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
    if ( ! current_user_can( 'manage_options' ) && ! current_user_can( 'manage_ry_registrations' ) && ! current_user_can( 'upload_files' ) ) {
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
    
    // Save Google Form settings
    update_post_meta( $post_id, '_ry_use_google_form',   $use_google_form );
    update_post_meta( $post_id, '_ry_google_form_url',   $google_form_url );
    
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
    if ( isset( $_POST['use_google_form'] ) ) {
        update_post_meta( $post_id, '_ry_use_google_form', sanitize_text_field( $_POST['use_google_form'] ) ? 1 : 0 );
    }
    if ( isset( $_POST['google_form_url'] ) ) {
        update_post_meta( $post_id, '_ry_google_form_url', esc_url_raw( $_POST['google_form_url'] ) );
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

// ═════════════════════════════════════════════════════════════════════════════
// FORM GROUPS AJAX HANDLERS
// ═════════════════════════════════════════════════════════════════════════════

require_once __DIR__ . '/class-form-groups-db.php';

/**
 * 1. Get Form Groups List
 */
add_action( 'wp_ajax_radm_get_form_groups', 'radm_ajax_get_form_groups' );
function radm_ajax_get_form_groups(): void {
    radm_ajax_auth();

    $search   = sanitize_text_field( $_POST['search'] ?? '' );
    $status   = sanitize_key( $_POST['status'] ?? '' );
    $page     = max( 1, absint( $_POST['page'] ?? 1 ) );
    $per_page = max( 1, absint( $_POST['per_page'] ?? 10 ) );

    $result = RADM_Form_Groups_DB::get_all( [
        'search'   => $search,
        'status'   => $status,
        'page'     => $page,
        'per_page' => $per_page,
    ] );

    wp_send_json_success( $result );
}

/**
 * 2. Get Single Form Group
 */
add_action( 'wp_ajax_radm_get_form_group', 'radm_ajax_get_form_group' );
function radm_ajax_get_form_group(): void {
    radm_ajax_auth();

    $id = absint( $_POST['id'] ?? 0 );
    if ( ! $id ) {
        wp_send_json_error( [ 'message' => 'Invalid Form Group ID.' ], 400 );
    }

    $group = RADM_Form_Groups_DB::get( $id );
    if ( ! $group ) {
        wp_send_json_error( [ 'message' => 'Form Group not found.' ], 404 );
    }

    wp_send_json_success( $group );
}

/**
 * 3. Save Form Group (Create / Update)
 */
add_action( 'wp_ajax_radm_save_form_group', 'radm_ajax_save_form_group' );
function radm_ajax_save_form_group(): void {
    radm_ajax_auth();

    $id          = absint( $_POST['id'] ?? 0 );
    $name        = sanitize_text_field( $_POST['name'] ?? '' );
    $description = sanitize_textarea_field( $_POST['description'] ?? '' );
    $status      = sanitize_key( $_POST['status'] ?? 'active' );
    $raw_centers = isset( $_POST['centers'] ) ? $_POST['centers'] : [];

    // If sent as JSON string
    if ( is_string( $raw_centers ) ) {
        $decoded = json_decode( stripslashes( $raw_centers ), true );
        if ( is_array( $decoded ) ) {
            $raw_centers = $decoded;
        }
    }

    if ( empty( $name ) ) {
        wp_send_json_error( [ 'message' => 'Form Group Name is required.' ], 400 );
    }

    try {
        $group_id = RADM_Form_Groups_DB::save( [
            'id'          => $id,
            'name'        => $name,
            'description' => $description,
            'status'      => $status,
            'centers'     => is_array( $raw_centers ) ? $raw_centers : [],
        ] );

        $saved = RADM_Form_Groups_DB::get( $group_id );

        wp_send_json_success( [
            'message'  => $id > 0 ? 'Form Group updated successfully.' : 'Form Group created successfully.',
            'group_id' => $group_id,
            'group'    => $saved,
        ] );
    } catch ( \Exception $e ) {
        wp_send_json_error( [ 'message' => $e->getMessage() ], 500 );
    }
}

/**
 * 4. Delete Form Group
 */
add_action( 'wp_ajax_radm_delete_form_group', 'radm_ajax_delete_form_group' );
function radm_ajax_delete_form_group(): void {
    radm_ajax_auth();

    $id = absint( $_POST['id'] ?? 0 );
    if ( ! $id ) {
        wp_send_json_error( [ 'message' => 'Invalid Form Group ID.' ], 400 );
    }

    $deleted = RADM_Form_Groups_DB::delete( $id );
    if ( ! $deleted ) {
        wp_send_json_error( [ 'message' => 'Failed to delete Form Group.' ], 500 );
    }

    wp_send_json_success( [ 'message' => 'Form Group deleted successfully.' ] );
}

/**
 * 5. Toggle Status
 */
add_action( 'wp_ajax_radm_toggle_form_group_status', 'radm_ajax_toggle_form_group_status' );
function radm_ajax_toggle_form_group_status(): void {
    radm_ajax_auth();

    $id = absint( $_POST['id'] ?? 0 );
    if ( ! $id ) {
        wp_send_json_error( [ 'message' => 'Invalid Form Group ID.' ], 400 );
    }

    try {
        $new_status = RADM_Form_Groups_DB::toggle_status( $id );
        wp_send_json_success( [
            'id'         => $id,
            'new_status' => $new_status,
            'message'    => 'Status updated to ' . ucfirst( $new_status ),
        ] );
    } catch ( \Exception $e ) {
        wp_send_json_error( [ 'message' => $e->getMessage() ], 500 );
    }
}

/**
 * 6. Public Center Link Endpoint for Website Modal
 */
add_action( 'wp_ajax_ry_get_public_form_group',        'ry_ajax_get_public_form_group' );
add_action( 'wp_ajax_nopriv_ry_get_public_form_group', 'ry_ajax_get_public_form_group' );
function ry_ajax_get_public_form_group(): void {
    $id = absint( $_POST['id'] ?? $_GET['id'] ?? 0 );
    if ( ! $id ) {
        wp_send_json_error( [ 'message' => 'Invalid Form Group ID.' ], 400 );
    }

    $group = RADM_Form_Groups_DB::get( $id );
    if ( ! $group || $group['status'] !== 'active' ) {
        wp_send_json_error( [ 'message' => 'This registration form is currently unavailable or inactive.' ], 404 );
    }

    if ( empty( $group['centers'] ) ) {
        wp_send_json_error( [ 'message' => 'No active center forms configured for this program.' ], 404 );
    }

    wp_send_json_success( [
        'id'          => $group['id'],
        'name'        => $group['name'],
        'description' => $group['description'],
        'centers'     => $group['centers'],
    ] );
}

/**
 * 1. GET GALLERY ITEMS LIST (with filters, search, pagination, tabs)
 */
add_action( 'wp_ajax_radm_get_gallery_items', 'radm_ajax_get_gallery_items' );
function radm_ajax_get_gallery_items(): void {
    radm_ajax_auth();

    $type      = sanitize_key( $_POST['type'] ?? 'all' );
    $category  = sanitize_text_field( $_POST['category'] ?? '' );
    $event_id  = absint( $_POST['event_id'] ?? 0 );
    $status    = sanitize_key( $_POST['status'] ?? '' );
    $search    = sanitize_text_field( $_POST['search'] ?? '' );
    $sort      = sanitize_key( $_POST['sort'] ?? 'latest' );
    $page      = max( 1, absint( $_POST['page'] ?? 1 ) );
    $per_page  = max( 1, absint( $_POST['per_page'] ?? 8 ) );

    $meta_query = [];
    if ( in_array( $type, [ 'image', 'video' ], true ) ) {
        $meta_query[] = [
            'key'     => '_ry_gallery_type',
            'value'   => $type,
            'compare' => '=',
        ];
    }
    if ( ! empty( $category ) ) {
        $meta_query[] = [
            'key'     => '_ry_gallery_category',
            'value'   => $category,
            'compare' => '=',
        ];
    }
    if ( $event_id > 0 ) {
        $meta_query[] = [
            'key'     => '_ry_gallery_event_id',
            'value'   => $event_id,
            'compare' => '=',
        ];
    }

    $post_status = [ 'publish', 'draft' ];
    if ( $status === 'publish' ) {
        $post_status = [ 'publish' ];
    } elseif ( $status === 'draft' ) {
        $post_status = [ 'draft' ];
    }

    $query_args = [
        'post_type'      => 'ry_gallery',
        'post_status'    => $post_status,
        'posts_per_page' => -1, // Fetch all to filter & count accurately
        's'              => $search,
    ];

    if ( ! empty( $meta_query ) ) {
        $query_args['meta_query'] = $meta_query;
    }

    if ( $sort === 'oldest' ) {
        $query_args['orderby'] = 'meta_value';
        $query_args['meta_key'] = '_ry_gallery_date';
        $query_args['order']   = 'ASC';
    } elseif ( $sort === 'title_asc' ) {
        $query_args['orderby'] = 'title';
        $query_args['order']   = 'ASC';
    } elseif ( $sort === 'title_desc' ) {
        $query_args['orderby'] = 'title';
        $query_args['order']   = 'DESC';
    } else {
        $query_args['orderby'] = 'meta_value';
        $query_args['meta_key'] = '_ry_gallery_date';
        $query_args['order']   = 'DESC';
    }

    $all_posts = get_posts( $query_args );

    // Count totals across all types for tab numbers
    $total_all   = 0;
    $total_image = 0;
    $total_video = 0;

    $base_posts = get_posts( [
        'post_type'      => 'ry_gallery',
        'post_status'    => [ 'publish', 'draft' ],
        'posts_per_page' => -1,
    ] );
    foreach ( $base_posts as $bp ) {
        $t = get_post_meta( $bp->ID, '_ry_gallery_type', true ) ?: 'image';
        $total_all++;
        if ( $t === 'video' ) {
            $total_video++;
        } else {
            $total_image++;
        }
    }

    $total_filtered = count( $all_posts );
    $offset         = ( $page - 1 ) * $per_page;
    $paged_posts    = array_slice( $all_posts, $offset, $per_page );

    $items = [];
    foreach ( $paged_posts as $post ) {
        $g_type     = get_post_meta( $post->ID, '_ry_gallery_type', true ) ?: 'image';
        $image_url  = get_post_meta( $post->ID, '_ry_gallery_image_url', true ) ?: '';
        $video_url  = get_post_meta( $post->ID, '_ry_gallery_video_url', true ) ?: '';
        $duration   = get_post_meta( $post->ID, '_ry_gallery_video_duration', true ) ?: '';
        $g_cat      = get_post_meta( $post->ID, '_ry_gallery_category', true ) ?: 'General';
        $g_event_id = (int) get_post_meta( $post->ID, '_ry_gallery_event_id', true );
        $g_date_raw = get_post_meta( $post->ID, '_ry_gallery_date', true ) ?: get_the_date( 'Y-m-d', $post->ID );
        $g_date_fmt = $g_date_raw ? date( 'd M Y', strtotime( $g_date_raw ) ) : date( 'd M Y', strtotime( $post->post_date ) );

        $event_name = '';
        if ( $g_event_id > 0 ) {
            $ev_post = get_post( $g_event_id );
            if ( $ev_post ) {
                $event_name = $ev_post->post_title;
            }
        }

        // Subtitle tag
        $sub_tag = '';
        if ( ! empty( $event_name ) ) {
            $sub_tag = 'Event: ' . $event_name;
        } elseif ( ! empty( $g_cat ) ) {
            $sub_tag = 'Category: ' . $g_cat;
        }

        // Auto fallback image
        if ( empty( $image_url ) ) {
            if ( has_post_thumbnail( $post->ID ) ) {
                $image_url = get_the_post_thumbnail_url( $post->ID, 'large' );
            } else {
                $image_url = 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=900&q=80';
            }
        }

        $items[] = [
            'id'             => $post->ID,
            'title'          => $post->post_title,
            'description'    => $post->post_content,
            'type'           => $g_type,
            'image_url'      => $image_url,
            'video_url'      => $video_url,
            'video_duration' => $duration,
            'category'       => $g_cat,
            'event_id'       => $g_event_id,
            'event_name'     => $event_name,
            'sub_tag'        => $sub_tag,
            'date_raw'       => $g_date_raw,
            'date_fmt'       => $g_date_fmt,
            'status'         => $post->post_status, // 'publish' or 'draft'
            'is_published'   => $post->post_status === 'publish',
        ];
    }

    wp_send_json_success( [
        'items'          => $items,
        'total'          => $total_filtered,
        'page'           => $page,
        'per_page'       => $per_page,
        'total_pages'    => ceil( $total_filtered / $per_page ),
        'counts'         => [
            'all'   => $total_all,
            'image' => $total_image,
            'video' => $total_video,
        ],
    ] );
}

/**
 * 2. SAVE (CREATE / UPDATE) GALLERY ITEM
 */
add_action( 'wp_ajax_radm_save_gallery_item', 'radm_ajax_save_gallery_item' );
function radm_ajax_save_gallery_item(): void {
    radm_ajax_auth();

    $media_id   = absint( $_POST['media_id'] ?? 0 );
    $title      = sanitize_text_field( $_POST['title'] ?? '' );
    $media_type = sanitize_key( $_POST['media_type'] ?? 'image' );
    $image_url  = esc_url_raw( $_POST['image_url'] ?? '' );
    $video_url  = esc_url_raw( $_POST['video_url'] ?? '' );
    $video_dur  = sanitize_text_field( $_POST['video_duration'] ?? '' );
    $video_post = esc_url_raw( $_POST['video_poster'] ?? '' );
    $category   = sanitize_text_field( $_POST['category'] ?? 'General' );
    $event_id   = absint( $_POST['event_id'] ?? 0 );
    $media_date = sanitize_text_field( $_POST['media_date'] ?? current_time( 'Y-m-d' ) );
    $status     = sanitize_key( $_POST['status'] ?? 'publish' );
    $desc       = sanitize_textarea_field( $_POST['description'] ?? '' );

    if ( ! in_array( $status, [ 'publish', 'draft' ], true ) ) {
        $status = 'publish';
    }

    if ( empty( $title ) ) {
        wp_send_json_error( [ 'message' => 'Media title is required.' ], 400 );
    }

    $uploaded_attachment_id = 0;
    // Handle Direct File Upload if present
    if ( ! empty( $_FILES['image_file'] ) && ! empty( $_FILES['image_file']['name'] ) ) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $attachment_id = media_handle_upload( 'image_file', 0 );
        if ( is_wp_error( $attachment_id ) ) {
            wp_send_json_error( [ 'message' => 'Upload failed: ' . $attachment_id->get_error_message() ], 400 );
        }
        $image_url              = wp_get_attachment_url( $attachment_id );
        $uploaded_attachment_id = $attachment_id;
    }

    // Auto-detect YouTube thumbnail if video thumbnail is blank
    if ( $media_type === 'video' ) {
        if ( ! empty( $video_post ) ) {
            $image_url = $video_post;
        } elseif ( empty( $image_url ) && ! empty( $video_url ) ) {
            if ( preg_match( '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_url, $m ) ) {
                $image_url = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
            }
        }
    }

    // Default fallback image if still empty
    if ( empty( $image_url ) ) {
        $image_url = 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=900&q=80';
    }

    $post_data = [
        'post_title'   => $title,
        'post_content' => $desc,
        'post_type'    => 'ry_gallery',
        'post_status'  => $status,
    ];

    if ( $media_id > 0 ) {
        $post_data['ID'] = $media_id;
        $updated_id = wp_update_post( $post_data, true );
        if ( is_wp_error( $updated_id ) ) {
            wp_send_json_error( [ 'message' => $updated_id->get_error_message() ], 500 );
        }
        $post_id = $media_id;
    } else {
        $post_data['post_author'] = get_current_user_id();
        $post_id = wp_insert_post( $post_data, true );
        if ( is_wp_error( $post_id ) ) {
            wp_send_json_error( [ 'message' => $post_id->get_error_message() ], 500 );
        }
    }

    // Update Post Meta
    update_post_meta( $post_id, '_ry_gallery_type', $media_type );
    update_post_meta( $post_id, '_ry_gallery_image_url', $image_url );
    update_post_meta( $post_id, '_ry_gallery_video_url', $video_url );
    update_post_meta( $post_id, '_ry_gallery_video_duration', $video_dur );
    update_post_meta( $post_id, '_ry_gallery_category', $category );
    update_post_meta( $post_id, '_ry_gallery_event_id', $event_id );
    update_post_meta( $post_id, '_ry_gallery_date', $media_date );

    if ( $uploaded_attachment_id > 0 ) {
        set_post_thumbnail( $post_id, $uploaded_attachment_id );
        wp_update_post( [
            'ID'          => $uploaded_attachment_id,
            'post_parent' => $post_id,
        ] );
    }

    if ( ! empty( $category ) ) {
        wp_set_object_terms( $post_id, $category, 'gallery_category', false );
    }

    wp_send_json_success( [
        'id'        => $post_id,
        'image_url' => $image_url,
        'title'     => $title,
        'message'   => $media_id > 0 ? 'Gallery item updated successfully.' : 'Photo uploaded to gallery successfully.',
    ] );
}

/**
 * 3. DELETE GALLERY ITEM
 */
add_action( 'wp_ajax_radm_delete_gallery_item', 'radm_ajax_delete_gallery_item' );
function radm_ajax_delete_gallery_item(): void {
    radm_ajax_auth();

    $media_id = absint( $_POST['media_id'] ?? 0 );
    if ( ! $media_id ) {
        wp_send_json_error( [ 'message' => 'Invalid media ID.' ], 400 );
    }

    $deleted = wp_delete_post( $media_id, true );
    if ( ! $deleted ) {
        wp_send_json_error( [ 'message' => 'Failed to delete media.' ], 500 );
    }

    wp_send_json_success( [ 'message' => 'Media item deleted.' ] );
}

/**
 * 4. TOGGLE GALLERY ITEM STATUS (Publish <-> Draft)
 */
add_action( 'wp_ajax_radm_toggle_gallery_status', 'radm_ajax_toggle_gallery_status' );
function radm_ajax_toggle_gallery_status(): void {
    radm_ajax_auth();

    $media_id = absint( $_POST['media_id'] ?? 0 );
    if ( ! $media_id ) {
        wp_send_json_error( [ 'message' => 'Invalid media ID.' ], 400 );
    }

    $current_status = get_post_status( $media_id );
    $new_status     = ( $current_status === 'publish' ) ? 'draft' : 'publish';

    wp_update_post( [
        'ID'          => $media_id,
        'post_status' => $new_status,
    ] );

    wp_send_json_success( [
        'id'         => $media_id,
        'new_status' => $new_status,
        'message'    => 'Status updated to ' . ucfirst( $new_status ),
    ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// 10. ROLES & MODULE ACCESS MANAGEMENT
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Get all staff users with their roles, module access tags, and center scopes
 */
add_action( 'wp_ajax_radm_get_staff_users', 'radm_ajax_get_staff_users' );
function radm_ajax_get_staff_users(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Super Admin permission required.' ], 403 );
    }

    $all_modules = radm_get_all_modules();
    $all_centers = radm_get_all_centers();
    $users = get_users( [ 'orderby' => 'display_name', 'order' => 'ASC' ] );

    $role_labels = [
        'administrator'    => 'Super Admin',
        'radm_admin'       => 'Admin (Content & Reg)',
        'radm_gallery'     => 'Gallery Manager',
        'radm_center_admin'=> 'Center Admin',
        'subscriber'       => 'Subscriber',
    ];

    $items = [];
    foreach ( $users as $u ) {
        $perms = radm_get_user_module_permissions( $u->ID );
        $role_key = ! empty( $u->roles ) ? $u->roles[0] : 'subscriber';

        $mod_items = [];
        foreach ( ( $perms['modules'] ?? [] ) as $m_key ) {
            if ( isset( $all_modules[ $m_key ] ) ) {
                $mod_items[] = [
                    'key'   => $m_key,
                    'label' => $all_modules[ $m_key ]['label'],
                ];
            }
        }

        $items[] = [
            'id'              => (int) $u->ID,
            'name'            => $u->display_name ?: $u->user_login,
            'email'           => $u->user_email,
            'role'            => $role_key,
            'role_label'      => $role_labels[ $role_key ] ?? ucfirst( $role_key ),
            'is_super_admin'  => ! empty( $perms['is_super_admin'] ),
            'modules'         => $perms['modules'] ?? [],
            'module_items'    => $mod_items,
            'restrict_center' => ! empty( $perms['restrict_center'] ),
            'centers'         => $perms['centers'] ?? [],
            'is_self'         => ( (int) $u->ID === (int) get_current_user_id() ),
            'registered_fmt'  => date( 'M d, Y', strtotime( $u->user_registered ) ),
        ];
    }

    wp_send_json_success( [
        'users'       => $items,
        'all_modules' => $all_modules,
        'all_centers' => $all_centers,
        'roles'       => $role_labels,
    ] );
}

/**
 * Get single user module & role access
 */
add_action( 'wp_ajax_radm_get_user_access', 'radm_ajax_get_user_access' );
function radm_ajax_get_user_access(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Super Admin permission required.' ], 403 );
    }

    $user_id = absint( $_POST['user_id'] ?? 0 );
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        wp_send_json_error( [ 'message' => 'User not found.' ], 404 );
    }

    $perms = radm_get_user_module_permissions( $user_id );
    $role_key = ! empty( $user->roles ) ? $user->roles[0] : 'subscriber';

    wp_send_json_success( [
        'id'              => $user->ID,
        'name'            => $user->display_name ?: $user->user_login,
        'email'           => $user->user_email,
        'role'            => $role_key,
        'is_super_admin'  => in_array( 'administrator', $user->roles, true ),
        'modules'         => $perms['modules'] ?? [],
        'restrict_center' => ! empty( $perms['restrict_center'] ),
        'centers'         => $perms['centers'] ?? [],
        'all_modules'     => radm_get_all_modules(),
        'all_centers'     => radm_get_all_centers(),
    ] );
}

/**
 * Save user role, accessible modules (multi-select), and center restriction
 */
add_action( 'wp_ajax_radm_save_user_access', 'radm_ajax_save_user_access' );
function radm_ajax_save_user_access(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Super Admin permission required.' ], 403 );
    }

    $user_id = absint( $_POST['user_id'] ?? 0 );
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        wp_send_json_error( [ 'message' => 'User not found.' ], 404 );
    }

    // Role update
    $new_role = sanitize_text_field( $_POST['role'] ?? '' );
    if ( $new_role && $new_role !== ( ! empty( $user->roles ) ? $user->roles[0] : '' ) ) {
        // Prevent demoting yourself if only admin
        if ( $user_id === get_current_user_id() && $new_role !== 'administrator' ) {
            wp_send_json_error( [ 'message' => 'You cannot demote yourself from Super Admin.' ], 400 );
        }
        $user->set_role( $new_role );
    }

    // Accessible Modules Multi-Select parsing
    $raw_modules = $_POST['modules'] ?? [];
    if ( is_string( $raw_modules ) ) {
        $raw_modules = json_decode( stripslashes( $raw_modules ), true ) ?: [];
    }
    $valid_keys = array_keys( radm_get_all_modules() );
    $modules = array_values( array_intersect( (array) $raw_modules, $valid_keys ) );

    // Center Restriction parsing
    $restrict_center = ! empty( $_POST['restrict_center'] );
    $raw_centers = $_POST['centers'] ?? [];
    if ( is_string( $raw_centers ) ) {
        $raw_centers = json_decode( stripslashes( $raw_centers ), true ) ?: [];
    }
    $centers = array_map( 'sanitize_text_field', (array) $raw_centers );

    // Save to user meta
    update_user_meta( $user_id, '_radm_allowed_modules', $modules );
    update_user_meta( $user_id, '_radm_restrict_center', $restrict_center ? 1 : 0 );
    update_user_meta( $user_id, '_radm_assigned_centers', $centers );

    wp_send_json_success( [
        'message' => 'Module access and role permissions updated successfully for ' . ( $user->display_name ?: $user->user_login ) . '.',
        'user_id' => $user_id,
        'modules' => $modules,
        'restrict_center' => $restrict_center,
        'centers' => $centers,
    ] );
}

