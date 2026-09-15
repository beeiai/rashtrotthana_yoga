<?php
/** Template Name: About Us */
get_header();
?>

<style>
/* ============================================================
   About Us â€” Synced with Homepage Design System
   ============================================================ */

/* â”€â”€ BACKGROUND â€” matches homepage bg.jpg visibility â”€â”€ */
.rs-about-page {
    position: relative;
    isolation: isolate;
    /* overflow: hidden; */
    color: var(--color-text);
    background: 
        linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>") center top / cover fixed no-repeat !important;
    animation: rs-nature-drift 24s ease-in-out infinite alternate;
}
.rs-about-page::before,
.rs-about-page::after {
    position: absolute;
    z-index: -1;
    display: block;
    width: 24rem;
    height: 24rem;
    border-radius: 50%;
    content: "";
    filter: blur(10px);
    opacity: .80;
    pointer-events: none;
}
.rs-about-page::before {
    top: 0; left: 0;
    width: 100%; height: 100%;
    border-radius: 0;
    background:
        radial-gradient(circle at 8% 8%, rgba(249, 183, 42, .18), transparent 24rem),
        radial-gradient(circle at 92% 18%, rgba(243, 106, 33, .14), transparent 28rem);
    filter: none;
    opacity: 1;
}
.rs-about-page::after {
    top: 105rem; right: -15rem;
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
    .rs-about-page { animation: none; }
    .rs-about-page::after { animation: none; }
}


/* â”€â”€ SCROLL REVEAL â”€â”€ */
.rsa-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.2, 0.7, 0.2, 1) var(--reveal-delay, 0ms),
                transform 0.8s cubic-bezier(0.2, 0.7, 0.2, 1) var(--reveal-delay, 0ms);
}
.rsa-reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* â”€â”€ CURSOR GLOW â”€â”€ */
.rs-cursor-glow {
    position: fixed;
    z-index: 9999;
    top: -18px; left: -18px;
    width: 36px; height: 36px;
    border: 1px solid rgba(249, 183, 42, .66);
    border-radius: 50%;
    background: rgba(249, 183, 42, .1);
    box-shadow: 0 0 22px rgba(249, 183, 42, .42);
    pointer-events: none;
    mix-blend-mode: screen;
    transition: transform 80ms linear;
}

