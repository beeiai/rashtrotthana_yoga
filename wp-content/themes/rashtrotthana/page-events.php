<?php
/**
 * Template Name: Events Page
 * Template for displaying Events & News with matching Home/Activities/Centers design system.
 */
get_header();
$all_event_centers = function_exists( 'rs_get_centers' ) ? rs_get_centers() : [];
?>

<!-- ============================================================
     Events & News Page Styles (Synchronized with Home, Activities, and Centers)
     ============================================================ -->
<style>
/* Page Root & Atmospheric Background */
.rs-events-page {
    position: relative;
    isolation: isolate;
    color: var(--color-text);
    font-family: 'Poppins', sans-serif;
    background: 
        linear-gradient(rgba(255, 255, 255, 0.82), rgba(255, 255, 255, 0.82)),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/mandala-bg.jpg' ); ?>") center top / cover fixed no-repeat !important;
    animation: rs-nature-drift 24s ease-in-out infinite alternate;
    min-height: 100vh;
    padding-bottom: 4.5rem;
}

.rs-events-page::before,
.rs-events-page::after {
    position: absolute;
    z-index: -1;
    display: block;
    width: 28rem;
    height: 28rem;
    border-radius: 50%;
    content: "";
    filter: blur(14px);
    opacity: .75;
    pointer-events: none;
}

.rs-events-page::before {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 0;
    background:
        radial-gradient(circle at 8% 10%, rgba(249, 183, 42, .18), transparent 26rem),
        radial-gradient(circle at 92% 16%, rgba(243, 106, 33, .14), transparent 30rem);
    filter: none;
    opacity: 1;
}

.rs-events-page::after {
    top: 55rem;
    right: -15rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .24), transparent 68%);
    animation: rse-atmosphere-pulse 5s ease-in-out infinite alternate;
}

@keyframes rs-nature-drift {
    0%   { background-position: center top, 48% top; }
    100% { background-position: center top, 52% top; }
}

@keyframes rse-atmosphere-pulse {
    0%   { opacity: .28; transform: scale(.96); }
    100% { opacity: .6;  transform: scale(1.08); }
}

/* Side Margins: Matching Home Page Exactly */
.rs-events-page .rs-container {
    width: 100% !important;
    max-width: none !important;
    padding-inline: clamp(20px, 4vw, 64px) !important;
    margin-inline: auto !important;
    box-sizing: border-box;
}

/* ============================================================
   Page Header Section (Replacing the old bulky Hero)
   ============================================================ */
.rs-events-header-section {
    padding: 3.5rem 0 2rem;
    text-align: center;
}

.rs-events-title-block {
    max-width: 820px;
    margin: 0 auto;
}

.rs-events-eyebrow {
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

.rs-events-eyebrow-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--color-saffron);
    box-shadow: 0 0 10px rgba(243, 106, 33, .8);
    animation: rs-dot-blink 1.8s ease-in-out infinite;
}

@keyframes rs-dot-blink {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.35); opacity: .6; }
}

.rs-events-page-title {
    margin: 0 0 1rem;
    color: #542019;
    font-size: clamp(2.3rem, 4vw, 3.4rem);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -.02em;
}

.rs-events-page-title em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-events-page-subtitle {
    margin: 0 auto 1.75rem;
    max-width: 680px;
    color: #67574c;
    font-size: clamp(1rem, 1.25vw, 1.12rem);
    line-height: 1.65;
}

/* Number Cards (Icons removed per user request) */
.rs-events-stats-bar {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.15rem;
    margin-bottom: 2.25rem;
}

.rs-events-stat-pill {
    display: inline-flex;
    align-items: center;
    gap: .65rem;
    padding: .65rem 1.45rem;
    border: 1px solid rgba(255, 255, 255, .85);
    border-radius: 999px;
    background: rgba(255, 255, 255, .72);
    box-shadow: 0 6px 20px rgba(89, 37, 24, .06);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    color: #542019;
}

.rs-events-stat-pill strong {
    color: var(--color-maroon);
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1;
}

.rs-events-stat-pill span {
    color: #67574c;
    font-size: .88rem;
    font-weight: 600;
}

/* ============================================================
   Control Bar: Search & Interactive Filters
   ============================================================ */
.rs-events-control-card {
    position: relative;
    z-index: 5;
    padding: 1.35rem 1.5rem;
    border: 1px solid rgba(143, 23, 29, .15);
    border-radius: 1.15rem;
    background: rgba(255, 253, 249, .82);
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    margin-bottom: 2rem;
}

.rs-events-filter-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1.25rem;
}

/* Nav Segment Pills */
.rs-events-nav-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: .45rem;
    padding: .35rem;
    border-radius: 999px;
    background: rgba(255, 245, 223, .7);
    border: 1px solid rgba(143, 23, 29, .12);
}

.rs-events-tab-btn {
    padding: .5rem 1.15rem;
    border: 0;
    border-radius: 999px;
    background: transparent;
    color: #67574c;
    font-family: 'Poppins', sans-serif;
    font-size: .84rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 200ms ease;
    white-space: nowrap;
}

.rs-events-tab-btn:hover {
    color: var(--color-maroon);
    background: rgba(255, 255, 255, .7);
}

.rs-events-tab-btn.is-active {
    background: var(--color-maroon);
    color: #fff;
    box-shadow: 0 4px 14px rgba(143, 23, 29, .28);
}

/* Search Box */
.rs-events-search-box {
    position: relative;
    flex: 1;
    min-width: 260px;
    max-width: 380px;
}

.rs-events-search-box svg {
    position: absolute;
    top: 50%;
    left: .85rem;
    transform: translateY(-50%);
    width: 1.1rem;
    height: 1.1rem;
    stroke: var(--color-maroon);
    stroke-width: 2.2;
    fill: none;
    pointer-events: none;
}

.rs-events-search-box input {
    width: 100%;
    height: 2.65rem;
    padding: .55rem 2.2rem .55rem 2.45rem;
    border: 1px solid rgba(143, 23, 29, .22);
    border-radius: 999px;
    background: rgba(255, 255, 255, .9);
    color: #542019;
    font-family: 'Poppins', sans-serif;
    font-size: .84rem;
    outline: none;
    transition: border-color 180ms ease, box-shadow 180ms ease;
}

.rs-events-search-box input:focus {
    border-color: var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .14);
}

.rs-events-search-box input::placeholder {
    color: #8b7465;
}

.rs-events-search-clear {
    position: absolute;
    top: 50%;
    right: .75rem;
    transform: translateY(-50%);
    width: 22px;
    height: 22px;
    border: 0;
    border-radius: 50%;
    background: rgba(143, 23, 29, .12);
    color: #542019;
    font-size: .75rem;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    line-height: 1;
}

.rs-events-search-clear.is-visible {
    display: flex;
}

/* Secondary Filter Row */
.rs-events-subfilters-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .85rem;
    margin-top: 1rem;
    padding-top: .85rem;
    border-top: 1px dashed rgba(143, 23, 29, .14);
}

.rs-events-filter-select {
    height: 2.35rem;
    padding: 0 2rem 0 .95rem;
    border: 1px solid rgba(143, 23, 29, .2);
    border-radius: .6rem;
    background: rgba(255, 255, 255, .9) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238F171D' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right .75rem center;
    color: #542019;
    font-family: 'Poppins', sans-serif;
    font-size: .82rem;
    font-weight: 500;
    outline: none;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
}

.rs-events-filter-select:focus {
    border-color: var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .12);
}

.rs-events-reset-btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    height: 2.35rem;
    padding: 0 .95rem;
    border: 1px solid rgba(143, 23, 29, .18);
    border-radius: .6rem;
    background: transparent;
    color: var(--color-maroon);
    font-family: 'Poppins', sans-serif;
    font-size: .8rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 160ms ease, color 160ms ease;
}

.rs-events-reset-btn:hover {
    background: rgba(143, 23, 29, .08);
}

.rs-events-status-indicator {
    margin-left: auto;
    font-size: .82rem;
    font-weight: 600;
    color: #795c4b;
}

/* ============================================================
   Section Headings (Matching Home & Activities Pages)
   ============================================================ */
.rs-events-section {
    padding: 2.5rem 0 3.25rem;
    position: relative;
}

.rs-events-section-header {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
}

.rs-events-section-header h2 {
    position: relative;
    margin: 0;
    color: #542019;
    font-size: clamp(1.85rem, 3vw, 2.5rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -.015em;
}

.rs-events-section-header h2::after {
    content: "";
    display: block;
    width: 48px;
    height: 4px;
    margin-top: .65rem;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--color-maroon), var(--color-saffron));
}

.rs-events-section-desc {
    max-width: 580px;
    margin: .4rem 0 0;
    color: #67574c;
    font-size: .92rem;
    line-height: 1.55;
}

.rs-events-header-controls {
    display: flex;
    align-items: center;
    gap: .75rem;
}

.rs-view-toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .5rem 1rem;
    border: 1px solid rgba(143, 23, 29, .25);
    border-radius: 999px;
    background: rgba(255, 255, 255, .7);
    color: var(--color-maroon);
    font-family: 'Poppins', sans-serif;
    font-size: .82rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 180ms ease;
}

.rs-view-toggle-btn:hover {
    background: var(--color-maroon);
    color: #fff;
    box-shadow: 0 6px 16px rgba(143, 23, 29, .22);
}

/* ============================================================
   Carousel Stage with Side Floating Left & Right Arrows
   ============================================================ */
.rs-carousel-stage {
    position: relative;
    width: 100%;
}

