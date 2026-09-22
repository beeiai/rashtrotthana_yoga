<?php
/**
 * Template Name: Events Page
 * Template for displaying Events & News with matching Home/Activities/Centers design system.
 */
get_header();
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
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>") center top / cover fixed no-repeat !important;
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

/* Card Footer: Strictly Identical Buttons & No Register Button for Completed Events */
.rs-event-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .6rem;
    margin-top: auto;
    padding-top: .9rem;
    border-top: 1px solid rgba(143, 23, 29, .1);
    min-height: 54px;
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

/* Register Now Button (Same Size, Single Line, No Wrapping) */
.rs-register-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: .4rem !important;
    width: 140px !important;
    min-width: 140px !important;
    height: 2.55rem !important;
    padding: 0 1rem !important;
    border: 1px solid #B31B1B !important;
    border-radius: 999px !important;
    background: #B31B1B !important;
    box-shadow: 0 8px 20px rgba(179, 27, 27, .28), inset 0 1px 0 rgba(255, 255, 255, .42) !important;
    color: #fff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: .84rem !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    text-shadow: 0 1px 0 rgba(0, 0, 0, .16) !important;
    cursor: pointer !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
    box-sizing: border-box !important;
    transition: transform 180ms ease, box-shadow 180ms ease, background-color 180ms ease !important;
}

.rs-register-btn:hover {
    transform: translateY(-2px) !important;
    background: #8F171D !important;
    box-shadow: 0 12px 26px rgba(179, 27, 27, .38), 0 0 18px rgba(243, 106, 33, .25), inset 0 1px 0 #fff !important;
    color: #fff !important;
}

/* Badge for Completed Events (No Register Button) */
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
    min-height: 480px;
    box-sizing: border-box;
    border: 1px solid rgba(143, 23, 29, .13) !important;
    border-radius: 1.25rem;
    background: rgba(255, 253, 249, .75);
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    overflow: hidden;
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), box-shadow 260ms ease, border-color 260ms ease;
}

.rs-news-item-card:hover {
    transform: translateY(-7px);
    border-color: rgba(249, 183, 42, .68) !important;
    box-shadow: 0 24px 44px rgba(89, 37, 24, .16), inset 0 1px 0 #fff;
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
    transition: transform 450ms cubic-bezier(.2,.8,.2,1);
}

.rs-news-item-card:hover .rs-news-media img {
    transform: scale(1.08);
}

.rs-news-category-badge {
    position: absolute;
    top: .9rem;
    left: .9rem;
    z-index: 2;
    padding: .35rem .8rem;
    border-radius: 999px;
    background: var(--color-maroon);
    box-shadow: 0 4px 12px rgba(143, 23, 29, .3);
    color: #fff;
    font-size: .72rem;
    font-weight: 700;
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
    align-items: center;
    gap: .75rem;
    height: 22px;
    min-height: 22px;
    margin-bottom: .65rem;
    color: #795c4b;
    font-size: .8rem;
    font-weight: 500;
}

.rs-news-meta-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--color-saffron);
}

.rs-news-title {
    margin: 0 0 .75rem;
    color: #542019;
    font-size: 1.16rem;
    font-weight: 700;
    line-height: 1.35;
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
    margin: 0 0 1.25rem;
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
    margin-top: auto;
    min-height: 38px;
    display: flex;
    align-items: center;
}

.rs-news-read-link {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    color: var(--color-maroon);
    font-size: .86rem;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
    font-family: inherit;
    transition: gap 180ms ease, color 180ms ease;
}