/* â”€â”€ TYPOGRAPHY â”€â”€ */
.rsa-eyebrow {
    font-size: 0.9rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--color-text-muted, #756a61);
    margin-bottom: 16px;
    display: inline-block;
    position: relative;
    border: none !important;
    padding: 0 !important;
    transition: color 220ms ease, transform 260ms cubic-bezier(.2,.8,.2,1);
}
.rsa-eyebrow:hover {
    color: var(--color-saffron, #f36a21);
    transform: translate3d(4px, -2px, 0);
}
.rsa-eyebrow-line::before {
    content: '';
    display: block;
    width: 32px;
    height: 3px;
    background: var(--color-saffron, #f36a21);
    margin-bottom: 12px;
    transform-origin: left center;
    transition: transform 300ms cubic-bezier(.2,.8,.2,1), box-shadow 300ms ease;
}
.rsa-eyebrow-line:hover::before {
    transform: scaleX(2);
    box-shadow: 0 0 14px rgba(243, 106, 33, .65);
}

.rsa-title {
    font-size: clamp(3.2rem, 6vw, 4.8rem);
    line-height: 1.15;
    color: #420e12;
    font-weight: 800;
    margin-bottom: 24px;
    letter-spacing: -0.02em;
    transition: color 220ms ease, transform 260ms cubic-bezier(.2,.8,.2,1), text-shadow 220ms ease;
}
.rsa-title:hover {
    color: #B31B1B;
    transform: translate3d(7px, -5px, 0) scale(1.025);
    text-shadow: 0 8px 18px rgba(179, 27, 27, .22), 0 0 14px rgba(243, 106, 33, .2);
}
.rsa-highlight {
    color: var(--color-saffron, #f36a21);
}
.rsa-text {
    font-size: 1.3rem;
    line-height: 1.8;
    color: #5a4840;
    text-transform: none !important;
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), color 220ms ease, text-shadow 220ms ease;
}
.rsa-text:hover {
    transform: translate3d(4px, -2px, 0);
    color: #550000;
    text-shadow: 0 4px 12px rgba(255, 255, 255, .9);
}

/* â”€â”€ LAYOUT â”€â”€ */
.rsa-section {
    padding: 100px 0;
    position: relative;
    z-index: 1;
}
.rsa-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: stretch;
}

/* â”€â”€ 1. HERO â”€â”€ */
.rsa-hero {
    position: relative;
    width: 100%;
    min-height: 650px;
    overflow: hidden;
    /* Hero image via CSS background â€” most reliable cross-browser approach */
    background-image:
        linear-gradient(90deg, #fffaf4 0%, rgba(255,250,244,.95) 26%, rgba(255,250,244,.55) 44%, rgba(255,250,244,0) 62%),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-v3.png' ); ?>");
    background-size: cover, cover;
    background-position: center, center;
    background-repeat: no-repeat, no-repeat;
}
/* Container flows full-width like homepage hero */
.rsa-hero > .rs-container {
    position: relative;
    z-index: 2;
    display: block;
    max-width: none;
    width: 100%;
    padding: 0;
}
.rsa-hero-content {
    position: relative;
    z-index: 2;
    width: min(100% - 160px, 1280px);
    max-width: 590px;
    margin: 0;
    padding: clamp(80px, 10vw, 110px) 0 clamp(90px, 10vw, 130px) clamp(48px, 8vw, 128px);
}

/* â”€â”€ 2. BACKGROUND SECTION â”€â”€ */
/* .rsa-bg-section {
    background: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(50px);
    border-top: 1px solid rgba(255, 255, 255, 0.4);
    border-bottom: 1px solid rgba(255, 255, 255, 0.4);
} */
.rsa-bg-grid { grid-template-columns: 45% 55%; }
.rsa-bg-content { display: flex; flex-direction: column; justify-content: center; }
.rsa-bg-content p { margin-bottom: 20px; }
.rsa-bg-motto { display: flex; align-items: flex-start; gap: 16px; margin-top: 32px; }
.rsa-bg-motto-icon { width: 28px; height: 28px; flex-shrink: 0; color: var(--color-saffron, #f36a21); }
.rsa-bg-motto-icon svg { width: 100%; height: 100%; }
.rsa-bg-motto-text { font-size: 1.05rem; font-weight: 600; line-height: 1.6; color: #420e12; }

/* Image cards with 3D tilt */
.rsa-tilt-card {
    border: 1px solid rgba(255, 255, 255, .72) !important;
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .8);
    backdrop-filter: blur(16px);
    --card-rotate-x: 0deg;
    --card-rotate-y: 0deg;
    transform: perspective(1100px) rotateX(var(--card-rotate-x)) rotateY(var(--card-rotate-y)) translateY(0px) scale(1);
    transform-style: preserve-3d;
    will-change: transform;
    transition: transform 220ms cubic-bezier(.2,.8,.2,1), box-shadow 220ms ease, border-color 220ms ease;
}
.rsa-tilt-card:hover {
    border-color: rgba(249, 183, 42, .68) !important;
    box-shadow: 0 34px 58px rgba(89, 37, 24, .2), 0 0 26px rgba(249, 183, 42, .18), inset 0 1px 0 #fff;
    transform: perspective(1100px) rotateX(var(--card-rotate-x)) rotateY(var(--card-rotate-y)) translateY(-8px) scale(1.025);
}
/* Shimmer line on top of tilt cards */
.rsa-tilt-card::after {
    position: absolute;
    top: 0; right: 1.2rem;
    width: 4rem; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(249, 183, 42, 1), transparent);
    box-shadow: 0 0 12px rgba(249, 183, 42, .8);
    content: "";
    pointer-events: none;
}

.rsa-bg-image {
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
}
.rsa-bg-image img {
    width: 100%; height: 100%; flex: 1; object-fit: cover;
    transition: transform 450ms cubic-bezier(.2,.8,.2,1), filter 450ms ease;
}
.rsa-bg-image:hover img {
    transform: scale(1.07) translateZ(12px);
    filter: saturate(1.14) contrast(1.05) brightness(1.04);
}

/* â”€â”€ 3. JOURNEY TIMELINE â”€â”€ */
.rsa-journey-section { text-align: center; padding-bottom: 100px; }
.rsa-journey-head { margin-bottom: 80px; }
.rsa-journey-head .rsa-title { margin-bottom: 0; }
.rsa-j-timeline-wrapper { position: relative; max-width: 1000px; margin: 0 auto; padding: 0 20px; }
.rsa-j-timeline-line {
    position: absolute; top: 35px; left: 10%; right: 10%;
    height: 1px; border-top: 2px dashed rgba(143, 23, 29, 0.2); z-index: 0;
}
.rsa-j-timeline { display: flex; justify-content: space-between; position: relative; z-index: 1; }
.rsa-j-point { width: 160px; text-align: center; display: flex; flex-direction: column; align-items: center; }
.rsa-j-icon {
    width: 70px; height: 70px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .85);
    border: 2px solid rgba(143, 23, 29, 0.15);
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04), inset 0 1px 0 rgba(255, 255, 255, .9);
    color: var(--color-maroon, #8f171d);
    backdrop-filter: blur(8px);
    --card-rotate-x: 0deg;
    --card-rotate-y: 0deg;
    transform: perspective(600px) rotateX(var(--card-rotate-x)) rotateY(var(--card-rotate-y)) translateY(0);
    transform-style: preserve-3d;
    will-change: transform;
    transition: transform 300ms cubic-bezier(.2,.8,.2,1), box-shadow 300ms ease, border-color 300ms ease;
    z-index: 2;
}
.rsa-j-point:hover .rsa-j-icon {
    border-color: var(--color-saffron, #f36a21);
    box-shadow: 0 18px 34px rgba(82, 38, 18, .14), 0 0 18px rgba(249, 183, 42, .22);
    transform: perspective(600px) rotateX(var(--card-rotate-x)) rotateY(var(--card-rotate-y)) translateY(-7px);
}
.rsa-j-icon svg { width: 24px; height: 24px; stroke-width: 1.5; }
.rsa-j-year {
    font-size: 1.2rem; font-weight: 800; color: #420e12; margin-bottom: 8px;
    transition: color 220ms ease, transform 260ms cubic-bezier(.2,.8,.2,1);
}
.rsa-j-point:hover .rsa-j-year {
    color: #B31B1B;
    transform: translateY(-3px);
}
.rsa-j-desc { font-size: 1rem; line-height: 1.6; color: #5a4840; padding: 0 10px; }

/* â”€â”€ 4. HISTORY SECTION â”€â”€ */
.rsa-history-section {
    background: rgba(255, 255, 255, 0.0); /* 70% transparent */
}
.rsa-h-grid { grid-template-columns: 45% 55%; align-items: center; }
.rsa-h-content { display: flex; flex-direction: column; justify-content: center; }
.rsa-h-list { position: relative; padding-left: 24px; margin-top: 30px; }
.rsa-h-list::before {
    content: ''; position: absolute; top: 8px; bottom: 0; left: 4px;
    width: 1px; background: rgba(143, 23, 29, 0.15);
}
.rsa-h-item {
    position: relative; margin-bottom: 28px;
    padding: 1.25rem 1.5rem; border-radius: 1.15rem;
    background: linear-gradient(145deg, rgba(255, 255, 255, .68), rgba(255, 248, 236, .42));
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .8);
    backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, .72);
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), box-shadow 260ms ease, border-color 260ms ease;
}
.rsa-h-item:hover {
    transform: translateY(-7px);
    border-color: rgba(243, 106, 33, .48);
    box-shadow: 0 22px 42px rgba(89, 37, 24, .14), inset 0 1px 0 rgba(255, 255, 255, .9);
}
.rsa-h-item:last-child { margin-bottom: 0; }
.rsa-h-item::before {
    content: ''; position: absolute; left: -24px; top: 6px;
    width: 9px; height: 9px; border-radius: 50%;
    background: var(--color-saffron, #f36a21);
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px rgba(143, 23, 29, 0.15);
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), box-shadow 260ms ease;
}
.rsa-h-item:hover::before {
    transform: scale(1.5);
    box-shadow: 0 0 10px rgba(243, 106, 33, .55);
}
.rsa-h-item h4 {
    font-size: 1.2rem; font-weight: 700; color: #420e12; margin: 0 0 6px 0;
    transition: color 220ms ease;
}
.rsa-h-item:hover h4 { color: #B31B1B; }
.rsa-h-item p { font-size: 1.05rem; line-height: 1.6; color: #5a4840; margin: 0; }

.rsa-h-images {
    width: 100%; border-radius: 20px; overflow: hidden;
    display: flex; flex-direction: column; aspect-ratio: 4 / 3; position: relative;
}
.rsa-h-images img {
    width: 100%; height: 100%; flex: 1; object-fit: cover;
    transition: transform 450ms cubic-bezier(.2,.8,.2,1), filter 450ms ease;
}
.rsa-h-images:hover img {
    transform: scale(1.07) translateZ(12px);
    filter: saturate(1.14) contrast(1.05) brightness(1.04);
}

/* â”€â”€ 5. FOUNDER SECTION â”€â”€ */
.rsa-founder-section { padding-bottom: 120px; }
.rsa-founder-grid { grid-template-columns: 35% 65%; gap: 60px; align-items: stretch; }
.rsa-founder-image {
    width: 100%; border-radius: 20px; overflow: hidden;
    display: flex; flex-direction: column; position: relative;
}
.rsa-founder-image img {
    width: 100%; height: 100%; flex: 1; object-fit: cover;
    transition: transform 450ms cubic-bezier(.2,.8,.2,1), filter 450ms ease;
}
.rsa-founder-image:hover img {
    transform: scale(1.07) translateZ(12px);
    filter: saturate(1.14) contrast(1.05) brightness(1.04);
}
.rsa-founder-content { display: flex; flex-direction: column; justify-content: center; }
.rsa-founder-content p { margin-bottom: 16px; }
.rsa-founder-quote {
    display: flex; gap: 16px; margin-top: 30px;
    padding: 24px 30px; border-radius: 1.15rem; position: relative;
    background: linear-gradient(145deg, rgba(255, 255, 255, .68), rgba(255, 248, 236, .42));
    box-shadow: 0 14px 34px rgba(89, 37, 24, .08), inset 0 1px 0 rgba(255, 255, 255, .8);
    backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, .72);
    transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
}
.rsa-founder-quote:hover {
    transform: translateY(-7px) !important;
    border-color: rgba(243, 106, 33, .48);
    box-shadow: 0 22px 42px rgba(89, 37, 24, .14), inset 0 1px 0 rgba(255, 255, 255, .9);
}
.rsa-quote-icon { font-size: 2.8rem; line-height: 1; color: var(--color-saffron, #f36a21); font-weight: 900; }
.rsa-quote-text { font-size: 1.15rem; font-style: italic; line-height: 1.7; color: #420e12; font-weight: 600; }
.rsa-quote-author { display: block; margin-top: 12px; font-size: 0.95rem; font-style: normal; color: var(--color-text-muted, #756a61); }

@keyframes rsa-button-pulse {
    0%   { box-shadow: 0 12px 26px rgba(179,27,27,.28), 0 0 12px rgba(179,27,27,.12); }
    100% { box-shadow: 0 18px 34px rgba(179,27,27,.42), 0 0 28px rgba(243,106,33,.3); }
}

/* â”€â”€ RESPONSIVE â”€â”€ */
@media (max-width: 1024px) {
    .rsa-grid-2, .rsa-bg-grid, .rsa-h-grid, .rsa-founder-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .rsa-hero-content { padding: 50px 0; }
    .rsa-j-timeline { flex-wrap: wrap; justify-content: center; gap: 40px; }
    .rsa-j-timeline-line { display: none; }
    .rsa-founder-grid { display: flex; flex-direction: column-reverse; }
    .rsa-founder-image { min-height: 400px; }
}
@media (pointer: coarse), (prefers-reduced-motion: reduce) {
    .rs-cursor-glow { display: none; }
    .rsa-tilt-card, .rsa-j-icon, .rsa-founder-quote {
        transform: none !important;
        transition: box-shadow 180ms ease, border-color 180ms ease;
    }
}
</style>

<main class="rs-homepage rs-about-page">


    <!-- ============================================================
         1. HERO SECTION
         ============================================================ -->
    <section class="rsa-hero rsa-animate">
        <div class="rs-container">
            <div class="rsa-hero-content">
                <h1 class="rsa-title">Rooted in Values.<br>Driven by <span class="rsa-highlight">Purpose.</span></h1>
                <p class="rsa-text">Our journey is a reflection of our commitment to holistic well-being and community transformation through Yoga.</p>
            </div>
        </div>
    </section>


    <!-- ============================================================
         2. BACKGROUND SECTION
         ============================================================ -->
    <section class="rsa-section rsa-bg-section rsa-animate">
        <div class="rs-container">
            <div class="rsa-grid-2 rsa-bg-grid">
                <div class="rsa-bg-content">
                    <span class="rsa-eyebrow rsa-eyebrow-line">Our Background</span>
                    <h2 class="rsa-title">Background</h2>
                    <p class="rsa-text">Rashtrotthana Yoga is a dedicated initiative of Rashtrotthana Parishat, committed to promoting physical, mental, and spiritual well-being through the timeless practice of Yoga.</p>
                    <p class="rsa-text">What began as a small effort to bring Yoga to the people has now grown into a vast movement touching thousands of lives every day across 23+ centers.</p>
                    <div class="rsa-bg-motto">
                        <div class="rsa-bg-motto-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div class="rsa-bg-motto-text">
                            Healthy Individuals. Strong Families.<br>
                            Empowered Communities. Sustainable Society.
                        </div>
                    </div>
                </div>
                <div class="rsa-bg-image rsa-tilt-card">
                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=1200&q=80" alt="Campus" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         3. JOURNEY TIMELINE
         ============================================================ -->
    <section class="rsa-section rsa-journey-section rsa-animate">
        <div class="rs-container">
            <div class="rsa-journey-head">
                <span class="rsa-eyebrow rsa-eyebrow-line" style="margin: 0 auto 16px auto; width: fit-content;">Our Journey So Far</span>
                <h2 class="rsa-title">A Journey of Impact and Growth</h2>
            </div>
            <div class="rsa-j-timeline-wrapper">
                <div class="rsa-j-timeline-line"></div>
                <div class="rsa-j-timeline">
                    <div class="rsa-j-point">
                        <div class="rsa-j-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                        <div class="rsa-j-year">Early 1990s</div>
                        <div class="rsa-j-desc">The vision took root with a small Yoga class in Jayanagar.</div>
                    </div>
                    <div class="rsa-j-point">
                        <div class="rsa-j-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
                        <div class="rsa-j-year">1995 &ndash; 2000</div>
                        <div class="rsa-j-desc">Yoga programs expanded to different parts of Bengaluru.</div>
                    </div>
                    <div class="rsa-j-point">
                        <div class="rsa-j-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4M9 7h6M9 11h6M9 15h6"/></svg></div>
                        <div class="rsa-j-year">2000 &ndash; 2010</div>
                        <div class="rsa-j-desc">Establishment of multiple centers and regular daily classes.</div>
                    </div>
                    <div class="rsa-j-point">
                        <div class="rsa-j-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg></div>
                        <div class="rsa-j-year">2010 &ndash; 2020</div>
                        <div class="rsa-j-desc">Reaching communities across Karnataka with 23+ centers.</div>
                    </div>
                    <div class="rsa-j-point">
                        <div class="rsa-j-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22C12 22 17 18 17 13C17 8 12 4 12 4C12 4 7 8 7 13C7 18 12 22 12 22Z"/><path d="M12 22C12 22 21 17 21 10C21 3 12 8 12 8"/><path d="M12 22C12 22 3 17 3 10C3 3 12 8 12 8"/></svg></div>
                        <div class="rsa-j-year">2020 &amp; Beyond</div>
                        <div class="rsa-j-desc">Continuing our mission with innovation, inclusion and impact.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         4. HISTORY SECTION
         ============================================================ -->
    <section class="rsa-section rsa-history-section rsa-animate">
        <div class="rs-container">
            <div class="rsa-grid-2 rsa-h-grid">
                <div class="rsa-h-content">
                    <span class="rsa-eyebrow rsa-eyebrow-line">Our History</span>
                    <h2 class="rsa-title">History</h2>
                    <div class="rsa-h-list">
                        <div class="rsa-h-item">
                            <h4>The Beginning</h4>
                            <p>Rashtrotthana Parishat envisioned a society rooted in health, culture, and values. Yoga was chosen as a path to achieve this vision.</p>
                        </div>
                        <div class="rsa-h-item">
                            <h4>Spreading the Light</h4>
                            <p>Yoga centers were established in neighborhoods, schools, and communities to make Yoga accessible to all.</p>
                        </div>
                        <div class="rsa-h-item">
                            <h4>Building a Movement</h4>
                            <p>Through dedicated teachers, volunteers, and well-structured programs, Yoga became a daily way of life for thousands.</p>
                        </div>
                        <div class="rsa-h-item">
                            <h4>Today</h4>
                            <p>With 23+ centers, diverse programs, and a growing family of practitioners, we continue to inspire and transform lives.</p>
                        </div>
                    </div>
                </div>
                <div class="rsa-h-images rsa-tilt-card">
                    <img src="https://images.unsplash.com/photo-1545389336-cf090694435e?auto=format&fit=crop&w=1200&q=80" alt="History Image" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         5. FOUNDER SECTION
         ============================================================ -->
    <section class="rsa-section rsa-founder-section rsa-animate">
        <div class="rs-container">
            <div class="rsa-grid-2 rsa-founder-grid">
                <div class="rsa-founder-image rsa-tilt-card">
                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=600&q=80" alt="Dr. D. Veerendra Heggade" loading="lazy">
                </div>
                <div class="rsa-founder-content">
                    <span class="rsa-eyebrow rsa-eyebrow-line">Founder History</span>
                    <h2 class="rsa-title">Our Founder</h2>
                    <p class="rsa-text"><strong>Dr. D. Veerendra Heggade</strong>, the visionary founder of Rashtrotthana Parishat, has been the guiding light behind the Yoga movement.</p>
                    <p class="rsa-text">His belief in the power of Yoga to transform individuals and communities has inspired the creation of a wide network of centers and programs.</p>
                    <p class="rsa-text">Under his leadership, Rashtrotthana Yoga continues to uplift lives and build a healthier, harmonious society.</p>
                    <div class="rsa-founder-quote rsa-tilt-card">
                        <div class="rsa-quote-icon">"</div>
                        <div>
                            <div class="rsa-quote-text">Yoga is not just an exercise; it is a way of life. It connects body, mind, and spirit to create a balanced, meaningful and joyful life.</div>
                            <span class="rsa-quote-author">&ndash; Dr. D. Veerendra Heggade</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var aboutPage = document.querySelector('.rs-about-page');

    /* â”€â”€ Scroll reveal â”€â”€ */
    if ('IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                obs.unobserve(entry.target);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px' });

        document.querySelectorAll('.rsa-animate').forEach(function (el, i) {
            el.classList.add('rsa-reveal');
            el.style.setProperty('--reveal-delay', (i * 70) + 'ms');
            revealObserver.observe(el);
        });
    } else {
        document.querySelectorAll('.rsa-animate').forEach(function (el) { el.style.opacity = '1'; });
    }

    if (!aboutPage || prefersReducedMotion) return;

    /* â”€â”€ Cursor glow â”€â”€ */
    if (window.matchMedia('(pointer: fine)').matches) {
        var cursorGlow = document.createElement('span');
        cursorGlow.className = 'rs-cursor-glow';
        cursorGlow.setAttribute('aria-hidden', 'true');
        document.body.appendChild(cursorGlow);

        window.addEventListener('pointermove', function (e) {
            cursorGlow.style.transform = 'translate3d(' + e.clientX + 'px, ' + e.clientY + 'px, 0)';
        }, { passive: true });

        /* â”€â”€ 3D tilt on cards & images â”€â”€ */
        var tiltCards = document.querySelectorAll('.rsa-tilt-card');
        Array.prototype.forEach.call(tiltCards, function (card) {
            card.addEventListener('pointermove', function (e) {
                var b = card.getBoundingClientRect();
                var rx = ((e.clientY - b.top) / b.height - 0.5) * -7;
                var ry = ((e.clientX - b.left) / b.width - 0.5) * 9;
                card.style.setProperty('--card-rotate-x', rx.toFixed(2) + 'deg');
                card.style.setProperty('--card-rotate-y', ry.toFixed(2) + 'deg');
            }, { passive: true });
            card.addEventListener('pointerleave', function () {
                card.style.setProperty('--card-rotate-x', '0deg');
                card.style.setProperty('--card-rotate-y', '0deg');
            });
        });

        /* â”€â”€ 3D tilt on journey icons â”€â”€ */
        var jPoints = document.querySelectorAll('.rsa-j-point');
        Array.prototype.forEach.call(jPoints, function (point) {
            var icon = point.querySelector('.rsa-j-icon');
            if (!icon) return;
            point.addEventListener('pointermove', function (e) {
                var b = icon.getBoundingClientRect();
                var rx = ((e.clientY - b.top) / b.height - 0.5) * -10;
                var ry = ((e.clientX - b.left) / b.width - 0.5) * 12;
                icon.style.setProperty('--card-rotate-x', rx.toFixed(2) + 'deg');
                icon.style.setProperty('--card-rotate-y', ry.toFixed(2) + 'deg');
            }, { passive: true });
            point.addEventListener('pointerleave', function () {
                icon.style.setProperty('--card-rotate-x', '0deg');
                icon.style.setProperty('--card-rotate-y', '0deg');
            });
        });
    }
});
</script>

<?php get_footer(); ?>