/* Side Arrows on Left & Right Ends of the Section */
.rs-carousel-side-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 1px solid rgba(143, 23, 29, .22);
    background: rgba(255, 255, 255, .96);
    box-shadow: 0 10px 28px rgba(89, 37, 24, .18), 0 0 0 1px rgba(255, 255, 255, .9);
    color: var(--color-maroon);
    cursor: pointer;
    transition: all 200ms cubic-bezier(.2,.8,.2,1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.rs-carousel-side-arrow svg {
    width: 24px;
    height: 24px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2.6;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.rs-carousel-side-arrow.rs-arrow-prev {
    left: -22px;
}

.rs-carousel-side-arrow.rs-arrow-next {
    right: -22px;
}

.rs-carousel-side-arrow:hover:not(:disabled) {
    background: var(--color-maroon);
    color: #fff;
    box-shadow: 0 14px 34px rgba(143, 23, 29, .38), 0 0 18px rgba(243, 106, 33, .3);
    transform: translateY(-50%) scale(1.1);
}

.rs-carousel-side-arrow:disabled {
    opacity: 0;
    pointer-events: none;
    transform: translateY(-50%) scale(.9);
}

/* Hide side arrows when in Grid view */
.rs-carousel-stage.is-grid .rs-carousel-side-arrow {
    display: none !important;
}

.rs-carousel-track {
    display: flex;
    gap: 1.5rem;
    overflow-x: auto;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding: .6rem .25rem 1.5rem;
    align-items: stretch;
}

.rs-carousel-track::-webkit-scrollbar {
    display: none;
}

.rs-carousel-track > * {
    flex: 0 0 calc(33.333% - 1rem);
    min-width: 320px;
    max-width: 410px;
    scroll-snap-align: start;
    display: flex;
    flex-direction: column;
}

/* Expanded Grid view */
.rs-carousel-stage.is-grid .rs-carousel-track {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    overflow-x: visible;
    scroll-snap-type: none;
}

.rs-carousel-stage.is-grid .rs-carousel-track > * {
    flex: none;
    max-width: none;
    min-width: 0;
}

/* Centered Pagination Indicator Bar (Underneath) */
.rs-carousel-sub-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-top: 1rem;
}

.rs-carousel-dots {
    display: flex;
    align-items: center;
    gap: .45rem;
}

.rs-carousel-dot {
    width: 9px;
    height: 9px;
    border: 0;
    border-radius: 50%;
    background: rgba(143, 23, 29, .22);
    padding: 0;
    cursor: pointer;
    transition: all 220ms ease;
}

.rs-carousel-dot.is-active {
    width: 24px;
    border-radius: 999px;
    background: var(--color-maroon);
    box-shadow: 0 0 10px rgba(143, 23, 29, .4);
}

.rs-carousel-page-status {
    color: #795c4b;
    font-size: .82rem;
    font-weight: 600;
}

/* ============================================================
   Equal Sized Event Card Design (Matching Home & Activities System)
   ============================================================ */
.rs-event-item-card {
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 485px;
    box-sizing: border-box;
    border: 1px solid rgba(143, 23, 29, .13) !important;
    border-radius: 1.25rem;
    background: rgba(255, 253, 249, .75);
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    overflow: hidden;
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), box-shadow 260ms ease, border-color 260ms ease;
    cursor: pointer;
}

.rs-event-item-card::after {
    position: absolute;
    top: 0;
    right: 1.2rem;
    width: 4rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
}

.rs-event-item-card:hover {
    transform: translateY(-7px);
    border-color: rgba(243, 106, 33, .48) !important;
    box-shadow: 0 24px 44px rgba(89, 37, 24, .16), 0 0 20px rgba(249, 183, 42, .14), inset 0 1px 0 #fff;
}

.rs-event-item-card[hidden] {
    display: none !important;
}

/* Card Media & Floating Date Badge (Fixed Height) */
.rs-event-media {
    position: relative;
    width: 100%;
    height: 200px;
    min-height: 200px;
    max-height: 200px;
    flex-shrink: 0;
    overflow: hidden;
    background: var(--color-sand);
}

.rs-event-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 450ms cubic-bezier(.2,.8,.2,1), filter 450ms ease;
    filter: saturate(1.06) contrast(1.02);
}

.rs-event-item-card:hover .rs-event-media img {
    transform: scale(1.08);
    filter: saturate(1.15) contrast(1.06);
}

.rs-event-date-badge {
    position: absolute;
    top: .9rem;
    left: .9rem;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 58px;
    padding: .4rem .55rem;
    border-radius: .85rem;
    border: 1px solid rgba(255, 255, 255, .9);
    background: rgba(255, 255, 255, .88);
    box-shadow: 0 6px 18px rgba(85, 0, 0, .22);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    text-align: center;
}

.rs-event-date-badge strong {
    display: block;
    color: var(--color-maroon);
    font-size: 1.35rem;
    font-weight: 800;
    line-height: 1;
}

.rs-event-date-badge span {
    display: block;
    color: var(--color-saffron);
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    margin-top: 2px;
}

.rs-event-category-pill {
    position: absolute;
    top: .9rem;
    right: .9rem;
    z-index: 2;
    padding: .35rem .75rem;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, .8);
    background: rgba(84, 32, 25, .78);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #fff;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .02em;
}

/* Card Body with Fixed Line Heights for Perfect Equal Sizing */
.rs-event-body {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    padding: 1.35rem 1.4rem 1.35rem;
}

.rs-event-meta-list {
    display: flex;
    flex-direction: column;
    gap: .35rem;
    height: 48px;
    min-height: 48px;
    margin-bottom: .75rem;
    justify-content: center;
}

.rs-event-meta-item {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    color: #756a61;
    font-size: .84rem;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rs-event-meta-item svg {
    flex-shrink: 0;
    width: 15px;
    height: 15px;
    stroke: var(--color-maroon);
    stroke-width: 2;
    fill: none;
}

.rs-event-title {
    margin: 0 0 .65rem;
    color: #542019;
    font-size: 1.18rem;
    font-weight: 700;
    line-height: 1.32;
    height: 3.15rem;
    min-height: 3.15rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 180ms ease;
}

.rs-event-item-card:hover .rs-event-title {
    color: var(--color-maroon);
}

.rs-event-desc {
    margin: 0 0 1rem;
    color: #67574c;
    font-size: .88rem;
    line-height: 1.55;
    height: 4.1rem;
    min-height: 4.1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Card Footer: View Details (Left, Plain) and Register Now (Right, Red) / Closed */
.rs-event-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    margin-top: auto;
    padding-top: .9rem;
    border-top: 1px solid rgba(143, 23, 29, .1);
    min-height: 52px;
}

/* View Details Button (Left, Plain / Non-Red) */
.rs-card-view-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: .35rem !important;
    height: 2.45rem !important;
    padding: 0 1.05rem !important;
    border: 1.5px solid rgba(143, 23, 29, .26) !important;
    border-radius: 999px !important;
    background: #FFFDF9 !important;
    color: var(--color-maroon, #8F171D) !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: .81rem !important;
    font-weight: 600 !important;
    line-height: 1 !important;
    cursor: pointer !important;
    white-space: nowrap !important;
    box-sizing: border-box !important;
    text-decoration: none !important;
    transition: all 180ms ease !important;
}

.rs-card-view-btn:hover {
    background: #FFF5EA !important;
    border-color: var(--color-maroon, #8F171D) !important;
    color: var(--color-maroon, #8F171D) !important;
    transform: translateY(-1px) !important;
}

/* Register Now Button (Right, Vibrant Red) */
.rs-card-register-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: .35rem !important;
    height: 2.45rem !important;
    padding: 0 1.15rem !important;
    border: 1px solid #B31B1B !important;
    border-radius: 999px !important;
    background: #B31B1B !important;
    box-shadow: 0 6px 16px rgba(179, 27, 27, .28), inset 0 1px 0 rgba(255, 255, 255, .35) !important;
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: .81rem !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    cursor: pointer !important;
    white-space: nowrap !important;
    box-sizing: border-box !important;
    text-decoration: none !important;
    transition: all 180ms ease !important;
}

.rs-card-register-btn:hover {
    background: #8F171D !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 10px 22px rgba(179, 27, 27, .38) !important;
    color: #ffffff !important;
}

/* Closed State (Right, Subtle Muted Pill) */
.rs-card-closed-pill {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    height: 2.45rem !important;
    padding: 0 1.1rem !important;
    border: 1px solid rgba(117, 106, 97, .24) !important;
    border-radius: 999px !important;
    background: rgba(117, 106, 97, .09) !important;
    color: #756a61 !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: .81rem !important;
    font-weight: 600 !important;
    line-height: 1 !important;
    cursor: not-allowed !important;
    white-space: nowrap !important;
    box-sizing: border-box !important;
}

.rs-event-mode-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: .35rem .65rem;
    border-radius: .45rem;
    background: #fff0d8;
    color: #a34812;
    font-size: .74rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 130px;
    flex-shrink: 1;
}

/* Register / Read More Button for News Articles */
.rs-register-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: .4rem !important;
    width: 140px !important;
    min-width: 140px !important;
    height: 2.55rem !important;
    padding: 0 1rem !important;
    border: 1.5px solid rgba(143, 23, 29, .26) !important;
    border-radius: 999px !important;
    background: #FFFDF9 !important;
    color: var(--color-maroon, #8F171D) !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: .84rem !important;
    font-weight: 600 !important;
    line-height: 1 !important;
    cursor: pointer !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
    box-sizing: border-box !important;
    transition: all 180ms ease !important;
}

.rs-register-btn:hover {
    background: #FFF5EA !important;
    border-color: var(--color-maroon, #8F171D) !important;
    color: var(--color-maroon, #8F171D) !important;
    transform: translateY(-1px) !important;
}

/* Badge for Completed Events / Articles */
.rs-event-concluded-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 130px;
    min-width: 130px;
    height: 2.45rem;
    padding: 0 .9rem;
    border: 1px solid rgba(117, 106, 97, .24);
    border-radius: 999px;
    background: rgba(117, 106, 97, .09);
    color: #756a61;
    font-family: 'Poppins', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ============================================================
   Equal Sized News & Articles Card Design
   ============================================================ */
.rs-news-item-card {
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 485px;
    box-sizing: border-box;
    border: 1px solid rgba(143, 23, 29, .13) !important;
    border-radius: 1.25rem;
    background: rgba(255, 253, 249, .75);
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    overflow: hidden;
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), box-shadow 260ms ease, border-color 260ms ease;
    cursor: pointer;
}

.rs-news-item-card::after {
    position: absolute;
    top: 0;
    right: 1.2rem;
    width: 4rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
}

.rs-news-item-card:hover {
    transform: translateY(-7px);
    border-color: rgba(243, 106, 33, .48) !important;
    box-shadow: 0 24px 44px rgba(89, 37, 24, .16), 0 0 20px rgba(249, 183, 42, .14), inset 0 1px 0 #fff;
}

.rs-news-item-card[hidden] {
    display: none !important;
}

.rs-news-media {
    position: relative;
    width: 100%;
    height: 200px;
    min-height: 200px;
    max-height: 200px;
    flex-shrink: 0;
    overflow: hidden;
    background: var(--color-sand);
}

.rs-news-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 450ms cubic-bezier(.2,.8,.2,1), filter 450ms ease;
    filter: saturate(1.06) contrast(1.02);
}

.rs-news-item-card:hover .rs-news-media img {
    transform: scale(1.08);
    filter: saturate(1.15) contrast(1.06);
}

.rs-news-category-badge {
    position: absolute;
    top: .9rem;
    right: .9rem;
    z-index: 2;
    padding: .35rem .75rem;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, .8);
    background: rgba(84, 32, 25, .78);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #fff;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .02em;
}

.rs-news-body {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    padding: 1.35rem 1.4rem 1.35rem;
}

.rs-news-meta {
    display: flex;
    flex-direction: column;
    gap: .35rem;
    height: 48px;
    min-height: 48px;
    margin-bottom: .75rem;
    justify-content: center;
}

