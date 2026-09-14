<?php
/** Template Name: About Us */
get_header();
?>

<style>
/* ============================================================
   About Us — Fully Independent & Reliable Layout
   ============================================================ */

/* ── EXACT MATCH OF HOMEPAGE BACKGROUND LOGIC ── */
.rs-about-page {
    position: relative;
    isolation: isolate;
    overflow: hidden;
    color: var(--color-text);
    background:
        linear-gradient(90deg, rgba(255, 248, 236, 0.25), rgba(255, 248, 236, 0.15)),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>") center top / cover fixed no-repeat;
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
    opacity: .46;
    pointer-events: none;
}
.rs-about-page::before {
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
.rs-about-page::after {
    top: 105rem;
    right: -15rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .24), transparent 68%);
}
@keyframes rs-nature-drift {
    0% { background-position: center top, 48% top; }
    100% { background-position: center top, 52% top; }
}
@media (prefers-reduced-motion: reduce) {
    .rs-about-page { animation: none; }
}

.rs-about-page *:not(svg):not(path) {
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif !important;
}

/* ── INDEPENDENT ANIMATION SYSTEM ── */
.rsa-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.2, 0.7, 0.2, 1), transform 0.8s cubic-bezier(0.2, 0.7, 0.2, 1);
}
.rsa-reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ── TYPOGRAPHY ── */
.rsa-eyebrow {
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.9rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase !important;
    color: var(--color-text-muted, #756a61);
    margin-bottom: 16px;
    display: inline-block;
    position: relative;
    border: none !important; 
    padding: 0 !important;
}
.rsa-eyebrow-line::before {
    content: '';
    display: block;
    width: 32px;
    height: 3px;
    background: var(--color-saffron, #f36a21);
    margin-bottom: 12px;
}
.rsa-title {
    font-family: 'Poppins', sans-serif !important;
    font-size: clamp(3.2rem, 6vw, 4.8rem); /* Increased heading size */
    line-height: 1.15;
    color: #420e12;
    font-weight: 800; /* Bolder sans-serif headings look better */
    margin-bottom: 24px;
    letter-spacing: -0.02em;
}
.rsa-highlight {
    color: var(--color-saffron, #f36a21); 
}
.rsa-text {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.3rem; /* Increased body text size */
    line-height: 1.8;
    color: #5a4840;
    text-transform: none !important;
}

/* ── LAYOUT UTILS ── */
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

/* ── 1. INDEPENDENT HERO SECTION ── */
.rsa-hero {
    position: relative;
    width: 100%;
    min-height: 700px;
    display: flex;
    align-items: center;
    background: url("https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=1800&q=80") center/cover no-repeat;
    overflow: hidden;
    padding-top: 60px;
}
.rsa-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255, 250, 244, 0.65); /* Overlay to ensure dark text remains highly readable over the full image */
    z-index: 0;
}
.rsa-hero .rs-container {
    position: relative;
    z-index: 2;
}
.rsa-hero-content {
    max-width: 650px;
}

/* ── 2. BACKGROUND SECTION ── */
.rsa-bg-section {
    background: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.4);
    border-bottom: 1px solid rgba(255,255,255,0.4);
}
.rsa-bg-grid {
    grid-template-columns: 45% 55%;
}
.rsa-bg-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.rsa-bg-content p {
    margin-bottom: 20px;
}
.rsa-bg-motto {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-top: 32px;
}
.rsa-bg-motto-icon {
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    color: var(--color-saffron, #f36a21);
}
.rsa-bg-motto-icon svg { width: 100%; height: 100%; }
.rsa-bg-motto-text {
    font-size: 1.05rem; /* Increased */
    font-weight: 600;
    line-height: 1.6;
    color: #420e12;
}
.rsa-bg-image {
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.06);
    /* Flex allows image to stretch to full height of parent grid cell */
    display: flex;
    flex-direction: column;
}
.rsa-bg-image img {
    width: 100%;
    height: 100%; /* Stretches to fill flex container */
    flex: 1;
    object-fit: cover;
}

