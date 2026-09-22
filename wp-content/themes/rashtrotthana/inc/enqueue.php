<?php
/**
 * Asset Enqueuing — Rashtrotthana Yoga
 *
 * Centralizes all wp_enqueue_style / wp_enqueue_script calls.
 * Per-page CSS and JS are enqueued conditionally so they only load on the
 * relevant page — better performance and easier cache-busting.
 */

if ( ! function_exists( 'rashtrotthana_enqueue_assets' ) ) :

function rashtrotthana_enqueue_assets() {

    // ── Global Styles ─────────────────────────────────────────────────────────
    wp_enqueue_style(
        'rashtrotthana-style',
        get_stylesheet_uri(),
        array(),
        '1.0.8'
    );

    wp_enqueue_style(
        'rashtrotthana-inner-pages',
        get_template_directory_uri() . '/assets/css/inner-pages.css',
        array( 'rashtrotthana-style' ),
        '2.1.0'
    );

    // ── Global Scripts ────────────────────────────────────────────────────────
    wp_enqueue_script(
        'rashtrotthana-inner-pages',
        get_template_directory_uri() . '/assets/js/inner-pages.js',
        array(),
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'rashtrotthana-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        array(),
        '1.0.1',
        true
    );

    // ── Homepage & About Us ───────────────────────────────────────────────────
    if ( is_front_page() || is_page( 'about-us' ) ) {
        wp_enqueue_style(
            'rashtrotthana-homepage-effects',
            get_template_directory_uri() . '/assets/css/homepage-effects.css',
            array( 'rashtrotthana-style' ),
            '2.0.0'
        );
        wp_enqueue_script(
            'rashtrotthana-homepage-effects',
            get_template_directory_uri() . '/assets/js/homepage-effects.js',
            array(),
            '2.0.0',
            true
        );
    }

    // ── Activities Page ───────────────────────────────────────────────────────
    // NOTE: page-activities.css / page-activities.js do NOT exist yet.
    // They will be created when inline <style> and <script> blocks are
    // extracted from page-activities.php (Phase 2 of the refactoring).
    /*
    if ( is_page( 'activities' ) ) {
        wp_enqueue_style(
            'rashtrotthana-activities',
            get_template_directory_uri() . '/assets/css/page-activities.css',
            array( 'rashtrotthana-inner-pages' ),
            '1.0.0'
        );
        wp_enqueue_script(
            'rashtrotthana-activities',
            get_template_directory_uri() . '/assets/js/page-activities.js',
            array(),
            '1.0.0',
            true
        );
    }
    */

    // ── Centers Page ──────────────────────────────────────────────────────────
    /*
    if ( is_page( 'centers' ) ) {
        wp_enqueue_style(
            'rashtrotthana-centers',
            get_template_directory_uri() . '/assets/css/page-centers.css',
            array( 'rashtrotthana-inner-pages' ),
            '1.0.0'
        );
        wp_enqueue_script(
            'rashtrotthana-centers',
            get_template_directory_uri() . '/assets/js/page-centers.js',
            array(),
            '1.0.0',
            true
        );
    }
    */

    // ── Events Page ───────────────────────────────────────────────────────────
    /*
    if ( is_page( 'events' ) ) {
        wp_enqueue_style(
            'rashtrotthana-events',
            get_template_directory_uri() . '/assets/css/page-events.css',
            array( 'rashtrotthana-inner-pages' ),
            '1.0.0'
        );
        wp_enqueue_script(
            'rashtrotthana-events',
            get_template_directory_uri() . '/assets/js/page-events.js',
            array(),
            '1.0.0',
            true
        );
    }
    */

    // ── Gallery Page ──────────────────────────────────────────────────────────
    /*
    if ( is_page( 'gallery' ) ) {
        wp_enqueue_style(
            'rashtrotthana-gallery',
            get_template_directory_uri() . '/assets/css/page-gallery.css',
            array( 'rashtrotthana-inner-pages' ),
            '1.0.0'
        );
        wp_enqueue_script(
            'rashtrotthana-gallery',
            get_template_directory_uri() . '/assets/js/page-gallery.js',
            array(),
            '1.0.0',
            true
        );
    }
    */

    // ── Contact Page ─────────────────────────────────────────────────────────
    /*
    if ( is_page( 'contact-us' ) ) {
        wp_enqueue_style(
            'rashtrotthana-contact',
            get_template_directory_uri() . '/assets/css/page-contact.css',
            array( 'rashtrotthana-inner-pages' ),
            '1.0.0'
        );
        wp_enqueue_script(
            'rashtrotthana-contact',
            get_template_directory_uri() . '/assets/js/page-contact.js',
            array(),
            '1.0.0',
            true
        );
    }
    */
}

add_action( 'wp_enqueue_scripts', 'rashtrotthana_enqueue_assets' );

endif;
