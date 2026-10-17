<?php
/**
 * Template Name: About Us
 * Description: Redesigned About Us page matching Home, Activities, Centers, Events, and Gallery pages.
 *              Hero section removed and replaced with a clean header title block and stat pills.
 *              Includes modernized Background, Timeline, History, Founder, and Core Values sections.
 */

get_header();
?>

<style>
/* ============================================================
   Rashtrotthana About Us Page Design System
   Matches Home, Activities, Centers, Events & Gallery Pages
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
.rs-about-page {
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

.rs-about-page * {
    font-family: 'Poppins', sans-serif !important;
    box-sizing: border-box;
}

/* Ambient Floating Glow Orbs */
.rs-about-page::before,
.rs-about-page::after {
    content: "";
    position: absolute;
    pointer-events: none;
    z-index: 0;
    border-radius: 50%;
}

.rs-about-page::before {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 6% 15%, rgba(249, 183, 42, .18), transparent 28rem),
        radial-gradient(circle at 94% 22%, rgba(243, 106, 33, .14), transparent 32rem);
}

.rs-about-page::after {
    top: 65rem;
    right: -12rem;
    width: 36rem;
    height: 36rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .22), transparent 70%);
    animation: rsa-atmosphere-pulse 5s ease-in-out infinite alternate;
}

@keyframes rsa-atmosphere-pulse {
    0%   { opacity: .25; transform: scale(.95); }
    100% { opacity: .55; transform: scale(1.08); }
}

/* Side Margins: Matching Home, Centers, and Events pages exactly */
.rs-about-page .rs-container {
    width: 100% !important;
    max-width: none !important;
    padding-inline: clamp(20px, 4vw, 64px) !important;
    margin-inline: auto !important;
    box-sizing: border-box;
    position: relative;
    z-index: 2;
}

/* ============================================================
   Page Header Section (Hero Removed, Clean Title Block & Stats)
   ============================================================ */
.rs-about-header-section {
    padding: 3.5rem 0 2.25rem;
    text-align: center;
}

.rs-about-title-block {
    max-width: 820px;
    margin: 0 auto;
}

.rs-about-eyebrow {
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

.rs-about-eyebrow-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--color-saffron);
    box-shadow: 0 0 10px rgba(243, 106, 33, .8);
    animation: rsa-dot-blink 1.8s ease-in-out infinite;
}

@keyframes rsa-dot-blink {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.35); opacity: .6; }
}

.rs-about-page-title {
    margin: 0 0 1rem;
    color: #542019;
    font-size: clamp(2.3rem, 4vw, 3.4rem);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -.02em;
}

.rs-about-page-title em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-about-page-subtitle {
    margin: 0 auto 2.25rem;
    max-width: 680px;
    color: #67574c;
    font-size: clamp(1rem, 1.25vw, 1.12rem);
    line-height: 1.65;
}

/* Clean Number Cards / Stat Pills (Single Line on Desktop) */
.rs-about-stats-bar {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: clamp(.4rem, .75vw, .75rem);
    margin-bottom: 2.25rem;
    max-width: 1200px;
    margin-inline: auto;
}

@media (min-width: 900px) {
    .rs-about-stats-bar {
        flex-wrap: nowrap;
    }
}

.rs-about-stat-pill {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .42rem .85rem;
    border: 1px solid rgba(255, 255, 255, .85);
    border-radius: 999px;
    background: rgba(255, 255, 255, .78);
    box-shadow: 0 4px 16px rgba(89, 37, 24, .06);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    color: #542019;
    white-space: nowrap;
    flex-shrink: 0;
}

.rs-about-stat-pill strong {
    color: var(--color-maroon);
    font-size: 1.12rem;
    font-weight: 800;
    line-height: 1;
}

.rs-about-stat-pill span {
    color: #67574c;
    font-size: .8rem;
    font-weight: 600;
    white-space: nowrap;
}

/* ============================================================
   Section Headings (Unified Across Pages)
   ============================================================ */
.rs-about-section {
    padding: 2.75rem 0 3.25rem;
    position: relative;
}

.rs-about-section-header {
    margin-bottom: 2rem;
}

.rs-about-section-header.text-center {
    text-align: center;
}

