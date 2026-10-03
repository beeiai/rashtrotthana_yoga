<?php
require_once('wp-load.php');
require_once('wp-content/themes/rashtrotthana/data/activities-data.php');
foreach ($activity_categories as $cat) {
    $term = get_term_by('name', $cat['title'], 'activity_category');
    if ($term) {
        update_term_meta($term->term_id, 'image_url', $cat['image']);
    }
}
