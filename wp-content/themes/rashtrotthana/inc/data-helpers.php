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

        $fallback_maps = array(
            'sadashivnagar' => 'https://maps.app.goo.gl/E3Dipy67Wwf5xkam8',
            'gayathrinagar' => 'https://maps.app.goo.gl/SCep2hzRv1xH2RmL9',
            'rbi-layout'    => 'https://maps.app.goo.gl/VNRgWBJkF2T9L2mo7',
            'rbilayout'     => 'https://maps.app.goo.gl/VNRgWBJkF2T9L2mo7',
            'kamakshipalya' => 'https://maps.app.goo.gl/QjpNjSdqVkfGjW3D6',
            'kg-nagar'      => 'https://maps.app.goo.gl/7x6twgWcDWvWVKRx9',
            'kgnagar'       => 'https://maps.app.goo.gl/7x6twgWcDWvWVKRx9',
            'nagarbhavi'    => 'https://maps.app.goo.gl/95rZNUx1rdTghNhq6',
            'vijaynagar'    => 'https://maps.app.goo.gl/jFy3yMB2wZTEjYWPA',
            'sunkenahalli'  => 'https://maps.app.goo.gl/mJV4THKcNoTKD4yk8',
            'kundalahalli'  => 'https://maps.app.goo.gl/8LNFGappKdPDxSHJ7',
            'jayanagar'     => 'https://maps.app.goo.gl/xkzHbuQHGYkNyoHG7',
        );

        $fallback_socials = array(
            'sadashivnagar' => array(
                'instagram' => 'https://www.instagram.com/invites/contact/?utm_source=ig_contact_invite&utm_medium=copy_link&utm_content=oihehvp',
                'facebook'  => 'https://www.facebook.com/rashtrotthanapathanjaliyogamandir.yoga',
                'linktree'  => 'https://linktr.ee/rysrisadashivnagar',
            ),
            'gayathrinagar' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanagayatrinagar?stkn=MWtjeGVkN2lmcG9hdA==',
                'facebook'  => 'https://www.facebook.com/profile.php?id=100087916731697&mibextid=ZbWKwL',
                'linktree'  => '',
            ),
            'rbi-layout' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanarbilayout/?hl=en',
                'facebook'  => 'https://www.facebook.com/photo/?fbid=122093703260352686&set=a.122093703290352686',
                'linktree'  => '',
            ),
            'rbilayout' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanarbilayout/?hl=en',
                'facebook'  => 'https://www.facebook.com/photo/?fbid=122093703260352686&set=a.122093703290352686',
                'linktree'  => '',
            ),
            'kamakshipalya' => array(
                'instagram' => 'https://www.instagram.com/rashtrottanabasaveshwaranagar?stkn=MXV1MnR3Z2sxNWVxOA==',
                'facebook'  => 'https://www.facebook.com/share/1ERBp1zPAh/',
                'linktree'  => '',
            ),
            'kg-nagar' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanakempegowdanagara?stkn=emk4NGNlcWl2ZWdu',
                'facebook'  => 'https://www.facebook.com/share/19M3dXaSLQ/',
                'linktree'  => '',
            ),
            'kgnagar' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanakempegowdanagara?stkn=emk4NGNlcWl2ZWdu',
                'facebook'  => 'https://www.facebook.com/share/19M3dXaSLQ/',
                'linktree'  => '',
            ),
            'nagarbhavi' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthananagarbhavi?stkn=MXRzcDl2OWp2aHFoaA==',
                'facebook'  => 'https://www.facebook.com/share/18Fz6TzN9z/',
                'linktree'  => '',
            ),
            'vijaynagar' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanavijayanagar?stkn=MmRuZ3h5bXB5dmVj',
                'facebook'  => 'https://www.facebook.com/share/1Jd2zSBJ2q/',
                'linktree'  => 'https://linktr.ee/RysriVijaynagar',
            ),
            'sunkenahalli' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanasunkenahalli?stkn=MWZyNXk4anRzbWtkcg==',
                'facebook'  => 'https://www.facebook.com/share/1Hip7xW11i/',
                'linktree'  => 'https://linktr.ee/sunkenahalli.rysri1',
            ),
            'kundalahalli' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanakundalahalli/',
                'facebook'  => 'https://www.facebook.com/rashtrotthanakundalahalli',
                'linktree'  => 'https://linktr.ee/admin/links',
            ),
            'jayanagar' => array(
                'instagram' => 'https://www.instagram.com/rashtrotthanajayanagar?stkn=cThsbDd3bDdidzl5',
                'facebook'  => 'https://www.facebook.com/share/1BsXeenHuR/',
                'linktree'  => '',
            ),
        );

        $map_url = get_post_meta($p->ID, 'map_url', true) ?: (get_field('map_url', $p->ID) ?: '');
        if (empty($map_url) && isset($fallback_maps[$c_slug])) {
            $map_url = $fallback_maps[$c_slug];
        }

        $ig_url = get_post_meta($p->ID, 'instagram_url', true) ?: (get_field('instagram_url', $p->ID) ?: '');
        if (empty($ig_url) && isset($fallback_socials[$c_slug]['instagram'])) {
            $ig_url = $fallback_socials[$c_slug]['instagram'];
        }

        $fb_url = get_post_meta($p->ID, 'facebook_url', true) ?: (get_field('facebook_url', $p->ID) ?: '');
        if (empty($fb_url) && isset($fallback_socials[$c_slug]['facebook'])) {
            $fb_url = $fallback_socials[$c_slug]['facebook'];
        }

        $lt_url = get_post_meta($p->ID, 'linktree_url', true) ?: (get_field('linktree_url', $p->ID) ?: '');
        if (empty($lt_url) && isset($fallback_socials[$c_slug]['linktree'])) {
            $lt_url = $fallback_socials[$c_slug]['linktree'];
        }

        $address = get_post_meta($p->ID, 'address', true) ?: (get_field('address', $p->ID) ?: $p->post_content);

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
            'address' => $address,
            'email' => $email,
            'image' => $img,
            'features' => !empty($features) ? $features : ['Certified Instructors', 'Spacious Shala'],
            'activity_details' => $activity_details,
            'is_hq' => get_field('is_hq', $p->ID) ?: false,
            'map_url' => $map_url,
            'instagram_url' => $ig_url,
            'facebook_url' => $fb_url,
            'linktree_url' => $lt_url,
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
    $posts = get_posts( array(
        'post_type'      => 'faq',
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'orderby'        => 'ID',
        'order'          => 'ASC',
    ) );
    $faqs = array();
    foreach ( $posts as $p ) {
        $faqs[] = array(
            'q' => $p->post_title,
            'a' => trim( strip_tags( $p->post_content ) )
        );
    }
    return $faqs;
}

