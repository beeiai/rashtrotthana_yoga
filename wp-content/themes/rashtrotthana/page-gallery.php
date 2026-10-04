<?php
/**
 * Template Name: Gallery Page
 * Description: Redesigned Gallery page matching Home, Activities, Centers, and Events pages.
 *              Features event-wise photo and video categorization with interactive event viewer.
 */

get_header();

// Gallery albums data — loaded from data/gallery-data.php.
// To swap in DB data, update rs_get_gallery_albums() in inc/data-helpers.php.
$gallery_events = rs_get_gallery_albums();

// Collect all standalone videos for the Video Gallery track
$all_videos = array();
foreach ( $gallery_events as $event ) {
    foreach ( $event['videos'] as $v ) {
        $v['event_id']    = $event['id'];
        $v['event_title'] = $event['title'];
        $all_videos[]     = $v;
    }
}
?>

<style>
/* ============================================================
   Rashtrotthana Gallery Page Design System
   Matches Home, Activities, Centers & Events Pages
   ============================================================ */
:root {
    --color-maroon: #8F171D;
    --color-maroon-dark: #6e1015;
    --color-saffron: #F36A21;
    --color-gold: #F9B72A;
    --color-cream: #FFF8EC;
    --color-sand: #F7EBD7;
    --color-text: #292522;
    --color-text-muted: #6b5c53;
}

/* Base Page Wrapper with Animated Nature Atmosphere */
.rs-gallery-page {
    position: relative;
    isolation: isolate;
    overflow-x: hidden;
    background-color: var(--color-cream) !important;
    background-image:
        radial-gradient(circle at 10% 8%, rgba(249, 183, 42, .24), transparent 28rem),
        radial-gradient(circle at 90% 12%, rgba(243, 106, 33, .16), transparent 32rem),
        linear-gradient(180deg, rgba(255, 248, 236, .94) 0%, rgba(255, 248, 236, .84) 40%, rgba(255, 248, 236, .96) 100%),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>") !important;
    background-position: center top, center top, center top, center top !important;
    background-size: auto, auto, auto, 1920px auto !important;
    background-repeat: no-repeat, no-repeat, no-repeat, repeat-y !important;
    background-attachment: scroll, scroll, scroll, fixed !important;
    color: var(--color-text);
    font-family: 'Poppins', sans-serif !important;
    padding-bottom: 3.5rem;
}

.rs-gallery-page * {
    font-family: 'Poppins', sans-serif !important;
    box-sizing: border-box;
}

/* Ambient Floating Glow Orbs */
.rs-gallery-page::before,
.rs-gallery-page::after {
    content: "";
    position: absolute;
    pointer-events: none;
    z-index: 0;
    border-radius: 50%;
}

.rs-gallery-page::before {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 6% 15%, rgba(249, 183, 42, .18), transparent 28rem),
        radial-gradient(circle at 94% 22%, rgba(243, 106, 33, .14), transparent 32rem);
}

.rs-gallery-page::after {
    top: 50rem;
    right: -12rem;
    width: 36rem;
    height: 36rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .22), transparent 70%);
    animation: rsg-atmosphere-pulse 5s ease-in-out infinite alternate;
}

@keyframes rsg-atmosphere-pulse {
    0%   { opacity: .25; transform: scale(.95); }
    100% { opacity: .55; transform: scale(1.08); }
}

/* Side Margins: Matching Home, Centers, and Events pages exactly */
.rs-gallery-page .rs-container {
    width: 100% !important;
    max-width: none !important;
    padding-inline: clamp(20px, 4vw, 64px) !important;
    margin-inline: auto !important;
    box-sizing: border-box;
    position: relative;
    z-index: 2;
}

/* ============================================================
   Page Header Section (Replacing the old bulky Hero)
   ============================================================ */
.rs-gallery-header-section {
    padding: 3.5rem 0 2.25rem;
    text-align: center;
}

.rs-gallery-title-block {
    max-width: 820px;
    margin: 0 auto;
}

.rs-gallery-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: .85rem;
    padding: .35rem .95rem;
    border: 1px solid rgba(143, 23, 29, .18);
    border-radius: 999px;
    background: rgba(255, 248, 236, .85);
    box-shadow: 0 4px 14px rgba(143, 23, 29, .06);
    color: var(--color-maroon);
    font-size: .82rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rs-gallery-eyebrow-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--color-saffron);
    box-shadow: 0 0 10px rgba(243, 106, 33, .8);
    animation: rsg-dot-blink 1.8s ease-in-out infinite;
}

@keyframes rsg-dot-blink {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.35); opacity: .6; }
}

.rs-gallery-page-title {
    margin: 0 0 1rem;
    color: #542019;
    font-size: clamp(2.3rem, 4vw, 3.4rem);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -.02em;
}

.rs-gallery-page-title em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-gallery-page-subtitle {
    margin: 0 auto 2.25rem;
    max-width: 680px;
    color: #67574c;
    font-size: clamp(1rem, 1.25vw, 1.12rem);
    line-height: 1.65;
}

/* Number Cards / Stat Pills (Clean typography without icons, matching Events page) */
.rs-gallery-stats-bar {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.15rem;
    margin-bottom: 2.25rem;
}

.rs-gallery-stat-pill {
    display: inline-flex;
    align-items: center;
    gap: .65rem;
    padding: .65rem 1.45rem;
    border: 1px solid rgba(255, 255, 255, .85);
    border-radius: 999px;
    background: rgba(255, 255, 255, .75);
    box-shadow: 0 6px 20px rgba(89, 37, 24, .06);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    color: #542019;
}

.rs-gallery-stat-pill strong {
    color: var(--color-maroon);
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1;
}

