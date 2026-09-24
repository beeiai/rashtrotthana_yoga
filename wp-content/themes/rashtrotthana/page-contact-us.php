<?php
/**
 * Template Name: Contact Us Page
 * Description: Redesigned Contact Us page matching Home, Activities, Centers, and Events pages.
 */

get_header();

// Contact page data — loaded from data/contact-data.php.
// To swap in DB data, update rs_get_flagship_centers() and rs_get_faqs() in inc/data-helpers.php.
$flagship_centers = rs_get_flagship_centers();
$faqs_dataset     = rs_get_faqs();
?>

<!-- Leaflet CSS & JS for Interactive Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
/* ============================================================
   Rashtrotthana Contact Page Design System
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
.rs-contact-page {
    position: relative;
    isolation: isolate;
    overflow-x: hidden;
    background-color: var(--color-cream) !important;
    background-image:
        radial-gradient(circle at 10% 8%, rgba(249, 183, 42, .24), transparent 28rem),
        radial-gradient(circle at 90% 12%, rgba(243, 106, 33, .16), transparent 32rem),
        linear-gradient(180deg, rgba(255, 248, 236, .94) 0%, rgba(255, 248, 236, .84) 40%, rgba(255, 248, 236, .96) 100%),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/mandala-bg.jpg' ); ?>") !important;
    background-position: center top, center top, center top, center top !important;
    background-size: auto, auto, auto, 1920px auto !important;
    background-repeat: no-repeat, no-repeat, no-repeat, repeat-y !important;
    background-attachment: scroll, scroll, scroll, fixed !important;
    color: var(--color-text);
    font-family: 'Poppins', sans-serif !important;
    padding-bottom: 3.5rem;
}

.rs-contact-page * {
    font-family: 'Poppins', sans-serif !important;
    box-sizing: border-box;
}

/* Ambient Floating Glow Orbs */
.rs-contact-page::before,
.rs-contact-page::after {
    content: "";
    position: absolute;
    pointer-events: none;
    z-index: 0;
    border-radius: 50%;
}

.rs-contact-page::before {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 6% 15%, rgba(249, 183, 42, .18), transparent 28rem),
        radial-gradient(circle at 94% 22%, rgba(243, 106, 33, .14), transparent 32rem);
}

.rs-contact-page::after {
    top: 50rem;
    right: -12rem;
    width: 36rem;
    height: 36rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .22), transparent 70%);
    animation: rsc-atmosphere-pulse 5s ease-in-out infinite alternate;
}

@keyframes rsc-atmosphere-pulse {
    0%   { opacity: .25; transform: scale(.95); }
    100% { opacity: .55; transform: scale(1.08); }
}

/* Side Margins: Matching Home, Centers, and Events pages exactly */
.rs-contact-page .rs-container {
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
.rs-contact-header-section {
    padding: 3.5rem 0 2.25rem;
    text-align: center;
}

.rs-contact-title-block {
    max-width: 820px;
    margin: 0 auto;
}

.rs-contact-eyebrow {
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

.rs-contact-eyebrow-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--color-saffron);
    box-shadow: 0 0 10px rgba(243, 106, 33, .8);
    animation: rsc-dot-blink 1.8s ease-in-out infinite;
}

@keyframes rsc-dot-blink {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.35); opacity: .6; }
}

.rs-contact-page-title {
    margin: 0 0 1rem;
    color: #542019;
    font-size: clamp(2.3rem, 4vw, 3.4rem);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -.02em;
}

.rs-contact-page-title em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-contact-page-subtitle {
    margin: 0 auto 2.5rem;
    max-width: 680px;
    color: #67574c;
    font-size: clamp(1rem, 1.25vw, 1.12rem);
    line-height: 1.65;
}

/* Quick Channels Bar (4 Glassmorphic Contact Channel Cards) */
.rs-contact-channels-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2.75rem;
}

.rs-contact-channel-card {
    position: relative;
    display: flex;
    flex-direction: column;
    padding: 1.45rem 1.35rem;
    border: 1px solid rgba(143, 23, 29, .14);
    border-radius: 1.15rem;
    background: rgba(255, 253, 249, .78);
    box-shadow: 0 10px 28px rgba(89, 37, 24, .07), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    text-align: left;
    transition: transform 220ms cubic-bezier(.2,.8,.2,1), box-shadow 220ms ease, border-color 220ms ease;
    text-decoration: none;
    color: inherit;
}

.rs-contact-channel-card::after {
    position: absolute;
    top: 0;
    right: 1.2rem;
    width: 3.5rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
}

.rs-contact-channel-card:hover {
    transform: translateY(-5px);
    border-color: rgba(243, 106, 33, .45);
    box-shadow: 0 18px 36px rgba(89, 37, 24, .12), 0 0 20px rgba(249, 183, 42, .12), inset 0 1px 0 #fff;
}

.rs-channel-header {
    display: flex;
    align-items: center;
    gap: .85rem;
    margin-bottom: .85rem;
}

.rs-channel-icon-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(143, 23, 29, .08);
    border: 1px solid rgba(143, 23, 29, .14);
    color: var(--color-maroon);
    flex-shrink: 0;
    transition: background 180ms ease, color 180ms ease;
}

.rs-contact-channel-card:hover .rs-channel-icon-wrap {
    background: var(--color-maroon);
    color: #fff;
    box-shadow: 0 4px 14px rgba(143, 23, 29, .3);
}

