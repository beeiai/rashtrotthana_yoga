<?php
/**
 * CMS Data Population Script
 * Extracts hardcoded arrays from the theme and inserts them into the WP Database as CPTs and ACF Options.
 */
echo "Starting Comprehensive CMS Data Population...\n";

// Disable term counting and cache addition for performance during import
wp_defer_term_counting(true);
wp_defer_comment_counting(true);

$theme_dir = 'D:/Rashtrotthana_yoga/wp-content/themes/rashtrotthana';

require_once $theme_dir . '/data/events-data.php';
require_once $theme_dir . '/data/activities-data.php';
require_once $theme_dir . '/data/centers-data.php';
require_once $theme_dir . '/data/gallery-data.php';
require_once $theme_dir . '/data/homepage-data.php';

// Ensure ACF is active
if ( ! function_exists('update_field') ) {
    die("Error: Advanced Custom Fields (ACF) is not active. Please activate it first.\n");
}

// ── 1. GLOBAL & PAGE OPTIONS (ACF) ──────────────────────────────────────────
echo "\nPopulating ACF Global Options (Homepage, About Us, Footer)...\n";

// Footer & Contact
update_field('ry_phone_primary', '+91 80 1234 5678', 'option');
update_field('ry_email_primary', 'info@rashtrotthana.org', 'option');
update_field('ry_address_primary', "#1, Rashtrotthana Complex,\nMalleswaram, Bengaluru - 560003\nKarnataka, India", 'option');
update_field('ry_facebook_url', '#', 'option');
update_field('ry_instagram_url', '#', 'option');
update_field('ry_youtube_url', '#', 'option');
update_field('ry_twitter_url', '#', 'option');

// Homepage Hero & Founder
update_field('ry_hero_title', 'Building a Healthy & Sustainable Society', 'option');
update_field('ry_hero_subtitle', 'Through Yoga, Education, Culture and Service, we strive for the holistic well-being of every individual and the upliftment of the society.', 'option');
update_field('ry_hero_button_text', 'Explore Activities', 'option');
update_field('ry_hero_button_url', '/activities/', 'option');

if (isset($rs_home_founder)) {
    update_field('ry_home_founder_name', $rs_home_founder['name'], 'option');
    update_field('ry_home_founder_title', $rs_home_founder['role'], 'option');
    update_field('ry_home_founder_subtitle', $rs_home_founder['subtitle'], 'option');
    update_field('ry_home_founder_photo', $rs_home_founder['image'], 'option');
    update_field('ry_home_founder_bio', implode("\n\n", $rs_home_founder['paragraphs']), 'option');
    update_field('ry_home_founder_quote', $rs_home_founder['quote'], 'option');
    update_field('ry_home_founder_quote_attr', $rs_home_founder['quote_author'], 'option');
}

if (isset($rs_home_stats)) {
    update_field('ry_home_stats', $rs_home_stats, 'option');
}

// About Us Vision/Mission
update_field('ry_about_vision_title', 'Our Vision', 'option');
update_field('ry_about_vision_text', '<p>To create a sustainable healthy society by integrating the ancient wisdom of Patanjali Yoga with modern scientific understanding, making holistic wellness accessible to all sections of society.</p>', 'option');
update_field('ry_about_vision_image', get_template_directory_uri() . '/assets/images/client/rysri-sadashivanagar.jpg', 'option');

update_field('ry_about_mission_title', 'Our Mission', 'option');
update_field('ry_about_mission_text', '<p>To establish world-class yoga training centers, conduct clinical research on yogic therapies, and cultivate a community of dedicated practitioners who lead by example in physical vitality, mental clarity, and spiritual harmony.</p>', 'option');
update_field('ry_about_mission_image', get_template_directory_uri() . '/assets/images/client/rysri-kundalahalli-1-.jpg', 'option');

$timeline = [
    ["year" => "Early 1990s", "title" => "The Beginning", "desc" => "The vision took root with a small, intimate Yoga class in Jayanagar."],
    ["year" => "1995 &ndash; 2000", "title" => "Expansion", "desc" => "Yoga programs expanded rapidly to diverse residential sectors of Bengaluru."],
    ["year" => "2000 &ndash; 2010", "title" => "Growth", "desc" => "Establishment of multiple dedicated centers with morning and evening batches."],
    ["year" => "2010 &ndash; 2020", "title" => "Reaching Out", "desc" => "Reaching communities across Karnataka with 23+ fully equipped yoga centers."],
    ["year" => "2020 &amp; Beyond", "title" => "The Future", "desc" => "Advancing specialized yoga therapy, digital classes, and youth leadership."]
];
update_field('ry_about_timeline', $timeline, 'option');

