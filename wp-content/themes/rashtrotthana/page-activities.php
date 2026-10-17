<?php
/**
 * Template Name: Activities Page
 * Description: Redesigned Activities page featuring 4 core pillars:
 *              Yoga, Gym, Karate, and Music & Dance.
 *              - Initial view shows only the 4 Category Cards.
 *              - Clicking a category reveals its sub-activities.
 *              - Comprehensive search bar & multi-dimensional filters (Center, Timing, Focus, Frequency).
 *              - Student registration modal with choice of center and AJAX database persistence.
 *              - 100% database driven.
 */

get_header();

// Fetch 4 Activity Categories dynamically from WordPress Database
$activity_categories = rs_get_activity_categories();

// Fetch all Centers dynamically from Database for the filter & registration dropdowns
$all_centers = rs_get_centers();

// Count total programs across all categories
$total_subactivities = 0;
foreach ( $activity_categories as $cat ) {
    $total_subactivities += count( $cat['items'] );
}
?>

<style>
/* ============================================================
   Rashtrotthana Activities Page — 4-Pillar Modern Design System
   Matches Home, Centers, Events & Gallery Pages
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
    --color-border: rgba(143, 23, 29, .14);
}

.rs-activities-page {
    position: relative;
    isolation: isolate;
    color: var(--color-text);
    font-family: 'Poppins', sans-serif !important;
    background: 
        linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/mandala-bg.jpg' ); ?>") center top / cover fixed no-repeat !important;
    animation: rs-nature-drift 24s ease-in-out infinite alternate;
    min-height: 100vh;
    padding-bottom: 5rem;
}

.rs-activities-page * {
    font-family: 'Poppins', sans-serif !important;
    box-sizing: border-box;
}

/* Ambient Floating Glow Orbs */
.rs-activities-page::before,
.rs-activities-page::after {
    position: absolute;
    z-index: -1;
    display: block;
    width: 28rem;
    height: 28rem;
    border-radius: 50%;
    content: "";
    filter: blur(16px);
    opacity: .75;
    pointer-events: none;
}

.rs-activities-page::before {
    top: 0; left: 0;
    width: 100%; height: 100%;
    border-radius: 0;
    background:
        radial-gradient(circle at 8% 8%, rgba(249, 183, 42, .18), transparent 28rem),
        radial-gradient(circle at 92% 16%, rgba(243, 106, 33, .14), transparent 32rem);
    filter: none;
    opacity: 1;
}

.rs-activities-page::after {
    top: 55rem; right: -15rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .24), transparent 68%);
    animation: rsa-atmosphere-pulse 5s ease-in-out infinite alternate;
}

@keyframes rs-nature-drift {
    0%   { background-position: center top, 48% top; }
    100% { background-position: center top, 52% top; }
}

@keyframes rsa-atmosphere-pulse {
    0%   { opacity: .28; transform: scale(.96); }
    100% { opacity: .6;  transform: scale(1.08); }
}

@media (prefers-reduced-motion: reduce) {
    .rs-activities-page { animation: none; }
    .rs-activities-page::after { animation: none; }
}

/* Container */
.rs-activities-page .rs-container {
    width: 100% !important;
    max-width: none !important;
    padding-inline: clamp(20px, 4vw, 64px) !important;
    margin-inline: auto !important;
    box-sizing: border-box;
    position: relative;
    z-index: 2;
}

/* ============================================================
   Page Header
   ============================================================ */
.rs-act-header-section {
    padding: 3.5rem 0 2.25rem;
    text-align: center;
}

.rs-act-title-block {
    max-width: 860px;
    margin: 0 auto;
}

.rs-act-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: .85rem;
    padding: .35rem .95rem;
    border: 1px solid rgba(143, 23, 29, .18);
    border-radius: 999px;
    background: rgba(255, 248, 236, .92);
    box-shadow: 0 4px 14px rgba(143, 23, 29, .06);
    color: var(--color-maroon);
    font-size: .82rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rs-act-eyebrow-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--color-saffron);
    box-shadow: 0 0 10px rgba(243, 106, 33, .8);
}

.rs-act-page-title {
    margin: 0 0 1rem;
    color: #542019;
    font-size: clamp(2.3rem, 4vw, 3.4rem);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -.02em;
}

.rs-act-page-title em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-act-page-subtitle {
    margin: 0 auto 1.5rem;
    max-width: 720px;
    color: #67574c;
    font-size: clamp(1rem, 1.25vw, 1.12rem);
    line-height: 1.65;
}

.rs-act-instruction-hint {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .45rem 1.1rem;
    background: rgba(243, 106, 33, .1);
    border: 1px dashed rgba(243, 106, 33, .35);
    border-radius: 999px;
    color: var(--color-maroon);
    font-size: .84rem;
    font-weight: 600;
}

/* ============================================================
   The 4 Core Pillar Cards Grid (Initial Primary View)
   ============================================================ */
.rs-pillars-section {
    margin-bottom: 2rem;
}

.rs-pillars-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.6rem;
}

.rs-pillar-card {
    position: relative;
    border-radius: 1.35rem;
    overflow: hidden;
    background: #fff;
    border: 2px solid rgba(143, 23, 29, .12);
    box-shadow: 0 10px 30px rgba(89, 37, 24, .08);
    display: flex;
    flex-direction: column;
    transition: all 260ms cubic-bezier(.16, 1, .3, 1);
    cursor: pointer;
    text-align: left;
}

.rs-pillar-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 45px rgba(89, 37, 24, .16);
    border-color: var(--color-maroon);
}

.rs-pillar-card.is-active-pillar {
    border-color: var(--color-saffron);
    box-shadow: 0 0 0 4px rgba(243, 106, 33, .25), 0 20px 45px rgba(89, 37, 24, .18);
    transform: translateY(-4px);
}

.rs-pillar-media {
    position: relative;
    width: 100%;
    aspect-ratio: 16/11;
    overflow: hidden;
    background: #e2e8f0;
}

.rs-pillar-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 550ms ease;
    display: block;
}

.rs-pillar-card:hover .rs-pillar-media img {
    transform: scale(1.08);
}

.rs-pillar-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.08) 0%, rgba(30, 15, 10, 0.72) 100%);
}

.rs-pillar-badge-count {
    position: absolute;
    top: .85rem;
    right: .85rem;
    padding: .35rem .8rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, .95);
    color: var(--color-maroon);
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .02em;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
}

.rs-pillar-body {
    padding: 1.4rem 1.4rem 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.rs-pillar-tagline {
    font-size: .74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--color-saffron);
    margin-bottom: .6rem;
    position: relative;
    display: inline-block;
    padding-bottom: .35rem;
}

.rs-pillar-tagline::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 26px;
    height: 2.5px;
    background: var(--color-saffron);
    border-radius: 2px;
}

.rs-pillar-card .rs-pillar-title {
    margin: 0 0 .5rem;
    font-size: clamp(1.15rem, 1.28vw, 1.3rem) !important;
    font-weight: 700;
    color: #542019;
    line-height: 1.25;
    min-height: 2.6rem;
    display: flex;
    align-items: center;
}

.rs-pillar-desc {
    margin: 0 0 1.25rem;
    font-size: .84rem;
    color: #67574c;
    line-height: 1.55;
    flex-grow: 1;
}

.rs-pillar-action-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: .9rem;
    border-top: 1px solid rgba(143, 23, 29, .1);
}

.rs-pillar-cta-text {
    font-size: .88rem;
    font-weight: 700;
    color: var(--color-maroon);
    display: flex;
    align-items: center;
    gap: .4rem;
}

.rs-pillar-card:hover .rs-pillar-cta-text {
    color: var(--color-saffron);
}

.rs-pillar-chevron {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(143, 23, 29, .08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-maroon);
    font-size: .85rem;
    transition: transform 200ms ease, background 200ms ease;
}

.rs-pillar-card:hover .rs-pillar-chevron {
    background: var(--color-maroon);
    color: #fff;
    transform: translateX(3px);
}

/* ============================================================
   Sub-Activities Master Section (Hidden initially, revealed on click)
   ============================================================ */
.rs-subactivities-master-section {
    display: none; /* Initially hidden */
    margin-top: 2.5rem;
    padding-top: 2.5rem;
    border-top: 2px dashed rgba(143, 23, 29, .18);
    scroll-margin-top: 60px;
    animation: rs-fade-in-up 350ms cubic-bezier(.16, 1, .3, 1) forwards;
}

.rs-subactivities-master-section.is-revealed {
    display: block;
}

