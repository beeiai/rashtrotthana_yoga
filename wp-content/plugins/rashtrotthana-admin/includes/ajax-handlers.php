<?php
/**
 * Rashtrotthana Admin Portal — AJAX Handlers
 *
 * All handlers are registered here and wired to admin-ajax.php.
 * Every action verifies the RADM nonce and manage_options capability.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// ── Helper: verify nonce + capability ────────────────────────────────────────
function radm_ajax_auth(): void {
    if ( ! check_ajax_referer( 'radm_nonce', 'nonce', false ) ) {
        wp_send_json_error( [ 'message' => 'Security check failed.' ], 403 );
    }
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Insufficient permissions.' ], 403 );
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 1. DASHBOARD STATS
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_get_dashboard_stats', 'radm_ajax_get_dashboard_stats' );
function radm_ajax_get_dashboard_stats(): void {
    radm_ajax_auth();
    global $wpdb;

    $table = $wpdb->prefix . 'ry_registrations';

    // Total registrations (all time, non-cancelled)
    $total = (int) $wpdb->get_var(
        "SELECT COUNT(*) FROM {$table} WHERE status NOT IN ('cancelled','rejected')"
    );

    // Active events (published CPT 'event')
    $active_events = (int) wp_count_posts( 'event' )->publish;

    // Registrations submitted today
    $today = current_time( 'Y-m-d' );
    $today_count = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE DATE(submitted_at) = %s AND status NOT IN ('cancelled','rejected')",
        $today
    ) );

    wp_send_json_success( [
        'total_registrations'  => $total,
        'active_events'        => $active_events,
        'registrations_today'  => $today_count,
    ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 2. GET EVENTS LIST
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_get_events', 'radm_ajax_get_events' );
function radm_ajax_get_events(): void {
    radm_ajax_auth();
    global $wpdb;

    $limit   = absint( $_POST['limit'] ?? 100 );
    $status  = sanitize_text_field( $_POST['event_status'] ?? 'any' );

    $args = [
        'post_type'      => 'event',
        'post_status'    => 'publish',
        'numberposts'    => $limit,
        'orderby'        => 'meta_value',
        'meta_key'       => '_ry_event_date',
        'order'          => 'ASC',
    ];

    $posts = get_posts( $args );
    $table = $wpdb->prefix . 'ry_registrations';

    $events = [];
    foreach ( $posts as $i => $post ) {
        $event_date    = get_post_meta( $post->ID, '_ry_event_date', true );
        $start_time    = get_post_meta( $post->ID, '_ry_start_time', true );
        $end_time      = get_post_meta( $post->ID, '_ry_end_time', true );
        $reg_open      = get_post_meta( $post->ID, '_ry_registration_open', true );
        $reg_last_date = get_post_meta( $post->ID, '_ry_reg_last_date', true );
        $centers       = get_post_meta( $post->ID, '_ry_event_centers', true );

        // Count real registrations for this event
        $reg_count       = (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE event_id = %d AND status NOT IN ('cancelled','rejected')",
            $post->ID
        ) );

        // Determine open/closed status
        $now     = current_time( 'Y-m-d' );
        $is_open = $reg_open && ( ! $reg_last_date || $now <= $reg_last_date );

        $events[] = [
            'id'              => $post->ID,
            'num'             => $i + 1,
            'name'            => $post->post_title,
            'date'            => $event_date ? date( 'd M Y', strtotime( $event_date ) ) : '—',
            'date_raw'        => $event_date,
            'start_time'    => $start_time,
            'end_time'      => $end_time,
            'reg_last_date' => $reg_last_date,
            'registration_open' => (bool) $is_open,
            'centers'       => is_array( $centers ) ? $centers : [],
            'reg_count'     => $reg_count,
            'status'        => $is_open ? 'open' : 'closed',
        ];
    }

    wp_send_json_success( [ 'events' => $events ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 11. GET CENTRES LIST
// ─────────────────────────────────────────────────────────────────────────────
// ─────────────────────────────────────────────────────────────────────────────

// ─────────────────────────────────────────────────────────────────────────────
// 3. CREATE EVENT
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_create_event', 'radm_ajax_create_event' );
function radm_ajax_create_event(): void {
    radm_ajax_auth();

    $name             = sanitize_text_field( $_POST['event_name'] ?? '' );
    $description      = sanitize_textarea_field( $_POST['event_description'] ?? '' );
    $event_date       = sanitize_text_field( $_POST['event_date'] ?? '' );
    $start_time       = sanitize_text_field( $_POST['start_time'] ?? '' );
    $end_time         = sanitize_text_field( $_POST['end_time'] ?? '' );
    $reg_last_date    = sanitize_text_field( $_POST['reg_last_date'] ?? '' );
    $reg_open         = ! empty( $_POST['registration_open'] ) ? 1 : 0;
    $google_form_url  = esc_url_raw( $_POST['google_form_url'] ?? '' );
    $use_google_form  = ! empty( $_POST['use_google_form'] ) ? 1 : 0;
    $centers          = isset( $_POST['centers'] ) && is_array( $_POST['centers'] )
                            ? array_map( 'sanitize_text_field', $_POST['centers'] )
                            : [];

    if ( ! $name || ! $event_date ) {
        wp_send_json_error( [ 'message' => 'Event name and date are required.' ], 400 );
    }

    $post_id = wp_insert_post( [
        'post_title'   => $name,
        'post_content' => $description,
        'post_type'    => 'event',
        'post_status'  => 'publish',
        'post_author'  => get_current_user_id(),
    ], true );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( [ 'message' => $post_id->get_error_message() ], 500 );
    }

    update_post_meta( $post_id, '_ry_event_date',       $event_date );
    update_post_meta( $post_id, '_ry_start_time',       $start_time );
    update_post_meta( $post_id, '_ry_end_time',         $end_time );
    update_post_meta( $post_id, '_ry_reg_last_date',    $reg_last_date );
    update_post_meta( $post_id, '_ry_registration_open', $reg_open );
    update_post_meta( $post_id, '_ry_event_centers',       $centers );
    // Mark this event as requiring registration (used by Registration_Manager)
    update_post_meta( $post_id, '_ry_requires_registration', 1 );

    // Handle image upload
    if ( ! empty( $_FILES['event_image']['name'] ) ) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        $attach_id = media_handle_upload( 'event_image', $post_id );
        if ( ! is_wp_error( $attach_id ) ) {
            set_post_thumbnail( $post_id, $attach_id );
        }
    }

    wp_send_json_success( [
        'message'  => 'Event created successfully.',
        'event_id' => $post_id,
    ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. UPDATE EVENT
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_update_event', 'radm_ajax_update_event' );
function radm_ajax_update_event(): void {
    radm_ajax_auth();

    $post_id    = absint( $_POST['event_id'] ?? 0 );
    $name       = sanitize_text_field( $_POST['event_name'] ?? '' );
    $event_date = sanitize_text_field( $_POST['event_date'] ?? '' );
    $reg_open   = ! empty( $_POST['registration_open'] ) ? 1 : 0;

    if ( ! $post_id || ! $name ) {
        wp_send_json_error( [ 'message' => 'Event ID and name are required.' ], 400 );
    }

    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'event' ) {
        wp_send_json_error( [ 'message' => 'Event not found.' ], 404 );
    }

    wp_update_post( [
        'ID'           => $post_id,
        'post_title'   => $name,
    ] );

    if ( $event_date ) {
        update_post_meta( $post_id, '_ry_event_date', $event_date );
    }
    update_post_meta( $post_id, '_ry_registration_open', $reg_open );

    // Optionally update other meta if passed
    if ( isset( $_POST['start_time'] ) ) {
        update_post_meta( $post_id, '_ry_start_time', sanitize_text_field( $_POST['start_time'] ) );
    }
    if ( isset( $_POST['end_time'] ) ) {
        update_post_meta( $post_id, '_ry_end_time', sanitize_text_field( $_POST['end_time'] ) );
    }
    if ( isset( $_POST['reg_last_date'] ) ) {
        update_post_meta( $post_id, '_ry_reg_last_date', sanitize_text_field( $_POST['reg_last_date'] ) );
    }

    // Re-derive status for the response
    $reg_last_date = get_post_meta( $post_id, '_ry_reg_last_date', true );
    $now           = current_time( 'Y-m-d' );
    $is_open       = $reg_open && ( ! $reg_last_date || $now <= $reg_last_date );

    wp_send_json_success( [
        'message'    => 'Event updated.',
        'event_id'   => $post_id,
        'new_name'   => $name,
        'new_date'   => $event_date ? date( 'd M Y', strtotime( $event_date ) ) : '',
        'new_status' => $is_open ? 'open' : 'closed',
    ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 5. DELETE EVENT
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_delete_event', 'radm_ajax_delete_event' );
function radm_ajax_delete_event(): void {
    radm_ajax_auth();

    $post_id = absint( $_POST['event_id'] ?? 0 );
    if ( ! $post_id ) {
        wp_send_json_error( [ 'message' => 'Missing event ID.' ], 400 );
    }

    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'event' ) {
        wp_send_json_error( [ 'message' => 'Event not found.' ], 404 );
    }

    // Trash the post (recoverable). Use wp_delete_post($id, true) for permanent.
    wp_trash_post( $post_id );

    wp_send_json_success( [ 'message' => 'Event deleted.' ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. GET PARTICIPANTS FOR AN EVENT
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_get_participants', 'radm_ajax_get_participants' );
function radm_ajax_get_participants(): void {
    radm_ajax_auth();
    global $wpdb;

    $event_id = absint( $_POST['event_id'] ?? 0 );
    if ( ! $event_id ) {
        wp_send_json_error( [ 'message' => 'Missing event ID.' ], 400 );
    }

    $table = $wpdb->prefix . 'ry_registrations';
    $rows  = $wpdb->get_results( $wpdb->prepare(
        "SELECT id, name, phone, email, status, submitted_at
         FROM {$table}
         WHERE event_id = %d
         ORDER BY submitted_at ASC",
        $event_id
    ), ARRAY_A );

    // Resolve branch from registration answers if available
    $answers_table = $wpdb->prefix . 'ry_registration_answers';
    foreach ( $rows as &$row ) {
        $branch = $wpdb->get_var( $wpdb->prepare(
            "SELECT field_value FROM {$answers_table}
             WHERE registration_id = %d AND field_key IN ('branch','center','location')
             LIMIT 1",
            $row['id']
        ) );
        $row['branch'] = $branch ?: '—';
    }
    unset( $row );

    wp_send_json_success( [ 'participants' => $rows ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 7. ADD PARTICIPANT
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_add_participant', 'radm_ajax_add_participant' );
function radm_ajax_add_participant(): void {
    radm_ajax_auth();
    global $wpdb;

    $event_id = absint( $_POST['event_id'] ?? 0 );
    $name     = sanitize_text_field( $_POST['name'] ?? '' );
    $phone    = sanitize_text_field( $_POST['phone'] ?? '' );
    $email    = sanitize_email( $_POST['email'] ?? '' );
    $branch   = sanitize_text_field( $_POST['branch'] ?? '' );

    if ( ! $event_id || ! $name || ! $phone ) {
        wp_send_json_error( [ 'message' => 'Event ID, name and phone are required.' ], 400 );
    }

    $table  = $wpdb->prefix . 'ry_registrations';
    $uuid   = wp_generate_uuid4();

    $inserted = $wpdb->insert( $table, [
        'registration_uuid' => $uuid,
        'form_id'           => 0,
        'event_id'          => $event_id,
        'name'              => $name,
        'email'             => $email,
        'phone'             => $phone,
        'status'            => 'confirmed',
        'language'          => 'en',
        'source'            => 'admin',
        'submitted_at'      => current_time( 'mysql' ),
        'confirmed_at'      => current_time( 'mysql' ),
    ], [ '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ] );

    if ( ! $inserted ) {
        wp_send_json_error( [ 'message' => 'Database error. Could not add participant.' ], 500 );
    }

    $reg_id = $wpdb->insert_id;

    // Save branch as an answer
    if ( $branch ) {
        $wpdb->insert( $wpdb->prefix . 'ry_registration_answers', [
            'registration_id' => $reg_id,
            'field_key'       => 'branch',
            'field_value'     => $branch,
            'created_at'      => current_time( 'mysql' ),
        ], [ '%d', '%s', '%s', '%s' ] );
    }

    wp_send_json_success( [
        'message' => 'Participant added.',
        'id'      => $reg_id,
    ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 8. UPDATE PARTICIPANT
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_update_participant', 'radm_ajax_update_participant' );
function radm_ajax_update_participant(): void {
    radm_ajax_auth();
    global $wpdb;

    $reg_id = absint( $_POST['reg_id'] ?? 0 );
    $name   = sanitize_text_field( $_POST['name'] ?? '' );
    $phone  = sanitize_text_field( $_POST['phone'] ?? '' );
    $email  = sanitize_email( $_POST['email'] ?? '' );
    $branch = sanitize_text_field( $_POST['branch'] ?? '' );

    if ( ! $reg_id || ! $name || ! $phone ) {
        wp_send_json_error( [ 'message' => 'Registration ID, name and phone are required.' ], 400 );
    }

    $table = $wpdb->prefix . 'ry_registrations';
    $exists = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$table} WHERE id = %d", $reg_id ) );
    if ( ! $exists ) {
        wp_send_json_error( [ 'message' => 'Participant not found.' ], 404 );
    }

    $wpdb->update( $table,
        [ 'name' => $name, 'phone' => $phone, 'email' => $email ],
        [ 'id'   => $reg_id ],
        [ '%s', '%s', '%s' ],
        [ '%d' ]
    );

    // Update or insert branch answer
    $answers_table = $wpdb->prefix . 'ry_registration_answers';
    $existing = $wpdb->get_var( $wpdb->prepare(
        "SELECT id FROM {$answers_table} WHERE registration_id = %d AND field_key = 'branch'",
        $reg_id
    ) );
    if ( $existing ) {
        $wpdb->update( $answers_table, [ 'field_value' => $branch ], [ 'id' => $existing ], [ '%s' ], [ '%d' ] );
    } else {
        $wpdb->insert( $answers_table, [
            'registration_id' => $reg_id,
            'field_key'       => 'branch',
            'field_value'     => $branch,
            'created_at'      => current_time( 'mysql' ),
        ], [ '%d', '%s', '%s', '%s' ] );
    }

    wp_send_json_success( [ 'message' => 'Participant updated.' ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 9. DELETE PARTICIPANT
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_delete_participant', 'radm_ajax_delete_participant' );
function radm_ajax_delete_participant(): void {
    radm_ajax_auth();
    global $wpdb;

    $reg_id = absint( $_POST['reg_id'] ?? 0 );
    if ( ! $reg_id ) {
        wp_send_json_error( [ 'message' => 'Missing registration ID.' ], 400 );
    }

    $table = $wpdb->prefix . 'ry_registrations';

    // Soft-delete: set status to 'cancelled'
    $updated = $wpdb->update(
        $table,
        [ 'status' => 'cancelled', 'cancelled_at' => current_time( 'mysql' ) ],
        [ 'id' => $reg_id ],
        [ '%s', '%s' ],
        [ '%d' ]
    );

    if ( $updated === false ) {
        wp_send_json_error( [ 'message' => 'Database error. Could not delete participant.' ], 500 );
    }

    wp_send_json_success( [ 'message' => 'Participant removed.' ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 10. EXPORT CSV
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_export_csv', 'radm_ajax_export_csv' );
function radm_ajax_export_csv(): void {
    if ( ! check_ajax_referer( 'radm_nonce', 'nonce', false ) ) { wp_die( 'Security check failed.', 403 ); }
    if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'Insufficient permissions.', 403 ); }

    global $wpdb;

    $event_id = absint( $_GET['event_id'] ?? 0 );
    $table    = $wpdb->prefix . 'ry_registrations';
    $at       = $wpdb->prefix . 'ry_registration_answers';

    if ( $event_id ) {
        $rows = $wpdb->get_results( $wpdb->prepare(
            "SELECT r.id, r.name, r.phone, r.email, r.status, r.submitted_at,
                    MAX(CASE WHEN a.field_key = 'branch' THEN a.field_value END) AS branch
             FROM {$table} r
             LEFT JOIN {$at} a ON a.registration_id = r.id
             WHERE r.event_id = %d AND r.status NOT IN ('cancelled','rejected')
             GROUP BY r.id
             ORDER BY r.submitted_at ASC",
            $event_id
        ), ARRAY_A );
        $filename = 'event-' . $event_id . '-participants.csv';
    } else {
        $rows = $wpdb->get_results(
            "SELECT r.id, r.name, r.phone, r.email, r.status, r.submitted_at,
                    r.event_id,
                    MAX(CASE WHEN a.field_key = 'branch' THEN a.field_value END) AS branch
             FROM {$table} r
             LEFT JOIN {$at} a ON a.registration_id = r.id
             WHERE r.status NOT IN ('cancelled','rejected')
             GROUP BY r.id
             ORDER BY r.submitted_at DESC
             LIMIT 5000",
            ARRAY_A
        );
        $filename = 'all-registrations.csv';
    }

    // Output CSV
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
    header( 'Pragma: no-cache' );
    header( 'Expires: 0' );

    $out = fopen( 'php://output', 'w' );

    // BOM for Excel UTF-8 compatibility
    fputs( $out, "\xEF\xBB\xBF" );

    if ( $event_id ) {
        fputcsv( $out, [ '#', 'Name', 'Phone', 'Email', 'Branch', 'Status', 'Registered At' ] );
        foreach ( $rows as $i => $row ) {
            fputcsv( $out, [
                $i + 1,
                $row['name'],
                $row['phone'],
                $row['email'],
                $row['branch'] ?? '—',
                $row['status'],
                $row['submitted_at'],
            ] );
        }
    } else {
        fputcsv( $out, [ '#', 'Name', 'Phone', 'Email', 'Branch', 'Event ID', 'Status', 'Registered At' ] );
        foreach ( $rows as $i => $row ) {
            fputcsv( $out, [
                $i + 1,
                $row['name'],
                $row['phone'],
                $row['email'],
                $row['branch'] ?? '—',
                $row['event_id'] ?? '—',
                $row['status'],
                $row['submitted_at'],
            ] );
        }
    }

    fclose( $out );
    exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// 10. FORM GROUPS (CRUD)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_ajax_radm_get_form_groups', 'radm_ajax_get_form_groups' );
function radm_ajax_get_form_groups(): void {
    radm_ajax_auth();
    $groups = get_option( 'radm_form_groups', [] );
    wp_send_json_success( [ 'groups' => array_values( (array) $groups ) ] );
}

add_action( 'wp_ajax_radm_save_form_group', 'radm_ajax_save_form_group' );
function radm_ajax_save_form_group(): void {
    radm_ajax_auth();

    $group_id    = sanitize_key( $_POST['group_id'] ?? '' );
    $title       = sanitize_text_field( $_POST['title'] ?? '' );
    $description = sanitize_textarea_field( $_POST['description'] ?? '' );
    $raw_slug    = sanitize_title( $_POST['slug'] ?? '' );
    $slug        = $raw_slug ?: sanitize_title( $title );
    $action_mode = in_array( $_POST['action_mode'] ?? 'redirect', [ 'redirect', 'embed' ], true )
                    ? sanitize_key( $_POST['action_mode'] )
                    : 'redirect';
    $ui_layout   = in_array( $_POST['ui_layout'] ?? 'cards', [ 'cards', 'dropdown' ], true )
                    ? sanitize_key( $_POST['ui_layout'] )
                    : 'cards';
    $raw_centres = isset( $_POST['centres'] ) && is_array( $_POST['centres'] ) ? $_POST['centres'] : [];

    if ( ! $title ) {
        wp_send_json_error( [ 'message' => 'Form Group title is required.' ], 400 );
    }

    $centres = [];
    foreach ( $raw_centres as $c ) {
        $c_name = sanitize_text_field( $c['name'] ?? '' );
        $c_loc  = sanitize_text_field( $c['location'] ?? '' );
        $c_url  = esc_url_raw( $c['url'] ?? '' );
        if ( ! $c_name ) continue;

        $c_id = sanitize_key( $c['id'] ?? '' );
        if ( ! $c_id ) {
            $c_id = 'c_' . wp_generate_password( 6, false, false );
        }

        $centres[] = [
            'id'       => $c_id,
            'name'     => $c_name,
            'location' => $c_loc,
            'url'      => $c_url,
        ];
    }

    $groups = get_option( 'radm_form_groups', [] );
    if ( ! is_array( $groups ) ) $groups = [];

    if ( ! $group_id ) {
        $group_id = 'group_' . wp_generate_password( 8, false, false );
    }

    $existing_analytics = $groups[ $group_id ]['analytics'] ?? [];

    $groups[ $group_id ] = [
        'id'          => $group_id,
        'slug'        => $slug,
        'title'       => $title,
        'description' => $description,
        'action_mode' => $action_mode,
        'ui_layout'   => $ui_layout,
        'centres'     => $centres,
        'analytics'   => $existing_analytics,
        'updated_at'  => current_time( 'mysql' ),
    ];

    update_option( 'radm_form_groups', $groups );

    wp_send_json_success( [
        'message'   => 'Form Group saved successfully.',
        'group_id'  => $group_id,
        'slug'      => $slug,
        'shortcode' => '[ry_form_group slug="' . $slug . '"]',
    ] );
}

add_action( 'wp_ajax_radm_delete_form_group', 'radm_ajax_delete_form_group' );
function radm_ajax_delete_form_group(): void {
    radm_ajax_auth();

    $group_id = sanitize_key( $_POST['group_id'] ?? '' );
    if ( ! $group_id ) {
        wp_send_json_error( [ 'message' => 'Missing Group ID.' ], 400 );
    }

    $groups = get_option( 'radm_form_groups', [] );
    if ( is_array( $groups ) && isset( $groups[ $group_id ] ) ) {
        unset( $groups[ $group_id ] );
        update_option( 'radm_form_groups', $groups );
    }

    wp_send_json_success( [ 'message' => 'Form Group deleted.' ] );
}

// ── Public Analytics Click Tracking Handler ──────────────────────────────────
add_action( 'wp_ajax_radm_track_form_group_click',        'radm_ajax_track_form_group_click' );
add_action( 'wp_ajax_nopriv_radm_track_form_group_click', 'radm_ajax_track_form_group_click' );
function radm_ajax_track_form_group_click(): void {
    $group_id  = sanitize_key( $_POST['group_id'] ?? '' );
    $centre_id = sanitize_key( $_POST['centre_id'] ?? '' );

    if ( ! $group_id || ! $centre_id ) {
        wp_send_json_error( [ 'message' => 'Missing parameters.' ], 400 );
    }

    $groups = get_option( 'radm_form_groups', [] );
    if ( is_array( $groups ) && isset( $groups[ $group_id ] ) ) {
        if ( ! isset( $groups[ $group_id ]['analytics'] ) || ! is_array( $groups[ $group_id ]['analytics'] ) ) {
            $groups[ $group_id ]['analytics'] = [];
        }

        $current = (int) ( $groups[ $group_id ]['analytics'][ $centre_id ] ?? 0 );
        $groups[ $group_id ]['analytics'][ $centre_id ] = $current + 1;

        update_option( 'radm_form_groups', $groups );
        wp_send_json_success( [ 'clicks' => $current + 1 ] );
    }

    wp_send_json_error( [ 'message' => 'Group not found.' ], 444 );
}





