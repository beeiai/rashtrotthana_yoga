<?php
/**
 * Rashtrotthana Yoga — functions.php
 *
 * This file is the theme bootstrap. It loads modular inc/ files:
 *   • inc/enqueue.php        — all wp_enqueue_style / wp_enqueue_script calls
 *   • inc/cpt-registration.php — Custom Post Type registrations
 *   • inc/data-helpers.php   — data query functions (teammate's integration point)
 *
 * IMPORTANT: Do NOT add business logic here. Use the appropriate inc/ file.
 */

// ── Modular Includes ──────────────────────────────────────────────────────────
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/cpt-registration.php';
require_once get_template_directory() . '/inc/data-helpers.php';

// ── Theme Setup ───────────────────────────────────────────────────────────────
if ( ! function_exists( 'rashtrotthana_theme_setup' ) ) :

function rashtrotthana_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'rashtrotthana' ),
        'footer'  => __( 'Footer Menu', 'rashtrotthana' ),
    ) );
}

add_action( 'after_setup_theme', 'rashtrotthana_theme_setup' );

endif;

// ── Legacy Homepage Collection Helper ────────────────────────────────────────
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

    return get_posts( array(
        'post_type'           => $available_types,
        'post_status'         => 'publish',
        'posts_per_page'      => absint( $limit ),
        'orderby'             => 'menu_order date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
    ) );
}
require_once get_template_directory() . '/inc/acf-setup.php'; 
