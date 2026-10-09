<?php
/**
 * Data Helper Functions — Rashtrotthana Yoga
 * Fully integrated with WP Database and ACF
 */

// ── Centers ──────────────────────────────────────────────────────────────────

function rs_get_centers( $zone_slug = '' ) {
    $args = array(
        'post_type'      => 'rs_center',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    );
    $posts = get_posts( $args );
    $centers = array();

    foreach ( $posts as $p ) {
        $zone = get_field('zone', $p->ID) ?: 'South Bengaluru';
        $z_slug = strtolower(explode(' ', $zone)[0]);
        
        if ( $zone_slug && $z_slug !== $zone_slug ) continue;

        $programs = [];
        $activity_details = [];
                $prog_rows = get_field('programs', $p->ID);
        if ( is_numeric($prog_rows) || is_string($prog_rows) ) {
            $count = intval($prog_rows);
            $prog_rows = [];
            for ( $i = 0; $i < $count; $i++ ) {
                $prog_rows[] = [
                    'program_name' => get_post_meta($p->ID, 'programs_' . $i . '_program_name', true),
                    'badge'        => get_post_meta($p->ID, 'programs_' . $i . '_badge', true),
                    'days'         => get_post_meta($p->ID, 'programs_' . $i . '_days', true),
                    'timings'      => get_post_meta($p->ID, 'programs_' . $i . '_timings', true),
                    'dates'        => get_post_meta($p->ID, 'programs_' . $i . '_dates', true),
                    'desc'         => get_post_meta($p->ID, 'programs_' . $i . '_desc', true),
                ];
            }
        }
        if (is_array($prog_rows)) {
            foreach ($prog_rows as $row) {
                $programs[] = $row['program_name'];
                $activity_details[] = array(
                    'name' => $row['program_name'],
                    'badge' => !empty($row['badge']) ? $row['badge'] : 'Regular Batch',
                    'days' => !empty($row['days']) ? $row['days'] : 'As per schedule',
                    'timings' => !empty($row['timings']) ? $row['timings'] : '',
                    'dates' => !empty($row['dates']) ? $row['dates'] : 'Ongoing',
                    'desc' => !empty($row['desc']) ? $row['desc'] : 'Certified instruction.'
                );
            }
        }
        
        $features = [];
                $feat_rows = get_field('features', $p->ID);
        if ( is_numeric($feat_rows) || is_string($feat_rows) ) {
            $count = intval($feat_rows);
            $feat_rows = [];
            for ( $i = 0; $i < $count; $i++ ) {
                $feat_rows[] = [
                    'feature_name' => get_post_meta($p->ID, 'features_' . $i . '_feature_name', true),
                ];
            }
        }
        if (is_array($feat_rows)) {
            foreach ($feat_rows as $row) {
                $features[] = $row['feature_name'];
            }
        }

        $lat = get_post_meta($p->ID, 'lat', true) ?: (get_field('lat', $p->ID) ?: 0);
        $lng = get_post_meta($p->ID, 'lng', true) ?: (get_field('lng', $p->ID) ?: 0);

        if ( empty($lat) || empty($lng) || ($lat == 12.9716 && $lng == 77.5946) ) {
            $fallback_coords = array(
                'sadashivnagar' => array( 13.0068, 77.5813 ),
                'gayathrinagar' => array( 12.9982, 77.5615 ),
                'rbi-layout'    => array( 12.8894, 77.5746 ),
                'kamakshipalya' => array( 12.9835, 77.5255 ),
                'kg-nagar'      => array( 12.9488, 77.5637 ),
                'nagarbhavi'    => array( 12.9602, 77.5103 ),
                'vijaynagar'    => array( 12.9698, 77.5358 ),
                'sunkenahalli'  => array( 12.9421, 77.5678 ),
                'girinagar'     => array( 12.9372, 77.5385 ),
                'aksharam'      => array( 12.9355, 77.5398 ),
                'kundalahalli'  => array( 12.9698, 77.7199 ),
                'jayanagar'     => array( 12.9250, 77.5938 ),
            );
            $slug_check = $p->post_name;
            foreach ($fallback_coords as $k => $c_pair) {
                if ($slug_check === $k || strpos($slug_check, $k) !== false || strpos(strtolower($p->post_title), $k) !== false) {
                    $lat = $c_pair[0];
                    $lng = $c_pair[1];
                    break;
                }
            }
        }
        $lat = floatval($lat ?: 12.9716);
        $lng = floatval($lng ?: 77.5946);
        $hours = get_field('hours', $p->ID) ?: 'Please refer to batch timings';
        $phone = get_field('phone', $p->ID) ?: '';
        $email = get_field('email', $p->ID) ?: 'info@rashtrotthana.org';
        $area = get_field('area', $p->ID) ?: '';

        $upload_dir = wp_upload_dir();
        $fallback_images = array(
            'sadashivnagar' => $upload_dir['baseurl'] . '/2026/10/Sadashivnagar.jpg',
            'gayathrinagar' => $upload_dir['baseurl'] . '/2026/10/Gayathrinagar.jpg',
            'rbi-layout'    => $upload_dir['baseurl'] . '/2026/10/RBI-Layout.jpg',
            'rbilayout'     => $upload_dir['baseurl'] . '/2026/10/RBI-Layout.jpg',
            'kamakshipalya' => $upload_dir['baseurl'] . '/2026/10/KAMAKSHIPALYA.jpg',
            'kg-nagar'      => $upload_dir['baseurl'] . '/2026/10/Kempegowda-Nagar.jpg',
            'kgnagar'       => $upload_dir['baseurl'] . '/2026/10/Kempegowda-Nagar.jpg',
            'nagarbhavi'    => $upload_dir['baseurl'] . '/2026/10/nagarbhavi.jpg',
            'vijaynagar'    => $upload_dir['baseurl'] . '/2026/10/Vijaynagar.jpg',
            'sunkenahalli'  => $upload_dir['baseurl'] . '/2026/10/Basavangudi.jpg',
            'girinagar'     => $upload_dir['baseurl'] . '/2026/10/Girinagar.jpg',
            'aksharam'      => $upload_dir['baseurl'] . '/2026/10/Yoga-Prashikshana.jpg',
            'kundalahalli'  => $upload_dir['baseurl'] . '/2026/10/Kundalahalli.jpg',
            'jayanagar'     => $upload_dir['baseurl'] . '/2026/10/Jayanagara.jpg',
        );
        $c_slug = $p->post_name;
        $img = get_the_post_thumbnail_url($p->ID, 'large') ?: get_post_meta($p->ID, '_ry_image_url', true);
        if (!$img && isset($fallback_images[$c_slug])) {
            $img = $fallback_images[$c_slug];
        }
        if (!$img) $img = get_template_directory_uri() . '/assets/images/client/20200529-175453.jpg';


        $centers[] = array(
            'id' => $p->post_name,
            'name' => $p->post_title,
            'area' => $area,
            'zone' => $zone,
            'zone_slug' => $z_slug,
            'lat' => $lat,
            'lng' => $lng,
            'phone' => $phone,
            'hours' => $hours,
            'timing' => 'both',
            'timing_label' => 'Morning & Evening',
            'programs' => !empty($programs) ? $programs : ['Yoga for Beginners', 'Pranayama'],
            'activities' => ['yoga', 'wellness'],
            'address' => get_field('address', $p->ID) ?: $p->post_content,
            'email' => $email,
            'image' => $img,
            'features' => !empty($features) ? $features : ['Certified Instructors', 'Spacious Shala'],
            'activity_details' => $activity_details,
            'is_hq' => get_field('is_hq', $p->ID) ?: false,
        );
    }
    return $centers;
}

