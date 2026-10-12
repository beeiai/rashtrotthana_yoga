<?php
/**
 * Content Pages Module — Rashtrotthana Admin Portal
 * 100% In-Portal Management for Centers, Activities, Events, News, and Inquiries.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$section = sanitize_key( $_GET['section'] ?? 'centers' );
if ( ! in_array( $section, [ 'centers', 'activities', 'events', 'news', 'inquiries' ], true ) ) {
    $section = 'centers';
}

// Counts for tabs
$count_centers    = (int) wp_count_posts( 'rs_center' )->publish;
$count_activities = (int) wp_count_posts( 'activity' )->publish;
if ( $count_activities === 0 ) {
    $count_activities = (int) wp_count_posts( 'rs_activity' )->publish;
}
$count_events    = (int) wp_count_posts( 'event' )->publish;
$count_news      = (int) wp_count_posts( 'post' )->publish;
$count_inquiries = (int) wp_count_posts( 'rs_inquiry' )->publish;

$titles = [
    'centers'    => [ 'Centers Management', 'Add, edit, or customize Rashtrotthana branch locations & details.' ],
    'activities' => [ 'Activities & Classes', 'Manage yoga programs, schedules, batches, and activities.' ],
    'events'     => [ 'Events Management', 'Create and oversee upcoming campus events & masterclasses.' ],
    'news'       => [ 'News & Press Releases', 'Publish updates, news announcements, and articles.' ],
    'inquiries'  => [ 'Contact Form Inquiries', 'View and respond to inquiries submitted by visitors.' ],
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
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=inquiries' ) ); ?>"
           class="radm-tab<?php echo $section === 'inquiries' ? ' active' : ''; ?>">
            ✉️ Inquiries (<?php echo esc_html( $count_inquiries ); ?>)
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
                + Add New Center
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
                    <th>Directions Link</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( $centers_query->have_posts() ) :
                    $idx = 1;
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
                        $status  = get_post_status( $cid );
                        $status_label = $status === 'publish' ? 'Published' : 'Draft';
                        $status_class = $status === 'publish' ? 'radm-badge--green' : 'radm-badge--orange';
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
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="Edit Center"
                                    onclick='radmEditCenter(<?php echo wp_json_encode( [
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
                                        'status'        => $status,
                                    ] ); ?>)'>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Center"
                                    onclick="radmPromptDelete(<?php echo esc_attr( $cid ); ?>, '<?php echo esc_attr( addslashes( $title ) ); ?>', 'center')">
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
            <select id="radm-activity-cat-filter" class="radm-select" style="width:200px;">
                <option value="">All Categories</option>
                <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                    <?php foreach ( $categories as $cat ) : ?>
                        <option value="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span class="radm-count-label"><strong id="radm-activity-count"><?php echo esc_html( $act_query->found_posts ); ?></strong> Activities Total</span>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmOpenActivityModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                + Add New Activity
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
                        $content = get_the_content();
                        $img     = get_the_post_thumbnail_url( $aid, 'medium' ) ?: ( get_post_meta( $aid, '_ry_image_url', true ) ?: '' );
                        $terms   = get_the_terms( $aid, 'activity_category' );
                        $cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'General';
                        $cat_slug = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->slug : '';
                        $cat_id   = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->term_id : 0;
                        $status   = get_post_status( $aid );
                ?>
                <tr class="radm-activity-row"
                    data-title="<?php echo esc_attr( strtolower( $title ) ); ?>"
                    data-cat="<?php echo esc_attr( $cat_slug ); ?>"
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
                        <span class="radm-badge <?php echo $status === 'publish' ? 'radm-badge--green' : 'radm-badge--orange'; ?>">
                            <?php echo esc_html( ucfirst( $status ) ); ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="radm-action-group" style="justify-content:flex-end;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit" title="Edit Activity"
                                    onclick='radmEditActivity(<?php echo wp_json_encode( [
                                        'id'               => $aid,
                                        'title'            => $title,
                                        'category_id'      => $cat_id,
                                        'badge'            => $badge,
                                        'content'          => $content,
                                        'batches_text'     => $batches,
                                        'duration_text'    => $dur,
                                        'frequency_text'   => $freq,
                                        'eligibility_text' => $elig,
                                        'centers_text'     => $centers,
                                        'image_url'        => $img,
                                        'status'           => $status,
                                    ] ); ?>)'>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Activity"
                                    onclick="radmPromptDelete(<?php echo esc_attr( $aid ); ?>, '<?php echo esc_attr( addslashes( $title ) ); ?>', 'activity')">
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
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&radm_view=create' ) ); ?>" class="radm-btn radm-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                + Create New Event
            </a>
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
                        $img     = get_the_post_thumbnail_url( $eid, 'medium' ) ?: ( get_post_meta( $eid, '_ry_image_url', true ) ?: '' );
                        $status  = get_post_status( $eid );
                        $reg_cnt = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$reg_table} WHERE event_id = %d AND status != 'cancelled'", $eid ) );
                ?>
                <tr class="radm-event-row" data-title="<?php echo esc_attr( strtolower( $title ) ); ?>">
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
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&event_id=' . $eid ) ); ?>"
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
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&event_id=' . $eid ) ); ?>"
                               class="radm-btn radm-btn-outline radm-btn-sm" title="View Registrations">
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
                + Add New Article
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
                        $img     = get_the_post_thumbnail_url( $nid, 'medium' ) ?: '';
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
                                    onclick='radmEditNews(<?php echo wp_json_encode( [
                                        'id'        => $nid,
                                        'title'     => $title,
                                        'content'   => $content,
                                        'excerpt'   => $excerpt,
                                        'image_url' => $img,
                                        'status'    => $status,
                                    ] ); ?>)'>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete" title="Delete Article"
                                    onclick="radmPromptDelete(<?php echo esc_attr( $nid ); ?>, '<?php echo esc_attr( addslashes( $title ) ); ?>', 'post')">
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
] );
?>

<div class="radm-card">
    <div class="radm-table-toolbar">
        <div style="display:flex; align-items:center; gap:12px; flex:1;">
            <div class="radm-search-wrap" style="position:relative; width:300px; max-width:100%;">
                <input type="text" id="radm-inq-search" class="radm-input" placeholder="Search inquiries by name or email…" style="padding-left:36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:12px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
        </div>
        <span class="radm-count-label"><strong><?php echo esc_html( $inq_query->found_posts ); ?></strong> Inquiries Received</span>
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
                        $subj    = get_post_meta( $iid, 'inquiry_subject', true ) ?: ( get_post_meta( $iid, '_rs_center', true ) ?: 'General Inquiry' );
                        $msg     = get_the_content();
                ?>
                <tr class="radm-inquiry-row" data-title="<?php echo esc_attr( strtolower( $name . ' ' . $email ) ); ?>" id="inq-row-<?php echo esc_attr( $iid ); ?>">
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
                    <div style="display:flex; align-items:center; gap:12px;">
                        <input type="text" id="center-image-url" name="image_url" class="radm-input" placeholder="Image URL or choose from library…" style="flex:1;" />
                        <button type="button" class="radm-btn radm-btn-outline" onclick="radmPickMedia('center-image-url', 'center-attachment-id', 'center-img-preview')">
                            Choose Image
                        </button>
                    </div>
                    <div id="center-img-preview" style="margin-top:8px; display:none;">
                        <img src="" style="max-height:90px; border-radius:6px; border:1px solid var(--radm-border);" />
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
                    <label class="radm-label" for="act-centers">Available Centers</label>
                    <input type="text" id="act-centers" name="centers_text" class="radm-input" placeholder="e.g. Available across all Bangalore Centers" />
                </div>

                <!-- Activity Image Selection -->
                <div class="radm-form-group">
                    <label class="radm-label">Featured Image</label>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <input type="text" id="act-image-url" name="image_url" class="radm-input" placeholder="Image URL or select from library…" style="flex:1;" />
                        <button type="button" class="radm-btn radm-btn-outline" onclick="radmPickMedia('act-image-url', 'act-attachment-id', 'act-img-preview')">
                            Choose Image
                        </button>
                    </div>
                    <div id="act-img-preview" style="margin-top:8px; display:none;">
                        <img src="" style="max-height:90px; border-radius:6px; border:1px solid var(--radm-border);" />
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="act-status">Status</label>
                    <select id="act-status" name="post_status" class="radm-select">
                        <option value="publish">Published (Visible on site)</option>
                        <option value="draft">Draft (Hidden)</option>
                    </select>
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

                <div class="radm-form-group">
                    <label class="radm-label">Featured Image</label>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <input type="text" id="news-image-url" name="image_url" class="radm-input" placeholder="Image URL or choose from library…" style="flex:1;" />
                        <button type="button" class="radm-btn radm-btn-outline" onclick="radmPickMedia('news-image-url', 'news-attachment-id', 'news-img-preview')">
                            Choose Image
                        </button>
                    </div>
                    <div id="news-img-preview" style="margin-top:8px; display:none;">
                        <img src="" style="max-height:90px; border-radius:6px; border:1px solid var(--radm-border);" />
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
    if (aSearch || aCat) {
        function filterActivities() {
            var q = (aSearch ? aSearch.value : '').toLowerCase().trim();
            var c = (aCat ? aCat.value : '');
            var rows = document.querySelectorAll('.radm-activity-row');
            var visible = 0;
            rows.forEach(function(row) {
                var title = row.getAttribute('data-title') || '';
                var cat   = row.getAttribute('data-cat') || '';
                var matchText = !q || title.indexOf(q) !== -1;
                var matchCat  = !c || cat === c;
                if (matchText && matchCat) {
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

    // Modal Helpers
    window.radmCloseModals = function() {
        document.querySelectorAll('.radm-modal-overlay').forEach(function(m) {
            m.classList.remove('radm-modal-open');
        });
    };

    window.radmPickMedia = function(urlInputId, attachmentInputId, previewId) {
        if (typeof wp !== 'undefined' && wp.media) {
            var frame = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            frame.on('select', function() {
                var att = frame.state().get('selection').first().toJSON();
                var urlInput = document.getElementById(urlInputId);
                var attInput = document.getElementById(attachmentInputId);
                var prevWrap = document.getElementById(previewId);
                if (urlInput) urlInput.value = att.url;
                if (attInput) attInput.value = att.id;
                if (prevWrap) {
                    prevWrap.style.display = 'block';
                    var img = prevWrap.querySelector('img');
                    if (img) img.src = att.url;
                }
            });
            frame.open();
        } else {
            var url = prompt('Enter Image URL:');
            if (url) {
                var uIn = document.getElementById(urlInputId);
                if (uIn) uIn.value = url;
            }
        }
    };

    // Center Modal
    window.radmOpenCenterModal = function() {
        document.getElementById('radm-center-form').reset();
        document.getElementById('center-id').value = '0';
        document.getElementById('center-attachment-id').value = '0';
        document.getElementById('radm-center-modal-title').textContent = 'Add New Center';
        var prev = document.getElementById('center-img-preview');
        if (prev) prev.style.display = 'none';
        document.getElementById('radm-center-modal').classList.add('radm-modal-open');
    };

    window.radmEditCenter = function(data) {
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
        document.getElementById('center-status').value = data.status || 'publish';

        var prev = document.getElementById('center-img-preview');
        if (prev) {
            if (data.image_url) {
                prev.style.display = 'block';
                prev.querySelector('img').src = data.image_url;
            } else {
                prev.style.display = 'none';
            }
        }
        document.getElementById('radm-center-modal-title').textContent = 'Edit Center: ' + (data.title || '');
        document.getElementById('radm-center-modal').classList.add('radm-modal-open');
    };

    window.radmSubmitCenter = function(e) {
        e.preventDefault();
        var btn = document.getElementById('center-save-btn');
        btn.disabled = true;
        btn.textContent = 'Saving…';

        var fd = new FormData(document.getElementById('radm-center-form'));
        fd.append('action', 'radm_save_content_center');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Center';
                if (res.success) {
                    alert(res.data.message || 'Center saved successfully!');
                    window.location.reload();
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

    // Activity Modal
    window.radmOpenActivityModal = function() {
        document.getElementById('radm-activity-form').reset();
        document.getElementById('act-id').value = '0';
        document.getElementById('act-attachment-id').value = '0';
        document.getElementById('radm-activity-modal-title').textContent = 'Add New Activity';
        var prev = document.getElementById('act-img-preview');
        if (prev) prev.style.display = 'none';
        document.getElementById('radm-activity-modal').classList.add('radm-modal-open');
    };

    window.radmEditActivity = function(data) {
        document.getElementById('act-id').value = data.id || '0';
        document.getElementById('act-name').value = data.title || '';
        if (data.category_id) document.getElementById('act-cat').value = data.category_id;
        document.getElementById('act-badge').value = data.badge || '';
        document.getElementById('act-content').value = data.content || '';
        document.getElementById('act-batches').value = data.batches_text || '';
        document.getElementById('act-duration').value = data.duration_text || '';
        document.getElementById('act-frequency').value = data.frequency_text || '';
        document.getElementById('act-eligibility').value = data.eligibility_text || '';
        document.getElementById('act-centers').value = data.centers_text || '';
        document.getElementById('act-image-url').value = data.image_url || '';
        document.getElementById('act-status').value = data.status || 'publish';

        var prev = document.getElementById('act-img-preview');
        if (prev) {
            if (data.image_url) {
                prev.style.display = 'block';
                prev.querySelector('img').src = data.image_url;
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

        var fd = new FormData(document.getElementById('radm-activity-form'));
        fd.append('action', 'radm_save_activity');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Activity';
                if (res.success) {
                    alert(res.data.message || 'Activity saved successfully!');
                    window.location.reload();
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
        document.getElementById('radm-news-modal-title').textContent = 'Add News Article';
        var prev = document.getElementById('news-img-preview');
        if (prev) prev.style.display = 'none';
        document.getElementById('radm-news-modal').classList.add('radm-modal-open');
    };

    window.radmEditNews = function(data) {
        document.getElementById('news-id').value = data.id || '0';
        document.getElementById('news-title').value = data.title || '';
        document.getElementById('news-excerpt').value = data.excerpt || '';
        document.getElementById('news-content').value = data.content || '';
        document.getElementById('news-image-url').value = data.image_url || '';
        document.getElementById('news-status').value = data.status || 'publish';

        var prev = document.getElementById('news-img-preview');
        if (prev) {
            if (data.image_url) {
                prev.style.display = 'block';
                prev.querySelector('img').src = data.image_url;
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

        var fd = new FormData(document.getElementById('radm-news-form'));
        fd.append('action', 'radm_save_post');
        fd.append('nonce', nonce);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Article';
                if (res.success) {
                    alert(res.data.message || 'Article saved successfully!');
                    window.location.reload();
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

    // Generic Delete Controller
    var activeDeleteId = 0;
    var activeDeleteType = '';

    window.radmPromptDelete = function(id, title, type) {
        activeDeleteId = id;
        activeDeleteType = type;
        document.getElementById('delete-target-title').textContent = title;
        document.getElementById('radm-delete-modal').classList.add('radm-modal-open');
    };

    window.radmExecuteDelete = function() {
        if (!activeDeleteId || !activeDeleteType) return;
        var btn = document.getElementById('delete-confirm-btn');
        btn.disabled = true;
        btn.textContent = 'Deleting…';

        var actionName = (activeDeleteType === 'center') ? 'radm_delete_content_center' : ('radm_delete_' + activeDeleteType);
        var fd = new FormData();
        fd.append('action', actionName);
        fd.append('nonce', nonce);
        fd.append('post_id', activeDeleteId);

        fetch(ajaxUrl, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Yes, Delete';
                radmCloseModals();
                if (res.success) {
                    // Remove row from table
                    var row = document.getElementById(activeDeleteType + '-row-' + activeDeleteId);
                    if (row) row.remove();
                    alert(res.data.message || 'Item removed successfully.');
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