.rs-gallery-stat-pill span {
    color: #67574c;
    font-size: .88rem;
    font-weight: 600;
}

/* Category Filter Bar */
.rs-gallery-filter-bar {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: .55rem;
    margin: 1.5rem auto 2.75rem;
    max-width: 960px;
    padding: .45rem;
    border-radius: 999px;
    background: rgba(255, 245, 223, .7);
    border: 1px solid rgba(143, 23, 29, .14);
    box-shadow: 0 8px 24px rgba(89, 37, 24, .05);
}

.rs-gallery-tab-btn {
    padding: .5rem 1.2rem;
    border: 0;
    border-radius: 999px;
    background: transparent;
    color: #67574c;
    font-size: .84rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 180ms ease;
    white-space: nowrap;
}

.rs-gallery-tab-btn:hover {
    color: var(--color-maroon);
    background: rgba(255, 255, 255, .7);
}

.rs-gallery-tab-btn.is-active {
    background: var(--color-maroon);
    color: #fff;
    box-shadow: 0 4px 14px rgba(143, 23, 29, .28);
}

/* ============================================================
   Section Headers
   ============================================================ */
.rs-gallery-section {
    padding: 2.25rem 0 3.25rem;
    position: relative;
}

.rs-gallery-section-header {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
}

.rs-gallery-section-header h2 {
    position: relative;
    margin: 0;
    color: #542019;
    font-size: clamp(1.85rem, 3vw, 2.5rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -.015em;
}

.rs-gallery-section-header h2 em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-gallery-section-header h2::after {
    content: "";
    display: block;
    width: 48px;
    height: 4px;
    margin-top: .65rem;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--color-maroon), var(--color-saffron));
}

.rs-gallery-section-desc {
    max-width: 600px;
    margin: .4rem 0 0;
    color: #67574c;
    font-size: .92rem;
    line-height: 1.55;
}

/* ============================================================
   Event Album Showcase Grid (The Event-Wise Categorization)
   ============================================================ */
.rs-event-albums-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.75rem;
}

.rs-event-album-card {
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 490px;
    border: 1px solid rgba(143, 23, 29, .13) !important;
    border-radius: 1.25rem;
    background: rgba(255, 253, 249, .75);
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    overflow: hidden;
    cursor: pointer;
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), box-shadow 260ms ease, border-color 260ms ease;
    text-align: left;
}

.rs-event-album-card::after {
    position: absolute;
    top: 0;
    right: 1.2rem;
    width: 4rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
}

.rs-event-album-card:hover {
    transform: translateY(-7px);
    border-color: rgba(243, 106, 33, .48) !important;
    box-shadow: 0 24px 44px rgba(89, 37, 24, .16), 0 0 20px rgba(249, 183, 42, .14), inset 0 1px 0 #fff;
}

.rs-album-media {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: var(--color-sand);
}

.rs-album-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 450ms cubic-bezier(.2,.8,.2,1), filter 450ms ease;
}

.rs-event-album-card:hover .rs-album-media img {
    transform: scale(1.08);
}

/* Floating Badges on Album Cover */
.rs-album-category-badge {
    position: absolute;
    top: .9rem;
    right: .9rem;
    z-index: 2;
    padding: .35rem .75rem;
    border-radius: 999px;
    background: rgba(84, 32, 25, .82);
    border: 1px solid rgba(255, 255, 255, .7);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #fff;
    font-size: .72rem;
    font-weight: 600;
}

.rs-album-count-badge {
    position: absolute;
    bottom: .9rem;
    left: .9rem;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .35rem .75rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, .92);
    border: 1px solid rgba(143, 23, 29, .15);
    box-shadow: 0 4px 12px rgba(89, 37, 24, .15);
    color: #542019;
    font-size: .74rem;
    font-weight: 700;
}

.rs-album-count-badge svg {
    width: 14px;
    height: 14px;
    stroke: var(--color-maroon);
    stroke-width: 2.2;
    fill: none;
}

/* Album Card Body */
.rs-album-body {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    padding: 1.35rem 1.4rem;
}

.rs-album-meta-row {
    display: flex;
    align-items: center;
    gap: .85rem;
    font-size: .8rem;
    color: #756a61;
    margin-bottom: .6rem;
}

.rs-album-meta-row span {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
}

.rs-album-meta-row svg {
    width: 14px;
    height: 14px;
    stroke: var(--color-maroon);
    stroke-width: 2;
    fill: none;
}

.rs-album-title {
    margin: 0 0 .55rem;
    color: #542019;
    font-size: 1.18rem;
    font-weight: 700;
    line-height: 1.32;
    transition: color 180ms ease;
}

.rs-event-album-card:hover .rs-album-title {
    color: var(--color-maroon);
}

.rs-album-desc {
    margin: 0 0 1.25rem;
    color: #67574c;
    font-size: .88rem;
    line-height: 1.55;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.rs-album-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: .9rem;
    border-top: 1px solid rgba(143, 23, 29, .1);
}

.rs-view-album-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .45rem 1.15rem;
    border-radius: 999px;
    background: #B31B1B;
    border: 1px solid #B31B1B;
    color: #fff;
    font-size: .82rem;
    font-weight: 700;
    box-shadow: 0 6px 16px rgba(179, 27, 27, .25);
    transition: all 180ms ease;
}

.rs-event-album-card:hover .rs-view-album-btn {
    background: #8F171D;
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(179, 27, 27, .38);
}

.rs-view-hint {
    font-size: .78rem;
    color: var(--color-saffron);
    font-weight: 600;
}

/* ============================================================
   Interactive Event Media Viewer (Revealed on Click)
   ============================================================ */