.rs-channel-icon-wrap svg {
    width: 22px;
    height: 22px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.rs-channel-title {
    margin: 0;
    font-size: 1.05rem;
    font-weight: 700;
    color: #542019;
}

.rs-channel-value {
    display: block;
    margin-bottom: .35rem;
    font-size: .95rem;
    font-weight: 700;
    color: var(--color-maroon);
    line-height: 1.35;
    word-break: break-word;
}

.rs-channel-timing {
    margin: 0;
    font-size: .78rem;
    line-height: 1.45;
    color: #79695f;
}

.rs-channel-cta-link {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    margin-top: auto;
    padding-top: .85rem;
    border-top: 1px dashed rgba(143, 23, 29, .12);
    font-size: .8rem;
    font-weight: 700;
    color: var(--color-saffron);
    transition: color 160ms ease, transform 160ms ease;
}

.rs-contact-channel-card:hover .rs-channel-cta-link {
    color: var(--color-maroon);
    transform: translateX(3px);
}

/* ============================================================
   Main Interactive Section: Message Form & Leaflet Map
   ============================================================ */
.rs-contact-main-section {
    padding: 1.5rem 0 3.5rem;
}

.rs-contact-split-grid {
    display: grid;
    grid-template-columns: 1.05fr 1.15fr;
    gap: 2rem;
    align-items: stretch;
}

/* Form Glass Card */
.rs-contact-form-card {
    position: relative;
    display: flex;
    flex-direction: column;
    padding: 2.25rem 2.25rem 2rem;
    border: 1px solid rgba(143, 23, 29, .14);
    border-radius: 1.35rem;
    background: rgba(255, 253, 249, .82);
    box-shadow: 0 16px 36px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .95);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
}

.rs-contact-form-card::after {
    position: absolute;
    top: 0;
    right: 2rem;
    width: 5rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 14px rgba(249, 183, 42, .85);
    content: "";
}

.rs-form-card-header {
    margin-bottom: 1.6rem;
}

.rs-form-card-header h2 {
    margin: 0 0 .4rem;
    color: #542019;
    font-size: clamp(1.6rem, 2.4vw, 2.1rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -.015em;
}

.rs-form-card-header h2::after {
    content: "";
    display: block;
    width: 44px;
    height: 4px;
    margin-top: .55rem;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--color-maroon), var(--color-saffron));
}

.rs-form-card-header p {
    margin: .55rem 0 0;
    color: #67574c;
    font-size: .88rem;
    line-height: 1.5;
}

/* Form Controls */
.rs-contact-interactive-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.15rem;
}

.rs-form-group-wide {
    grid-column: 1 / -1;
}

.rs-form-field-wrap {
    display: flex;
    flex-direction: column;
    gap: .4rem;
}

.rs-form-field-wrap label {
    font-size: .82rem;
    font-weight: 600;
    color: #542019;
}

.rs-form-field-wrap label span.req {
    color: var(--color-maroon);
}

.rs-contact-input,
.rs-contact-select,
.rs-contact-textarea {
    width: 100%;
    height: 2.75rem;
    padding: .55rem 1rem;
    border: 1px solid rgba(143, 23, 29, .22);
    border-radius: .7rem;
    background: rgba(255, 255, 255, .92);
    color: #4a271f;
    font-family: 'Poppins', sans-serif;
    font-size: .86rem;
    outline: none;
    transition: border-color 180ms ease, box-shadow 180ms ease, background 180ms ease;
}

.rs-contact-input:focus,
.rs-contact-select:focus,
.rs-contact-textarea:focus {
    border-color: var(--color-maroon);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .14);
}

.rs-contact-input::placeholder,
.rs-contact-textarea::placeholder {
    color: #937f72;
    font-size: .84rem;
}

.rs-contact-select {
    padding-right: 2.2rem;
    appearance: none;
    -webkit-appearance: none;
    background: rgba(255, 255, 255, .92) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%238F171D' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right .85rem center;
    cursor: pointer;
}

.rs-contact-textarea {
    height: auto;
    min-height: 120px;
    padding: .75rem 1rem;
    resize: vertical;
    line-height: 1.55;
}

/* Submit Button (Home-Page Styled Maroon Pill) */
.rs-contact-submit-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: .55rem !important;
    min-width: 175px !important;
    height: 2.85rem !important;
    padding: 0 1.65rem !important;
    border: 1px solid #B31B1B !important;
    border-radius: 999px !important;
    background: #B31B1B !important;
    box-shadow: 0 8px 22px rgba(179, 27, 27, .3), inset 0 1px 0 rgba(255, 255, 255, .4) !important;
    color: #fff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: .88rem !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    cursor: pointer !important;
    white-space: nowrap !important;
    transition: transform 180ms ease, box-shadow 180ms ease, background-color 180ms ease !important;
}

.rs-contact-submit-btn:hover {
    transform: translateY(-2px) !important;
    background: #8F171D !important;
    box-shadow: 0 12px 28px rgba(179, 27, 27, .42), 0 0 18px rgba(243, 106, 33, .25), inset 0 1px 0 #fff !important;
}

.rs-contact-submit-btn svg {
    width: 16px;
    height: 16px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2.2;
    transition: transform 180ms ease;
}

.rs-contact-submit-btn:hover svg {
    transform: translateX(3px);
}

/* Form Success & Feedback Alert */
.rs-form-alert {
    display: none;
    margin-top: 1.25rem;
    padding: 1rem 1.25rem;
    border-radius: .85rem;
    font-size: .85rem;
    line-height: 1.5;
    animation: rsc-fade-in 300ms ease;
}