.rs-news-meta-item {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    color: #756a61;
    font-size: .84rem;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rs-news-meta-item svg {
    flex-shrink: 0;
    width: 15px;
    height: 15px;
    stroke: var(--color-maroon);
    stroke-width: 2;
    fill: none;
}

.rs-news-title {
    margin: 0 0 .65rem;
    color: #542019;
    font-size: 1.18rem;
    font-weight: 700;
    line-height: 1.32;
    height: 3.15rem;
    min-height: 3.15rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 180ms ease;
}

.rs-news-item-card:hover .rs-news-title {
    color: var(--color-maroon);
}

.rs-news-excerpt {
    margin: 0 0 1rem;
    color: #67574c;
    font-size: .88rem;
    line-height: 1.55;
    height: 4.1rem;
    min-height: 4.1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.rs-news-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .6rem;
    margin-top: auto;
    padding-top: .9rem;
    border-top: 1px solid rgba(143, 23, 29, .1);
    min-height: 54px;
}

/* No Results Message */
.rs-events-empty-state {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3.5rem 1.5rem;
    border: 1px dashed rgba(143, 23, 29, .25);
    border-radius: 1.25rem;
    background: rgba(255, 255, 255, .5);
    text-align: center;
}

.rs-events-empty-state.is-visible {
    display: flex;
}

.rs-events-empty-state span.empty-icon {
    font-size: 2.4rem;
    margin-bottom: .8rem;
    color: var(--color-saffron);
}

.rs-events-empty-state h3 {
    margin: 0 0 .4rem;
    color: #542019;
    font-size: 1.25rem;
}

.rs-events-empty-state p {
    margin: 0 0 1.25rem;
    color: #756a61;
    font-size: .9rem;
}

/* ============================================================
   Newsletter / Stay Informed Banner (Consistent with Home/Centers)
   ============================================================ */
.rs-events-subscribe-section {
    padding: 2.5rem 0 1rem;
}

.rs-events-newsletter-card {
    position: relative;
    overflow: hidden;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    padding: 2.75rem 3rem;
    border: 1px solid rgba(255, 255, 255, .8);
    border-radius: 1.5rem;
    background: linear-gradient(135deg, rgba(255, 245, 223, .92), rgba(255, 235, 195, .82));
    box-shadow: 0 20px 48px rgba(89, 37, 24, .12), inset 0 1px 0 #fff;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

.rs-events-newsletter-card::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -20%;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(249, 183, 42, .32), transparent 70%);
    pointer-events: none;
}

.rs-events-newsletter-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    max-width: 580px;
}

.rs-events-newsletter-icon {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    box-shadow: 0 8px 20px rgba(143, 23, 29, .25);
    color: #fff;
    font-size: 1.6rem;
}

.rs-events-newsletter-text h3 {
    margin: 0 0 .35rem;
    color: #542019;
    font-size: 1.45rem;
    font-weight: 800;
}

.rs-events-newsletter-text p {
    margin: 0;
    color: #67574c;
    font-size: .92rem;
    line-height: 1.55;
}

.rs-events-newsletter-form {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .75rem;
    flex: 1;
    min-width: 300px;
    max-width: 480px;
}

.rs-events-newsletter-form input[type="email"] {
    flex: 1;
    min-width: 220px;
    height: 3.1rem;
    padding: 0 1.25rem;
    border: 1px solid rgba(143, 23, 29, .22);
    border-radius: 999px;
    background: #fff;
    color: #542019;
    font-family: 'Poppins', sans-serif;
    font-size: .88rem;
    outline: none;
    box-shadow: inset 0 2px 4px rgba(89, 37, 24, .04);
}

.rs-events-newsletter-form input[type="email"]:focus {
    border-color: var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .14);
}

.rs-events-newsletter-form button {
    height: 3.1rem;
    padding: 0 1.6rem;
    border: 1px solid #B31B1B;
    border-radius: 999px;
    background: #B31B1B;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: .88rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(179, 27, 27, .28);
    transition: all 180ms ease;
    white-space: nowrap;
}

.rs-events-newsletter-form button:hover {
    background: #8F171D;
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(179, 27, 27, .38);
}

.rs-newsletter-msg {
    width: 100%;
    margin: .4rem 0 0 .5rem;
    font-size: .82rem;
    font-weight: 600;
    display: none;
}

.rs-newsletter-msg.is-success {
    display: block;
    color: #1e7e34;
}

/* ============================================================
   Interactive Registration Modal Dialog
   ============================================================ */
.rs-event-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    opacity: 0;
    transition: opacity 220ms ease;
}

.rs-event-modal.is-active {
    display: flex;
    opacity: 1;
}

.rs-event-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(30, 10, 5, .62);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

.rs-event-modal-card {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 580px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 2.25rem;
    border: 1px solid rgba(255, 255, 255, .85);
    border-radius: 1.5rem;
    background: #fffdf9;
    box-shadow: 0 28px 64px rgba(45, 12, 5, .32);
    transform: scale(.95);
    transition: transform 240ms cubic-bezier(.2,.8,.2,1);
}

.rs-event-modal.is-active .rs-event-modal-card {
    transform: scale(1);
}

.rs-modal-close-btn {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    width: 36px;
    height: 36px;
    border: 1px solid rgba(143, 23, 29, .15);
    border-radius: 50%;
    background: rgba(255, 255, 255, .8);
    color: #542019;
    font-size: 1.1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 160ms ease;
}

.rs-modal-close-btn:hover {
    background: var(--color-maroon);
    color: #fff;
}

.rs-modal-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(143, 23, 29, .12);
}

.rs-modal-badge {
    display: inline-block;
    padding: .25rem .7rem;
    border-radius: 999px;
    background: #fff0d8;
    color: var(--color-saffron);
    font-size: .75rem;
    font-weight: 700;
    margin-bottom: .5rem;
}

.rs-modal-title {
    margin: 0 0 .5rem;
    color: #542019;
    font-size: 1.45rem;
    font-weight: 800;
    line-height: 1.25;
}

.rs-modal-event-details {
    display: flex;
    flex-wrap: wrap;
    gap: .85rem;
    color: #67574c;
    font-size: .84rem;
    font-weight: 500;
}

.rs-modal-event-details span {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
}

.rs-modal-detail-icon {
    width: 15px;
    height: 15px;
    fill: none;
    stroke: var(--color-maroon);
    stroke-width: 2.2;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
}

.rs-modal-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

@media (max-width: 480px) {
    .rs-modal-row {
        grid-template-columns: 1fr;
        gap: .85rem;
    }
}

/* Modal Form Fields */
.rs-modal-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.rs-modal-field {
    display: flex;
    flex-direction: column;
    gap: .35rem;
}

.rs-modal-field label {
    color: #542019;
    font-size: .82rem;
    font-weight: 700;
}

.rs-modal-field input,
.rs-modal-field select {
    height: 2.75rem;
    padding: 0 .95rem;
    border: 1px solid rgba(143, 23, 29, .22);
    border-radius: .65rem;
    background: #fff;
    color: #542019;
    font-family: 'Poppins', sans-serif;
    font-size: .86rem;
    outline: none;
    transition: border-color 160ms ease, box-shadow 160ms ease;
}

.rs-modal-field input:focus,
.rs-modal-field select:focus {
    border-color: var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .12);
}

.rs-modal-submit-btn {
    height: 2.9rem;
    margin-top: .6rem;
    border: 1px solid #B31B1B;
    border-radius: 999px;
    background: #B31B1B;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: .92rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(179, 27, 27, .28);
    transition: all 180ms ease;
}

.rs-modal-submit-btn:hover {
    background: #8F171D;
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(179, 27, 27, .38);
}

.rs-modal-success-alert {
    display: none;
    padding: 1rem;
    border-radius: .75rem;
    background: #e8f5e9;
    border: 1px solid #c8e6c9;
    color: #2e7d32;
    font-size: .86rem;
    font-weight: 600;
    text-align: center;
}

/* Event Registration Confirmation Card */
.rs-event-confirm-card {
    text-align: center;
    padding: 0.5rem 0.25rem;
    animation: rsFadeInUp 0.32s cubic-bezier(0.16, 1, 0.3, 1);
}
.rs-evt-confirm-icon-wrap {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #ecfdf5;
    box-shadow: 0 0 0 8px #f0fdf4;
}
.rs-evt-confirm-check-svg {
    width: 42px;
    height: 42px;
}
.rs-evt-confirm-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #065f46;
    margin: 0 0 0.3rem;
}
.rs-evt-confirm-greeting {
    font-size: 1.05rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.35rem;
}
.rs-evt-confirm-desc {
    font-size: 0.9rem;
    color: #4b5563;
    margin: 0 0 1.25rem;
    line-height: 1.45;
}
.rs-evt-confirm-summary-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.9rem 1.15rem;
    text-align: left;
    margin-bottom: 1.15rem;
}
.rs-evt-confirm-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0.45rem 0;
    border-bottom: 1px dashed #e2e8f0;
    font-size: 0.86rem;
    gap: 0.75rem;
}
.rs-evt-confirm-summary-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.rs-evt-confirm-summary-label {
    color: #64748b;
    font-weight: 500;
    flex-shrink: 0;
}
.rs-evt-confirm-summary-val {
    color: #0f172a;
    font-weight: 600;
    text-align: right;
    word-break: break-word;
}
.rs-evt-confirm-next-steps {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 0.8rem 1rem;
    font-size: 0.84rem;
    color: #166534;
    text-align: left;
    margin-bottom: 1.25rem;
    line-height: 1.4;
}
.rs-evt-confirm-next-steps svg {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
}
.rs-evt-confirm-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
}
.rs-evt-confirm-done-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 2.25rem;
    background: #B31B1B;
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 600;
    border: none;
    border-radius: 999px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(179, 27, 27, 0.25);
    transition: all 0.2s ease;
}
.rs-evt-confirm-done-btn:hover {
    background: #8F171D;
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(179, 27, 27, 0.35);
}

/* ============================================================
   Big Activities-Style Event & News Detail Modals
   ============================================================ */
.rs-event-big-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: clamp(14px, 2.5vw, 32px);
    opacity: 0;
    transition: opacity 240ms ease;
}

.rs-event-big-modal.is-active {
    display: flex;
    opacity: 1;
}

.rs-event-big-modal .rs-event-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(30, 10, 5, 0.65);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

.rs-event-big-modal-container {
    position: relative;
    z-index: 2;
    width: 100%;
    display: flex;
    justify-content: center;
}

.rs-event-big-card {
    position: relative;
    width: 100% !important;
    max-width: 980px !important;
    max-height: calc(100vh - 44px);
    overflow-y: auto;
    overflow-x: hidden;
    background: #FFFDF9;
    border: 1.5px solid rgba(143, 23, 29, 0.18);
    border-radius: 26px;
    box-shadow: 0 32px 90px rgba(45, 12, 8, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.9) inset;
    padding: clamp(28px, 3vw, 40px) clamp(24px, 3.5vw, 44px);
    transform: scale(0.94) translateY(18px);
    transition: transform 320ms cubic-bezier(0.16, 1, 0.3, 1);
    scrollbar-width: thin;
    scrollbar-color: rgba(143, 23, 29, 0.25) transparent;
}

.rs-event-big-card::-webkit-scrollbar {
    width: 6px;
}

