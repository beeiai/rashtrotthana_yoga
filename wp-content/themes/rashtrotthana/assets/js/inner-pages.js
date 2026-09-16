/**
 * inner-pages.js
 * Additive interaction layer for all non-homepage inner pages.
 * Mirrors the homepage-effects.js feature set on inner pages.
 */
(function () {
  'use strict';

  /* Only run on inner pages (not homepage) */
  if (document.body.classList.contains('home')) return;

  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ─────────────────────────────────────────────────────────────
     1. CUSTOM CURSOR — saffron dot + lagging ring
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion && window.matchMedia('(pointer: fine)').matches) {
    var dot  = document.createElement('div');
    var ring = document.createElement('div');
    dot.className  = 'rsi-cursor-dot';
    ring.className = 'rsi-cursor-ring';
    document.body.appendChild(dot);
    document.body.appendChild(ring);

    var mx = 0, my = 0, rx = 0, ry = 0;

    document.addEventListener('mousemove', function (e) {
      mx = e.clientX; my = e.clientY;
      dot.style.transform = 'translate(' + mx + 'px,' + my + 'px) translate(-50%,-50%)';
    });

    (function animRing() {
      rx += (mx - rx) * 0.14;
      ry += (my - ry) * 0.14;
      ring.style.transform = 'translate(' + rx + 'px,' + ry + 'px) translate(-50%,-50%)';
      requestAnimationFrame(animRing);
    })();

    /* Hover state on interactive elements */
    var interactables = 'a, button, input, select, textarea, article[class*="card"], article[class*="category"], .rs-activity-category, .rs-directory-card, .rs-media-item';
    document.querySelectorAll(interactables).forEach(function (el) {
      el.addEventListener('mouseenter', function () {
        dot.classList.add('is-hovering');
        ring.classList.add('is-hovering');
      });
      el.addEventListener('mouseleave', function () {
        dot.classList.remove('is-hovering');
        ring.classList.remove('is-hovering');
      });
    });
  }

  /* ─────────────────────────────────────────────────────────────
     2. NAVBAR SCROLL SHADOW
  ───────────────────────────────────────────────────────────── */
  var navbar = document.querySelector('.rs-navbar');
  if (navbar) {
    var wasScrolled = false;
    window.addEventListener('scroll', function () {
      var isScrolled = window.scrollY > 30;
      if (isScrolled !== wasScrolled) {
        wasScrolled = isScrolled;
        navbar.classList.toggle('is-scrolled', isScrolled);
      }
    }, { passive: true });
  }

  /* ─────────────────────────────────────────────────────────────
     3. RIPPLE ON BUTTONS AND LINKS
  ───────────────────────────────────────────────────────────── */
  function addRipple(el) {
    el.style.position = 'relative';
    el.style.overflow = 'hidden';
    el.addEventListener('click', function (e) {
      var rect   = el.getBoundingClientRect();
      var size   = Math.max(rect.width, rect.height) * 1.8;
      var x      = e.clientX - rect.left - size / 2;
      var y      = e.clientY - rect.top  - size / 2;
      var r      = document.createElement('span');
      r.className = 'rsi-ripple';
      r.style.cssText = 'width:' + size + 'px;height:' + size + 'px;left:' + x + 'px;top:' + y + 'px;';
      el.appendChild(r);
      r.addEventListener('animationend', function () { r.remove(); });
    });
  }

  document.querySelectorAll(
    '.rs-btn, a[class*="primary"], a[class*="secondary"], button[class*="primary"], .rs-event-register, .rs-register-button, .rs-center-button, [class*="-hero"] a'
  ).forEach(addRipple);

  /* ─────────────────────────────────────────────────────────────
     4. SCROLL-REVEAL — enhanced stagger for inner page sections
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    /* Section headings — trigger accent-bar animation */
    var headingObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('rsi-visible');
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

    document.querySelectorAll(
      '[class*="-section"] h2, [class*="-directory"] h2, [class*="-categories"] h2, [class*="-heading"] h2, [class*="-section-heading"] h2'
    ).forEach(function (el) { headingObserver.observe(el); });

    /* Stagger sibling cards */
    var cardObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        /* Stagger siblings inside same parent */
        var siblings = Array.from(entry.target.parentElement.children);
        var idx = siblings.indexOf(entry.target);
        entry.target.style.setProperty('--reveal-delay', (Math.min(idx, 4) * 80) + 'ms');
        entry.target.classList.add('rs-page-reveal', 'is-visible');
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.07, rootMargin: '0px 0px -20px 0px' });

    /* Cards in grids */
    document.querySelectorAll(
      'article[class*="card"], article[class*="category"], .rs-activity-category, .rs-directory-card, .rs-media-item, .rs-news-grid article'
    ).forEach(function (el) {
      /* Don't double-add if already handled by navigation.js */
      if (!el.classList.contains('rs-page-reveal')) {
        cardObserver.observe(el);
      }
    });
  }

  /* ─────────────────────────────────────────────────────────────
     5. STAT COUNTER ANIMATION
  ───────────────────────────────────────────────────────────── */
  /* Inner pages have stats as plain text like "23+" — we parse and animate */
  var statStrong = document.querySelectorAll(
    '[class*="-numbers"] strong, [class*="-stats"] strong, .rs-activities-stats strong'
  );

  if (statStrong.length) {
    var statObs = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        obs.unobserve(entry.target);
        var el   = entry.target;
        var raw  = el.textContent.trim();         /* e.g. "23+" or "1.5+ Lakh" */
        var num  = parseFloat(raw);
        if (isNaN(num) || reducedMotion) return;  /* skip if not a number */
        var suffix = raw.replace(/^[\d.]+/, '');   /* everything after the number */
        var dur    = 1600;
        var start  = performance.now();
        (function step(now) {
          var p    = Math.min((now - start) / dur, 1);
          var ease = p === 1 ? 1 : 1 - Math.pow(2, -10 * p);
          var val  = ease * num;
          /* Preserve decimal if original had it */
          el.textContent = (Number.isInteger(num) ? Math.round(val) : val.toFixed(1)) + suffix;
          if (p < 1) requestAnimationFrame(step);
        })(performance.now());
      });
    }, { threshold: 0.4 });

    statStrong.forEach(function (el) { statObs.observe(el); });
  }

  /* ─────────────────────────────────────────────────────────────
     6. 3-D CARD TILT on hover
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    var tiltTargets = document.querySelectorAll(
      'article[class*="card"], article[class*="category"], .rs-activity-category'
    );
    tiltTargets.forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var rect = card.getBoundingClientRect();
        var xRel = (e.clientX - rect.left) / rect.width  - 0.5;
        var yRel = (e.clientY - rect.top ) / rect.height - 0.5;
        card.style.transform = 'perspective(800px) rotateY(' + xRel * 5 + 'deg) rotateX(' + -yRel * 4 + 'deg) translateY(-7px)';
        card.style.willChange = 'transform';
      });
      card.addEventListener('mouseleave', function () {
        card.style.transform = '';
        card.style.willChange = '';
      });
    });
  }

  /* ─────────────────────────────────────────────────────────────
     7. MAGNETIC EFFECT on primary CTA buttons
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    document.querySelectorAll(
      'a[class*="primary"], button[class*="primary"], .rs-event-hero-primary, .rs-event-hero-secondary'
    ).forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var rect = btn.getBoundingClientRect();
        var dx   = e.clientX - rect.left - rect.width  / 2;
        var dy   = e.clientY - rect.top  - rect.height / 2;
        btn.style.transform = 'translate(' + dx * 0.18 + 'px,' + dy * 0.18 + 'px)';
      });
      btn.addEventListener('mouseleave', function () {
        btn.style.transform = '';
      });
    });
  }

  /* ─────────────────────────────────────────────────────────────
     8. GALLERY LIGHTBOX keyboard/mouse nav (enhancement — already in page-gallery.php)
        This block safely does nothing if the lightbox isn't on the page.
  ───────────────────────────────────────────────────────────── */
  /* (lightbox JS already inline in page-gallery.php — no duplication needed) */

  /* ─────────────────────────────────────────────────────────────
     9. HERO PARALLAX — subtle image depth on mouse move
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    var heroImage = document.querySelector('[class*="-hero-image"]');
    var heroEl    = document.querySelector('[class*="-hero"]');
    if (heroImage && heroEl) {
      heroEl.addEventListener('mousemove', function (e) {
        var rect = heroEl.getBoundingClientRect();
        var dx   = (e.clientX - rect.left - rect.width  / 2) / (rect.width  / 2);
        var dy   = (e.clientY - rect.top  - rect.height / 2) / (rect.height / 2);
        heroImage.style.backgroundPositionX = (65 + dx * 3) + '%';
        heroImage.style.backgroundPositionY = (50 + dy * 2) + '%';
      });
      heroEl.addEventListener('mouseleave', function () {
        heroImage.style.backgroundPositionX = '';
        heroImage.style.backgroundPositionY = '';
      });
    }
  }

  /* ─────────────────────────────────────────────────────────────
     10. CENTER SEARCH — live filter (Centers page)
  ───────────────────────────────────────────────────────────── */
  var centerSearch = document.querySelector('.rs-centers-page .rs-center-search input');
  if (centerSearch) {
    var dirCards = document.querySelectorAll('.rs-directory-card');
    centerSearch.addEventListener('input', function () {
      var q = this.value.toLowerCase().trim();
      dirCards.forEach(function (c) {
        var match = !q || (c.dataset.center || c.textContent).toLowerCase().includes(q);
        c.style.display = match ? '' : 'none';
      });
    });
  }

})();
