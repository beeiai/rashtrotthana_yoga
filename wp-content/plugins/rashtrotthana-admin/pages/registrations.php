<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $wpdb;

// ── Determine sub-view: 'list' (default) or 'create' ─────────────────────
$view = sanitize_key( $_GET['radm_view'] ?? 'list' );

if ( $view === 'create' ) :
    // ══════════════════════════════════════════════════════
    //  CREATE NEW EVENT VIEW
    // ══════════════════════════════════════════════════════
    radm_portal_header( 'Registrations', 'Manage event registrations and participants' );
    $list_url   = admin_url( 'admin.php?page=radm-registrations' );
    $create_url = admin_url( 'admin.php?page=radm-registrations&radm_view=create' );

    // Centers list
    $centers = [
        'Jayanagar', 'Basavanagudi', 'Malleshwaram',
        'Indiranagar', 'Whitefield', 'HSR Layout',
        'Rajarajeshwari Nagar', 'Whitefield 2', 'Koramangala',
        'Yelahanka', 'Electronic City', 'Hebbal',
    ];
?>

<!-- Top bar: back link + breadcrumb -->
<div class="radm-page-topbar">
    <a href="<?php echo esc_url( $list_url ); ?>" class="radm-back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Back to Events
    </a>
    <nav class="radm-breadcrumb">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ); ?>">Home</a>
        <span class="sep">›</span>
        <a href="<?php echo esc_url( $list_url ); ?>">Registrations</a>
        <span class="sep">›</span>
        <span class="current">Create Event</span>
    </nav>
</div>

<!-- Page title -->
<div class="radm-page-title">
    <h2>Create New Event</h2>
    <p>Add event details and enable registrations for participants</p>
</div>

