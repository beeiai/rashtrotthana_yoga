<?php
/**
 * Hero section — Rashtrotthana Yoga
 * Supports 4 slideshow images, zero-layout-shift typewriter animation, and static subheading.
 */
$hero_headings = array(
    'Transforming Self. Empowering Communities.',
    'Elevate Your Life. Uplift Society.',
    'Holistic Well-being for a Sustainable World.',
);
$hero_subtitle = 'Discover a path to total physical, mental, and social vitality. Through structured training and dedicated service, we are actively shaping a healthier, sustainable tomorrow.';
$btn_text      = 'Explore Activities';
$btn_url       = home_url( '/activities/' );

$hero_images = array(
    content_url( '/uploads/2026/10/hero-section-1.jpg' ),
    content_url( '/uploads/2026/10/Hero-section-2.jpeg' ),
    content_url( '/uploads/2026/10/Hero-section-3.jpg' ),
    content_url( '/uploads/2026/10/hero-section-4.jpg' ),
);
?>
<section class="rs-hero">
    <div class="rs-container rs-hero-container">
        <div class="rs-hero-content">
            <p class="rs-hero-eyebrow">RASHTROTTHANA YOGA</p>
            <h1 class="rs-hero-title">
                <span class="rs-hero-title-ghost" aria-hidden="true"><?php echo esc_html( $hero_headings[2] ); ?></span>
                <span class="rs-hero-blur-container">
                    <?php foreach ( $hero_headings as $i => $heading ) : ?>
                        <span class="rs-hero-blur-slide<?php echo 0 === $i ? ' is-active' : ''; ?>">
                            <?php echo esc_html( $heading ); ?>
                        </span>
                    <?php endforeach; ?>
                </span>
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
                    <?php foreach ( $hero_images as $index => $img_url ) : ?>
                        <img class="rs-hero-slide<?php echo 0 === $index ? ' is-active' : ''; ?>" 
                             src="<?php echo esc_url( $img_url ); ?>" 
                             alt="<?php echo esc_attr( 'Rashtrotthana Yoga Hero Slide ' . ( $index + 1 ) ); ?>" 
                             <?php echo 0 === $index ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
                    <?php endforeach; ?>
                </div>
                <div class="rs-hero-slide-dots" aria-label="Hero slideshow controls">
                    <?php foreach ( $hero_images as $index => $img_url ) : ?>
                        <button class="<?php echo 0 === $index ? 'is-active' : ''; ?>" 
                                type="button" 
                                aria-label="<?php echo esc_attr( 'Show slide ' . ( $index + 1 ) ); ?>" 
                                <?php echo 0 === $index ? 'aria-current="true"' : ''; ?>></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.rs-hero-title {
    display: grid !important;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr;
    align-items: start;
    position: relative;
    font-size: clamp(2.05rem, 3.2vw, 2.9rem) !important;
    line-height: 1.18 !important;
    letter-spacing: -0.02em !important;
    font-weight: 800 !important;
    color: #431510;
    min-height: 2.4em;
    margin-bottom: 1.15rem;
}
.rs-hero-title-ghost {
    grid-column: 1 / 2;
    grid-row: 1 / 2;
    visibility: hidden;
    pointer-events: none;
    user-select: none;
    opacity: 0;
    line-height: inherit;
    font-size: inherit;
    font-weight: inherit;
    letter-spacing: inherit;
}
.rs-hero-blur-container {
    grid-column: 1 / 2;
    grid-row: 1 / 2;
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr;
    line-height: inherit;
    font-size: inherit;
    font-weight: inherit;
    letter-spacing: inherit;
    position: relative;
}
.rs-hero-blur-slide {
    grid-column: 1 / 2;
    grid-row: 1 / 2;
    line-height: inherit;
    font-size: inherit;
    font-weight: inherit;
    letter-spacing: inherit;
    opacity: 0;
    filter: blur(12px);
    transform: translateY(8px) scale(0.99);
    transition: opacity 0.65s cubic-bezier(0.4, 0, 0.2, 1),
                filter 0.65s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.65s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
    will-change: opacity, filter, transform;
}
.rs-hero-blur-slide.is-active {
    opacity: 1;
    filter: blur(0px);
    transform: translateY(0) scale(1);
    pointer-events: auto;
}
.rs-hero-action-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 1.5rem;
}
.rs-hero-icon {
    width: 48px;
    height: 48px;
    object-fit: contain;
    flex-shrink: 0;
}
@media (max-width: 600px) {
    .rs-hero-action-row {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    .rs-hero-icon {
        display: none;
    }
    .rs-hero-actions {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .rs-hero-actions .rs-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
(function() {
    var slides = document.querySelectorAll('.rs-hero-blur-slide');
    if (!slides || slides.length < 2) return;

    var current = 0;
    var intervalTime = 3800; // Duration each heading stays visible

    function nextHeading() {
        var prevSlide = slides[current];
        prevSlide.classList.remove('is-active');
        prevSlide.classList.add('is-exiting');

        setTimeout(function() {
            prevSlide.classList.remove('is-exiting');
        }, 650);

        current = (current + 1) % slides.length;
        var nextSlide = slides[current];
        nextSlide.classList.add('is-active');
    }

    setInterval(nextHeading, intervalTime);
})();
</script>

