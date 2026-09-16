<?php
namespace Rashtrotthana\Registration\Submissions;

use Rashtrotthana\Registration\Forms\Form_Manager;
use Rashtrotthana\Registration\Validation\Validator;

class Registration_Manager {

    /**
     * Handle a new registration submission
     */
    public static function submit( $form_id, $activity_id, $event_id, $answers, $language = 'en', $source = 'web' ) {
        global $wpdb;

        // 1. Validate Form Exists
        $form = Form_Manager::get_form( $form_id );
        if ( ! $form ) {
            return new \WP_Error( 'invalid_form', __( 'The requested registration form does not exist or is inactive.', 'rashtrotthana-registration' ), [ 'status' => 400 ] );
        }

        // 2. Validate Activity/Event if provided
        $requires_registration = false;
        $capacity = 0;
        $is_waitlist_enabled = true; // Default behavior if not explicitly disabled in spec
        $target_id = $event_id ? $event_id : $activity_id;

        if ( $target_id ) {
            $post = get_post( $target_id );
            if ( ! $post || ! in_array( $post->post_type, [ 'activity', 'event' ] ) || $post->post_status !== 'publish' ) {
                return new \WP_Error( 'invalid_target', __( 'The specified activity or event is invalid.', 'rashtrotthana-registration' ), [ 'status' => 400 ] );
            }

            $requires_registration = get_post_meta( $target_id, '_ry_requires_registration', true );
            if ( ! $requires_registration ) {
                return new \WP_Error( 'registration_disabled', __( 'Registration is not enabled for this activity.', 'rashtrotthana-registration' ), [ 'status' => 403 ] );
            }

            // Check if Registration Window is active (for Events)
            if ( $post->post_type === 'event' ) {
                $reg_start = get_post_meta( $target_id, '_ry_registration_start', true );
                $reg_end = get_post_meta( $target_id, '_ry_registration_end', true );
                $now = current_time( 'mysql' );

                if ( $reg_start && $now < $reg_start ) {
                    return new \WP_Error( 'registration_closed', __( 'Registration has not opened yet.', 'rashtrotthana-registration' ), [ 'status' => 403 ] );
                }
                if ( $reg_end && $now > $reg_end ) {
                    return new \WP_Error( 'registration_closed', __( 'Registration has closed.', 'rashtrotthana-registration' ), [ 'status' => 403 ] );
                }

                $capacity = (int) get_post_meta( $target_id, '_ry_maximum_participants', true );
            }
        }

        // 3. Validate Answers
        $validation = Validator::validate_answers( $form['fields'], $answers );
        if ( ! $validation['is_valid'] ) {
            return new \WP_Error( 'invalid_fields', __( 'Please correct the highlighted fields.', 'rashtrotthana-registration' ), [ 'status' => 400, 'errors' => $validation['errors'] ] );
        }

        $sanitized_answers = $validation['answers'];
        
        // Extract common fields for indexing (assuming conventional keys: 'name', 'email', 'phone')
        $name = isset( $sanitized_answers['name'] ) ? $sanitized_answers['name'] : ( isset( $sanitized_answers['full_name'] ) ? $sanitized_answers['full_name'] : 'Unknown' );
        $email = isset( $sanitized_answers['email'] ) ? $sanitized_answers['email'] : '';
        $phone = isset( $sanitized_answers['phone'] ) ? $sanitized_answers['phone'] : ( isset( $sanitized_answers['mobile'] ) ? $sanitized_answers['mobile'] : '' );

        // 4. Duplicate Check
        $duplicate = $wpdb->get_var( $wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}ry_registrations 
             WHERE email = %s AND phone = %s AND (activity_id = %d OR event_id = %d) AND status IN ('pending', 'confirmed', 'waitlisted')",
            $email, $phone, $activity_id, $event_id
        ) );

        if ( $duplicate ) {
            return new \WP_Error( 'duplicate_registration', __( 'You are already registered for this activity.', 'rashtrotthana-registration' ), [ 'status' => 409 ] );
        }

        // 5. Begin Transaction for Concurrency/Capacity Check
        $wpdb->query( "START TRANSACTION" );

        $status = 'confirmed'; // Default to confirmed unless capacity is full

        if ( $capacity > 0 && $target_id ) {
            // Lock rows for the count to prevent race conditions
            // Note: Since we are counting, we lock the target post in wp_posts to serialize requests for this event
            $wpdb->query( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE ID = %d FOR UPDATE", $target_id ) );

            $confirmed_count = (int) $wpdb->get_var( $wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}ry_registrations WHERE (activity_id = %d OR event_id = %d) AND status = 'confirmed'",
                $target_id, $target_id
            ) );

            if ( $confirmed_count >= $capacity ) {
                if ( $is_waitlist_enabled ) {
                    $status = 'waitlisted';
                } else {
                    $wpdb->query( "ROLLBACK" );
                    return new \WP_Error( 'capacity_full', __( 'This activity has reached maximum capacity.', 'rashtrotthana-registration' ), [ 'status' => 403 ] );
                }
            }
        }

        // 6. Insert Registration
        $uuid = wp_generate_uuid4();
        
        $inserted = $wpdb->insert(
            $wpdb->prefix . 'ry_registrations',
            [
                'registration_uuid' => $uuid,
                'form_id'           => $form_id,
                'activity_id'       => $activity_id ?: null,
                'event_id'          => $event_id ?: null,
                'name'              => $name,
                'email'             => $email,
                'phone'             => $phone,
                'status'            => $status,
                'language'          => $language,
                'source'            => $source,
                'submitted_at'      => current_time( 'mysql' ),
                'confirmed_at'      => $status === 'confirmed' ? current_time( 'mysql' ) : null,
            ],
            [ '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ]
        );

        if ( ! $inserted ) {
            $wpdb->query( "ROLLBACK" );
            return new \WP_Error( 'db_error', __( 'Failed to save registration. Please try again.', 'rashtrotthana-registration' ), [ 'status' => 500 ] );
        }

        $registration_id = $wpdb->insert_id;

        // 7. Insert Answers
        foreach ( $sanitized_answers as $key => $val ) {
            $wpdb->insert(
                $wpdb->prefix . 'ry_registration_answers',
                [
                    'registration_id' => $registration_id,
                    'field_key'       => $key,
                    'field_value'     => is_array( $val ) ? wp_json_encode( $val ) : $val,
                    'created_at'      => current_time( 'mysql' ),
                ],
                [ '%d', '%s', '%s', '%s' ]
            );
        }

        $wpdb->query( "COMMIT" );

        // 8. Fire Action Hooks for Integrations (e.g., WATI)
        do_action( 'rashtrotthana_registration_created', $registration_id, $status, $uuid );
        
        if ( $status === 'confirmed' ) {
            do_action( 'rashtrotthana_registration_confirmed', $registration_id, $uuid );
        } elseif ( $status === 'waitlisted' ) {
            do_action( 'rashtrotthana_registration_waitlisted', $registration_id, $uuid );
        }

        return [
            'success'         => true,
            'registration_id' => $uuid, // Expose public UUID, not internal sequential ID
            'status'          => $status,
            'message'         => $status === 'confirmed' ? __( 'Registration confirmed successfully.', 'rashtrotthana-registration' ) : __( 'You have been added to the waitlist.', 'rashtrotthana-registration' )
        ];
    }

    /**
     * Update the status of an existing registration (Admin functionality)
     */
    public static function update_status( $registration_id, $new_status ) {
        global $wpdb;

        $valid_statuses = [ 'pending', 'confirmed', 'waitlisted', 'cancelled', 'rejected', 'completed' ];
        if ( ! in_array( $new_status, $valid_statuses ) ) {
            return new \WP_Error( 'invalid_status', 'Invalid status provided.' );
        }

        $registration = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ry_registrations WHERE id = %d", $registration_id ) );
        
        if ( ! $registration ) {
            return new \WP_Error( 'not_found', 'Registration not found.' );
        }

        if ( $registration->status === $new_status ) {
            return true; // No change
        }

        $data = [ 'status' => $new_status ];
        $format = [ '%s' ];

        if ( $new_status === 'confirmed' && ! $registration->confirmed_at ) {
            $data['confirmed_at'] = current_time( 'mysql' );
            $format[] = '%s';
        }
        if ( $new_status === 'cancelled' ) {
            $data['cancelled_at'] = current_time( 'mysql' );
            $format[] = '%s';
        }

        $updated = $wpdb->update(
            $wpdb->prefix . 'ry_registrations',
            $data,
            [ 'id' => $registration_id ],
            $format,
            [ '%d' ]
        );

        if ( $updated !== false ) {
            // Fire Hooks based on new status
            do_action( "rashtrotthana_registration_status_changed", $registration_id, $new_status, $registration->status );
            do_action( "rashtrotthana_registration_{$new_status}", $registration_id, $registration->registration_uuid );
            return true;
        }

        return false;
    }
}
