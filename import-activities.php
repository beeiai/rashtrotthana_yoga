<?php
require_once('wp-load.php');
require_once('wp-content/themes/rashtrotthana/data/activities-data.php');

foreach ( $activity_categories as $cat ) {
    $term = term_exists( $cat['slug'], 'activity_category' );
    if ( ! $term ) {
        $term = wp_insert_term(
            $cat['title'],
            'activity_category',
            array('slug' => $cat['slug'])
        );
    }
    if ( is_wp_error($term) ) continue;
    $term_id = is_array($term) ? $term['term_id'] : $term;
    $term_key = 'activity_category_' . $term_id;

    update_field('icon', $cat['icon'], $term_key);
    update_field('tagline', $cat['tagline'], $term_key);
    update_field('text', $cat['text'], $term_key);
    update_field('image', $cat['image'], $term_key);

    foreach ( $cat['items'] as $item ) {
        $existing = get_page_by_title( $item['name'], OBJECT, 'activity' );
        if ( $existing ) {
            $post_id = $existing->ID;
        } else {
            $post_id = wp_insert_post( array(
                'post_title'   => $item['name'],
                'post_type'    => 'activity',
                'post_status'  => 'publish',
            ) );
        }
        wp_set_object_terms( $post_id, intval($term_id), 'activity_category' );
        update_field('badge', $item['badge'], $post_id);
        update_field('description', $item['desc'], $post_id);
        update_field('centers_text', $item['centers'], $post_id);
        update_field('batches_text', $item['batches'], $post_id);
        update_field('duration_text', $item['duration'], $post_id);
        if (isset($item['frequency'])) update_field('frequency_text', $item['frequency'], $post_id);
        if (isset($item['eligibility'])) update_field('eligibility_text', $item['eligibility'], $post_id);
    }
}
echo "Activities Imported Successfully!\n";