function rs_get_flagship_centers() {
    $centers = rs_get_centers();
    return array_values( array_filter( $centers, function($c) {
        return !empty($c['is_hq']);
    }));
}

function rs_get_faqs() {
    $posts = get_posts( array( 'post_type' => 'faq', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
    $faqs = array();
    foreach ( $posts as $p ) {
        $faqs[] = array(
            'q' => $p->post_title,
            'a' => wpautop($p->post_content)
        );
    }
    // Fallback if none exist
    
    return $faqs;
}

// ── Activities ───────────────────────────────────────────────────────────────


function rs_get_activity_categories() {
    $categories = array();
    
    // Get all activity category terms
    $terms = get_terms( array(
        'taxonomy' => 'activity_category',
        'hide_empty' => false,
    ) );
    
    
    
    foreach ( $terms as $term ) {
        $term_id = 'activity_category_' . $term->term_id;
        $icon_fallbacks = array(
            'yoga-wellness'     => '🧘',
            'arts-music'        => '🎵',
            'dance'             => '💃',
            'martial-arts'      => '🥋',
            'children-programs' => '👶',
            'fitness-sports'    => '🏃',
            'health-therapy'    => '🌿',
            'knowledge-culture' => '🕉️',
        );
        $term_icon = get_field('icon', $term_id);
        if ( empty($term_icon) || $term_icon === '?' ) {
            $term_icon = isset($icon_fallbacks[$term->slug]) ? $icon_fallbacks[$term->slug] : '🧘';
        }
        $cat_data = array(
            'slug'    => $term->slug,
            'icon'    => $term_icon,
            'title'   => $term->name,

            'tagline' => get_field('tagline', $term_id),
            'text'    => get_field('text', $term_id),
            'image'   => get_field('image', $term_id) ?: get_term_meta($term->term_id, 'image_url', true),
            'items'   => array()
        );
        
        // Get activities for this term
        $activities = get_posts( array(
            'post_type' => 'activity',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'activity_category',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                ),
            ),
        ) );
        
        foreach ( $activities as $act ) {
            $cat_data['items'][] = array(
                'name'        => $act->post_title,
                'badge'       => get_field('badge', $act->ID),
                'desc'        => $act->post_content,
                'centers'     => get_field('centers', $act->ID) ?: 'All major centers',
                'batches'     => get_field('batches', $act->ID),
                'duration'    => get_field('duration', $act->ID),
                'frequency'   => get_field('frequency', $act->ID),
                'eligibility' => get_field('eligibility', $act->ID)
            );
        }
        
        $categories[] = $cat_data;
    }
    
    return $categories;
}

