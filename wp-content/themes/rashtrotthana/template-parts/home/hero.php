<?php
$hero_subtitle = function_exists('get_field') ? get_field('ry_hero_subtitle', 'option') : null;
$btn_text = function_exists('get_field') ? get_field('ry_hero_button_text', 'option') : null;
$btn_url = function_exists('get_field') ? get_field('ry_hero_button_url', 'option') : null;

// Subheading — hardcoded (update this text with the real subheading)
$hero_subtitle = 'Through Yoga, Education, Culture and Service, we strive for the holistic well-being of every individual and the upliftment of the society.';

if ( ! $btn_text ) $btn_text = 'Explore Activities';
if ( ! $btn_url ) $btn_url = home_url('/activities/');
?>
<style>
    /* ── Hero Typing Effect ────────────────────────────────────── */
    .rs-hero-cursor {
        display: inline-block;
        width: 3px;
        height: .9em;
        margin-left: 2px;
        vertical-align: middle;
        background: #8F171D;
        border-radius: 2px;
        animation: rs-cursor-blink 700ms ease-in-out infinite alternate;
    }
    @keyframes rs-cursor-blink {
        0%   { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
<section class="rs-hero">
    <div class="rs-container rs-hero-container">
        <div class="rs-hero-content">
            <p class="rs-hero-eyebrow">RASHTROTTHANA YOGA</p>
            <h1 class="rs-hero-title" aria-live="polite" aria-label="Hero heading">
                <span id="rs-hero-typing" aria-hidden="true"></span><span class="rs-hero-cursor" aria-hidden="true"></span>
            </h1>
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
                    <!-- PLACEHOLDER: Replace these 4 src values with your uploaded image URLs -->
                    <img class="rs-hero-slide is-active" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>" alt="Yoga practice at Rashtrotthana" fetchpriority="high">
                    <img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>" alt="Cultural Gathering" loading="lazy">
                    <img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>" alt="Summer Camp" loading="lazy">
                    <img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>" alt="Community Event" loading="lazy">
                </div>
                <div class="rs-hero-slide-dots" aria-label="Hero slideshow controls">
                    <button class="is-active" type="button" aria-label="Show slide 1" aria-current="true"></button>
                    <button type="button" aria-label="Show slide 2"></button>
                    <button type="button" aria-label="Show slide 3"></button>
                    <button type="button" aria-label="Show slide 4"></button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    // ──────────────────────────────────────────────────
    // HEADING TEXTS — Replace these 3 strings with your actual headings
    // ──────────────────────────────────────────────────
    var RS_HERO_HEADINGS = [
        'HEADING 1 — Replace Me',
        'HEADING 2 — Replace Me',
        'HEADING 3 — Replace Me'
    ];
    // ──────────────────────────────────────────────────

    var el = document.getElementById('rs-hero-typing');
    if (!el || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        // Reduced motion: just show first heading statically
        if (el) el.textContent = RS_HERO_HEADINGS[0];
        return;
    }

    var headingIndex = 0;
    var charIndex    = 0;
    var isErasing    = false;
    var TYPING_SPEED = 55;   // ms per character typed
    var ERASE_SPEED  = 28;   // ms per character erased
    var PAUSE_AFTER  = 2200; // ms to pause at full heading before erasing
    var PAUSE_BEFORE = 400;  // ms to pause after full erase before next heading

    function tick() {
        var current = RS_HERO_HEADINGS[headingIndex];

        if (!isErasing) {
            // Typing
            charIndex++;
            el.textContent = current.slice(0, charIndex);
            if (charIndex === current.length) {
                // Reached end — pause then start erasing
                isErasing = true;
                setTimeout(tick, PAUSE_AFTER);
                return;
            }
            setTimeout(tick, TYPING_SPEED);
        } else {
            // Erasing
            charIndex--;
            el.textContent = current.slice(0, charIndex);
            if (charIndex === 0) {
                // Fully erased — move to next heading
                isErasing = false;
                headingIndex = (headingIndex + 1) % RS_HERO_HEADINGS.length;
                setTimeout(tick, PAUSE_BEFORE);
                return;
            }
            setTimeout(tick, ERASE_SPEED);
        }
    }

    // Start after a short delay so page loads first
    setTimeout(tick, 600);
}());
</script>