$def_img = get_template_directory_uri() . "/assets/images/hero-v3.png";
$team = [
    ["name" => "Ananya H.", "role" => "Yoga & Wellness", "desc" => "Creating welcoming spaces where every person can find balance and strength.", "photo" => $def_img],
    ["name" => "Prasanna B.", "role" => "Education & Values", "desc" => "Nurturing confident learners through discipline, curiosity and timeless values.", "photo" => $def_img],
    ["name" => "Ramesh K.", "role" => "Community Service", "desc" => "Connecting people and purpose through meaningful service across our communities.", "photo" => $def_img],
    ["name" => "Meera S.", "role" => "Culture & Outreach", "desc" => "Sharing the richness of Indian culture while building a kinder, stronger society.", "photo" => $def_img],
];
update_field('ry_about_team', $team, 'option');

// ── 2. POPULATE CENTERS ──────────────────────────────────────────────────
echo "\nPopulating Centers...\n";
foreach ($centers as $c) {
    $existing = get_page_by_title($c['name'], OBJECT, 'center');
    if (!$existing) {
        $post_id = wp_insert_post([
            'post_title'   => $c['name'],
            'post_content' => $c['address'],
            'post_type'    => 'center',
            'post_status'  => 'publish'
        ]);
        if (!is_wp_error($post_id)) {
            update_field('area', $c['area'], $post_id);
            update_field('zone', $c['zone'], $post_id);
            update_field('lat', $c['lat'], $post_id);
            update_field('lng', $c['lng'], $post_id);
            update_field('phone', $c['phone'], $post_id);
            update_field('hours', $c['hours'], $post_id);
            update_field('email', $c['email'], $post_id);
            
            // Reformat programs for ACF Repeater
            if (!empty($c['programs'])) {
                $progs = array_map(function($p) { return ['program_name' => $p]; }, $c['programs']);
                update_field('programs', $progs, $post_id);
            }
            if (!empty($c['features'])) {
                $feats = array_map(function($f) { return ['feature_name' => $f]; }, $c['features']);
                update_field('features', $feats, $post_id);
            }
            
            if (isset($c['is_hq']) && $c['is_hq']) {
                update_field('is_hq', 1, $post_id);
            }

            update_post_meta($post_id, '_ry_image_url', $c['image']);
            echo " - Created Center: {$c['name']}\n";
        }
    } else {
        echo " - Center exists: {$c['name']}\n";
    }
}

// ── 3. POPULATE EVENTS ───────────────────────────────────────────────────
echo "\nPopulating Events...\n";
foreach ($events_dataset as $e) {
    $existing = get_page_by_title($e['title'], OBJECT, 'event');
    if (!$existing) {
        $post_id = wp_insert_post([
            'post_title'   => $e['title'],
            'post_content' => $e['desc'],
            'post_type'    => 'event',
            'post_status'  => 'publish'
        ]);
        if (!is_wp_error($post_id)) {
            update_field('event_date', $e['date_iso'], $post_id);
            update_field('event_time', $e['time'], $post_id);
            update_field('event_fee', $e['fee'], $post_id);
            update_field('event_mode', $e['mode'], $post_id);
            update_post_meta($post_id, '_ry_image_url', $e['image']);
            
            // Link to a center by name if possible
            $center_obj = get_page_by_title(trim(explode('&', $e['venue'])[0]), OBJECT, 'center');
            if ($center_obj) {
                update_field('event_venue', $center_obj->ID, $post_id);
            } else {
                update_field('event_venue_custom', $e['venue'], $post_id);
            }
            
            echo " - Created Event: {$e['title']}\n";
        }
    } else {
        echo " - Event exists: {$e['title']}\n";
    }
}