.rs-event-media-hub {
    display: none;
    margin-bottom: 3.5rem;
    padding: 2.25rem 2.25rem 2.5rem;
    border: 1px solid rgba(143, 23, 29, .18);
    border-radius: 1.45rem;
    background: rgba(255, 253, 249, .92);
    box-shadow: 0 18px 45px rgba(89, 37, 24, .12), inset 0 1px 0 rgba(255, 255, 255, .95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    animation: rsg-fade-up 350ms cubic-bezier(.2,.8,.2,1);
}

.rs-event-media-hub.is-active {
    display: block;
}

@keyframes rsg-fade-up {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

.rs-hub-top-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.75rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(143, 23, 29, .14);
}

.rs-hub-back-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .5rem 1.15rem;
    border-radius: 999px;
    border: 1px solid rgba(143, 23, 29, .22);
    background: #fff;
    color: var(--color-maroon);
    font-size: .82rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 180ms ease;
}

.rs-hub-back-btn:hover {
    background: var(--color-maroon);
    color: #fff;
    box-shadow: 0 4px 14px rgba(143, 23, 29, .24);
}

.rs-hub-event-switcher {
    display: flex;
    align-items: center;
    gap: .65rem;
}

.rs-hub-event-switcher label {
    font-size: .84rem;
    font-weight: 600;
    color: #542019;
}

.rs-hub-select {
    height: 2.35rem;
    padding: 0 2rem 0 .95rem;
    border: 1px solid rgba(143, 23, 29, .2);
    border-radius: .6rem;
    background: rgba(255, 255, 255, .95) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238F171D' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right .75rem center;
    color: #542019;
    font-family: 'Poppins', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    outline: none;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
}

.rs-hub-header-info {
    margin-bottom: 2rem;
}

.rs-hub-title {
    margin: 0 0 .5rem;
    font-size: clamp(1.6rem, 2.8vw, 2.2rem);
    font-weight: 800;
    color: #542019;
}

.rs-hub-meta-pills {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .75rem;
    margin-bottom: .85rem;
}

.rs-hub-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .3rem .75rem;
    border-radius: 999px;
    background: #fff0d8;
    color: #a34812;
    font-size: .76rem;
    font-weight: 600;
}

.rs-hub-meta-pill svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2.2;
    fill: none;
}

.rs-hub-desc {
    margin: 0;
    max-width: 820px;
    color: #67574c;
    font-size: .94rem;
    line-height: 1.6;
}

/* Hub Type Filters (All, Photos, Videos) */
.rs-hub-type-tabs {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: 1.75rem;
}

.rs-hub-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .45rem 1.15rem;
    border-radius: 999px;
    border: 1px solid rgba(143, 23, 29, .15);
    background: rgba(255, 255, 255, .7);
    color: #67574c;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 180ms ease;
}

.rs-hub-tab-btn.is-active {
    background: var(--color-maroon);
    color: #fff;
    border-color: var(--color-maroon);
    box-shadow: 0 4px 12px rgba(143, 23, 29, .25);
}

/* Hub Media Grid (Both Photos and Videos) */
.rs-hub-media-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.35rem;
}

.rs-hub-media-card {
    position: relative;
    border-radius: 1.1rem;
    overflow: hidden;
    background: #fff;
    border: 1px solid rgba(143, 23, 29, .14);
    box-shadow: 0 8px 22px rgba(89, 37, 24, .06);
    cursor: pointer;
    transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
    display: flex;
    flex-direction: column;
}

.rs-hub-media-card:hover {
    transform: translateY(-5px);
    border-color: var(--color-saffron);
    box-shadow: 0 16px 32px rgba(89, 37, 24, .14);
}

.rs-hub-thumb-wrap {
    position: relative;
    width: 100%;
    height: 190px;
    overflow: hidden;
    background: var(--color-sand);
}

.rs-hub-thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 380ms ease;
}

.rs-hub-media-card:hover .rs-hub-thumb-wrap img {
    transform: scale(1.07);
}

/* Media Card Play / Zoom Icon Badge */
.rs-hub-play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(42, 20, 15, .28);
    transition: background 200ms ease;
}

.rs-hub-media-card:hover .rs-hub-play-overlay {
    background: rgba(42, 20, 15, .15);
}

.rs-hub-play-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .94);
    color: var(--color-maroon);
    box-shadow: 0 6px 18px rgba(0, 0, 0, .25);
    transition: transform 200ms ease, background 200ms ease;
}

.rs-hub-media-card:hover .rs-hub-play-btn {
    transform: scale(1.15);
    background: var(--color-maroon);
    color: #fff;
}

.rs-hub-play-btn svg {
    width: 22px;
    height: 22px;
    fill: currentColor;
    margin-left: 2px;
}

.rs-hub-zoom-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .92);
    color: var(--color-maroon);
    opacity: 0;
    transform: scale(.85);
    box-shadow: 0 6px 16px rgba(0, 0, 0, .2);
    transition: all 200ms ease;
}

.rs-hub-media-card:hover .rs-hub-zoom-btn {
    opacity: 1;
    transform: scale(1);
}

.rs-hub-zoom-btn svg {
    width: 20px;
    height: 20px;
    stroke: currentColor;
    stroke-width: 2.2;
    fill: none;
}

.rs-hub-duration-badge {
    position: absolute;
    top: .75rem;
    right: .75rem;
    padding: .2rem .55rem;
    border-radius: 4px;
    background: rgba(20, 12, 10, .85);
    color: #fff;
    font-size: .7rem;
    font-weight: 700;
}

