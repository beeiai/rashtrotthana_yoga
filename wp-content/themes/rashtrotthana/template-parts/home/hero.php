<?php
$hero_title = function_exists('get_field') ? get_field('ry_hero_title', 'option') : null;
$hero_subtitle = function_exists('get_field') ? get_field('ry_hero_subtitle', 'option') : null;
$btn_text = function_exists('get_field') ? get_field('ry_hero_button_text', 'option') : null;
$btn_url = function_exists('get_field') ? get_field('ry_hero_button_url', 'option') : null;

// Fallbacks
if ( ! $hero_title ) $hero_title = 'Building a Healthy & Sustainable Society';
if ( ! $hero_subtitle ) $hero_subtitle = 'Through Yoga, Education, Culture and Service, we strive for the holistic well-being of every individual and the upliftment of the society.';
if ( ! $btn_text ) $btn_text = 'Explore Activities';
if ( ! $btn_url ) $btn_url = home_url('/activities/');
?>
<section class="rs-hero">
    <div class="rs-container rs-hero-container">
        <div class="rs-hero-content">
            <p class="rs-hero-eyebrow">RASHTROTTHANA YOGA</p>
            <h1 class="rs-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
            <p class="rs-hero-description"><?php echo esc_html( $hero_subtitle ); ?></p>
            <div class="rs-hero-action-row">
                <img class="rs-hero-icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/icon.png' ); ?>" alt="" aria-hidden="true">
                <div class="rs-hero-actions">
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="rs-btn rs-btn-primary"><?php echo esc_html( $btn_text ); ?></a>
                    <a href="<?php echo esc_url( home_url('/centers/') ); ?>" class="rs-btn rs-btn-secondary">Find a Center</a>
                </div>
            </div>
        </div>
        <div class="rs-hero-visual">
            <div class="rs-hero-image-wrapper rs-hero-slideshow" data-slide-interval="4000">
                <div class="rs-hero-slides">
                    <img class="rs-hero-slide is-active" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/client/21-06-22-idy-celebration-12-.jpg' ); ?>" alt="Yoga practice at Rashtrotthana" fetchpriority="high">
                    <img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg' ); ?>" alt="Cultural Gathering" loading="lazy">
                    <img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg' ); ?>" alt="Summer Camp" loading="lazy">
                </div>
                <div class="rs-hero-slide-dots" aria-label="Hero slideshow controls">
                    <button class="is-active" type="button" aria-label="Show slide 1" aria-current="true"></button>
                    <button type="button" aria-label="Show slide 2"></button>
                    <button type="button" aria-label="Show slide 3"></button>
                </div>
            </div>
        </div>
    </div>
</section>