<!-- Form — posts via AJAX to radm_create_event -->
<form method="post" enctype="multipart/form-data" id="radm-create-event-form">
    <?php wp_nonce_field( 'radm_create_event', 'radm_event_nonce' ); ?>

    <!-- Server-side notice area -->
    <div id="radm-form-notice" style="display:none;" class="radm-notice"></div>

    <div class="radm-form-card">

        <!-- Event Name -->
        <div class="radm-form-group">
            <label class="radm-label" for="radm-event-name">
                Event Name <span class="req">*</span>
            </label>
            <input id="radm-event-name" name="event_name" type="text" class="radm-input"
                   placeholder="International Yoga Day Celebration 2026" required>
        </div>

        <!-- Event Description -->
        <div class="radm-form-group">
            <label class="radm-label" for="radm-event-desc">
                Event Description <span class="req">*</span>
            </label>
            <textarea id="radm-event-desc" name="event_description" class="radm-textarea"
                      placeholder="Join us for International Yoga Day 2026, a special celebration to embrace health, harmony and inner peace…" required></textarea>
        </div>

        <!-- Event Image -->
        <div class="radm-form-group">
            <label class="radm-label">Event Image</label>
            <div class="radm-upload-row">
                <label class="radm-upload-zone" for="radm-event-image" id="radm-upload-zone">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 16 12 12 8 16"/>
                        <line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/>
                    </svg>
                    <p>Drag &amp; drop an image here<br>or click to upload</p>
                    <small>JPG, PNG or WebP (Max 2 MB)</small>
                    <input id="radm-event-image" name="event_image" type="file"
                           accept="image/jpeg,image/png,image/webp" style="display:none;">
                </label>
                <div class="radm-upload-preview" id="radm-image-preview" style="display:none; min-height:150px;">
                    <img id="radm-preview-img" src="" alt="Preview">
                    <button type="button" class="radm-preview-remove" id="radm-remove-img" title="Remove image">✕</button>
                </div>
            </div>
        </div>

        <!-- Event Date / Start Time / End Time -->
        <div class="radm-form-row cols-3">
            <div>
                <label class="radm-label" for="radm-event-date">
                    Event Date <span class="req">*</span>
                </label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <input id="radm-event-date" name="event_date" type="date" class="radm-input" required>
                </div>
            </div>
            <div>
                <label class="radm-label" for="radm-start-time">
                    Start Time <span class="req">*</span>
                </label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <input id="radm-start-time" name="start_time" type="time" class="radm-input" required>
                </div>
            </div>
            <div>
                <label class="radm-label" for="radm-end-time">
                    End Time <span class="req">*</span>
                </label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <input id="radm-end-time" name="end_time" type="time" class="radm-input" required>
                </div>
            </div>
        </div>

        <!-- Select Centers -->
        <div class="radm-form-group">
            <label class="radm-label">Select Centers <span class="req">*</span></label>
            <div class="radm-search-input-wrap">
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" class="radm-input" id="radm-center-search"
                           placeholder="Search centers (e.g. Jayanagar, Basavanagudi…)">
                </div>
            </div>
            <div class="radm-centers-grid" id="radm-centers-list">
                <?php foreach ( $centers as $center ) :
                    $id  = 'center-' . sanitize_title( $center );
                    $val = sanitize_title( $center );
                ?>
                <label class="radm-checkbox-item" data-name="<?php echo esc_attr( strtolower( $center ) ); ?>">
                    <input type="checkbox" id="<?php echo esc_attr( $id ); ?>"
                           name="centers[]" value="<?php echo esc_attr( $val ); ?>">
                    <span><?php echo esc_html( $center ); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Registration Last Date + Enable Registration -->
        <div class="radm-form-row cols-2">
            <div>
                <label class="radm-label" for="radm-reg-last-date">
                    Registration Last Date <span class="req">*</span>
                </label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <input id="radm-reg-last-date" name="reg_last_date" type="date" class="radm-input" required>
                </div>
            </div>
            <div>
                <label class="radm-label">Enable Registration <span class="req">*</span></label>
                <div class="radm-toggle-row" style="margin-top:4px;">
                    <label class="radm-toggle">
                        <input type="checkbox" name="registration_open" id="radm-reg-toggle" checked>
                        <span class="radm-toggle-track"></span>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- Google Form Options -->
        <div class="radm-form-row cols-2" style="margin-top:20px; border-top: 1px dashed #cbd5e1; padding-top: 20px;">
            <div>
                <label class="radm-label">Use Google Form? (External)</label>
                <div class="radm-toggle-row" style="margin-top:4px;">
                    <label class="radm-toggle">
                        <input type="checkbox" name="use_google_form" id="radm-use-google-form-toggle" value="1">
                        <span class="radm-toggle-track"></span>
                    </label>
                </div>
            </div>
            <div>
                <label class="radm-label" for="radm-google-form-url">
                    Google Form URL
                </label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                    <input id="radm-google-form-url" name="google_form_url" type="url" class="radm-input" placeholder="https://docs.google.com/forms/...">
                </div>
            </div>
        </div>

    </div><!-- /.radm-form-card -->

    <!-- Action buttons -->
    <div class="radm-form-actions">
        <a href="<?php echo esc_url( $list_url ); ?>" class="radm-btn radm-btn-outline">Cancel</a>
        <button type="submit" class="radm-btn radm-btn-primary" id="radm-create-event-submit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Create Event
        </button>
    </div>

</form>

<?php
    radm_portal_footer();