.rs-hub-type-tag {
    position: absolute;
    top: .75rem;
    left: .75rem;
    padding: .2rem .6rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, .92);
    color: var(--color-maroon);
    font-size: .68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.rs-hub-card-body {
    padding: .95rem 1.15rem;
}

.rs-hub-card-title {
    margin: 0 0 .25rem;
    font-size: .94rem;
    font-weight: 700;
    color: #542019;
    line-height: 1.35;
}

.rs-hub-card-caption {
    margin: 0;
    font-size: .78rem;
    color: #79695f;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ============================================================
   Featured Video Highlights Showcase Track
   ============================================================ */
.rs-featured-videos-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.35rem;
}

.rs-video-feature-card {
    border: 1px solid rgba(143, 23, 29, .13);
    border-radius: 1.2rem;
    background: rgba(255, 253, 249, .75);
    box-shadow: 0 10px 28px rgba(89, 37, 24, .06);
    overflow: hidden;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
}

.rs-video-feature-card:hover {
    transform: translateY(-5px);
    border-color: rgba(243, 106, 33, .45);
    box-shadow: 0 18px 36px rgba(89, 37, 24, .12);
}

.rs-video-card-thumb {
    position: relative;
    width: 100%;
    height: 155px;
    background: var(--color-sand);
    cursor: pointer;
    overflow: hidden;
}

.rs-video-card-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 360ms ease;
}

.rs-video-feature-card:hover .rs-video-card-thumb img {
    transform: scale(1.08);
}

.rs-video-card-body {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    padding: 1.05rem 1.15rem 1.25rem;
}

.rs-video-card-body h3 {
    margin: 0 0 .35rem;
    font-size: .96rem;
    font-weight: 700;
    color: #542019;
    line-height: 1.35;
}

.rs-video-card-body p {
    margin: 0 0 .85rem;
    font-size: .78rem;
    color: #79695f;
    line-height: 1.45;
}

.rs-video-watch-btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    margin-top: auto;
    font-size: .8rem;
    font-weight: 700;
    color: var(--color-maroon);
    cursor: pointer;
    background: transparent;
    border: none;
    padding: 0;
    transition: color 160ms ease, transform 160ms ease;
}

.rs-video-watch-btn:hover {
    color: var(--color-saffron);
    transform: translateX(3px);
}

/* ============================================================
   Stay Connected Newsletter Banner
   ============================================================ */
.rs-gallery-subscribe-banner {
    margin-top: 2rem;
    padding: 2.25rem 2.5rem;
    border: 1px solid rgba(143, 23, 29, .15);
    border-radius: 1.35rem;
    background: linear-gradient(135deg, rgba(255, 240, 218, .92), rgba(255, 250, 242, .92));
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 #fff;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.rs-sub-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.rs-sub-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(243, 106, 33, .12);
    border: 1px solid rgba(243, 106, 33, .25);
    color: var(--color-saffron);
    flex-shrink: 0;
}

.rs-sub-icon svg {
    width: 28px;
    height: 28px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2.2;
}

.rs-sub-text strong {
    display: block;
    font-size: 1.25rem;
    font-weight: 800;
    color: #542019;
    margin-bottom: .25rem;
}

.rs-sub-text p {
    margin: 0;
    font-size: .9rem;
    color: #67574c;
    line-height: 1.45;
}

.rs-sub-form {
    display: flex;
    align-items: center;
    gap: .65rem;
    flex-shrink: 0;
    min-width: 340px;
}

.rs-sub-form input {
    flex: 1;
    height: 2.75rem;
    padding: 0 1.15rem;
    border: 1px solid rgba(143, 23, 29, .22);
    border-radius: 999px;
    background: #fff;
    font-size: .85rem;
    outline: none;
}

.rs-sub-form input:focus {
    border-color: var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .14);
}

.rs-sub-form button {
    height: 2.75rem;
    padding: 0 1.4rem;
    border-radius: 999px;
    border: 0;
    background: var(--color-maroon);
    color: #fff;
    font-size: .84rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(143, 23, 29, .25);
    transition: all 180ms ease;
    white-space: nowrap;
}

.rs-sub-form button:hover {
    background: #6e1015;
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(143, 23, 29, .35);
}

/* ============================================================
   Full-Screen Lightbox Modal for Photos & Videos
   ============================================================ */
.rs-gallery-lightbox {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
}

.rs-gallery-lightbox.is-open {
    display: flex;
}

.rs-lightbox-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(22, 10, 8, .88);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.rs-lightbox-panel {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    max-width: 960px;
    width: 100%;
    max-height: 92vh;
    border-radius: 1.25rem;
    background: rgba(255, 253, 249, .98);
    box-shadow: 0 25px 60px rgba(0, 0, 0, .45);
    overflow: hidden;
    animation: rsg-modal-in 240ms cubic-bezier(.2,.8,.2,1);
}

@keyframes rsg-modal-in {
    from { opacity: 0; transform: scale(.95); }
    to   { opacity: 1; transform: scale(1); }
}

.rs-lightbox-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .85rem 1.4rem;
    border-bottom: 1px solid rgba(143, 23, 29, .12);
    background: rgba(255, 255, 255, .8);
}

.rs-lightbox-header h4 {
    margin: 0;
    font-size: 1rem;
    font-weight: 700;
    color: #542019;
}

.rs-lightbox-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 0;
    background: rgba(143, 23, 29, .1);
    color: var(--color-maroon);
    font-size: 1.3rem;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 160ms ease;
}

.rs-lightbox-close-btn:hover {
    background: var(--color-maroon);
    color: #fff;
}

.rs-lightbox-stage {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0f0806;
    min-height: 380px;
    max-height: 65vh;
    overflow: hidden;
}

.rs-lightbox-media-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rs-lightbox-media-container img {
    max-width: 100%;
    max-height: 65vh;
    object-fit: contain;
}