.rs-event-big-card::-webkit-scrollbar-thumb {
    background: rgba(143, 23, 29, 0.25);
    border-radius: 10px;
}

.rs-event-big-modal.is-active .rs-event-big-card {
    transform: scale(1) translateY(0);
}

.rs-event-big-close {
    position: absolute;
    top: 22px;
    right: 22px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid rgba(143, 23, 29, 0.18);
    background: #FFF5EA;
    color: #542019;
    font-size: 1.25rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 180ms ease;
    z-index: 10;
    line-height: 1;
}

.rs-event-big-close:hover {
    background: #8F171D;
    color: #FFFFFF;
    border-color: #8F171D;
    transform: rotate(90deg) scale(1.08);
}

.rs-event-modal-banner-wrap {
    width: 100%;
    max-height: 380px;
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    background: #f7ebe1;
    box-shadow: 0 10px 30px rgba(89, 37, 24, 0.12);
}

.rs-event-modal-banner-wrap img {
    width: 100%;
    max-height: 380px;
    object-fit: cover;
    display: block;
}

.rs-event-meta-pill-group {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-top: .85rem;
}

.rs-event-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .4rem .95rem;
    border-radius: 999px;
    background: #FFF4E4;
    border: 1px solid rgba(243, 106, 33, .25);
    color: #542019;
    font-size: .84rem;
    font-weight: 600;
}

.rs-event-meta-pill svg {
    width: 16px;
    height: 16px;
    stroke: var(--color-maroon);
    stroke-width: 2.2;
    fill: none;
    flex-shrink: 0;
}

.rs-act-modal-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
}

.rs-act-modal-tagline {
    display: inline-block;
    color: var(--color-saffron);
    font: 700 0.78rem 'Poppins', sans-serif;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.rs-act-modal-title {
    margin: 0 0 8px;
    color: #542019;
    font: 700 clamp(1.5rem, 2.4vw, 2.1rem)/1.22 'Poppins', sans-serif;
    letter-spacing: -0.02em;
}

.rs-act-modal-divider {
    height: 1px;
    background: linear-gradient(90deg, rgba(143, 23, 29, 0.18), rgba(243, 106, 33, 0.25), transparent);
    margin: 1.25rem 0 1.5rem;
}

.rs-event-modal-fulltext {
    color: #3b2b24;
    font-size: 1.02rem;
    line-height: 1.8;
}

.rs-event-modal-fulltext p {
    margin: 0 0 1.25rem;
}

.rs-dignitaries-list {
    margin: .85rem 0 1.5rem;
    padding-left: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: .65rem;
}

.rs-dignitaries-list li {
    position: relative;
    padding: .75rem 1.15rem .75rem 2.2rem;
    background: rgba(255, 247, 237, .75);
    border: 1px solid rgba(143, 23, 29, .12);
    border-radius: .85rem;
    line-height: 1.6;
    font-size: .95rem;
    color: #43332c;
}

.rs-dignitaries-list li::before {
    content: "•";
    position: absolute;
    left: .85rem;
    top: .65rem;
    color: var(--color-maroon);
    font-size: 1.35rem;
    line-height: 1;
}

.rs-dignitaries-list li strong {
    color: var(--color-maroon);
    font-weight: 700;
}

.rs-act-modal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}

.rs-act-modal-footer-note {
    margin: 0;
    color: #796d65;
    font: 500 0.84rem/1.55 'Poppins', sans-serif;
    max-width: 580px;
}

.rs-act-modal-footer-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.rs-act-modal-centers-link {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    border-radius: 999px;
    background: #FFF6EC;
    color: #542019;
    border: 1px solid rgba(143, 23, 29, 0.2);
    font: 600 0.82rem 'Poppins', sans-serif;
    text-decoration: none;
    transition: all 180ms ease;
    white-space: nowrap;
}

.rs-act-modal-centers-link:hover {
    background: #FFEEDB;
    border-color: #8F171D;
    color: #8F171D;
}

/* Modal Register Now Button (Vibrant Red, Matches Theme Primary Button) */
.rs-modal-register-btn {
    background: #B31B1B !important;
    color: #FFFFFF !important;
    border: 1px solid #8F171D !important;
    border-radius: 999px !important;
    padding: 10px 24px !important;
    font: 700 0.86rem 'Poppins', sans-serif !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    box-shadow: 0 6px 18px rgba(179, 27, 27, 0.3) !important;
    cursor: pointer !important;
    transition: all 180ms ease !important;
    white-space: nowrap !important;
}

.rs-modal-register-btn:hover {
    background: #8F171D !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 10px 24px rgba(179, 27, 27, 0.4) !important;
    color: #FFFFFF !important;
}

/* Modal Closed Badge */
.rs-modal-closed-btn {
    background: rgba(117, 106, 97, 0.1) !important;
    color: #756a61 !important;
    border: 1px solid rgba(117, 106, 97, 0.25) !important;
    border-radius: 999px !important;
    padding: 10px 22px !important;
    font: 600 0.84rem 'Poppins', sans-serif !important;
    display: inline-flex !important;
    align-items: center !important;
    cursor: not-allowed !important;
    white-space: nowrap !important;
}

/* Modal Close Button (Plain / Warm Outline) */
.rs-act-modal-close-pill-btn,
.rs-act-modal-cta-btn {
    background: #FFF6EC !important;
    color: #542019 !important;
    border: 1px solid rgba(143, 23, 29, 0.24) !important;
    border-radius: 999px !important;
    padding: 10px 22px !important;
    font: 600 0.84rem 'Poppins', sans-serif !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    cursor: pointer !important;
    transition: all 180ms ease !important;
    white-space: nowrap !important;
    box-shadow: none !important;
}

.rs-act-modal-close-pill-btn:hover,
.rs-act-modal-cta-btn:hover {
    background: #FFEEDB !important;
    border-color: #8F171D !important;
    color: #8F171D !important;
    transform: translateY(-1px) !important;
}

/* ============================================================
   Responsive Media Queries
   ============================================================ */
@media (max-width: 1050px) {
    .rs-carousel-track > * {
        flex: 0 0 calc(50% - 0.75rem);
        min-width: 290px;
    }
}

@media (max-width: 768px) {
    .rs-events-header-section {
        padding: 2.5rem 0 1.5rem;
    }
    .rs-events-filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    .rs-events-nav-tabs {
        overflow-x: auto;
        flex-wrap: nowrap;
    }
    .rs-events-search-box {
        max-width: none;
        min-width: 0;
    }
    .rs-carousel-track > * {
        flex: 0 0 84vw;
        min-width: 270px;
    }
    .rs-carousel-side-arrow.rs-arrow-prev {
        left: 0;
    }
    .rs-carousel-side-arrow.rs-arrow-next {
        right: 0;
    }
    .rs-events-newsletter-card {
        padding: 1.75rem;
        flex-direction: column;
    }
    .rs-events-newsletter-content {
        flex-direction: column;
        text-align: center;
    }
    .rs-events-newsletter-form {
        min-width: 100%;
    }
}
</style>

<?php
/**
 * Events and news data — loaded from data/events-data.php.
 * To swap in DB data, update rs_get_events() and rs_get_news() in inc/data-helpers.php.
 */
$events_dataset = rs_get_events();
$news_dataset   = rs_get_news();
?>

