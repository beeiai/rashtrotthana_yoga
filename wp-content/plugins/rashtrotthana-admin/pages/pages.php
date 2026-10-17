<?php
/**
 * Content Pages Module — Rashtrotthana Admin Portal
 * 100% In-Portal Management for Centers, Activities, Events, News, and Inquiries.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$section = sanitize_key( $_GET['section'] ?? 'centers' );
if ( ! in_array( $section, [ 'centers', 'activities', 'events', 'news', 'faqs', 'inquiries', 'activity-inquiries' ], true ) ) {
    $section = 'centers';
}

// Global cached lists for dropdowns throughout this module
$all_centers_list = get_posts( [
    'post_type'      => [ 'rs_center', 'center' ],
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
] );

$all_activities_list = get_posts( [
    'post_type'      => [ 'activity', 'rs_activity' ],
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
] );

// Counts for tabs
$count_centers    = count( $all_centers_list ) ?: (int) wp_count_posts( 'rs_center' )->publish;
$count_activities = count( $all_activities_list ) ?: (int) wp_count_posts( 'activity' )->publish;
$count_events     = (int) wp_count_posts( 'event' )->publish;
$count_news       = (int) wp_count_posts( 'post' )->publish;
$count_faqs       = (int) wp_count_posts( 'faq' )->publish;

// Inquiries breakdown: Contact vs Activity Registrations
$all_inquiry_ids = get_posts( [
    'post_type'      => 'rs_inquiry',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
] );
$count_contact_inquiries  = 0;
$count_activity_inquiries = 0;
foreach ( $all_inquiry_ids as $inq_post_id ) {
    $inq_act = get_post_meta( $inq_post_id, '_rs_activity', true );
    if ( ! empty( $inq_act ) ) {
        $count_activity_inquiries++;
    } else {
        $count_contact_inquiries++;
    }
}

$titles = [
    'centers'            => [ 'Centers Management', 'Add, edit, or customize Rashtrotthana branch locations & details.' ],
    'activities'         => [ 'Activities & Classes', 'Manage yoga programs, schedules, batches, and activities.' ],
    'events'             => [ 'Events Management', 'Create and oversee upcoming campus events & masterclasses.' ],
    'news'               => [ 'News & Press Releases', 'Publish updates, news announcements, and articles.' ],
    'faqs'               => [ 'FAQ Questions Management', 'Manage frequently asked questions displayed on Contact Us and Help pages.' ],
    'inquiries'          => [ 'Contact Form Inquiries', 'View and respond to general inquiries submitted from the Contact Us page.' ],
    'activity-inquiries' => [ 'Activity Registrations & Enquiries', 'Manage student applications and batch inquiries submitted for yoga & cultural programs.' ],
];

radm_portal_header( $titles[ $section ][0], $titles[ $section ][1] );
?>

<!-- ── Top Tabs Navigation ────────────────────────────────────────────────── -->
<div class="radm-reg-topbar" style="margin-bottom: 22px;">
    <div class="radm-tabs" style="width: 100%; border-bottom: 2px solid var(--radm-border); display: flex; gap: 4px; overflow-x: auto;">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=centers' ) ); ?>"
           class="radm-tab<?php echo $section === 'centers' ? ' active' : ''; ?>">
            🏢 Centers (<?php echo esc_html( $count_centers ); ?>)
        </a>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=activities' ) ); ?>"
           class="radm-tab<?php echo $section === 'activities' ? ' active' : ''; ?>">
            🧘 Activities (<?php echo esc_html( $count_activities ); ?>)
        </a>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=events' ) ); ?>"
           class="radm-tab<?php echo $section === 'events' ? ' active' : ''; ?>">
            📅 Events (<?php echo esc_html( $count_events ); ?>)
        </a>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=news' ) ); ?>"
           class="radm-tab<?php echo $section === 'news' ? ' active' : ''; ?>">
            📰 News &amp; Updates (<?php echo esc_html( $count_news ); ?>)
        </a>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=faqs' ) ); ?>"
           class="radm-tab<?php echo $section === 'faqs' ? ' active' : ''; ?>">
            ❓ FAQs (<?php echo esc_html( $count_faqs ); ?>)
        </a>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=inquiries' ) ); ?>"
           class="radm-tab<?php echo $section === 'inquiries' ? ' active' : ''; ?>">
            📞 Contact Inquiries (<?php echo esc_html( $count_contact_inquiries ); ?>)
        </a>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=activity-inquiries' ) ); ?>"
           class="radm-tab<?php echo $section === 'activity-inquiries' ? ' active' : ''; ?>">
            🧘 Activity Enquiries (<?php echo esc_html( $count_activity_inquiries ); ?>)
        </a>
    </div>
</div>

<?php if ( $section === 'centers' ) : ?>
<!-- ══════════════════════════════════════════════════════════════════════════
     SECTION: CENTERS MANAGEMENT
     ══════════════════════════════════════════════════════════════════════════ -->
<?php
$centers_query = new WP_Query( [
    'post_type'      => 'rs_center',
    'posts_per_page' => -1,
    'post_status'    => [ 'publish', 'draft' ],
    'orderby'        => 'title',
    'order'          => 'ASC',
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar">
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:280px; max-width:100%;">
                <input type="text" id="radm-center-search" class="radm-input" placeholder="Search centers by name or area…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <select id="radm-center-zone-filter" class="radm-select" style="width:190px;">
                <option value="">All Zones</option>
                <option value="South Bengaluru">South Bengaluru</option>
                <option value="North Bengaluru">North Bengaluru</option>
                <option value="West Bengaluru">West Bengaluru</option>
                <option value="East Bengaluru">East Bengaluru</option>
            </select>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span class="radm-count-label"><strong id="radm-center-count"><?php echo esc_html( $centers_query->found_posts ); ?></strong> Centers Total</span>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmOpenCenterModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add New Center
            </button>
        </div>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-centers-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:70px;">Image</th>
                    <th>Center Name</th>
                    <th>Zone &amp; Area</th>
                    <th>Contact Info</th>
                    <th>Inquiries / Registrations</th>
                    <th>Directions Link</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $centers_query->have_posts() ) :
                    $idx = 1;
                    global $wpdb;
                    while ( $centers_query->have_posts() ) :
                        $centers_query->the_post();
                        $cid     = get_the_ID();
                        $title   = get_the_title();
                        $area    = get_post_meta( $cid, 'area', true ) ?: '';
                        $zone    = get_post_meta( $cid, 'zone', true ) ?: 'South Bengaluru';
                        $phone   = get_post_meta( $cid, 'phone', true ) ?: '';
                        $email   = get_post_meta( $cid, 'email', true ) ?: '';
                        $hours   = get_post_meta( $cid, 'hours', true ) ?: '';
                        $address = get_post_meta( $cid, 'address', true ) ?: get_the_content();
                        $map_url = get_post_meta( $cid, 'map_url', true ) ?: '';
                        $ig_url  = get_post_meta( $cid, 'instagram_url', true ) ?: '';
                        $fb_url  = get_post_meta( $cid, 'facebook_url', true ) ?: '';
                        $lt_url  = get_post_meta( $cid, 'linktree_url', true ) ?: '';
                        $img     = get_the_post_thumbnail_url( $cid, 'medium' ) ?: ( get_post_meta( $cid, '_ry_image_url', true ) ?: '' );
                        $att_id  = (int) get_post_thumbnail_id( $cid );
                        $status  = get_post_status( $cid );
                        $status_label = $status === 'publish' ? 'Published' : 'Draft';
                        $status_class = $status === 'publish' ? 'radm-badge--green' : 'radm-badge--orange';

                        $cen_inq_count = (int) $wpdb->get_var( $wpdb->prepare(
                            "SELECT COUNT(DISTINCT p.ID) FROM {$wpdb->posts} p
                             INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
                             WHERE p.post_type = 'rs_inquiry'
                               AND p.post_status != 'trash'
                               AND pm.meta_key = '_rs_center'
                               AND (pm.meta_value = %s OR pm.meta_value LIKE %s)",
                            $title,
                            '%' . $wpdb->esc_like( $title ) . '%'
                        ) );
                        $cen_reg_count = 0;
                        $has_ans_table = $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}ry_registration_answers'" );
                        if ( $has_ans_table ) {
                            $cen_reg_count = (int) $wpdb->get_var( $wpdb->prepare(
                                "SELECT COUNT(DISTINCT a.registration_id) FROM {$wpdb->prefix}ry_registration_answers a
                                 WHERE a.field_key IN ('branch','center','location')
                                   AND (a.field_value = %s OR a.field_value LIKE %s)",
                                $title,
                                '%' . $wpdb->esc_like( $title ) . '%'
                            ) );
                        }
                        $total_cen_count = max( $cen_inq_count, $cen_reg_count );
                ?>
                <tr class="radm-center-row"
                    data-title="<?php echo esc_attr( strtolower( $title ) ); ?>"
                    data-area="<?php echo esc_attr( strtolower( $area ) ); ?>"
                    data-zone="<?php echo esc_attr( $zone ); ?>"
                    id="center-row-<?php echo esc_attr( $cid ); ?>">
                    <td style="color:var(--radm-text-muted); font-size:12px;"><?php echo esc_html( $idx++ ); ?></td>
                    <td>
                        <div style="width:48px; height:48px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border:1px solid var(--radm-border);">
                            <?php if ( $img ) : ?>
                                <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%; height:100%; object-fit:cover;" />
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" style="color:#94a3b8;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <strong style="font-size:14px; color:var(--radm-text); display:block;"><?php echo esc_html( $title ); ?></strong>
                        <?php if ( $area ) : ?>
                            <span style="font-size:12px; color:var(--radm-text-muted);"><?php echo esc_html( $area ); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="radm-branch-badge" style="margin-bottom:4px;"><?php echo esc_html( $zone ); ?></span>
                        <?php if ( $hours ) : ?>
                            <div style="font-size:11.5px; color:var(--radm-text-muted);"><?php echo esc_html( $hours ); ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ( $phone ) : ?>
                            <div style="font-size:12.5px;"><a href="tel:<?php echo esc_attr( $phone ); ?>" style="color:var(--radm-text); text-decoration:none;"><?php echo esc_html( $phone ); ?></a></div>
                        <?php endif; ?>
                        <?php if ( $email ) : ?>
                            <div style="font-size:11.5px; color:var(--radm-text-muted);"><?php echo esc_html( $email ); ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=activity-inquiries&center=' . urlencode( $title ) ) ); ?>"
                           style="display:inline-flex; align-items:center; gap:5px; font-weight:600; font-size:12.5px; color:<?php echo $total_cen_count > 0 ? 'var(--radm-green)' : 'var(--radm-text-muted)'; ?>; text-decoration:none;"
                           title="Click to view inquiries received for this center">
                            <span style="display:inline-block; width:7px; height:7px; border-radius:50%; background:<?php echo $total_cen_count > 0 ? '#10b981' : '#cbd5e1'; ?>;"></span>
                            <strong><?php echo esc_html( $total_cen_count ); ?></strong> inquiries &rarr;
                        </a>
                    </td>
                    <td>
                        <?php if ( $map_url ) : ?>
                            <a href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener" style="display:inline-flex; align-items:center; gap:4px; font-size:12px; color:var(--radm-green); font-weight:600; text-decoration:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                                </svg>
                                Google Maps
                            </a>
                        <?php else : ?>
                            <span style="color:#94a3b8; font-size:12px;">Not set</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="radm-badge <?php echo esc_attr( $status_class ); ?>">
                            <?php echo esc_html( $status_label ); ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <?php
                            $prog_rows = get_field('programs', $cid);
                            $center_acts = [];
                            if ( is_numeric($prog_rows) || is_string($prog_rows) ) {
                                $prog_cnt = intval($prog_rows);
                                for ( $pi = 0; $pi < $prog_cnt; $pi++ ) {
                                    $pname = get_post_meta($cid, 'programs_' . $pi . '_program_name', true);
                                    if ($pname) { $center_acts[] = $pname; }
                                }
                            } elseif ( is_array($prog_rows) ) {
                                foreach ($prog_rows as $prow) {
                                    if (!empty($prow['program_name'])) { $center_acts[] = $prow['program_name']; }
                                }
                            }
                            $saved_acts = get_post_meta($cid, '_ry_center_activities', true);
                            if ( is_array($saved_acts) ) {
                                $center_acts = array_values(array_unique(array_merge($center_acts, $saved_acts)));
                            }
                            ?>
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="Edit Center"
                                    data-center="<?php echo esc_attr( wp_json_encode( [
                                        'id'            => $cid,
                                        'title'         => $title,
                                        'area'          => $area,
                                        'zone'          => $zone,
                                        'phone'         => $phone,
                                        'email'         => $email,
                                        'hours'         => $hours,
                                        'address'       => $address,
                                        'map_url'       => $map_url,
                                        'instagram_url' => $ig_url,
                                        'facebook_url'  => $fb_url,
                                        'linktree_url'  => $lt_url,
                                        'image_url'     => $img,
                                        'attachment_id' => $att_id,
                                        'status'        => $status,
                                        'activities'    => $center_acts,
                                    ] ) ); ?>"
                                    onclick="radmEditCenter(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Center"
                                    data-id="<?php echo esc_attr( $cid ); ?>"
                                    data-title="<?php echo esc_attr( $title ); ?>"
                                    data-attachment-id="<?php echo esc_attr( $att_id ); ?>"
                                    onclick="radmPromptDelete(this, '<?php echo esc_attr( addslashes( $title ) ); ?>', 'center', <?php echo esc_attr( $att_id ); ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <tr>
                    <td colspan="9" style="text-align:center; padding:36px; color:var(--radm-text-muted);">
                        No centers found in database. Click <strong>+ Add New Center</strong> to create one.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php elseif ( $section === 'activities' ) : ?>
<!-- ══════════════════════════════════════════════════════════════════════════
     SECTION: ACTIVITIES & CLASSES MANAGEMENT
     ══════════════════════════════════════════════════════════════════════════ -->
<?php
$act_query = new WP_Query( [
    'post_type'      => [ 'activity', 'rs_activity' ],
    'posts_per_page' => -1,
    'post_status'    => [ 'publish', 'draft' ],
    'orderby'        => 'title',
    'order'          => 'ASC',
] );

$categories = get_terms( [
    'taxonomy'   => 'activity_category',
    'hide_empty' => false,
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar">
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:280px; max-width:100%;">
                <input type="text" id="radm-activity-search" class="radm-input" placeholder="Search activities…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <select id="radm-activity-cat-filter" class="radm-select" style="width:180px;">
                <option value="">All Categories</option>
                <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                    <?php foreach ( $categories as $cat ) : ?>
                        <option value="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <select id="radm-activity-inq-filter" class="radm-select" style="width:165px;">
                <option value="">All Inquiries</option>
                <option value="has_inquiries">With Inquiries Only</option>
                <option value="no_inquiries">Zero Inquiries</option>
            </select>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span class="radm-count-label"><strong id="radm-activity-count"><?php echo esc_html( $act_query->found_posts ); ?></strong> Activities Total</span>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmOpenActivityModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add New Activity
            </button>
        </div>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-activities-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:70px;">Image</th>
                    <th>Activity Title</th>
                    <th>Category</th>
                    <th>Batches / Schedule</th>
                    <th>Duration &amp; Frequency</th>
                    <th>Registration</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $act_query->have_posts() ) :
                    $idx = 1;
                    while ( $act_query->have_posts() ) :
                        $act_query->the_post();
                        $aid     = get_the_ID();
                        $title   = get_the_title();
                        $badge   = get_post_meta( $aid, 'badge', true ) ?: 'Regular Batch';
                        $batches = get_post_meta( $aid, 'batches_text', true ) ?: ( get_post_meta( $aid, 'batches', true ) ?: 'Morning & Evening' );
                        $dur     = get_post_meta( $aid, 'duration_text', true ) ?: ( get_post_meta( $aid, 'duration', true ) ?: '60 Mins' );
                        $freq    = get_post_meta( $aid, 'frequency_text', true ) ?: ( get_post_meta( $aid, 'frequency', true ) ?: 'Weekly Schedule' );
                        $elig    = get_post_meta( $aid, 'eligibility_text', true ) ?: ( get_post_meta( $aid, 'eligibility', true ) ?: 'All Age Groups' );
                        $centers = get_post_meta( $aid, 'centers_text', true ) ?: '';
                        $reg_open_meta = get_post_meta( $aid, '_ry_registration_open', true );
                        $is_reg_open   = ( $reg_open_meta === '' || $reg_open_meta === false || $reg_open_meta === '1' || $reg_open_meta === 1 );
                        $content = get_the_content();
                        $img     = get_the_post_thumbnail_url( $aid, 'medium' ) ?: ( get_post_meta( $aid, '_ry_image_url', true ) ?: '' );
                        $att_id  = (int) get_post_thumbnail_id( $aid );
                        $terms   = get_the_terms( $aid, 'activity_category' );
                        $cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'General';
                        $cat_slug = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->slug : '';
                        $cat_id   = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->term_id : 0;
                        $status   = get_post_status( $aid );

                        global $wpdb;
                        $act_slug  = get_post_field( 'post_name', $aid );
                        $inq_count = (int) $wpdb->get_var( $wpdb->prepare(
                            "SELECT COUNT(DISTINCT p.ID) FROM {$wpdb->posts} p
                             INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID 
                             WHERE p.post_type = 'rs_inquiry' AND p.post_status != 'trash'
                               AND (
                                   (pm.meta_key = '_rs_activity' AND (pm.meta_value = %s OR pm.meta_value = %s))
                                   OR (pm.meta_key = '_rs_activity_id' AND pm.meta_value = %d)
                               )",
                            $title,
                            $act_slug,
                            $aid
                        ) );
                        $has_reg_table = $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}ry_registrations'" );
                        $reg_count = 0;
                        if ( $has_reg_table ) {
                            $reg_count = (int) $wpdb->get_var( $wpdb->prepare(
                                "SELECT COUNT(*) FROM {$wpdb->prefix}ry_registrations WHERE activity_id = %d AND status NOT IN ('cancelled','rejected')",
                                $aid
                            ) );
                        }
                        $total_inq = max( $inq_count, $reg_count );
                ?>
                <tr class="radm-activity-row"
                    data-title="<?php echo esc_attr( strtolower( $title ) ); ?>"
                    data-cat="<?php echo esc_attr( $cat_slug ); ?>"
                    data-inquiries="<?php echo esc_attr( $total_inq ); ?>"
                    style="<?php echo $total_inq > 0 ? 'background: #f0fdf4;' : ''; ?>"
                    id="activity-row-<?php echo esc_attr( $aid ); ?>">
                    <td style="color:var(--radm-text-muted); font-size:12px;"><?php echo esc_html( $idx++ ); ?></td>
                    <td>
                        <div style="width:48px; height:48px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border:1px solid var(--radm-border);">
                            <?php if ( $img ) : ?>
                                <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%; height:100%; object-fit:cover;" />
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" style="color:#94a3b8;">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <strong style="font-size:14px; color:var(--radm-text); display:block;"><?php echo esc_html( $title ); ?></strong>
                        <?php if ( $badge ) : ?>
                            <span style="font-size:11.5px; color:var(--radm-green); font-weight:600;"><?php echo esc_html( $badge ); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="radm-branch-badge"><?php echo esc_html( $cat_name ); ?></span>
                    </td>
                    <td>
                        <div style="font-size:12.5px;"><?php echo esc_html( $batches ); ?></div>
                    </td>
                    <td>
                        <div style="font-size:12px; color:var(--radm-text);"><?php echo esc_html( $dur ); ?></div>
                        <div style="font-size:11px; color:var(--radm-text-muted);"><?php echo esc_html( $freq ); ?></div>
                    </td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:4px;">
                            <button type="button" 
                                    class="radm-btn <?php echo $is_reg_open ? 'radm-btn-success' : 'radm-btn-outline'; ?> radm-btn-sm" 
                                    style="padding:3px 10px; font-size:11.5px; display:inline-flex; align-items:center; gap:5px;"
                                    onclick="radmToggleActivityReg(<?php echo esc_attr( $aid ); ?>, this)"
                                    title="Click to toggle Registration open/closed on website">
                                <span class="radm-status-dot" style="display:inline-block; width:7px; height:7px; border-radius:50%; background:<?php echo $is_reg_open ? '#10b981' : '#94a3b8'; ?>;"></span>
                                <span class="reg-label"><?php echo $is_reg_open ? 'Open' : 'Closed'; ?></span>
                            </button>
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=activity-inquiries&activity=' . urlencode( $title ) ) ); ?>" 
                               style="font-size:11.5px; color:<?php echo $total_inq > 0 ? '#047857' : 'var(--radm-text-muted)'; ?>; font-weight:<?php echo $total_inq > 0 ? '700' : '500'; ?>; text-decoration:none;">
                               <?php echo esc_html( $total_inq ); ?> inquiries &rarr;
                            </a>
                        </div>
                    </td>
                    <td>
                        <span class="radm-badge <?php echo $status === 'publish' ? 'radm-badge--green' : 'radm-badge--orange'; ?>">
                            <?php echo esc_html( ucfirst( $status ) ); ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="Edit Activity"
                                    data-activity="<?php echo esc_attr( wp_json_encode( [
                                        'id'                => $aid,
                                        'title'             => $title,
                                        'category_id'       => $cat_id,
                                        'badge'             => $badge,
                                        'content'           => $content,
                                        'batches_text'      => $batches,
                                        'duration_text'     => $dur,
                                        'frequency_text'    => $freq,
                                        'eligibility_text'  => $elig,
                                        'centers_text'      => $centers,
                                        'registration_open' => $is_reg_open ? 1 : 0,
                                        'image_url'         => $img,
                                        'attachment_id'     => $att_id,
                                        'status'            => $status,
                                    ] ) ); ?>"
                                    onclick="radmEditActivity(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Activity"
                                    data-id="<?php echo esc_attr( $aid ); ?>"
                                    data-title="<?php echo esc_attr( $title ); ?>"
                                    data-attachment-id="<?php echo esc_attr( $att_id ); ?>"
                                    onclick="radmPromptDelete(this, '<?php echo esc_attr( addslashes( $title ) ); ?>', 'activity', <?php echo esc_attr( $att_id ); ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding:36px; color:var(--radm-text-muted);">
                        No activities found. Click <strong>+ Add New Activity</strong> to create one.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php elseif ( $section === 'events' ) : ?>
<!-- ══════════════════════════════════════════════════════════════════════════
     SECTION: EVENTS MANAGEMENT
     ══════════════════════════════════════════════════════════════════════════ -->
<?php
$event_query = new WP_Query( [
    'post_type'      => 'event',
    'posts_per_page' => -1,
    'post_status'    => [ 'publish', 'draft' ],
    'orderby'        => 'date',
    'order'          => 'DESC',
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar">
        <div style="display:flex; align-items:center; gap:12px; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:300px; max-width:100%;">
                <input type="text" id="radm-event-search" class="radm-input" placeholder="Search events by name or venue…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span class="radm-count-label"><strong><?php echo esc_html( $event_query->found_posts ); ?></strong> Events Total</span>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmOpenEventModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Create New Event
            </button>
        </div>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-events-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:70px;">Image</th>
                    <th>Event Name</th>
                    <th>Date &amp; Time</th>
                    <th>Venue</th>
                    <th>Registrations</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $event_query->have_posts() ) :
                    $idx = 1;
                    global $wpdb;
                    $reg_table = $wpdb->prefix . 'ry_registrations';
                    while ( $event_query->have_posts() ) :
                        $event_query->the_post();
                        $eid     = get_the_ID();
                        $title   = get_the_title();
                        $date    = get_post_meta( $eid, '_ry_event_date', true ) ?: get_the_date( 'Y-m-d' );
                        $start   = get_post_meta( $eid, '_ry_start_time', true ) ?: '06:00';
                        $end     = get_post_meta( $eid, '_ry_end_time', true ) ?: '08:00';
                        $venue   = get_post_meta( $eid, '_ry_venue', true ) ?: 'Rashtrotthana Central';
                        $reg_open= get_post_meta( $eid, '_ry_registration_open', true );
                        $content = get_the_content();
                        $img     = get_the_post_thumbnail_url( $eid, 'medium' ) ?: ( get_post_meta( $eid, '_ry_image_url', true ) ?: '' );
                        $att_id  = (int) get_post_thumbnail_id( $eid );
                        $status  = get_post_status( $eid );
                        $reg_cnt = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$reg_table} WHERE event_id = %d AND status != 'cancelled'", $eid ) );
                ?>
                <tr class="radm-event-row" data-title="<?php echo esc_attr( strtolower( $title ) ); ?>" id="event-row-<?php echo esc_attr( $eid ); ?>">
                    <td style="color:var(--radm-text-muted); font-size:12px;"><?php echo esc_html( $idx++ ); ?></td>
                    <td>
                        <div style="width:48px; height:48px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border:1px solid var(--radm-border);">
                            <?php if ( $img ) : ?>
                                <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%; height:100%; object-fit:cover;" />
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" style="color:#94a3b8;">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <strong style="font-size:14px; color:var(--radm-text); display:block;"><?php echo esc_html( $title ); ?></strong>
                    </td>
                    <td>
                        <div style="font-size:13px; font-weight:600;"><?php echo esc_html( $date ); ?></div>
                        <div style="font-size:11.5px; color:var(--radm-text-muted);"><?php echo esc_html( $start . ' - ' . $end ); ?></div>
                    </td>
                    <td>
                        <span style="font-size:13px; color:var(--radm-text);"><?php echo esc_html( $venue ); ?></span>
                    </td>
                    <td>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&radm_tab=users&event=' . $eid ) ); ?>"
                           style="display:inline-flex; align-items:center; gap:6px; font-weight:600; color:var(--radm-green); text-decoration:none;">
                            <strong><?php echo esc_html( $reg_cnt ); ?></strong> participants &rarr;
                        </a>
                    </td>
                    <td>
                        <span class="radm-badge <?php echo $status === 'publish' ? 'radm-badge--green' : 'radm-badge--orange'; ?>">
                            <?php echo esc_html( ucfirst( $status ) ); ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="Edit Event"
                                    data-event="<?php echo esc_attr( wp_json_encode( [
                                        'id'                => $eid,
                                        'title'             => $title,
                                        'event_date'        => $date,
                                        'start_time'        => $start,
                                        'end_time'          => $end,
                                        'venue'             => $venue,
                                        'registration_open' => ( $reg_open === '0' || $reg_open === 0 ) ? 0 : 1,
                                        'content'           => $content,
                                        'image_url'         => $img,
                                        'attachment_id'     => $att_id,
                                        'status'            => $status,
                                    ] ) ); ?>"
                                    onclick="radmEditEvent(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Event"
                                    data-id="<?php echo esc_attr( $eid ); ?>"
                                    data-title="<?php echo esc_attr( $title ); ?>"
                                    data-attachment-id="<?php echo esc_attr( $att_id ); ?>"
                                    onclick="radmPromptDelete(this, '<?php echo esc_attr( addslashes( $title ) ); ?>', 'event', <?php echo esc_attr( $att_id ); ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&event_id=' . $eid ) ); ?>"
                               class="radm-btn radm-btn-outline radm-btn-sm" title="View Registrations" style="margin-left:4px;">
                                Registrations
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php elseif ( $section === 'news' ) : ?>
<!-- ══════════════════════════════════════════════════════════════════════════
     SECTION: NEWS & ARTICLES MANAGEMENT
     ══════════════════════════════════════════════════════════════════════════ -->
<?php
$news_query = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => [ 'publish', 'draft' ],
    'orderby'        => 'date',
    'order'          => 'DESC',
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar">
        <div style="display:flex; align-items:center; gap:12px; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:300px; max-width:100%;">
                <input type="text" id="radm-news-search" class="radm-input" placeholder="Search news &amp; press releases…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span class="radm-count-label"><strong><?php echo esc_html( $news_query->found_posts ); ?></strong> Articles Total</span>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmOpenNewsModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add New Article
            </button>
        </div>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-news-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:70px;">Image</th>
                    <th>Article Title</th>
                    <th>Published Date</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $news_query->have_posts() ) :
                    $idx = 1;
                    while ( $news_query->have_posts() ) :
                        $news_query->the_post();
                        $nid     = get_the_ID();
                        $title   = get_the_title();
                        $date    = get_the_date( 'M d, Y' );
                        $author  = get_the_author();
                        $content = get_the_content();
                        $excerpt = get_the_excerpt();
                        $img     = get_the_post_thumbnail_url( $nid, 'medium' ) ?: ( get_post_meta( $nid, '_ry_image_url', true ) ?: '' );
                        $att_id  = (int) get_post_thumbnail_id( $nid );
                        $status  = get_post_status( $nid );
                ?>
                <tr class="radm-news-row" data-title="<?php echo esc_attr( strtolower( $title ) ); ?>" id="news-row-<?php echo esc_attr( $nid ); ?>">
                    <td style="color:var(--radm-text-muted); font-size:12px;"><?php echo esc_html( $idx++ ); ?></td>
                    <td>
                        <div style="width:48px; height:48px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border:1px solid var(--radm-border);">
                            <?php if ( $img ) : ?>
                                <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%; height:100%; object-fit:cover;" />
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" style="color:#94a3b8;">
                                    <path d="M4 22h16a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v16a2 2 0 01-2 2zm0 0a2 2 0 01-2-2v-9c0-1.1.9-2 2-2h2"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <strong style="font-size:14px; color:var(--radm-text); display:block;"><?php echo esc_html( $title ); ?></strong>
                        <?php if ( $excerpt ) : ?>
                            <span style="font-size:12px; color:var(--radm-text-muted); display:block; max-width:400px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                <?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><span style="font-size:13px; color:var(--radm-text);"><?php echo esc_html( $date ); ?></span></td>
                    <td><span style="font-size:12.5px; color:var(--radm-text-muted);"><?php echo esc_html( $author ); ?></span></td>
                    <td>
                        <span class="radm-badge <?php echo $status === 'publish' ? 'radm-badge--green' : 'radm-badge--orange'; ?>">
                            <?php echo esc_html( ucfirst( $status ) ); ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="Edit Article"
                                    data-news="<?php echo esc_attr( wp_json_encode( [
                                        'id'            => $nid,
                                        'title'         => $title,
                                        'content'       => $content,
                                        'excerpt'       => $excerpt,
                                        'image_url'     => $img,
                                        'attachment_id' => $att_id,
                                        'status'        => $status,
                                    ] ) ); ?>"
                                    onclick="radmEditNews(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Article"
                                    data-id="<?php echo esc_attr( $nid ); ?>"
                                    data-title="<?php echo esc_attr( $title ); ?>"
                                    data-attachment-id="<?php echo esc_attr( $att_id ); ?>"
                                    onclick="radmPromptDelete(this, '<?php echo esc_attr( addslashes( $title ) ); ?>', 'post', <?php echo esc_attr( $att_id ); ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php elseif ( $section === 'faqs' ) : ?>
<!-- ══════════════════════════════════════════════════════════════════════════
     SECTION: FAQ QUESTIONS MANAGEMENT
     ══════════════════════════════════════════════════════════════════════════ -->
<?php
$faq_query = new WP_Query( [
    'post_type'      => 'faq',
    'posts_per_page' => -1,
    'post_status'    => [ 'publish', 'draft' ],
    'orderby'        => [ 'menu_order' => 'ASC', 'date' => 'DESC' ],
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar">
        <div style="display:flex; align-items:center; gap:12px; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:300px; max-width:100%;">
                <input type="text" id="radm-faq-search" class="radm-input" placeholder="Search FAQs by question or answer…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span class="radm-count-label"><strong><?php echo esc_html( $faq_query->found_posts ); ?></strong> FAQs Total</span>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmOpenFaqModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add New FAQ
            </button>
        </div>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-faqs-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:30%;">Question</th>
                    <th>Answer</th>
                    <th style="width:80px;">Order</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $faq_query->have_posts() ) :
                    $idx = 1;
                    while ( $faq_query->have_posts() ) :
                        $faq_query->the_post();
                        $fid        = get_the_ID();
                        $question   = get_the_title();
                        $answer     = get_the_content();
                        $menu_order = (int) get_post_field( 'menu_order', $fid );
                        $status     = get_post_status( $fid );
                ?>
                <tr class="radm-faq-row" data-title="<?php echo esc_attr( strtolower( $question . ' ' . wp_strip_all_tags( $answer ) ) ); ?>" id="faq-row-<?php echo esc_attr( $fid ); ?>">
                    <td style="color:var(--radm-text-muted); font-size:12px;"><?php echo esc_html( $idx++ ); ?></td>
                    <td>
                        <strong style="font-size:13.5px; color:var(--radm-text); display:block;"><?php echo esc_html( $question ); ?></strong>
                    </td>
                    <td>
                        <div style="font-size:12.5px; color:var(--radm-text-muted); max-width:420px; line-height:1.5;">
                            <?php echo esc_html( wp_trim_words( wp_strip_all_tags( $answer ), 24, '…' ) ); ?>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:12.5px; font-weight:600;"><?php echo esc_html( $menu_order ); ?></span>
                    </td>
                    <td>
                        <span class="radm-badge <?php echo $status === 'publish' ? 'radm-badge--green' : 'radm-badge--orange'; ?>">
                            <?php echo esc_html( ucfirst( $status ) ); ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="Edit FAQ"
                                    data-faq="<?php echo esc_attr( wp_json_encode( [
                                        'id'         => $fid,
                                        'title'      => $question,
                                        'content'    => $answer,
                                        'menu_order' => $menu_order,
                                        'status'     => $status,
                                    ] ) ); ?>"
                                    onclick="radmEditFaq(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete FAQ"
                                    data-id="<?php echo esc_attr( $fid ); ?>"
                                    data-title="<?php echo esc_attr( $question ); ?>"
                                    onclick="radmPromptDelete(this, '<?php echo esc_attr( addslashes( $question ) ); ?>', 'faq')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:36px; color:var(--radm-text-muted);">
                        No FAQs found. Click <strong>+ Add New FAQ</strong> to create one.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php elseif ( $section === 'inquiries' ) : ?>
<!-- ══════════════════════════════════════════════════════════════════════════
     SECTION: CONTACT FORM INQUIRIES
     ══════════════════════════════════════════════════════════════════════════ -->
<?php
$inq_query = new WP_Query( [
    'post_type'      => 'rs_inquiry',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => [
        'relation' => 'OR',
        [
            'key'     => '_rs_activity',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => '_rs_activity',
            'value'   => '',
            'compare' => '=',
        ],
    ],
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar">
        <div style="display:flex; align-items:center; gap:12px; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:300px; max-width:100%;">
                <input type="text" id="radm-inq-search" class="radm-input" placeholder="Search inquiries by name, email or message…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
        </div>
        <span class="radm-count-label"><strong><?php echo esc_html( $inq_query->found_posts ); ?></strong> Contact Inquiries Received</span>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-inquiries-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email &amp; Phone</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $inq_query->have_posts() ) :
                    $idx = 1;
                    while ( $inq_query->have_posts() ) :
                        $inq_query->the_post();
                        $iid     = get_the_ID();
                        $date    = get_the_date( 'M d, Y H:i' );
                        $name    = get_post_meta( $iid, 'inquiry_name', true ) ?: ( get_post_meta( $iid, '_rs_name', true ) ?: get_the_title() );
                        $email   = get_post_meta( $iid, 'inquiry_email', true ) ?: get_post_meta( $iid, '_rs_email', true );
                        $phone   = get_post_meta( $iid, 'inquiry_phone', true ) ?: get_post_meta( $iid, '_rs_phone', true );
                        $subj    = get_post_meta( $iid, 'inquiry_subject', true ) ?: 'General Inquiry';
                        $msg     = get_the_content();
                ?>
                <tr class="radm-inquiry-row" data-title="<?php echo esc_attr( strtolower( $name . ' ' . $email . ' ' . $subj . ' ' . $msg ) ); ?>" id="inq-row-<?php echo esc_attr( $iid ); ?>">
                    <td style="color:var(--radm-text-muted); font-size:12px;"><?php echo esc_html( $idx++ ); ?></td>
                    <td><span style="font-size:12.5px; color:var(--radm-text-muted);"><?php echo esc_html( $date ); ?></span></td>
                    <td><strong style="font-size:13.5px; color:var(--radm-text);"><?php echo esc_html( $name ); ?></strong></td>
                    <td>
                        <div style="font-size:13px;"><a href="mailto:<?php echo esc_attr( $email ); ?>" style="color:var(--radm-green);"><?php echo esc_html( $email ); ?></a></div>
                        <?php if ( $phone ) : ?>
                            <div style="font-size:11.5px; color:var(--radm-text-muted);"><?php echo esc_html( $phone ); ?></div>
                        <?php endif; ?>
                    </td>
                    <td><span class="radm-branch-badge"><?php echo esc_html( $subj ); ?></span></td>
                    <td>
                        <div style="font-size:12.5px; color:var(--radm-text-muted); max-width:320px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            <?php echo esc_html( wp_strip_all_tags( $msg ) ); ?>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="View Full Message"
                                    onclick='radmViewInquiry(<?php echo wp_json_encode( [
                                        'name'    => $name,
                                        'email'   => $email,
                                        'phone'   => $phone,
                                        'subject' => $subj,
                                        'date'    => $date,
                                        'message' => $msg,
                                    ] ); ?>)'>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Inquiry"
                                    onclick="radmPromptDelete(<?php echo esc_attr( $iid ); ?>, 'Inquiry from <?php echo esc_attr( addslashes( $name ) ); ?>', 'inquiry')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:36px; color:var(--radm-text-muted);">
                        No contact inquiries received yet.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php elseif ( $section === 'activity-inquiries' ) : ?>
<!-- ══════════════════════════════════════════════════════════════════════════
     SECTION: ACTIVITY REGISTRATIONS & PROGRAM ENQUIRIES
     ══════════════════════════════════════════════════════════════════════════ -->
<?php
$filter_act = sanitize_text_field( $_GET['activity'] ?? '' );
$filter_cen = sanitize_text_field( $_GET['center'] ?? '' );

$act_meta_query = [
    'relation' => 'AND',
];
if ( ! empty( $filter_act ) ) {
    $act_meta_query[] = [
        'relation' => 'OR',
        [
            'key'     => '_rs_activity',
            'value'   => $filter_act,
            'compare' => '=',
        ],
        [
            'key'     => '_rs_activity',
            'value'   => $filter_act,
            'compare' => 'LIKE',
        ],
        [
            'key'     => '_rs_event_title',
            'value'   => $filter_act,
            'compare' => 'LIKE',
        ],
    ];
} else {
    $act_meta_query[] = [
        'relation' => 'OR',
        [
            'key'     => '_rs_activity',
            'value'   => '',
            'compare' => '!=',
        ],
        [
            'key'     => '_rs_event_id',
            'value'   => '',
            'compare' => '!=',
        ],
    ];
}
if ( ! empty( $filter_cen ) ) {
    $act_meta_query[] = [
        'key'     => '_rs_center',
        'value'   => $filter_cen,
        'compare' => 'LIKE',
    ];
}

$act_inq_query = new WP_Query( [
    'post_type'      => 'rs_inquiry',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => $act_meta_query,
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar" style="flex-wrap:wrap; gap:12px;">
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:260px; max-width:100%;">
                <input type="text" id="radm-actinq-search" class="radm-input" placeholder="Search student name, phone, email…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>

            <!-- Activity Dropdown Filter -->
            <div style="display:flex; align-items:center; gap:6px;">
                <label for="radm-actinq-filter-activity" style="font-size:12px; font-weight:600; color:var(--radm-text-muted);">Activity:</label>
                <select id="radm-actinq-filter-activity" class="radm-select" style="font-size:13px; max-width:240px;" onchange="radmFilterActInquiries()">
                    <option value="">All Activities</option>
                    <?php foreach ( $all_activities_list as $act_obj ) : ?>
                        <option value="<?php echo esc_attr( $act_obj->post_title ); ?>" <?php selected( $filter_act, $act_obj->post_title ); ?>>
                            <?php echo esc_html( $act_obj->post_title ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Center Dropdown Filter -->
            <div style="display:flex; align-items:center; gap:6px;">
                <label for="radm-actinq-filter-center" style="font-size:12px; font-weight:600; color:var(--radm-text-muted);">Center:</label>
                <select id="radm-actinq-filter-center" class="radm-select" style="font-size:13px; max-width:200px;" onchange="radmFilterActInquiries()">
                    <option value="">All Centers</option>
                    <?php foreach ( $all_centers_list as $cen_obj ) : ?>
                        <option value="<?php echo esc_attr( $cen_obj->post_title ); ?>" <?php selected( $filter_cen, $cen_obj->post_title ); ?>>
                            <?php echo esc_html( $cen_obj->post_title ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if ( ! empty( $filter_act ) || ! empty( $filter_cen ) ) : ?>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=activity-inquiries' ) ); ?>" class="radm-btn radm-btn-outline radm-btn-sm" style="font-size:12px; color:#ef4444; border-color:#fca5a5;">
                    ✕ Clear Filter
                </a>
            <?php endif; ?>
        </div>

        <span class="radm-count-label"><strong><?php echo esc_html( $act_inq_query->found_posts ); ?></strong> Registrations</span>
    </div>

    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-activity-inquiries-table">
            <thead>
                <tr>
                    <th style="width:45px;">#</th>
                    <th>Date</th>
                    <th>Student Name</th>
                    <th>Contact</th>
                    <th>Activity Program</th>
                    <th>Center / Branch</th>
                    <th>Timing</th>
                    <th>Notes</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $act_inq_query->have_posts() ) :
                    $idx = 1;
                    while ( $act_inq_query->have_posts() ) :
                        $act_inq_query->the_post();
                        $aid     = get_the_ID();
                        $date    = get_the_date( 'M d, Y H:i' );
                        $s_name  = get_post_meta( $aid, '_rs_student_name', true ) ?: ( get_post_meta( $aid, 'inquiry_name', true ) ?: get_the_title() );
                        $s_phone = get_post_meta( $aid, '_rs_student_phone', true ) ?: get_post_meta( $aid, 'inquiry_phone', true );
                        $s_email = get_post_meta( $aid, '_rs_student_email', true ) ?: get_post_meta( $aid, 'inquiry_email', true );
                        $s_act   = get_post_meta( $aid, '_rs_activity', true ) ?: ( get_post_meta( $aid, '_rs_event_title', true ) ?: 'Program Enrollment' );
                        $s_cen   = get_post_meta( $aid, '_rs_center', true ) ?: 'All Centers';
                        $s_time  = get_post_meta( $aid, '_rs_timing', true ) ?: 'Flexible';
                        $content = get_the_content();
                ?>
                <tr class="radm-actinq-row" 
                    data-title="<?php echo esc_attr( strtolower( $s_name . ' ' . $s_phone . ' ' . $s_email . ' ' . $s_act . ' ' . $s_cen ) ); ?>"
                    data-act="<?php echo esc_attr( $s_act ); ?>"
                    data-cen="<?php echo esc_attr( $s_cen ); ?>"
                    id="actinq-row-<?php echo esc_attr( $aid ); ?>">
                    <td style="color:var(--radm-text-muted); font-size:12px;"><?php echo esc_html( $idx++ ); ?></td>
                    <td><span style="font-size:12.5px; color:var(--radm-text-muted);"><?php echo esc_html( $date ); ?></span></td>
                    <td><strong style="font-size:13.5px; color:var(--radm-text);"><?php echo esc_html( $s_name ); ?></strong></td>
                    <td>
                        <?php if ( $s_phone ) : ?>
                            <div style="font-size:13px; font-weight:600;"><a href="tel:<?php echo esc_attr( $s_phone ); ?>" style="color:var(--radm-text); text-decoration:none;">📞 <?php echo esc_html( $s_phone ); ?></a></div>
                        <?php endif; ?>
                        <?php if ( $s_email ) : ?>
                            <div style="font-size:12px;"><a href="mailto:<?php echo esc_attr( $s_email ); ?>" style="color:var(--radm-green);"><?php echo esc_html( $s_email ); ?></a></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="radm-badge radm-badge--green" style="font-weight:600;">
                            <?php echo esc_html( $s_act ); ?>
                        </span>
                    </td>
                    <td><span class="radm-branch-badge"><?php echo esc_html( $s_cen ); ?></span></td>
                    <td><span style="font-size:12.5px; color:var(--radm-text);"><?php echo esc_html( $s_time ); ?></span></td>
                    <td>
                        <div style="font-size:12px; color:var(--radm-text-muted); max-width:240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            <?php echo esc_html( wp_strip_all_tags( $content ) ); ?>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="View Full Registration"
                                    onclick='radmViewActivityInquiry(<?php echo wp_json_encode( [
                                        'name'     => $s_name,
                                        'phone'    => $s_phone,
                                        'email'    => $s_email,
                                        'activity' => $s_act,
                                        'center'   => $s_cen,
                                        'timing'   => $s_time,
                                        'date'     => $date,
                                        'notes'    => $content,
                                    ] ); ?>)'>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Registration"
                                    onclick="radmPromptDelete(<?php echo esc_attr( $aid ); ?>, 'Registration from <?php echo esc_attr( addslashes( $s_name ) ); ?>', 'inquiry')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <tr>
                    <td colspan="9" style="text-align:center; padding:36px; color:var(--radm-text-muted);">
                        No activity registrations received yet.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: ADD / EDIT CENTER
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-center-modal" aria-hidden="true">
    <div class="radm-modal" style="max-width: 600px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 id="radm-center-modal-title" style="margin:0; font-size:17px; font-weight:700;">Add New Center</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <form id="radm-center-form" onsubmit="radmSubmitCenter(event)">
            <input type="hidden" id="center-id" name="post_id" value="0" />
            <input type="hidden" id="center-attachment-id" name="attachment_id" value="0" />
            <input type="hidden" id="center-old-attachment-id" name="old_attachment_id" value="0" />
            
            <div class="radm-modal-body" style="padding:22px 24px; overflow-y:auto; max-height:70vh; display:flex; flex-direction:column; gap:16px;">
                <div class="radm-form-group">
                    <label class="radm-label" for="center-name">Center Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="center-name" name="post_title" class="radm-input" placeholder="e.g. Sadashivnagar Center" required />
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="center-area">Area / Locality</label>
                        <input type="text" id="center-area" name="area" class="radm-input" placeholder="e.g. Sadashivnagar" />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="center-zone">Zone</label>
                        <select id="center-zone" name="zone" class="radm-select">
                            <option value="South Bengaluru">South Bengaluru</option>
                            <option value="North Bengaluru">North Bengaluru</option>
                            <option value="West Bengaluru">West Bengaluru</option>
                            <option value="East Bengaluru">East Bengaluru</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="center-phone">Contact Phone</label>
                        <input type="text" id="center-phone" name="phone" class="radm-input" placeholder="e.g. +91 94801 23456" />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="center-email">Email Address</label>
                        <input type="email" id="center-email" name="email" class="radm-input" placeholder="e.g. center@rashtrotthana.org" />
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="center-hours">Operating Timings / Hours</label>
                    <input type="text" id="center-hours" name="hours" class="radm-input" placeholder="e.g. Morning 06:00 - 10:00 AM | Evening 05:00 - 08:30 PM" />
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="center-address">Full Address</label>
                    <textarea id="center-address" name="address" class="radm-textarea" rows="2" placeholder="Street address, landmark, PIN code…"></textarea>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="center-map-url">Google Maps Directions URL</label>
                    <input type="url" id="center-map-url" name="map_url" class="radm-input" placeholder="https://maps.app.goo.gl/..." />
                </div>

                <!-- Offered Activities / Programs Multi-select -->
                <div class="radm-form-group">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <label class="radm-label" style="margin-bottom:0;">Offered Activities / Programs <small style="font-weight:400; color:var(--radm-text-muted);">(Select multiple)</small></label>
                        <button type="button" id="center-toggle-all-acts-btn" onclick="radmToggleAllCenterActs()" style="background:none; border:none; color:var(--radm-green); font-size:12px; font-weight:600; cursor:pointer; text-decoration:underline;">
                            Select All Activities
                        </button>
                    </div>

                    <!-- Selected Activities Pills Display -->
                    <div id="center-activities-pills" style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:8px;"></div>

                    <!-- Multi-select Dropdown Trigger -->
                    <div class="radm-multiselect-wrap" id="center-activities-ms-wrap" style="position:relative;">
                        <button type="button" class="radm-multiselect-btn radm-input" id="center-activities-ms-btn" onclick="radmToggleCenterActsDropdown()" style="display:flex; justify-content:space-between; align-items:center; text-align:left; cursor:pointer; font-size:13px; background:#fff;">
                            <span id="center-activities-ms-label" style="color:var(--radm-text-muted);">Choose Activities offered at this Center…</span>
                            <span style="font-size:10px; color:#64748b;">▼</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="radm-multiselect-dropdown" id="center-activities-ms-dropdown" style="display:none; position:absolute; top:100%; left:0; right:0; z-index:60; background:#fff; border:1px solid var(--radm-border); border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.12); padding:8px; max-height:240px; overflow-y:auto; margin-top:4px;">
                            <div style="margin-bottom:6px; padding:2px;">
                                <input type="text" id="center-acts-search-box" class="radm-input" placeholder="Search activities..." style="font-size:12px; padding:5px 8px;" oninput="radmFilterCenterActsList(this.value)" />
                            </div>
                            <div class="radm-ms-options-list" id="center-acts-options-list">
                                <?php foreach ( $all_activities_list as $act_item ) : ?>
                                    <label class="radm-ms-item center-act-opt" style="display:flex; align-items:center; gap:8px; padding:6px 8px; border-radius:6px; cursor:pointer; font-size:13px;" data-title="<?php echo esc_attr( strtolower( $act_item->post_title ) ); ?>">
                                        <input type="checkbox" name="activities[]" class="center-act-cb" value="<?php echo esc_attr( $act_item->post_title ); ?>" data-name="<?php echo esc_attr( $act_item->post_title ); ?>" onchange="radmOnCenterActCbChange()" />
                                        <span><?php echo esc_html( $act_item->post_title ); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="center-ig">Instagram URL</label>
                        <input type="url" id="center-ig" name="instagram_url" class="radm-input" placeholder="https://instagram.com/..." />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="center-fb">Facebook URL</label>
                        <input type="url" id="center-fb" name="facebook_url" class="radm-input" placeholder="https://facebook.com/..." />
                    </div>
                </div>

                <!-- Center Image Selection -->
                <div class="radm-form-group">
                    <label class="radm-label">Featured Image</label>
                    <input type="hidden" id="center-image-url" name="image_url" value="" />
                    <div class="radm-image-selector-wrap" id="center-image-picker-box">
                        <div id="center-img-preview" class="radm-image-preview-card" style="display:none;">
                            <img src="" alt="Center Preview" />
                            <div class="radm-image-preview-details">
                                <div class="radm-image-preview-name">Selected Center Image</div>
                                <div class="radm-image-preview-url"></div>
                            </div>
                            <button type="button" class="radm-btn-remove-img" onclick="radmClearSelectedImage('center-image-url', 'center-attachment-id', 'center-img-preview')">✕ Remove</button>
                        </div>
                        <div class="radm-image-action-buttons">
                            <button type="button" class="radm-btn radm-btn-primary" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmUploadFromLocal('center-image-url', 'center-attachment-id', 'center-img-preview', 'center-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Upload from Local
                            </button>
                            <button type="button" class="radm-btn radm-btn-outline" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmOpenDbMediaPicker('center-image-url', 'center-attachment-id', 'center-img-preview', 'center-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Choose from Database
                            </button>
                        </div>
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="center-status">Status</label>
                    <select id="center-status" name="post_status" class="radm-select">
                        <option value="publish">Published (Visible on site)</option>
                        <option value="draft">Draft (Hidden)</option>
                    </select>
                </div>
            </div>

            <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" class="radm-btn radm-btn-outline" onclick="radmCloseModals()">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="center-save-btn">Save Center</button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: ADD / EDIT ACTIVITY
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-activity-modal" aria-hidden="true">
    <div class="radm-modal" style="max-width: 600px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 id="radm-activity-modal-title" style="margin:0; font-size:17px; font-weight:700;">Add New Activity</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <form id="radm-activity-form" onsubmit="radmSubmitActivity(event)">
            <input type="hidden" id="act-id" name="post_id" value="0" />
            <input type="hidden" id="act-attachment-id" name="attachment_id" value="0" />
            <input type="hidden" id="act-old-attachment-id" name="old_attachment_id" value="0" />

            <div class="radm-modal-body" style="padding:22px 24px; overflow-y:auto; max-height:70vh; display:flex; flex-direction:column; gap:16px;">
                <div class="radm-form-group">
                    <label class="radm-label" for="act-name">Activity Title <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="act-name" name="post_title" class="radm-input" placeholder="e.g. Yoga for Beginners (Sarala Yoga)" required />
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-cat">Category</label>
                        <select id="act-cat" name="category_id" class="radm-select">
                            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                                <?php foreach ( $categories as $cat ) : ?>
                                    <option value="<?php echo esc_attr( $cat->term_id ); ?>"><?php echo esc_html( $cat->name ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-badge">Badge Label</label>
                        <input type="text" id="act-badge" name="badge" class="radm-input" placeholder="e.g. Certified Program / Regular Batch" />
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="act-content">Activity Description</label>
                    <textarea id="act-content" name="content" class="radm-textarea" rows="3" placeholder="Overview of the program, benefits, syllabus…"></textarea>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-batches">Batches / Timing Text</label>
                        <input type="text" id="act-batches" name="batches_text" class="radm-input" placeholder="e.g. Morning & Evening Batches" />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-duration">Duration</label>
                        <input type="text" id="act-duration" name="duration_text" class="radm-input" placeholder="e.g. 60 Mins / Class" />
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-frequency">Frequency</label>
                        <input type="text" id="act-frequency" name="frequency_text" class="radm-input" placeholder="e.g. Mon to Fri / 3 Days a Week" />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-eligibility">Eligibility</label>
                        <input type="text" id="act-eligibility" name="eligibility_text" class="radm-input" placeholder="e.g. 14+ Years / All Age Groups" />
                    </div>
                </div>

                <div class="radm-form-group">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <label class="radm-label" style="margin-bottom:0;">Available Centers <small style="font-weight:400; color:var(--radm-text-muted);">(Select multiple)</small></label>
                        <button type="button" id="act-toggle-all-centers-btn" onclick="radmToggleAllActCenters()" style="background:none; border:none; color:var(--radm-green); font-size:12px; font-weight:600; cursor:pointer; text-decoration:underline;">
                            Select All Centers
                        </button>
                    </div>

                    <!-- Selected Centers Pills Display -->
                    <div id="act-centers-pills" style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:8px;"></div>

                    <!-- Multi-select Dropdown Trigger -->
                    <div class="radm-multiselect-wrap" id="act-centers-ms-wrap" style="position:relative;">
                        <button type="button" class="radm-multiselect-btn radm-input" id="act-centers-ms-btn" onclick="radmToggleActCentersDropdown()" style="display:flex; justify-content:space-between; align-items:center; text-align:left; cursor:pointer; font-size:13px; background:#fff;">
                            <span id="act-centers-ms-label" style="color:var(--radm-text);">Available across all Bangalore Centers</span>
                            <span style="font-size:10px; color:#64748b;">▼</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="radm-multiselect-dropdown" id="act-centers-ms-dropdown" style="display:none; position:absolute; top:100%; left:0; right:0; z-index:60; background:#fff; border:1px solid var(--radm-border); border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.12); padding:8px; max-height:240px; overflow-y:auto; margin-top:4px;">
                            <div style="margin-bottom:6px; padding:2px;">
                                <input type="text" id="act-centers-search-box" class="radm-input" placeholder="Search centers..." style="font-size:12px; padding:5px 8px;" oninput="radmFilterActCentersList(this.value)" />
                            </div>
                            <div style="border-bottom:1px solid var(--radm-border); padding-bottom:6px; margin-bottom:6px;">
                                <label class="radm-ms-item" style="display:flex; align-items:center; gap:8px; padding:6px 8px; border-radius:6px; cursor:pointer; font-size:13px; font-weight:600; background:#f0fdf4; color:#166534;">
                                    <input type="checkbox" id="act-center-all-cb" value="Available across all Bangalore Centers" onchange="radmOnActAllCentersCbChange(this)" />
                                    <span>All Bangalore Centers (Available Everywhere)</span>
                                </label>
                            </div>
                            <div class="radm-ms-options-list" id="act-centers-options-list">
                                <?php foreach ( $all_centers_list as $cen ) : ?>
                                    <label class="radm-ms-item act-center-opt" style="display:flex; align-items:center; gap:8px; padding:6px 8px; border-radius:6px; cursor:pointer; font-size:13px;" data-title="<?php echo esc_attr( strtolower( $cen->post_title ) ); ?>">
                                        <input type="checkbox" class="act-center-cb" value="<?php echo esc_attr( $cen->post_title . ' Center' ); ?>" data-name="<?php echo esc_attr( $cen->post_title ); ?>" onchange="radmOnActCenterCbChange()" />
                                        <span><?php echo esc_html( $cen->post_title ); ?> Center</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <input type="text" id="act-centers" name="centers_text" class="radm-input" value="Available across all Bangalore Centers" style="display:none; margin-top:8px;" />
                </div>

                <!-- Activity Image Selection -->
                <div class="radm-form-group">
                    <label class="radm-label">Featured Image</label>
                    <input type="hidden" id="act-image-url" name="image_url" value="" />
                    <div class="radm-image-selector-wrap" id="act-image-picker-box">
                        <div id="act-img-preview" class="radm-image-preview-card" style="display:none;">
                            <img src="" alt="Activity Preview" />
                            <div class="radm-image-preview-details">
                                <div class="radm-image-preview-name">Selected Activity Image</div>
                                <div class="radm-image-preview-url"></div>
                            </div>
                            <button type="button" class="radm-btn-remove-img" onclick="radmClearSelectedImage('act-image-url', 'act-attachment-id', 'act-img-preview')">✕ Remove</button>
                        </div>
                        <div class="radm-image-action-buttons">
                            <button type="button" class="radm-btn radm-btn-primary" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmUploadFromLocal('act-image-url', 'act-attachment-id', 'act-img-preview', 'act-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Upload from Local
                            </button>
                            <button type="button" class="radm-btn radm-btn-outline" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmOpenDbMediaPicker('act-image-url', 'act-attachment-id', 'act-img-preview', 'act-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Choose from Database
                            </button>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-reg-open">Registration Open?</label>
                        <select id="act-reg-open" name="registration_open" class="radm-select">
                            <option value="1">Yes (Registration Open)</option>
                            <option value="0">No (Registration Closed)</option>
                        </select>
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="act-status">Status</label>
                        <select id="act-status" name="post_status" class="radm-select">
                            <option value="publish">Published (Visible on site)</option>
                            <option value="draft">Draft (Hidden)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" class="radm-btn radm-btn-outline" onclick="radmCloseModals()">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="act-save-btn">Save Activity</button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: ADD / EDIT NEWS ARTICLE
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-news-modal" aria-hidden="true">
    <div class="radm-modal" style="max-width: 600px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 id="radm-news-modal-title" style="margin:0; font-size:17px; font-weight:700;">Add News Article</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <form id="radm-news-form" onsubmit="radmSubmitNews(event)">
            <input type="hidden" id="news-id" name="post_id" value="0" />
            <input type="hidden" id="news-attachment-id" name="attachment_id" value="0" />
            <input type="hidden" id="news-old-attachment-id" name="old_attachment_id" value="0" />

            <div class="radm-modal-body" style="padding:22px 24px; overflow-y:auto; max-height:70vh; display:flex; flex-direction:column; gap:16px;">
                <div class="radm-form-group">
                    <label class="radm-label" for="news-title">Article Title <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="news-title" name="post_title" class="radm-input" placeholder="e.g. Annual Yoga Convocation Successfully Completed" required />
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="news-excerpt">Short Summary / Excerpt</label>
                    <textarea id="news-excerpt" name="excerpt" class="radm-textarea" rows="2" placeholder="Brief 1-2 sentence preview…"></textarea>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="news-content">Article Content</label>
                    <textarea id="news-content" name="content" class="radm-textarea" rows="6" placeholder="Full announcement or press release body…"></textarea>
                </div>

                <!-- News Image Selection -->
                <div class="radm-form-group">
                    <label class="radm-label">Featured Image</label>
                    <input type="hidden" id="news-image-url" name="image_url" value="" />
                    <div class="radm-image-selector-wrap" id="news-image-picker-box">
                        <div id="news-img-preview" class="radm-image-preview-card" style="display:none;">
                            <img src="" alt="News Preview" />
                            <div class="radm-image-preview-details">
                                <div class="radm-image-preview-name">Selected News Image</div>
                                <div class="radm-image-preview-url"></div>
                            </div>
                            <button type="button" class="radm-btn-remove-img" onclick="radmClearSelectedImage('news-image-url', 'news-attachment-id', 'news-img-preview')">✕ Remove</button>
                        </div>
                        <div class="radm-image-action-buttons">
                            <button type="button" class="radm-btn radm-btn-primary" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmUploadFromLocal('news-image-url', 'news-attachment-id', 'news-img-preview', 'news-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Upload from Local
                            </button>
                            <button type="button" class="radm-btn radm-btn-outline" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmOpenDbMediaPicker('news-image-url', 'news-attachment-id', 'news-img-preview', 'news-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Choose from Database
                            </button>
                        </div>
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="news-status">Status</label>
                    <select id="news-status" name="post_status" class="radm-select">
                        <option value="publish">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" class="radm-btn radm-btn-outline" onclick="radmCloseModals()">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="news-save-btn">Save Article</button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: ADD / EDIT EVENT
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-event-modal" aria-hidden="true">
    <div class="radm-modal" style="max-width: 600px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 id="radm-event-modal-title" style="margin:0; font-size:17px; font-weight:700;">Add New Event</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <form id="radm-event-form" onsubmit="radmSubmitEvent(event)">
            <input type="hidden" id="event-id" name="post_id" value="0" />
            <input type="hidden" id="event-attachment-id" name="attachment_id" value="0" />
            <input type="hidden" id="event-old-attachment-id" name="old_attachment_id" value="0" />

            <div class="radm-modal-body" style="padding:22px 24px; overflow-y:auto; max-height:70vh; display:flex; flex-direction:column; gap:16px;">
                <div class="radm-form-group">
                    <label class="radm-label" for="event-title">Event Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="event-title" name="post_title" class="radm-input" placeholder="e.g. International Yoga Day 2025" required />
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="event-date">Event Date <span style="color:#ef4444;">*</span></label>
                        <input type="date" id="event-date" name="event_date" class="radm-input" required />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="event-venue-select">Venue / Location</label>
                        <select id="event-venue-select" class="radm-select" onchange="radmOnVenueSelectChange(this)">
                            <option value="">-- Choose Center / Venue --</option>
                            <?php foreach ( $all_centers_list as $cen ) : ?>
                                <option value="<?php echo esc_attr( $cen->post_title . ' Center' ); ?>"><?php echo esc_html( $cen->post_title ); ?> Center</option>
                            <?php endforeach; ?>
                            <option value="__custom__">Other / Custom Venue…</option>
                        </select>
                        <input type="text" id="event-venue" name="venue" class="radm-input" placeholder="e.g. Jayanagar Central Yogashala" style="display:none; margin-top:8px;" />
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="event-start">Start Time</label>
                        <input type="time" id="event-start" name="start_time" class="radm-input" value="06:00" />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="event-end">End Time</label>
                        <input type="time" id="event-end" name="end_time" class="radm-input" value="08:00" />
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="event-desc">Description</label>
                    <textarea id="event-desc" name="content" class="radm-textarea" rows="3" placeholder="Overview of the event, schedule, highlights…"></textarea>
                </div>

                <!-- Event Image Selection -->
                <div class="radm-form-group">
                    <label class="radm-label">Featured Image / Banner</label>
                    <input type="hidden" id="event-image-url" name="image_url" value="" />
                    <div class="radm-image-selector-wrap" id="event-image-picker-box">
                        <div id="event-img-preview" class="radm-image-preview-card" style="display:none;">
                            <img src="" alt="Event Preview" />
                            <div class="radm-image-preview-details">
                                <div class="radm-image-preview-name">Selected Event Banner</div>
                                <div class="radm-image-preview-url"></div>
                            </div>
                            <button type="button" class="radm-btn-remove-img" onclick="radmClearSelectedImage('event-image-url', 'event-attachment-id', 'event-img-preview')">✕ Remove</button>
                        </div>
                        <div class="radm-image-action-buttons">
                            <button type="button" class="radm-btn radm-btn-primary" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmUploadFromLocal('event-image-url', 'event-attachment-id', 'event-img-preview', 'event-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Upload from Local
                            </button>
                            <button type="button" class="radm-btn radm-btn-outline" style="font-size:12.5px; padding:7px 14px; display:inline-flex; align-items:center; gap:6px;" onclick="radmOpenDbMediaPicker('event-image-url', 'event-attachment-id', 'event-img-preview', 'event-old-attachment-id')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Choose from Database
                            </button>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="event-reg-open">Registrations Open?</label>
                        <select id="event-reg-open" name="registration_open" class="radm-select">
                            <option value="1">Yes (Open)</option>
                            <option value="0">No (Closed)</option>
                        </select>
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="event-status">Status</label>
                        <select id="event-status" name="post_status" class="radm-select">
                            <option value="publish">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" class="radm-btn radm-btn-outline" onclick="radmCloseModals()">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="event-save-btn">Save Event</button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: ADD / EDIT FAQ
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-faq-modal" aria-hidden="true">
    <div class="radm-modal" style="max-width: 560px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 id="radm-faq-modal-title" style="margin:0; font-size:17px; font-weight:700;">Add FAQ Question</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <form id="radm-faq-form" onsubmit="radmSubmitFaq(event)">
            <input type="hidden" id="faq-id" name="post_id" value="0" />

            <div class="radm-modal-body" style="padding:22px 24px; overflow-y:auto; max-height:70vh; display:flex; flex-direction:column; gap:16px;">
                <div class="radm-form-group">
                    <label class="radm-label" for="faq-question">Question <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="faq-question" name="post_title" class="radm-input" placeholder="e.g. What are the timings for beginner yoga classes?" required />
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="faq-answer">Answer <span style="color:#ef4444;">*</span></label>
                    <textarea id="faq-answer" name="content" class="radm-textarea" rows="5" placeholder="Provide a helpful and clear answer for visitors…" required></textarea>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="faq-order">Display Order</label>
                        <input type="number" id="faq-order" name="menu_order" class="radm-input" value="0" min="0" placeholder="0" />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label" for="faq-status">Status</label>
                        <select id="faq-status" name="post_status" class="radm-select">
                            <option value="publish">Published (Visible on site)</option>
                            <option value="draft">Draft (Hidden)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" class="radm-btn radm-btn-outline" onclick="radmCloseModals()">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="faq-save-btn">Save FAQ</button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: VIEW INQUIRY DETAILS
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-inquiry-modal" aria-hidden="true">
    <div class="radm-modal" style="max-width: 520px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; font-size:17px; font-weight:700;">Inquiry Details</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <div class="radm-modal-body" style="padding:22px 24px; display:flex; flex-direction:column; gap:14px;">
            <div>
                <span style="font-size:12px; color:var(--radm-text-muted);">From:</span>
                <strong id="inq-modal-name" style="font-size:15px; color:var(--radm-text); display:block;"></strong>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Email:</span>
                    <div id="inq-modal-email" style="font-size:13px; color:var(--radm-green); font-weight:600;"></div>
                </div>
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Phone:</span>
                    <div id="inq-modal-phone" style="font-size:13px; color:var(--radm-text);"></div>
                </div>
            </div>
            <div>
                <span style="font-size:12px; color:var(--radm-text-muted);">Subject / Center:</span>
                <div id="inq-modal-subj" style="font-size:13px; font-weight:600;"></div>
            </div>
            <div>
                <span style="font-size:12px; color:var(--radm-text-muted);">Submitted On:</span>
                <div id="inq-modal-date" style="font-size:12px; color:var(--radm-text-muted);"></div>
            </div>
            <div>
                <span style="font-size:12px; color:var(--radm-text-muted);">Message:</span>
                <div id="inq-modal-msg" style="padding:14px; background:#f8fafc; border:1px solid var(--radm-border); border-radius:8px; font-size:13.5px; line-height:1.6; color:var(--radm-text); white-space:pre-wrap; margin-top:4px;"></div>
            </div>
        </div>
        <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:flex-end;">
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmCloseModals()">Close</button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: VIEW ACTIVITY REGISTRATION DETAILS
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-activity-inquiry-modal" aria-hidden="true">
    <div class="radm-modal" style="max-width: 540px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; font-size:17px; font-weight:700;">Student Registration Details</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <div class="radm-modal-body" style="padding:22px 24px; display:flex; flex-direction:column; gap:14px;">
            <div>
                <span style="font-size:12px; color:var(--radm-text-muted);">Student Name:</span>
                <strong id="act-modal-name" style="font-size:16px; color:var(--radm-text); display:block;"></strong>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Phone Number:</span>
                    <div id="act-modal-phone" style="font-size:13.5px; font-weight:600; color:var(--radm-text);"></div>
                </div>
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Email Address:</span>
                    <div id="act-modal-email" style="font-size:13px; color:var(--radm-green); font-weight:600;"></div>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Program / Activity:</span>
                    <div id="act-modal-activity" style="font-size:13.5px; font-weight:600; color:#15803d;"></div>
                </div>
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Selected Center:</span>
                    <div id="act-modal-center" style="font-size:13px; font-weight:600;"></div>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Preferred Timing:</span>
                    <div id="act-modal-timing" style="font-size:13px; color:var(--radm-text);"></div>
                </div>
                <div>
                    <span style="font-size:12px; color:var(--radm-text-muted);">Submitted On:</span>
                    <div id="act-modal-date" style="font-size:12px; color:var(--radm-text-muted);"></div>
                </div>
            </div>
            <div>
                <span style="font-size:12px; color:var(--radm-text-muted);">Student Notes / Details:</span>
                <div id="act-modal-notes" style="padding:14px; background:#f8fafc; border:1px solid var(--radm-border); border-radius:8px; font-size:13px; line-height:1.6; color:var(--radm-text); white-space:pre-wrap; margin-top:4px;"></div>
            </div>
        </div>
        <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <div id="act-modal-whatsapp-wrap"></div>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmCloseModals()">Close</button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: DELETE CONFIRMATION
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-delete-modal" aria-hidden="true">
    <div class="radm-modal radm-modal--sm" style="max-width:440px;">
        <div class="radm-modal-header" style="padding:18px 24px; border-bottom:1px solid var(--radm-border); display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; font-size:16px; font-weight:700; color:#dc2626;">Confirm Deletion</h3>
            <button type="button" class="radm-icon-btn" onclick="radmCloseModals()" style="border:none;">✕</button>
        </div>
        <div class="radm-modal-body" style="padding:20px 24px;">
            <p style="margin:0; font-size:14px;">Are you sure you want to remove <strong id="delete-target-title">this item</strong>?</p>
            <p style="margin:6px 0 0; font-size:12.5px; color:var(--radm-text-muted);">This action will move it to trash in WordPress.</p>
        </div>
        <div class="radm-modal-footer" style="padding:16px 24px; border-top:1px solid var(--radm-border); display:flex; justify-content:flex-end; gap:12px;">
            <button type="button" class="radm-btn radm-btn-outline" onclick="radmCloseModals()">Cancel</button>
            <button type="button" class="radm-btn radm-btn-primary" id="delete-confirm-btn" style="background:#dc2626; border-color:#dc2626;" onclick="radmExecuteDelete()">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     CLIENT-SIDE INTERACTION CONTROLLER
     ══════════════════════════════════════════════════════════════════════════ -->
<script>
(function() {
    var ajaxUrl = (window.RADMConfig && window.RADMConfig.ajaxUrl) || '/wp-admin/admin-ajax.php';
    var nonce   = (window.RADMConfig && window.RADMConfig.nonce) || '';

    // Search & Filter: Centers
    var cSearch = document.getElementById('radm-center-search');
    var cZone   = document.getElementById('radm-center-zone-filter');
    if (cSearch || cZone) {
        function filterCenters() {
            var q = (cSearch ? cSearch.value : '').toLowerCase().trim();
            var z = (cZone ? cZone.value : '');
            var rows = document.querySelectorAll('.radm-center-row');
            var visible = 0;
            rows.forEach(function(row) {
                var title = row.getAttribute('data-title') || '';
                var area  = row.getAttribute('data-area') || '';
                var zone  = row.getAttribute('data-zone') || '';
                var matchText = !q || title.indexOf(q) !== -1 || area.indexOf(q) !== -1;
                var matchZone = !z || zone === z;
                if (matchText && matchZone) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });
            var cntEl = document.getElementById('radm-center-count');
            if (cntEl) cntEl.textContent = visible;
        }
        if (cSearch) cSearch.addEventListener('input', filterCenters);
        if (cZone) cZone.addEventListener('change', filterCenters);
    }

    // Search & Filter: Activities
    var aSearch = document.getElementById('radm-activity-search');
    var aCat    = document.getElementById('radm-activity-cat-filter');
    var aInq    = document.getElementById('radm-activity-inq-filter');
    if (aSearch || aCat || aInq) {
        function filterActivities() {
            var q = (aSearch ? aSearch.value : '').toLowerCase().trim();
            var c = (aCat ? aCat.value : '');
            var inqVal = (aInq ? aInq.value : '');
            var rows = document.querySelectorAll('.radm-activity-row');
            var visible = 0;
            rows.forEach(function(row) {
                var title = row.getAttribute('data-title') || '';
                var cat   = row.getAttribute('data-cat') || '';
                var inqCnt = parseInt(row.getAttribute('data-inquiries') || '0', 10);
                var matchText = !q || title.indexOf(q) !== -1;
                var matchCat  = !c || cat === c;
                var matchInq  = !inqVal || (inqVal === 'has_inquiries' ? inqCnt > 0 : inqCnt === 0);
                if (matchText && matchCat && matchInq) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });
            var cntEl = document.getElementById('radm-activity-count');
            if (cntEl) cntEl.textContent = visible;
        }
        if (aSearch) aSearch.addEventListener('input', filterActivities);
        if (aCat) aCat.addEventListener('change', filterActivities);
        if (aInq) aInq.addEventListener('change', filterActivities);
    }

    // Search: News
    var nSearch = document.getElementById('radm-news-search');
    if (nSearch) {
        nSearch.addEventListener('input', function() {
            var q = this.value.toLowerCase().trim();
            document.querySelectorAll('.radm-news-row').forEach(function(row) {
                var title = row.getAttribute('data-title') || '';
                row.style.display = (!q || title.indexOf(q) !== -1) ? '' : 'none';
            });
        });
    }

    // Search: FAQs
    var fSearch = document.getElementById('radm-faq-search');
    if (fSearch) {
        fSearch.addEventListener('input', function() {
            var q = this.value.toLowerCase().trim();
            document.querySelectorAll('.radm-faq-row').forEach(function(row) {
                var title = row.getAttribute('data-title') || '';
                row.style.display = (!q || title.indexOf(q) !== -1) ? '' : 'none';
            });
        });
    }

    // Search: Inquiries
    var iSearch = document.getElementById('radm-inq-search');
    if (iSearch) {
        iSearch.addEventListener('input', function() {
            var q = this.value.toLowerCase().trim();
            document.querySelectorAll('.radm-inquiry-row').forEach(function(row) {
                var title = row.getAttribute('data-title') || '';
                row.style.display = (!q || title.indexOf(q) !== -1) ? '' : 'none';
            });
        });
    }

    // Search: Activity Inquiries
    var actInqSearch = document.getElementById('radm-actinq-search');
    if (actInqSearch) {
        actInqSearch.addEventListener('input', function() {
            var q = this.value.toLowerCase().trim();
            document.querySelectorAll('.radm-actinq-row').forEach(function(row) {
                var title = row.getAttribute('data-title') || '';
                row.style.display = (!q || title.indexOf(q) !== -1) ? '' : 'none';
            });
        });
    }

    // Modal Helpers
    window.radmCloseModals = function() {
        document.querySelectorAll('.radm-modal-overlay').forEach(function(m) {
            m.classList.remove('radm-modal-open');
        });
    };

    // Forward radmPickMedia to custom in-portal media picker (No wp.media)
    window.radmPickMedia = function(urlInputId, attachmentInputId, previewId) {
        if (typeof window.radmOpenDbMediaPicker === 'function') {
            window.radmOpenDbMediaPicker(urlInputId, attachmentInputId, previewId, null);
        }
    };

    // Center Modal
    window.radmOpenCenterModal = function() {
        document.getElementById('radm-center-form').reset();
        document.getElementById('center-id').value = '0';
        document.getElementById('center-attachment-id').value = '0';
        document.getElementById('center-old-attachment-id').value = '0';
        document.getElementById('center-image-url').value = '';
        document.getElementById('radm-center-modal-title').textContent = 'Add New Center';
        var prev = document.getElementById('center-img-preview');
        if (prev) prev.style.display = 'none';

        // Reset activities multi-select
        document.querySelectorAll('.center-act-cb').forEach(function(cb) { cb.checked = false; });
        radmRenderCenterActPills([]);
        var actLbl = document.getElementById('center-activities-ms-label');
        if (actLbl) actLbl.textContent = 'Choose Activities offered at this Center…';

        document.getElementById('radm-center-modal').classList.add('radm-modal-open');
    };

    window.radmEditCenter = function(dataOrEl) {
        var data = dataOrEl;
        if (dataOrEl && dataOrEl.nodeType) {
            try {
                data = JSON.parse(dataOrEl.getAttribute('data-center') || dataOrEl.getAttribute('data-json') || '{}');
            } catch(e) {
                console.error('Error parsing center data:', e);
                data = {};
            }
        }
        if (!data) data = {};
        document.getElementById('center-id').value = data.id || '0';
        document.getElementById('center-name').value = data.title || '';
        document.getElementById('center-area').value = data.area || '';
        document.getElementById('center-zone').value = data.zone || 'South Bengaluru';
        document.getElementById('center-phone').value = data.phone || '';
        document.getElementById('center-email').value = data.email || '';
        document.getElementById('center-hours').value = data.hours || '';
        document.getElementById('center-address').value = data.address || '';
        document.getElementById('center-map-url').value = data.map_url || '';
        document.getElementById('center-ig').value = data.instagram_url || '';
        document.getElementById('center-fb').value = data.facebook_url || '';
        document.getElementById('center-image-url').value = data.image_url || '';
        document.getElementById('center-attachment-id').value = data.attachment_id || '0';
        document.getElementById('center-old-attachment-id').value = data.attachment_id || '0';
        document.getElementById('center-status').value = data.status || 'publish';

        // Populate activities
        var acts = Array.isArray(data.activities) ? data.activities : [];
        document.querySelectorAll('.center-act-cb').forEach(function(cb) {
            cb.checked = acts.indexOf(cb.value) !== -1;
        });
        radmRenderCenterActPills(acts);
        var actLbl = document.getElementById('center-activities-ms-label');
        if (actLbl) {
            actLbl.textContent = acts.length > 0 ? (acts.length + ' Activities selected') : 'Choose Activities offered at this Center…';
        }

        var prev = document.getElementById('center-img-preview');
        if (prev) {
            if (data.image_url) {
                prev.style.display = 'flex';
                var img = prev.querySelector('img');
                if (img) img.src = data.image_url;
                var urlEl = prev.querySelector('.radm-image-preview-url');
                if (urlEl) urlEl.textContent = data.image_url;
            } else {
                prev.style.display = 'none';
            }
        }
        document.getElementById('radm-center-modal-title').textContent = 'Edit Center: ' + (data.title || '');
        document.getElementById('radm-center-modal').classList.add('radm-modal-open');
    };

    // Center Activities Multi-Select Helpers
    window.radmToggleCenterActsDropdown = function() {
        var dd = document.getElementById('center-activities-ms-dropdown');
        if (dd) {
            dd.style.display = (dd.style.display === 'none' || !dd.style.display) ? 'block' : 'none';
        }
    };

    window.radmFilterCenterActsList = function(q) {
        var query = (q || '').trim().toLowerCase();
        var items = document.querySelectorAll('.center-act-opt');
        items.forEach(function(item) {
            var title = item.getAttribute('data-title') || '';
            item.style.display = (!query || title.indexOf(query) !== -1) ? 'flex' : 'none';
        });
    };

    window.radmRenderCenterActPills = function(acts) {
        var wrap = document.getElementById('center-activities-pills');
        if (!wrap) return;
        wrap.innerHTML = '';
        if (!acts || !acts.length) return;

        acts.forEach(function(actName) {
            var pill = document.createElement('span');
            pill.className = 'radm-filter-tag';
            pill.style.cssText = 'display:inline-flex; align-items:center; gap:5px; background:#dcfce7; color:#15803d; padding:3px 9px; border-radius:14px; font-size:12px; font-weight:600;';
            pill.innerHTML = '<span>' + actName + '</span><button type="button" style="background:none; border:none; color:#15803d; font-size:13px; cursor:pointer; padding:0; line-height:1;" title="Remove">×</button>';
            pill.querySelector('button').onclick = function() {
                var cb = document.querySelector('.center-act-cb[value="' + CSS.escape(actName) + '"]');
                if (cb) { cb.checked = false; }
                radmOnCenterActCbChange();
            };
            wrap.appendChild(pill);
        });
    };

    window.radmToggleAllCenterActs = function() {
        var cbs = document.querySelectorAll('.center-act-cb');
        var anyUnchecked = Array.prototype.some.call(cbs, function(cb) { return !cb.checked; });
        cbs.forEach(function(cb) { cb.checked = anyUnchecked; });
        radmOnCenterActCbChange();
    };

    window.radmOnCenterActCbChange = function() {
        var cbs = document.querySelectorAll('.center-act-cb');
        var selected = [];
        cbs.forEach(function(cb) {
            if (cb.checked) {
                selected.push(cb.value);
            }
        });
        radmRenderCenterActPills(selected);
        var labelEl = document.getElementById('center-activities-ms-label');
        if (labelEl) {
            labelEl.textContent = selected.length > 0 ? (selected.length + ' Activities selected') : 'Choose Activities offered at this Center…';
        }
    };

    window.radmSubmitCenter = function(e) {
        e.preventDefault();
        var btn = document.getElementById('center-save-btn');
        btn.disabled = true;
        btn.textContent = 'Saving…';

        var oldAtt = parseInt(document.getElementById('center-old-attachment-id').value, 10) || 0;
        var newAtt = parseInt(document.getElementById('center-attachment-id').value, 10) || 0;

        var fd = new FormData(document.getElementById('radm-center-form'));
        fd.append('action', 'radm_save_content_center');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Center';
                if (res.success) {
                    var savedId = res.data.id || 0;
                    radmCloseModals();

                    // Check if previous image was changed and is now an orphan
                    if (oldAtt > 0 && oldAtt !== newAtt && typeof window.radmCheckAndPromptOrphan === 'function') {
                        window.radmCheckAndPromptOrphan(oldAtt, savedId, function() {
                            alert(res.data.message || 'Center saved successfully!');
                            window.location.reload();
                        });
                    } else {
                        alert(res.data.message || 'Center saved successfully!');
                        window.location.reload();
                    }
                } else {
                    alert(res.data.message || 'Error saving center.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Save Center';
                alert('Network error while saving center.');
            });
    };

    // Activity Multi-Select Centers Helpers
    window.radmToggleActCentersDropdown = function() {
        var dd = document.getElementById('act-centers-ms-dropdown');
        if (dd) {
            dd.style.display = (dd.style.display === 'none' || !dd.style.display) ? 'block' : 'none';
        }
    };

    window.radmFilterActCentersList = function(q) {
        var query = (q || '').trim().toLowerCase();
        var items = document.querySelectorAll('.act-center-opt');
        items.forEach(function(item) {
            var title = item.getAttribute('data-title') || '';
            item.style.display = (!query || title.indexOf(query) !== -1) ? 'flex' : 'none';
        });
    };

    window.radmRenderActCenterPills = function(centers) {
        var wrap = document.getElementById('act-centers-pills');
        if (!wrap) return;
        wrap.innerHTML = '';
        if (!centers || !centers.length) return;

        centers.forEach(function(c) {
            var pill = document.createElement('span');
            pill.className = 'radm-filter-tag';
            pill.style.cssText = 'display:inline-flex; align-items:center; gap:5px; background:#e0f2fe; color:#0369a1; padding:3px 9px; border-radius:14px; font-size:12px; font-weight:600;';
            pill.innerHTML = '<span>' + (c.replace(/ Center$/i, '')) + '</span><button type="button" style="background:none; border:none; color:#0369a1; font-size:13px; cursor:pointer; padding:0; line-height:1;" title="Remove">×</button>';
            pill.querySelector('button').onclick = function() {
                var cb = document.querySelector('.act-center-cb[value="' + CSS.escape(c) + '"]');
                if (cb) { cb.checked = false; }
                var allCb = document.getElementById('act-center-all-cb');
                if (allCb) { allCb.checked = false; }
                radmOnActCenterCbChange();
            };
            wrap.appendChild(pill);
        });
    };

    window.radmOnActAllCentersCbChange = function(allCb) {
        var cbs = document.querySelectorAll('.act-center-cb');
        var isAll = allCb.checked;
        cbs.forEach(function(cb) {
            cb.checked = isAll;
        });
        radmOnActCenterCbChange();
    };

    window.radmOnActCenterCbChange = function() {
        var cbs = document.querySelectorAll('.act-center-cb');
        var allCb = document.getElementById('act-center-all-cb');
        var selected = [];
        var total = cbs.length;
        var checkedCount = 0;

        cbs.forEach(function(cb) {
            if (cb.checked) {
                selected.push(cb.value);
                checkedCount++;
            }
        });

        var hiddenInput = document.getElementById('act-centers');
        var labelEl     = document.getElementById('act-centers-ms-label');

        if (checkedCount === total && total > 0) {
            if (allCb) allCb.checked = true;
            if (hiddenInput) hiddenInput.value = 'Available across all Bangalore Centers';
            if (labelEl) labelEl.textContent = 'Available across all Bangalore Centers (' + total + ' Centers)';
            radmRenderActCenterPills(['All Bangalore Centers']);
        } else if (checkedCount === 0) {
            if (allCb) allCb.checked = false;
            if (hiddenInput) hiddenInput.value = '';
            if (labelEl) labelEl.textContent = 'None selected (Click to choose centers)';
            radmRenderActCenterPills([]);
        } else {
            if (allCb) allCb.checked = false;
            if (hiddenInput) hiddenInput.value = selected.join(', ');
            if (labelEl) labelEl.textContent = checkedCount + ' Centers selected';
            radmRenderActCenterPills(selected);
        }
    };

    window.radmToggleAllActCenters = function() {
        var allCb = document.getElementById('act-center-all-cb');
        if (allCb) {
            allCb.checked = !allCb.checked;
            radmOnActAllCentersCbChange(allCb);
        }
    };

    // Close act centers dropdown when clicked outside
    document.addEventListener('click', function(e) {
        var msWrap = document.getElementById('act-centers-ms-wrap');
        var msDropdown = document.getElementById('act-centers-ms-dropdown');
        if (msWrap && msDropdown && !msWrap.contains(e.target)) {
            msDropdown.style.display = 'none';
        }
    });

    window.radmOpenActivityModal = function() {
        document.getElementById('radm-activity-form').reset();
        document.getElementById('act-id').value = '0';
        document.getElementById('act-attachment-id').value = '0';
        document.getElementById('act-old-attachment-id').value = '0';
        document.getElementById('act-image-url').value = '';
        
        // Reset centers to All Bangalore Centers
        var allCb = document.getElementById('act-center-all-cb');
        if (allCb) allCb.checked = true;
        var cbs = document.querySelectorAll('.act-center-cb');
        cbs.forEach(function(cb) { cb.checked = true; });
        radmOnActCenterCbChange();

        if (document.getElementById('act-reg-open')) document.getElementById('act-reg-open').value = '1';
        document.getElementById('radm-activity-modal-title').textContent = 'Add New Activity';
        var prev = document.getElementById('act-img-preview');
        if (prev) prev.style.display = 'none';
        document.getElementById('radm-activity-modal').classList.add('radm-modal-open');
    };

    window.radmEditActivity = function(dataOrEl) {
        var data = dataOrEl;
        if (dataOrEl && dataOrEl.nodeType) {
            try {
                data = JSON.parse(dataOrEl.getAttribute('data-activity') || dataOrEl.getAttribute('data-json') || '{}');
            } catch(e) {
                console.error('Error parsing activity data:', e);
                data = {};
            }
        }
        if (!data) data = {};
        document.getElementById('act-id').value = data.id || '0';
        document.getElementById('act-name').value = data.title || '';
        if (data.category_id) document.getElementById('act-cat').value = data.category_id;
        document.getElementById('act-badge').value = data.badge || '';
        document.getElementById('act-content').value = data.content || '';
        document.getElementById('act-batches').value = data.batches_text || '';
        document.getElementById('act-duration').value = data.duration_text || '';
        document.getElementById('act-frequency').value = data.frequency_text || '';
        document.getElementById('act-eligibility').value = data.eligibility_text || '';
        
        // Multi-select centers sync
        var cVal = (data.centers_text || '').trim();
        var allCb = document.getElementById('act-center-all-cb');
        var cbs = document.querySelectorAll('.act-center-cb');

        if (!cVal || cVal.toLowerCase().indexOf('all bangalore') !== -1 || cVal.toLowerCase().indexOf('all centers') !== -1) {
            if (allCb) allCb.checked = true;
            cbs.forEach(function(cb) { cb.checked = true; });
            radmOnActCenterCbChange();
        } else {
            if (allCb) allCb.checked = false;
            var parts = cVal.split(',').map(function(s) { return s.trim().toLowerCase(); });
            cbs.forEach(function(cb) {
                var v = cb.value.toLowerCase();
                var n = (cb.getAttribute('data-name') || '').toLowerCase();
                var isMatch = parts.some(function(p) {
                    return p === v || p === n || v.indexOf(p) !== -1 || p.indexOf(n) !== -1;
                });
                cb.checked = isMatch;
            });
            radmOnActCenterCbChange();
        }

        if (document.getElementById('act-reg-open')) document.getElementById('act-reg-open').value = (data.registration_open === 0 || data.registration_open === '0') ? '0' : '1';
        document.getElementById('act-image-url').value = data.image_url || '';
        document.getElementById('act-attachment-id').value = data.attachment_id || '0';
        document.getElementById('act-old-attachment-id').value = data.attachment_id || '0';
        document.getElementById('act-status').value = data.status || 'publish';

        var prev = document.getElementById('act-img-preview');
        if (prev) {
            if (data.image_url) {
                prev.style.display = 'flex';
                var img = prev.querySelector('img');
                if (img) img.src = data.image_url;
                var urlEl = prev.querySelector('.radm-image-preview-url');
                if (urlEl) urlEl.textContent = data.image_url;
            } else {
                prev.style.display = 'none';
            }
        }
        document.getElementById('radm-activity-modal-title').textContent = 'Edit Activity: ' + (data.title || '');
        document.getElementById('radm-activity-modal').classList.add('radm-modal-open');
    };

    window.radmSubmitActivity = function(e) {
        e.preventDefault();
        var btn = document.getElementById('act-save-btn');
        btn.disabled = true;
        btn.textContent = 'Saving…';

        var oldAtt = parseInt(document.getElementById('act-old-attachment-id').value, 10) || 0;
        var newAtt = parseInt(document.getElementById('act-attachment-id').value, 10) || 0;

        var fd = new FormData(document.getElementById('radm-activity-form'));
        fd.append('action', 'radm_save_activity');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Activity';
                if (res.success) {
                    var savedId = res.data.id || 0;
                    radmCloseModals();

                    // Check if previous image was changed and is now an orphan
                    if (oldAtt > 0 && oldAtt !== newAtt && typeof window.radmCheckAndPromptOrphan === 'function') {
                        window.radmCheckAndPromptOrphan(oldAtt, savedId, function() {
                            alert(res.data.message || 'Activity saved successfully!');
                            window.location.reload();
                        });
                    } else {
                        alert(res.data.message || 'Activity saved successfully!');
                        window.location.reload();
                    }
                } else {
                    alert(res.data.message || 'Error saving activity.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Save Activity';
                alert('Network error while saving activity.');
            });
    };

    // News Modal
    window.radmOpenNewsModal = function() {
        document.getElementById('radm-news-form').reset();
        document.getElementById('news-id').value = '0';
        document.getElementById('news-attachment-id').value = '0';
        document.getElementById('news-old-attachment-id').value = '0';
        document.getElementById('news-image-url').value = '';
        document.getElementById('radm-news-modal-title').textContent = 'Add News Article';
        var prev = document.getElementById('news-img-preview');
        if (prev) prev.style.display = 'none';
        document.getElementById('radm-news-modal').classList.add('radm-modal-open');
    };

    window.radmEditNews = function(dataOrEl) {
        var data = dataOrEl;
        if (dataOrEl && dataOrEl.nodeType) {
            try {
                data = JSON.parse(dataOrEl.getAttribute('data-news') || dataOrEl.getAttribute('data-json') || '{}');
            } catch(e) {
                console.error('Error parsing news data:', e);
                data = {};
            }
        }
        if (!data) data = {};
        document.getElementById('news-id').value = data.id || '0';
        document.getElementById('news-title').value = data.title || '';
        document.getElementById('news-excerpt').value = data.excerpt || '';
        document.getElementById('news-content').value = data.content || '';
        document.getElementById('news-image-url').value = data.image_url || '';
        document.getElementById('news-attachment-id').value = data.attachment_id || '0';
        document.getElementById('news-old-attachment-id').value = data.attachment_id || '0';
        document.getElementById('news-status').value = data.status || 'publish';

        var prev = document.getElementById('news-img-preview');
        if (prev) {
            if (data.image_url) {
                prev.style.display = 'flex';
                var img = prev.querySelector('img');
                if (img) img.src = data.image_url;
                var urlEl = prev.querySelector('.radm-image-preview-url');
                if (urlEl) urlEl.textContent = data.image_url;
            } else {
                prev.style.display = 'none';
            }
        }
        document.getElementById('radm-news-modal-title').textContent = 'Edit Article: ' + (data.title || '');
        document.getElementById('radm-news-modal').classList.add('radm-modal-open');
    };

    window.radmSubmitNews = function(e) {
        e.preventDefault();
        var btn = document.getElementById('news-save-btn');
        btn.disabled = true;
        btn.textContent = 'Saving…';

        var oldAtt = parseInt(document.getElementById('news-old-attachment-id').value, 10) || 0;
        var newAtt = parseInt(document.getElementById('news-attachment-id').value, 10) || 0;

        var fd = new FormData(document.getElementById('radm-news-form'));
        fd.append('action', 'radm_save_post');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Article';
                if (res.success) {
                    var savedId = res.data.id || 0;
                    radmCloseModals();

                    // Check if previous image was changed and is now an orphan
                    if (oldAtt > 0 && oldAtt !== newAtt && typeof window.radmCheckAndPromptOrphan === 'function') {
                        window.radmCheckAndPromptOrphan(oldAtt, savedId, function() {
                            alert(res.data.message || 'Article saved successfully!');
                            window.location.reload();
                        });
                    } else {
                        alert(res.data.message || 'Article saved successfully!');
                        window.location.reload();
                    }
                } else {
                    alert(res.data.message || 'Error saving article.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Save Article';
                alert('Network error while saving article.');
            });
    };

    // Toggle Activity Registration Quick Action
    window.radmToggleActivityReg = function(actId, btn) {
        var dot = btn.querySelector('.radm-status-dot');
        var lbl = btn.querySelector('.reg-label');
        btn.disabled = true;

        var fd = new FormData();
        fd.append('action', 'radm_toggle_activity_registration');
        fd.append('nonce', nonce);
        fd.append('post_id', actId);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                if (res.success) {
                    var isOpen = res.data.open === 1;
                    if (isOpen) {
                        btn.className = 'radm-btn radm-btn-success radm-btn-sm';
                        if (dot) dot.style.background = '#10b981';
                        if (lbl) lbl.textContent = 'Open';
                    } else {
                        btn.className = 'radm-btn radm-btn-outline radm-btn-sm';
                        if (dot) dot.style.background = '#94a3b8';
                        if (lbl) lbl.textContent = 'Closed';
                    }
                    radmToast(res.data.message || 'Status updated!', 'success');
                } else {
                    alert(res.data.message || 'Error updating registration.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                alert('Network error while toggling registration.');
            });
    };

    // Event Modal Controllers
    window.radmOnVenueSelectChange = function(sel) {
        var customInput = document.getElementById('event-venue');
        if (sel.value === '__custom__') {
            customInput.style.display = 'block';
            customInput.value = '';
            customInput.focus();
        } else {
            customInput.style.display = 'none';
            customInput.value = sel.value;
        }
    };

    window.radmOpenEventModal = function() {
        document.getElementById('radm-event-form').reset();
        document.getElementById('event-id').value = '0';
        document.getElementById('event-attachment-id').value = '0';
        document.getElementById('event-old-attachment-id').value = '0';
        document.getElementById('event-image-url').value = '';
        var venueSel = document.getElementById('event-venue-select');
        if (venueSel) venueSel.selectedIndex = 0;
        var venueInput = document.getElementById('event-venue');
        if (venueInput) { venueInput.value = ''; venueInput.style.display = 'none'; }
        document.getElementById('radm-event-modal-title').textContent = 'Add New Event';
        var prev = document.getElementById('event-img-preview');
        if (prev) prev.style.display = 'none';
        document.getElementById('radm-event-modal').classList.add('radm-modal-open');
    };

    function radmFormatTime24(t) {
        if (!t) return '';
        var m = String(t).trim().match(/^(\d{1,2}):(\d{2})\s*(AM|PM)?$/i);
        if (!m) return t;
        var h = parseInt(m[1], 10);
        var min = m[2];
        var ampm = (m[3] || '').toUpperCase();
        if (ampm === 'PM' && h < 12) h += 12;
        if (ampm === 'AM' && h === 12) h = 0;
        return (h < 10 ? '0' : '') + h + ':' + min;
    }

    window.radmEditEvent = function(dataOrEl) {
        var data = dataOrEl;
        if (dataOrEl && dataOrEl.nodeType) {
            try {
                data = JSON.parse(dataOrEl.getAttribute('data-event') || dataOrEl.getAttribute('data-json') || '{}');
            } catch(e) {
                console.error('Error parsing event data:', e);
                data = {};
            }
        }
        if (!data) data = {};

        var idEl = document.getElementById('event-id');
        if (idEl) idEl.value = data.id || '0';
        var titleEl = document.getElementById('event-title');
        if (titleEl) titleEl.value = data.title || '';
        var dateEl = document.getElementById('event-date');
        if (dateEl) dateEl.value = data.event_date || '';
        var startEl = document.getElementById('event-start');
        if (startEl) startEl.value = radmFormatTime24(data.start_time) || '06:00';
        var endEl = document.getElementById('event-end');
        if (endEl) endEl.value = radmFormatTime24(data.end_time) || '08:00';

        var venueSel = document.getElementById('event-venue-select');
        var venueInput = document.getElementById('event-venue');
        var vVal = data.venue || '';
        if (venueSel) {
            var found = false;
            for (var i = 0; i < venueSel.options.length; i++) {
                if (venueSel.options[i].value === vVal) {
                    venueSel.selectedIndex = i;
                    found = true;
                    break;
                }
            }
            if (found) {
                if (venueInput) { venueInput.value = vVal; venueInput.style.display = 'none'; }
            } else if (vVal) {
                venueSel.value = '__custom__';
                if (venueInput) { venueInput.value = vVal; venueInput.style.display = 'block'; }
            } else {
                venueSel.selectedIndex = 0;
                if (venueInput) { venueInput.value = ''; venueInput.style.display = 'none'; }
            }
        } else if (venueInput) {
            venueInput.value = vVal;
        }

        var regOpenEl = document.getElementById('event-reg-open');
        if (regOpenEl) regOpenEl.value = (data.registration_open === 0 || data.registration_open === '0') ? '0' : '1';
        var descEl = document.getElementById('event-desc');
        if (descEl) descEl.value = data.content || '';
        var imgUrlEl = document.getElementById('event-image-url');
        if (imgUrlEl) imgUrlEl.value = data.image_url || '';
        var attEl = document.getElementById('event-attachment-id');
        if (attEl) attEl.value = data.attachment_id || '0';
        var oldAttEl = document.getElementById('event-old-attachment-id');
        if (oldAttEl) oldAttEl.value = data.attachment_id || '0';
        var statEl = document.getElementById('event-status');
        if (statEl) statEl.value = data.status || 'publish';

        var prev = document.getElementById('event-img-preview');
        if (prev) {
            if (data.image_url) {
                prev.style.display = 'flex';
                var img = prev.querySelector('img');
                if (img) img.src = data.image_url;
                var urlEl = prev.querySelector('.radm-image-preview-url');
                if (urlEl) urlEl.textContent = data.image_url;
            } else {
                prev.style.display = 'none';
            }
        }
        var modalTitleEl = document.getElementById('radm-event-modal-title');
        if (modalTitleEl) modalTitleEl.textContent = 'Edit Event: ' + (data.title || '');
        var modalEl = document.getElementById('radm-event-modal');
        if (modalEl) modalEl.classList.add('radm-modal-open');
    };

    window.radmSubmitEvent = function(e) {
        e.preventDefault();
        var btn = document.getElementById('event-save-btn');
        btn.disabled = true;
        btn.textContent = 'Saving…';

        var oldAtt = parseInt(document.getElementById('event-old-attachment-id').value, 10) || 0;
        var newAtt = parseInt(document.getElementById('event-attachment-id').value, 10) || 0;

        var fd = new FormData(document.getElementById('radm-event-form'));
        fd.append('action', 'radm_save_content_event');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Event';
                if (res.success) {
                    var savedId = res.data.id || 0;
                    radmCloseModals();

                    if (oldAtt > 0 && oldAtt !== newAtt && typeof window.radmCheckAndPromptOrphan === 'function') {
                        window.radmCheckAndPromptOrphan(oldAtt, savedId, function() {
                            alert(res.data.message || 'Event saved successfully!');
                            window.location.reload();
                        });
                    } else {
                        alert(res.data.message || 'Event saved successfully!');
                        window.location.reload();
                    }
                } else {
                    alert(res.data.message || 'Error saving event.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Save Event';
                alert('Network error while saving event.');
            });
    };

    // FAQ Modal Controllers
    window.radmOpenFaqModal = function() {
        document.getElementById('radm-faq-form').reset();
        document.getElementById('faq-id').value = '0';
        document.getElementById('radm-faq-modal-title').textContent = 'Add FAQ Question';
        document.getElementById('radm-faq-modal').classList.add('radm-modal-open');
    };

    window.radmEditFaq = function(dataOrEl) {
        var data = dataOrEl;
        if (dataOrEl && dataOrEl.nodeType) {
            try {
                data = JSON.parse(dataOrEl.getAttribute('data-faq') || dataOrEl.getAttribute('data-json') || '{}');
            } catch(e) {
                console.error('Error parsing FAQ data:', e);
                data = {};
            }
        }
        if (!data) data = {};
        document.getElementById('faq-id').value = data.id || '0';
        document.getElementById('faq-question').value = data.title || '';
        document.getElementById('faq-answer').value = data.content || '';
        document.getElementById('faq-order').value = data.menu_order || '0';
        document.getElementById('faq-status').value = data.status || 'publish';
        document.getElementById('radm-faq-modal-title').textContent = 'Edit FAQ Question';
        document.getElementById('radm-faq-modal').classList.add('radm-modal-open');
    };

    window.radmSubmitFaq = function(e) {
        e.preventDefault();
        var btn = document.getElementById('faq-save-btn');
        btn.disabled = true;
        btn.textContent = 'Saving…';

        var fd = new FormData(document.getElementById('radm-faq-form'));
        fd.append('action', 'radm_save_faq');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save FAQ';
                if (res.success) {
                    radmCloseModals();
                    alert(res.data.message || 'FAQ saved successfully!');
                    window.location.reload();
                } else {
                    alert(res.data.message || 'Error saving FAQ.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Save FAQ';
                alert('Network error while saving FAQ.');
            });
    };

    // Inquiry View Modal
    window.radmViewInquiry = function(data) {
        document.getElementById('inq-modal-name').textContent = data.name || '';
        document.getElementById('inq-modal-email').textContent = data.email || '';
        document.getElementById('inq-modal-phone').textContent = data.phone || 'N/A';
        document.getElementById('inq-modal-subj').textContent = data.subject || 'General Inquiry';
        document.getElementById('inq-modal-date').textContent = data.date || '';
        document.getElementById('inq-modal-msg').textContent = data.message || '';
        document.getElementById('radm-inquiry-modal').classList.add('radm-modal-open');
    };

    // Activity Registration View Modal
    window.radmViewActivityInquiry = function(data) {
        document.getElementById('act-modal-name').textContent = data.name || '';
        document.getElementById('act-modal-phone').innerHTML = data.phone ? ('<a href="tel:' + encodeURIComponent(data.phone) + '" style="color:var(--radm-text); text-decoration:none;">📞 ' + data.phone + '</a>') : 'N/A';
        document.getElementById('act-modal-email').innerHTML = data.email ? ('<a href="mailto:' + encodeURIComponent(data.email) + '" style="color:var(--radm-green);">' + data.email + '</a>') : 'N/A';
        document.getElementById('act-modal-activity').textContent = data.activity || '';
        document.getElementById('act-modal-center').textContent = data.center || 'All Centers';
        document.getElementById('act-modal-timing').textContent = data.timing || 'Flexible';
        document.getElementById('act-modal-date').textContent = data.date || '';
        document.getElementById('act-modal-notes').textContent = data.notes || 'No special notes or medical requirements provided.';

        var waWrap = document.getElementById('act-modal-whatsapp-wrap');
        if (waWrap) {
            if (data.phone) {
                var cleanPhone = data.phone.replace(/[^0-9]/g, '');
                if (cleanPhone.length === 10) cleanPhone = '91' + cleanPhone;
                var waMsg = encodeURIComponent('Namaste ' + (data.name || '') + ', greetings from Rashtrotthana Yoga regarding your inquiry for ' + (data.activity || 'yoga classes') + '!');
                waWrap.innerHTML = '<a href="https://wa.me/' + cleanPhone + '?text=' + waMsg + '" target="_blank" class="radm-btn radm-btn-success" style="font-size:12.5px; padding:6px 14px; display:inline-flex; align-items:center; gap:6px; text-decoration:none;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>' +
                    'Chat on WhatsApp</a>';
            } else {
                waWrap.innerHTML = '';
            }
        }

        document.getElementById('radm-activity-inquiry-modal').classList.add('radm-modal-open');
    };

    // Filter Activity Inquiries on dropdown change
    window.radmFilterActInquiries = function() {
        var actEl = document.getElementById('radm-actinq-filter-activity');
        var cenEl = document.getElementById('radm-actinq-filter-center');
        var act = actEl ? actEl.value : '';
        var cen = cenEl ? cenEl.value : '';
        var url = 'admin.php?page=radm-pages&section=activity-inquiries';
        if (act) url += '&activity=' + encodeURIComponent(act);
        if (cen) url += '&center=' + encodeURIComponent(cen);
        window.location.href = url;
    };

    // Generic Delete Controller
    var activeDeleteId = 0;
    var activeDeleteType = '';
    var activeDeleteAttachmentId = 0;

    window.radmPromptDelete = function(idOrEl, title, type, attachmentId) {
        if (idOrEl && idOrEl.nodeType) {
            activeDeleteId = parseInt(idOrEl.getAttribute('data-id'), 10) || 0;
            activeDeleteType = type || idOrEl.getAttribute('data-type') || 'item';
            activeDeleteAttachmentId = parseInt(idOrEl.getAttribute('data-att-id') || idOrEl.getAttribute('data-attachment-id'), 10) || 0;
            var t = idOrEl.getAttribute('data-title') || title || 'this item';
            var titleEl = document.getElementById('delete-target-title');
            if (titleEl) titleEl.textContent = t;
        } else {
            activeDeleteId = parseInt(idOrEl, 10) || 0;
            activeDeleteType = type || '';
            activeDeleteAttachmentId = parseInt(attachmentId, 10) || 0;
            var titleEl = document.getElementById('delete-target-title');
            if (titleEl) titleEl.textContent = title || 'this item';
        }
        var delModal = document.getElementById('radm-delete-modal');
        if (delModal) delModal.classList.add('radm-modal-open');
    };

    window.radmExecuteDelete = function() {
        if (!activeDeleteId || !activeDeleteType) return;
        var btn = document.getElementById('delete-confirm-btn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Deleting…';
        }

        var deletedAttId = activeDeleteAttachmentId;
        var actionName = (activeDeleteType === 'center') ? 'radm_delete_content_center' : ('radm_delete_' + activeDeleteType);
        var fd = new FormData();
        fd.append('action', actionName);
        fd.append('nonce', nonce);
        fd.append('post_id', activeDeleteId);
        fd.append('event_id', activeDeleteId);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Yes, Delete';
                radmCloseModals();
                if (res.success) {
                    var row = document.getElementById(activeDeleteType + '-row-' + activeDeleteId);
                    if (row) row.remove();

                    if (deletedAttId > 0 && typeof window.radmCheckAndPromptOrphan === 'function') {
                        window.radmCheckAndPromptOrphan(deletedAttId, 0, function() {
                            alert(res.data.message || 'Item removed successfully.');
                        });
                    } else {
                        alert(res.data.message || 'Item removed successfully.');
                    }
                } else {
                    alert(res.data.message || 'Error removing item.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Yes, Delete';
                radmCloseModals();
                alert('Network error while deleting item.');
            });
    };
})();
</script>

<?php radm_portal_footer(); ?>