@keyframes rs-fade-in-up {
    0%   { opacity: 0; transform: translateY(24px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Category Navigation & Control Bar */
.rs-act-control-panel {
    background: rgba(255, 255, 255, .9);
    border: 1px solid var(--color-border);
    border-radius: 1.25rem;
    padding: 1.5rem;
    box-shadow: 0 10px 32px rgba(89, 37, 24, .06);
    margin-bottom: 2rem;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

.rs-panel-top-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(143, 23, 29, .1);
}

.rs-back-to-categories-btn {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    padding: .5rem 1.15rem;
    border-radius: 999px;
    background: rgba(255, 248, 236, .9);
    border: 1px solid rgba(143, 23, 29, .22);
    color: var(--color-maroon);
    font-size: .84rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 180ms ease;
}

.rs-back-to-categories-btn:hover {
    background: var(--color-maroon);
    color: #fff;
    transform: translateX(-3px);
}

.rs-category-tabs-nav {
    display: flex;
    flex-wrap: wrap;
    gap: .45rem;
}

.rs-cat-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .5rem 1.15rem;
    border-radius: 999px;
    border: 1px solid rgba(143, 23, 29, .15);
    background: #fff;
    color: #67574c;
    font-size: .84rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 180ms ease;
}

.rs-cat-nav-btn:hover {
    color: var(--color-maroon);
    border-color: var(--color-maroon);
    background: rgba(255, 248, 236, .7);
}

.rs-cat-nav-btn.is-active {
    background: var(--color-maroon);
    border-color: var(--color-maroon);
    color: #fff;
    box-shadow: 0 4px 14px rgba(143, 23, 29, .28);
}

/* Search, Sort & Advanced Multi-Filter Controls */
.rs-search-sort-row {
    display: grid;
    grid-template-columns: 1fr 220px;
    gap: 1rem;
    margin-bottom: 1rem;
    align-items: center;
}

.rs-search-box-wrap {
    position: relative;
    width: 100%;
}

.rs-search-input {
    width: 100%;
    height: 2.85rem;
    padding: 0 2.5rem 0 2.75rem;
    border-radius: 999px;
    border: 1.5px solid rgba(143, 23, 29, .22);
    background: #fff;
    font-size: .88rem;
    color: #292522;
    outline: none;
    transition: border-color 160ms ease, box-shadow 160ms ease;
}

.rs-search-input:focus {
    border-color: var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .12);
}

.rs-search-icon-svg {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--color-maroon);
    pointer-events: none;
}

.rs-search-clear-btn {
    position: absolute;
    right: .9rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #94a3b8;
    cursor: pointer;
    display: none;
    line-height: 1;
}

.rs-search-clear-btn.is-visible {
    display: block;
}

.rs-filters-dropdowns-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: .85rem;
    align-items: center;
}

.rs-filter-select-wrap {
    position: relative;
}

.rs-filter-select {
    width: 100%;
    height: 2.85rem;
    padding: 0 2rem 0 1rem;
    border-radius: 999px;
    border: 1.5px solid rgba(143, 23, 29, .2);
    background: #fff;
    font-size: .83rem;
    font-weight: 600;
    color: #443731;
    outline: none;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    transition: border-color 160ms ease;
}

.rs-filter-select:focus {
    border-color: var(--color-maroon);
}

.rs-select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    width: 14px;
    height: 14px;
    color: var(--color-maroon);
}

/* Quick Filter Chips Row (1-Click Shortcuts) */
.rs-quick-chips-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .5rem;
    margin-top: 1.15rem;
    padding-top: 1rem;
    border-top: 1px dashed rgba(143, 23, 29, .12);
}

.rs-quick-chip-label {
    font-size: .76rem;
    font-weight: 800;
    color: var(--color-maroon);
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-right: .25rem;
}

.rs-quick-chip-btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .35rem .85rem;
    border-radius: 999px;
    border: 1px solid rgba(143, 23, 29, .18);
    background: #fff;
    font-size: .8rem;
    font-weight: 600;
    color: #542019;
    cursor: pointer;
    transition: all 160ms ease;
}

.rs-quick-chip-btn:hover {
    background: rgba(255, 248, 236, .95);
    border-color: var(--color-maroon);
    color: var(--color-maroon);
}

.rs-quick-chip-btn.is-active {
    background: var(--color-maroon);
    border-color: var(--color-maroon);
    color: #fff;
    box-shadow: 0 3px 10px rgba(143, 23, 29, .25);
}

/* Results Status Bar & Active Filter Tags */
.rs-filter-status-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-top: 1.15rem;
    padding-top: 1rem;
    border-top: 1px dashed rgba(143, 23, 29, .1);
    font-size: .84rem;
}

.rs-active-tags-list {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .45rem;
}

.rs-active-tag-chip {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .25rem .7rem;
    border-radius: 999px;
    background: rgba(243, 106, 33, .12);
    border: 1px solid rgba(243, 106, 33, .3);
    color: #8c3809;
    font-size: .76rem;
    font-weight: 700;
}

.rs-active-tag-close {
    cursor: pointer;
    font-size: 1rem;
    line-height: 1;
    color: #8c3809;
    margin-left: 2px;
}

.rs-results-count {
    font-weight: 700;
    color: #542019;
}

.rs-reset-all-filters-btn {
    background: none;
    border: none;
    color: var(--color-maroon);
    font-weight: 700;
    text-decoration: underline;
    cursor: pointer;
    font-size: .82rem;
    padding: 0;
}

/* ============================================================
   Sub-Activity Cards Grid
   ============================================================ */
.rs-catalog-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.6rem;
}

.rs-subactivity-card {
    border-radius: 1.25rem;
    background: rgba(255, 255, 255, .92);
    border: 1px solid rgba(143, 23, 29, .14);
    box-shadow: 0 8px 24px rgba(89, 37, 24, .06);
    padding: 1.6rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.rs-subactivity-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 36px rgba(89, 37, 24, .12);
    border-color: rgba(143, 23, 29, .32);
}

.rs-subact-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: .75rem;
}

.rs-subact-title-wrap {
    display: flex;
    flex-direction: column;
    gap: .25rem;
}

.rs-subact-cat-pill {
    font-size: .72rem;
    font-weight: 800;
    color: var(--color-saffron);
    text-transform: uppercase;
    letter-spacing: .06em;
}

.rs-subact-title {
    margin: 0;
    font-size: 1.15rem;
    font-weight: 700;
    color: #542019;
    line-height: 1.3;
}

.rs-subact-badge {
    padding: .25rem .7rem;
    border-radius: 999px;
    background: rgba(249, 183, 42, .2);
    border: 1px solid rgba(249, 183, 42, .55);
    color: #8c5300;
    font-size: .72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .04em;
    white-space: nowrap;
    flex-shrink: 0;
}

.rs-subact-desc {
    margin: 0 0 1.25rem;
    font-size: .88rem;
    color: #67574c;
    line-height: 1.6;
}

/* Specifications Box */
.rs-subact-specs {
    display: flex;
    flex-direction: column;
    gap: .75rem;
    padding: 1.1rem;
    background: rgba(255, 248, 236, .7);
    border: 1px solid rgba(143, 23, 29, .09);
    border-radius: .85rem;
    margin-bottom: 1.35rem;
}

.rs-spec-row {
    display: flex;
    align-items: flex-start;
    gap: .75rem;
    font-size: .82rem;
    line-height: 1.45;
}

.rs-spec-icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    color: var(--color-maroon);
    margin-top: 1px;
}

.rs-spec-content strong {
    color: #542019;
    font-weight: 700;
    margin-right: .35rem;
}

.rs-spec-content span {
    color: #67574c;
}

/* Sub-Activity Card Actions */
.rs-subact-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-top: .95rem;
    border-top: 1px solid rgba(143, 23, 29, .09);
}

.rs-register-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .65rem 1.45rem;
    border-radius: 999px;
    background: var(--color-maroon);
    color: #fff !important;
    font-size: .86rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(143, 23, 29, .25);
    transition: all 180ms ease;
    text-decoration: none;
}

.rs-register-btn:hover {
    background: #6e1015;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(143, 23, 29, .35);
}

/* Empty State when zero results match */
.rs-no-results-box {
    display: none;
    grid-column: 1 / -1;
    text-align: center;
    padding: 3.5rem 1.5rem;
    background: rgba(255, 255, 255, .8);
    border-radius: 1.25rem;
    border: 2px dashed rgba(143, 23, 29, .15);
}

.rs-no-results-box.is-visible {
    display: block;
}

.rs-no-results-icon {
    font-size: 3rem;
    margin-bottom: .75rem;
}

.rs-no-results-box h3 {
    margin: 0 0 .5rem;
    font-size: 1.35rem;
    color: #542019;
    font-weight: 800;
}

.rs-no-results-box p {
    margin: 0 0 1.25rem;
    color: #67574c;
    font-size: .92rem;
}

/* ============================================================
   Interactive Student Registration Modal
   ============================================================ */
.rs-reg-modal {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
}

.rs-reg-modal.is-open {
    display: flex;
}