.rs-form-alert.is-success {
    display: none;
    align-items: flex-start;
    gap: .75rem;
    background: #f1f8ea;
    border: 1px solid #b5d89b;
    color: #2b5717;
}

.rs-form-alert.is-success.is-visible {
    display: flex;
}

.rs-form-alert.is-success strong {
    display: block;
    font-weight: 700;
    margin-bottom: 2px;
}

@keyframes rsc-fade-in {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ============================================================
   Leaflet Map Column & Head Office Overlay Card
   ============================================================ */
.rs-contact-map-card {
    position: relative;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(143, 23, 29, .14);
    border-radius: 1.35rem;
    background: rgba(255, 253, 249, .82);
    box-shadow: 0 16px 36px rgba(89, 37, 24, .08);
    overflow: hidden;
    min-height: 520px;
}

.rs-contact-map-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.15rem 1.5rem;
    border-bottom: 1px solid rgba(143, 23, 29, .12);
    background: rgba(255, 255, 255, .7);
}

.rs-contact-map-header h3 {
    margin: 0;
    font-size: 1.05rem;
    font-weight: 800;
    color: #542019;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.rs-contact-map-header h3 svg {
    width: 18px;
    height: 18px;
    stroke: var(--color-maroon);
    stroke-width: 2.2;
    fill: none;
}

.rs-map-filter-hint {
    font-size: .78rem;
    font-weight: 600;
    color: var(--color-saffron);
}

/* Map Canvas Container */
.rs-leaflet-canvas-container {
    position: relative;
    flex: 1 1 auto;
    width: 100%;
    min-height: 420px;
}

#rs-contact-leaflet-map {
    width: 100%;
    height: 100%;
    min-height: 420px;
    z-index: 1;
}

/* Leaflet Custom Marker Styling */
.rs-leaflet-custom-marker {
    background: transparent;
    border: none;
}

.rs-leaflet-pin-wrap {
    position: relative;
    width: 38px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    filter: drop-shadow(0 6px 12px rgba(89, 37, 24, .3));
    cursor: pointer;
    transition: transform 180ms ease;
}

.rs-leaflet-pin-wrap:hover,
.rs-leaflet-pin-wrap.is-active {
    transform: scale(1.18) translateY(-4px);
}

.rs-leaflet-pin-wrap.is-hq .rs-pin-svg path {
    fill: #8F171D;
    stroke: #F9B72A;
    stroke-width: 2;
}

.rs-leaflet-pin-wrap .rs-pin-badge {
    position: absolute;
    top: 6px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-maroon);
    font-size: 10px;
    font-weight: 800;
}

/* Custom Leaflet Popup */
.rs-custom-leaflet-popup .leaflet-popup-content-wrapper {
    background: rgba(255, 253, 249, .96) !important;
    backdrop-filter: blur(14px) !important;
    -webkit-backdrop-filter: blur(14px) !important;
    border: 1px solid rgba(143, 23, 29, .2) !important;
    border-radius: 1rem !important;
    box-shadow: 0 12px 30px rgba(89, 37, 24, .2) !important;
    padding: .85rem 1rem !important;
    color: #4a271f !important;
    font-family: 'Poppins', sans-serif !important;
}

.rs-custom-leaflet-popup .leaflet-popup-tip {
    background: rgba(255, 253, 249, .96) !important;
}

.rs-map-popup-inner h4 {
    margin: 0 0 .25rem;
    font-size: .96rem;
    font-weight: 800;
    color: #542019;
}

.rs-map-popup-badge {
    display: inline-block;
    padding: 2px 7px;
    border-radius: 4px;
    background: #fff0d8;
    color: #a34812;
    font-size: .68rem;
    font-weight: 700;
    margin-bottom: .45rem;
}

.rs-map-popup-inner p {
    margin: 0 0 .5rem;
    font-size: .78rem;
    line-height: 1.4;
    color: #67574c;
}

.rs-map-popup-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    margin-top: .4rem;
    padding-top: .4rem;
    border-top: 1px dashed rgba(143, 23, 29, .15);
}

.rs-map-popup-phone {
    font-size: .78rem;
    font-weight: 700;
    color: var(--color-maroon);
}

.rs-map-popup-dir {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: .78rem;
    font-weight: 700;
    color: var(--color-saffron);
}

.rs-map-popup-dir:hover {
    color: var(--color-maroon);
    text-decoration: underline;
}

/* Floating Head Office Overlay Bar at Bottom of Map */
.rs-map-hq-overlay {
    padding: 1rem 1.4rem;
    background: rgba(255, 253, 249, .94);
    border-top: 1px solid rgba(143, 23, 29, .12);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.rs-map-hq-info {
    display: flex;
    flex-direction: column;
}

.rs-map-hq-info strong {
    color: #542019;
    font-size: .92rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: .35rem;
}

.rs-map-hq-info span {
    color: #67574c;
    font-size: .78rem;
    line-height: 1.35;
    margin-top: 2px;
}

.rs-map-hq-directions-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .45rem 1.05rem;
    border-radius: 999px;
    border: 1px solid rgba(143, 23, 29, .22);
    background: #fff;
    color: var(--color-maroon);
    font-size: .78rem;
    font-weight: 700;
    white-space: nowrap;
    box-shadow: 0 4px 12px rgba(89, 37, 24, .08);
    transition: all 180ms ease;
}