.rs-about-section-header.text-center h2::after {
    margin: .65rem auto 0;
}

.rs-about-section-header h2 {
    position: relative;
    margin: 0;
    color: #542019;
    font-size: clamp(1.85rem, 3vw, 2.5rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -.015em;
}

.rs-about-section-header h2 em {
    font-style: normal;
    color: var(--color-maroon);
    background: linear-gradient(135deg, var(--color-maroon), var(--color-saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.rs-about-section-header h2::after {
    content: "";
    display: block;
    width: 48px;
    height: 4px;
    margin-top: .65rem;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--color-maroon), var(--color-saffron));
}

.rs-about-section-desc {
    max-width: 680px;
    margin: .5rem 0 0;
    color: #67574c;
    font-size: .95rem;
    line-height: 1.6;
}

.rs-about-section-desc.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

/* ============================================================
   2. OUR BACKGROUND SECTION
   ============================================================ */
.rs-background-grid {
    display: grid;
    grid-template-columns: 1.05fr 1fr;
    gap: 3rem;
    align-items: center;
}

.rs-background-content p {
    color: #67574c;
    font-size: 1.02rem;
    line-height: 1.75;
    margin: 0 0 1.25rem;
}

.rs-background-content p strong {
    color: #542019;
}

/* Motto Card */
.rs-motto-card {
    position: relative;
    margin-top: 2rem;
    padding: 1.45rem 1.65rem;
    border: 1px solid rgba(143, 23, 29, .15);
    border-radius: 1.2rem;
    background: rgba(255, 253, 249, .82);
    box-shadow: 0 12px 30px rgba(89, 37, 24, .07), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.rs-motto-card::after {
    position: absolute;
    top: 0;
    right: 1.5rem;
    width: 4rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
}

.rs-motto-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: rgba(243, 106, 33, .12);
    border: 1px solid rgba(243, 106, 33, .25);
    color: var(--color-saffron);
    flex-shrink: 0;
}

.rs-motto-icon svg {
    width: 26px;
    height: 26px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2.2;
}

.rs-motto-text {
    font-size: .98rem;
    font-weight: 700;
    line-height: 1.55;
    color: #542019;
}

/* Framed Visual Image */
.rs-framed-image {
    position: relative;
    border-radius: 1.35rem;
    overflow: hidden;
    border: 1px solid rgba(143, 23, 29, .14);
    box-shadow: 0 16px 38px rgba(89, 37, 24, .1), inset 0 1px 0 rgba(255, 255, 255, .9);
    background: var(--color-sand);
}

.rs-framed-image::after {
    position: absolute;
    top: 0;
    right: 1.5rem;
    width: 5rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 14px rgba(249, 183, 42, .85);
    content: "";
}

.rs-framed-image img {
    width: 100%;
    height: 100%;
    max-height: 440px;
    object-fit: cover;
    transition: transform 500ms cubic-bezier(.2,.8,.2,1), filter 500ms ease;
}

.rs-framed-image:hover img {
    transform: scale(1.06);
    filter: saturate(1.12);
}

/* ============================================================
   3. JOURNEY TIMELINE SECTION
   ============================================================ */
.rs-timeline-section {
    padding: 3.5rem 0;
}

.rs-timeline-wrapper {
    position: relative;
    max-width: 1100px;
    margin: 3rem auto 0;
    padding: 0 1rem;
}

/* Connector Track Line */
.rs-timeline-track-line {
    position: absolute;
    top: 40px;
    left: 8%;
    right: 8%;
    height: 3px;
    background: linear-gradient(90deg, 
        rgba(143, 23, 29, .2) 0%, 
        rgba(243, 106, 33, .5) 50%, 
        rgba(249, 183, 42, .6) 100%
    );
    z-index: 1;
    border-radius: 999px;
}

.rs-timeline-row {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
    gap: 1.25rem;
}

.rs-timeline-node {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    cursor: default;
    transition: transform 220ms ease;
}

.rs-timeline-node:hover {
    transform: translateY(-6px);
}

.rs-timeline-icon-wrap {
    width: 78px;
    height: 78px;
    border-radius: 50%;
    background: rgba(255, 253, 249, .95);
    border: 2px solid rgba(143, 23, 29, .22);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
    box-shadow: 0 8px 24px rgba(89, 37, 24, .1), inset 0 1px 0 #fff;
    color: var(--color-maroon);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    transition: all 220ms cubic-bezier(.2,.8,.2,1);
}

.rs-timeline-node:hover .rs-timeline-icon-wrap {
    background: var(--color-maroon);
    border-color: var(--color-gold);
    color: #fff;
    box-shadow: 0 12px 30px rgba(143, 23, 29, .35), 0 0 18px rgba(249, 183, 42, .3);
    transform: scale(1.12);
}

.rs-timeline-icon-wrap svg {
    width: 30px;
    height: 30px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}

.rs-timeline-year-pill {
    display: inline-block;
    padding: .35rem .95rem;
    border-radius: 999px;
    background: #fff0d8;
    color: #a34812;
    font-size: .86rem;
    font-weight: 800;
    margin-bottom: .65rem;
    border: 1px solid rgba(243, 106, 33, .2);
    transition: all 180ms ease;
}

.rs-timeline-node:hover .rs-timeline-year-pill {
    background: var(--color-maroon);
    color: #fff;
    border-color: var(--color-maroon);
}

.rs-timeline-card-desc {
    font-size: .88rem;
    line-height: 1.55;
    color: #67574c;
    max-width: 200px;
    margin: 0;
}

/* ============================================================
   4. OUR HISTORY SECTION (Chronological Evolution)
   ============================================================ */
.rs-history-grid {
    display: grid;
    grid-template-columns: 1.15fr 1fr;
    gap: 3rem;
    align-items: center;
}

.rs-history-timeline-list {
    position: relative;
    padding-left: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Vertical Spine Line */
.rs-history-timeline-list::before {
    content: "";
    position: absolute;
    top: 15px;
    bottom: 15px;
    left: 8px;
    width: 2px;
    background: linear-gradient(180deg, var(--color-maroon), var(--color-saffron));
    border-radius: 999px;
}

.rs-history-step-card {
    position: relative;
    padding: 1.35rem 1.6rem;
    border-radius: 1.15rem;
    background: rgba(255, 253, 249, .8);
    border: 1px solid rgba(143, 23, 29, .13);
    box-shadow: 0 10px 28px rgba(89, 37, 24, .06), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
}

.rs-history-step-card::after {
    position: absolute;
    top: 0;
    right: 1.2rem;
    width: 3.5rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 10px rgba(249, 183, 42, .8);
    content: "";
}

.rs-history-step-card:hover {
    transform: translateX(6px);
    border-color: rgba(243, 106, 33, .45);
    box-shadow: 0 16px 36px rgba(89, 37, 24, .12);
}

/* Step Node Dot */
.rs-history-step-card::before {
    content: "";
    position: absolute;
    left: -2rem;
    top: 1.5rem;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid var(--color-maroon);
    box-shadow: 0 0 0 3px rgba(143, 23, 29, .15);
    transition: all 200ms ease;
}

.rs-history-step-card:hover::before {
    background: var(--color-saffron);
    border-color: #fff;
    box-shadow: 0 0 0 4px rgba(243, 106, 33, .4);
    transform: scale(1.25);
}

.rs-history-step-card h4 {
    margin: 0 0 .4rem;
    font-size: 1.15rem;
    font-weight: 700;
    color: #542019;
    transition: color 180ms ease;
}

.rs-history-step-card:hover h4 {
    color: var(--color-maroon);
}

.rs-history-step-card p {
    margin: 0;
    font-size: .92rem;
    line-height: 1.6;
    color: #67574c;
}

/* ============================================================
   4. OUR MEMBERS SECTION
   ============================================================ */
.rs-team-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1.4rem;
}

.rs-team-card {
    position: relative;
    overflow: hidden;
    padding: .85rem .85rem 1.25rem;
    border: 1px solid rgba(143, 23, 29, .15) !important;
    border-radius: 1.15rem;
    background: linear-gradient(145deg, rgba(255, 255, 255, .9), rgba(255, 248, 236, .75));
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .9);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
    text-align: center;
}

.rs-team-card::after {
    position: absolute;
    top: 0;
    right: 1.2rem;
    width: 4rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-gold), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
}

