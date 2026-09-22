<?php
/**
 * CMS Data Population Script
 * Extracts hardcoded arrays from the theme and inserts them into the WP Database as CPTs.
 */
echo "Starting CMS Data Population...\n";

$theme_dir = dirname(dirname(dirname(__FILE__))) . '/D:\Rashtrotthana_yoga\wp-content\themes\rashtrotthana';
// Actually, since this is running from cli, just use absolute path:
$theme_dir = 'D:/Rashtrotthana_yoga/wp-content/themes/rashtrotthana';

require_once $theme_dir . '/data/events-data.php';
require_once $theme_dir . '/data/activities-data.php';
require_once $theme_dir . '/data/centers-data.php';

// 1. POPULATE CENTERS
echo "Populating Centers...\n";
foreach ($centers as $c) {
    // Check if exists
    $existing = get_page_by_title($c['name'], OBJECT, 'center');
    if (!$existing) {
        $post_id = wp_insert_post([
            'post_title'   => $c['name'],
            'post_content' => "Address: {$c['address']}\nPhone: {$c['phone']}\nEmail: {$c['email']}",
            'post_type'    => 'center',
            'post_status'  => 'publish'
        ]);
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_ry_center_area', $c['area']);
            update_post_meta($post_id, '_ry_center_zone', $c['zone']);
            update_post_meta($post_id, '_ry_center_lat', $c['lat']);
            update_post_meta($post_id, '_ry_center_lng', $c['lng']);
            update_post_meta($post_id, '_ry_center_phone', $c['phone']);
            update_post_meta($post_id, '_ry_center_hours', $c['hours']);
            update_post_meta($post_id, '_ry_center_email', $c['email']);
            update_post_meta($post_id, '_ry_image_url', $c['image']); // Store URL to avoid downloading 100s of images
            echo " - Created Center: {$c['name']}\n";
        }
    } else {
        echo " - Center exists: {$c['name']}\n";
    }
}

// 2. POPULATE EVENTS
echo "Populating Events...\n";
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
            update_post_meta($post_id, '_ry_event_date', $e['date_iso']);
            
            $times = explode(' – ', $e['time']);
            update_post_meta($post_id, '_ry_start_time', trim($times[0] ?? ''));
            update_post_meta($post_id, '_ry_end_time', trim($times[1] ?? ''));
            
            update_post_meta($post_id, '_ry_event_fee', $e['fee']);
            update_post_meta($post_id, '_ry_event_mode', $e['mode']);
            update_post_meta($post_id, '_ry_image_url', $e['image']);
            
            // Link to a center by name if possible
            $center_obj = get_page_by_title(trim(explode('&', $e['venue'])[0]), OBJECT, 'center');
            if ($center_obj) {
                update_post_meta($post_id, '_ry_event_centers', [$center_obj->post_title]);
            }
            
            echo " - Created Event: {$e['title']}\n";
        }
    } else {
        echo " - Event exists: {$e['title']}\n";
    }
}

// 3. POPULATE NEWS (Standard Posts)
echo "Populating News...\n";
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
            update_post_meta($post_id, '_ry_read_time', $n['read_time']);
            wp_set_post_categories($post_id, [wp_create_category('News')]);
            echo " - Created News: {$n['title']}\n";
        }
    } else {
        echo " - News exists: {$n['title']}\n";
    }
}

// 4. POPULATE ACTIVITIES
echo "Populating Activities...\n";
foreach ($activity_categories as $cat) {
    foreach ($cat['items'] as $act) {
        $existing = get_page_by_title($act['name'], OBJECT, 'activity');
        if (!$existing) {
            $post_id = wp_insert_post([
                'post_title'   => $act['name'],
                'post_content' => "Category: {$cat['slug']}\nBadge: {$act['badge']}",
                'post_type'    => 'activity',
                'post_status'  => 'publish'
            ]);
            if (!is_wp_error($post_id)) {
                echo " - Created Activity: {$act['name']}\n";
            }
        } else {
            echo " - Activity exists: {$act['name']}\n";
        }
    }
}

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
        
        // If it's the home page, set it as the front page
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

echo "CMS Population Complete!\n";
