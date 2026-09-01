<?php get_header(); ?>

<style>
    .rs-homepage { font-size: 16px; }
    .rs-homepage .rs-hero-title { font-size: clamp(2.7rem, 5vw, 4.7rem); line-height: 1.05; letter-spacing: -.035em; }
    .rs-homepage .rs-hero-description { max-width: 34rem; font-size: clamp(1rem, 1.25vw, 1.12rem); line-height: 1.7; }
    .rs-homepage .rs-heading { max-width: 48rem; margin-inline: auto; text-align: center; }
    .rs-homepage .rs-heading:after { text-align: center; }
    .rs-homepage .rs-heading h2, .rs-homepage .rs-section-row h2 { font-size: clamp(1.9rem, 3.2vw, 2.85rem); line-height: 1.15; }
    .rs-homepage .rs-section-row { align-items: end; }
    .rs-homepage .rs-value-card { min-height: 0; padding: 2rem 1.6rem; text-align: left; }
    .rs-homepage .rs-value-card h3, .rs-homepage .rs-activity-card h3, .rs-homepage .rs-event-card h3 { font-size: 1.2rem; line-height: 1.25; }
    .rs-homepage .rs-value-card p, .rs-homepage .rs-activity-card p, .rs-homepage .rs-event-card p { font-size: .92rem; line-height: 1.65; }
    .rs-homepage .rs-stat-grid strong { font-size: clamp(2rem, 3.2vw, 3rem); }
    .rs-homepage .rs-stat-grid span { font-size: .78rem; }
    .rs-homepage .rs-center-heading { align-items: end; }
    .rs-homepage .rs-center-heading h2 { font-size: clamp(1.9rem, 3vw, 2.7rem); }
    .rs-homepage .rs-center-card h3 { font-size: 1.1rem; }
    .rs-homepage .rs-center-location, .rs-homepage .rs-center-meta, .rs-homepage .rs-testimonial-grid p { font-size: .9rem; line-height: 1.55; }
    .rs-homepage .rs-cta .rs-container { justify-content: space-between; }
    .rs-homepage .rs-cta .rs-container > div { margin-right: auto; }
    @media (max-width: 600px) {
        .rs-homepage .rs-hero-title { font-size: 2.7rem; }
        .rs-homepage .rs-heading, .rs-homepage .rs-heading:after { text-align: left; }
        .rs-homepage .rs-section-row, .rs-homepage .rs-center-heading { align-items: flex-start; flex-direction: column; }
        .rs-homepage .rs-outline-link { margin-top: .35rem; }
        .rs-homepage .rs-value-card { padding: 1.5rem 1.25rem; }
        .rs-homepage .rs-cta .rs-container { align-items: flex-start; }
    }
</style>