// ── Events ───────────────────────────────────────────────────────────────────

function rs_get_events( $type = '' ) {
    $posts = get_posts( array('post_type' => 'event', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'ASC') );
    $events = array();
    foreach ( $posts as $p ) {
        $date_iso = get_field('event_date', $p->ID) ?: get_post_meta($p->ID, '_ry_event_date', true);
        if (!$date_iso) $date_iso = get_the_date('Y-m-d', $p);
        
        // ACF date could be Ymd (e.g., 20261015) or Y-m-d
        if (preg_match('/^(\d{4})(\d{2})(\d{2})$/', $date_iso, $m)) {
            $date_iso = $m[1] . '-' . $m[2] . '-' . $m[3];
        }
        $ts = strtotime($date_iso);
        
        $time = get_field('event_time', $p->ID);
        if (!$time) {
            $start = get_post_meta($p->ID, '_ry_start_time', true);
            $end = get_post_meta($p->ID, '_ry_end_time', true);
            $time = ($start && $end) ? "$start - $end" : "6:00 AM - 9:00 AM";
        }
        
        $img = get_the_post_thumbnail_url($p->ID, 'large') ?: get_post_meta($p->ID, '_ry_image_url', true);
        if (!$img) $img = get_template_directory_uri() . '/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg';
        
        $venue_obj = get_field('event_venue', $p->ID);
        $venue = $venue_obj ? $venue_obj->post_title : (get_field('event_venue_custom', $p->ID) ?: (get_post_meta($p->ID, '_ry_event_venue', true) ?: 'Rashtrotthana Center'));

        // Compare using midnight to ensure today's events are not marked past
        $today_midnight = strtotime(current_time('Y-m-d 00:00:00'));
        $is_past = $ts < $today_midnight;
        $override_type = get_post_meta($p->ID, '_ry_event_type', true);
        $e_type = $override_type ?: ($is_past ? 'past' : 'upcoming');

        if ( $type && $type !== $e_type ) {
            continue;
        }

        $category = get_post_meta($p->ID, '_ry_event_category', true) ?: (get_field('event_category', $p->ID) ?: 'Special Event');
        $reg_status = get_field('registration_status', $p->ID) ?: get_post_meta($p->ID, '_ry_registration_status', true);
        if (!$reg_status) {
            $reg_status = ($is_past || $e_type === 'past') ? 'closed' : 'open';
        }

        $events[] = array(
            'id' => $p->post_name,
            'day' => date('d', $ts),
            'month' => date('M', $ts),
            'year' => date('Y', $ts),
            'date_iso' => $date_iso,
            'timeframe' => $is_past ? 'past' : strtolower(date('F', $ts)),
            'title' => $p->post_title,
            'venue' => $venue,
            'time' => $time,
            'category' => $category,
            'category_slug' => sanitize_title($category),
            'mode' => get_field('event_mode', $p->ID) ?: (get_post_meta($p->ID, '_ry_event_mode', true) ?: 'In-Person'),
            'type' => $e_type,
            'image' => $img,
            'desc' => $p->post_excerpt ?: wp_trim_words(strip_tags($p->post_content), 24, '...'),
            'full_text' => wpautop($p->post_content),
            'fee' => get_field('event_fee', $p->ID) ?: (get_post_meta($p->ID, '_ry_event_fee', true) ?: 'Free'),
            'registration_status' => $reg_status,
        );
    }
    
    return $events;
}