// ── Activities ───────────────────────────────────────────────────────────────


function rs_get_activity_categories() {
    static $cached = null;
    if ( $cached !== null ) {
        return $cached;
    }

    $terms = get_terms( array(
        'taxonomy'   => 'activity_category',
        'hide_empty' => false,
    ) );

    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        require get_template_directory() . '/data/activities-data.php';
        $cached = isset( $activity_categories ) ? $activity_categories : array();
        return $cached;
    }

    // Desired category display order matching Home page
    $order_map = array(
        'yoga'        => 1,
        'gym'         => 2,
        'karate'      => 3,
        'music-dance' => 4,
    );

    $fallback_images = array(
        'yoga'        => content_url( '/uploads/2026/10/Yoga.jpg' ),
        'gym'         => content_url( '/uploads/2026/10/GYM.webp' ),
        'karate'      => content_url( '/uploads/2026/10/karate.jpg' ),
        'music-dance' => content_url( '/uploads/2026/10/Music.jpg' ),
    );

    $fallback_taglines = array(
        'yoga'        => 'Strength, Balance & Inner Peace',
        'gym'         => 'Strength, Stamina & Peak Fitness',
        'karate'      => 'Discipline, Agility & Self-Defence',
        'music-dance' => 'Creativity, Harmony & Soul',
    );

    $categories = array();

    foreach ( $terms as $term ) {
        $term_id = 'activity_category_' . $term->term_id;
        $slug    = $term->slug;

        $tagline = get_field( 'tagline', $term_id ) ?: ( get_term_meta( $term->term_id, 'tagline', true ) ?: ( isset( $fallback_taglines[ $slug ] ) ? $fallback_taglines[ $slug ] : '' ) );
        $text    = get_field( 'text', $term_id ) ?: ( get_term_meta( $term->term_id, 'text', true ) ?: $term->description );
        $image   = get_field( 'image', $term_id ) ?: ( get_term_meta( $term->term_id, 'image', true ) ?: ( get_term_meta( $term->term_id, 'image_url', true ) ?: ( isset( $fallback_images[ $slug ] ) ? $fallback_images[ $slug ] : '' ) ) );

        $cat_data = array(
            'slug'    => $slug,
            'title'   => $term->name,
            'tagline' => $tagline,
            'text'    => $text,
            'image'   => $image,
            'order'   => isset( $order_map[ $slug ] ) ? $order_map[ $slug ] : 99,
            'items'   => array(),
        );

        // Query sub-activities for this category
        $activities = get_posts( array(
            'post_type'      => 'activity',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'activity_category',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                ),
            ),
        ) );

        $seen_titles = array();
        foreach ( $activities as $act ) {
            $clean_title = trim( $act->post_title );
            if ( isset( $seen_titles[ $clean_title ] ) ) {
                continue;
            }
            $seen_titles[ $clean_title ] = true;

            $badge       = get_field( 'badge', $act->ID ) ?: ( get_post_meta( $act->ID, 'badge', true ) ?: 'Certified Program' );
            $centers_val = get_field( 'centers_text', $act->ID ) ?: ( get_post_meta( $act->ID, 'centers_text', true ) ?: ( get_field( 'centers', $act->ID ) ?: get_post_meta( $act->ID, 'centers', true ) ) );
            if ( empty( $centers_val ) || $centers_val === '0' || $centers_val === 0 ) {
                $centers_val = 'Available across Bengaluru Centers';
            }
            $batches     = get_field( 'batches_text', $act->ID ) ?: ( get_post_meta( $act->ID, 'batches_text', true ) ?: ( get_field( 'batches', $act->ID ) ?: ( get_post_meta( $act->ID, 'batches', true ) ?: 'Morning & Evening Batches Available' ) ) );
            $duration    = get_field( 'duration_text', $act->ID ) ?: ( get_post_meta( $act->ID, 'duration_text', true ) ?: ( get_field( 'duration', $act->ID ) ?: ( get_post_meta( $act->ID, 'duration', true ) ?: '60 Mins / Class' ) ) );
            $frequency   = get_field( 'frequency_text', $act->ID ) ?: ( get_post_meta( $act->ID, 'frequency_text', true ) ?: ( get_field( 'frequency', $act->ID ) ?: ( get_post_meta( $act->ID, 'frequency', true ) ?: 'Regular Weekly Schedule' ) ) );
            $eligibility = get_field( 'eligibility_text', $act->ID ) ?: ( get_post_meta( $act->ID, 'eligibility_text', true ) ?: ( get_field( 'eligibility', $act->ID ) ?: ( get_post_meta( $act->ID, 'eligibility', true ) ?: 'All Age Groups' ) ) );

            $cat_data['items'][] = array(
                'id'          => $act->ID,
                'name'        => $clean_title,
                'badge'       => $badge,
                'desc'        => $act->post_content,
                'centers'     => $centers_val,
                'batches'     => $batches,
                'duration'    => $duration,
                'frequency'   => $frequency,
                'eligibility' => $eligibility,
            );
        }

        $categories[] = $cat_data;
    }

    // Sort according to canonical order
    usort( $categories, function( $a, $b ) {
        return $a['order'] - $b['order'];
    } );

    $cached = $categories;
    return $cached;
}

