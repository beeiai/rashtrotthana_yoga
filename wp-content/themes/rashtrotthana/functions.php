<?php

function rashtrotthana_enqueue_styles() {
    wp_enqueue_style(
        'rashtrotthana-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
}

add_action('wp_enqueue_scripts', 'rashtrotthana_enqueue_styles');