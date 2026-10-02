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

        $lat = get_field('lat', $p->ID) ?: 12.9716;
        $lng = get_field('lng', $p->ID) ?: 77.5946;
        $hours = get_field('hours', $p->ID) ?: 'Please refer to batch timings';
        $phone = get_field('phone', $p->ID) ?: '';
        $email = get_field('email', $p->ID) ?: 'info@rashtrotthana.org';
        $area = get_field('area', $p->ID) ?: '';

        $img = get_the_post_thumbnail_url($p->ID, 'large') ?: get_post_meta($p->ID, '_ry_image_url', true);
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
        $cat_data = array(
            'slug'    => $term->slug,
            'icon'    => get_field('icon', $term_id),
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
    $posts = get_posts( array('post_type' => 'event', 'posts_per_page' => -1, 'post_status' => 'publish') );
    $events = array();
    foreach ( $posts as $p ) {
        $date_iso = get_field('event_date', $p->ID) ?: get_post_meta($p->ID, '_ry_event_date', true);
        if (!$date_iso) $date_iso = current_time('Y-m-d');
        
        // ACF date could be Ymd (e.g., 20261015) or Y-m-d
        if (preg_match('/^(\d{4})(\d{2})(\d{2})$/', $date_iso, $m)) {
            $date_iso = $m[1] . '-' . $m[2] . '-' . $m[3];
        }
        $ts = strtotime($date_iso);
        
        $time = get_field('event_time', $p->ID);
        if (!$time) {
            $start = get_post_meta($p->ID, '_ry_start_time', true);
            $end = get_post_meta($p->ID, '_ry_end_time', true);
            $time = ($start && $end) ? "$start - $end" : "6:00 AM - 8:00 AM";
        }
        
        $img = get_the_post_thumbnail_url($p->ID, 'large') ?: get_post_meta($p->ID, '_ry_image_url', true);
        if (!$img) $img = get_template_directory_uri() . '/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg';
        
        $venue_obj = get_field('event_venue', $p->ID);
        $venue = $venue_obj ? $venue_obj->post_title : (get_field('event_venue_custom', $p->ID) ?: 'Rashtrotthana Center');

        // Compare using midnight to ensure today's events are not marked past
        $today_midnight = strtotime(current_time('Y-m-d 00:00:00'));
        $is_past = $ts < $today_midnight;
        $e_type = $is_past ? 'past' : 'upcoming';

        if ( $type && $type !== $e_type ) {
            continue;
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
            'category' => 'Wellness',
            'category_slug' => 'wellness',
            'mode' => get_field('event_mode', $p->ID) ?: get_post_meta($p->ID, '_ry_event_mode', true),
            'type' => $e_type,
            'image' => $img,
            'desc' => wp_trim_words($p->post_content, 20),
            'fee' => get_field('event_fee', $p->ID) ?: get_post_meta($p->ID, '_ry_event_fee', true),
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
        
        $rt = get_post_meta($p->ID, '_ry_read_time', true) ?: '3 min read';
        
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
            'excerpt' => $p->post_excerpt ?: wp_trim_words($p->post_content, 15),
            'full_text' => wpautop($p->post_content)
        );
    }
    
    return $news;
}

// ── Gallery ──────────────────────────────────────────────────────────────────

function rs_get_gallery_albums() {
    $posts = get_posts( array('post_type' => 'rs_gallery_album', 'posts_per_page' => -1, 'post_status' => 'publish') );
    $albums = array();
    foreach ( $posts as $p ) {
        $img = get_the_post_thumbnail_url($p->ID, 'large') ?: get_template_directory_uri() . '/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg';
        
        $photos = get_field('photos', $p->ID) ?: [];
        $videos = get_field('videos', $p->ID) ?: [];

        $albums[] = array(
            'id' => $p->post_name,
            'title' => $p->post_title,
            'category' => 'Events',
            'category_slug' => 'events',
            'date' => get_the_date('F j, Y', $p),
            'venue' => 'Rashtrotthana Center',
            'desc' => $p->post_content,
            'cover_image' => $img,
            'photos' => $photos,
            'videos' => $videos
        );
    }
    
    return $albums;
}

// ── Homepage ─────────────────────────────────────────────────────────────────