else :
    // ══════════════════════════════════════════════════════
    //  EVENTS LIST VIEW (default)
    // ══════════════════════════════════════════════════════
    radm_portal_header( 'Registrations', 'Manage events and view registered participants' );
    $create_url = admin_url( 'admin.php?page=radm-registrations&radm_view=create' );
    $active_tab = sanitize_key( $_GET['radm_tab'] ?? 'events' );

    // ── Real data: events from WP CPT 'event' ─────────────────────────────
    $event_posts = get_posts( [
        'post_type'      => 'event',
        'post_status'    => 'publish',
        'numberposts'    => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => '_ry_event_date',
        'order'          => 'ASC',
    ] );

    $reg_table = $wpdb->prefix . 'ry_registrations';
    $now_date  = current_time( 'Y-m-d' );
    $events    = [];

    foreach ( $event_posts as $i => $post ) {
        $event_date    = get_post_meta( $post->ID, '_ry_event_date', true );
        $reg_open      = get_post_meta( $post->ID, '_ry_registration_open', true );
        $reg_last_date = get_post_meta( $post->ID, '_ry_reg_last_date', true );
        $start_time    = get_post_meta( $post->ID, '_ry_start_time', true );
        $end_time      = get_post_meta( $post->ID, '_ry_end_time', true );
        $use_google_form = get_post_meta( $post->ID, '_ry_use_google_form', true );
        $google_form_url = get_post_meta( $post->ID, '_ry_google_form_url', true );

        $reg_count = (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$reg_table} WHERE event_id = %d AND status NOT IN ('cancelled','rejected')",
            $post->ID
        ) );

        $is_open  = $reg_open && ( ! $reg_last_date || $now_date <= $reg_last_date );
        $status   = $is_open ? 'open' : 'closed';

        $events[] = [
            'id'              => $post->ID,
            'num'             => $i + 1,
            'name'            => $post->post_title,
            'date'            => $event_date ? date( 'd M Y', strtotime( $event_date ) ) : '—',
            'date_raw'        => $event_date ?: '',
            'start_time'      => $start_time,
            'end_time'        => $end_time,
            'reg_count'       => $reg_count,
            'status'          => $status,
            'use_google_form' => $use_google_form,
            'google_form_url' => $google_form_url,
        ];
    }

    // ── Real data: participants for users tab ──────────────────────────────
    $event_id    = absint( $_GET['event'] ?? 0 );
    $event_label = '';
    $users       = [];

    if ( $active_tab === 'users' && $event_id ) {
        $event_post = get_post( $event_id );
        if ( $event_post && $event_post->post_type === 'event' ) {
            $event_label = $event_post->post_title;
        }

        $at = $wpdb->prefix . 'ry_registration_answers';

        $raw_users = $wpdb->get_results( $wpdb->prepare(
            "SELECT r.id, r.name, r.phone, r.email, r.status,
                    MAX(CASE WHEN a.field_key IN ('branch','center','location') THEN a.field_value END) AS branch
             FROM {$reg_table} r
             LEFT JOIN {$at} a ON a.registration_id = r.id
             WHERE r.event_id = %d AND r.status NOT IN ('cancelled','rejected')
             GROUP BY r.id
             ORDER BY r.id ASC",
            $event_id
        ), ARRAY_A );

        foreach ( $raw_users as $u ) {
            $users[] = [
                'id'     => $u['id'],
                'name'   => $u['name'],
                'phone'  => $u['phone'],
                'email'  => $u['email'],
                'branch' => $u['branch'] ?: '—',
                'status' => $u['status'],
            ];
        }
    }

    $branch_list = [
        'Jayanagar','Basavanagudi','Malleshwaram','Indiranagar',
        'Whitefield','HSR Layout','Rajarajeshwari Nagar','Whitefield 2',
        'Koramangala','Yelahanka','Electronic City','Hebbal',
    ];
?>

<!-- ── Tabs Row + Create Button ─────────────────────────────────────── -->
<div class="radm-reg-topbar">
    <div class="radm-tabs">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&radm_tab=events' ) ); ?>"
           class="radm-tab <?php echo $active_tab === 'events' ? 'active' : ''; ?>">
            Events
        </a>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&radm_tab=users' ) ); ?>"
           class="radm-tab <?php echo $active_tab === 'users' ? 'active' : ''; ?>">
            Registered Users
        </a>
    </div>
    <a href="<?php echo esc_url( $create_url ); ?>" class="radm-btn radm-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Create New Event
    </a>
</div>

<!-- ── Events Tab ─────────────────────────────────────────────────────── -->
<?php if ( $active_tab !== 'users' ) : ?>

