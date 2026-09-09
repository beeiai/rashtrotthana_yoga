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

<style>
    /* Homepage visual system: translucent surfaces, electric accents, and depth. */
    body.home {
        --home-ink: var(--color-text);
        --home-muted: var(--color-text-muted);
        --home-glass: rgba(255, 255, 255, .48);
        --home-glass-strong: rgba(255, 255, 255, .68);
        --home-line: rgba(255, 255, 255, .72);
        --home-violet: var(--color-maroon);
        --home-cyan: var(--color-gold);
        --home-pink: var(--color-saffron);
        background: var(--color-cream);
    }

    body.home .rs-site-header {
        box-shadow: 0 12px 34px rgba(67, 43, 112, .12);
    }

    body.home .rs-navbar {
        background: rgba(255, 248, 236, .62);
        border-bottom-color: rgba(143, 23, 29, .16);
        box-shadow: inset 0 -1px 0 rgba(255, 255, 255, .62);
        -webkit-backdrop-filter: blur(22px) saturate(145%);
        backdrop-filter: blur(22px) saturate(145%);
    }

    body.home .rs-homepage {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        color: var(--home-ink);
        background:
            linear-gradient(90deg, rgba(255, 248, 236, .84), rgba(255, 248, 236, .72)),
            url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>") center top / cover fixed no-repeat;
        animation: rs-nature-drift 24s ease-in-out infinite alternate;
    }

    body.home .rs-homepage::before,
    body.home .rs-homepage::after {
        position: absolute;
        z-index: -1;
        display: block;
        width: 24rem;
        height: 24rem;
        border-radius: 50%;
        content: "";
        filter: blur(10px);
        opacity: .46;
        pointer-events: none;
    }

    body.home .rs-homepage::before {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
        background:
            radial-gradient(circle at 8% 8%, rgba(249, 183, 42, .18), transparent 24rem),
            radial-gradient(circle at 92% 18%, rgba(243, 106, 33, .14), transparent 28rem);
        filter: none;
        opacity: 1;
    }

    body.home .rs-homepage::after {
        top: 105rem;
        right: -15rem;
        background: radial-gradient(circle, rgba(249, 183, 42, .24), transparent 68%);
    }

    @keyframes rs-nature-drift {
        0% { background-position: center top, 48% top; }
        100% { background-position: center top, 52% top; }
    }

    @media (prefers-reduced-motion: reduce) {
        body.home .rs-homepage { animation: none; }
    }

    body.home .rs-hero {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(115deg, rgba(255, 248, 236, .94) 0%, rgba(255, 248, 236, .8) 47%, rgba(249, 183, 42, .72) 48%, rgba(243, 106, 33, .92) 100%),
            radial-gradient(circle at 84% 30%, rgba(143, 23, 29, .18), transparent 22rem);
    }

    body.home .rs-hero::after {
        display: none;
    }

    body.home .rs-hero-content,
    body.home .rs-hero-visual {
        position: relative;
        z-index: 1;
    }

    body.home .rs-hero-content {
        max-width: 570px;
        padding: 0;
        border: 0;
        border-radius: 0;
        background: transparent;
        box-shadow: none;
        -webkit-backdrop-filter: none;
        backdrop-filter: none;
    }

    body.home .rs-hero-eyebrow,
    body.home .rs-kicker {
        color: var(--home-violet);
        text-shadow: 0 0 16px rgba(143, 23, 29, .28);
    }

    body.home .rs-hero-title,
    body.home .rs-heading h2,
    body.home .rs-section-row h2,
    body.home .rs-center-intro h2 {
        color: var(--home-ink);
    }

    body.home .rs-hero-title {
        background: none;
        color: #550000;
        text-shadow: 0 3px 18px rgba(255, 248, 236, .88);
    }

    body.home .rs-hero-description,
    body.home .rs-value-card p,
    body.home .rs-activity-card p,
    body.home .rs-event-card p,
    body.home .rs-team-card > p:last-child,
    body.home .rs-center-location {
        color: var(--home-muted);
    }

    body.home .rs-hero-description {
        color: #4f4741;
        text-shadow: 0 2px 12px rgba(255, 248, 236, .92);
    }

    body.home .rs-hero-icon {
        display: block;
        width: 96px;
        height: 96px;
        margin: 0;
        object-fit: contain;
        mix-blend-mode: multiply;
        opacity: .82;
    }

    body.home .rs-hero-action-row {
        display: flex;
        align-items: center;
        gap: 1.35rem;
        margin-top: 1.35rem;
    }

    body.home .rs-hero-actions {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: center;
        gap: .75rem;
    }

    body.home .rs-hero-action-row .rs-btn {
        min-width: 174px;
    }

    body.home .rs-hero-action-row .rs-btn-secondary {
        border-color: #B31B1B !important;
        background: #fff !important;
        color: #B31B1B !important;
        text-shadow: none;
    }

    body.home .rs-hero-image-wrapper {
        border: 1px solid rgba(255, 255, 255, .84);
        border-radius: 28px 0 0 28px;
        box-shadow: 0 18px 44px rgba(83, 37, 16, .18), 0 0 0 8px rgba(255, 255, 255, .14), 0 0 42px rgba(243, 106, 33, .18);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }

    body.home .rs-hero-slide-dots button {
        border-color: rgba(255, 255, 255, .9);
        background: rgba(255, 255, 255, .4);
        box-shadow: 0 0 10px rgba(249, 183, 42, .3);
    }

    body.home .rs-hero-slide-dots button.is-active {
        background: var(--color-gold);
        box-shadow: 0 0 14px rgba(249, 183, 42, .8);
    }

    body.home .rs-btn,
    body.home .rs-center-button,
    body.home .rs-register-button {
        border: 1px solid #B31B1B;
        background: #B31B1B;
        box-shadow: 0 10px 24px rgba(179, 27, 27, .3), 0 0 16px rgba(179, 27, 27, .16), inset 0 1px 0 rgba(255, 255, 255, .42);
        color: #fff;
        text-shadow: 0 1px 0 rgba(0, 0, 0, .16);
    }

    body.home .rs-btn-secondary,
    body.home .rs-outline-link {
        border-color: #B31B1B;
        background: rgba(255, 248, 236, .5);
        color: #B31B1B;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .72);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }

    body.home .rs-btn:hover,
    body.home .rs-center-button:hover,
    body.home .rs-register-button:hover {
        background: #B31B1B;
        box-shadow: 0 14px 30px rgba(179, 27, 27, .36), 0 0 22px rgba(179, 27, 27, .24), inset 0 1px 0 #fff;
    }

    body.home .rs-values,
    body.home .rs-content-section,
    body.home .rs-centers,
    body.home .rs-testimonials,
    body.home .rs-gallery {
        background: transparent;
    }

    body.home .rs-value-card,
    body.home .rs-activity-card,
    body.home .rs-event-card,
    body.home .rs-team-card,
    body.home .rs-center-card,
    body.home .rs-center-intro,
    body.home .rs-center-locate {
        border: 1px solid var(--home-line) !important;
        background: transparent !important;
        background-image: none !important;
        box-shadow: 0 28px 46px rgba(89, 37, 24, .18), 0 10px 16px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .86), inset 0 -1px 0 rgba(143, 23, 29, .1);
        -webkit-backdrop-filter: blur(26px);
        backdrop-filter: blur(26px);
    }

    body.home .rs-value-card::after,
    body.home .rs-activity-card::after,
    body.home .rs-event-card::after,
    body.home .rs-team-card::after,
    body.home .rs-center-card::after {
        position: absolute;
        top: 0;
        right: 1.2rem;
        width: 4rem;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--home-cyan), transparent);
        box-shadow: 0 0 12px rgba(249, 183, 42, .8);
        content: "";
    }

    body.home .rs-value-card:hover,
    body.home .rs-activity-card:hover,
    body.home .rs-event-card:hover,
    body.home .rs-team-card:hover,
    body.home .rs-center-card:hover,
    body.home .rs-gallery-grid img:hover {
        border-color: rgba(249, 183, 42, .68) !important;
        box-shadow: 0 34px 58px rgba(89, 37, 24, .2), 0 0 26px rgba(249, 183, 42, .18), inset 0 1px 0 #fff, inset 0 -1px 0 rgba(143, 23, 29, .1);
    }

    body.home .rs-value-card h3,
    body.home .rs-activity-card h3,
    body.home .rs-event-card h3,
    body.home .rs-team-card h3,
    body.home .rs-center-card h3 {
        color: var(--home-ink);
    }

    body.home .rs-value-card {
        min-height: 260px;
        padding: 2.35rem 2rem;
        border-radius: 1.35rem;
    }

    body.home .rs-value-card h3 {
        font-size: 1.35rem !important;
        line-height: 1.25 !important;
    }

    body.home .rs-value-card p {
        max-width: 29rem;
        font-size: 1rem;
        line-height: 1.7;
    }

    body.home .rs-center-card h3 {
        font-size: 1.15rem !important;
        line-height: 1.3 !important;
    }

    body.home .rs-center-card .rs-center-location {
        margin-top: .55rem;
        font-size: .95rem !important;
        line-height: 1.5 !important;
    }

    body.home .rs-center-card .rs-center-button {
        font-size: .82rem !important;
    }

    body.home .rs-value-card::before {
        background: linear-gradient(90deg, var(--home-cyan), var(--home-violet), var(--home-pink));
        box-shadow: 0 0 12px rgba(243, 106, 33, .5);
    }

    body.home .rs-activity-card img,
    body.home .rs-event-image img,
    body.home .rs-team-card img,
    body.home .rs-center-card > img,
    body.home .rs-center-card > a > img,
    body.home .rs-gallery-grid img {
        filter: saturate(1.08) contrast(1.02);
    }

    body.home .rs-stats {
        background: transparent;
    }

    body.home .rs-stat-grid {
        background: transparent !important;
        background-image: none !important;
        box-shadow: 0 22px 54px rgba(89, 37, 24, .22), inset 0 1px 0 rgba(255, 255, 255, .8);
        color: var(--color-maroon);
    }

    body.home .rs-stat-grid h2,
    body.home .rs-stat-grid p,
    body.home .rs-stat-grid span,
    body.home .rs-stat-grid strong {
        color: var(--color-maroon);
    }

    body.home .rs-stat-grid strong {
        text-shadow: 0 2px 10px rgba(255, 255, 255, .7);
    }

    body.home .rs-center-search input {
        border-color: rgba(143, 23, 29, .24);
        background: rgba(255, 255, 255, .48);
        color: var(--home-ink);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .78);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }

    body.home .rs-center-locate {
        background: transparent !important;
        background-image: none !important;
        color: var(--color-maroon);
        text-shadow: 0 1px 8px rgba(255, 255, 255, .82);
        box-shadow: 0 28px 46px rgba(89, 37, 24, .18), 0 10px 16px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .86), inset 0 -1px 0 rgba(143, 23, 29, .1);
    }

    body.home .rs-section-row h2::after,
    body.home .rs-heading h2::after {
        background: linear-gradient(90deg, var(--home-cyan), var(--home-pink));
        box-shadow: 0 0 12px rgba(249, 183, 42, .55);
    }

    body.home .rs-cursor-glow {
        border-color: rgba(249, 183, 42, .66);
        background: rgba(249, 183, 42, .1);
        box-shadow: 0 0 22px rgba(249, 183, 42, .42);
        mix-blend-mode: screen;
    }

    body.home .rs-footer {
        background: #550000;
        box-shadow: 0 -18px 50px rgba(89, 37, 24, .16);
        border-top: 1px solid rgba(255, 255, 255, .16);
    }

    @media (min-width: 901px) {
        body.home .rs-hero-container {
            display: grid;
            grid-template-columns: .95fr 1.35fr;
            align-items: center;
            gap: 20px;
            min-height: 560px;
            padding-top: 55px;
            padding-bottom: 105px;
        }
    }

    @media (max-width: 900px) {
        body.home .rs-hero-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            min-height: auto;
            padding-top: 50px;
            padding-bottom: 120px;
        }
        body.home .rs-hero-image-wrapper { border-radius: 24px; }
    }

    @media (max-width: 600px) {
        body.home .rs-hero-container { padding-top: 36px; padding-bottom: 105px; }
        body.home .rs-hero-content { width: auto; }
        body.home .rs-hero-image-wrapper { margin-top: 8px; }
    }

    /* Full-bleed hero: the image carries the section while the copy melts into it. */
    body.home .rs-hero {
        background: var(--color-cream);
    }

    body.home .rs-hero-container {
        position: relative;
        display: block;
        width: 100%;
        min-height: 650px;
        padding: 0;
    }

    body.home .rs-hero-visual {
        position: absolute;
        inset: 0;
        z-index: 0;
        width: 100%;
        min-height: 650px;
    }

    body.home .rs-hero-image-wrapper {
        width: 100%;
        height: 650px;
        border: 0;
        border-radius: 0;
        box-shadow: none;
    }

    body.home .rs-hero-image-wrapper::after {
        background:
            linear-gradient(90deg, rgba(255, 248, 236, .99) 0%, rgba(255, 248, 236, .92) 27%, rgba(255, 248, 236, .64) 46%, rgba(255, 248, 236, .16) 68%, rgba(255, 248, 236, 0) 100%),
            linear-gradient(180deg, rgba(143, 23, 29, .08), transparent 32%, rgba(143, 23, 29, .12));
    }

    body.home .rs-hero-image-wrapper img {
        width: 100%;
        height: 650px;
        object-fit: cover;
        object-position: center;
    }

    body.home .rs-hero-content {
        position: relative;
        z-index: 2;
        width: min(100% - 160px, 1280px);
        max-width: 620px;
        min-height: 650px;
        margin: 0 auto 0 0;
        padding: 108px 0 130px clamp(48px, 8vw, 128px);
        background: transparent;
        -webkit-backdrop-filter: none;
        backdrop-filter: none;
    }

    body.home .rs-hero-title {
        max-width: 620px;
        text-shadow: 0 3px 18px rgba(255, 248, 236, .75);
    }

    body.home .rs-hero-description {
        max-width: 560px;
        text-shadow: 0 2px 12px rgba(255, 248, 236, .9);
    }

    @media (max-width: 900px) {
        body.home .rs-hero-container,
        body.home .rs-hero-visual,
        body.home .rs-hero-image-wrapper,
        body.home .rs-hero-image-wrapper img {
            min-height: 620px;
            height: 620px;
        }

        body.home .rs-hero-content {
            width: min(100% - 64px, 700px);
            min-height: 620px;
            padding: 76px 0 110px 32px;
        }

        body.home .rs-hero-icon {
            width: 76px;
            height: 76px;
        }

        body.home .rs-hero-image-wrapper::after {
            background:
                linear-gradient(90deg, rgba(255, 248, 236, .99) 0%, rgba(255, 248, 236, .9) 42%, rgba(255, 248, 236, .26) 76%, rgba(255, 248, 236, 0) 100%),
                linear-gradient(180deg, rgba(143, 23, 29, .08), transparent 36%, rgba(143, 23, 29, .14));
        }
    }

    @media (max-width: 600px) {
        body.home .rs-hero-container,
        body.home .rs-hero-visual,
        body.home .rs-hero-image-wrapper,
        body.home .rs-hero-image-wrapper img {
            min-height: 620px;
            height: 620px;
        }

        body.home .rs-hero-content {
            width: calc(100% - 40px);
            min-height: 620px;
            padding: 54px 0 90px 20px;
        }

        body.home .rs-hero-icon {
            width: 72px;
            height: 72px;
        }

        body.home .rs-hero-action-row {
            align-items: flex-start;
            gap: 1rem;
        }

        body.home .rs-hero-action-row .rs-btn {
            min-width: 150px;
        }

        body.home .rs-hero-image-wrapper img {
            object-position: 65% center;
        }

        body.home .rs-hero-image-wrapper::after {
            background:
                linear-gradient(90deg, rgba(255, 248, 236, .99) 0%, rgba(255, 248, 236, .9) 53%, rgba(255, 248, 236, .18) 100%),
                linear-gradient(180deg, rgba(143, 23, 29, .08), transparent 38%, rgba(143, 23, 29, .14));
        }

        body.home .rs-center-card h3 {
            font-size: 1.08rem !important;
        }

        body.home .rs-center-card .rs-center-location {
            font-size: .9rem !important;
        }
    }

    body.home .rs-btn,
    body.home .rs-center-intro .rs-center-button,
    body.home .rs-center-card .rs-center-button,
    body.home .rs-register-button {
        border-color: #B31B1B !important;
        background: #B31B1B !important;
        color: #fff !important;
    }

    body.home .rs-btn:hover,
    body.home .rs-center-intro .rs-center-button:hover,
    body.home .rs-center-card:hover .rs-center-button,
    body.home .rs-register-button:hover {
        background: #B31B1B !important;
        color: #fff !important;
        box-shadow: 0 12px 26px rgba(179, 27, 27, .32), 0 0 18px rgba(179, 27, 27, .2);
    }

    body.home .rs-menu-toggle {
        border-color: #B31B1B;
        background: transparent;
    }

    body.home .rs-menu-toggle span,
    body.home .rs-hero-slide-dots button {
        background: #B31B1B;
    }

    body.home .rs-hero-slide-dots button {
        border-color: #B31B1B;
    }

    body.home .rs-hero-slide-dots button.is-active {
        background: #B31B1B !important;
        border-color: #B31B1B !important;
    }

    body.home .rs-navigation .rs-nav-link {
        padding: 28px 4px;
        font-size: 1rem !important;
    }

    @media (max-width: 900px) {
        body.home .rs-navigation .rs-nav-link {
            padding: 14px 18px;
            font-size: 1rem !important;
        }
    }

    @media (hover: hover) and (pointer: fine) {
        body.home .rs-value-card,
        body.home .rs-activity-card,
        body.home .rs-event-card,
        body.home .rs-center-card,
        body.home .rs-team-card,
        body.home .rs-center-intro,
        body.home .rs-center-locate,
        body.home .rs-stat-grid {
            --card-rotate-x: 0deg;
            --card-rotate-y: 0deg;
            --card-lift: 0px;
            --card-scale: 1;
            position: relative;
            transform: perspective(1100px) rotateX(var(--card-rotate-x)) rotateY(var(--card-rotate-y)) translateY(var(--card-lift)) scale(var(--card-scale));
            transform-style: preserve-3d;
            will-change: transform;
            transition: transform 180ms cubic-bezier(.2, .8, .2, 1), box-shadow 220ms ease, border-color 220ms ease;
        }

        body.home .rs-value-card:hover,
        body.home .rs-activity-card:hover,
        body.home .rs-event-card:hover,
        body.home .rs-center-card:hover,
        body.home .rs-team-card:hover,
        body.home .rs-center-intro:hover,
        body.home .rs-center-locate:hover,
        body.home .rs-stat-grid:hover {
            --card-lift: -8px;
            --card-scale: 1.025;
        }

        body.home .rs-value-card > *,
        body.home .rs-activity-card > *,
        body.home .rs-event-card > *,
        body.home .rs-center-card > *,
        body.home .rs-team-card > *,
        body.home .rs-center-intro > *,
        body.home .rs-center-locate > *,
        body.home .rs-stat-grid > * {
            transform: translateZ(16px);
        }

        body.home .rs-homepage .rs-btn,
        body.home .rs-homepage .rs-center-button,
        body.home .rs-homepage .rs-register-button,
        body.home .rs-homepage .rs-outline-link {
            --button-x: 50%;
            --button-y: 50%;
            position: relative;
            isolation: isolate;
            overflow: hidden;
            transform: translateY(0) scale(1);
            transition: transform 180ms ease, box-shadow 180ms ease, color 180ms ease;
        }

        body.home .rs-homepage .rs-btn::before,
        body.home .rs-homepage .rs-center-button::before,
        body.home .rs-homepage .rs-register-button::before,
        body.home .rs-homepage .rs-outline-link::before {
            position: absolute;
            top: var(--button-y);
            left: var(--button-x);
            z-index: -1;
            width: 24px;
            height: 24px;
            border: 1px solid rgba(255, 255, 255, .88);
            border-radius: 50%;
            content: "";
            opacity: 0;
            transform: translate(-50%, -50%) scale(.45);
            transition: opacity 160ms ease, transform 220ms ease;
        }

        body.home .rs-homepage .rs-btn::after,
        body.home .rs-homepage .rs-center-button::after,
        body.home .rs-homepage .rs-register-button::after,
        body.home .rs-homepage .rs-outline-link::after {
            position: absolute;
            top: var(--button-y);
            left: var(--button-x);
            z-index: -1;
            width: 34px;
            height: 34px;
            background: linear-gradient(#fff, #fff) center / 1px 100% no-repeat, linear-gradient(90deg, #fff, #fff) center / 100% 1px no-repeat;
            content: "";
            opacity: 0;
            transform: translate(-50%, -50%) rotate(45deg) scale(.6);
            transition: opacity 160ms ease, transform 220ms ease;
        }

        body.home .rs-homepage .rs-btn:hover,
        body.home .rs-homepage .rs-center-button:hover,
        body.home .rs-homepage .rs-register-button:hover,
        body.home .rs-homepage .rs-outline-link:hover {
            transform: translateY(-3px) scale(1.035);
        }

        body.home .rs-homepage .rs-btn:hover::before,
        body.home .rs-homepage .rs-center-button:hover::before,
        body.home .rs-homepage .rs-register-button:hover::before,
        body.home .rs-homepage .rs-outline-link:hover::before,
        body.home .rs-homepage .rs-btn:hover::after,
        body.home .rs-homepage .rs-center-button:hover::after,
        body.home .rs-homepage .rs-register-button:hover::after,
        body.home .rs-homepage .rs-outline-link:hover::after {
            opacity: .8;
            transform: translate(-50%, -50%) rotate(0) scale(1);
        }

        body.home .rs-homepage .rs-btn.rs-crosshair-active::before,
        body.home .rs-homepage .rs-center-button.rs-crosshair-active::before,
        body.home .rs-homepage .rs-register-button.rs-crosshair-active::before,
        body.home .rs-homepage .rs-outline-link.rs-crosshair-active::before,
        body.home .rs-homepage .rs-btn.rs-crosshair-active::after,
        body.home .rs-homepage .rs-center-button.rs-crosshair-active::after,
        body.home .rs-homepage .rs-register-button.rs-crosshair-active::after,
        body.home .rs-homepage .rs-outline-link.rs-crosshair-active::after {
            opacity: .8 !important;
            transform: translate(-50%, -50%) rotate(0) scale(1) !important;
        }

        body.home .rs-homepage .rs-hero-icon,
        body.home .rs-homepage .rs-center-locate svg,
        body.home .rs-homepage .rs-center-search svg,
        body.home .rs-homepage .rs-value-card i,
        body.home .rs-homepage .rs-activity-card > i {
            transform: translateZ(24px) rotateX(0deg) rotateY(0deg) scale(1);
            transform-style: preserve-3d;
            filter: drop-shadow(0 8px 5px rgba(85, 0, 0, .22));
            transition: transform 260ms cubic-bezier(.2, .8, .2, 1), filter 260ms ease;
        }

        body.home .rs-homepage .rs-value-card:hover i,
        body.home .rs-homepage .rs-activity-card:hover > i,
        body.home .rs-homepage .rs-center-locate:hover svg,
        body.home .rs-homepage .rs-center-search:focus-within svg,
        body.home .rs-homepage .rs-hero-action-row:hover .rs-hero-icon {
            transform: translateZ(34px) rotateX(10deg) rotateY(-12deg) scale(1.12);
            filter: drop-shadow(0 14px 8px rgba(85, 0, 0, .3));
        }

        body.home .rs-homepage .rs-activity-card img,
        body.home .rs-homepage .rs-event-card img,
        body.home .rs-homepage .rs-center-card img,
        body.home .rs-homepage .rs-team-card img,
        body.home .rs-homepage .rs-gallery-grid img {
            transition: transform 450ms cubic-bezier(.2, .8, .2, 1), filter 450ms ease;
        }

        body.home .rs-homepage .rs-activity-card:hover img,
        body.home .rs-homepage .rs-event-card:hover img,
        body.home .rs-homepage .rs-center-card:hover img,
        body.home .rs-homepage .rs-team-card:hover img,
        body.home .rs-homepage .rs-gallery-grid img:hover {
            transform: scale(1.08) translateZ(12px);
            filter: saturate(1.18) contrast(1.06) brightness(1.06);
        }

        body.home .rs-navigation .rs-nav-link {
            transition: color 180ms ease, transform 180ms ease;
        }

        body.home .rs-navigation .rs-nav-link:hover {
            transform: translateY(-3px);
        }

        body.home .rs-brand,
        body.home .rs-footer-logo,
        body.home .rs-header-logo,
        body.home .rs-homepage h1,
        body.home .rs-homepage h2,
        body.home .rs-homepage h3,
        body.home .rs-homepage p,
        body.home .rs-homepage .rs-kicker,
        body.home .rs-homepage .rs-hero-eyebrow {
            transition: transform 260ms cubic-bezier(.2, .8, .2, 1), color 220ms ease, text-shadow 220ms ease, filter 220ms ease;
        }

        body.home .rs-brand:hover {
            transform: perspective(600px) rotateY(-10deg) rotateX(4deg) translateY(-3px) scale(1.04);
        }

        body.home .rs-footer-logo:hover {
            transform: perspective(600px) rotateY(10deg) rotateX(4deg) translateY(-3px) scale(1.04);
        }

        body.home .rs-brand:hover img,
        body.home .rs-footer-logo:hover img,
        body.home .rs-header-logo:hover {
            filter: drop-shadow(0 8px 6px rgba(85, 0, 0, .3)) saturate(1.2);
            transform: translateZ(22px) rotateZ(-2deg) scale(1.08);
        }

        body.home .rs-homepage h1:hover,
        body.home .rs-homepage h2:hover,
        body.home .rs-homepage h3:hover,
        body.home .rs-homepage .rs-kicker:hover,
        body.home .rs-homepage .rs-hero-eyebrow:hover {
            color: #B31B1B;
            transform: translate3d(7px, -5px, 0) scale(1.025);
            text-shadow: 0 8px 18px rgba(179, 27, 27, .22), 0 0 14px rgba(243, 106, 33, .2);
        }

        body.home .rs-homepage p:hover {
            transform: translate3d(4px, -2px, 0);
            color: #550000;
            text-shadow: 0 4px 12px rgba(255, 255, 255, .9);
        }

        body.home .rs-homepage .rs-section-row h2::before,
        body.home .rs-homepage .rs-value-card::before {
            transform-origin: left center;
            transition: transform 300ms cubic-bezier(.2, .8, .2, 1), box-shadow 300ms ease;
        }

        body.home .rs-homepage .rs-section-row h2:hover::before,
        body.home .rs-homepage .rs-value-card:hover::before {
            transform: scaleX(1.9);
            box-shadow: 0 0 18px rgba(243, 106, 33, .75);
        }

        body.home .rs-homepage .rs-btn:hover,
        body.home .rs-homepage .rs-center-button:hover,
        body.home .rs-homepage .rs-register-button:hover,
        body.home .rs-homepage .rs-outline-link:hover {
            animation: rs-button-pulse 1.15s ease-in-out infinite alternate;
        }

        body.home .rs-homepage .rs-btn::marker,
        body.home .rs-homepage .rs-center-button::marker,
        body.home .rs-homepage .rs-register-button::marker {
            display: none;
        }

        body.home .rs-homepage::before {
            transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), 0) scale(1.04);
            transition: transform 900ms cubic-bezier(.2, .8, .2, 1);
        }

        body.home .rs-homepage::after {
            animation: rs-atmosphere-pulse 5s ease-in-out infinite alternate;
        }
    }

    @keyframes rs-button-pulse {
        0% { box-shadow: 0 12px 26px rgba(179, 27, 27, .28), 0 0 12px rgba(179, 27, 27, .12); }
        100% { box-shadow: 0 18px 34px rgba(179, 27, 27, .42), 0 0 28px rgba(243, 106, 33, .3); }
    }

    @keyframes rs-atmosphere-pulse {
        0% { opacity: .28; transform: scale(.96); }
        100% { opacity: .6; transform: scale(1.08); }
    }

    body.home .rs-homepage > section {
        position: relative;
        z-index: 1;
    }

    body.home .rs-home-atmosphere {
        position: absolute;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        pointer-events: none;
        perspective: 900px;
        transform-style: preserve-3d;
    }

    body.home .rs-atmosphere-ring,
    body.home .rs-atmosphere-petal {
        position: absolute;
        display: block;
        transform-style: preserve-3d;
        pointer-events: none;
        will-change: transform;
    }

    body.home .rs-atmosphere-ring {
        border: 1px solid rgba(179, 27, 27, .22);
        border-radius: 50%;
        box-shadow: 0 0 26px rgba(243, 106, 33, .14), inset 0 0 24px rgba(249, 183, 42, .1);
        opacity: .72;
    }

    body.home .rs-atmosphere-ring::before,
    body.home .rs-atmosphere-ring::after {
        position: absolute;
        inset: 12%;
        border: 1px solid rgba(243, 106, 33, .24);
        border-radius: 50%;
        content: "";
    }

    body.home .rs-atmosphere-ring::after {
        inset: 25%;
        border-color: rgba(249, 183, 42, .36);
        box-shadow: 0 0 18px rgba(249, 183, 42, .3);
    }

    body.home .rs-atmosphere-ring-one {
        top: 9%;
        right: -5rem;
        width: 11rem;
        height: 11rem;
        animation: rs-ring-orbit-one 16s ease-in-out infinite alternate;
    }

    body.home .rs-atmosphere-ring-two {
        top: 58%;
        left: -7rem;
        width: 14rem;
        height: 14rem;
        border-color: rgba(85, 0, 0, .16);
        animation: rs-ring-orbit-two 21s ease-in-out infinite alternate-reverse;
    }

    body.home .rs-atmosphere-petal {
        width: 3.2rem;
        height: 5.8rem;
        border: 1px solid rgba(179, 27, 27, .2);
        border-radius: 100% 0 100% 0;
        background: linear-gradient(145deg, rgba(255, 248, 236, .1), rgba(243, 106, 33, .08));
        box-shadow: 8px 12px 20px rgba(85, 0, 0, .1), inset 0 0 18px rgba(249, 183, 42, .16);
        opacity: .72;
    }

    body.home .rs-atmosphere-petal-one {
        top: 34%;
        right: 18%;
        animation: rs-petal-float-one 11s ease-in-out infinite alternate;
    }

    body.home .rs-atmosphere-petal-two {
        top: 72%;
        right: 29%;
        width: 2.6rem;
        height: 4.7rem;
        border-color: rgba(249, 183, 42, .3);
        animation: rs-petal-float-two 13s ease-in-out infinite alternate-reverse;
    }

    body.home .rs-atmosphere-petal-three {
        top: 18%;
        left: 24%;
        width: 2.2rem;
        height: 4rem;
        border-color: rgba(243, 106, 33, .26);
        animation: rs-petal-float-three 9s ease-in-out infinite alternate;
    }

    body.home .rs-atmosphere-petal-four,
    body.home .rs-atmosphere-petal-five,
    body.home .rs-atmosphere-petal-six,
    body.home .rs-atmosphere-petal-seven,
    body.home .rs-atmosphere-petal-eight,
    body.home .rs-atmosphere-petal-nine,
    body.home .rs-atmosphere-petal-ten,
    body.home .rs-atmosphere-petal-eleven,
    body.home .rs-atmosphere-petal-twelve,
    body.home .rs-atmosphere-petal-thirteen,
    body.home .rs-atmosphere-petal-fourteen,
    body.home .rs-atmosphere-petal-fifteen {
        width: 1.8rem;
        height: 3.2rem;
        opacity: .58;
        animation: rs-petal-float-three 12s ease-in-out infinite alternate;
    }

    body.home .rs-atmosphere-petal-four { top: 7%; left: 18%; }
    body.home .rs-atmosphere-petal-five { top: 29%; right: 7%; animation-delay: -2s; }
    body.home .rs-atmosphere-petal-six { top: 38%; left: 6%; animation-delay: -4s; }
    body.home .rs-atmosphere-petal-seven { top: 47%; left: 51%; animation-delay: -6s; }
    body.home .rs-atmosphere-petal-eight { top: 56%; right: 17%; animation-delay: -8s; }
    body.home .rs-atmosphere-petal-nine { top: 63%; left: 24%; animation-delay: -1s; }
    body.home .rs-atmosphere-petal-ten { top: 74%; right: 48%; animation-delay: -3s; }
    body.home .rs-atmosphere-petal-eleven { top: 81%; left: 4%; animation-delay: -5s; }
    body.home .rs-atmosphere-petal-twelve { top: 91%; right: 38%; animation-delay: -7s; }
    body.home .rs-atmosphere-petal-thirteen { top: 14%; right: 48%; animation-delay: -9s; }
    body.home .rs-atmosphere-petal-fourteen { top: 69%; right: 3%; animation-delay: -11s; }
    body.home .rs-atmosphere-petal-fifteen { top: 96%; left: 68%; animation-delay: -13s; }

    body.home .rs-atmosphere-leaf,
    body.home .rs-atmosphere-flower,
    body.home .rs-atmosphere-lotus {
        position: absolute;
        display: grid;
        place-items: center;
        pointer-events: none;
        transform-style: preserve-3d;
        will-change: transform;
    }

    body.home .rs-atmosphere-leaf {
        width: 1.7rem;
        height: 3.2rem;
        border: 1px solid rgba(85, 0, 0, .28);
        border-radius: 100% 0 100% 0;
        background: linear-gradient(135deg, rgba(179, 27, 27, .12), rgba(249, 183, 42, .16));
        box-shadow: 5px 7px 12px rgba(85, 0, 0, .12), inset 0 0 9px rgba(249, 183, 42, .22);
        opacity: .82;
    }

    body.home .rs-atmosphere-leaf::after {
        width: 1px;
        height: 80%;
        background: rgba(85, 0, 0, .34);
        content: "";
        transform: rotate(28deg);
    }

    body.home .rs-atmosphere-leaf-one { top: 12%; left: 8%; animation: rs-leaf-drift-one 8s ease-in-out infinite alternate; }
    body.home .rs-atmosphere-leaf-two { top: 42%; left: 31%; animation: rs-leaf-drift-two 10s ease-in-out infinite alternate-reverse; }
    body.home .rs-atmosphere-leaf-three { top: 67%; right: 9%; animation: rs-leaf-drift-three 12s ease-in-out infinite alternate; }
    body.home .rs-atmosphere-leaf-four { top: 84%; left: 47%; animation: rs-leaf-drift-one 14s ease-in-out infinite alternate-reverse; }

    body.home .rs-atmosphere-leaf-five,
    body.home .rs-atmosphere-leaf-six,
    body.home .rs-atmosphere-leaf-seven,
    body.home .rs-atmosphere-leaf-eight,
    body.home .rs-atmosphere-leaf-nine,
    body.home .rs-atmosphere-leaf-ten,
    body.home .rs-atmosphere-leaf-eleven,
    body.home .rs-atmosphere-leaf-twelve,
    body.home .rs-atmosphere-leaf-thirteen,
    body.home .rs-atmosphere-leaf-fourteen,
    body.home .rs-atmosphere-leaf-fifteen,
    body.home .rs-atmosphere-leaf-sixteen,
    body.home .rs-atmosphere-leaf-seventeen,
    body.home .rs-atmosphere-leaf-eighteen,
    body.home .rs-atmosphere-leaf-nineteen,
    body.home .rs-atmosphere-leaf-twenty {
        width: 1.1rem;
        height: 2.1rem;
        opacity: .64;
        animation: rs-leaf-drift-two 11s ease-in-out infinite alternate;
    }

    body.home .rs-atmosphere-leaf-five { top: 5%; left: 38%; }
    body.home .rs-atmosphere-leaf-six { top: 11%; right: 19%; animation-delay: -1s; }
    body.home .rs-atmosphere-leaf-seven { top: 23%; left: 3%; animation-delay: -2s; }
    body.home .rs-atmosphere-leaf-eight { top: 31%; left: 58%; animation-delay: -3s; }
    body.home .rs-atmosphere-leaf-nine { top: 43%; right: 4%; animation-delay: -4s; }
    body.home .rs-atmosphere-leaf-ten { top: 52%; left: 18%; animation-delay: -5s; }
    body.home .rs-atmosphere-leaf-eleven { top: 61%; left: 72%; animation-delay: -6s; }
    body.home .rs-atmosphere-leaf-twelve { top: 68%; left: 39%; animation-delay: -7s; }
    body.home .rs-atmosphere-leaf-thirteen { top: 76%; right: 23%; animation-delay: -8s; }
    body.home .rs-atmosphere-leaf-fourteen { top: 86%; left: 14%; animation-delay: -9s; }
    body.home .rs-atmosphere-leaf-fifteen { top: 93%; right: 7%; animation-delay: -10s; }
    body.home .rs-atmosphere-leaf-sixteen { top: 98%; left: 31%; animation-delay: -11s; }
    body.home .rs-atmosphere-leaf-seventeen { top: 36%; left: 84%; animation-delay: -12s; }
    body.home .rs-atmosphere-leaf-eighteen { top: 58%; left: 5%; animation-delay: -13s; }
    body.home .rs-atmosphere-leaf-nineteen { top: 79%; left: 58%; animation-delay: -14s; }
    body.home .rs-atmosphere-leaf-twenty { top: 16%; left: 69%; animation-delay: -15s; }

    body.home .rs-atmosphere-flower,
    body.home .rs-atmosphere-lotus {
        color: rgba(179, 27, 27, .42);
        font-family: Georgia, serif;
        line-height: 1;
        text-shadow: 5px 7px 8px rgba(85, 0, 0, .16), 0 0 12px rgba(249, 183, 42, .3);
    }

    body.home .rs-atmosphere-flower {
        font-size: 1.8rem;
    }

    body.home .rs-atmosphere-lotus {
        width: 2.8rem;
        height: 2.8rem;
        border: 1px solid rgba(243, 106, 33, .28);
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 248, 236, .18), rgba(243, 106, 33, .06));
        font-size: 1.65rem;
    }

    body.home .rs-atmosphere-flower-one { top: 25%; left: 45%; animation: rs-flower-spin 11s linear infinite; }
    body.home .rs-atmosphere-flower-two { top: 54%; right: 37%; font-size: 1.35rem; animation: rs-flower-spin 15s linear infinite reverse; }
    body.home .rs-atmosphere-flower-three { top: 78%; left: 17%; font-size: 1.25rem; animation: rs-flower-spin 9s linear infinite; }
    body.home .rs-atmosphere-lotus-one { top: 16%; right: 32%; animation: rs-lotus-breathe 7s ease-in-out infinite alternate; }
    body.home .rs-atmosphere-lotus-two { top: 49%; left: 13%; animation: rs-lotus-breathe 10s ease-in-out infinite alternate-reverse; }
    body.home .rs-atmosphere-lotus-three { top: 88%; right: 18%; animation: rs-lotus-breathe 8s ease-in-out infinite alternate; }

    body.home .rs-atmosphere-yoga {
        position: absolute;
        color: rgba(85, 0, 0, .38);
        font-size: 1.25rem;
        line-height: 1;
        text-shadow: 3px 5px 7px rgba(85, 0, 0, .18), 0 0 10px rgba(249, 183, 42, .25);
        transform-style: preserve-3d;
        will-change: transform;
        animation: rs-yoga-float 10s ease-in-out infinite alternate;
    }

    body.home .rs-atmosphere-yoga-one { top: 9%; left: 52%; }
    body.home .rs-atmosphere-yoga-two { top: 21%; right: 5%; animation-delay: -1s; }
    body.home .rs-atmosphere-yoga-three { top: 33%; left: 13%; animation-delay: -2s; }
    body.home .rs-atmosphere-yoga-four { top: 46%; right: 28%; animation-delay: -3s; }
    body.home .rs-atmosphere-yoga-five { top: 59%; left: 7%; animation-delay: -4s; }
    body.home .rs-atmosphere-yoga-six { top: 68%; right: 5%; animation-delay: -5s; }
    body.home .rs-atmosphere-yoga-seven { top: 77%; left: 33%; animation-delay: -6s; }
    body.home .rs-atmosphere-yoga-eight { top: 85%; right: 44%; animation-delay: -7s; }
    body.home .rs-atmosphere-yoga-nine { top: 93%; left: 81%; animation-delay: -8s; }
    body.home .rs-atmosphere-yoga-ten { top: 27%; left: 76%; animation-delay: -9s; }

    @keyframes rs-yoga-float {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), -20px) rotateY(-14deg) rotateZ(-8deg) scale(.82); }
        100% { transform: translate3d(calc(var(--background-x, 0px) + 20px), calc(var(--background-y, 0px) - 24px), 60px) rotateY(14deg) rotateZ(8deg) scale(1.08); }
    }

    @keyframes rs-ring-orbit-one {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), -40px) rotateX(62deg) rotateZ(-12deg) scale(.9); }
        100% { transform: translate3d(calc(var(--background-x, 0px) - 34px), calc(var(--background-y, 0px) + 26px), 80px) rotateX(18deg) rotateZ(28deg) scale(1.08); }
    }

    @keyframes rs-ring-orbit-two {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), 50px) rotateY(64deg) rotateZ(8deg) scale(1); }
        100% { transform: translate3d(calc(var(--background-x, 0px) + 38px), calc(var(--background-y, 0px) - 24px), -60px) rotateY(18deg) rotateZ(-30deg) scale(.88); }
    }

    @keyframes rs-petal-float-one {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), -20px) rotateZ(-24deg) rotateY(18deg); }
        100% { transform: translate3d(calc(var(--background-x, 0px) - 24px), calc(var(--background-y, 0px) - 38px), 90px) rotateZ(26deg) rotateY(-24deg); }
    }

    @keyframes rs-petal-float-two {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), 40px) rotateZ(32deg); }
        100% { transform: translate3d(calc(var(--background-x, 0px) + 26px), calc(var(--background-y, 0px) - 28px), -30px) rotateZ(-22deg); }
    }

    @keyframes rs-petal-float-three {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), 20px) rotateZ(-42deg); }
        100% { transform: translate3d(calc(var(--background-x, 0px) + 18px), calc(var(--background-y, 0px) + 30px), 70px) rotateZ(18deg); }
    }

    @keyframes rs-leaf-drift-one {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), -20px) rotateZ(-24deg) rotateY(20deg); }
        100% { transform: translate3d(calc(var(--background-x, 0px) + 22px), calc(var(--background-y, 0px) - 26px), 50px) rotateZ(28deg) rotateY(-18deg); }
    }

    @keyframes rs-leaf-drift-two {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), 35px) rotateZ(34deg) rotateX(18deg); }
        100% { transform: translate3d(calc(var(--background-x, 0px) - 28px), calc(var(--background-y, 0px) + 22px), -30px) rotateZ(-18deg) rotateX(-18deg); }
    }

    @keyframes rs-leaf-drift-three {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), 10px) rotateZ(-42deg); }
        100% { transform: translate3d(calc(var(--background-x, 0px) + 20px), calc(var(--background-y, 0px) - 32px), 65px) rotateZ(22deg); }
    }

    @keyframes rs-flower-spin {
        from { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), -10px) rotateZ(0deg) rotateX(12deg); }
        to { transform: translate3d(calc(var(--background-x, 0px) + 18px), calc(var(--background-y, 0px) - 20px), 45px) rotateZ(360deg) rotateX(-12deg); }
    }

    @keyframes rs-lotus-breathe {
        0% { transform: translate3d(var(--background-x, 0px), var(--background-y, 0px), -10px) rotateY(-18deg) scale(.86); }
        100% { transform: translate3d(calc(var(--background-x, 0px) - 20px), calc(var(--background-y, 0px) - 24px), 60px) rotateY(18deg) scale(1.12); }
    }

    @media (prefers-reduced-motion: reduce), (pointer: coarse) {
        body.home .rs-atmosphere-ring,
        body.home .rs-atmosphere-petal,
        body.home .rs-atmosphere-leaf,
        body.home .rs-atmosphere-flower,
        body.home .rs-atmosphere-lotus,
        body.home .rs-atmosphere-yoga {
            animation: none;
        }
    }

    @media (prefers-reduced-motion: reduce), (pointer: coarse) {
        body.home .rs-value-card,
        body.home .rs-activity-card,
        body.home .rs-event-card,
        body.home .rs-center-card,
        body.home .rs-team-card,
        body.home .rs-center-intro,
        body.home .rs-center-locate,
        body.home .rs-stat-grid {
            transform: none !important;
            transition: box-shadow 180ms ease, border-color 180ms ease;
        }
    }

    body.home .rs-homepage .rs-btn.rs-crosshair-active::before,
    body.home .rs-homepage .rs-center-button.rs-crosshair-active::before,
    body.home .rs-homepage .rs-register-button.rs-crosshair-active::before,
    body.home .rs-homepage .rs-outline-link.rs-crosshair-active::before {
        opacity: .8 !important;
        transform: translate(-50%, -50%) scale(1) !important;
    }

    body.home .rs-homepage .rs-btn.rs-crosshair-active::after,
    body.home .rs-homepage .rs-center-button.rs-crosshair-active::after,
    body.home .rs-homepage .rs-register-button.rs-crosshair-active::after,
    body.home .rs-homepage .rs-outline-link.rs-crosshair-active::after {
        opacity: .8 !important;
        transform: translate(-50%, -50%) rotate(0) scale(1) !important;
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
                homepage.style.setProperty('--background-x', ((event.clientX / window.innerWidth - .5) * -18).toFixed(2) + 'px');
                homepage.style.setProperty('--background-y', ((event.clientY / window.innerHeight - .5) * -12).toFixed(2) + 'px');
            }, { passive: true });

            var tiltCards = homepage.querySelectorAll('.rs-value-card, .rs-activity-card, .rs-event-card, .rs-center-card, .rs-team-card, .rs-center-intro, .rs-center-locate, .rs-stat-grid');
            Array.prototype.forEach.call(tiltCards, function (card) {
                card.addEventListener('pointermove', function (event) {
                    var bounds = card.getBoundingClientRect();
                    var horizontal = (event.clientX - bounds.left) / bounds.width - .5;
                    var vertical = (event.clientY - bounds.top) / bounds.height - .5;
                    card.style.setProperty('--card-rotate-x', (vertical * -7).toFixed(2) + 'deg');
                    card.style.setProperty('--card-rotate-y', (horizontal * 9).toFixed(2) + 'deg');
                }, { passive: true });

                card.addEventListener('pointerleave', function () {
                    card.style.setProperty('--card-rotate-x', '0deg');
                    card.style.setProperty('--card-rotate-y', '0deg');
                });
            });

            var interactiveButtons = homepage.querySelectorAll('.rs-btn, .rs-center-button, .rs-register-button, .rs-outline-link');
            Array.prototype.forEach.call(interactiveButtons, function (button) {
                button.addEventListener('pointermove', function (event) {
                    var bounds = button.getBoundingClientRect();
                    button.style.setProperty('--button-x', (event.clientX - bounds.left) + 'px');
                    button.style.setProperty('--button-y', (event.clientY - bounds.top) + 'px');
                    button.classList.add('rs-crosshair-active');
                }, { passive: true });

                button.addEventListener('pointerleave', function () {
                    button.style.setProperty('--button-x', '50%');
                    button.style.setProperty('--button-y', '50%');
                    button.classList.remove('rs-crosshair-active');
                });
            });
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
        var speed = 0.035;
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

    <div class="rs-home-atmosphere" aria-hidden="true">
        <span class="rs-atmosphere-ring rs-atmosphere-ring-one"></span>
        <span class="rs-atmosphere-ring rs-atmosphere-ring-two"></span>
        <span class="rs-atmosphere-petal rs-atmosphere-petal-one"></span>
        <span class="rs-atmosphere-petal rs-atmosphere-petal-two"></span>
        <span class="rs-atmosphere-petal rs-atmosphere-petal-three"></span>
        <span class="rs-atmosphere-petal rs-atmosphere-petal-four"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-five"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-six"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-seven"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-eight"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-nine"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-ten"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-eleven"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-twelve"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-thirteen"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-fourteen"></span><span class="rs-atmosphere-petal rs-atmosphere-petal-fifteen"></span>
        <span class="rs-atmosphere-leaf rs-atmosphere-leaf-one"></span>
        <span class="rs-atmosphere-leaf rs-atmosphere-leaf-two"></span>
        <span class="rs-atmosphere-leaf rs-atmosphere-leaf-three"></span>
        <span class="rs-atmosphere-leaf rs-atmosphere-leaf-four"></span>
        <span class="rs-atmosphere-leaf rs-atmosphere-leaf-five"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-six"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-seven"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-eight"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-nine"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-ten"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-eleven"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-twelve"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-thirteen"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-fourteen"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-fifteen"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-sixteen"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-seventeen"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-eighteen"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-nineteen"></span><span class="rs-atmosphere-leaf rs-atmosphere-leaf-twenty"></span>
        <span class="rs-atmosphere-flower rs-atmosphere-flower-one">✿</span>
        <span class="rs-atmosphere-flower rs-atmosphere-flower-two">✿</span>
        <span class="rs-atmosphere-flower rs-atmosphere-flower-three">✦</span>
        <span class="rs-atmosphere-lotus rs-atmosphere-lotus-two">☯</span>
        <span class="rs-atmosphere-yoga rs-atmosphere-yoga-one">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-two">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-three">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-four">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-five">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-six">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-seven">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-eight">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-nine">🧘</span><span class="rs-atmosphere-yoga rs-atmosphere-yoga-ten">🧘</span>
    </div>

    <?php get_template_part('template-parts/home/hero'); ?>
    <?php get_template_part('template-parts/home/homepage-sections'); ?>

</main>

<?php get_footer(); ?>
