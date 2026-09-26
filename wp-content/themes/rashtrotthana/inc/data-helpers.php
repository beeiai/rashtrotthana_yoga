<?php
/**
 * Data Helper Functions — Rashtrotthana Yoga
 * Fully integrated with WP Database and ACF
 */

// ── Centers ──────────────────────────────────────────────────────────────────

function rs_get_centers( $zone_slug = '' ) {
    $args = array(
        'post_type'      => 'center',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    );
    if ( $zone_slug ) {
        // Find centers by zone_slug mapping
        // We'll filter in PHP to be safe since zone_slug isn't directly an ACF field (it's derived from zone name)
    }
    
    $posts = get_posts( $args );
    $centers = array();

    foreach ( $posts as $p ) {
        $zone = get_field('zone', $p->ID) ?: 'South Bengaluru';
        $z_slug = strtolower(explode(' ', $zone)[0]); // south, north, etc.
        
        if ( $zone_slug && $z_slug !== $zone_slug ) {
            continue;
        }

        $programs = [];
        $prog_rows = get_field('programs', $p->ID);
        if ($prog_rows) {
            foreach ($prog_rows as $row) {
                $programs[] = $row['program_name'];
            }
        }
        
        $features = [];
        $feat_rows = get_field('features', $p->ID);
        if ($feat_rows) {
            foreach ($feat_rows as $row) {
                $features[] = $row['feature_name'];
            }
        }

        // Fallback to old meta if ACF is empty
        $lat = get_field('lat', $p->ID) ?: get_post_meta($p->ID, '_ry_center_lat', true);
        $lng = get_field('lng', $p->ID) ?: get_post_meta($p->ID, '_ry_center_lng', true);
        $hours = get_field('hours', $p->ID) ?: get_post_meta($p->ID, '_ry_center_hours', true);
        $phone = get_field('phone', $p->ID) ?: get_post_meta($p->ID, '_ry_center_phone', true);
        $email = get_field('email', $p->ID) ?: get_post_meta($p->ID, '_ry_center_email', true);
        $area = get_field('area', $p->ID) ?: get_post_meta($p->ID, '_ry_center_area', true);

        $img = get_the_post_thumbnail_url($p->ID, 'large') ?: get_post_meta($p->ID, '_ry_image_url', true);
        if (!$img) $img = get_template_directory_uri() . '/assets/images/client/21-06-22-idy-celebration-12-.jpg';

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
            'timing' => 'both', // Hardcoded as per original
            'timing_label' => 'Morning & Evening',
            'programs' => !empty($programs) ? $programs : ['Yoga for Beginners', 'Pranayama'],
            'activities' => ['yoga', 'wellness'],
            'address' => get_field('address', $p->ID) ?: $p->post_content,
            'email' => $email,
            'image' => $img,
            'features' => !empty($features) ? $features : ['Experienced Instructors', 'Serene Environment'],
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
    if ( empty($faqs) ) {
        require get_template_directory() . '/data/contact-data.php';
        return isset($faqs_dataset) ? $faqs_dataset : array();
    }
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
    
    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        require get_template_directory() . '/data/activities-data.php';
        return $activity_categories;
    }
    
    foreach ( $terms as $term ) {
        $term_id = 'activity_category_' . $term->term_id;
        $cat_data = array(
            'slug'    => $term->slug,
            'icon'    => get_field('icon', $term_id),
            'title'   => $term->name,
            'tagline' => get_field('tagline', $term_id),
            'text'    => get_field('text', $term_id),
            'image'   => get_field('image', $term_id),
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

        $is_past = $ts < current_time('timestamp');
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
    
    if ( empty($events) ) {
        require get_template_directory() . '/data/events-data.php';
        return $type ? array_values(array_filter($events_dataset, fn($e) => $e['type'] === $type)) : $events_dataset;
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
    if ( empty($news) ) {
        require get_template_directory() . '/data/events-data.php';
        return isset($news_dataset) ? $news_dataset : array();
    }
    return $news;
}

// ── Gallery ──────────────────────────────────────────────────────────────────

function rs_get_gallery_albums() {
    $posts = get_posts( array('post_type' => 'gallery_album', 'posts_per_page' => -1, 'post_status' => 'publish') );
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
    if ( empty($albums) ) {
        require get_template_directory() . '/data/gallery-data.php';
        return $gallery_events;
    }
    return $albums;
}

// ── Homepage ─────────────────────────────────────────────────────────────────

function rs_get_homepage_data() {
    // Merge ACF options with original arrays
    require get_template_directory() . '/data/homepage-data.php';
    
    // Values
    $v_title = get_field('ry_about_vision_title', 'option');
    $v_text = get_field('ry_about_vision_text', 'option');
    $m_title = get_field('ry_about_mission_title', 'option');
    $m_text = get_field('ry_about_mission_text', 'option');
    if ( $v_title && $m_title ) {
        $rs_home_values[0] = ['title' => $v_title, 'text' => strip_tags($v_text)];
        $rs_home_values[1] = ['title' => $m_title, 'text' => strip_tags($m_text)];
    }
    
    // Stats
    $stats = get_field('ry_home_stats', 'option');
    if ( $stats ) {
        $rs_home_stats = $stats;
    }
    
    // Founder
    $f_name = get_field('ry_home_founder_name', 'option');
    if ( $f_name ) {
        $rs_home_founder = array(
            'name' => $f_name,
            'role' => get_field('ry_home_founder_title', 'option'),
            'subtitle' => get_field('ry_home_founder_subtitle', 'option'),
            'image' => get_field('ry_home_founder_photo', 'option'),
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
    if ( !empty($f_cards) ) {
        $rs_home_center_cards = array_slice($f_cards, 0, 4);
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