// ── 4. POPULATE ACTIVITIES ───────────────────────────────────────────────
echo "\nPopulating Activities...\n";
foreach ($activity_categories as $cat) {
    // 1. Create the Taxonomy Term if it doesn't exist
    $term = term_exists($cat['title'], 'activity_category');
    if (!$term) {
        $term = wp_insert_term($cat['title'], 'activity_category', ['slug' => $cat['slug']]);
    }
    if (!is_wp_error($term)) {
        $term_id = is_array($term) ? $term['term_id'] : $term;
        update_field('icon', $cat['icon'], 'activity_category_' . $term_id);
        update_field('tagline', $cat['tagline'], 'activity_category_' . $term_id);
        update_field('text', $cat['text'], 'activity_category_' . $term_id);
        update_field('image', $cat['image'], 'activity_category_' . $term_id);
    }

    // 2. Create the child Activities
    foreach ($cat['items'] as $act) {
        $existing = get_page_by_title($act['name'], OBJECT, 'activity');
        if (!$existing) {
            $post_id = wp_insert_post([
                'post_title'   => $act['name'],
                'post_content' => $act['desc'],
                'post_type'    => 'activity',
                'post_status'  => 'publish'
            ]);
            if (!is_wp_error($post_id)) {
                update_field('badge', $act['badge'], $post_id);
                update_field('duration', $act['duration'], $post_id);
                update_field('frequency', $act['frequency'], $post_id);
                update_field('eligibility', $act['eligibility'], $post_id);
                update_field('batches', $act['batches'], $post_id);

                if (!is_wp_error($term)) {
                    wp_set_post_terms($post_id, [$term_id], 'activity_category');
                }
                echo " - Created Activity: {$act['name']}\n";
            }
        } else {
            echo " - Activity exists: {$act['name']}\n";
        }
    }
}

// ── 5. POPULATE GALLERY ──────────────────────────────────────────────────
echo "\nPopulating Gallery Albums...\n";
foreach ($gallery_events as $alb) {
    $existing = get_page_by_title($alb['title'], OBJECT, 'gallery_album');
    if (!$existing) {
        $post_id = wp_insert_post([
            'post_title'   => $alb['title'],
            'post_content' => $alb['desc'],
            'post_type'    => 'gallery_album',
            'post_status'  => 'publish'
        ]);
        if (!is_wp_error($post_id)) {
            // Photos
            if (!empty($alb['photos'])) {
                update_field('photos', $alb['photos'], $post_id);
            }
            // Videos
            if (!empty($alb['videos'])) {
                update_field('videos', $alb['videos'], $post_id);
            }
            // Assign dummy cover image logic
            update_post_meta($post_id, '_ry_image_url', $alb['cover_image'] ?? '');
            echo " - Created Gallery Album: {$alb['title']}\n";
        }
    } else {
        echo " - Gallery Album exists: {$alb['title']}\n";
    }
}

// ── 6. POPULATE NEWS ─────────────────────────────────────────────────────
echo "\nPopulating News...\n";
foreach ($news_dataset as $n) {
    $existing = get_page_by_title($n['title'], OBJECT, 'post');
    if (!$existing) {
        $post_id = wp_insert_post([
            'post_title'   => $n['title'],
            'post_content' => $n['full_text'],
            'post_excerpt' => $n['excerpt'],
            'post_type'    => 'post',
            'post_status'  => 'publish'
        ]);
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_ry_image_url', $n['image']);
            wp_set_post_categories($post_id, [wp_create_category('News')]);
            echo " - Created News: {$n['title']}\n";
        }
    } else {
        echo " - News exists: {$n['title']}\n";
    }
}

// ── 7. POPULATE CORE PAGES ───────────────────────────────────────────────
echo "\nPopulating Core Pages...\n";
$core_pages = [
    ['title' => 'Home', 'slug' => 'home', 'template' => 'front-page.php'],
    ['title' => 'About Us', 'slug' => 'about-us', 'template' => 'page-about-us.php'],
    ['title' => 'Activities', 'slug' => 'activities', 'template' => 'page-activities.php'],
    ['title' => 'Centers', 'slug' => 'centers', 'template' => 'page-centers.php'],
    ['title' => 'Events', 'slug' => 'events', 'template' => 'page-events.php'],
    ['title' => 'Gallery', 'slug' => 'gallery', 'template' => 'page-gallery.php'],
    ['title' => 'Contact Us', 'slug' => 'contact-us', 'template' => 'page-contact-us.php'],
];

foreach ($core_pages as $p) {
    $existing = get_page_by_path($p['slug']);
    if (!$existing) {
        $page_id = wp_insert_post([
            'post_title' => $p['title'],
            'post_name' => $p['slug'],
            'post_status' => 'publish',
            'post_type' => 'page'
        ]);
        update_post_meta($page_id, '_wp_page_template', $p['template']);
        echo " - Created page: " . $p['title'] . "\n";
        
        if ($p['slug'] === 'home') {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $page_id);
        }
    } else {
        update_post_meta($existing->ID, '_wp_page_template', $p['template']);
        echo " - Page exists: " . $p['title'] . " (Template assigned)\n";
        
        if ($p['slug'] === 'home') {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $existing->ID);
        }
    }
}

wp_defer_term_counting(false);
wp_defer_comment_counting(false);
echo "\n============================================\n";
echo "CMS Population & ACF Mapping Complete!\n";
echo "============================================\n";