.rs-map-hq-directions-btn:hover {
    background: var(--color-maroon);
    color: #fff;
    border-color: var(--color-maroon);
    box-shadow: 0 6px 18px rgba(143, 23, 29, .24);
}

/* ============================================================
   Section Headings (Matching Activities, Centers, Events)
   ============================================================ */
.rs-contact-section {
    padding: 2.75rem 0 3.25rem;
    position: relative;
}

.rs-section-header-wrap {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
}

.rs-section-header-wrap h2 {
    position: relative;
    margin: 0;
    color: #542019;
    font-size: clamp(1.85rem, 3vw, 2.5rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -.015em;
}

.rs-section-header-wrap h2 em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-section-header-wrap h2::after {
    content: "";
    display: block;
    width: 48px;
    height: 4px;
    margin-top: .65rem;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--color-maroon), var(--color-saffron));
}

.rs-section-desc {
    max-width: 580px;
    margin: .4rem 0 0;
    color: #67574c;
    font-size: .92rem;
    line-height: 1.55;
}

.rs-all-centers-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .55rem 1.25rem;
    border: 1px solid rgba(143, 23, 29, .25);
    border-radius: 999px;
    background: rgba(255, 255, 255, .75);
    color: var(--color-maroon);
    font-size: .84rem;
    font-weight: 700;
    transition: all 180ms ease;
    box-shadow: 0 4px 14px rgba(89, 37, 24, .06);
}

.rs-all-centers-btn:hover {
    background: var(--color-maroon);
    color: #fff;
    box-shadow: 0 8px 22px rgba(143, 23, 29, .25);
    transform: translateY(-2px);
}

/* ============================================================
   Connect with Flagship Centers (4 Equal-Sized Glass Cards)
   ============================================================ */
.rs-contact-centers-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.35rem;
}

.rs-contact-center-card {
    position: relative;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(143, 23, 29, .13);
    border-radius: 1.2rem;
    background: rgba(255, 253, 249, .75);
    box-shadow: 0 12px 30px rgba(89, 37, 24, .07), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    overflow: hidden;
    transition: transform 240ms cubic-bezier(.2,.8,.2,1), box-shadow 240ms ease, border-color 240ms ease;
    height: 100%;
}

.rs-contact-center-card::after {
    position: absolute;
    top: 0;
    right: 1.2rem;
    width: 3.5rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
}

.rs-contact-center-card:hover {
    transform: translateY(-6px);
    border-color: rgba(243, 106, 33, .45);
    box-shadow: 0 20px 40px rgba(89, 37, 24, .14), 0 0 18px rgba(249, 183, 42, .12), inset 0 1px 0 #fff;
}

.rs-contact-center-media {
    position: relative;
    width: 100%;
    height: 160px;
    overflow: hidden;
    background: var(--color-sand);
}

.rs-contact-center-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 400ms ease;
}

.rs-contact-center-card:hover .rs-contact-center-media img {
    transform: scale(1.08);
}

.rs-contact-center-badge {
    position: absolute;
    top: .75rem;
    right: .75rem;
    padding: .25rem .65rem;
    border-radius: 999px;
    background: rgba(84, 32, 25, .82);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    color: #fff;
    font-size: .68rem;
    font-weight: 700;
}

.rs-contact-center-body {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    padding: 1.15rem 1.25rem 1.25rem;
}

.rs-contact-center-title {
    margin: 0 0 .5rem;
    font-size: 1.05rem;
    font-weight: 700;
    color: #542019;
    line-height: 1.3;
}

.rs-contact-center-meta {
    display: flex;
    flex-direction: column;
    gap: .4rem;
    margin-bottom: 1rem;
}

.rs-contact-center-meta-item {
    display: flex;
    align-items: flex-start;
    gap: .45rem;
    font-size: .8rem;
    color: #756a61;
    line-height: 1.35;
}

.rs-contact-center-meta-item svg {
    width: 14px;
    height: 14px;
    stroke: var(--color-maroon);
    stroke-width: 2;
    fill: none;
    flex-shrink: 0;
    margin-top: 2px;
}

.rs-contact-center-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: .8rem;
    border-top: 1px solid rgba(143, 23, 29, .1);
}

.rs-contact-center-footer a {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .8rem;
    font-weight: 700;
    color: var(--color-saffron);
    transition: color 160ms ease, transform 160ms ease;
}

.rs-contact-center-footer a:hover {
    color: var(--color-maroon);
    transform: translateX(3px);
}

/* ============================================================
   Frequently Asked Questions (Accessible & Polished Accordion)
   ============================================================ */
.rs-contact-faq-section {
    padding: 1.5rem 0 3.5rem;
}

.rs-faq-accordion-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 920px;
    margin: 0 auto;
}

.rs-faq-card {
    border: 1px solid rgba(143, 23, 29, .13);
    border-radius: 1.15rem;
    background: rgba(255, 253, 249, .8);
    box-shadow: 0 6px 20px rgba(89, 37, 24, .05), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    overflow: hidden;
    transition: border-color 200ms ease, box-shadow 200ms ease;
}

.rs-faq-card.is-active {
    border-color: rgba(243, 106, 33, .45);
    box-shadow: 0 12px 30px rgba(89, 37, 24, .1);
}

.rs-faq-trigger {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.25rem;
    padding: 1.25rem 1.6rem;
    border: none;
    background: transparent;
    color: #542019;
    font-family: 'Poppins', sans-serif;
    font-size: 1.02rem;
    font-weight: 700;
    text-align: left;
    cursor: pointer;
    line-height: 1.4;
    transition: color 180ms ease;
}