// ── Student Registration AJAX Handler ─────────────────────────────────────────
add_action( 'wp_ajax_rs_submit_activity_registration', 'rs_handle_activity_registration' );
add_action( 'wp_ajax_nopriv_rs_submit_activity_registration', 'rs_handle_activity_registration' );

function rs_handle_activity_registration() {
    check_ajax_referer( 'rs_activity_reg_nonce', 'nonce' );

    $name     = sanitize_text_field( $_POST['student_name'] ?? '' );
    $phone    = sanitize_text_field( $_POST['student_phone'] ?? '' );
    $email    = sanitize_email( $_POST['student_email'] ?? '' );
    $activity = sanitize_text_field( $_POST['activity_name'] ?? '' );
    $center   = sanitize_text_field( $_POST['center_choice'] ?? '' );
    $timing   = sanitize_text_field( $_POST['preferred_timing'] ?? '' );
    $notes    = sanitize_textarea_field( $_POST['student_notes'] ?? '' );

    if ( empty( $name ) || empty( $phone ) || empty( $center ) ) {
        wp_send_json_error( array( 'message' => 'Please provide your Name, Phone Number, and select a Center.' ) );
    }

    $title = sprintf( 'Registration: %s (%s) - %s', $activity, $center, $name );
    $content = sprintf(
        "Student Registration Details:\n\nName: %s\nPhone: %s\nEmail: %s\nActivity: %s\nCenter: %s\nPreferred Timing: %s\nNotes: %s\nSubmitted: %s",
        $name, $phone, $email, $activity, $center, $timing, $notes, current_time( 'mysql' )
    );

    $inquiry_id = wp_insert_post( array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'rs_inquiry',
    ) );

    if ( $inquiry_id && ! is_wp_error( $inquiry_id ) ) {
        update_post_meta( $inquiry_id, '_rs_student_name', $name );
        update_post_meta( $inquiry_id, '_rs_student_phone', $phone );
        update_post_meta( $inquiry_id, '_rs_student_email', $email );
        update_post_meta( $inquiry_id, '_rs_activity', $activity );
        update_post_meta( $inquiry_id, '_rs_center', $center );
        update_post_meta( $inquiry_id, '_rs_timing', $timing );

        wp_send_json_success( array(
            'message' => sprintf(
                'Namaste %s! Your registration for "%s" at our %s Center has been successfully submitted. Our coordinator will contact you shortly.',
                $name, $activity, $center
            ),
            'inquiry_id' => $inquiry_id,
        ) );
    } else {
        wp_send_json_error( array( 'message' => 'Unable to save registration right now. Please try again or call your nearest center directly.' ) );
    }
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

