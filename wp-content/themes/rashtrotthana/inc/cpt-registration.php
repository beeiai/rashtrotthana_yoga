<?php
/**
 * Custom Post Type Registration — Rashtrotthana Yoga
 *
 * Registers all CPTs used across the theme.
 * Once registered, your backend teammate can add ACF / custom meta fields
 * and migrate data from the data/ folder into WordPress posts.
 *
 * HOW TO ADD ACF FIELDS:
 * Install Advanced Custom Fields plugin, then map fields to these post types.
 * Each CPT has a "DB Field Mapping" comment showing what keys the templates expect.
 */

if ( ! function_exists( 'rs_register_post_types' ) ) :

function rs_register_post_types() {

    // ── rs_center ─────────────────────────────────────────────────────────────
    // DB Field Mapping: id, name, area, zone, zone_slug, lat, lng, phone, hours,
    //                   timing, timing_label, programs[], activities[], address,
    //                   email, image, features[], activities_detail[], events[]
    register_post_type( 'rs_center', array(
        'labels'        => array(
            'name'          => __( 'Centers', 'rashtrotthana' ),
            'singular_name' => __( 'Center', 'rashtrotthana' ),
            'add_new_item'  => __( 'Add New Center', 'rashtrotthana' ),
            'edit_item'     => __( 'Edit Center', 'rashtrotthana' ),
        ),
        'public'        => true,
        'has_archive'   => false,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-location',
        'supports'      => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite'       => array( 'slug' => 'center' ),
    ) );

    // ── rs_event ──────────────────────────────────────────────────────────────
    // DB Field Mapping: id, day, month, year, date_iso, timeframe, title, venue,
    //                   time, category, category_slug, mode, type, image, desc, fee
    register_post_type( 'rs_event', array(
        'labels'        => array(
            'name'          => __( 'Events', 'rashtrotthana' ),
            'singular_name' => __( 'Event', 'rashtrotthana' ),
            'add_new_item'  => __( 'Add New Event', 'rashtrotthana' ),
            'edit_item'     => __( 'Edit Event', 'rashtrotthana' ),
        ),
        'public'        => true,
        'has_archive'   => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-calendar-alt',
        'supports'      => array( 'title', 'thumbnail', 'excerpt', 'editor', 'custom-fields' ),
        'rewrite'       => array( 'slug' => 'event' ),
    ) );

    // ── rs_activity_category ──────────────────────────────────────────────────
    // DB Field Mapping: slug, icon, title, tagline, text, image, items[]
    //   Each item: name, badge, desc, centers, batches, duration, frequency, eligibility
    register_post_type( 'rs_activity', array(
        'labels'        => array(
            'name'          => __( 'Activity Categories', 'rashtrotthana' ),
            'singular_name' => __( 'Activity Category', 'rashtrotthana' ),
            'add_new_item'  => __( 'Add New Activity Category', 'rashtrotthana' ),
            'edit_item'     => __( 'Edit Activity Category', 'rashtrotthana' ),
        ),
        'public'        => true,
        'has_archive'   => false,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-universal-access',
        'supports'      => array( 'title', 'thumbnail', 'excerpt', 'editor', 'custom-fields', 'page-attributes' ),
        'rewrite'       => array( 'slug' => 'activity' ),
    ) );

    // ── rs_member ─────────────────────────────────────────────────────────────
    // DB Field Mapping: name (post_title), role (meta), bio (excerpt/content), image (thumbnail)
    register_post_type( 'rs_member', array(
        'labels'        => array(
            'name'          => __( 'Team Members', 'rashtrotthana' ),
            'singular_name' => __( 'Team Member', 'rashtrotthana' ),
            'add_new_item'  => __( 'Add New Member', 'rashtrotthana' ),
            'edit_item'     => __( 'Edit Member', 'rashtrotthana' ),
        ),
        'public'        => false,
        'show_ui'       => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-groups',
        'supports'      => array( 'title', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields' ),
    ) );

    // ── rs_gallery_album ──────────────────────────────────────────────────────
    // DB Field Mapping: id, title, category, category_slug, date, venue, desc,
    //                   cover_image, photos[], videos[]
    register_post_type( 'rs_gallery_album', array(
        'labels'        => array(
            'name'          => __( 'Gallery Albums', 'rashtrotthana' ),
            'singular_name' => __( 'Gallery Album', 'rashtrotthana' ),
            'add_new_item'  => __( 'Add New Gallery Album', 'rashtrotthana' ),
            'edit_item'     => __( 'Edit Gallery Album', 'rashtrotthana' ),
        ),
        'public'        => false,
        'show_ui'       => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-format-gallery',
        'supports'      => array( 'title', 'thumbnail', 'excerpt', 'editor', 'custom-fields', 'page-attributes' ),
    ) );
}

add_action( 'init', 'rs_register_post_types' );

endif; // rs_register_post_types
