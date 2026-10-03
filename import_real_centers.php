<?php
// Delete old centers
$old_centers = get_posts(['post_type' => ['center', 'rs_center'], 'posts_per_page' => -1, 'post_status' => 'any']);
foreach ($old_centers as $c) {
    wp_delete_post($c->ID, true);
}
echo "Deleted " . count($old_centers) . " old centers.\n";

$json = file_get_contents(__DIR__ . '/parsed_centers.json');
$centers = json_decode($json, true);

foreach ($centers as $c) {
    $post_id = wp_insert_post([
        'post_title' => $c['name'],
        'post_type' => 'rs_center',
        'post_status' => 'publish',
        'post_content' => $c['address']
    ]);

    update_post_meta($post_id, 'phone', $c['phone']);
    update_post_meta($post_id, 'area', $c['name']);
    
    // Set some random image
    $images = glob(__DIR__ . '/wp-content/themes/rashtrotthana/assets/images/client/*.{jpg,jpeg,png}', GLOB_BRACE);
    if (!empty($images)) {
        $img = basename($images[array_rand($images)]);
        update_post_meta($post_id, '_ry_image_url', get_template_directory_uri() . '/assets/images/client/' . $img);
    }
    
    // Add activities as ACF repeater
    $count = count($c['activities']);
    update_post_meta($post_id, 'programs', $count);
    
    for ($i = 0; $i < $count; $i++) {
        $act = $c['activities'][$i];
        update_post_meta($post_id, 'programs_' . $i . '_program_name', $act['name']);
        update_post_meta($post_id, 'programs_' . $i . '_timings', $act['time']);
    }

    echo "Inserted: " . $c['name'] . "\n";
}