.rs-faq-trigger:hover {
    color: var(--color-maroon);
}

.rs-faq-icon-pill {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid rgba(143, 23, 29, .2);
    background: #fff;
    color: var(--color-maroon);
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1;
    flex-shrink: 0;
    transition: all 220ms ease;
}

.rs-faq-card.is-active .rs-faq-icon-pill {
    background: var(--color-maroon);
    color: #fff;
    transform: rotate(45deg);
    border-color: var(--color-maroon);
    box-shadow: 0 4px 12px rgba(143, 23, 29, .25);
}

.rs-faq-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 320ms cubic-bezier(.2,.8,.2,1), padding 320ms ease;
}

.rs-faq-body-inner {
    padding: 0 1.6rem 1.35rem;
    color: #67574c;
    font-size: .92rem;
    line-height: 1.65;
    border-top: 1px dashed rgba(143, 23, 29, .12);
    padding-top: 1rem;
}

/* ============================================================
   Immediate Assistance Callout Banner (Home/Centers Design)
   ============================================================ */
.rs-contact-assistance-banner {
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

.rs-assistance-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.rs-assistance-icon {
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

.rs-assistance-icon svg {
    width: 28px;
    height: 28px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2.2;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.rs-assistance-text strong {
    display: block;
    font-size: 1.25rem;
    font-weight: 800;
    color: #542019;
    margin-bottom: .25rem;
}

.rs-assistance-text p {
    margin: 0;
    font-size: .9rem;
    color: #67574c;
    line-height: 1.45;
}

.rs-assistance-actions {
    display: flex;
    align-items: center;
    gap: .85rem;
    flex-shrink: 0;
}

.rs-assistance-call-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .75rem 1.45rem;
    border-radius: 999px;
    background: var(--color-maroon);
    color: #fff;
    font-size: .86rem;
    font-weight: 700;
    box-shadow: 0 8px 22px rgba(143, 23, 29, .28);
    transition: all 180ms ease;
    white-space: nowrap;
}

.rs-assistance-call-btn:hover {
    background: #6e1015;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(143, 23, 29, .4);
    color: #fff;
}

.rs-assistance-whatsapp-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .75rem 1.45rem;
    border-radius: 999px;
    background: #fff;
    border: 1px solid rgba(143, 23, 29, .2);
    color: #436928;
    font-size: .86rem;
    font-weight: 700;
    box-shadow: 0 6px 16px rgba(89, 37, 24, .06);
    transition: all 180ms ease;
    white-space: nowrap;
}

.rs-assistance-whatsapp-btn:hover {
    border-color: #436928;
    background: #f7faf4;
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(67, 105, 40, .18);
    color: #436928;
}

/* ============================================================
   Responsive Media Queries
   ============================================================ */
@media (max-width: 1080px) {
    .rs-contact-channels-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .rs-contact-split-grid {
        grid-template-columns: 1fr;
    }
    .rs-contact-centers-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .rs-contact-channels-grid {
        grid-template-columns: 1fr;
    }
    .rs-contact-centers-grid {
        grid-template-columns: 1fr;
    }
    .rs-contact-interactive-form {
        grid-template-columns: 1fr;
    }
    .rs-contact-form-card {
        padding: 1.5rem;
    }
    .rs-contact-assistance-banner {
        flex-direction: column;
        text-align: center;
        padding: 1.75rem;
    }
    .rs-assistance-content {
        flex-direction: column;
    }
    .rs-assistance-actions {
        flex-direction: column;
        width: 100%;
    }
    .rs-assistance-call-btn,
    .rs-assistance-whatsapp-btn {
        width: 100%;
        justify-content: center;
    }
    .rs-map-hq-overlay {
        flex-direction: column;
        align-items: flex-start;
    }
    .rs-map-hq-directions-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<main class="rs-contact-page" id="main-content">
    <!-- Page Header Block (Hero Removed) -->
    <header class="rs-contact-header-section">
        <div class="rs-container">
            <div class="rs-contact-title-block">
                <div class="rs-contact-eyebrow">
                    <span class="rs-contact-eyebrow-dot" aria-hidden="true"></span>
                    <span>Community &amp; Assistance</span>
                </div>
                <h1 class="rs-contact-page-title">We’re Here to <em>Connect</em> with You</h1>
                <p class="rs-contact-page-subtitle">
                    Have a question, need assistance with yoga batch enrolments, or looking to visit our centers? Reach out through any of our direct channels below.
                </p>
            </div>

            <!-- Quick Contact Channels Bar (4 Glass Cards) -->
            <div class="rs-contact-channels-grid">
                <!-- Phone Support -->
                <a href="tel:+918026644444" class="rs-contact-channel-card" aria-label="Call central support">
                    <div class="rs-channel-header">
                        <div class="rs-channel-icon-wrap" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <h3 class="rs-channel-title">Call Us</h3>
                    </div>
                    <strong class="rs-channel-value">080 2664 4444</strong>
                    <p class="rs-channel-timing">Mon – Sat: 5:00 AM – 9:00 PM<br>Sun: 6:00 AM – 1:00 PM</p>
                    <span class="rs-channel-cta-link">Call Now &rarr;</span>
                </a>

                <!-- WhatsApp Desk -->
                <a href="https://wa.me/918095552361" target="_blank" rel="noopener" class="rs-contact-channel-card" aria-label="Chat on WhatsApp">
                    <div class="rs-channel-header">
                        <div class="rs-channel-icon-wrap" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        </div>
                        <h3 class="rs-channel-title">WhatsApp</h3>
                    </div>
                    <strong class="rs-channel-value">+91 80955 52361</strong>
                    <p class="rs-channel-timing">Instant replies and queries<br>during working hours</p>
                    <span class="rs-channel-cta-link">Start Chat &rarr;</span>
                </a>

                <!-- Email Support -->
                <a href="mailto:info@rashtrotthanayoga.org" class="rs-contact-channel-card" aria-label="Send email">
                    <div class="rs-channel-header">
                        <div class="rs-channel-icon-wrap" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <h3 class="rs-channel-title">Email Us</h3>
                    </div>
                    <strong class="rs-channel-value">info@rashtrotthanayoga.org</strong>
                    <p class="rs-channel-timing">We respond within<br>24 working hours</p>
                    <span class="rs-channel-cta-link">Write to Us &rarr;</span>
                </a>

                <!-- Visit Head Office -->
                <a href="#rs-contact-map-section" class="rs-contact-channel-card" aria-label="View Head Office on map">
                    <div class="rs-channel-header">
                        <div class="rs-channel-icon-wrap" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h3 class="rs-channel-title">Visit Us</h3>
                    </div>
                    <strong class="rs-channel-value">Jayanagar Head Office</strong>
                    <p class="rs-channel-timing">#23, 4th Cross, 4th Block,<br>Bengaluru – 560011</p>
                    <span class="rs-channel-cta-link">Locate on Map &rarr;</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main 2-Column Section: Send Message Form + Interactive Leaflet Map -->
    <section class="rs-contact-main-section" id="rs-contact-map-section">
        <div class="rs-container">
            <div class="rs-contact-split-grid">
                <!-- Column 1: Send Us a Message Form -->
                <div class="rs-contact-form-card">
                    <div class="rs-form-card-header">
                        <h2>Send Us a Message</h2>
                        <p>Fill out the form below with your requirements and our counseling team will get in touch with you shortly.</p>
                    </div>

                    <form class="rs-contact-interactive-form" id="rs-contact-main-form" action="#" method="post">
                        <!-- Full Name -->
                        <div class="rs-form-field-wrap">
                            <label for="contact-name">Full Name <span class="req">*</span></label>
                            <input type="text" id="contact-name" name="name" class="rs-contact-input" placeholder="e.g. Anand Sharma" required minlength="2" maxlength="70" pattern="[A-Za-zÀ-ÿ .'-]+" title="Please enter your full name.">
                        </div>

                        <!-- Email Address -->
                        <div class="rs-form-field-wrap">
                            <label for="contact-email">Email Address <span class="req">*</span></label>
                            <input type="email" id="contact-email" name="email" class="rs-contact-input" placeholder="e.g. anand@example.com" required maxlength="100" autocomplete="email">
                        </div>

                        <!-- Phone Number -->
                        <div class="rs-form-field-wrap">
                            <label for="contact-phone">Phone / WhatsApp <span class="req">*</span></label>
                            <input type="tel" id="contact-phone" name="phone" class="rs-contact-input" placeholder="e.g. +91 98765 43210" required pattern="[0-9+() -]{7,20}" minlength="7" maxlength="20" inputmode="tel" title="Please enter a valid phone number.">
                        </div>

                        <!-- Topic Dropdown -->
                        <div class="rs-form-field-wrap">
                            <label for="contact-topic">Inquiry Topic <span class="req">*</span></label>
                            <select id="contact-topic" name="topic" class="rs-contact-select" required>
                                <option value="" selected disabled>Select a topic...</option>
                                <option value="general-classes">Regular Yoga &amp; Pranayama Classes</option>
                                <option value="center-inquiry">Bengaluru Center Batch Enquiry</option>
                                <option value="yoga-therapy">Yoga Therapy &amp; Holistic Healing</option>
                                <option value="online-classes">Online Live Zoom Batches</option>
                                <option value="children-seniors">Children &amp; Senior Citizen Yoga</option>
                                <option value="events-workshops">Upcoming Events &amp; Workshops</option>
                                <option value="other">Other Suggestions / Feedback</option>
                            </select>
                        </div>

                        <!-- Subject -->
                        <div class="rs-form-field-wrap rs-form-group-wide">
                            <label for="contact-subject">Subject <span class="req">*</span></label>
                            <input type="text" id="contact-subject" name="subject" class="rs-contact-input" placeholder="e.g. Morning batch availability at Jayanagar" required minlength="3" maxlength="120">
                        </div>

                        <!-- Message Body -->
                        <div class="rs-form-field-wrap rs-form-group-wide">
                            <label for="contact-message">Your Message <span class="req">*</span></label>
                            <textarea id="contact-message" name="message" class="rs-contact-textarea" placeholder="Please share any specific health conditions, batch preference, or questions..." required minlength="10" maxlength="1200" rows="5"></textarea>
                        </div>

                        <!-- Submit Action -->
                        <div class="rs-form-group-wide" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-top: .5rem;">
                            <button type="submit" class="rs-contact-submit-btn" id="rs-contact-submit-btn">
                                <span>Send Message</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </button>
                            <span style="font-size: .78rem; color: #79695f;">Fields marked with <span style="color: var(--color-maroon);">*</span> are required.</span>
                        </div>
                    </form>

                    <!-- Success Feedback Alert (Hidden by default, shown only after submit) -->
                    <div class="rs-form-alert is-success" id="rs-contact-success-alert" role="alert" style="display: none;">
                        <svg style="width: 24px; height: 24px; stroke: #2b5717; stroke-width: 2.2; fill: none; flex-shrink: 0;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <div>
                            <strong>Thank you for reaching out!</strong>
                            <span>Your message has been received. Our counselors will review your request and get back to you within 24 working hours.</span>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Interactive Leaflet Map -->
                <div class="rs-contact-map-card">
                    <div class="rs-contact-map-header">
                        <h3>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>Interactive Bengaluru Centers Map</span>
                        </h3>
                        <span class="rs-map-filter-hint">6 Key Shalas Marked</span>
                    </div>

                    <!-- Leaflet Canvas -->
                    <div class="rs-leaflet-canvas-container">
                        <div id="rs-contact-leaflet-map"></div>
                    </div>

                    <!-- Head Office Quick Info Footer Bar -->
                    <div class="rs-map-hq-overlay">
                        <div class="rs-map-hq-info">
                            <strong>
                                <svg style="width: 15px; height: 15px; stroke: var(--color-maroon); stroke-width: 2.5; fill: none;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Head Office &amp; Central Shala</span>
                            </strong>
                            <span>No. 23, 4th Cross, 4th Block, Jayanagar, Bengaluru – 560011</span>
                        </div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=Rashtrotthana+Yoga+Jayanagar+Bengaluru" target="_blank" rel="noopener" class="rs-map-hq-directions-btn">
                            <span>Get Directions</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Connect with Flagship Centers Section -->
    <section class="rs-contact-section">
        <div class="rs-container">
            <div class="rs-section-header-wrap">
                <div>
                    <h2>Connect with Our <em>Centers</em></h2>
                    <p class="rs-section-desc">Visit our spacious yoga shalas across Bengaluru for in-person consultations, trial sessions, and holistic community activities.</p>
                </div>
                <a href="<?php echo esc_url( home_url( '/centers/' ) ); ?>" class="rs-all-centers-btn">
                    <span>Explore All 23+ Centers</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="rs-contact-centers-grid">
                <?php foreach ( array_slice( $flagship_centers, 0, 4 ) as $center ) : ?>
                    <article class="rs-contact-center-card">
                        <div class="rs-contact-center-media">
                            <img src="<?php echo esc_url( $center['image'] ); ?>" alt="<?php echo esc_attr( $center['name'] ); ?>" loading="lazy">
                            <?php if ( ! empty( $center['is_hq'] ) ) : ?>
                                <span class="rs-contact-center-badge">Head Office</span>
                            <?php else : ?>
                                <span class="rs-contact-center-badge">Bengaluru Shala</span>
                            <?php endif; ?>
                        </div>

                        <div class="rs-contact-center-body">
                            <h3 class="rs-contact-center-title"><?php echo esc_html( $center['name'] ); ?></h3>
                            
                            <div class="rs-contact-center-meta">
                                <div class="rs-contact-center-meta-item">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span><?php echo esc_html( $center['address'] ); ?></span>
                                </div>
                                <div class="rs-contact-center-meta-item">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span><?php echo esc_html( $center['phone'] ); ?></span>
                                </div>
                            </div>

                            <div class="rs-contact-center-footer">
                                <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $center['phone'] ) ); ?>">
                                    <span>Call Center</span> &rarr;
                                </a>
                                <a href="<?php echo esc_url( home_url( '/centers/#' . $center['id'] ) ); ?>" style="color: var(--color-maroon);">
                                    <span>View Details</span> &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Frequently Asked Questions (FAQ) Accordion Section -->
    <section class="rs-contact-faq-section" id="faqs">
        <div class="rs-container">
            <div class="rs-section-header-wrap" style="text-align: center; justify-content: center; flex-direction: column; align-items: center;">
                <h2>Frequently Asked <em>Questions</em></h2>
                <p class="rs-section-desc" style="text-align: center;">
                    Everything you need to know about class timings, trial registrations, online programs, and yoga therapy.
                </p>
            </div>

            <div class="rs-faq-accordion-list" role="region" aria-label="Frequently Asked Questions">
                <?php foreach ( $faqs_dataset as $idx => $faq ) : ?>
                    <div class="rs-faq-card<?php echo ( $idx === 0 ) ? ' is-active' : ''; ?>" id="faq-item-<?php echo esc_attr( $idx ); ?>">
                        <button type="button" 
                                class="rs-faq-trigger" 
                                aria-expanded="<?php echo ( $idx === 0 ) ? 'true' : 'false'; ?>" 
                                aria-controls="faq-body-<?php echo esc_attr( $idx ); ?>">
                            <span><?php echo esc_html( $faq['q'] ); ?></span>
                            <span class="rs-faq-icon-pill" aria-hidden="true">+</span>
                        </button>
                        <div class="rs-faq-body" id="faq-body-<?php echo esc_attr( $idx ); ?>" style="<?php echo ( $idx === 0 ) ? 'max-height: 400px;' : ''; ?>">
                            <div class="rs-faq-body-inner">
                                <p><?php echo esc_html( $faq['a'] ); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Immediate Assistance Callout Banner -->
            <div class="rs-contact-assistance-banner">
                <div class="rs-assistance-content">
                    <div class="rs-assistance-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </div>
                    <div class="rs-assistance-text">
                        <strong>Need Immediate Assistance?</strong>
                        <p>Our counselors are available Monday through Saturday to answer questions about batch availability and admissions.</p>
                    </div>
                </div>
                <div class="rs-assistance-actions">
                    <a href="tel:+918026644444" class="rs-assistance-call-btn">
                        <svg style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.2;" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>080 2664 4444</span>
                    </a>
                    <a href="https://wa.me/918095552361" target="_blank" rel="noopener" class="rs-assistance-whatsapp-btn">
                        <svg style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.2;" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        <span>WhatsApp Support</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ============================================================
    // 1. LEAFLET MAP INITIALIZATION & BRANDED MARKERS
    // ============================================================
    var mapContainer = document.getElementById('rs-contact-leaflet-map');
    if (mapContainer && typeof L !== 'undefined') {
        // Initialize Map centered on Jayanagar Head Office
        var map = L.map('rs-contact-leaflet-map', {
            center: [12.9450, 77.5850],
            zoom: 12,
            scrollWheelZoom: false
        });

        // Crisp, clean CartoDB Voyager tiles (No API key needed)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Centers dataset for map markers
        var mapCenters = <?php echo json_encode( $flagship_centers ); ?>;

        var mapIconUrl = '<?php echo esc_url( get_template_directory_uri() . "/assets/images/map_icon.png" ); ?>';

        function createCustomPin(isHQ) {
            return L.divIcon({
                className: 'rs-leaflet-custom-marker',
                html: '<div class="rs-map-flag-pin' + (isHQ ? ' is-highlighted' : '') + '">' +
                      '<div class="rs-flag-base-shadow"></div>' +
                      '<img src="' + mapIconUrl + '" class="rs-map-flag-img" alt="Center Marker">' +
                      (isHQ ? '<div class="rs-flag-pulse"></div>' : '') +
                      '</div>',
                iconSize: [38, 52],
                iconAnchor: [4, 51],
                popupAnchor: [15, -48]
            });
        }

        var markersGroup = L.featureGroup().addTo(map);

        mapCenters.forEach(function (center) {
            var marker = L.marker([center.lat, center.lng], {
                icon: createCustomPin(center.is_hq),
                title: center.name
            });

            var directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + encodeURIComponent(center.name + ' ' + center.address);

            var popupHtml = '<div class="rs-map-popup-inner">' +
                '<h4>' + center.name + '</h4>' +
                '<span class="rs-map-popup-badge">' + (center.is_hq ? 'Head Office & Central Shala' : center.area) + '</span>' +
                '<p>' + center.address + '</p>' +
                '<div class="rs-map-popup-actions">' +
                    '<a href="tel:' + center.phone.replace(/[^0-9+]/g, '') + '" class="rs-map-popup-phone">☎ ' + center.phone + '</a>' +
                    '<a href="' + directionsUrl + '" target="_blank" rel="noopener" class="rs-map-popup-dir">Directions &rarr;</a>' +
                '</div>' +
            '</div>';

            marker.bindPopup(popupHtml, {
                maxWidth: 290,
                className: 'rs-custom-leaflet-popup'
            });

            markersGroup.addLayer(marker);

            // Automatically open Head Office popup on desktop
            if (center.is_hq && window.innerWidth > 992) {
                setTimeout(function () {
                    marker.openPopup();
                }, 600);
            }
        });

        // Fit bounds comfortably to all flagship centers
        map.fitBounds(markersGroup.getBounds().pad(0.12));
    }

    // ============================================================
    // 2. CONTACT FORM SUBMISSION & USER FEEDBACK
    // ============================================================
    var contactForm = document.getElementById('rs-contact-main-form');
    var successAlert = document.getElementById('rs-contact-success-alert');
    var submitBtn = document.getElementById('rs-contact-submit-btn');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!contactForm.checkValidity()) {
                contactForm.reportValidity();
                return;
            }

            var originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Sending Message...</span>';

            setTimeout(function () {
                contactForm.reset();
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;

                if (successAlert) {
                    successAlert.style.display = 'flex';
                    successAlert.classList.add('is-visible');
                    successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                    setTimeout(function () {
                        successAlert.style.display = 'none';
                        successAlert.classList.remove('is-visible');
                    }, 8000);
                }
            }, 900);
        });
    }

    // ============================================================
    // 3. ACCESSIBLE FAQ ACCORDION CONTROLLER
    // ============================================================
    var faqCards = document.querySelectorAll('.rs-faq-card');

    faqCards.forEach(function (card) {
        var trigger = card.querySelector('.rs-faq-trigger');
        var body = card.querySelector('.rs-faq-body');

        if (trigger && body) {
            trigger.addEventListener('click', function () {
                var isOpen = card.classList.contains('is-active');

                // Close all other accordions for a crisp single-expansion feel
                faqCards.forEach(function (otherCard) {
                    if (otherCard !== card) {
                        otherCard.classList.remove('is-active');
                        var otherTrigger = otherCard.querySelector('.rs-faq-trigger');
                        var otherBody = otherCard.querySelector('.rs-faq-body');
                        if (otherTrigger) otherTrigger.setAttribute('aria-expanded', 'false');
                        if (otherBody) otherBody.style.maxHeight = null;
                    }
                });

                // Toggle current card
                if (isOpen) {
                    card.classList.remove('is-active');
                    trigger.setAttribute('aria-expanded', 'false');
                    body.style.maxHeight = null;
                } else {
                    card.classList.add('is-active');
                    trigger.setAttribute('aria-expanded', 'true');
                    body.style.maxHeight = body.scrollHeight + 40 + 'px';
                }
            });
        }
    });
});
</script>

<?php get_footer(); ?>