.rs-team-card:hover {
    transform: translateY(-5px);
    border-color: rgba(243, 106, 33, .48) !important;
    box-shadow: 0 22px 42px rgba(89, 37, 24, .14), inset 0 1px 0 rgba(255, 255, 255, .9);
}

.rs-team-card img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    object-position: top center;
    border-radius: .75rem;
    background: #fdfaf5;
    transition: transform 400ms ease, filter 400ms ease;
}

.rs-team-card:hover img {
    transform: scale(1.04);
}

.rs-team-card h3 {
    margin: .95rem .35rem .25rem;
    color: #542019;
    font-size: 1.15rem;
    font-weight: 700;
    line-height: 1.25;
}

.rs-team-card .rs-team-role {
    margin: 0 .35rem 0;
    color: var(--color-saffron);
    font-size: .88rem;
    font-weight: 600;
    line-height: 1.35;
}

/* Overview Image Specific Styling for Circular Emblem */
.rs-overview-image {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rs-overview-image::after {
    display: none !important;
}

.rs-overview-image img {
    max-height: 420px;
    width: auto;
    max-width: 100%;
    object-fit: contain;
    filter: drop-shadow(0 16px 36px rgba(89, 37, 24, .16));
    border-radius: 50%;
}

/* ============================================================
   Responsive Layout Media Queries
   ============================================================ */
@media (max-width: 1024px) {
    .rs-background-grid,
    .rs-history-grid {
        grid-template-columns: 1fr;
        gap: 2.5rem;
    }
    .rs-team-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.5rem 1rem;
    }
}