<div class="radm-card">
    <!-- Search + Count -->
    <div class="radm-table-toolbar">
        <div class="radm-input-icon" style="max-width:280px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" class="radm-input" id="radm-event-search"
                   placeholder="Search events…" style="font-size:13px;">
        </div>
        <span class="radm-count-label"><?php echo count( $events ); ?> event<?php echo count( $events ) !== 1 ? 's' : ''; ?></span>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-events-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Registrations</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( empty( $events ) ) : ?>
                <tr>
                    <td colspan="6">
                        <div class="radm-coming-soon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <h3>No Events Yet</h3>
                            <p>Create your first event using the button above.</p>
                        </div>
                    </td>
                </tr>
                <?php else : ?>
                <?php foreach ( $events as $ev ) : ?>
                <tr class="radm-event-row" data-id="<?php echo esc_attr( $ev['id'] ); ?>">
                    <td style="color:var(--radm-text-muted);font-weight:600;"><?php echo esc_html( $ev['num'] ); ?></td>
                    <td style="font-weight:500;" class="radm-event-name"><?php echo esc_html( $ev['name'] ); ?></td>
                    <td style="color:var(--radm-text-muted);"><?php echo esc_html( $ev['date'] ); ?></td>
                    <td><?php echo esc_html( $ev['reg_count'] ); ?></td>
                    <td><span class="radm-badge <?php echo esc_attr( $ev['status'] ); ?>"><?php echo esc_html( ucfirst( $ev['status'] ) ); ?></span></td>
                    <td>
                        <div class="radm-action-group">
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&radm_tab=users&event=' . $ev['id'] ) ); ?>"
                               class="radm-btn-view" title="View registered users">
                                View Users
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit radm-edit-event-btn"
                                    title="Edit event"
                                    data-id="<?php echo esc_attr( $ev['id'] ); ?>"
                                    data-name="<?php echo esc_attr( $ev['name'] ); ?>"
                                    data-date="<?php echo esc_attr( $ev['date_raw'] ); ?>"
                                    data-start="<?php echo esc_attr( $ev['start_time'] ?? '' ); ?>"
                                    data-end="<?php echo esc_attr( $ev['end_time'] ?? '' ); ?>"
                                    data-status="<?php echo esc_attr( $ev['status'] ); ?>"
                                    data-use-google-form="<?php echo esc_attr( $ev['use_google_form'] ); ?>"
                                    data-google-form-url="<?php echo esc_attr( $ev['google_form_url'] ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete radm-delete-event-btn"
                                    title="Delete event"
                                    data-id="<?php echo esc_attr( $ev['id'] ); ?>"
                                    data-label="<?php echo esc_attr( $ev['name'] ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php else :
    // ── Registered Users Tab ────────────────────────────────────────────
?>

<!-- ── Registered Users Tab ───────────────────────────────────────────── -->

<?php if ( $event_label ) : ?>
<div class="radm-users-context-bar">
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&radm_tab=events' ) ); ?>"
       class="radm-back-link" style="font-size:13px;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        All Events
    </a>
    <span class="radm-users-context-title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 00-3-3.87"/>
            <path d="M16 3.13a4 4 0 010 7.75"/>
        </svg>
        Registrations for: <strong><?php echo esc_html( $event_label ); ?></strong>
    </span>
</div>
<?php endif; ?>

