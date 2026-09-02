<?php

function rashtrotthana_enqueue_assets() {

    wp_enqueue_style(
        'rashtrotthana-style',
        get_stylesheet_uri(),
        array(),
        '1.0.6'
    );

    wp_enqueue_script(
        'rashtrotthana-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        array(),
        '1.0.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'rashtrotthana_enqueue_assets');

function rashtrotthana_theme_setup() {

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'rashtrotthana'),
        'footer'  => __('Footer Menu', 'rashtrotthana'),
    ));
}

add_action('after_setup_theme', 'rashtrotthana_theme_setup');

/**
 * Return published content for a homepage collection, without requiring a CPT.
 * A future content integration can register any of the supplied post types; until
 * then the presentation templates display their design fallback data.
 *
 * @param string[] $post_types Candidate post types.
 * @param int      $limit      Number of items.
 * @return WP_Post[]
 */
function rashtrotthana_home_collection( $post_types, $limit = 5 ) {
    $available_types = array_filter( $post_types, 'post_type_exists' );

    if ( empty( $available_types ) ) {
        return array();
    }

    return get_posts(
        array(
            'post_type'           => $available_types,
            'post_status'         => 'publish',
            'posts_per_page'      => absint( $limit ),
            'orderby'             => 'menu_order date',
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
        )
    );
}