.rs-lightbox-media-container iframe {
    width: 100%;
    height: 520px;
    max-height: 65vh;
    border: 0;
}

.rs-lightbox-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 46px;
    height: 46px;
    border-radius: 50%;
    border: 0;
    background: rgba(255, 255, 255, .85);
    color: var(--color-maroon);
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .3);
    transition: all 180ms ease;
    z-index: 5;
}

.rs-lightbox-nav-btn:hover {
    background: var(--color-maroon);
    color: #fff;
    transform: translateY(-50%) scale(1.1);
}

.rs-lightbox-nav-prev {
    left: 1rem;
}

.rs-lightbox-nav-next {
    right: 1rem;
}

.rs-lightbox-footer {
    padding: .95rem 1.4rem;
    background: #fff;
    border-top: 1px solid rgba(143, 23, 29, .1);
}

.rs-lightbox-caption {
    margin: 0;
    font-size: .88rem;
    color: #67574c;
    line-height: 1.5;
}

/* ============================================================
   Responsive Layout Media Queries
   ============================================================ */
@media (max-width: 1120px) {
    .rs-event-albums-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .rs-hub-media-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .rs-featured-videos-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .rs-event-albums-grid {
        grid-template-columns: 1fr;
    }
    .rs-hub-media-grid {
        grid-template-columns: 1fr;
    }
    .rs-featured-videos-grid {
        grid-template-columns: 1fr;
    }
    .rs-gallery-subscribe-banner {
        flex-direction: column;
        text-align: center;
        padding: 1.75rem;
    }
    .rs-sub-content {
        flex-direction: column;
    }
    .rs-sub-form {
        width: 100%;
        min-width: 0;
        flex-direction: column;
    }
    .rs-sub-form button {
        width: 100%;
    }
    .rs-event-media-hub {
        padding: 1.35rem;
    }
}
</style>

