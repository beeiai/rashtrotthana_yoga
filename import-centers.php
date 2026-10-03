<?php
require_once('wp-load.php');

echo "Deleting old centers...\n";
$args = array(
    'post_type' => 'center',
    'posts_per_page' => -1,
    'post_status' => 'any'
);
$old_centers = get_posts($args);
foreach ($old_centers as $oc) {
    wp_delete_post($oc->ID, true);
}
echo "Deleted " . count($old_centers) . " old centers.\n";

require_once(get_template_directory() . '/data/centers-data.php');

echo "Importing " . count($centers) . " new centers from centers-data.php...\n";

foreach ($centers as $c) {
    $post_data = array(
        'post_title' => $c['name'],
        'post_content' => $c['address'],
        'post_status' => 'publish',
        'post_type' => 'center',
        'post_name' => $c['id']
    );
    
    $post_id = wp_insert_post($post_data);
    if (is_wp_error($post_id)) {
        echo "Error inserting " . $c['name'] . "\n";
        continue;
    }
    
    // Update ACF fields using keys from acf-setup.php
    update_field('field_c_area', $c['area'], $post_id);
    update_field('field_c_zone', $c['zone'], $post_id);
    update_field('field_c_address', $c['address'], $post_id);
    update_field('field_c_phone', $c['phone'], $post_id);
    update_field('field_c_email', $c['email'], $post_id);
    update_field('field_c_hours', $c['hours'], $post_id);
    update_field('field_c_lat', $c['lat'], $post_id);
    update_field('field_c_lng', $c['lng'], $post_id);
    update_field('field_c_is_hq', isset($c['is_hq']) ? $c['is_hq'] : false, $post_id);
    update_field('field_c_is_featured', true, $post_id); // we'll just feature them all
    
    // Programs Repeater
    if (!empty($c['activity_details'])) {
        $programs = array();
        foreach ($c['activity_details'] as $act) {
            $programs[] = array(
                'program_name' => $act['name'],
                'badge' => $act['badge'],
                'days' => $act['days'],
                'timings' => $act['timings'],
                'dates' => $act['dates'],
                'desc' => $act['desc'],
            );
        }
        update_field('field_c_programs', $programs, $post_id);
    }
    
    // Features Repeater
    if (!empty($c['features'])) {
        $features = array();
        foreach ($c['features'] as $f) {
            $features[] = array(
                'feature_name' => $f
            );
        }
        update_field('field_c_features', $features, $post_id);
    }
    
    echo "Imported center: " . $c['name'] . "\n";
}

echo "Done.\n";