<div class="radm-card">

    <?php if ( empty( $users ) ) : ?>
    <div class="radm-coming-soon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 00-3-3.87"/>
            <path d="M16 3.13a4 4 0 010 7.75"/>
        </svg>
        <h3>No Registrations Yet</h3>
        <p><?php echo $event_label ? 'No one has registered for this event yet.' : 'Select an event from the Events tab to view its registered participants.'; ?></p>
    </div>

    <?php else : ?>

    <!-- Toolbar: search + add + export + count -->
    <div class="radm-table-toolbar">
        <div class="radm-input-icon" style="max-width:280px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" class="radm-input" id="radm-users-search"
                   placeholder="Search by name, phone, email or branch…" style="font-size:13px;">
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <span class="radm-count-label" id="radm-users-count"><?php echo count( $users ); ?> participants</span>
            <a href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=radm_export_csv&nonce=' . wp_create_nonce( 'radm_nonce' ) . '&event_id=' . $event_id ) ); ?>"
               class="radm-btn radm-btn-outline radm-btn-sm" id="radm-export-csv">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export CSV
            </a>
            <button type="button" class="radm-btn radm-btn-primary radm-btn-sm" id="radm-add-user-btn"
                    data-event-id="<?php echo esc_attr( $event_id ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Add Participant
            </button>
        </div>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-users-table">
            <thead>
                <tr>
                    <th style="width:42px;">#</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Branch</th>
                    <th style="width:100px;text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="radm-users-tbody">
                <?php foreach ( $users as $i => $u ) :
                    $parts    = explode( ' ', trim( $u['name'] ) );
                    $initials = strtoupper(
                        count( $parts ) >= 2
                            ? substr( $parts[0], 0, 1 ) . substr( $parts[1], 0, 1 )
                            : substr( $parts[0], 0, 2 )
                    );
                ?>
                <tr class="radm-user-row"
                    data-id="<?php echo esc_attr( $u['id'] ); ?>"
                    data-name="<?php echo esc_attr( strtolower( $u['name'] ) ); ?>"
                    data-phone="<?php echo esc_attr( $u['phone'] ); ?>"
                    data-email="<?php echo esc_attr( strtolower( $u['email'] ) ); ?>"
                    data-branch="<?php echo esc_attr( strtolower( $u['branch'] ) ); ?>"
                    data-raw-name="<?php echo esc_attr( $u['name'] ); ?>"
                    data-raw-phone="<?php echo esc_attr( $u['phone'] ); ?>"
                    data-raw-email="<?php echo esc_attr( $u['email'] ); ?>"
                    data-raw-branch="<?php echo esc_attr( $u['branch'] ); ?>">
                    <td class="radm-row-num" style="color:var(--radm-text-muted);font-weight:600;"><?php echo $i + 1; ?></td>
                    <td>
                        <div class="radm-user-cell">
                            <div class="radm-user-initials" data-initials="<?php echo esc_attr( $initials ); ?>"><?php echo esc_html( $initials ); ?></div>
                            <span class="radm-user-name-text" style="font-weight:500;"><?php echo esc_html( $u['name'] ); ?></span>
                        </div>
                    </td>
                    <td>
                        <a href="tel:<?php echo esc_attr( $u['phone'] ); ?>" class="radm-contact-link radm-phone-link radm-cell-phone">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 012.11 4.18 2 2 0 014.09 2H7.1a2 2 0 012 1.72c.13 1 .37 2 .72 2.93a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.15-1.15a2 2 0 012.11-.45c.93.35 1.93.59 2.93.72A2 2 0 0122 16.92z"/>
                            </svg>
                            <span><?php echo esc_html( $u['phone'] ); ?></span>
                        </a>
                    </td>
                    <td>
                        <a href="mailto:<?php echo esc_attr( $u['email'] ); ?>" class="radm-contact-link radm-email-link radm-cell-email">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <span><?php echo esc_html( $u['email'] ); ?></span>
                        </a>
                    </td>
                    <td><span class="radm-branch-badge radm-cell-branch"><?php echo esc_html( $u['branch'] ); ?></span></td>
                    <td style="text-align:center;">
                        <div class="radm-action-group" style="justify-content:center;">
                            <button type="button"
                                    class="radm-icon-btn radm-icon-btn--edit radm-edit-user-btn"
                                    title="Edit participant"
                                    data-row-id="<?php echo esc_attr( $u['id'] ); ?>"
                                    data-event-id="<?php echo esc_attr( $event_id ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button"
                                    class="radm-icon-btn radm-icon-btn--delete radm-delete-user-btn"
                                    title="Delete participant"
                                    data-row-id="<?php echo esc_attr( $u['id'] ); ?>"
                                    data-label="<?php echo esc_attr( $u['name'] ); ?>"
                                    data-event-id="<?php echo esc_attr( $event_id ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php endif; ?>
</div><!-- /.radm-card -->

<?php endif; /* users tab */ ?>

<?php
    radm_portal_footer();
endif;
?>

<!-- ══════════════════════════════════════════════════════════════
     ADD / EDIT PARTICIPANT MODAL
     ══════════════════════════════════════════════════════════════ -->