<main class="rs-events-page" id="main-content">



    <!-- ============================================================
         Refined Header Block (Zero Hero Banner — Activities/Centers Style)
         ============================================================ -->
    <section class="rs-events-header-section" aria-labelledby="events-page-heading">
        <div class="rs-container">
            <div class="rs-events-title-block">
                <h1 id="events-page-heading" class="rs-events-page-title">Events &amp; <em>News</em></h1>
                <p class="rs-events-page-subtitle">
                    Experience transformative yoga celebrations, skill-building workshops, and inspiring community stories across our 10+ Bengaluru centers. Find your next milestone below.
                </p>
            </div>

            <!-- ============================================================
                 Control Bar: Live Search, Tabs & Multi-Filters
                 ============================================================ -->
            <div class="rs-events-control-card" role="search" aria-label="Event and news filters">
                <div class="rs-events-filter-row">
                    <!-- Segmented Navigation Tabs -->
                    <nav class="rs-events-nav-tabs" aria-label="Filter by type">
                        <button type="button" class="rs-events-tab-btn is-active" data-filter-type="all">All Items</button>
                        <button type="button" class="rs-events-tab-btn" data-filter-type="events">Events &amp; Programs</button>
                        <button type="button" class="rs-events-tab-btn" data-filter-type="news">News &amp; Articles</button>
                    </nav>

                    <!-- Real-Time Search Box -->
                    <div class="rs-events-search-box">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="search" id="rs-events-search-input" placeholder="Search events, workshops, centers, or news..." aria-label="Search events and news" autocomplete="off">
                        <button type="button" id="rs-events-clear-search" class="rs-events-search-clear" aria-label="Clear search">×</button>
                    </div>
                </div>

                <!-- Secondary Filter Selectors -->
                <div class="rs-events-subfilters-row">
                    <label for="rs-filter-category" class="screen-reader-text" style="position:absolute;width:1px;height:1px;overflow:hidden;">Select Category</label>
                    <select id="rs-filter-category" class="rs-events-filter-select" aria-label="Filter by category">
                        <option value="all">All Categories</option>
                        <option value="special">Special Events</option>
                        <option value="workshop">Workshops &amp; Masterclasses</option>
                        <option value="wellness">Wellness &amp; Therapy</option>
                        <option value="children">Children &amp; Youth</option>
                        <option value="achievement">Achievements</option>
                        <option value="community">Community Initiatives</option>
                    </select>

                    <label for="rs-filter-month" class="screen-reader-text" style="position:absolute;width:1px;height:1px;overflow:hidden;">Select Timeframe</label>
                    <select id="rs-filter-month" class="rs-events-filter-select" aria-label="Filter by timeframe">
                        <option value="all">All Timeframes</option>
                        <option value="current">June 2026</option>
                        <option value="july">July 2026</option>
                        <option value="august">August 2026 &amp; Beyond</option>
                        <option value="past">Past Archives</option>
                    </select>

                    <button type="button" id="rs-filter-reset-btn" class="rs-events-reset-btn" aria-label="Reset all filters">
                        <span aria-hidden="true">↺</span> Reset Filters
                    </button>

                    <div class="rs-events-status-indicator" id="rs-filter-count-text" aria-live="polite">
                        Showing <?php echo count($events_dataset); ?> Events &amp; <?php echo count($news_dataset); ?> Article<?php echo count($news_dataset) === 1 ? '' : 's'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         Events & Programs Section (Equal Cards + Side Arrow Carousel)
         ============================================================ -->
    <section class="rs-events-section" id="events-section" aria-labelledby="events-section-title">
        <div class="rs-container">
            <div class="rs-events-section-header">
                <div>
                    <h2 id="events-section-title">Events &amp; Programs</h2>
                    <p class="rs-events-section-desc">
                        Participate in inspiring gatherings, therapeutic intensives, and celebrations guided by certified Rashtrotthana Gurus.
                    </p>
                </div>
                <div class="rs-events-header-controls">
                    <button type="button" class="rs-view-toggle-btn" id="rs-events-view-toggle" aria-expanded="false" data-target="events-carousel-stage">
                        <span class="toggle-text">View All Events in Grid</span> <span aria-hidden="true">⊞</span>
                    </button>
                </div>
            </div>

            <!-- Events Carousel Stage (With Left & Right Side Arrows) -->
            <div class="rs-carousel-stage" id="events-carousel-stage">
                <!-- Left End Arrow -->
                <button type="button" class="rs-carousel-side-arrow rs-arrow-prev" id="events-btn-prev" aria-label="Previous events">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <!-- Events Carousel Track -->
                <div class="rs-carousel-track" id="events-carousel-track" role="region" aria-label="Events carousel" tabindex="0">
                    <?php foreach ( $events_dataset as $index => $event ) : ?>
                        <article class="rs-event-item-card"
                                 id="<?php echo esc_attr( $event['id'] ); ?>"
                                 data-event-id="<?php echo esc_attr( $event['id'] ); ?>"
                                 data-type="<?php echo esc_attr( $event['type'] ); ?>"
                                 data-category="<?php echo esc_attr( $event['category_slug'] ); ?>"
                                 data-timeframe="<?php echo esc_attr( $event['timeframe'] ); ?>"
                                 data-title="<?php echo esc_attr( $event['title'] ); ?>"
                                 data-venue="<?php echo esc_attr( $event['venue'] ); ?>"
                                 data-date="<?php echo esc_attr( $event['day'] . ' ' . $event['month'] . ' ' . $event['year'] ); ?>"
                                 data-time="<?php echo esc_attr( $event['time'] ); ?>"
                                 data-fee="<?php echo esc_attr( $event['fee'] ); ?>"
                                 data-search="<?php echo esc_attr( strtolower( $event['title'] . ' ' . $event['venue'] . ' ' . $event['category'] . ' ' . $event['desc'] ) ); ?>"
                                 tabindex="0" role="button" aria-haspopup="dialog" aria-label="View details for <?php echo esc_attr( $event['title'] ); ?>">
                            
                            <div class="rs-event-media">
                                <img src="<?php echo esc_url( $event['image'] ); ?>" alt="<?php echo esc_attr( $event['title'] ); ?>" loading="lazy">
                                <span class="rs-event-category-pill"><?php echo esc_html( $event['category'] ); ?></span>
                                <div class="rs-event-date-badge">
                                    <strong><?php echo esc_html( $event['day'] ); ?></strong>
                                    <span><?php echo esc_html( $event['month'] ); ?></span>
                                </div>
                            </div>

                            <div class="rs-event-body">
                                <div class="rs-event-meta-list">
                                    <div class="rs-event-meta-item">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <span><?php echo esc_html( $event['venue'] ); ?></span>
                                    </div>
                                    <div class="rs-event-meta-item">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span><?php echo esc_html( $event['time'] ); ?></span>
                                    </div>
                                </div>

                                <h3 class="rs-event-title"><?php echo esc_html( $event['title'] ); ?></h3>
                                <p class="rs-event-desc"><?php echo esc_html( $event['desc'] ); ?></p>

                                <div class="rs-event-footer">
                                    <button type="button" class="rs-card-view-btn rs-open-event-modal" data-event-id="<?php echo esc_attr( $event['id'] ); ?>" aria-label="View details for <?php echo esc_attr( $event['title'] ); ?>">
                                        <span>View Details</span> <span aria-hidden="true">&rarr;</span>
                                    </button>
                                    <?php if ( !empty($event['registration_status']) && $event['registration_status'] === 'closed' ) : ?>
                                        <span class="rs-card-closed-pill" aria-label="Registration is closed">Closed</span>
                                    <?php else : ?>
                                        <button type="button" class="rs-card-register-btn rs-open-register-modal" data-event-id="<?php echo esc_attr( $event['id'] ); ?>" data-event-title="<?php echo esc_attr( $event['title'] ); ?>" aria-label="Register now for <?php echo esc_attr( $event['title'] ); ?>">
                                            <span>Register Now</span> <span aria-hidden="true">&rarr;</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Right End Arrow -->
                <button type="button" class="rs-carousel-side-arrow rs-arrow-next" id="events-btn-next" aria-label="Next events">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>

            <!-- Empty State for Events -->
            <div class="rs-events-empty-state" id="events-empty-state">
                <span class="empty-icon">🌱</span>
                <h3>No Events Found</h3>
                <p>No upcoming events match your selected filters. Try choosing "All Categories" or resetting your search.</p>
                <button type="button" class="rs-events-reset-btn rs-trigger-reset">Clear Filters</button>
            </div>

            <!-- Centered Dots & Status Bar Below Section -->
            <div class="rs-carousel-sub-bar" id="events-carousel-controls">
                <div class="rs-carousel-dots" id="events-carousel-dots" role="tablist" aria-label="Event slides">
                    <!-- Populated via JS -->
                </div>
                <div class="rs-carousel-page-status" id="events-carousel-status">
                    Slide 1 of <?php echo ceil(count($events_dataset) / 3); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         News & Articles Section (Equal Cards + Side Arrow Carousel)
         ============================================================ -->
    <section class="rs-events-section" id="news-section" aria-labelledby="news-section-title">
        <div class="rs-container">
            <div class="rs-events-section-header">
                <div>
                    <h2 id="news-section-title">News, Insights &amp; Articles</h2>
                    <p class="rs-events-section-desc">
                        Explore stories of community transformation, holistic health tips, and milestone announcements from the Rashtrotthana movement.
                    </p>
                </div>
                <div class="rs-events-header-controls">
                    <button type="button" class="rs-view-toggle-btn" id="rs-news-view-toggle" aria-expanded="false" data-target="news-carousel-stage">
                        <span class="toggle-text">View All News in Grid</span> <span aria-hidden="true">⊞</span>
                    </button>
                </div>
            </div>

            <!-- News Carousel Stage (With Left & Right Side Arrows) -->
            <div class="rs-carousel-stage" id="news-carousel-stage">
                <!-- Left End Arrow -->
                <button type="button" class="rs-carousel-side-arrow rs-arrow-prev" id="news-btn-prev" aria-label="Previous news">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <!-- News Carousel Track -->
                <div class="rs-carousel-track" id="news-carousel-track" role="region" aria-label="News articles carousel" tabindex="0">
                    <?php foreach ( $news_dataset as $index => $article ) : ?>
                        <article class="rs-news-item-card"
                                 id="<?php echo esc_attr( $article['id'] ); ?>"
                                 data-news-id="<?php echo esc_attr( $article['id'] ); ?>"
                                 data-category="<?php echo esc_attr( $article['category_slug'] ); ?>"
                                 data-title="<?php echo esc_attr( $article['title'] ); ?>"
                                 data-date="<?php echo esc_attr( $article['date'] ); ?>"
                                 data-search="<?php echo esc_attr( strtolower( $article['title'] . ' ' . $article['category'] . ' ' . $article['excerpt'] ) ); ?>"
                                 tabindex="0" role="button" aria-haspopup="dialog" aria-label="Read article: <?php echo esc_attr( $article['title'] ); ?>">
                            
                            <div class="rs-news-media">
                                <img src="<?php echo esc_url( $article['image'] ); ?>" alt="<?php echo esc_attr( $article['title'] ); ?>" loading="lazy">
                                <span class="rs-news-category-badge"><?php echo esc_html( $article['category'] ); ?></span>
                                <div class="rs-event-date-badge">
                                    <strong><?php echo esc_html( date('d', strtotime($article['date'])) ); ?></strong>
                                    <span><?php echo esc_html( date('M', strtotime($article['date'])) ); ?></span>
                                </div>
                            </div>

                            <div class="rs-news-body">
                                <div class="rs-news-meta">
                                    <div class="rs-news-meta-item">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        <span><?php echo esc_html( $article['date'] ); ?></span>
                                    </div>
                                    <div class="rs-news-meta-item">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span><?php echo esc_html( $article['read_time'] ); ?></span>
                                    </div>
                                </div>

                                <h3 class="rs-news-title"><?php echo esc_html( $article['title'] ); ?></h3>
                                <p class="rs-news-excerpt"><?php echo esc_html( $article['excerpt'] ); ?></p>

                                <div class="rs-news-footer">
                                    <span class="rs-event-mode-badge" title="<?php echo esc_attr( $article['read_time'] ); ?>"><?php echo esc_html( $article['read_time'] ); ?></span>
                                    <button type="button" class="rs-register-btn rs-open-article-modal" data-news-id="<?php echo esc_attr( $article['id'] ); ?>">
                                        <span>Read More</span> <span aria-hidden="true">&rarr;</span>
                                    </button>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Right End Arrow -->
                <button type="button" class="rs-carousel-side-arrow rs-arrow-next" id="news-btn-next" aria-label="Next news">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>

            <!-- Empty State for News -->
            <div class="rs-events-empty-state" id="news-empty-state">
                <span class="empty-icon">??</span>
                <h3>No News Articles Found</h3>
                <p>No news stories match your current search criteria. Try modifying your query.</p>
                <button type="button" class="rs-events-reset-btn rs-trigger-reset">Reset Filters</button>
            </div>

            <!-- Centered Dots & Status Bar Below Section -->
            <div class="rs-carousel-sub-bar" id="news-carousel-controls">
                <div class="rs-carousel-dots" id="news-carousel-dots" role="tablist" aria-label="News slides">
                    <!-- Populated via JS -->
                </div>
                <div class="rs-carousel-page-status" id="news-carousel-status">
                    Slide 1 of <?php echo ceil(count($news_dataset) / 3); ?>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- ============================================================
     Interactive "Event Details" Modal (Big Card, Activities Style)
     ============================================================ -->