<style>
    .rs-homepage .rs-centers { padding-block: 4.5rem; background: #fffaf2; }
    .rs-homepage .rs-center-finder { display: grid; grid-template-columns: 1.1fr repeat(3, 1.25fr) 1.05fr; gap: .9rem; align-items: stretch; }
    .rs-homepage .rs-center-intro, .rs-homepage .rs-center-locate { display: flex; flex-direction: column; justify-content: center; min-height: 15.5rem; padding: 1.65rem; border-radius: .8rem; background: #fff5df; }
    .rs-homepage .rs-center-intro h2 { margin: .45rem 0 .85rem; color: #542019; font: 700 clamp(1.65rem, 2.2vw, 2.15rem)/1.08 Georgia, serif; }
    .rs-homepage .rs-center-intro p { margin: 0 0 1.4rem; color: #67574c; font-size: .85rem; line-height: 1.55; }
    .rs-homepage .rs-center-intro .rs-center-button { align-self: flex-start; }
    .rs-homepage .rs-center-cards { display: contents; }
    .rs-homepage .rs-center-card { min-width: 0; border-radius: .8rem; box-shadow: 0 8px 20px rgba(67,48,28,.07); }
    .rs-homepage .rs-center-card > img, .rs-homepage .rs-center-card > a > img { height: 8rem; }
    .rs-homepage .rs-center-card-body { padding: .8rem .85rem .95rem; }
    .rs-homepage .rs-center-card h3 { font-size: .88rem; }
    .rs-homepage .rs-center-location { margin: .35rem 0 .7rem; font-size: .72rem; }
    .rs-homepage .rs-center-meta { gap: .5rem; padding: .55rem 0 0; font-size: .68rem; }
    .rs-homepage .rs-center-card .rs-center-button { display: none; }
    .rs-homepage .rs-center-locate { align-items: center; text-align: center; color: #8f171d; font: 700 1rem/1.4 Georgia, serif; transition: background-color 180ms ease, color 180ms ease; }
    .rs-homepage .rs-center-locate:hover { background: #8f171d; color: #fff; }
    @media (max-width: 1100px) {
        .rs-homepage .rs-center-finder { grid-template-columns: 1fr repeat(2, 1.25fr); }
        .rs-homepage .rs-center-locate { grid-column: 1 / -1; min-height: 4.75rem; }
    }
    @media (max-width: 700px) {
        .rs-homepage .rs-centers { padding-block: 3rem; }
        .rs-homepage .rs-center-finder { grid-template-columns: 1fr; }
        .rs-homepage .rs-center-intro, .rs-homepage .rs-center-locate { min-height: auto; padding: 1.5rem; }
        .rs-homepage .rs-center-card > img, .rs-homepage .rs-center-card > a > img { height: 11.5rem; }
        .rs-homepage .rs-center-card h3 { font-size: 1rem; }
        .rs-homepage .rs-center-location, .rs-homepage .rs-center-meta { font-size: .82rem; }
        .rs-homepage .rs-center-locate { grid-column: auto; }
    }
</style>

<style>
    .rs-homepage .rs-center-finder { grid-template-columns: 1.05fr repeat(3, 1.28fr) 1.05fr; gap: 1rem; align-items: stretch; }
    .rs-homepage .rs-center-intro, .rs-homepage .rs-center-locate, .rs-homepage .rs-center-card { min-height: 16rem; }
    .rs-homepage .rs-center-card { display: flex; flex-direction: column; align-self: stretch; }
    .rs-homepage .rs-center-card > a { display: flex; flex: 1; flex-direction: column; }
    .rs-homepage .rs-center-card > img, .rs-homepage .rs-center-card > a > img { height: 7.5rem; }
    .rs-homepage .rs-center-card-body { display: flex; flex: 1; flex-direction: column; padding: .85rem .9rem; }
    .rs-homepage .rs-center-card .rs-center-button { margin-top: auto; }
    .rs-homepage .rs-center-card h3 { font-size: .92rem; line-height: 1.28; }
    .rs-homepage .rs-center-location { margin: .35rem 0 .85rem; font-size: .75rem; }
    .rs-homepage .rs-center-intro .rs-center-button, .rs-homepage .rs-center-card .rs-center-button { display: inline-flex; align-self: flex-start; margin-top: .8rem; padding: .45rem .8rem; background: #8f171d; color: #fff; font-size: .7rem; }
    .rs-homepage .rs-center-intro .rs-center-button:hover, .rs-homepage .rs-center-card:hover .rs-center-button { background: #c54b1b; color: #fff; }
    .rs-homepage .rs-center-locate { gap: 1rem; }
    .rs-homepage .rs-center-locate svg { width: 2.65rem; height: 2.65rem; fill: currentColor; }
    .rs-homepage .rs-center-locate span { display: block; }
    @media (max-width: 1100px) {
        .rs-homepage .rs-center-finder { grid-template-columns: 1fr repeat(2, 1.3fr); }
    }
    @media (max-width: 700px) {
        .rs-homepage .rs-center-card { min-height: 0; }
        .rs-homepage .rs-center-card > img, .rs-homepage .rs-center-card > a > img { height: 12rem; }
        .rs-homepage .rs-center-card .rs-center-button { font-size: .78rem; }
    }
</style>

<style>
    .rs-homepage .rs-activity-grid,
    .rs-homepage .rs-event-grid,
    .rs-homepage .rs-testimonial-grid,
    .rs-homepage .rs-gallery-grid {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        overscroll-behavior-x: contain;
        padding: .25rem .15rem 1.25rem;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
        scrollbar-width: none;
    }
    .rs-homepage .rs-activity-grid::-webkit-scrollbar,
    .rs-homepage .rs-event-grid::-webkit-scrollbar,
    .rs-homepage .rs-testimonial-grid::-webkit-scrollbar,
    .rs-homepage .rs-gallery-grid::-webkit-scrollbar { display: none; }
    .rs-homepage .rs-activity-grid > *,
    .rs-homepage .rs-event-grid > *,
    .rs-homepage .rs-testimonial-grid > *,
    .rs-homepage .rs-gallery-grid > * {
        flex: 0 0 min(22rem, 82vw);
        scroll-snap-align: start;
    }
    .rs-homepage .rs-gallery-grid > img { height: 13.75rem; object-fit: cover; }
    @media (max-width: 700px) {
        .rs-homepage .rs-activity-grid,
        .rs-homepage .rs-event-grid,
        .rs-homepage .rs-testimonial-grid,
        .rs-homepage .rs-gallery-grid { gap: 1rem; padding-bottom: 1rem; }
        .rs-homepage .rs-activity-grid > *,
        .rs-homepage .rs-event-grid > *,
        .rs-homepage .rs-testimonial-grid > *,
        .rs-homepage .rs-gallery-grid > * { flex-basis: min(19rem, 86vw); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    document.querySelectorAll('.rs-activity-grid, .rs-event-grid, .rs-testimonial-grid, .rs-gallery-grid').forEach(function (track) {
        var paused = false;
        var interval = 4200;
        var timer;

        function cardStep() {
            var card = track.firstElementChild;
            return card ? card.getBoundingClientRect().width + parseFloat(getComputedStyle(track).gap || 0) : 0;
        }

        function advance() {
            if (paused || !document.contains(track)) return;
            var step = cardStep();
            if (!step) return;
            if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 4) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: step, behavior: 'smooth' });
            }
        }

        function pause() { paused = true; }
        function resume() { paused = false; }

        track.addEventListener('mouseenter', pause);
        track.addEventListener('mouseleave', resume);
        track.addEventListener('focusin', pause);
        track.addEventListener('focusout', resume);
        track.addEventListener('touchstart', pause, { passive: true });
        track.addEventListener('touchend', function () { setTimeout(resume, interval); }, { passive: true });

        timer = window.setInterval(advance, interval);
        window.addEventListener('beforeunload', function () { window.clearInterval(timer); }, { once: true });
    });
});
</script>

<main class="rs-homepage">

    <?php get_template_part('template-parts/home/hero'); ?>
    <?php get_template_part('template-parts/home/homepage-sections'); ?>

</main>

<?php get_footer(); ?>