function rs_format_youtube_embed( $url ) {
    if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match ) ) {
        return 'https://www.youtube.com/embed/' . $match[1];
    }
    return $url;
}

function rs_get_gallery_albums() {
    static $cached = null;
    if ( $cached !== null ) {
        return $cached;
    }

    $db_albums = get_posts( array(
        'post_type'      => 'rs_gallery_album',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'DESC',
    ) );

    if ( ! empty( $db_albums ) ) {
        $albums = array();
        foreach ( $db_albums as $p ) {
            $date     = get_post_meta( $p->ID, '_rs_album_date', true ) ?: get_the_date( 'F j, Y', $p );
            $venue    = get_post_meta( $p->ID, '_rs_album_venue', true ) ?: 'Bengaluru';
            $category = get_post_meta( $p->ID, '_rs_album_category', true ) ?: 'Special Event';
            $cat_slug = sanitize_title( $category );
            $desc     = $p->post_excerpt ?: wp_strip_all_tags( $p->post_content );

            // Cover Image
            $cover_url = get_the_post_thumbnail_url( $p->ID, 'large' );

            // Photos
            $photos_raw = get_post_meta( $p->ID, '_rs_album_photos', true );
            $photo_ids  = array();
            if ( is_string( $photos_raw ) && ! empty( $photos_raw ) ) {
                if ( $photos_raw[0] === '[' ) {
                    $photo_ids = json_decode( $photos_raw, true ) ?: array();
                } else {
                    $photo_ids = array_filter( array_map( 'intval', explode( ',', $photos_raw ) ) );
                }
            } elseif ( is_array( $photos_raw ) ) {
                $photo_ids = $photos_raw;
            }

            // Fallback: check attachments where post_parent = $p->ID
            if ( empty( $photo_ids ) ) {
                $attached = get_posts( array(
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'post_parent'    => $p->ID,
                    'posts_per_page' => 100,
                    'fields'         => 'ids',
                ) );
                if ( ! empty( $attached ) ) {
                    $photo_ids = $attached;
                }
            }

            $photos = array();
            foreach ( $photo_ids as $pid ) {
                $img_url = wp_get_attachment_image_url( $pid, 'large' ) ?: wp_get_attachment_url( $pid );
                if ( ! $img_url ) {
                    continue;
                }
                $photos[] = array(
                    'id'      => $pid,
                    'title'   => get_the_title( $pid ),
                    'url'     => $img_url,
                    'caption' => wp_get_attachment_caption( $pid ) ?: get_the_title( $pid ),
                );
            }

            if ( ! $cover_url && ! empty( $photos ) ) {
                $cover_url = $photos[0]['url'];
            }

            // Videos
            $videos_raw = get_post_meta( $p->ID, '_rs_album_videos', true );
            $videos     = array();
            if ( is_string( $videos_raw ) && ! empty( $videos_raw ) ) {
                $videos = json_decode( $videos_raw, true ) ?: array();
            } elseif ( is_array( $videos_raw ) ) {
                $videos = $videos_raw;
            }

            foreach ( $videos as &$vid ) {
                $v_url = isset( $vid['url'] ) ? $vid['url'] : ( isset( $vid['embed_url'] ) ? $vid['embed_url'] : '' );
                $vid['embed_url'] = rs_format_youtube_embed( $v_url );
                if ( empty( $vid['duration'] ) && ! empty( $vid['subtitle'] ) ) {
                    $vid['duration'] = $vid['subtitle'];
                }
                if ( empty( $vid['subtitle'] ) ) {
                    $vid['subtitle'] = 'Event Highlights';
                }
                if ( empty( $vid['thumb'] ) ) {
                    $vid['thumb'] = $cover_url ?: ( ! empty( $photos ) ? $photos[0]['url'] : '' );
                }
            }
            unset( $vid );

            $albums[] = array(
                'id'            => $p->post_name,
                'title'         => $p->post_title,
                'category'      => $category,
                'category_slug' => $cat_slug,
                'date'          => $date,
                'venue'         => $venue,
                'desc'          => $desc,
                'cover_image'   => $cover_url ?: get_template_directory_uri() . '/assets/images/mandala-bg.jpg',
                'photos'        => $photos,
                'videos'        => $videos,
            );
        }

        $cached = $albums;
        return $cached;
    }

    // Load from static data file as fallback if no DB albums exist
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
