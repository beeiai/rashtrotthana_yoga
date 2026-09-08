<?php get_header(); ?>

<style>
    .rs-homepage { font-size: 16px; }
    .rs-homepage .rs-reveal { opacity: 0; transform: translateY(22px); transition: opacity 700ms ease var(--reveal-delay, 0ms), transform 700ms cubic-bezier(.2,.7,.2,1) var(--reveal-delay, 0ms); }
    .rs-homepage .rs-reveal.is-visible { opacity: 1; transform: translateY(0); }
    .rs-navbar { background: rgba(255, 253, 249, .78); border-bottom-color: rgba(143, 23, 29, .1); box-shadow: 0 8px 28px rgba(82, 38, 18, .06); backdrop-filter: blur(14px); }
    .rs-homepage .rs-activity-card, .rs-homepage .rs-event-card, .rs-homepage .rs-team-card, .rs-homepage .rs-center-card { transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease; }
    .rs-homepage .rs-activity-card:hover, .rs-homepage .rs-event-card:hover, .rs-homepage .rs-center-card:hover { transform: translateY(-6px); box-shadow: 0 18px 34px rgba(82, 38, 18, .14); }
    .rs-homepage .rs-btn, .rs-homepage .rs-center-button, .rs-homepage .rs-register-button { transition: transform 180ms ease, box-shadow 180ms ease, background-color 180ms ease, color 180ms ease; }
    .rs-homepage .rs-btn:hover, .rs-homepage .rs-center-button:hover, .rs-homepage .rs-register-button:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(143, 23, 29, .18); }
    .rs-cursor-glow { position: fixed; z-index: 9999; top: -18px; left: -18px; width: 36px; height: 36px; border: 1px solid rgba(243, 106, 33, .32); border-radius: 50%; background: rgba(255, 212, 142, .16); pointer-events: none; mix-blend-mode: multiply; transition: transform 80ms linear, width 180ms ease, height 180ms ease, background-color 180ms ease; }
    .rs-homepage .rs-hero-visual { will-change: transform; }
    .rs-homepage .rs-hero-title { font-size: clamp(2.7rem, 5vw, 4.7rem); line-height: 1.05; letter-spacing: -.035em; }
    .rs-homepage .rs-hero-description { max-width: 34rem; font-size: clamp(1rem, 1.25vw, 1.12rem); line-height: 1.7; }
    .rs-homepage .rs-heading { max-width: 48rem; margin-inline: auto; text-align: center; }
    .rs-homepage .rs-heading:after { text-align: center; }
    .rs-homepage .rs-values .rs-heading, .rs-homepage .rs-values .rs-heading h2, .rs-homepage .rs-values .rs-heading:after { text-align: center; }
    .rs-homepage .rs-values .rs-heading { max-width: 760px; margin-bottom: 2.4rem; }
    .rs-homepage .rs-heading h2, .rs-homepage .rs-section-row h2 { font-size: clamp(1.9rem, 3.2vw, 2.85rem); line-height: 1.15; }
    .rs-homepage .rs-section-row { align-items: end; }
    .rs-homepage .rs-value-card { position: relative; min-height: 0; padding: 2rem 1.6rem; text-align: left; border: 1px solid rgba(255, 255, 255, .72) !important; border-radius: 1.15rem; background: linear-gradient(145deg, rgba(255, 255, 255, .68), rgba(255, 248, 236, .42)); box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .8); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); overflow: hidden; transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease; }
    .rs-homepage .rs-value-card::before { content: ""; display: block; width: 42px; height: 3px; margin-bottom: 1.35rem; background: linear-gradient(90deg, var(--color-maroon), var(--color-saffron)); }
    .rs-homepage .rs-value-card:hover { transform: translateY(-7px); border-color: rgba(243, 106, 33, .48) !important; box-shadow: 0 22px 42px rgba(89, 37, 24, .14), inset 0 1px 0 rgba(255, 255, 255, .9); }
    .rs-homepage .rs-value-card h3, .rs-homepage .rs-activity-card h3, .rs-homepage .rs-event-card h3 { font-size: 1.2rem; line-height: 1.25; }
    .rs-homepage .rs-value-card p, .rs-homepage .rs-activity-card p, .rs-homepage .rs-event-card p { font-size: .92rem; line-height: 1.65; }
    .rs-homepage .rs-team-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1.4rem; }
    .rs-homepage .rs-team-card { flex: none; min-width: 0; overflow: hidden; padding: .8rem .8rem 1.25rem; border: 1px solid rgba(143, 23, 29, .14); border-radius: .8rem; background: #fffdf9; box-shadow: 0 10px 24px rgba(82, 38, 18, .08); transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease; }
    .rs-homepage .rs-team-card:hover { transform: translateY(-4px); border-color: rgba(243, 106, 33, .45); box-shadow: 0 16px 30px rgba(82, 38, 18, .13); }
    .rs-homepage .rs-team-card img { width: 100%; aspect-ratio: 1 / 1; object-fit: cover; object-position: center; border-radius: .45rem; background: var(--color-sand); }
    .rs-homepage .rs-team-card h3 { margin: .85rem .35rem .2rem; color: var(--color-maroon); font-size: 1.08rem; line-height: 1.25; }
    .rs-homepage .rs-team-card > p { min-height: 0; margin-left: .35rem; margin-right: .35rem; }
    .rs-homepage .rs-team-card .rs-team-role { margin-top: 0; margin-bottom: .65rem; color: var(--color-saffron); font-size: .82rem; font-weight: 600; line-height: 1.35; }
    .rs-homepage .rs-team-card > p:last-child { margin-top: 0; margin-bottom: 0; color: var(--color-text-muted); font-size: .8rem; line-height: 1.5; }
    .rs-homepage .rs-stat-grid strong { font-size: clamp(2rem, 3.2vw, 3rem); }
    .rs-homepage .rs-stat-value { font-variant-numeric: tabular-nums; white-space: nowrap; }
    .rs-homepage .rs-stat-grid span { font-size: .78rem; }
    .rs-homepage .rs-center-heading { align-items: end; }
    .rs-homepage .rs-center-heading h2 { font-size: clamp(1.9rem, 3vw, 2.7rem); }
    .rs-homepage .rs-center-card h3 { font-size: 1.1rem; }
    .rs-homepage .rs-center-location, .rs-homepage .rs-center-meta, .rs-homepage .rs-testimonial-grid p { font-size: .9rem; line-height: 1.55; }
    @media (max-width: 600px) {
        .rs-homepage .rs-hero-title { font-size: 2.7rem; }
        .rs-homepage .rs-heading, .rs-homepage .rs-heading:after { text-align: left; }
        .rs-homepage .rs-team-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.5rem 1rem; }
        .rs-homepage .rs-section-row, .rs-homepage .rs-center-heading { align-items: flex-start; flex-direction: column; }
        .rs-homepage .rs-outline-link { margin-top: .35rem; }
        .rs-homepage .rs-value-card { padding: 1.5rem 1.25rem; }
        .rs-homepage .rs-values .rs-heading { margin-bottom: 1.6rem; }
    }
    @media (max-width: 600px) {
        .rs-homepage .rs-team-grid { grid-template-columns: 1fr; }
        .rs-homepage .rs-team-card img { aspect-ratio: 1 / 1; }
    }
    @media (pointer: coarse), (prefers-reduced-motion: reduce) {
        .rs-cursor-glow { display: none; }
        .rs-homepage .rs-reveal { opacity: 1; transform: none; transition: none; }
    }