function rs_get_news() {
    $posts = get_posts( array('post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'publish') );
    $news = array();
    foreach ( $posts as $p ) {
        $img = get_the_post_thumbnail_url($p->ID, 'large') ?: get_post_meta($p->ID, '_ry_image_url', true);
        if (!$img) $img = get_template_directory_uri() . '/assets/images/client/20200529-182250.jpg';
        
        $rt = get_post_meta($p->ID, '_ry_read_time', true) ?: '2 min read';
        
        $cats = wp_get_post_categories($p->ID, ['fields' => 'all']);
        $cat_name = !empty($cats) ? $cats[0]->name : 'News';
        $cat_slug = !empty($cats) ? $cats[0]->slug : 'news';

        $news[] = array(
            'id' => $p->post_name,
            'title' => $p->post_title,
            'date' => get_the_date('M j, Y', $p),
            'category' => $cat_name,
            'category_slug' => $cat_slug,
            'read_time' => $rt,
            'image' => $img,
            'excerpt' => $p->post_excerpt ?: wp_trim_words(strip_tags($p->post_content), 22, '...'),
            'full_text' => wpautop($p->post_content)
        );
    }
    
    return $news;
}

// ── Gallery ──────────────────────────────────────────────────────────────────

function rs_get_gallery_albums() {
    static $cached = null;
    if ( $cached !== null ) {
        return $cached;
    }
    // Load from static data file. To switch to DB-driven albums,
    // replace this block with a get_posts() / WP_Query call.
    require get_template_directory() . '/data/gallery-data.php';
    $cached = isset( $gallery_events ) ? $gallery_events : array();
    return $cached;
}

/**
 * Retrieve homepage gallery images strictly from WordPress Media Library
 */
function rs_get_home_gallery_images( $limit = 12 ) {
    $args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => 50,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $attachments = get_posts( $args );
    $gallery = array();

    foreach ( $attachments as $att ) {
        $file = get_attached_file( $att->ID );
        // Verify attachment file actually exists on disk
        if ( ! $file || ! file_exists( $file ) ) {
            continue;
        }

        // Filter out hero slides, logos, or founder portrait
        $slug = $att->post_name;
        if ( stripos( $slug, 'hero' ) !== false || stripos( $slug, 'founder' ) !== false || stripos( $slug, 'logo' ) !== false ) {
            continue;
        }

        $img_url = wp_get_attachment_image_url( $att->ID, 'large' ) ?: wp_get_attachment_url( $att->ID );
        if ( ! $img_url ) {
            continue;
        }

        $gallery[] = array(
            'id'    => $att->ID,
            'title' => $att->post_title,
            'url'   => $img_url,
            'link'  => home_url( '/gallery/' ),
        );

        if ( count( $gallery ) >= $limit ) {
            break;
        }
    }

    return $gallery;
}

// ── Homepage ─────────────────────────────────────────────────────────────────

function rs_get_homepage_data() {
    require get_template_directory() . '/data/homepage-data.php';

    return array(
        'activities'         => isset( $rs_home_activities ) ? $rs_home_activities : array(),
        'center_cards'       => $rs_home_center_cards,
        'stats'              => $rs_home_stats,
        'values'             => $rs_home_values,
        'founder'            => $rs_home_founder,
        'activity_fallbacks' => isset( $rs_activity_fallbacks ) ? $rs_activity_fallbacks : array(),
        'event_fallbacks'    => $rs_event_fallbacks,
    );
}