/**
 * Quick Create New Staff User with direct module & role assignment
 */
add_action( 'wp_ajax_radm_create_staff_user', 'radm_ajax_create_staff_user' );
function radm_ajax_create_staff_user(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Super Admin permission required.' ], 403 );
    }

    $name     = sanitize_text_field( $_POST['name'] ?? '' );
    $email    = sanitize_email( $_POST['email'] ?? '' );
    $username = sanitize_user( $_POST['username'] ?? '' );
    $password = $_POST['password'] ?? '';
    $role     = sanitize_text_field( $_POST['role'] ?? 'radm_admin' );

    if ( ! $name || ! $email ) {
        wp_send_json_error( [ 'message' => 'Name and Email are required.' ], 400 );
    }
    if ( email_exists( $email ) ) {
        wp_send_json_error( [ 'message' => 'A user with this email address already exists.' ], 400 );
    }

    if ( ! $username ) {
        $username = sanitize_user( current( explode( '@', $email ) ) );
        if ( username_exists( $username ) ) {
            $username .= '_' . wp_rand( 100, 999 );
        }
    }

    if ( ! $password ) {
        $password = wp_generate_password( 12, false );
    }

    $user_id = wp_create_user( $username, $password, $email );
    if ( is_wp_error( $user_id ) ) {
        wp_send_json_error( [ 'message' => $user_id->get_error_message() ], 400 );
    }

    wp_update_user( [
        'ID'           => $user_id,
        'display_name' => $name,
        'role'         => $role,
    ] );

    // Modules Multi-Select
    $raw_modules = $_POST['modules'] ?? [];
    if ( is_string( $raw_modules ) ) {
        $raw_modules = json_decode( stripslashes( $raw_modules ), true ) ?: [];
    }
    $valid_keys = array_keys( radm_get_all_modules() );
    $modules = array_values( array_intersect( (array) $raw_modules, $valid_keys ) );

    $restrict_center = ! empty( $_POST['restrict_center'] );
    $raw_centers = $_POST['centers'] ?? [];
    if ( is_string( $raw_centers ) ) {
        $raw_centers = json_decode( stripslashes( $raw_centers ), true ) ?: [];
    }
    $centers = array_map( 'sanitize_text_field', (array) $raw_centers );

    update_user_meta( $user_id, '_radm_allowed_modules', $modules );
    update_user_meta( $user_id, '_radm_restrict_center', $restrict_center ? 1 : 0 );
    update_user_meta( $user_id, '_radm_assigned_centers', $centers );

    wp_send_json_success( [
        'message'  => "Staff user '{$name}' created successfully!",
        'user_id'  => $user_id,
        'username' => $username,
        'password' => $password,
    ] );
}