<main class="rs-gallery-page" id="main-content">
    <!-- Page Header Block (Hero Removed) -->
    <header class="rs-gallery-header-section">
        <div class="rs-container">
            <div class="rs-gallery-title-block">
                <div class="rs-gallery-eyebrow">
                    <span class="rs-gallery-eyebrow-dot" aria-hidden="true"></span>
                    <span>Moments &amp; Archives</span>
                </div>
                <h1 class="rs-gallery-page-title">Visual Stories &amp; <em>Memories</em></h1>
                <p class="rs-gallery-page-subtitle">
                    Explore inspiring moments from our community gatherings, therapeutic intensives, children’s summer camps, and cultural celebrations across our 23+ Bengaluru centers.
                </p>
            </div>

            <!-- Clean Stat Pills (No Icons, Matching Events Page Design) -->
            <div class="rs-gallery-stats-bar">
                <div class="rs-gallery-stat-pill">
                    <strong>23+</strong>
                    <span>Bengaluru Centers</span>
                </div>
                <div class="rs-gallery-stat-pill">
                    <strong>35+</strong>
                    <span>Yoga Programs</span>
                </div>
                <div class="rs-gallery-stat-pill">
                    <strong>1,200+</strong>
                    <span>Visual Archives</span>
                </div>
                <div class="rs-gallery-stat-pill">
                    <strong>10,000+</strong>
                    <span>Active Participants</span>
                </div>
            </div>

            <!-- Category Filter Tabs Bar -->
            <nav class="rs-gallery-filter-bar" aria-label="Filter gallery by event category">
                <button type="button" class="rs-gallery-tab-btn is-active" data-filter="all">All Events</button>
                <button type="button" class="rs-gallery-tab-btn" data-filter="yoga-day">Yoga Day</button>
                <button type="button" class="rs-gallery-tab-btn" data-filter="children">Children Camp</button>
                <button type="button" class="rs-gallery-tab-btn" data-filter="therapy">Therapy &amp; Health</button>
                <button type="button" class="rs-gallery-tab-btn" data-filter="youth">Youth Fest</button>
                <button type="button" class="rs-gallery-tab-btn" data-filter="community">Community Seva</button>
                <button type="button" class="rs-gallery-tab-btn" data-filter="culture">Retreat &amp; Culture</button>
            </nav>
        </div>
    </header>

    <!-- Interactive Event Media Hub (Revealed when an Event Album is clicked) -->
    <section class="rs-container">
        <div class="rs-event-media-hub" id="rs-event-media-hub" role="region" aria-label="Event Media Viewer">
            <!-- Hub Top Action Bar -->
            <div class="rs-hub-top-bar">
                <button type="button" class="rs-hub-back-btn" id="rs-hub-back-btn">
                    <span aria-hidden="true">&larr;</span>
                    <span>Back to All Event Albums</span>
                </button>

                <div class="rs-hub-event-switcher">
                    <label for="rs-hub-select-dropdown">Switch Event:</label>
                    <select id="rs-hub-select-dropdown" class="rs-hub-select">
                        <?php foreach ( $gallery_events as $ev ) : ?>
                            <option value="<?php echo esc_attr( $ev['id'] ); ?>"><?php echo esc_html( $ev['title'] ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Hub Header Details -->
            <div class="rs-hub-header-info">
                <h2 class="rs-hub-title" id="rs-hub-active-title">Event Title</h2>
                <div class="rs-hub-meta-pills">
                    <span class="rs-hub-meta-pill" id="rs-hub-active-date">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Date</span>
                    </span>
                    <span class="rs-hub-meta-pill" id="rs-hub-active-venue">
                        <svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>Venue</span>
                    </span>
                    <span class="rs-hub-meta-pill" id="rs-hub-active-count">
                        <span>0 Photos • 0 Videos</span>
                    </span>
                </div>
                <p class="rs-hub-desc" id="rs-hub-active-desc">Event description</p>
            </div>

            <!-- Hub Media Type Filter Tabs -->
            <div class="rs-hub-type-tabs">
                <button type="button" class="rs-hub-tab-btn is-active" data-hub-type="all">All Media (<span id="hub-count-all">0</span>)</button>
                <button type="button" class="rs-hub-tab-btn" data-hub-type="photo">Photos (<span id="hub-count-photos">0</span>)</button>
                <button type="button" class="rs-hub-tab-btn" data-hub-type="video">Videos (<span id="hub-count-videos">0</span>)</button>
            </div>

            <!-- Dynamic Media Grid for Selected Event -->
            <div class="rs-hub-media-grid" id="rs-hub-media-grid">
                <!-- Dynamically populated via JS when event card is clicked -->
            </div>
        </div>
    </section>

    <!-- Main Event Albums Showcase Section -->
    <section class="rs-gallery-section" id="event-albums-section">
        <div class="rs-container">
            <div class="rs-gallery-section-header">
                <div>
                    <h2>Event-Wise <em>Photo &amp; Video Albums</em></h2>
                    <p class="rs-gallery-section-desc">
                        Click on any event album below to view all the high-resolution photographs, ceremony reels, and video highlights recorded for that program.
                    </p>
                </div>
            </div>

            <div class="rs-event-albums-grid" id="rs-event-albums-grid">
                <?php foreach ( $gallery_events as $event ) : ?>
                    <?php
                    $photo_count = count( $event['photos'] );
                    $video_count = count( $event['videos'] );
                    ?>
                    <article class="rs-event-album-card" 
                             data-event-id="<?php echo esc_attr( $event['id'] ); ?>"
                             data-category="<?php echo esc_attr( $event['category_slug'] ); ?>"
                             tabindex="0"
                             role="button"
                             aria-label="View album: <?php echo esc_attr( $event['title'] ); ?>">
                        
                        <div class="rs-album-media">
                            <img src="<?php echo esc_url( $event['cover_image'] ); ?>" alt="<?php echo esc_attr( $event['title'] ); ?>" loading="lazy">
                            <span class="rs-album-category-badge"><?php echo esc_html( $event['category'] ); ?></span>
                            <span class="rs-album-count-badge">
                                <svg viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                <span><?php echo esc_html( $photo_count ); ?> Photos • <?php echo esc_html( $video_count ); ?> Videos</span>
                            </span>
                        </div>

                        <div class="rs-album-body">
                            <div class="rs-album-meta-row">
                                <span>
                                    <svg viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                    <?php echo esc_html( $event['date'] ); ?>
                                </span>
                            </div>

                            <h3 class="rs-album-title"><?php echo esc_html( $event['title'] ); ?></h3>
                            <p class="rs-album-desc"><?php echo esc_html( $event['desc'] ); ?></p>

                            <div class="rs-album-footer">
                                <span class="rs-view-album-btn">
                                    <span>Explore Album</span> &rarr;
                                </span>
                                <span class="rs-view-hint">Click to open &rarr;</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Curated Featured Videos Showcase Section -->
    <section class="rs-gallery-section" id="featured-videos">
        <div class="rs-container">
            <div class="rs-gallery-section-header">
                <div>
                    <h2>Featured <em>Video Highlights</em></h2>
                    <p class="rs-gallery-section-desc">
                        Watch demonstrations, youth yoga challenges, and therapeutic masterclasses from our centers across Bengaluru.
                    </p>
                </div>
            </div>

            <div class="rs-featured-videos-grid">
                <?php foreach ( $all_videos as $vid ) : ?>
                    <article class="rs-video-feature-card">
                        <div class="rs-video-card-thumb rs-trigger-video" 
                             data-title="<?php echo esc_attr( $vid['title'] ); ?>" 
                             data-src="<?php echo esc_url( $vid['embed_url'] ); ?>"
                             data-caption="<?php echo esc_attr( $vid['subtitle'] . ' — ' . $vid['event_title'] ); ?>"
                             tabindex="0"
                             role="button"
                             aria-label="Play video: <?php echo esc_attr( $vid['title'] ); ?>">
                            <img src="<?php echo esc_url( $vid['thumb'] ); ?>" alt="<?php echo esc_attr( $vid['title'] ); ?>" loading="lazy">
                            <span class="rs-hub-duration-badge"><?php echo esc_html( $vid['duration'] ); ?></span>
                            <div class="rs-hub-play-overlay">
                                <div class="rs-hub-play-btn" aria-hidden="true">
                                    <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="rs-video-card-body">
                            <h3><?php echo esc_html( $vid['title'] ); ?></h3>
                            <p><?php echo esc_html( $vid['subtitle'] ); ?></p>
                            <button type="button" class="rs-video-watch-btn rs-trigger-video"
                                    data-title="<?php echo esc_attr( $vid['title'] ); ?>" 
                                    data-src="<?php echo esc_url( $vid['embed_url'] ); ?>"
                                    data-caption="<?php echo esc_attr( $vid['subtitle'] . ' — ' . $vid['event_title'] ); ?>">
                                <span>Watch Video</span> &rarr;
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Stay Connected Newsletter Banner -->
            <div class="rs-gallery-subscribe-banner">
                <div class="rs-sub-content">
                    <div class="rs-sub-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <div class="rs-sub-text">
                        <strong>Stay Connected. Stay Inspired.</strong>
                        <p>Subscribe to our periodic newsletter to receive notifications on upcoming festival camps, photo albums, and masterclasses.</p>
                    </div>
                </div>
                <form class="rs-sub-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Rashtrotthana Yoga visual updates!'); this.reset();">
                    <input type="email" placeholder="Enter your email address" required autocomplete="email">
                    <button type="submit">Subscribe &rarr;</button>
                </form>
            </div>
        </div>
    </section>
</main>

<!-- Full-Screen Interactive Lightbox Modal -->
<div class="rs-gallery-lightbox" id="rs-gallery-lightbox" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Media Preview Lightbox">
    <div class="rs-lightbox-backdrop" id="rs-lightbox-backdrop"></div>
    <div class="rs-lightbox-panel">
        <div class="rs-lightbox-header">
            <h4 id="rs-lightbox-title">Media Title</h4>
            <button type="button" class="rs-lightbox-close-btn" id="rs-lightbox-close-btn" aria-label="Close media preview">&times;</button>
        </div>

        <div class="rs-lightbox-stage">
            <button type="button" class="rs-lightbox-nav-btn rs-lightbox-nav-prev" id="rs-lightbox-prev-btn" aria-label="Previous media item">&#8249;</button>
            
            <div class="rs-lightbox-media-container" id="rs-lightbox-media-container">
                <!-- Image or Iframe injected dynamically -->
            </div>

            <button type="button" class="rs-lightbox-nav-btn rs-lightbox-nav-next" id="rs-lightbox-nav-next-btn" aria-label="Next media item">&#8250;</button>
        </div>

        <div class="rs-lightbox-footer">
            <p class="rs-lightbox-caption" id="rs-lightbox-caption">Caption</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dataset of all events with photos and videos passed from PHP
    var galleryEvents = <?php echo json_encode( $gallery_events ); ?>;

    var hubSection = document.getElementById('rs-event-media-hub');
    var hubBackBtn = document.getElementById('rs-hub-back-btn');
    var hubSelectDropdown = document.getElementById('rs-hub-select-dropdown');
    var hubTitle = document.getElementById('rs-hub-active-title');
    var hubDate = document.getElementById('rs-hub-active-date');
    var hubVenue = document.getElementById('rs-hub-active-venue');
    var hubCount = document.getElementById('rs-hub-active-count');
    var hubDesc = document.getElementById('rs-hub-active-desc');
    var hubGrid = document.getElementById('rs-hub-media-grid');
    var countAllSpan = document.getElementById('hub-count-all');
    var countPhotosSpan = document.getElementById('hub-count-photos');
    var countVideosSpan = document.getElementById('hub-count-videos');

    var currentEvent = null;
    var currentFilterType = 'all';

    // Lightbox references
    var lightbox = document.getElementById('rs-gallery-lightbox');
    var lightboxBackdrop = document.getElementById('rs-lightbox-backdrop');
    var lightboxCloseBtn = document.getElementById('rs-lightbox-close-btn');
    var lightboxMedia = document.getElementById('rs-lightbox-media-container');
    var lightboxTitle = document.getElementById('rs-lightbox-title');
    var lightboxCaption = document.getElementById('rs-lightbox-caption');
    var lightboxPrev = document.getElementById('rs-lightbox-prev-btn');
    var lightboxNext = document.getElementById('rs-lightbox-nav-next-btn');

    var currentMediaQueue = [];
    var currentMediaIndex = 0;

    // ============================================================
    // 1. OPEN EVENT MEDIA HUB (WHEN AN EVENT IS CLICKED)
    // ============================================================
    function openEventHub(eventId) {
        var foundEvent = galleryEvents.find(function (ev) {
            return ev.id === eventId;
        });

        if (!foundEvent) return;
        currentEvent = foundEvent;

        // Set Hub Information
        hubTitle.textContent = currentEvent.title;
        hubDate.innerHTML = '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> <span>' + currentEvent.date + '</span>';
        hubVenue.innerHTML = '<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> <span>' + currentEvent.venue + '</span>';
        hubCount.innerHTML = '<span>' + currentEvent.photos.length + ' Photos • ' + currentEvent.videos.length + ' Videos</span>';
        hubDesc.textContent = currentEvent.desc;

        if (hubSelectDropdown) {
            hubSelectDropdown.value = currentEvent.id;
        }

        countAllSpan.textContent = currentEvent.photos.length + currentEvent.videos.length;
        countPhotosSpan.textContent = currentEvent.photos.length;
        countVideosSpan.textContent = currentEvent.videos.length;

        // Reset Hub media type tabs to 'all'
        currentFilterType = 'all';
        document.querySelectorAll('.rs-hub-tab-btn').forEach(function (btn) {
            btn.classList.toggle('is-active', btn.dataset.hubType === 'all');
        });

        renderHubMedia();

        hubSection.classList.add('is-active');
        hubSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function renderHubMedia() {
        if (!currentEvent) return;
        hubGrid.innerHTML = '';
        currentMediaQueue = [];

        // Build Photos
        if (currentFilterType === 'all' || currentFilterType === 'photo') {
            currentEvent.photos.forEach(function (photo) {
                currentMediaQueue.push({
                    type: 'photo',
                    title: photo.title,
                    caption: photo.caption || photo.title,
                    url: photo.url,
                    thumb: photo.url
                });
            });
        }

        // Build Videos
        if (currentFilterType === 'all' || currentFilterType === 'video') {
            currentEvent.videos.forEach(function (vid) {
                currentMediaQueue.push({
                    type: 'video',
                    title: vid.title,
                    caption: vid.subtitle,
                    url: vid.embed_url,
                    thumb: vid.thumb,
                    duration: vid.duration
                });
            });
        }

        // Render Cards in Grid
        currentMediaQueue.forEach(function (item, index) {
            var card = document.createElement('div');
            card.className = 'rs-hub-media-card';
            card.tabIndex = 0;
            card.setAttribute('role', 'button');
            card.setAttribute('aria-label', (item.type === 'video' ? 'Play video: ' : 'View photo: ') + item.title);

            var overlayContent = item.type === 'video'
                ? '<div class="rs-hub-play-overlay"><div class="rs-hub-play-btn"><svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg></div></div><span class="rs-hub-duration-badge">' + (item.duration || 'Video') + '</span>'
                : '<div class="rs-hub-play-overlay"><div class="rs-hub-zoom-btn"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" x2="16.65" y1="21" y2="16.65"/><line x1="11" x2="11" y1="8" y2="14"/><line x1="8" x2="14" y1="11" y2="11"/></svg></div></div>';

            card.innerHTML =
                '<div class="rs-hub-thumb-wrap">' +
                    '<img src="' + item.thumb + '" alt="' + item.title + '" loading="lazy">' +
                    '<span class="rs-hub-type-tag">' + (item.type === 'video' ? 'Video' : 'Photo') + '</span>' +
                    overlayContent +
                '</div>' +
                '<div class="rs-hub-card-body">' +
                    '<h4 class="rs-hub-card-title">' + item.title + '</h4>' +
                    '<p class="rs-hub-card-caption">' + item.caption + '</p>' +
                '</div>';

            card.addEventListener('click', function () {
                openLightbox(index);
            });

            card.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openLightbox(index);
                }
            });

            hubGrid.appendChild(card);
        });
    }

    // Attach click listeners on all Event Album Cards
    document.querySelectorAll('.rs-event-album-card').forEach(function (card) {
        var eventId = card.dataset.eventId;
        card.addEventListener('click', function () {
            openEventHub(eventId);
        });
        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openEventHub(eventId);
            }
        });
    });

    // Back to All Albums Button
    if (hubBackBtn) {
        hubBackBtn.addEventListener('click', function () {
            hubSection.classList.remove('is-active');
            var albumsGrid = document.getElementById('event-albums-section');
            if (albumsGrid) albumsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    // Switch Event Dropdown
    if (hubSelectDropdown) {
        hubSelectDropdown.addEventListener('change', function () {
            openEventHub(this.value);
        });
    }

    // Hub Type Filter Tabs (All / Photos / Videos)
    document.querySelectorAll('.rs-hub-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.rs-hub-tab-btn').forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            currentFilterType = btn.dataset.hubType;
            renderHubMedia();
        });
    });

    // Category Tabs Filter for the main Event Albums
    document.querySelectorAll('.rs-gallery-tab-btn').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.rs-gallery-tab-btn').forEach(function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');

            var filter = tab.dataset.filter;
            var albumCards = document.querySelectorAll('.rs-event-album-card');

            albumCards.forEach(function (c) {
                if (filter === 'all' || c.dataset.category === filter) {
                    c.style.display = 'flex';
                } else {
                    c.style.display = 'none';
                }
            });

            // Automatically open matching event if filtered to a single category
            if (filter !== 'all') {
                var firstMatch = galleryEvents.find(function (ev) {
                    return ev.category_slug === filter;
                });
                if (firstMatch) {
                    openEventHub(firstMatch.id);
                }
            }
        });
    });

    // ============================================================
    // 2. LIGHTBOX VIEWER FOR PHOTOS & VIDEOS
    // ============================================================
    function openLightbox(index) {
        if (!currentMediaQueue || currentMediaQueue.length === 0) return;
        currentMediaIndex = (index + currentMediaQueue.length) % currentMediaQueue.length;
        renderLightboxItem();
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function renderLightboxItem() {
        var item = currentMediaQueue[currentMediaIndex];
        if (!item) return;

        lightboxTitle.textContent = item.title;
        lightboxCaption.textContent = item.caption;

        if (item.type === 'video') {
            lightboxMedia.innerHTML = '<iframe src="' + item.url + '?autoplay=1" title="' + item.title + '" allow="autoplay; fullscreen" allowfullscreen></iframe>';
        } else {
            lightboxMedia.innerHTML = '<img src="' + item.url + '" alt="' + item.title + '">';
        }

        // Hide navigation if only 1 item
        var hasMultiple = currentMediaQueue.length > 1;
        lightboxPrev.style.display = hasMultiple ? 'flex' : 'none';
        lightboxNext.style.display = hasMultiple ? 'flex' : 'none';
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxMedia.innerHTML = '';
        document.body.style.overflow = '';
    }

    if (lightboxCloseBtn) lightboxCloseBtn.addEventListener('click', closeLightbox);
    if (lightboxBackdrop) lightboxBackdrop.addEventListener('click', closeLightbox);

    if (lightboxNext) {
        lightboxNext.addEventListener('click', function () {
            openLightbox(currentMediaIndex + 1);
        });
    }

    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function () {
            openLightbox(currentMediaIndex - 1);
        });
    }

    // Keyboard controls (Escape, ArrowLeft, ArrowRight)
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('is-open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') openLightbox(currentMediaIndex + 1);
        if (e.key === 'ArrowLeft') openLightbox(currentMediaIndex - 1);
    });

    // ============================================================
    // 3. FEATURED VIDEO DIRECT TRIGGERS
    // ============================================================
    document.querySelectorAll('.rs-trigger-video').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            var title = trigger.dataset.title;
            var src = trigger.dataset.src;
            var caption = trigger.dataset.caption;

            currentMediaQueue = [{
                type: 'video',
                title: title,
                caption: caption,
                url: src
            }];
            openLightbox(0);
        });

        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                trigger.click();
            }
        });
    });
});
</script>

<?php get_footer(); ?>