function rs_get_homepage_data() {
    $rs_home_center_cards = [];
    $rs_home_stats = [];
    $rs_home_values = [];
    $rs_home_founder = [];
    $rs_activity_fallbacks = [];
    $rs_event_fallbacks = [];
    // Merge ACF options with original arrays
    
    
    // Values
    $rs_home_values = array(
        array( 'title' => 'Our Vision',  'text' => 'To build a healthy, harmonious and sustainable society rooted in Indian values.' ),
        array( 'title' => 'Our Mission', 'text' => 'To empower individuals through Yoga, Education, Culture and Service for personal growth and social transformation.' ),
        array( 'title' => 'Our Values',  'text' => 'Integrity, compassion, discipline, selfless service and excellence in everything we do.' ),
        array( 'title' => 'Our Impact',  'text' => 'Building stronger communities through meaningful service and lifelong learning.' ),
    );

    $v_title = get_field('ry_about_vision_title', 'option');
    $v_text = get_field('ry_about_vision_text', 'option');
    $m_title = get_field('ry_about_mission_title', 'option');
    $m_text = get_field('ry_about_mission_text', 'option');
    if ( $v_title && $m_title ) {
        $rs_home_values[0] = ['title' => $v_title, 'text' => strip_tags($v_text)];
        $rs_home_values[1] = ['title' => $m_title, 'text' => strip_tags($m_text)];
    }
    
    // Stats
    $rs_home_stats = array(
        array( 'value' => 1972, 'suffix' => '',  'label' => 'Since' ),
        array( 'value' => 35,   'suffix' => '+', 'label' => 'Activities' ),
        array( 'value' => 18,   'suffix' => '',  'label' => 'Projects' ),
        array( 'value' => 23,   'suffix' => '+', 'label' => 'Centers' ),
        array( 'value' => 1000, 'suffix' => '+', 'label' => 'Lives Impacted' ),
    );
    $stats = get_field('ry_home_stats', 'option');
    if ( $stats && is_array($stats) ) {
        $rs_home_stats = $stats;
    }
    
    // Founder
    $f_name = get_field('ry_home_founder_name', 'option');
    if ( $f_name ) {
        $rs_home_founder = array(
            'name' => $f_name,
            'title' => get_field('ry_home_founder_title', 'option'),
            'subtitle' => get_field('ry_home_founder_subtitle', 'option'),
            'image' => get_field('ry_home_founder_photo', 'option'),
            'image_alt' => $f_name . ' - Founder',
            'paragraphs' => explode("\n\n", strip_tags(get_field('ry_home_founder_bio', 'option'))),
            'quote' => get_field('ry_home_founder_quote', 'option'),
            'quote_author' => get_field('ry_home_founder_quote_attr', 'option'),
        );
    }
    
    // Featured Cards
    $f_cards = [];
    $all_centers = rs_get_centers();
    foreach ($all_centers as $c) {
        if ( !empty($c['is_featured']) ) {
            $f_cards[] = [
                'name' => $c['name'],
                'city' => $c['area'],
                'image' => $c['image'],
                'link' => home_url('/centers/#' . $c['id'])
            ];
        }
    }
    
    // Fallback: If no centers are manually featured, just grab the first 4
    if ( empty($f_cards) && !empty($all_centers) ) {
        $slice = array_slice($all_centers, 0, 4);
        foreach ($slice as $c) {
            $f_cards[] = [
                'name' => $c['name'],
                'city' => $c['area'],
                'image' => $c['image'],
                'link' => home_url('/centers/#' . $c['id'])
            ];
        }
    }

    if ( !empty($f_cards) ) {
        $rs_home_center_cards = $f_cards;
    }
    
    // Update stats dynamically
    if ( !empty($rs_home_stats) && is_array($rs_home_stats) ) {
        $real_count = count($all_centers);
        foreach ($rs_home_stats as &$stat) {
            if ( $stat['label'] === 'Centers' && $real_count > 0 ) {
                $stat['value'] = $real_count;
            }
        }
    }
    
    return array(
        'center_cards'       => $rs_home_center_cards,
        'stats'              => $rs_home_stats,
        'values'             => $rs_home_values,
        'founder'            => $rs_home_founder,
        'activity_fallbacks' => $rs_activity_fallbacks,
        'event_fallbacks'    => $rs_event_fallbacks,
    );
}