/**
 * Delete staff user
 */
add_action( 'wp_ajax_radm_delete_staff_user', 'radm_ajax_delete_staff_user' );
function radm_ajax_delete_staff_user(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Super Admin permission required.' ], 403 );
    }

    $user_id = absint( $_POST['user_id'] ?? 0 );
    if ( ! $user_id ) {
        wp_send_json_error( [ 'message' => 'Invalid user ID.' ], 400 );
    }

    if ( $user_id === get_current_user_id() ) {
        wp_send_json_error( [ 'message' => 'You cannot delete your own account.' ], 400 );
    }

    $user = get_userdata( $user_id );
    if ( ! $user ) {
        wp_send_json_error( [ 'message' => 'User not found.' ], 404 );
    }

    // Require user deletion functions if not already loaded
    require_once ABSPATH . 'wp-admin/includes/user.php';

    $deleted = wp_delete_user( $user_id, get_current_user_id() );
    if ( ! $deleted ) {
        wp_send_json_error( [ 'message' => 'Failed to delete user.' ], 500 );
    }

    wp_send_json_success( [
        'message' => "User '{$user->display_name}' has been deleted successfully.",
        'user_id' => $user_id,
    ] );
}

/**
 * Save Organization Settings (Name, Logo, Contact Email)
 */