</style>

<style>
    .rs-homepage .rs-centers { padding-block: 4.5rem; background: #fffaf2; }
    .rs-homepage .rs-center-finder { display: grid; grid-template-columns: 1.1fr repeat(3, 1.25fr) 1.05fr; gap: .9rem; align-items: stretch; }
    .rs-homepage .rs-center-intro, .rs-homepage .rs-center-locate { display: flex; flex-direction: column; justify-content: center; min-height: 15.5rem; padding: 1.65rem; border-radius: .8rem; background: #fff5df; }
    .rs-homepage .rs-center-intro, .rs-homepage .rs-center-locate { display: flex; flex-direction: column; justify-content: center; min-height: 15.5rem; padding: 1.65rem; border-radius: .8rem; }
    .rs-homepage .rs-center-intro { justify-content: flex-start; padding-top: 1.35rem; background: linear-gradient(145deg, #fff0d2, #ffe2ad); }
    .rs-homepage .rs-center-intro h2 { margin: .35rem 0 .75rem; color: #542019; font: 700 clamp(1.65rem, 2.2vw, 2.15rem)/1.08 Georgia, serif; }
    .rs-homepage .rs-center-intro p { margin: 0 0 1.4rem; color: #67574c; font-size: .85rem; line-height: 1.55; }
    .rs-homepage .rs-center-intro .rs-center-button { align-self: flex-start; }
        .rs-homepage .rs-center-search { position: relative; width: 100%; margin: 0 0 .45rem; }
        .rs-homepage .rs-center-search svg { position: absolute; top: 50%; left: .7rem; width: 1rem; height: 1rem; transform: translateY(-50%); fill: none; stroke: #8f171d; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2; pointer-events: none; }
        .rs-homepage .rs-center-search input { width: 100%; min-height: 2.55rem; padding: .55rem .65rem .55rem 2.15rem; border: 1px solid rgba(143,23,29,.22); border-radius: .45rem; background: rgba(255,255,255,.78); color: #542019; font-size: .72rem; outline: none; }
        .rs-homepage .rs-center-search input::placeholder { color: #8b7465; }
        .rs-homepage .rs-center-search input:focus { border-color: #8f171d; box-shadow: 0 0 0 3px rgba(143,23,29,.12); }
        .rs-homepage .rs-center-search-status { min-height: 1rem; margin: 0 0 .3rem; color: #795c4b; font-size: .65rem; }
    .rs-homepage .rs-center-cards { display: contents; }
    .rs-homepage .rs-center-card { min-width: 0; border: 1px solid rgba(143,23,29,.12); border-radius: .9rem; background: #fffdf9; box-shadow: 0 10px 24px rgba(82,38,18,.07); }
    .rs-homepage .rs-center-card[hidden] { display: none !important; }
    .rs-homepage .rs-center-card > img, .rs-homepage .rs-center-card > a > img { height: 8.8rem; object-fit: cover; }
    .rs-homepage .rs-center-card-body { display: flex; flex: 1; flex-direction: column; padding: 1rem 1rem 1.05rem; }
    .rs-homepage .rs-center-card h3 { margin: 0; color: #542019; font: 700 1rem/1.28 Georgia, serif; }
    .rs-homepage .rs-center-location { margin: .4rem 0 0; color: #756a61; font-size: .78rem; line-height: 1.4; }
    .rs-homepage .rs-center-meta { gap: .5rem; padding: .55rem 0 0; font-size: .68rem; }
    .rs-homepage .rs-center-card .rs-center-button { display: none; }
    .rs-homepage .rs-center-locate { align-items: center; text-align: center; color: #8f171d; font: 700 1rem/1.4 Georgia, serif; transition: background-color 180ms ease, color 180ms ease; }
    .rs-homepage .rs-center-locate { align-items: center; text-align: center; color: #fff8ec; font: 700 1rem/1.4 Georgia, serif; background: linear-gradient(145deg, #8f171d, #5d1116); box-shadow: 0 10px 22px rgba(93,17,22,.16); transition: transform 180ms ease, box-shadow 180ms ease; }
    .rs-homepage .rs-center-locate:hover { color: #fff; transform: translateY(-3px); box-shadow: 0 15px 28px rgba(93,17,22,.24); }
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
        .rs-homepage .rs-center-no-results { grid-column: auto; }
    }
</style>

<style>
    .rs-homepage .rs-center-finder { grid-template-columns: 1.05fr repeat(3, 1.28fr) 1.05fr; gap: 1rem; align-items: stretch; }
    .rs-homepage .rs-center-intro, .rs-homepage .rs-center-locate, .rs-homepage .rs-center-card { min-height: 16rem; }
    .rs-homepage .rs-center-card { display: flex; flex-direction: column; align-self: stretch; overflow: hidden; }
    .rs-homepage .rs-center-card > a { display: flex; flex: 1; flex-direction: column; }
    .rs-homepage .rs-center-card > img, .rs-homepage .rs-center-card > a > img { height: 8.8rem; }
    .rs-homepage .rs-center-card-body { display: flex; flex: 1; flex-direction: column; padding: 1rem; }
    .rs-homepage .rs-center-card .rs-center-button { margin-top: auto; }
    .rs-homepage .rs-center-card h3 { font-size: .92rem; line-height: 1.28; }
    .rs-homepage .rs-center-location { margin: .35rem 0 .85rem; font-size: .75rem; }
    .rs-homepage .rs-center-intro .rs-center-button, .rs-homepage .rs-center-card .rs-center-button { display: inline-flex; align-items: center; justify-content: center; align-self: flex-start; min-height: 2.35rem; margin-top: auto; padding: .55rem .9rem; border-radius: 999px; background: #8f171d; color: #fff; font-size: .72rem; font-weight: 700; line-height: 1; }
    .rs-homepage .rs-center-intro .rs-center-button:hover, .rs-homepage .rs-center-card:hover .rs-center-button { background: #c54b1b; color: #fff; }
    .rs-homepage .rs-center-locate { gap: 1rem; }
    .rs-homepage .rs-center-locate svg { width: 2.65rem; height: 2.65rem; fill: currentColor; }
    .rs-homepage .rs-center-locate span { display: block; }
        .rs-homepage .rs-center-no-results { grid-column: 2 / 5; align-self: center; margin: 0; padding: 1.5rem; color: #795c4b; text-align: center; font-size: .85rem; }
        .rs-homepage .rs-center-intro { padding-top: 1.25rem; }
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
    .rs-homepage .rs-gallery-grid::-webkit-scrollbar { display: none; }
    .rs-homepage .rs-activity-grid > *,
    .rs-homepage .rs-event-grid > *,
    .rs-homepage .rs-gallery-grid > * {
        flex: 0 0 min(22rem, 82vw);
        scroll-snap-align: start;
    }
    .rs-homepage .rs-gallery-grid > img { height: 13.75rem; object-fit: cover; }
    @media (max-width: 700px) {
        .rs-homepage .rs-activity-grid,
        .rs-homepage .rs-event-grid,
        .rs-homepage .rs-gallery-grid { gap: 1rem; padding-bottom: 1rem; }
        .rs-homepage .rs-activity-grid > *,
        .rs-homepage .rs-event-grid > *,
        .rs-homepage .rs-gallery-grid > * { flex-basis: min(19rem, 86vw); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var homepage = document.querySelector('.rs-homepage');

    if (homepage && !prefersReducedMotion) {
        var revealItems = homepage.querySelectorAll('.rs-values, .rs-stats, .rs-centers, .rs-content-section, .rs-testimonials, .rs-team-card, .rs-activity-card, .rs-event-card');
        var revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px' });

        Array.prototype.forEach.call(revealItems, function (item, index) {
            item.classList.add('rs-reveal');
            item.style.setProperty('--reveal-delay', Math.min(index % 4, 3) * 70 + 'ms');
            revealObserver.observe(item);
        });

        var heroVisual = document.querySelector('.rs-hero-visual');
        if (heroVisual && window.matchMedia('(min-width: 901px)').matches) {
            window.addEventListener('scroll', function () {
                heroVisual.style.transform = 'translate3d(0, ' + Math.min(window.scrollY * 0.08, 42) + 'px, 0)';
            }, { passive: true });
        }

        if (window.matchMedia('(pointer: fine)').matches) {
            var cursorGlow = document.createElement('span');
            cursorGlow.className = 'rs-cursor-glow';
            cursorGlow.setAttribute('aria-hidden', 'true');
            document.body.appendChild(cursorGlow);
            window.addEventListener('pointermove', function (event) {
                cursorGlow.style.transform = 'translate3d(' + event.clientX + 'px, ' + event.clientY + 'px, 0)';
            }, { passive: true });
        }

        var stats = document.querySelector('.rs-stat-grid');
        if (stats) {
            var statValues = stats.querySelectorAll('.rs-stat-value');
            var statsObserver = new IntersectionObserver(function (entries, observer) {
                if (!entries.some(function (entry) { return entry.isIntersecting; })) return;
                Array.prototype.forEach.call(statValues, function (value, index) {
                    var target = Number(value.getAttribute('data-count')) || 0;
                    var suffix = value.getAttribute('data-suffix') || '';
                    var start = performance.now() + index * 90;
                    var duration = 1500;

                    function count(timestamp) {
                        var progress = Math.min(Math.max((timestamp - start) / duration, 0), 1);
                        var eased = 1 - Math.pow(1 - progress, 3);
                        value.textContent = Math.floor(target * eased).toLocaleString() + suffix;
                        if (progress < 1) window.requestAnimationFrame(count);
                    }

                    window.requestAnimationFrame(count);
                });
                observer.disconnect();
            }, { threshold: 0.35 });
            statsObserver.observe(stats);
        }
    }

    if (prefersReducedMotion) {
        document.querySelectorAll('.rs-stat-value').forEach(function (value) {
            var target = Number(value.getAttribute('data-count')) || 0;
            value.textContent = target.toLocaleString() + (value.getAttribute('data-suffix') || '');
        });
    }

    var centerFinder = document.querySelector('.rs-center-finder');
    var centerSearch = document.querySelector('#rs-center-search-input');
    if (centerFinder && centerSearch) {
        var centerSearchForm = centerSearch.closest('form');
        var centerCards = Array.prototype.slice.call(centerFinder.querySelectorAll('.rs-center-card'));
        var centerStatus = centerFinder.querySelector('.rs-center-search-status');
        var noResults = centerFinder.querySelector('.rs-center-no-results');

        if (centerSearchForm) {
            centerSearchForm.addEventListener('submit', function (event) { event.preventDefault(); });
        }

        centerSearch.addEventListener('input', function () {
            var query = centerSearch.value.trim().toLowerCase();
            var visibleCount = 0;

            centerCards.forEach(function (card) {
                var matches = !query || card.textContent.toLowerCase().indexOf(query) !== -1;
                card.hidden = !matches;
                if (matches) visibleCount += 1;
            });

            centerStatus.textContent = query ? visibleCount + ' center' + (visibleCount === 1 ? '' : 's') + ' found' : '';
            noResults.hidden = visibleCount !== 0;
        });
    }

    if (prefersReducedMotion) return;

    document.querySelectorAll('.rs-activity-grid, .rs-gallery-grid').forEach(function (track) {
        var paused = false;
        var animationFrame;
        var lastTimestamp = 0;
        var speed = 0.028;
        var position = track.scrollLeft;

        Array.prototype.slice.call(track.children).forEach(function (card) {
            var clone = card.cloneNode(true);
            clone.classList.remove('rs-reveal');
            clone.classList.add('is-visible');
            clone.style.removeProperty('--reveal-delay');
            track.appendChild(clone);
        });

        function cardStep() {
            var card = track.firstElementChild;
            return card ? card.getBoundingClientRect().width + parseFloat(getComputedStyle(track).gap || 0) : 0;
        }

        function animate(timestamp) {
            if (!document.contains(track)) return;
            var elapsed = lastTimestamp ? Math.min(timestamp - lastTimestamp, 40) : 0;
            lastTimestamp = timestamp;

            if (!paused) {
                position += elapsed * speed;
                track.scrollLeft = position;
                var step = cardStep();
                var firstCard = track.firstElementChild;
                if (firstCard && step && position >= step) {
                    track.appendChild(firstCard);
                    position -= step;
                    track.scrollLeft = position;
                }
            }

            animationFrame = window.requestAnimationFrame(animate);
        }

        function pause() { paused = true; }
        function resume() { paused = false; }

        track.addEventListener('mouseenter', pause);
        track.addEventListener('mouseleave', resume);

        track.style.scrollBehavior = 'auto';
        track.style.scrollSnapType = 'none';
        animationFrame = window.requestAnimationFrame(animate);
        window.addEventListener('beforeunload', function () { window.cancelAnimationFrame(animationFrame); }, { once: true });
    });
});
</script>

<main class="rs-homepage">

    <?php get_template_part('template-parts/home/hero'); ?>
    <?php get_template_part('template-parts/home/homepage-sections'); ?>

</main>

<?php get_footer(); ?>