<div id="radm-user-modal-overlay" class="radm-modal-overlay" aria-hidden="true">
    <div class="radm-modal" role="dialog" aria-labelledby="radm-modal-title" aria-modal="true">

        <div class="radm-modal-header">
            <h3 id="radm-modal-title">Add Participant</h3>
            <button type="button" class="radm-modal-close" id="radm-modal-close-btn" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="radm-modal-body">
            <input type="hidden" id="radm-modal-row-id" value="">
            <input type="hidden" id="radm-modal-event-id" value="">

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label" for="radm-modal-name">Full Name <span class="req">*</span></label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <input type="text" id="radm-modal-name" class="radm-input" placeholder="e.g. Aarav Sharma" required>
                </div>
            </div>

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label" for="radm-modal-phone">Phone Number <span class="req">*</span></label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 012.11 4.18 2 2 0 014.09 2H7.1a2 2 0 012 1.72c.13 1 .37 2 .72 2.93a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.15-1.15a2 2 0 012.11-.45c.93.35 1.93.59 2.93.72A2 2 0 0122 16.92z"/>
                    </svg>
                    <input type="tel" id="radm-modal-phone" class="radm-input" placeholder="e.g. 9845012345" required>
                </div>
            </div>

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label" for="radm-modal-email">Email <span class="req">*</span></label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <input type="email" id="radm-modal-email" class="radm-input" placeholder="e.g. name@gmail.com" required>
                </div>
            </div>

            <div class="radm-form-group" style="margin-bottom:4px;">
                <label class="radm-label" for="radm-modal-branch">Branch <span class="req">*</span></label>
                <div class="radm-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <select id="radm-modal-branch" class="radm-input" required>
                        <option value="">— Select branch —</option>
                        <?php foreach ( $branch_list as $b ) {
                            echo '<option value="' . esc_attr( $b ) . '">' . esc_html( $b ) . '</option>';
                        } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-modal-cancel-btn">Cancel</button>
            <button type="button" class="radm-btn radm-btn-primary" id="radm-modal-save-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Save Participant
            </button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     DELETE CONFIRMATION MODAL
     ══════════════════════════════════════════════════════════════ -->
<div id="radm-delete-modal-overlay" class="radm-modal-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--sm" role="dialog" aria-modal="true">

        <div class="radm-modal-header">
            <h3 style="color:#C62828;">Confirm Delete</h3>
            <button type="button" class="radm-modal-close" id="radm-delete-modal-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="radm-modal-body" style="padding-top:8px;">
            <div class="radm-delete-warning-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                </svg>
            </div>
            <p style="margin:0 0 6px;font-weight:600;font-size:15px;">Are you sure?</p>
            <p style="margin:0;color:var(--radm-text-muted);font-size:13px;">
                You are about to remove <strong id="radm-delete-label"></strong>.
                This action cannot be undone.
            </p>
        </div>

        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-delete-cancel-btn">Cancel</button>
            <button type="button" class="radm-btn radm-btn-danger" id="radm-delete-confirm-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                </svg>
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     EDIT EVENT MODAL
     ══════════════════════════════════════════════════════════════ -->
<div id="radm-edit-event-overlay" class="radm-modal-overlay" aria-hidden="true">
    <div class="radm-modal" role="dialog" aria-modal="true">
        <div class="radm-modal-header">
            <h3>Edit Event</h3>
            <button type="button" class="radm-modal-close" id="radm-edit-event-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="radm-modal-body">
            <input type="hidden" id="radm-edit-event-id">

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label" for="radm-edit-event-name">Event Name <span class="req">*</span></label>
                <input type="text" id="radm-edit-event-name" class="radm-input" required>
            </div>

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label" for="radm-edit-event-date">Event Date</label>
                <input type="date" id="radm-edit-event-date" class="radm-input">
            </div>

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label">Use Google Form? (External)</label>
                <div class="radm-toggle-row" style="margin-top:4px;">
                    <label class="radm-toggle">
                        <input type="checkbox" id="radm-edit-use-google-form">
                        <span class="radm-toggle-track"></span>
                    </label>
                </div>
            </div>

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label" for="radm-edit-google-form-url">Google Form URL</label>
                <input type="url" id="radm-edit-google-form-url" class="radm-input" placeholder="https://docs.google.com/forms/...">
            </div>

            <div class="radm-form-group" style="margin-bottom:4px;">
                <label class="radm-label">Registration Status</label>
                <div class="radm-toggle-row" style="margin-top:4px;">
                    <label class="radm-toggle">
                        <input type="checkbox" id="radm-edit-event-reg-open">
                        <span class="radm-toggle-track"></span>
                    </label>
                    <span class="radm-toggle-label" id="radm-edit-reg-label">Registrations are open</span>
                </div>
            </div>
        </div>
        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-edit-event-cancel">Cancel</button>
            <button type="button" class="radm-btn radm-btn-primary" id="radm-edit-event-save">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Save Changes
            </button>
        </div>
    </div>
</div>