add_action( 'wp_ajax_radm_save_org_settings', 'radm_ajax_save_org_settings' );
function radm_ajax_save_org_settings(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized.' ], 403 );
    }

    $org_name      = sanitize_text_field( $_POST['org_name'] ?? '' );
    $org_logo      = esc_url_raw( $_POST['org_logo'] ?? '' );
    $contact_email = sanitize_email( $_POST['contact_email'] ?? '' );

    if ( empty( $org_name ) ) {
        wp_send_json_error( [ 'message' => 'Organization name is required.' ], 400 );
    }
    if ( empty( $contact_email ) || ! is_email( $contact_email ) ) {
        wp_send_json_error( [ 'message' => 'A valid contact email is required.' ], 400 );
    }

    update_option( 'blogname', $org_name );
    update_option( 'radm_org_name', $org_name );
    if ( ! empty( $org_logo ) ) {
        update_option( 'radm_org_logo', $org_logo );
    }
    update_option( 'admin_email', $contact_email );
    update_option( 'radm_contact_email', $contact_email );

    wp_send_json_success( [
        'message'       => 'Organization settings saved successfully!',
        'org_name'      => $org_name,
        'org_logo'      => $org_logo,
        'contact_email' => $contact_email,
    ] );
}

/**
 * Get all Centers
 */