@media (max-width: 768px) {
    .rs-about-header-section {
        padding: 2.25rem 0 1.25rem;
    }
    .rs-about-page-title {
        font-size: clamp(1.85rem, 6.8vw, 2.4rem);
    }
    .rs-about-stats-bar {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .rs-about-stat-pill {
        justify-content: center;
        border-radius: 12px;
        padding: 8px 10px;
    }
    .rs-team-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<main class="rs-about-page" id="main-content">

    <!-- ============================================================
         1. PAGE HEADER SECTION (Clean Title Block & Stats)
         ============================================================ -->
    <header class="rs-about-header-section">
        <div class="rs-container">
            <div class="rs-about-title-block">
                <h1 class="rs-about-page-title">Rooted in Values. Driven by <em>Purpose.</em></h1>
                <p class="rs-about-page-subtitle">
                    Discover the 50+ year journey of Rashtrotthana Yoga - an enduring commitment to holistic well-being, authentic Vedic discipline, and community transformation across Karnataka.
                </p>
            </div>

            <!-- Clean Stat Pills -->
            <div class="rs-about-stats-bar">
                <div class="rs-about-stat-pill">
                    <strong>25+</strong>
                    <span>Centers</span>
                </div>
                <div class="rs-about-stat-pill">
                    <strong>150+</strong>
                    <span>Daily Classes</span>
                </div>
                <div class="rs-about-stat-pill">
                    <strong>3000+</strong>
                    <span>Daily Practitioners</span>
                </div>
                <div class="rs-about-stat-pill">
                    <strong>1 Lakh+</strong>
                    <span>Yoga Trained</span>
                </div>
                <div class="rs-about-stat-pill">
                    <strong>250+</strong>
                    <span>Teachers</span>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================================================
         2. OVERVIEW SECTION
         ============================================================ -->
    <section class="rs-about-section" id="background-section">
        <div class="rs-container">
            <div class="rs-background-grid">
                <div class="rs-background-content">
                    <div class="rs-about-section-header">
                        <h2>Overview</h2>
                    </div>

                    <p>
                        Rashtrotthana currently runs Yoga centres in 24 locations in Bengaluru. Yoga is taught to interested people in over 180 groups every day. Yoga education is offered in three stages: introduction, practice, and advancement. More than 4,000 people are receiving Yoga therapy and training every day.
                    </p>
                    <p>
                        In addition to Yoga training, a monthly ideological lecture on national, cultural, and social issues is also organized.
                    </p>

                    <!-- Motto Card -->
                    <div class="rs-motto-card">
                        <div class="rs-motto-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="rs-motto-text">
                            Healthy Individuals. Strong Families.<br>
                            Empowered Communities. Sustainable Society.
                        </div>
                    </div>
                </div>

                <div class="rs-framed-image rs-overview-image">
                    <img src="<?php echo esc_url( content_url( '/uploads/2026/10/History.png' ) ); ?>" alt="Rashtrotthana Yoga History" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         3. OUR HISTORICAL EVOLUTION SECTION
         ============================================================ -->
    <section class="rs-about-section" id="history-section">
        <div class="rs-container">
            <div class="rs-history-grid">
                <div class="rs-history-content">
                    <div class="rs-about-section-header">
                        <h2>Our Historical <em>Evolution</em></h2>
                        <p class="rs-about-section-desc">
                            How a collective vision blossomed into a daily way of life for thousands of families.
                        </p>
                    </div>

                    <div class="rs-history-timeline-list">
                        <div class="rs-history-step-card">
                            <h4>Beginning of Yoga Initiative</h4>
                            <p>In 1972, the Rashtrotthana Physical Education Centre was started in Jayanagar, Bengaluru. The initiative was supported by Rashtrotthana Parishat, with contributions from several donors and Vishwa Hindu Parishat activists.</p>
                        </div>

                        <div class="rs-history-step-card">
                            <h4>Ajith Kumar’s Role</h4>
                            <p>Ajith Kumar, a Pracharak of the Rashtriya Swayamsevak Sangh, played a key role in promoting Yoga. He trained under renowned Yoga teachers Pattabhi Jois in Mysuru and later B.K.S. Iyengar.</p>
                        </div>

                        <div class="rs-history-step-card">
                            <h4>Yoga Training &amp; Expansion</h4>
                            <p>Under Ajith Kumar’s leadership, Rashtrotthana workers and Yoga enthusiasts began practicing Yoga. Regular Yoga classes were gradually introduced, and practitioners were trained to become Yoga instructors.</p>
                        </div>

                        <div class="rs-history-step-card">
                            <h4>Contribution to Yoga Education</h4>
                            <p>Many trained practitioners became dedicated Yoga teachers at the Rashtrotthana Physical Education Centre. The centre played an important role in spreading Yoga awareness and education across Karnataka and beyond.</p>
                        </div>
                    </div>
                </div>

                <div class="rs-framed-image">
                    <img src="<?php echo esc_url( content_url( '/uploads/2026/10/evolution.jpeg' ) ); ?>" alt="Rashtrotthana Yoga Evolution" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         4. OUR MEMBERS SECTION
         ============================================================ -->
    <section class="rs-about-section" id="members-section">
        <div class="rs-container">
            <div class="rs-about-section-header text-center">
                <h2>Our <em>Members</em></h2>
                <p class="rs-about-section-desc mx-auto">
                    Meet the leadership guiding our vision of health, culture, and service.
                </p>
            </div>

            <div class="rs-team-grid">
                <?php
                $rs_members = array(
                    array(
                        'name'  => 'Shri Ajith Kumar',
                        'role'  => 'Founder',
                        'image' => content_url( '/uploads/2026/10/Shri-Ajith-kumar-Founder.png' ),
                    ),
                    array(
                        'name'  => 'Shri M P Kumar',
                        'role'  => 'President',
                        'image' => content_url( '/uploads/2026/10/Sri-M-P-Kumar-President.png' ),
                    ),
                    array(
                        'name'  => 'Shri Dinesh Hegde',
                        'role'  => 'General Secretary',
                        'image' => content_url( '/uploads/2026/10/Sri-Dinesh-Hegde-General-Secretary.png' ),
                    ),
                    array(
                        'name'  => 'Shri K S Narayan',
                        'role'  => 'Treasurer',
                        'image' => content_url( '/uploads/2026/10/Sri-K-S-Narayan-Treasurer.jpg' ),
                    ),
                );

                foreach ( $rs_members as $member ) : ?>
                    <article class="rs-team-card">
                        <img src="<?php echo esc_url( $member['image'] ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>" loading="lazy">
                        <h3><?php echo esc_html( $member['name'] ); ?></h3>
                        <p class="rs-team-role"><?php echo esc_html( $member['role'] ); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
