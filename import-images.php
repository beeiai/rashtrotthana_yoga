<?php
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require get_template_directory() . '/data/activities-data.php';

$acts = get_posts(['post_type' => 'activity', 'posts_per_page' => -1]);
$map = [];
foreach ($activity_categories as $cat) {
    foreach ($cat['items'] as $item) {
        $path = str_replace(get_template_directory_uri(), get_template_directory(), $cat['image']);
        $map[$item['name']] = $path;
    }
}

foreach ($acts as $act) {
    if (isset($map[$act->post_title])) {
        $file = $map[$act->post_title];
        if (file_exists($file)) {
            if (!has_post_thumbnail($act->ID)) {
                echo 'Importing for ' . $act->post_title . '... ';
                
                // Construct fake upload array to use media_handle_sideload
                $file_array = ['name' => basename($file), 'tmp_name' => $file];
                
                // Read file into tmp location because sideload moves it
                $tmp = wp_tempnam($file);
                copy($file, $tmp);
                $file_array['tmp_name'] = $tmp;

                $att_id = media_handle_sideload($file_array, $act->ID, null);
                if (!is_wp_error($att_id)) {
                    set_post_thumbnail($act->ID, $att_id);
                    echo 'Success: ' . $att_id . "\n";
                } else {
                    echo 'Error: ' . $att_id->get_error_message() . "\n";
                }
            } else {
                echo "Already has thumbnail: {$act->post_title}\n";
            }
        } else {
            echo "File not found for {$act->post_title}: $file\n";
        }
    } else {
        echo "No category match for {$act->post_title}\n";
    }
}