<div id="rs-event-detail-modal" class="rs-event-big-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="rs-big-event-title">
    <div class="rs-event-modal-backdrop" data-close-modal="true"></div>
    <div class="rs-event-big-modal-container">
        <div class="rs-event-big-card">
            <button type="button" class="rs-event-big-close" aria-label="Close event details" data-close-modal="true">&times;</button>
            
            <div class="rs-event-modal-banner-wrap" id="rs-big-event-banner-wrap">
                <img id="rs-big-event-img" src="" alt="">
            </div>

            <div class="rs-act-modal-header">
                <div class="rs-act-modal-meta">
                    <span class="rs-act-modal-tagline" id="rs-big-event-category">SPECIAL EVENT</span>
                    <div id="rs-modal-header-reg-wrap"></div>
                </div>
                <h2 class="rs-act-modal-title" id="rs-big-event-title">Event Title</h2>
                
                <div class="rs-event-meta-pill-group">
                    <span class="rs-event-meta-pill">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <strong id="rs-big-event-date">Date</strong>
                    </span>
                    <span class="rs-event-meta-pill">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span id="rs-big-event-time">Time</span>
                    </span>
                    <span class="rs-event-meta-pill">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span id="rs-big-event-venue">Venue</span>
                    </span>
                </div>
            </div>

            <div class="rs-act-modal-divider" aria-hidden="true"></div>

            <div class="rs-act-modal-body">
                <div class="rs-event-modal-fulltext" id="rs-big-event-content">
                    <!-- Injected via JavaScript -->
                </div>
            </div>

            <div class="rs-act-modal-footer">
                <p class="rs-act-modal-footer-note">Rashtrotthana Yoga — Nurturing health, culture, and community across 10+ Bengaluru centers.</p>
                <div class="rs-act-modal-footer-actions">
                    <a href="<?php echo esc_url( home_url('/centers/') ); ?>" class="rs-act-modal-centers-link">
                        <span>Find Nearest Center &rarr;</span>
                    </a>
                    <div id="rs-modal-reg-action-wrap"></div>
                    <button type="button" class="rs-act-modal-close-pill-btn" data-close-modal="true">
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     Interactive "Read Article" Preview Modal (Big Card, Activities Style)
     ============================================================ -->
<div id="rs-article-modal" class="rs-event-big-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="rs-article-modal-title">
    <div class="rs-event-modal-backdrop" data-close-modal="true"></div>
    <div class="rs-event-big-modal-container">
        <div class="rs-event-big-card">
            <button type="button" class="rs-event-big-close" aria-label="Close article dialog" data-close-modal="true">&times;</button>
            
            <div class="rs-event-modal-banner-wrap" id="rs-article-modal-banner-wrap">
                <img id="rs-article-modal-img" src="" alt="">
            </div>

            <div class="rs-act-modal-header">
                <div class="rs-act-modal-meta">
                    <span class="rs-act-modal-tagline" id="rs-article-modal-category">NEWS &amp; UPDATES</span>
                </div>
                <h2 class="rs-act-modal-title" id="rs-article-modal-title">Article Title</h2>
                <div class="rs-event-meta-pill-group">
                    <span class="rs-event-meta-pill">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span id="rs-article-modal-date">Date</span>
                    </span>
                    <span class="rs-event-meta-pill">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span id="rs-article-modal-readtime">2 min read</span>
                    </span>
                    <span class="rs-event-meta-pill">
                        <span>Rashtrotthana Editorial</span>
                    </span>
                </div>
            </div>

            <div class="rs-act-modal-divider" aria-hidden="true"></div>

            <div class="rs-act-modal-body">
                <div class="rs-event-modal-fulltext" id="rs-article-modal-content">
                    <!-- Injected via JavaScript -->
                </div>
            </div>

            <div class="rs-act-modal-footer">
                <p class="rs-act-modal-footer-note">For media coverage, press releases, or inquiries, reach out to info@rashtrotthana.org.</p>
                <div class="rs-act-modal-footer-actions">
                    <button type="button" class="rs-act-modal-close-pill-btn" data-close-modal="true">
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     Interactive "Register Now" Event Registration Modal Dialog
     ============================================================ -->
<div id="rs-registration-modal" class="rs-event-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="rs-reg-modal-title">
    <div class="rs-event-modal-backdrop" data-close-reg-modal="true"></div>
    <div class="rs-event-modal-card">
        <button type="button" class="rs-modal-close-btn" aria-label="Close registration form" data-close-reg-modal="true">&times;</button>
        
        <div class="rs-modal-header">
            <span class="rs-modal-badge" id="rs-reg-modal-badge">EVENT REGISTRATION</span>
            <h2 class="rs-modal-title" id="rs-reg-modal-title">Register for Event</h2>
            <div class="rs-modal-event-details">
                <span id="rs-reg-modal-date">
                    <svg class="rs-modal-detail-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <strong id="rs-reg-modal-date-text">Date</strong>
                </span>
                <span id="rs-reg-modal-time">
                    <svg class="rs-modal-detail-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span id="rs-reg-modal-time-text">Time</span>
                </span>
                <span id="rs-reg-modal-venue">
                    <svg class="rs-modal-detail-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span id="rs-reg-modal-venue-text">Venue</span>
                </span>
            </div>
        </div>

        <form class="rs-modal-form" id="rs-event-reg-form">
            <?php wp_nonce_field( 'rs_event_reg_nonce', 'rs_event_reg_nonce' ); ?>
            <input type="hidden" id="rs-reg-event-id" name="event_id" value="">
            
            <div class="rs-modal-field">
                <label for="rs-reg-name">Full Name *</label>
                <input type="text" id="rs-reg-name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="rs-modal-row">
                <div class="rs-modal-field">
                    <label for="rs-reg-phone">Phone Number *</label>
                    <input type="tel" id="rs-reg-phone" name="phone" placeholder="e.g. +91 98765 43210" required>
                </div>
                <div class="rs-modal-field">
                    <label for="rs-reg-email">Email Address *</label>
                    <input type="email" id="rs-reg-email" name="email" placeholder="you@example.com" required>
                </div>
            </div>

            <div class="rs-modal-field">
                <label for="rs-reg-center">Preferred Center / Branch</label>
                <select id="rs-reg-center" name="center">
                    <option value="">Select Nearest Center / Branch</option>
                    <?php if ( ! empty( $all_event_centers ) ) : ?>
                        <?php foreach ( $all_event_centers as $c ) : ?>
                            <option value="<?php echo esc_attr( $c['name'] ); ?>"><?php echo esc_html( $c['name'] . ( ! empty( $c['zone'] ) ? ' (' . $c['zone'] . ')' : '' ) ); ?></option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="Jayanagar">Jayanagar</option>
                        <option value="Basavanagudi">Basavanagudi</option>
                        <option value="Sadashivanagar">Sadashivanagar</option>
                        <option value="KG Nagar">KG Nagar / Sunkenahalli</option>
                        <option value="Vijayanagar">Vijayanagar</option>
                    <?php endif; ?>
                    <option value="Other">Other / Not sure</option>
                </select>
            </div>

            <button type="submit" class="rs-modal-submit-btn" id="rs-reg-submit-btn">
                <span>Confirm Registration &rarr;</span>
            </button>

            <div class="rs-modal-error-alert" id="rs-reg-error-msg" style="display:none; color:#ef4444; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:10px 14px; font-size:13px; margin-top:10px;"></div>

            <div class="rs-modal-success-alert" id="rs-reg-success-msg">
                🎉 <strong>Registration Submitted Successfully!</strong><br>
                Thank you! Our coordinators will contact you with reporting timings and tournament details.
            </div>
        </form>

        <!-- Event Registration Confirmation Card (Shown when registration succeeds) -->
        <div class="rs-event-confirm-card" id="rs-event-confirm-card" style="display: none;">
            <div class="rs-evt-confirm-icon-wrap">
                <svg viewBox="0 0 24 24" class="rs-evt-confirm-check-svg" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" stroke="#10b981" stroke-width="2"/>
                    <path d="M7.5 12l3 3 6-6"/>
                </svg>
            </div>
            <h3 class="rs-evt-confirm-title">Registration Confirmed!</h3>
            <p class="rs-evt-confirm-greeting" id="rs-evt-confirm-greeting">Namaste,</p>
            <p class="rs-evt-confirm-desc">Your seat for this event has been reserved. Thank you for registering!</p>

            <div class="rs-evt-confirm-summary-box">
                <div class="rs-evt-confirm-summary-row">
                    <span class="rs-evt-confirm-summary-label">Event:</span>
                    <span class="rs-evt-confirm-summary-val" id="rs-evt-conf-title">Special Event</span>
                </div>
                <div class="rs-evt-confirm-summary-row">
                    <span class="rs-evt-confirm-summary-label">Date &amp; Time:</span>
                    <span class="rs-evt-confirm-summary-val" id="rs-evt-conf-datetime">-</span>
                </div>
                <div class="rs-evt-confirm-summary-row">
                    <span class="rs-evt-confirm-summary-label">Venue / Center:</span>
                    <span class="rs-evt-confirm-summary-val" id="rs-evt-conf-venue">-</span>
                </div>
                <div class="rs-evt-confirm-summary-row">
                    <span class="rs-evt-confirm-summary-label">Participant:</span>
                    <span class="rs-evt-confirm-summary-val" id="rs-evt-conf-name">-</span>
                </div>
                <div class="rs-evt-confirm-summary-row" id="rs-evt-conf-ref-row">
                    <span class="rs-evt-confirm-summary-label">Reference ID:</span>
                    <span class="rs-evt-confirm-summary-val" id="rs-evt-conf-ref" style="color:#0369a1; font-family:monospace;">#RY-EVT</span>
                </div>
            </div>

            <div class="rs-evt-confirm-next-steps">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>Reporting time and tournament/session instructions will be communicated via WhatsApp / SMS prior to the event.</span>
            </div>

            <div class="rs-evt-confirm-actions">
                <button type="button" class="rs-evt-confirm-done-btn" id="rs-evt-confirm-done-btn">Done / Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JSON Data Embeds for Interactive JS -->
<script id="rs-events-data" type="application/json">
<?php echo wp_json_encode( $events_dataset ); ?>
</script>
<script id="rs-news-data" type="application/json">
<?php echo wp_json_encode( $news_dataset ); ?>
</script>