/* ── 3. JOURNEY TIMELINE SECTION ── */
.rsa-journey-section {
    text-align: center;
    padding-bottom: 100px;
}
.rsa-journey-head {
    margin-bottom: 80px;
}
.rsa-journey-head .rsa-title { margin-bottom: 0; }
.rsa-j-timeline-wrapper {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}
.rsa-j-timeline-line {
    position: absolute;
    top: 35px;
    left: 10%;
    right: 10%;
    height: 1px;
    border-top: 2px dashed rgba(143, 23, 29, 0.2);
    z-index: 0;
}
.rsa-j-timeline {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}
.rsa-j-point {
    width: 160px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.rsa-j-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid rgba(143,23,29,0.15);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    color: var(--color-maroon, #8f171d);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    z-index: 2;
}
.rsa-j-point:hover .rsa-j-icon {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    border-color: var(--color-saffron, #f36a21);
}
.rsa-j-icon svg { width: 24px; height: 24px; stroke-width: 1.5; }
.rsa-j-year {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.2rem; /* Increased */
    font-weight: 800;
    color: #420e12;
    margin-bottom: 8px;
}
.rsa-j-desc {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1rem; /* Increased */
    line-height: 1.6;
    color: #5a4840;
    padding: 0 10px;
}

/* ── 4. HISTORY SECTION ── */
.rsa-history-section {
    background: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.4);
}
.rsa-h-grid {
    grid-template-columns: 45% 55%; /* Match Background Section Grid */
    align-items: center; /* Center the image instead of stretching it */
}
.rsa-h-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.rsa-h-list {
    position: relative;
    padding-left: 24px;
    margin-top: 30px;
}
.rsa-h-list::before {
    content: '';
    position: absolute;
    top: 8px;
    bottom: 0;
    left: 4px;
    width: 1px;
    background: rgba(143,23,29,0.15);
}
.rsa-h-item {
    position: relative;
    margin-bottom: 28px;
}
.rsa-h-item:last-child {
    margin-bottom: 0;
}
.rsa-h-item::before {
    content: '';
    position: absolute;
    left: -24px;
    top: 6px;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: var(--color-saffron, #f36a21);
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px rgba(143,23,29,0.15);
}
.rsa-h-item h4 {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.2rem; /* Increased */
    font-weight: 700;
    color: #420e12;
    margin: 0 0 6px 0;
}
.rsa-h-item p {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.05rem; /* Increased */
    line-height: 1.6;
    color: #5a4840;
    margin: 0;
}
.rsa-h-images {
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    aspect-ratio: 4 / 3; /* Ensure it has a fixed, pleasant proportion similar to the background card */
}
.rsa-h-images img {
    width: 100%;
    height: 100%;
    flex: 1;
    object-fit: cover;
}

/* ── 5. FOUNDER SECTION ── */
.rsa-founder-section {
    padding-bottom: 120px;
}
.rsa-founder-grid {
    grid-template-columns: 35% 65%;
    gap: 60px;
    align-items: stretch; /* Enforces equal heights */
}
.rsa-founder-image {
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
}
.rsa-founder-image img {
    width: 100%;
    height: 100%;
    flex: 1; /* Stretches to fill */
    object-fit: cover;
}
.rsa-founder-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.rsa-founder-content p {
    margin-bottom: 16px;
}
.rsa-founder-quote {
    display: flex;
    gap: 16px;
    margin-top: 30px;
    padding: 24px 30px;
    background: rgba(255,255,255,0.8);
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,0.05);
}
.rsa-quote-icon {
    font-size: 2.8rem;
    line-height: 1;
    color: var(--color-saffron, #f36a21);
    font-family: 'Poppins', sans-serif !important;
    font-weight: 900;
}
.rsa-quote-text {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.15rem; /* Increased */
    font-style: italic;
    line-height: 1.7;
    color: #420e12;
    font-weight: 600;
}
.rsa-quote-author {
    font-family: 'Poppins', sans-serif !important;
    display: block;
    margin-top: 12px;
    font-size: 0.95rem; /* Increased */
    font-style: normal;
    color: var(--color-text-muted, #756a61);
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .rsa-grid-2, .rsa-bg-grid, .rsa-h-grid, .rsa-founder-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .rsa-hero-content {
        padding: 50px 0;
    }
    .rsa-hero-visual::after {
        background: linear-gradient(90deg, #fffaf4 0%, rgba(255,250,244,.9) 53%, rgba(255,250,244,.12) 100%);
    }
    .rsa-j-timeline {
        flex-wrap: wrap;
        justify-content: center;
        gap: 40px;
    }
    .rsa-j-timeline-line { display: none; }
    .rsa-founder-grid {
        display: flex;
        flex-direction: column-reverse;
    }
    .rsa-founder-image {
        min-height: 400px;
    }
}
@media (max-width: 600px) {
    .rsa-h-images {
        grid-template-columns: 1fr;
    }
}
</style>

<main class="rs-homepage rs-about-page">

    <!-- ============================================================
         1. HERO SECTION (Full Width Background Image)
         ============================================================ -->
    <section class="rsa-hero rsa-animate">
        <div class="rs-container">
            <div class="rsa-hero-content">
                <span class="rsa-eyebrow rsa-eyebrow-line">About Us</span>
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
                <div class="rsa-bg-image">
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
                
                <div class="rsa-h-images">
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
                <div class="rsa-founder-image">
                    <!-- Placeholder for founder -->
                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=600&q=80" alt="Dr. D. Veerendra Heggade" loading="lazy">
                </div>
                <div class="rsa-founder-content">
                    <span class="rsa-eyebrow rsa-eyebrow-line">Founder History</span>
                    <h2 class="rsa-title">Our Founder</h2>
                    
                    <p class="rsa-text"><strong>Dr. D. Veerendra Heggade</strong>, the visionary founder of Rashtrotthana Parishat, has been the guiding light behind the Yoga movement.</p>
                    <p class="rsa-text">His belief in the power of Yoga to transform individuals and communities has inspired the creation of a wide network of centers and programs.</p>
                    <p class="rsa-text">Under his leadership, Rashtrotthana Yoga continues to uplift lives and build a healthier, harmonious society.</p>
                    
                    <div class="rsa-founder-quote">
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
/* Simple, conflict-free reveal animation */
document.addEventListener('DOMContentLoaded', function() {
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        
        document.querySelectorAll('.rsa-animate').forEach(el => {
            el.classList.add('rsa-reveal');
            observer.observe(el);
        });
    } else {
        document.querySelectorAll('.rsa-animate').forEach(el => el.style.opacity = '1');
    }
});
</script>

<?php get_footer(); ?>