.rs-reg-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(20, 10, 8, .68);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.rs-reg-panel {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 580px;
    max-height: 90vh;
    overflow-y: auto;
    background: #fff;
    border-radius: 1.35rem;
    box-shadow: 0 25px 60px rgba(0, 0, 0, .28);
    border: 1px solid rgba(143, 23, 29, .15);
    animation: rs-modal-pop 220ms cubic-bezier(.16, 1, .3, 1);
}

@keyframes rs-modal-pop {
    0%   { opacity: 0; transform: scale(.94) translateY(12px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}

.rs-reg-header {
    padding: 1.5rem 1.75rem 1.15rem;
    background: linear-gradient(135deg, rgba(255, 248, 236, .95), rgba(247, 235, 215, .9));
    border-bottom: 1px solid rgba(143, 23, 29, .12);
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.rs-reg-header-titles h3 {
    margin: 0 0 .25rem;
    font-size: 1.35rem;
    font-weight: 800;
    color: #542019;
}

.rs-reg-header-titles p {
    margin: 0;
    font-size: .84rem;
    color: var(--color-maroon);
    font-weight: 600;
}

.rs-reg-close-btn {
    background: rgba(255, 255, 255, .8);
    border: 1px solid rgba(143, 23, 29, .15);
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #542019;
    cursor: pointer;
    transition: background 150ms ease;
    flex-shrink: 0;
}

.rs-reg-close-btn:hover {
    background: #fee2e2;
    color: var(--color-maroon);
}

.rs-reg-body {
    padding: 1.75rem;
}

.rs-reg-form-group {
    margin-bottom: 1.15rem;
}

.rs-reg-form-group label {
    display: block;
    margin-bottom: .35rem;
    font-size: .84rem;
    font-weight: 700;
    color: #542019;
}

.rs-reg-form-group label span.req {
    color: #b91c1c;
}

.rs-reg-form-group input,
.rs-reg-form-group select,
.rs-reg-form-group textarea {
    width: 100%;
    padding: .65rem .95rem;
    border: 1px solid rgba(143, 23, 29, .22);
    border-radius: .65rem;
    background: #fff;
    font-size: .88rem;
    color: #292522;
    outline: none;
    transition: border-color 160ms ease, box-shadow 160ms ease;
}

.rs-reg-form-group input:focus,
.rs-reg-form-group select:focus,
.rs-reg-form-group textarea:focus {
    border-color: var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .12);
}

.rs-reg-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.rs-reg-submit-btn {
    width: 100%;
    padding: .85rem 1.5rem;
    border: none;
    border-radius: 999px;
    background: var(--color-maroon);
    color: #fff;
    font-size: .95rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(143, 23, 29, .25);
    transition: all 180ms ease;
    margin-top: .5rem;
}

.rs-reg-submit-btn:hover {
    background: #6e1015;
    box-shadow: 0 8px 22px rgba(143, 23, 29, .35);
}

.rs-reg-submit-btn:disabled {
    opacity: .7;
    cursor: not-allowed;
}

.rs-reg-feedback {
    display: none;
    padding: 1rem;
    border-radius: .75rem;
    margin-top: 1rem;
    font-size: .88rem;
    line-height: 1.45;
}

.rs-reg-feedback.is-success {
    display: block;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.rs-reg-feedback.is-error {
    display: block;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

/* Registration Confirmation Card */
.rs-reg-confirm-card {
    text-align: center;
    padding: 1rem 0.5rem 0.5rem;
    animation: rsFadeInUp 0.32s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes rsFadeInUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}
.rs-confirm-icon-wrap {
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
.rs-confirm-check-svg {
    width: 42px;
    height: 42px;
}
.rs-confirm-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #065f46;
    margin: 0 0 0.3rem;
}
.rs-confirm-greeting {
    font-size: 1.05rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.35rem;
}
.rs-confirm-desc {
    font-size: 0.9rem;
    color: #4b5563;
    margin: 0 0 1.25rem;
    line-height: 1.45;
}
.rs-confirm-summary-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.9rem 1.15rem;
    text-align: left;
    margin-bottom: 1.15rem;
}
.rs-confirm-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0.45rem 0;
    border-bottom: 1px dashed #e2e8f0;
    font-size: 0.86rem;
    gap: 0.75rem;
}
.rs-confirm-summary-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.rs-confirm-summary-label {
    color: #64748b;
    font-weight: 500;
    flex-shrink: 0;
}
.rs-confirm-summary-val {
    color: #0f172a;
    font-weight: 600;
    text-align: right;
    word-break: break-word;
}
.rs-confirm-next-steps {
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
.rs-confirm-next-steps svg {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
}
.rs-confirm-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
}
.rs-confirm-done-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 2.25rem;
    background: var(--color-maroon, #8b2500);
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.rs-confirm-done-btn:hover {
    background: #6e1c00;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139, 37, 0, 0.25);
}

/* ============================================================
   Responsive Layout Breakpoints
   ============================================================ */
@media (max-width: 1200px) {
    .rs-filters-dropdowns-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 1120px) {
    .rs-pillars-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 860px) {
    .rs-catalog-grid {
        grid-template-columns: 1fr;
    }
    .rs-reg-form-row {
        grid-template-columns: 1fr;
    }
    .rs-search-sort-row {
        grid-template-columns: 1fr;
    }
    .rs-filters-dropdowns-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .rs-act-header-section {
        padding: 2.25rem 0 1.5rem;
    }
    .rs-act-page-title {
        font-size: clamp(1.75rem, 6.8vw, 2.3rem);
    }
    .rs-pillars-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    .rs-pillar-body {
        padding: 1.25rem;
    }
    .rs-filters-dropdowns-grid {
        grid-template-columns: 1fr;
    }
    .rs-panel-top-row {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    .rs-back-to-categories-btn {
        justify-content: center;
        width: 100%;
    }
    .rs-subactivity-card {
        padding: 1.2rem;
    }
    .rs-subact-batch-pills {
        flex-wrap: wrap;
    }
    /* Mobile Registration Modal */
    .rs-reg-modal {
        padding: 10px;
    }
    .rs-reg-panel {
        max-width: 100%;
        width: 100%;
        max-height: 94vh;
        border-radius: 18px;
    }
    .rs-reg-header {
        padding: 1.15rem 1.25rem;
    }
    .rs-reg-header-titles h3 {
        font-size: 1.15rem;
    }
    .rs-reg-body {
        padding: 1.2rem 1.1rem;
    }
    .rs-reg-form-row {
        grid-template-columns: 1fr;
        gap: 0.85rem;
    }
    .rs-reg-input,
    .rs-reg-select {
        font-size: 16px !important;
    }
    .rs-reg-submit-btn {
        padding: 0.85rem 1.25rem;
        font-size: 0.95rem;
    }
    .rs-confirm-summary-box {
        padding: 0.75rem 0.85rem;
    }
    .rs-confirm-summary-row {
        font-size: 0.82rem;
    }
}
</style>

<main class="rs-activities-page" id="main-content">

    <!-- Page Header Section -->
    <header class="rs-act-header-section">
        <div class="rs-container">
            <div class="rs-act-title-block">
                <div class="rs-act-eyebrow">
                    <span class="rs-act-eyebrow-dot"></span>
                    <span>Holistic Practices &bull; Bengaluru</span>
                </div>
                <h1 class="rs-act-page-title">
                    Empower Body, Mind &amp; <em>Spirit</em>
                </h1>
                <p class="rs-act-page-subtitle">
                    Select any of our 4 core disciplines below to view comprehensive sub-activity programs, certified centers, and daily batch timings.
                </p>
                <div class="rs-act-instruction-hint">
                    <span>Click any card below to explore its programs &amp; batches</span>
                </div>
            </div>
        </div>
    </header>

    <div class="rs-container">

        <!-- 4 Primary Activity Pillar Cards (Initial View) -->
        <section class="rs-pillars-section" id="pillars-section" aria-label="Core Activity Disciplines">
            <div class="rs-pillars-grid">
                <?php foreach ( $activity_categories as $index => $cat ) : ?>
                    <article class="rs-pillar-card" 
                             data-category-slug="<?php echo esc_attr( $cat['slug'] ); ?>"
                             tabindex="0"
                             role="button"
                             aria-label="Explore <?php echo esc_attr( $cat['title'] ); ?> programs">
                        <div class="rs-pillar-media">
                            <img src="<?php echo esc_url( $cat['image'] ); ?>" alt="<?php echo esc_attr( $cat['title'] ); ?>" loading="lazy">
                            <div class="rs-pillar-overlay"></div>
                            <span class="rs-pillar-badge-count"><?php echo count( $cat['items'] ); ?> Programs</span>
                        </div>

                        <div class="rs-pillar-body">
                            <span class="rs-pillar-tagline"><?php echo esc_html( $cat['tagline'] ); ?></span>
                            <h2 class="rs-pillar-title"><?php echo esc_html( $cat['title'] ); ?></h2>
                            <p class="rs-pillar-desc"><?php echo esc_html( $cat['text'] ); ?></p>
                            
                            <div class="rs-pillar-action-row">
                                <span class="rs-pillar-cta-text">
                                    <span>View <?php echo esc_html( $cat['title'] ); ?> Programs</span>
                                </span>
                                <span class="rs-pillar-chevron" aria-hidden="true">&rarr;</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Sub-Activities Master Section (Revealed on Category Click) -->
        <section class="rs-subactivities-master-section" id="subactivities-master-section" aria-label="Detailed Programs Catalog">
            
            <!-- Category Navigation & Filter Control Panel -->
            <div class="rs-act-control-panel">
                
                <!-- Top Row: Back Button & Category Switcher Tabs -->
                <div class="rs-panel-top-row">
                    <button type="button" class="rs-back-to-categories-btn" id="rs-back-to-categories-btn">
                        <span>&larr; Back to 4 Categories</span>
                    </button>

                    <div class="rs-category-tabs-nav" role="tablist">
                        <button type="button" class="rs-cat-nav-btn is-active" data-cat-nav="all">
                            <span>All Disciplines (<?php echo esc_html( $total_subactivities ); ?>)</span>
                        </button>
                        <?php foreach ( $activity_categories as $cat ) : ?>
                            <button type="button" class="rs-cat-nav-btn" data-cat-nav="<?php echo esc_attr( $cat['slug'] ); ?>" data-cat-title="<?php echo esc_attr( $cat['title'] ); ?>" data-cat-total="<?php echo count( $cat['items'] ); ?>">
                                <span><?php echo esc_html( $cat['title'] ); ?> (<?php echo count( $cat['items'] ); ?>)</span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Search & Sort Row -->
                <div class="rs-search-sort-row">
                    <!-- Search Input -->
                    <div class="rs-search-box-wrap">
                        <svg class="rs-search-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input type="text" 
                               id="rs-activity-search-input" 
                               class="rs-search-input" 
                               placeholder="Search activities by name, keyword, asana, martial art, teacher, center..."
                               aria-label="Search activities">
                        <button type="button" id="rs-search-clear-btn" class="rs-search-clear-btn" aria-label="Clear search">&times;</button>
                    </div>

                    <!-- Sort By Dropdown -->
                    <div class="rs-filter-select-wrap">
                        <select id="rs-filter-sort" class="rs-filter-select" aria-label="Sort activities">
                            <option value="featured">Sort: Featured</option>
                            <option value="name-asc">Name: A &rarr; Z</option>
                            <option value="name-desc">Name: Z &rarr; A</option>
                        </select>
                        <svg class="rs-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                </div>

                <!-- 5-Column Filter Dropdowns Grid -->
                <div class="rs-filters-dropdowns-grid">
                    
                    <!-- Filter 1: Center / Location Filter -->
                    <div class="rs-filter-select-wrap">
                        <select id="rs-filter-center" class="rs-filter-select" aria-label="Filter by Center">
                            <option value="">All 25+ Centers</option>
                            <?php foreach ( $all_centers as $center ) : ?>
                                <option value="<?php echo esc_attr( strtolower( $center['name'] ) ); ?>">
                                    <?php echo esc_html( $center['name'] ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <svg class="rs-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>

                    <!-- Filter 2: Batch Timing Filter -->
                    <div class="rs-filter-select-wrap">
                        <select id="rs-filter-timing" class="rs-filter-select" aria-label="Filter by Batch Timing">
                            <option value="">All Batch Hours</option>
                            <option value="morning">Morning (5:30 AM – 11 AM)</option>
                            <option value="evening">Evening (4:30 PM – 8:30 PM)</option>
                            <option value="weekend">Weekend Batches (Sat/Sun)</option>
                        </select>
                        <svg class="rs-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>

                    <!-- Filter 3: Schedule / Days Frequency Filter -->
                    <div class="rs-filter-select-wrap">
                        <select id="rs-filter-schedule" class="rs-filter-select" aria-label="Filter by Schedule Frequency">
                            <option value="">All Schedules</option>
                            <option value="daily">Daily / 5-6 Days a Week</option>
                            <option value="alternate">Alternate Days (2-3 Days/Wk)</option>
                            <option value="weekend">Weekend Only (Sat &amp; Sun)</option>
                            <option value="appointment">By Consultation / Appointment</option>
                        </select>
                        <svg class="rs-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>

                    <!-- Filter 4: Target Audience / Age Group Filter -->
                    <div class="rs-filter-select-wrap">
                        <select id="rs-filter-audience" class="rs-filter-select" aria-label="Filter by Target Audience">
                            <option value="">All Age Groups</option>
                            <option value="kids">Kids &amp; Youth (Ages 5–15)</option>
                            <option value="adults">Adults &amp; Seniors (Age 15+)</option>
                            <option value="women">Women Dedicated Batches</option>
                            <option value="therapy">Special Health &amp; Therapy</option>
                        </select>
                        <svg class="rs-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>

                    <!-- Filter 5: Level & Focus Filter -->
                    <div class="rs-filter-select-wrap">
                        <select id="rs-filter-focus" class="rs-filter-select" aria-label="Filter by Focus or Level">
                            <option value="">All Focus Areas</option>
                            <option value="foundational">Beginner &amp; Foundational</option>
                            <option value="fitness">Daily Fitness &amp; Stamina</option>
                            <option value="therapeutic">Therapeutic &amp; Wellness</option>
                            <option value="classical">Classical Arts &amp; Belts</option>
                            <option value="cultural">Heritage &amp; Mentorship</option>
                        </select>
                        <svg class="rs-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>

                </div>

                <!-- Quick Filter Chips Row (1-Click Shortcuts) -->
                <div class="rs-quick-chips-row" aria-label="Quick Filter Shortcuts">
                    <span class="rs-quick-chip-label">Quick Filters:</span>
                    <button type="button" class="rs-quick-chip-btn is-active" data-quick-filter="all">All</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="kids">Kids &amp; Teens</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="beginners">Beginners</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="therapy">Therapy &amp; Care</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="morning">Morning Batches</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="evening">Evening Batches</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="weekend">Weekend Batches</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="women">Women Dedicated</button>
                    <button type="button" class="rs-quick-chip-btn" data-quick-filter="classical">Classical &amp; Belts</button>
                </div>

                <!-- Status Row with Active Filter Tags -->
                <div class="rs-filter-status-bar">
                    <div class="rs-active-tags-list" id="rs-active-tags-list"></div>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-left: auto;">
                        <span class="rs-results-count" id="rs-results-count">Showing <?php echo esc_html( $total_subactivities ); ?> activities</span>
                        <button type="button" class="rs-reset-all-filters-btn" id="rs-reset-all-filters-btn">Reset All Filters</button>
                    </div>
                </div>

            </div>

            <!-- Sub-Activities Cards Grid -->
            <div class="rs-catalog-grid" id="rs-catalog-grid">
                <?php 
                $card_counter = 0;
                foreach ( $activity_categories as $cat ) : ?>
                    <?php foreach ( $cat['items'] as $item ) : ?>
                        <?php
                        $clean_title = esc_attr( strtolower( $item['name'] ) );
                        $clean_desc  = esc_attr( strtolower( $item['desc'] ) );
                        $clean_cntrs = esc_attr( strtolower( $item['centers'] ) );
                        $clean_badge = esc_attr( strtolower( $item['badge'] ) );
                        $clean_batch = esc_attr( strtolower( $item['batches'] ) );
                        $clean_freq  = esc_attr( strtolower( $item['frequency'] ) );
                        $clean_elig  = esc_attr( strtolower( $item['eligibility'] ) );
                        ?>
                        <article class="rs-subactivity-card"
                                 data-original-index="<?php echo $card_counter++; ?>"
                                 data-category="<?php echo esc_attr( $cat['slug'] ); ?>"
                                 data-title="<?php echo $clean_title; ?>"
                                 data-desc="<?php echo $clean_desc; ?>"
                                 data-centers="<?php echo $clean_cntrs; ?>"
                                 data-badge="<?php echo $clean_badge; ?>"
                                 data-batches="<?php echo $clean_batch; ?>"
                                 data-frequency="<?php echo $clean_freq; ?>"
                                 data-eligibility="<?php echo $clean_elig; ?>">
                            
                            <div>
                                <div class="rs-subact-top">
                                    <div class="rs-subact-title-wrap">
                                        <span class="rs-subact-cat-pill"><?php echo esc_html( $cat['title'] ); ?></span>
                                        <h3 class="rs-subact-title"><?php echo esc_html( $item['name'] ); ?></h3>
                                    </div>
                                    <?php if ( ! empty( $item['badge'] ) ) : ?>
                                        <span class="rs-subact-badge"><?php echo esc_html( $item['badge'] ); ?></span>
                                    <?php endif; ?>
                                </div>

                                <p class="rs-subact-desc"><?php echo esc_html( $item['desc'] ); ?></p>

                                <!-- Specifications Box -->
                                <div class="rs-subact-specs">
                                    <!-- Centers -->
                                    <div class="rs-spec-row">
                                        <svg class="rs-spec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        <div class="rs-spec-content">
                                            <strong>Centers:</strong>
                                            <span><?php echo esc_html( $item['centers'] ); ?></span>
                                        </div>
                                    </div>

                                    <!-- Batches -->
                                    <div class="rs-spec-row">
                                        <svg class="rs-spec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        <div class="rs-spec-content">
                                            <strong>Timings:</strong>
                                            <span><?php echo esc_html( $item['batches'] ); ?></span>
                                        </div>
                                    </div>

                                    <!-- Schedule / Duration -->
                                    <div class="rs-spec-row">
                                        <svg class="rs-spec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>
                                        </svg>
                                        <div class="rs-spec-content">
                                            <strong>Schedule:</strong>
                                            <span><?php echo esc_html( $item['frequency'] ); ?> &bull; <?php echo esc_html( $item['duration'] ); ?></span>
                                        </div>
                                    </div>

                                    <!-- Eligibility -->
                                    <div class="rs-spec-row">
                                        <svg class="rs-spec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>
                                        </svg>
                                        <div class="rs-spec-content">
                                            <strong>Eligibility:</strong>
                                            <span><?php echo esc_html( $item['eligibility'] ); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rs-subact-actions">
                                <!-- Student Register Button -->
                                <?php if ( ! empty( $item['registration_open'] ) ) : ?>
                                <button type="button" 
                                        class="rs-register-btn rs-trigger-reg-modal"
                                        data-activity="<?php echo esc_attr( $item['name'] ); ?>"
                                        data-activity-id="<?php echo esc_attr( $item['id'] ); ?>"
                                        data-category="<?php echo esc_attr( $cat['title'] ); ?>">
                                    <span>Register Now</span> &rarr;
                                </button>
                                <?php else : ?>
                                <button type="button" 
                                        class="rs-register-btn" 
                                        style="background: #94a3b8; border-color: #94a3b8; cursor: not-allowed; opacity: 0.85;" 
                                        disabled
                                        title="Registrations are currently closed for this activity">
                                    <span>Registrations Closed</span>
                                </button>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <!-- Empty State Message when 0 results match -->
                <div class="rs-no-results-box" id="rs-no-results-box">
                    <div class="rs-no-results-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 44px; height: 44px; color: var(--color-maroon); display: inline-block;">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                    </div>
                    <h3>No Activities Match Your Filters</h3>
                    <p>Try searching for a different keyword, clearing your filters, or switching categories.</p>
                    <button type="button" class="rs-register-btn" id="rs-empty-reset-btn">Reset All Filters</button>
                </div>
            </div>

        </section>

    </div>
</main>

<!-- ============================================================
     Student Registration Modal
     ============================================================ -->
<div class="rs-reg-modal" id="rs-activity-reg-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="rs-reg-modal-title">
    <div class="rs-reg-backdrop" id="rs-reg-backdrop"></div>
    <div class="rs-reg-panel">
        
        <div class="rs-reg-header">
            <div class="rs-reg-header-titles">
                <h3 id="rs-reg-modal-title">Student Registration</h3>
                <p id="rs-reg-activity-display">Selected: Yoga for Beginners</p>
            </div>
            <button type="button" class="rs-reg-close-btn" id="rs-reg-close-btn" aria-label="Close registration dialog">&times;</button>
        </div>

        <div class="rs-reg-body">
            <form id="rs-student-reg-form">
                <?php wp_nonce_field( 'rs_activity_reg_nonce', 'rs_reg_nonce' ); ?>
                <input type="hidden" name="activity_name" id="rs-reg-activity-input" value="">
                <input type="hidden" name="activity_id" id="rs-reg-activity-id-input" value="">

                <!-- Student Full Name -->
                <div class="rs-reg-form-group">
                    <label for="reg_student_name">Full Name <span class="req">*</span></label>
                    <input type="text" id="reg_student_name" name="student_name" required placeholder="Enter student's full name">
                </div>

                <!-- Phone & Email -->
                <div class="rs-reg-form-row">
                    <div class="rs-reg-form-group">
                        <label for="reg_student_phone">Phone / WhatsApp <span class="req">*</span></label>
                        <input type="tel" id="reg_student_phone" name="student_phone" required placeholder="e.g. 9876543210">
                    </div>
                    <div class="rs-reg-form-group">
                        <label for="reg_student_email">Email Address <span class="req">*</span></label>
                        <input type="email" id="reg_student_email" name="student_email" required placeholder="e.g. name@example.com">
                    </div>
                </div>

                <!-- Choice of Center (Dynamically populated from DB) -->
                <div class="rs-reg-form-group">
                    <label for="reg_center_choice">Choice of Center <span class="req">*</span></label>
                    <select id="reg_center_choice" name="center_choice" required>
                        <option value="">-- Select Your Preferred Center --</option>
                        <?php foreach ( $all_centers as $center ) : ?>
                            <option value="<?php echo esc_attr( $center['name'] ); ?>">
                                <?php echo esc_html( $center['name'] ); ?><?php echo ! empty( $center['area'] ) ? ' (' . esc_html( $center['area'] ) . ')' : ''; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Preferred Batch Timing -->
                <div class="rs-reg-form-group">
                    <label for="reg_preferred_timing">Preferred Batch Timing</label>
                    <select id="reg_preferred_timing" name="preferred_timing">
                        <option value="Morning Early (5:30 AM - 6:30 AM)">Morning Early (5:30 AM - 6:30 AM)</option>
                        <option value="Morning Regular (6:30 AM - 8:00 AM)" selected>Morning Regular (6:30 AM - 8:00 AM)</option>
                        <option value="Morning Midday (8:30 AM - 10:30 AM)">Morning Midday (8:30 AM - 10:30 AM)</option>
                        <option value="Evening Early (4:30 PM - 6:00 PM)">Evening Early (4:30 PM - 6:00 PM)</option>
                        <option value="Evening Regular (6:00 PM - 7:30 PM)">Evening Regular (6:00 PM - 7:30 PM)</option>
                        <option value="Evening Late (7:30 PM - 9:00 PM)">Evening Late (7:30 PM - 9:00 PM)</option>
                        <option value="Weekend Batches (Saturday & Sunday)">Weekend Batches (Saturday &amp; Sunday)</option>
                    </select>
                </div>

                <!-- Special Notes / Queries -->
                <div class="rs-reg-form-group">
                    <label for="reg_student_notes">Notes / Health Queries (Optional)</label>
                    <textarea id="reg_student_notes" name="student_notes" rows="2" placeholder="Mention prior experience, health concerns, or goals..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="rs-reg-submit-btn" id="rs-reg-submit-btn">
                    <span>Submit Student Registration</span>
                </button>

                <!-- Feedback Message -->
                <div class="rs-reg-feedback" id="rs-reg-feedback" role="alert"></div>
            </form>

            <!-- Registration Confirmation Card (Shown when registration succeeds) -->
            <div class="rs-reg-confirm-card" id="rs-reg-confirm-card" style="display: none;">
                <div class="rs-confirm-icon-wrap">
                    <svg viewBox="0 0 24 24" class="rs-confirm-check-svg" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" stroke="#10b981" stroke-width="2"/>
                        <path d="M7.5 12l3 3 6-6"/>
                    </svg>
                </div>
                <h3 class="rs-confirm-title">Registration Confirmed!</h3>
                <p class="rs-confirm-greeting" id="rs-confirm-greeting">Namaste,</p>
                <p class="rs-confirm-desc">Your seat has been reserved. Thank you for registering with Rashtrotthana Yoga!</p>

                <div class="rs-confirm-summary-box">
                    <div class="rs-confirm-summary-row">
                        <span class="rs-confirm-summary-label">Program:</span>
                        <span class="rs-confirm-summary-val" id="rs-conf-activity">Yoga Program</span>
                    </div>
                    <div class="rs-confirm-summary-row">
                        <span class="rs-confirm-summary-label">Center:</span>
                        <span class="rs-confirm-summary-val" id="rs-conf-center">Selected Center</span>
                    </div>
                    <div class="rs-confirm-summary-row">
                        <span class="rs-confirm-summary-label">Batch Timing:</span>
                        <span class="rs-confirm-summary-val" id="rs-conf-timing">Morning Regular</span>
                    </div>
                    <div class="rs-confirm-summary-row">
                        <span class="rs-confirm-summary-label">Student:</span>
                        <span class="rs-confirm-summary-val" id="rs-conf-student">-</span>
                    </div>
                    <div class="rs-confirm-summary-row" id="rs-conf-ref-row">
                        <span class="rs-confirm-summary-label">Reference ID:</span>
                        <span class="rs-confirm-summary-val" id="rs-conf-ref" style="color:#0369a1; font-family:monospace;">#RY-ACT</span>
                    </div>
                </div>

                <div class="rs-confirm-next-steps">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>Our center coordinator will contact you shortly on your registered number to finalize your batch schedule and enrollment details.</span>
                </div>

                <div class="rs-confirm-actions">
                    <button type="button" class="rs-confirm-done-btn" id="rs-reg-confirm-done-btn">Done / Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Elements ──
    var pillarCards = document.querySelectorAll('.rs-pillar-card');
    var masterSection = document.getElementById('subactivities-master-section');
    var backToCategoriesBtn = document.getElementById('rs-back-to-categories-btn');
    var catNavButtons = document.querySelectorAll('.rs-cat-nav-btn');
    var searchInput = document.getElementById('rs-activity-search-input');
    var searchClearBtn = document.getElementById('rs-search-clear-btn');
    var filterSort = document.getElementById('rs-filter-sort');
    var filterCenter = document.getElementById('rs-filter-center');
    var filterTiming = document.getElementById('rs-filter-timing');
    var filterSchedule = document.getElementById('rs-filter-schedule');
    var filterAudience = document.getElementById('rs-filter-audience');
    var filterFocus = document.getElementById('rs-filter-focus');
    var quickFilterBtns = document.querySelectorAll('.rs-quick-chip-btn');
    var activeTagsList = document.getElementById('rs-active-tags-list');
    var resetFiltersBtn = document.getElementById('rs-reset-all-filters-btn');
    var emptyResetBtn = document.getElementById('rs-empty-reset-btn');
    var resultsCountEl = document.getElementById('rs-results-count');
    var noResultsBox = document.getElementById('rs-no-results-box');
    var catalogGrid = document.getElementById('rs-catalog-grid');
    var subactCards = Array.from(document.querySelectorAll('.rs-subactivity-card'));

    var currentCategory = 'all';
    var activeQuickFilter = 'all';

    // ── 1. Reveal Sub-Activities on Pillar Card Click ──
    function openCategoryCatalog(categorySlug) {
        currentCategory = categorySlug || 'all';

        // Update active state on pillar cards
        pillarCards.forEach(function (card) {
            if (card.getAttribute('data-category-slug') === currentCategory) {
                card.classList.add('is-active-pillar');
            } else {
                card.classList.remove('is-active-pillar');
            }
        });

        // Update active state on top category switcher tabs
        catNavButtons.forEach(function (btn) {
            if (btn.getAttribute('data-cat-nav') === currentCategory) {
                btn.classList.add('is-active');
            } else {
                btn.classList.remove('is-active');
            }
        });

        // Reveal master section if hidden
        masterSection.classList.add('is-revealed');

        // Apply filters
        applyAllFilters();

        // Smooth scroll to control panel
        masterSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Attach click to all 4 pillar cards
    pillarCards.forEach(function (card) {
        card.addEventListener('click', function () {
            var slug = this.getAttribute('data-category-slug');
            openCategoryCatalog(slug);
        });

        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                var slug = this.getAttribute('data-category-slug');
                openCategoryCatalog(slug);
            }
        });
    });

    // Back to 4 Categories Button (Collapses sub-activities view)
    if (backToCategoriesBtn) {
        backToCategoriesBtn.addEventListener('click', function () {
            masterSection.classList.remove('is-revealed');
            pillarCards.forEach(function (card) { card.classList.remove('is-active-pillar'); });
            var pillarsSection = document.getElementById('pillars-section');
            if (pillarsSection) {
                pillarsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // Category Tabs Switcher within sub-activities
    catNavButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var slug = this.getAttribute('data-cat-nav');
            openCategoryCatalog(slug);
        });
    });

    // ── 2. Card Sorting Logic ──
    function sortCards(sortVal) {
        if (!catalogGrid || !noResultsBox) return;

        var sorted = subactCards.slice();

        if (sortVal === 'name-asc') {
            sorted.sort(function (a, b) {
                var titleA = a.getAttribute('data-title') || '';
                var titleB = b.getAttribute('data-title') || '';
                return titleA.localeCompare(titleB);
            });
        } else if (sortVal === 'name-desc') {
            sorted.sort(function (a, b) {
                var titleA = a.getAttribute('data-title') || '';
                var titleB = b.getAttribute('data-title') || '';
                return titleB.localeCompare(titleA);
            });
        } else {
            // Featured / default order
            sorted.sort(function (a, b) {
                var idxA = parseInt(a.getAttribute('data-original-index') || 0, 10);
                var idxB = parseInt(b.getAttribute('data-original-index') || 0, 10);
                return idxA - idxB;
            });
        }

        sorted.forEach(function (card) {
            catalogGrid.insertBefore(card, noResultsBox);
        });
    }

    // ── 3. Render Active Filter Badges ──
    function renderActiveTags(query, centerVal, timingVal, scheduleVal, audienceVal, focusVal) {
        if (!activeTagsList) return;
        activeTagsList.innerHTML = '';

        var tags = [];

        if (query) {
            tags.push({
                label: 'Search: "' + query + '"',
                clear: function () {
                    if (searchInput) searchInput.value = '';
                    applyAllFilters();
                }
            });
        }

        if (centerVal && filterCenter) {
            var centerText = filterCenter.options[filterCenter.selectedIndex].text.trim();
            tags.push({
                label: 'Center: ' + centerText,
                clear: function () {
                    filterCenter.value = '';
                    applyAllFilters();
                }
            });
        }

        if (timingVal && filterTiming) {
            var timingText = filterTiming.options[filterTiming.selectedIndex].text.trim();
            tags.push({
                label: 'Timing: ' + timingText,
                clear: function () {
                    filterTiming.value = '';
                    applyAllFilters();
                }
            });
        }

        if (scheduleVal && filterSchedule) {
            var schedText = filterSchedule.options[filterSchedule.selectedIndex].text.trim();
            tags.push({
                label: 'Schedule: ' + schedText,
                clear: function () {
                    filterSchedule.value = '';
                    applyAllFilters();
                }
            });
        }

        if (audienceVal && filterAudience) {
            var audText = filterAudience.options[filterAudience.selectedIndex].text.trim();
            tags.push({
                label: 'Audience: ' + audText,
                clear: function () {
                    filterAudience.value = '';
                    applyAllFilters();
                }
            });
        }

        if (focusVal && filterFocus) {
            var focusText = filterFocus.options[filterFocus.selectedIndex].text.trim();
            tags.push({
                label: 'Focus: ' + focusText,
                clear: function () {
                    filterFocus.value = '';
                    applyAllFilters();
                }
            });
        }

        if (activeQuickFilter !== 'all') {
            tags.push({
                label: 'Quick: ' + activeQuickFilter,
                clear: function () {
                    activeQuickFilter = 'all';
                    updateQuickChipActive('all');
                    applyAllFilters();
                }
            });
        }

        tags.forEach(function (tag) {
            var chip = document.createElement('span');
            chip.className = 'rs-active-tag-chip';
            chip.innerHTML = tag.label + ' <span class="rs-active-tag-close" aria-label="Remove filter">&times;</span>';
            chip.querySelector('.rs-active-tag-close').addEventListener('click', tag.clear);
            activeTagsList.appendChild(chip);
        });
    }

    function updateQuickChipActive(activeKey) {
        quickFilterBtns.forEach(function (btn) {
            if (btn.getAttribute('data-quick-filter') === activeKey) {
                btn.classList.add('is-active');
            } else {
                btn.classList.remove('is-active');
            }
        });
    }

    // ── 4. Main Multi-Filter & Search Engine ──
    function applyAllFilters() {
        var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        var centerVal = filterCenter ? filterCenter.value.toLowerCase().trim() : '';
        var timingVal = filterTiming ? filterTiming.value.toLowerCase().trim() : '';
        var scheduleVal = filterSchedule ? filterSchedule.value.toLowerCase().trim() : '';
        var audienceVal = filterAudience ? filterAudience.value.toLowerCase().trim() : '';
        var focusVal = filterFocus ? filterFocus.value.toLowerCase().trim() : '';
        var sortVal = filterSort ? filterSort.value : 'featured';

        // Show/hide search clear button
        if (searchClearBtn) {
            if (query.length > 0) {
                searchClearBtn.classList.add('is-visible');
            } else {
                searchClearBtn.classList.remove('is-visible');
            }
        }

        var visibleCount = 0;

        subactCards.forEach(function (card) {
            var cardCat   = card.getAttribute('data-category') || '';
            var title     = card.getAttribute('data-title') || '';
            var desc      = card.getAttribute('data-desc') || '';
            var centers   = card.getAttribute('data-centers') || '';
            var badge     = card.getAttribute('data-badge') || '';
            var batches   = card.getAttribute('data-batches') || '';
            var freq      = card.getAttribute('data-frequency') || '';
            var elig      = card.getAttribute('data-eligibility') || '';

            var fullText  = (title + ' ' + desc + ' ' + centers + ' ' + badge + ' ' + batches + ' ' + freq + ' ' + elig).toLowerCase();

            // Category match
            var catMatch = (currentCategory === 'all' || cardCat === currentCategory);

            // Search query match
            var searchMatch = !query || fullText.indexOf(query) !== -1;

            // Center match (includes universal centers phrases)
            var centerMatch = true;
            if (centerVal) {
                centerMatch = (centers.indexOf(centerVal) !== -1 || 
                               centers.indexOf('all 12') !== -1 || 
                               centers.indexOf('available across') !== -1 || 
                               centers.indexOf('all rashtrotthana') !== -1);
            }

            // Timing match
            var timingMatch = true;
            if (timingVal === 'morning') {
                timingMatch = (batches.indexOf('morning') !== -1 || batches.indexOf('am') !== -1);
            } else if (timingVal === 'evening') {
                timingMatch = (batches.indexOf('evening') !== -1 || batches.indexOf('pm') !== -1);
            } else if (timingVal === 'weekend') {
                timingMatch = (batches.indexOf('weekend') !== -1 || batches.indexOf('saturday') !== -1 || batches.indexOf('sunday') !== -1 || freq.indexOf('weekend') !== -1);
            }

            // Schedule Frequency match
            var scheduleMatch = true;
            if (scheduleVal === 'daily') {
                scheduleMatch = (freq.indexOf('5 days') !== -1 || freq.indexOf('6 days') !== -1 || freq.indexOf('daily') !== -1 || freq.indexOf('monday - saturday') !== -1 || freq.indexOf('monday to friday') !== -1 || freq.indexOf('mon - sat') !== -1);
            } else if (scheduleVal === 'alternate') {
                scheduleMatch = (freq.indexOf('3 days') !== -1 || freq.indexOf('2 days') !== -1 || freq.indexOf('alternative') !== -1 || freq.indexOf('4 days') !== -1);
            } else if (scheduleVal === 'weekend') {
                scheduleMatch = (freq.indexOf('weekend') !== -1 || freq.indexOf('sunday') !== -1 || freq.indexOf('saturday') !== -1 || batches.indexOf('weekend') !== -1);
            } else if (scheduleVal === 'appointment') {
                scheduleMatch = (freq.indexOf('appointment') !== -1 || freq.indexOf('consultation') !== -1);
            }

            // Target Audience / Age Group match
            var audienceMatch = true;
            if (audienceVal === 'kids') {
                audienceMatch = (elig.indexOf('children') !== -1 || elig.indexOf('kids') !== -1 || elig.indexOf('aged 6 to') !== -1 || elig.indexOf('aged 5') !== -1 || elig.indexOf('ages 5') !== -1 || elig.indexOf('ages 6') !== -1 || elig.indexOf('ages 7') !== -1 || elig.indexOf('ages 8') !== -1 || elig.indexOf('bala') !== -1 || elig.indexOf('youth') !== -1 || elig.indexOf('teens') !== -1 || title.indexOf('children') !== -1 || title.indexOf('kids') !== -1);
            } else if (audienceVal === 'adults') {
                audienceMatch = (elig.indexOf('adults') !== -1 || elig.indexOf('men') !== -1 || elig.indexOf('seniors') !== -1 || elig.indexOf('16+') !== -1 || elig.indexOf('15+') !== -1 || elig.indexOf('all') !== -1 || elig.indexOf('professionals') !== -1);
            } else if (audienceVal === 'women') {
                audienceMatch = (elig.indexOf('women') !== -1 || elig.indexOf('ladies') !== -1 || badge.indexOf('women') !== -1 || title.indexOf('prenatal') !== -1);
            } else if (audienceVal === 'therapy') {
                audienceMatch = (elig.indexOf('chronic') !== -1 || elig.indexOf('ailments') !== -1 || elig.indexOf('disorders') !== -1 || badge.indexOf('therapeutic') !== -1 || badge.indexOf('care') !== -1 || badge.indexOf('clinical') !== -1 || badge.indexOf('restorative') !== -1);
            }

            // Discipline Focus / Level match
            var focusMatch = true;
            if (focusVal === 'foundational') {
                focusMatch = (badge.indexOf('foundational') !== -1 || title.indexOf('beginner') !== -1 || badge.indexOf('all levels') !== -1 || title.indexOf('sarala') !== -1);
            } else if (focusVal === 'fitness') {
                focusMatch = (badge.indexOf('daily') !== -1 || badge.indexOf('fitness') !== -1 || badge.indexOf('stamina') !== -1 || title.indexOf('gym') !== -1 || title.indexOf('swimming') !== -1);
            } else if (focusVal === 'therapeutic') {
                focusMatch = (badge.indexOf('therap') !== -1 || badge.indexOf('care') !== -1 || badge.indexOf('holistic') !== -1 || badge.indexOf('restorative') !== -1 || badge.indexOf('clinical') !== -1 || title.indexOf('therapy') !== -1 || title.indexOf('chikitsa') !== -1 || title.indexOf('massage') !== -1 || title.indexOf('acupressure') !== -1 || title.indexOf('naturopathy') !== -1 || title.indexOf('counselling') !== -1);
            } else if (focusVal === 'classical') {
                focusMatch = (badge.indexOf('classical') !== -1 || badge.indexOf('belt') !== -1 || badge.indexOf('traditional') !== -1 || title.indexOf('karate') !== -1 || title.indexOf('kalaripayattu') !== -1 || title.indexOf('taekwondo') !== -1 || title.indexOf('bharatanatyam') !== -1 || title.indexOf('kathak') !== -1 || title.indexOf('carnatic') !== -1 || title.indexOf('hindusthani') !== -1);
            } else if (focusVal === 'cultural') {
                focusMatch = (badge.indexOf('wisdom') !== -1 || badge.indexOf('mentorship') !== -1 || badge.indexOf('artistry') !== -1 || badge.indexOf('language') !== -1 || title.indexOf('samskara') !== -1 || title.indexOf('bhagavadgita') !== -1 || title.indexOf('kannada') !== -1 || title.indexOf('calligraphy') !== -1);
            }

            // Quick Filter shortcut match
            var quickMatch = true;
            if (activeQuickFilter === 'kids') {
                quickMatch = (elig.indexOf('children') !== -1 || elig.indexOf('kids') !== -1 || elig.indexOf('aged 6 to') !== -1 || elig.indexOf('ages 5') !== -1 || title.indexOf('children') !== -1 || title.indexOf('kids') !== -1);
            } else if (activeQuickFilter === 'beginners') {
                quickMatch = (badge.indexOf('foundational') !== -1 || title.indexOf('beginner') !== -1 || badge.indexOf('all levels') !== -1);
            } else if (activeQuickFilter === 'therapy') {
                quickMatch = (badge.indexOf('therap') !== -1 || badge.indexOf('care') !== -1 || title.indexOf('therapy') !== -1 || title.indexOf('chikitsa') !== -1);
            } else if (activeQuickFilter === 'morning') {
                quickMatch = (batches.indexOf('morning') !== -1 || batches.indexOf('am') !== -1);
            } else if (activeQuickFilter === 'evening') {
                quickMatch = (batches.indexOf('evening') !== -1 || batches.indexOf('pm') !== -1);
            } else if (activeQuickFilter === 'weekend') {
                quickMatch = (batches.indexOf('weekend') !== -1 || batches.indexOf('saturday') !== -1 || batches.indexOf('sunday') !== -1 || freq.indexOf('weekend') !== -1);
            } else if (activeQuickFilter === 'women') {
                quickMatch = (elig.indexOf('women') !== -1 || elig.indexOf('ladies') !== -1 || badge.indexOf('women') !== -1 || title.indexOf('prenatal') !== -1);
            } else if (activeQuickFilter === 'classical') {
                quickMatch = (badge.indexOf('classical') !== -1 || badge.indexOf('belt') !== -1 || title.indexOf('karate') !== -1 || title.indexOf('bharatanatyam') !== -1);
            }

            if (catMatch && searchMatch && centerMatch && timingMatch && scheduleMatch && audienceMatch && focusMatch && quickMatch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Apply sorting
        sortCards(sortVal);

        // Update count text
        if (resultsCountEl) {
            resultsCountEl.textContent = 'Showing ' + visibleCount + ' matching activities';
        }

        // Show/hide no results banner
        if (noResultsBox) {
            if (visibleCount === 0) {
                noResultsBox.classList.add('is-visible');
            } else {
                noResultsBox.classList.remove('is-visible');
            }
        }

        // Render active filter badges
        renderActiveTags(query, centerVal, timingVal, scheduleVal, audienceVal, focusVal);
    }

    // Attach listeners to Search & Filters
    if (searchInput) searchInput.addEventListener('input', applyAllFilters);
    if (filterCenter) filterCenter.addEventListener('change', applyAllFilters);
    if (filterTiming) filterTiming.addEventListener('change', applyAllFilters);
    if (filterSchedule) filterSchedule.addEventListener('change', applyAllFilters);
    if (filterAudience) filterAudience.addEventListener('change', applyAllFilters);
    if (filterFocus) filterFocus.addEventListener('change', applyAllFilters);
    if (filterSort) filterSort.addEventListener('change', applyAllFilters);

    if (searchClearBtn) {
        searchClearBtn.addEventListener('click', function () {
            searchInput.value = '';
            applyAllFilters();
            searchInput.focus();
        });
    }

    // Quick Filter Buttons handler
    quickFilterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var filterKey = this.getAttribute('data-quick-filter') || 'all';
            if (activeQuickFilter === filterKey && filterKey !== 'all') {
                activeQuickFilter = 'all';
                updateQuickChipActive('all');
            } else {
                activeQuickFilter = filterKey;
                updateQuickChipActive(filterKey);
            }
            applyAllFilters();
        });
    });

    function resetAllFilters() {
        if (searchInput) searchInput.value = '';
        if (filterCenter) filterCenter.value = '';
        if (filterTiming) filterTiming.value = '';
        if (filterSchedule) filterSchedule.value = '';
        if (filterAudience) filterAudience.value = '';
        if (filterFocus) filterFocus.value = '';
        if (filterSort) filterSort.value = 'featured';
        activeQuickFilter = 'all';
        updateQuickChipActive('all');
        applyAllFilters();
    }

    if (resetFiltersBtn) resetFiltersBtn.addEventListener('click', resetAllFilters);
    if (emptyResetBtn) emptyResetBtn.addEventListener('click', resetAllFilters);

    // ── 3. Deep Linking via URL Hash (e.g. #yoga, #karate, #gym, #music-dance) ──
    var hash = window.location.hash ? window.location.hash.replace('#', '').toLowerCase() : '';
    if (hash) {
        if (hash === 'yoga' || hash === 'yoga-wellness') {
            openCategoryCatalog('yoga');
        } else if (hash === 'gym' || hash === 'fitness-sports') {
            openCategoryCatalog('gym');
        } else if (hash === 'karate' || hash === 'martial-arts') {
            openCategoryCatalog('karate');
        } else if (hash === 'music-dance' || hash === 'arts-music' || hash === 'dance') {
            openCategoryCatalog('music-dance');
        }
    }

    // ── 4. Student Registration Modal Flow ──
    var regModal = document.getElementById('rs-activity-reg-modal');
    var regBackdrop = document.getElementById('rs-reg-backdrop');
    var regCloseBtn = document.getElementById('rs-reg-close-btn');
    var regForm = document.getElementById('rs-student-reg-form');
    var regActivityDisplay = document.getElementById('rs-reg-activity-display');
    var regActivityInput = document.getElementById('rs-reg-activity-input');
    var regFeedback = document.getElementById('rs-reg-feedback');
    var regSubmitBtn = document.getElementById('rs-reg-submit-btn');
    var regConfirmCard = document.getElementById('rs-reg-confirm-card');
    var regDoneBtn = document.getElementById('rs-reg-confirm-done-btn');

    function openRegModal(activityTitle, categoryTitle, activityId) {
        regActivityDisplay.textContent = 'Enrolling in: ' + activityTitle + ' (' + categoryTitle + ')';
        regActivityInput.value = activityTitle;
        var regActIdInput = document.getElementById('rs-reg-activity-id-input');
        if (regActIdInput) regActIdInput.value = activityId || '';
        regFeedback.className = 'rs-reg-feedback';
        regFeedback.textContent = '';
        regFeedback.style.display = 'none';

        if (regConfirmCard) regConfirmCard.style.display = 'none';
        if (regForm) {
            regForm.style.display = 'block';
            regForm.reset();
        }
        regActivityInput.value = activityTitle;
        if (regActIdInput) regActIdInput.value = activityId || '';
        regModal.classList.add('is-open');
        regModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        
        var nameInput = document.getElementById('reg_student_name');
        if (nameInput) {
            setTimeout(function() { nameInput.focus(); }, 120);
        }
    }

    function closeRegModal() {
        regModal.classList.remove('is-open');
        regModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (regConfirmCard) regConfirmCard.style.display = 'none';
        if (regForm) regForm.style.display = 'block';
    }

    if (regDoneBtn) {
        regDoneBtn.addEventListener('click', closeRegModal);
    }

    // Attach click listeners to all "Register Now" buttons
    document.querySelectorAll('.rs-trigger-reg-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var activity   = this.getAttribute('data-activity') || 'Yoga Program';
            var category   = this.getAttribute('data-category') || 'Rashtrotthana Yoga';
            var activityId = this.getAttribute('data-activity-id') || '';
            openRegModal(activity, category, activityId);
        });
    });

    if (regCloseBtn) regCloseBtn.addEventListener('click', closeRegModal);
    if (regBackdrop) regBackdrop.addEventListener('click', closeRegModal);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && regModal.classList.contains('is-open')) {
            closeRegModal();
        }
    });

    // ── 5. AJAX Form Submission ──
    if (regForm) {
        regForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var sName   = document.getElementById('reg_student_name').value.trim();
            var sPhone  = document.getElementById('reg_student_phone').value.trim();
            var sEmail  = document.getElementById('reg_student_email').value.trim();
            var sAct    = document.getElementById('rs-reg-activity-input').value;
            var sCenter = document.getElementById('reg_center_choice').value;
            var sTiming = document.getElementById('reg_preferred_timing').value;
            var sNotes  = document.getElementById('reg_student_notes').value;

            regSubmitBtn.disabled = true;
            regSubmitBtn.textContent = 'Submitting Registration...';
            regFeedback.className = 'rs-reg-feedback';
            regFeedback.style.display = 'none';

            var formData = new FormData();
            formData.append('action', 'rs_submit_activity_registration');
            formData.append('nonce', document.getElementById('rs_reg_nonce').value);
            formData.append('student_name', sName);
            formData.append('student_phone', sPhone);
            formData.append('student_email', sEmail);
            formData.append('activity_name', sAct);
            var actIdEl = document.getElementById('rs-reg-activity-id-input');
            formData.append('activity_id', actIdEl ? actIdEl.value : '');
            formData.append('center_choice', sCenter);
            formData.append('preferred_timing', sTiming);
            formData.append('student_notes', sNotes);

            var ajaxUrl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function (response) { return response.json(); })
            .then(function (result) {
                regSubmitBtn.disabled = false;
                regSubmitBtn.textContent = 'Submit Student Registration';

                if (result.success) {
                    regForm.style.display = 'none';
                    if (regConfirmCard) {
                        var confGreet = document.getElementById('rs-confirm-greeting');
                        if (confGreet) confGreet.textContent = 'Namaste, ' + (sName || 'Student') + '!';
                        var confAct = document.getElementById('rs-conf-activity');
                        if (confAct) confAct.textContent = sAct || 'Yoga Program';
                        var confCen = document.getElementById('rs-conf-center');
                        if (confCen) confCen.textContent = sCenter || 'Selected Center';
                        var confTime = document.getElementById('rs-conf-timing');
                        if (confTime) confTime.textContent = sTiming || 'Regular Batch';
                        var confStud = document.getElementById('rs-conf-student');
                        if (confStud) confStud.textContent = sName + (sPhone ? ' • ' + sPhone : '');
                        var confRef = document.getElementById('rs-conf-ref');
                        var refId = (result.data && (result.data.registration_id || result.data.inquiry_id)) ? (result.data.registration_id || result.data.inquiry_id) : '';
                        if (confRef) confRef.textContent = refId ? '#RY-ACT-' + refId : '#RY-ACT';

                        regConfirmCard.style.display = 'block';
                    }
                    regForm.reset();
                } else {
                    regFeedback.className = 'rs-reg-feedback is-error';
                    regFeedback.textContent = (result.data && result.data.message) ? result.data.message : 'Registration error. Please check required fields.';
                    regFeedback.style.display = 'block';
                }
            })
            .catch(function (error) {
                regSubmitBtn.disabled = false;
                regSubmitBtn.textContent = 'Submit Student Registration';
                regFeedback.className = 'rs-reg-feedback is-error';
                regFeedback.textContent = 'Network error. Please try again or call your nearest center directly.';
                regFeedback.style.display = 'block';
            });
        });
    }
});
</script>

<?php get_footer(); ?>