<!-- ============================================================
     Vanilla JavaScript Logic for Filtering, Working Carousels & Modals
     ============================================================ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Initialization
    var eventsData = [];
    var newsData = [];
    try {
        eventsData = JSON.parse(document.getElementById('rs-events-data').textContent);
        newsData = JSON.parse(document.getElementById('rs-news-data').textContent);
    } catch (e) {
        console.error('Error parsing JSON datasets', e);
    }

    // Lookup Maps
    var eventsMap = {};
    eventsData.forEach(function (ev) { eventsMap[ev.id] = ev; });
    var newsMap = {};
    newsData.forEach(function (nw) { newsMap[nw.id] = nw; });

    // Elements
    var searchInput = document.getElementById('rs-events-search-input');
    var clearSearchBtn = document.getElementById('rs-events-clear-search');
    var categorySelect = document.getElementById('rs-filter-category');
    var monthSelect = document.getElementById('rs-filter-month');
    var resetBtn = document.getElementById('rs-filter-reset-btn');
    var triggerResetBtns = document.querySelectorAll('.rs-trigger-reset');
    var tabButtons = document.querySelectorAll('.rs-events-tab-btn');
    var countText = document.getElementById('rs-filter-count-text');

    var eventsSection = document.getElementById('events-section');
    var newsSection = document.getElementById('news-section');
    var eventCards = Array.prototype.slice.call(document.querySelectorAll('.rs-event-item-card'));
    var newsCards = Array.prototype.slice.call(document.querySelectorAll('.rs-news-item-card'));
    var eventsEmptyState = document.getElementById('events-empty-state');
    var newsEmptyState = document.getElementById('news-empty-state');

    // Filter State
    var activeFilterType = 'all'; // 'all', 'upcoming', 'past', 'news'

    // ============================================================
    // Filter Functionality
    // ============================================================
    function applyFilters() {
        var query = (searchInput.value || '').trim().toLowerCase();
        var selectedCat = categorySelect.value;
        var selectedMonth = monthSelect.value;

        // Show/hide clear search button
        if (query.length > 0) {
            clearSearchBtn.classList.add('is-visible');
        } else {
            clearSearchBtn.classList.remove('is-visible');
        }

        var visibleEvents = 0;
        var visibleNews = 0;

        // Filter Events Cards
        eventCards.forEach(function (card) {
            var cCategory = card.getAttribute('data-category') || '';
            var cTimeframe = card.getAttribute('data-timeframe') || '';
            var cSearch = card.getAttribute('data-search') || '';

            var matchesType = true;
            if (activeFilterType === 'news') matchesType = false;

            var matchesCategory = (selectedCat === 'all' || cCategory === selectedCat);
            var matchesMonth = (selectedMonth === 'all' || cTimeframe === selectedMonth);
            var matchesSearch = (!query || cSearch.indexOf(query) !== -1);

            var isVisible = matchesType && matchesCategory && matchesMonth && matchesSearch;
            card.hidden = !isVisible;
            if (isVisible) visibleEvents++;
        });

        // Filter News Cards
        newsCards.forEach(function (card) {
            var cCategory = card.getAttribute('data-category') || '';
            var cSearch = card.getAttribute('data-search') || '';

            var matchesType = true;
            if (activeFilterType === 'events') matchesType = false;

            var matchesCategory = (selectedCat === 'all' || cCategory === selectedCat);
            var matchesSearch = (!query || cSearch.indexOf(query) !== -1);

            var isVisible = matchesType && matchesCategory && matchesSearch;
            card.hidden = !isVisible;
            if (isVisible) visibleNews++;
        });

        // Show / hide sections based on active type
        if (activeFilterType === 'news') {
            eventsSection.style.display = 'none';
            newsSection.style.display = 'block';
        } else if (activeFilterType === 'events') {
            eventsSection.style.display = 'block';
            newsSection.style.display = 'none';
        } else {
            eventsSection.style.display = 'block';
            newsSection.style.display = 'block';
        }

        // Empty states
        if (visibleEvents === 0 && eventsSection.style.display !== 'none') {
            eventsEmptyState.classList.add('is-visible');
        } else {
            eventsEmptyState.classList.remove('is-visible');
        }

        if (visibleNews === 0 && newsSection.style.display !== 'none') {
            newsEmptyState.classList.add('is-visible');
        } else {
            newsEmptyState.classList.remove('is-visible');
        }

        // Counter message
        countText.textContent = 'Showing ' + visibleEvents + ' Event' + (visibleEvents === 1 ? '' : 's') + ' & ' + visibleNews + ' Article' + (visibleNews === 1 ? '' : 's');

        // Re-evaluate carousels
        updateCarouselControls('events');
        updateCarouselControls('news');
    }

    // Tab buttons event
    tabButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            tabButtons.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            activeFilterType = btn.getAttribute('data-filter-type');
            applyFilters();
        });
    });

    // Inputs events
    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (categorySelect) categorySelect.addEventListener('change', applyFilters);
    if (monthSelect) monthSelect.addEventListener('change', applyFilters);

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function () {
            searchInput.value = '';
            applyFilters();
            searchInput.focus();
        });
    }

    function resetAllFilters() {
        if (searchInput) searchInput.value = '';
        if (categorySelect) categorySelect.value = 'all';
        if (monthSelect) monthSelect.value = 'all';
        activeFilterType = 'all';
        tabButtons.forEach(function (b) {
            b.classList.toggle('is-active', b.getAttribute('data-filter-type') === 'all');
        });
        applyFilters();
    }

    if (resetBtn) resetBtn.addEventListener('click', resetAllFilters);
    triggerResetBtns.forEach(function (btn) { btn.addEventListener('click', resetAllFilters); });

    // ============================================================
    // Working Carousel Controllers with Side Left & Right Arrows
    // ============================================================
    function setupCarousel(type) {
        var track = document.getElementById(type + '-carousel-track');
        var prevBtn = document.getElementById(type + '-btn-prev');
        var nextBtn = document.getElementById(type + '-btn-next');
        var dotsContainer = document.getElementById(type + '-carousel-dots');
        var statusLabel = document.getElementById(type + '-carousel-status');
        var stage = document.getElementById(type + '-carousel-stage');
        var toggleBtn = document.getElementById('rs-' + type + '-view-toggle');

        if (!track || !prevBtn || !nextBtn) return;

        function getStepWidth() {
            var firstVisible = track.querySelector('article:not([hidden])');
            if (firstVisible) {
                var style = window.getComputedStyle(track);
                var gap = parseFloat(style.gap || style.gridGap || '24') || 24;
                return firstVisible.getBoundingClientRect().width + gap;
            }
            return 360;
        }

        function getVisibleCards() {
            return track.querySelectorAll('article:not([hidden])');
        }

        function updateState() {
            if (stage.classList.contains('is-grid')) {
                prevBtn.disabled = true;
                nextBtn.disabled = true;
                if (statusLabel) statusLabel.textContent = 'All items displayed in Grid view';
                return;
            }

            var scrollLeft = track.scrollLeft;
            var maxScroll = Math.max(0, track.scrollWidth - track.clientWidth - 5);
            var isAtStart = scrollLeft <= 5;
            var isAtEnd = scrollLeft >= maxScroll;

            prevBtn.disabled = isAtStart;
            nextBtn.disabled = isAtEnd;

            // Update Dots
            var cards = getVisibleCards();
            var step = getStepWidth();
            var pageIndex = Math.round(scrollLeft / (step * 2)) || 0;
            var totalPages = Math.max(1, Math.ceil(cards.length / 2));

            if (dotsContainer) {
                dotsContainer.innerHTML = '';
                for (var i = 0; i < totalPages; i++) {
                    var dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'rs-carousel-dot' + (i === pageIndex ? ' is-active' : '');
                    dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                    (function (idx) {
                        dot.addEventListener('click', function () {
                            track.scrollTo({ left: idx * step * 2, behavior: 'smooth' });
                        });
                    })(i);
                    dotsContainer.appendChild(dot);
                }
            }

            if (statusLabel) {
                statusLabel.textContent = 'Slide ' + (pageIndex + 1) + ' of ' + totalPages;
            }
        }

        prevBtn.addEventListener('click', function () {
            var step = getStepWidth();
            track.scrollBy({ left: -step * 1.5, behavior: 'smooth' });
            setTimeout(updateState, 350);
        });

        nextBtn.addEventListener('click', function () {
            var step = getStepWidth();
            track.scrollBy({ left: step * 1.5, behavior: 'smooth' });
            setTimeout(updateState, 350);
        });

        track.addEventListener('scroll', function () {
            window.requestAnimationFrame(updateState);
        }, { passive: true });

        // Grid View Toggle
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                var isGrid = stage.classList.toggle('is-grid');
                toggleBtn.setAttribute('aria-expanded', String(isGrid));
                var textSpan = toggleBtn.querySelector('.toggle-text');
                if (textSpan) {
                    textSpan.textContent = isGrid ? 'View as Carousel' : ('View All ' + (type === 'events' ? 'Events' : 'News') + ' in Grid');
                }
                var iconSpan = toggleBtn.querySelector('span:last-child');
                if (iconSpan) iconSpan.textContent = isGrid ? '?' : '?';
                updateState();
            });
        }

        // Initial update
        setTimeout(updateState, 100);
    }

    function updateCarouselControls(type) {
        var track = document.getElementById(type + '-carousel-track');
        var prevBtn = document.getElementById(type + '-btn-prev');
        var nextBtn = document.getElementById(type + '-btn-next');
        if (track && prevBtn && nextBtn) {
            var maxScroll = Math.max(0, track.scrollWidth - track.clientWidth - 5);
            prevBtn.disabled = track.scrollLeft <= 5;
            nextBtn.disabled = track.scrollLeft >= maxScroll;
        }
    }

    setupCarousel('events');
    setupCarousel('news');

    // ============================================================
    // Event Details Big Modal Controller (Activities Style)
    // ============================================================
    var eventModal = document.getElementById('rs-event-detail-modal');
    var eventImg = document.getElementById('rs-big-event-img');
    var eventBannerWrap = document.getElementById('rs-big-event-banner-wrap');
    var eventTitle = document.getElementById('rs-big-event-title');
    var eventCategory = document.getElementById('rs-big-event-category');
    var eventDate = document.getElementById('rs-big-event-date');
    var eventTime = document.getElementById('rs-big-event-time');
    var eventVenue = document.getElementById('rs-big-event-venue');
    var eventContent = document.getElementById('rs-big-event-content');

    function openEventDetailModal(eventId) {
        var ev = eventsMap[eventId];
        if (!ev || !eventModal) return;

        if (ev.image && eventImg) {
            eventImg.src = ev.image;
            eventImg.alt = ev.title;
            if (eventBannerWrap) eventBannerWrap.style.display = 'block';
        } else if (eventBannerWrap) {
            eventBannerWrap.style.display = 'none';
        }

        if (eventCategory) eventCategory.textContent = (ev.category || 'SPECIAL EVENT').toUpperCase();
        if (eventTitle) eventTitle.textContent = ev.title;
        if (eventDate) eventDate.textContent = ev.day + ' ' + ev.month + ' ' + ev.year;
        if (eventTime) eventTime.textContent = ev.time;
        if (eventVenue) eventVenue.textContent = ev.venue;
        if (eventContent) {
            eventContent.innerHTML = ev.full_text || ('<p>' + (ev.desc || '') + '</p>');
        }

        var regWrap = document.getElementById('rs-modal-reg-action-wrap');
        var headerRegWrap = document.getElementById('rs-modal-header-reg-wrap');
        var isClosed = (ev.registration_status === 'closed');

        if (isClosed) {
            if (regWrap) regWrap.innerHTML = '<span class="rs-modal-closed-btn" aria-label="Registration is closed">Closed</span>';
            if (headerRegWrap) headerRegWrap.innerHTML = '<span class="rs-card-closed-pill" aria-label="Registration is closed">Closed</span>';
        } else {
            var safeTitle = (ev.title || '').replace(/"/g, '&quot;');
            var regBtnHtml = '<button type="button" class="rs-modal-register-btn rs-open-register-modal" data-event-id="' + ev.id + '" data-event-title="' + safeTitle + '"><span>Register Now</span> <span aria-hidden="true">&rarr;</span></button>';
            var headerRegHtml = '<button type="button" class="rs-card-register-btn rs-open-register-modal" data-event-id="' + ev.id + '" data-event-title="' + safeTitle + '"><span>Register Now</span> <span aria-hidden="true">&rarr;</span></button>';
            if (regWrap) regWrap.innerHTML = regBtnHtml;
            if (headerRegWrap) headerRegWrap.innerHTML = headerRegHtml;
        }

        // Attach click listener for newly injected register buttons inside the modal
        if (regWrap) {
            var rBtn = regWrap.querySelector('.rs-open-register-modal');
            if (rBtn) {
                rBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openRegisterModal(ev.id);
                });
            }
        }
        if (headerRegWrap) {
            var hrBtn = headerRegWrap.querySelector('.rs-open-register-modal');
            if (hrBtn) {
                hrBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openRegisterModal(ev.id);
                });
            }
        }

        eventModal.classList.add('is-active');
        eventModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeEventDetailModal() {
        if (!eventModal) return;
        eventModal.classList.remove('is-active');
        eventModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // ============================================================
    // Registration Modal Controller
    // ============================================================
    var regModal = document.getElementById('rs-registration-modal');
    var regForm = document.getElementById('rs-event-reg-form');
    var regSuccess = document.getElementById('rs-reg-success-msg');
    var regSubmitBtn = document.getElementById('rs-reg-submit-btn');
    var regConfirmCard = document.getElementById('rs-event-confirm-card');
    var regDoneBtn = document.getElementById('rs-evt-confirm-done-btn');

    function openRegisterModal(eventId) {
        var ev = eventsMap[eventId];
        if (!ev || !regModal) return;

        var titleEl = document.getElementById('rs-reg-modal-title');
        var dateEl = document.getElementById('rs-reg-modal-date-text');
        var timeEl = document.getElementById('rs-reg-modal-time-text');
        var venueEl = document.getElementById('rs-reg-modal-venue-text');
        var hiddenIdEl = document.getElementById('rs-reg-event-id');

        if (titleEl) titleEl.textContent = 'Register: ' + ev.title;
        if (dateEl) dateEl.textContent = ev.day + ' ' + ev.month + ' ' + ev.year;
        if (timeEl) timeEl.textContent = ev.time;
        if (venueEl) venueEl.textContent = ev.venue;
        if (hiddenIdEl) hiddenIdEl.value = ev.id;

        if (regConfirmCard) regConfirmCard.style.display = 'none';
        if (regForm) {
            regForm.style.display = 'block';
            regForm.reset();
        }
        if (regSuccess) regSuccess.style.display = 'none';
        var errorEl = document.getElementById('rs-reg-error-msg');
        if (errorEl) { errorEl.style.display = 'none'; errorEl.textContent = ''; }

        if (regSubmitBtn) {
            regSubmitBtn.disabled = false;
            regSubmitBtn.innerHTML = '<span>Confirm Registration &rarr;</span>';
        }

        regModal.classList.add('is-active');
        regModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeRegisterModal() {
        if (!regModal) return;
        regModal.classList.remove('is-active');
        regModal.setAttribute('aria-hidden', 'true');
        if (regConfirmCard) regConfirmCard.style.display = 'none';
        if (regForm) regForm.style.display = 'block';
        // Only restore body overflow if event detail modal is not active
        if (!eventModal || !eventModal.classList.contains('is-active')) {
            document.body.style.overflow = '';
        }
    }

    if (regDoneBtn) {
        regDoneBtn.addEventListener('click', closeRegisterModal);
    }

    // Attach card footer Register Now click listeners
    document.querySelectorAll('.rs-card-register-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var eventId = btn.getAttribute('data-event-id');
            openRegisterModal(eventId);
        });
    });

    // Close registration modal listeners
    document.querySelectorAll('[data-close-reg-modal="true"]').forEach(function (el) {
        el.addEventListener('click', function () {
            closeRegisterModal();
        });
    });

    // Registration form submission handler
    if (regForm) {
        regForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var errorEl = document.getElementById('rs-reg-error-msg');
            if (errorEl) {
                errorEl.style.display = 'none';
                errorEl.textContent = '';
            }
            if (regSuccess) regSuccess.style.display = 'none';

            var eventId = document.getElementById('rs-reg-event-id') ? document.getElementById('rs-reg-event-id').value : '';
            var nameVal = document.getElementById('rs-reg-name') ? document.getElementById('rs-reg-name').value.trim() : '';
            var phoneVal = document.getElementById('rs-reg-phone') ? document.getElementById('rs-reg-phone').value.trim() : '';
            var emailVal = document.getElementById('rs-reg-email') ? document.getElementById('rs-reg-email').value.trim() : '';
            var centerVal = document.getElementById('rs-reg-center') ? document.getElementById('rs-reg-center').value : '';
            var nonceEl = document.getElementById('rs_event_reg_nonce');
            var nonceVal = nonceEl ? nonceEl.value : '';

            if (!nameVal || !phoneVal || !eventId) {
                if (errorEl) {
                    errorEl.textContent = 'Please fill all required fields.';
                    errorEl.style.display = 'block';
                }
                return;
            }

            if (regSubmitBtn) {
                regSubmitBtn.disabled = true;
                regSubmitBtn.innerHTML = '<span>Submitting Registration...</span>';
            }

            var formData = new FormData();
            formData.append('action', 'rs_submit_event_registration');
            formData.append('nonce', nonceVal);
            formData.append('event_id', eventId);
            formData.append('name', nameVal);
            formData.append('phone', phoneVal);
            formData.append('email', emailVal);
            formData.append('center', centerVal);

            var ajaxUrl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function (res) { return res.json(); })
            .then(function (result) {
                if (regSubmitBtn) {
                    regSubmitBtn.disabled = false;
                    regSubmitBtn.innerHTML = '<span>Confirm Registration &rarr;</span>';
                }

                if (result.success) {
                    var ev = eventsMap[eventId];
                    regForm.style.display = 'none';
                    if (regConfirmCard) {
                        var confGreet = document.getElementById('rs-evt-confirm-greeting');
                        if (confGreet) confGreet.textContent = 'Namaste, ' + (nameVal || 'Participant') + '!';
                        var confTitle = document.getElementById('rs-evt-conf-title');
                        if (confTitle) confTitle.textContent = ev ? ev.title : 'Special Event';
                        var confDt = document.getElementById('rs-evt-conf-datetime');
                        if (confDt) confDt.textContent = (ev ? ev.day + ' ' + ev.month + ' ' + ev.year : '') + (ev && ev.time ? ' • ' + ev.time : '');
                        var confVenue = document.getElementById('rs-evt-conf-venue');
                        var vText = (ev ? ev.venue : '');
                        if (centerVal && centerVal !== 'Other') {
                            vText = centerVal + (vText ? ' (' + vText + ')' : '');
                        }
                        if (confVenue) confVenue.textContent = vText || 'Rashtrotthana Center';
                        var confName = document.getElementById('rs-evt-conf-name');
                        if (confName) confName.textContent = nameVal + (phoneVal ? ' • ' + phoneVal : '');
                        var confRef = document.getElementById('rs-evt-conf-ref');
                        var refId = (result.data && (result.data.registration_id || result.data.inquiry_id)) ? (result.data.registration_id || result.data.inquiry_id) : '';
                        if (confRef) confRef.textContent = refId ? '#RY-EVT-' + refId : '#RY-EVT';

                        regConfirmCard.style.display = 'block';
                    }
                    regForm.reset();
                } else {
                    if (errorEl) {
                        errorEl.textContent = (result.data && result.data.message) ? result.data.message : 'Registration failed. Please try again.';
                        errorEl.style.display = 'block';
                    }
                }
            })
            .catch(function (err) {
                if (regSubmitBtn) {
                    regSubmitBtn.disabled = false;
                    regSubmitBtn.innerHTML = '<span>Confirm Registration &rarr;</span>';
                }
                if (errorEl) {
                    errorEl.textContent = 'Network or server error. Please try again.';
                    errorEl.style.display = 'block';
            });
        });
    }

    // Bind event detail click (both the button and entire card)
    document.querySelectorAll('.rs-open-event-modal').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var eventId = btn.getAttribute('data-event-id');
            openEventDetailModal(eventId);
        });
    });

    document.querySelectorAll('.rs-event-item-card').forEach(function (card) {
        card.addEventListener('click', function (e) {
            if (e.target.closest('a') || e.target.closest('button')) return;
            var eventId = card.getAttribute('data-event-id') || card.id;
            openEventDetailModal(eventId);
        });
        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                var eventId = card.getAttribute('data-event-id') || card.id;
                openEventDetailModal(eventId);
            }
        });
    });

    // ============================================================
    // Article Preview Big Modal Controller (Activities Style)
    // ============================================================
    var articleModal = document.getElementById('rs-article-modal');
    var articleImg = document.getElementById('rs-article-modal-img');
    var articleBannerWrap = document.getElementById('rs-article-modal-banner-wrap');
    var articleTitle = document.getElementById('rs-article-modal-title');
    var articleCategory = document.getElementById('rs-article-modal-category');
    var articleDate = document.getElementById('rs-article-modal-date');
    var articleReadTime = document.getElementById('rs-article-modal-readtime');
    var articleContent = document.getElementById('rs-article-modal-content');

    function openArticleModal(newsId) {
        var nw = newsMap[newsId];
        if (!nw || !articleModal) return;

        if (nw.image && articleImg) {
            articleImg.src = nw.image;
            articleImg.alt = nw.title;
            if (articleBannerWrap) articleBannerWrap.style.display = 'block';
        } else if (articleBannerWrap) {
            articleBannerWrap.style.display = 'none';
        }

        if (articleCategory) articleCategory.textContent = (nw.category || 'NEWS').toUpperCase();
        if (articleTitle) articleTitle.textContent = nw.title;
        if (articleDate) articleDate.textContent = nw.date;
        if (articleReadTime) articleReadTime.textContent = nw.read_time;
        if (articleContent) {
            articleContent.innerHTML = nw.full_text || ('<p>' + (nw.excerpt || '') + '</p>');
        }

        articleModal.classList.add('is-active');
        articleModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeArticleModal() {
        if (!articleModal) return;
        articleModal.classList.remove('is-active');
        articleModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.rs-open-article-modal').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var newsId = btn.getAttribute('data-news-id');
            openArticleModal(newsId);
        });
    });

    document.querySelectorAll('.rs-news-item-card').forEach(function (card) {
        card.addEventListener('click', function (e) {
            if (e.target.closest('a') || e.target.closest('button')) return;
            var newsId = card.getAttribute('data-news-id') || card.id;
            openArticleModal(newsId);
        });
        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                var newsId = card.getAttribute('data-news-id') || card.id;
                openArticleModal(newsId);
            }
        });
    });

    // Close Modals on Backdrop or Close Button Click
    document.querySelectorAll('[data-close-modal="true"]').forEach(function (el) {
        el.addEventListener('click', function () {
            closeEventDetailModal();
            closeArticleModal();
        });
    });

    // Close on Escape key
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (regModal && regModal.classList.contains('is-active')) {
                closeRegisterModal();
            } else {
                closeEventDetailModal();
                closeArticleModal();
            }
        }
    });
});
</script>

<?php get_footer(); ?>