add_action( 'wp_ajax_radm_get_centers', 'radm_ajax_get_centers' );
function radm_ajax_get_centers(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized.' ], 403 );
    }

    $centers = radm_get_centers_list();
    wp_send_json_success( [
        'centers' => $centers,
    ] );
}

/**
 * Save or Create Center
 */
add_action( 'wp_ajax_radm_save_center', 'radm_ajax_save_center' );
function radm_ajax_save_center(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized.' ], 403 );
    }

    $center_id = sanitize_key( $_POST['center_id'] ?? '' );
    $name      = sanitize_text_field( $_POST['name'] ?? '' );
    $location  = sanitize_text_field( $_POST['location'] ?? 'Bangalore' );
    $status    = sanitize_key( $_POST['status'] ?? 'active' );

    if ( empty( $name ) ) {
        wp_send_json_error( [ 'message' => 'Center name is required.' ], 400 );
    }

    $centers = radm_get_centers_list();
    $is_edit = false;

    if ( ! empty( $center_id ) ) {
        foreach ( $centers as &$c ) {
            if ( $c['id'] === $center_id ) {
                $c['name']     = $name;
                $c['location'] = $location;
                $c['status']   = in_array( $status, [ 'active', 'inactive' ], true ) ? $status : 'active';
                $is_edit = true;
                break;
            }
        }
        unset( $c );
    }

    if ( ! $is_edit ) {
        $center_id = 'center-' . uniqid();
        $centers[] = [
            'id'       => $center_id,
            'name'     => $name,
            'location' => $location ?: 'Bangalore',
            'status'   => in_array( $status, [ 'active', 'inactive' ], true ) ? $status : 'active',
        ];
    }

    update_option( 'radm_centers_list', $centers );

    wp_send_json_success( [
        'message' => $is_edit ? 'Center updated successfully!' : 'New center added successfully!',
        'center'  => [
            'id'       => $center_id,
            'name'     => $name,
            'location' => $location,
            'status'   => $status,
        ],
        'centers' => $centers,
    ] );
}

/**
 * Delete Center
 */
add_action( 'wp_ajax_radm_delete_center', 'radm_ajax_delete_center' );
function radm_ajax_delete_center(): void {
    radm_ajax_auth();
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized.' ], 403 );
    }

    $center_id = sanitize_key( $_POST['center_id'] ?? '' );
    if ( empty( $center_id ) ) {
        wp_send_json_error( [ 'message' => 'Invalid center ID.' ], 400 );
    }

    $centers = radm_get_centers_list();
    $new_centers = [];
    $deleted_name = '';

    foreach ( $centers as $c ) {
        if ( $c['id'] === $center_id ) {
            $deleted_name = $c['name'];
        } else {
            $new_centers[] = $c;
        }
    }

    update_option( 'radm_centers_list', $new_centers );

    wp_send_json_success( [
        'message'   => "Center '{$deleted_name}' deleted successfully.",
        'center_id' => $center_id,
        'centers'   => $new_centers,
    ] );
}