.rs-news-read-link:hover {
    gap: .75rem;
    color: var(--color-saffron);
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

/* ============================================================
   Article Read Preview Modal
   ============================================================ */
.rs-article-modal-card {
    max-width: 660px;
}

.rs-article-modal-media {
    width: 100%;
    height: 240px;
    border-radius: 1rem;
    overflow: hidden;
    margin-bottom: 1.25rem;
}

.rs-article-modal-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rs-article-modal-body p {
    color: #67574c;
    font-size: .95rem;
    line-height: 1.7;
    margin-bottom: 1rem;
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

<div class="rs-events-notice" style="background: #e0f2fe; border: 1px solid #bae6fd; padding: 15px 20px; text-align: center; color: #0369a1; font-weight: 500;">
   Looking to register for a current event or camp? <a href="/ongoing-registrations/" style="color: #0284c7; text-decoration: underline; font-weight: 600;">Click here to view open registrations</a>.
</div>

    <!-- ============================================================
         Refined Header Block (Zero Hero Banner — Activities/Centers Style)
         ============================================================ -->
    <section class="rs-events-header-section" aria-labelledby="events-page-heading">
        <div class="rs-container">
            <div class="rs-events-title-block">
                <div class="rs-events-eyebrow">
                    <span class="rs-events-eyebrow-dot" aria-hidden="true"></span>
                    <span>COMMUNITY &amp; CELEBRATIONS</span>
                </div>
                <h1 id="events-page-heading" class="rs-events-page-title">Events &amp; <em>News</em></h1>
                <p class="rs-events-page-subtitle">
                    Experience transformative yoga celebrations, skill-building workshops, and inspiring community stories across our 23+ Bengaluru centers. Find your next milestone below.
                </p>

                <!-- Quick Highlights Stat Bar (Small icons removed per user request) -->
                <div class="rs-events-stats-bar" aria-label="Events overview">
                    <div class="rs-events-stat-pill">
                        <strong><?php echo count($events_dataset); ?>+</strong>
                        <span>Scheduled Events</span>
                    </div>
                    <div class="rs-events-stat-pill">
                        <strong>23+</strong>
                        <span>Bengaluru Centers</span>
                    </div>
                    <div class="rs-events-stat-pill">
                        <strong>10,000+</strong>
                        <span>Active Participants</span>
                    </div>
                    <div class="rs-events-stat-pill">
                        <strong><?php echo count($news_dataset); ?></strong>
                        <span>Fresh Insights</span>
                    </div>
                </div>
            </div>

            <!-- ============================================================
                 Control Bar: Live Search, Tabs & Multi-Filters
                 ============================================================ -->
            <div class="rs-events-control-card" role="search" aria-label="Event and news filters">
                <div class="rs-events-filter-row">
                    <!-- Segmented Navigation Tabs -->
                    <nav class="rs-events-nav-tabs" aria-label="Filter by type">
                        <button type="button" class="rs-events-tab-btn is-active" data-filter-type="all">All Items</button>
                        <button type="button" class="rs-events-tab-btn" data-filter-type="upcoming">Upcoming Events</button>
                        <button type="button" class="rs-events-tab-btn" data-filter-type="past">Past Events</button>
                        <button type="button" class="rs-events-tab-btn" data-filter-type="news">News &amp; Articles</button>
                    </nav>

                    <!-- Real-Time Search Box -->
                    <div class="rs-events-search-box">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="search" id="rs-events-search-input" placeholder="Search events, workshops, centers, or news..." aria-label="Search events and news" autocomplete="off">
                        <button type="button" id="rs-events-clear-search" class="rs-events-search-clear" aria-label="Clear search">✕</button>
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
                        Showing <?php echo count($events_dataset); ?> Events &amp; <?php echo count($news_dataset); ?> Articles
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         Upcoming Events Section (Equal Cards + Side Arrow Carousel)
         ============================================================ -->
    <section class="rs-events-section" id="events-section" aria-labelledby="events-section-title">
        <div class="rs-container">
            <div class="rs-events-section-header">
                <div>
                    <h2 id="events-section-title">Upcoming Events &amp; Programs</h2>
                    <p class="rs-events-section-desc">
                        Participate in inspiring gatherings, therapeutic intensives, and weekend retreats guided by certified Rashtrotthana Gurus.
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
                                 data-type="<?php echo esc_attr( $event['type'] ); ?>"
                                 data-category="<?php echo esc_attr( $event['category_slug'] ); ?>"
                                 data-timeframe="<?php echo esc_attr( $event['timeframe'] ); ?>"
                                 data-title="<?php echo esc_attr( $event['title'] ); ?>"
                                 data-venue="<?php echo esc_attr( $event['venue'] ); ?>"
                                 data-date="<?php echo esc_attr( $event['day'] . ' ' . $event['month'] . ' ' . $event['year'] ); ?>"
                                 data-time="<?php echo esc_attr( $event['time'] ); ?>"
                                 data-fee="<?php echo esc_attr( $event['fee'] ); ?>"
                                 data-search="<?php echo esc_attr( strtolower( $event['title'] . ' ' . $event['venue'] . ' ' . $event['category'] . ' ' . $event['desc'] ) ); ?>">
                            
                            <div class="rs-event-media">
                                <img src="<?php echo esc_url( $event['image'] ); ?>" alt="<?php echo esc_attr( $event['title'] ); ?>" loading="lazy">
                                <div class="rs-event-date-badge">
                                    <strong><?php echo esc_html( $event['day'] ); ?></strong>
                                    <span><?php echo esc_html( $event['month'] ); ?></span>
                                </div>
                                <span class="rs-event-category-pill"><?php echo esc_html( $event['category'] ); ?></span>
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
                                    <span class="rs-event-mode-badge" title="<?php echo esc_attr( $event['mode'] ); ?>"><?php echo esc_html( $event['mode'] ); ?></span>
                                    
                                    <?php if ( $event['type'] !== 'past' ) : ?>
                                        <button type="button" class="rs-register-btn rs-open-register-modal" data-event-id="<?php echo esc_attr( $event['id'] ); ?>">
                                            <span>Register Now</span> <span aria-hidden="true">→</span>
                                        </button>
                                    <?php else : ?>
                                        <span class="rs-event-concluded-badge">Completed</span>
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
                <span class="empty-icon">🔍</span>
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
                                 data-category="<?php echo esc_attr( $article['category_slug'] ); ?>"
                                 data-title="<?php echo esc_attr( $article['title'] ); ?>"
                                 data-date="<?php echo esc_attr( $article['date'] ); ?>"
                                 data-search="<?php echo esc_attr( strtolower( $article['title'] . ' ' . $article['category'] . ' ' . $article['excerpt'] ) ); ?>">
                            
                            <div class="rs-news-media">
                                <img src="<?php echo esc_url( $article['image'] ); ?>" alt="<?php echo esc_attr( $article['title'] ); ?>" loading="lazy">
                                <span class="rs-news-category-badge"><?php echo esc_html( $article['category'] ); ?></span>
                            </div>

                            <div class="rs-news-body">
                                <div class="rs-news-meta">
                                    <span><?php echo esc_html( $article['date'] ); ?></span>
                                    <span class="rs-news-meta-dot" aria-hidden="true"></span>
                                    <span><?php echo esc_html( $article['read_time'] ); ?></span>
                                </div>

                                <h3 class="rs-news-title"><?php echo esc_html( $article['title'] ); ?></h3>
                                <p class="rs-news-excerpt"><?php echo esc_html( $article['excerpt'] ); ?></p>

                                <div class="rs-news-footer">
                                    <button type="button" class="rs-news-read-link rs-open-article-modal" data-news-id="<?php echo esc_attr( $article['id'] ); ?>">
                                        <span>Read Full Article</span> <span aria-hidden="true">→</span>
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
                <span class="empty-icon">📰</span>
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

    <!-- ============================================================
         Stay Informed Newsletter Banner (Home & Centers Style)
         ============================================================ -->
    <section class="rs-events-subscribe-section" aria-label="Newsletter Subscription">
        <div class="rs-container">
            <div class="rs-events-newsletter-card">
                <div class="rs-events-newsletter-content">
                    <div class="rs-events-newsletter-icon" aria-hidden="true">✉</div>
                    <div class="rs-events-newsletter-text">
                        <h3>Stay Informed. Stay Inspired.</h3>
                        <p>Subscribe to our monthly newsletter and never miss an update on upcoming yoga celebrations, health workshops, and inspiring community programs.</p>
                    </div>
                </div>

                <form class="rs-events-newsletter-form" id="rs-newsletter-form">
                    <label for="rs-newsletter-email" class="screen-reader-text" style="position:absolute;width:1px;height:1px;overflow:hidden;">Email Address</label>
                    <input type="email" id="rs-newsletter-email" placeholder="Enter your email address..." required autocomplete="email">
                    <button type="submit">
                        <span>Subscribe</span> <span aria-hidden="true">→</span>
                    </button>
                    <div class="rs-newsletter-msg" id="rs-newsletter-status" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </section>

</main>

<!-- ============================================================
     Interactive "Register Now" Modal
     ============================================================ -->
<div id="rs-registration-modal" class="rs-event-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="rs-modal-event-title">
    <div class="rs-event-modal-backdrop" data-close-modal="true"></div>
    <div class="rs-event-modal-card">
        <button type="button" class="rs-modal-close-btn" aria-label="Close registration dialog" data-close-modal="true">✕</button>
        
        <div class="rs-modal-header">
            <span class="rs-modal-badge" id="rs-modal-category-text">Special Event</span>
            <h2 class="rs-modal-title" id="rs-modal-event-title">Event Title</h2>
            <div class="rs-modal-event-details">
                <span>
                    <svg class="rs-modal-detail-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span id="rs-modal-date-text">Date</span>
                </span>
                <span>
                    <svg class="rs-modal-detail-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span id="rs-modal-time-text">Time</span>
                </span>
                <span>
                    <svg class="rs-modal-detail-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span id="rs-modal-venue-text">Venue</span>
                </span>
            </div>
        </div>

        <form class="rs-modal-form" id="rs-event-registration-form">
            <input type="hidden" id="rs-modal-hidden-event-id" name="event_id">

            <div class="rs-modal-field">
                <label for="reg-full-name">Your Full Name *</label>
                <input type="text" id="reg-full-name" required placeholder="e.g. Anand Sharma">
            </div>

            <div class="rs-modal-row">
                <div class="rs-modal-field">
                    <label for="reg-age">Age *</label>
                    <input type="number" id="reg-age" name="age" required min="5" max="120" placeholder="e.g. 28">
                </div>
                <div class="rs-modal-field">
                    <label for="reg-gender">Gender *</label>
                    <select id="reg-gender" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="rs-modal-field">
                <label for="reg-phone-number">Mobile / WhatsApp Number *</label>
                <input type="tel" id="reg-phone-number" required placeholder="e.g. 98765 43210">
            </div>

            <div class="rs-modal-field">
                <label for="reg-email-address">Email Address *</label>
                <input type="email" id="reg-email-address" required placeholder="e.g. anand@example.com">
            </div>

            <div class="rs-modal-field">
                <label for="reg-center-preference">Preferred Rashtrotthana Center</label>
                <select id="reg-center-preference">
                    <option value="jayanagar">Jayanagar Center</option>
                    <option value="basavanagudi">Basavanagudi Center</option>
                    <option value="malleswaram">Malleswaram Center</option>
                    <option value="yelahanka">Yelahanka Center</option>
                    <option value="whitefield">Whitefield Center</option>
                    <option value="jpnagar">JP Nagar Center</option>
                    <option value="online">Online / Hybrid Batch</option>
                </select>
            </div>

            <button type="submit" class="rs-modal-submit-btn" id="rs-submit-reg-btn">
                Confirm Registration →
            </button>
            <div class="rs-modal-success-alert" id="rs-modal-reg-success" aria-live="polite">
                ✓ Thank you! Your registration has been received. Our center team will contact you with program batch guidelines shortly.
            </div>
        </form>
    </div>
</div>

<!-- ============================================================
     Interactive "Read Article" Preview Modal
     ============================================================ -->
<div id="rs-article-modal" class="rs-event-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="rs-article-modal-title">
    <div class="rs-event-modal-backdrop" data-close-modal="true"></div>
    <div class="rs-event-modal-card rs-article-modal-card">
        <button type="button" class="rs-modal-close-btn" aria-label="Close article dialog" data-close-modal="true">✕</button>
        
        <div class="rs-article-modal-media">
            <img id="rs-article-modal-img" src="" alt="">
        </div>

        <div class="rs-modal-header">
            <span class="rs-modal-badge" id="rs-article-modal-category">News</span>
            <h2 class="rs-modal-title" id="rs-article-modal-title">Article Title</h2>
            <div class="rs-modal-event-details">
                <span>
                    <svg class="rs-modal-detail-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span id="rs-article-modal-date">May 20, 2026</span>
                </span>
                <span>•</span>
                <span>Rashtrotthana Editorial</span>
            </div>
        </div>

        <div class="rs-article-modal-body" id="rs-article-modal-content">
            <!-- Injected via JavaScript -->
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
            var cType = card.getAttribute('data-type') || '';
            var cCategory = card.getAttribute('data-category') || '';
            var cTimeframe = card.getAttribute('data-timeframe') || '';
            var cSearch = card.getAttribute('data-search') || '';

            var matchesType = true;
            if (activeFilterType === 'upcoming') matchesType = (cType === 'upcoming');
            else if (activeFilterType === 'past') matchesType = (cType === 'past');
            else if (activeFilterType === 'news') matchesType = false; // Hide events when news tab active

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
            if (activeFilterType === 'upcoming' || activeFilterType === 'past') {
                matchesType = false; // Hide news when specific event tab active
            }

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
        } else if (activeFilterType === 'upcoming' || activeFilterType === 'past') {
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
                if (iconSpan) iconSpan.textContent = isGrid ? '⇄' : '⊞';
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
    // Registration Modal Controller (For active events only)
    // ============================================================
    var regModal = document.getElementById('rs-registration-modal');
    var regForm = document.getElementById('rs-event-registration-form');
    var regSuccessAlert = document.getElementById('rs-modal-reg-success');
    var hiddenEventIdInput = document.getElementById('rs-modal-hidden-event-id');
    var modalEventTitle = document.getElementById('rs-modal-event-title');
    var modalDateText = document.getElementById('rs-modal-date-text');
    var modalTimeText = document.getElementById('rs-modal-time-text');
    var modalVenueText = document.getElementById('rs-modal-venue-text');
    var modalCategoryText = document.getElementById('rs-modal-category-text');

    function openRegModal(eventId) {
        var ev = eventsMap[eventId];
        if (!ev || ev.type === 'past') return;

        hiddenEventIdInput.value = ev.id;
        modalEventTitle.textContent = ev.title;
        modalDateText.textContent = ev.day + ' ' + ev.month + ' ' + ev.year;
        modalTimeText.textContent = ev.time;
        modalVenueText.textContent = ev.venue;
        modalCategoryText.textContent = ev.category + ' (' + ev.fee + ')';

        regForm.reset();
        regSuccessAlert.style.display = 'none';

        regModal.classList.add('is-active');
        regModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        var firstInput = regForm.querySelector('input[type="text"]');
        if (firstInput) firstInput.focus();
    }

    function closeRegModal() {
        regModal.classList.remove('is-active');
        regModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.rs-open-register-modal').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var eventId = btn.getAttribute('data-event-id');
            openRegModal(eventId);
        });
    });

    if (regForm) {
        regForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var submitBtn = document.getElementById('rs-submit-reg-btn');
            submitBtn.textContent = 'Registering...';
            submitBtn.disabled = true;

            setTimeout(function () {
                submitBtn.textContent = 'Registration Confirmed ✓';
                regSuccessAlert.style.display = 'block';
                setTimeout(function () {
                    closeRegModal();
                    submitBtn.textContent = 'Confirm Registration →';
                    submitBtn.disabled = false;
                }, 2200);
            }, 700);
        });
    }

    // ============================================================
    // Article Preview Modal Controller
    // ============================================================
    var articleModal = document.getElementById('rs-article-modal');
    var articleImg = document.getElementById('rs-article-modal-img');
    var articleTitle = document.getElementById('rs-article-modal-title');
    var articleCategory = document.getElementById('rs-article-modal-category');
    var articleDate = document.getElementById('rs-article-modal-date');
    var articleContent = document.getElementById('rs-article-modal-content');

    function openArticleModal(newsId) {
        var nw = newsMap[newsId];
        if (!nw) return;

        articleImg.src = nw.image;
        articleImg.alt = nw.title;
        articleTitle.textContent = nw.title;
        articleCategory.textContent = nw.category;
        articleDate.textContent = nw.date + ' (' + nw.read_time + ')';
        articleContent.innerHTML = '<p>' + nw.full_text + '</p><p>For inquiries, press coverage, or collaborations, contact the Rashtrotthana Media Cell at info@rashtrotthana.org.</p>';

        articleModal.classList.add('is-active');
        articleModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeArticleModal() {
        articleModal.classList.remove('is-active');
        articleModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.rs-open-article-modal').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var newsId = btn.getAttribute('data-news-id');
            openArticleModal(newsId);
        });
    });

    // Close Modals on Backdrop or Close Button Click
    document.querySelectorAll('[data-close-modal="true"]').forEach(function (el) {
        el.addEventListener('click', function () {
            closeRegModal();
            closeArticleModal();
        });
    });

    // Close on Escape key
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeRegModal();
            closeArticleModal();
        }
    });

    // ============================================================
    // Newsletter Form Handler
    // ============================================================
    var newsletterForm = document.getElementById('rs-newsletter-form');
    var newsletterStatus = document.getElementById('rs-newsletter-status');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var emailVal = document.getElementById('rs-newsletter-email').value;
            newsletterStatus.className = 'rs-newsletter-msg is-success';
            newsletterStatus.textContent = '✓ Subscribed! Welcome to Rashtrotthana community updates.';
            newsletterForm.reset();
            setTimeout(function () { newsletterStatus.style.display = 'none'; }, 4000);
        });
    }
});
</script>

<?php get_footer(); ?>
