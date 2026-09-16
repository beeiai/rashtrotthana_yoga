/**
 * homepage-effects.js  v2
 * Additive animations for the Rashtrotthana Yoga homepage.
 * Loads only on .rs-homepage. Never overwrites navigation.js logic.
 *
 * FIX: Scroll-reveal is now DISABLED for the horizontal-scroll carousels
 *      (.rs-activity-grid, .rs-event-grid, .rs-gallery-grid) so cards inside
 *      those containers are always visible regardless of scroll position.
 */
(function () {
  'use strict';

  /* Skip if page is not the homepage */
  if (!document.querySelector('.rs-homepage')) return;
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ─────────────────────────────────────────────────────────────
     1. CUSTOM CURSOR (fine pointer only)
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion && window.matchMedia('(pointer: fine)').matches) {
    var dot  = document.createElement('div');
    var ring = document.createElement('div');
    dot.className  = 'rse-cursor-dot';
    ring.className = 'rse-cursor-ring';
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

    var interactables = 'a, button, .rs-btn, .rs-activity-card, .rs-event-card, .rs-center-card, .rs-team-card, .rs-value-card, .rs-gallery-grid img, .rs-outline-link';
    document.querySelectorAll(interactables).forEach(function (el) {
      el.addEventListener('mouseenter', function () { dot.classList.add('is-hovering'); ring.classList.add('is-hovering'); });
      el.addEventListener('mouseleave', function () { dot.classList.remove('is-hovering'); ring.classList.remove('is-hovering'); });
    });
  }

  /* ─────────────────────────────────────────────────────────────
     2. SCROLL-REVEAL  (IntersectionObserver)
     NOTE: Cards inside horizontal-scroll containers are intentionally
     excluded — applying opacity:0 to them breaks the carousel since
     IntersectionObserver doesn't track position inside scroll containers.
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    var srObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('rs-sr-visible');
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

    var delays = [0, 80, 160, 240, 320];

    /* Value cards – staggered from left */
    document.querySelectorAll('.rs-value-card').forEach(function (el, i) {
      el.classList.add('rs-sr-left');
      el.style.setProperty('--sr-delay', delays[Math.min(i, 4)] + 'ms');
      srObserver.observe(el);
    });

    /* Center cards – staggered from right */
    document.querySelectorAll('.rs-center-card').forEach(function (el, i) {
      el.classList.add('rs-sr-right');
      el.style.setProperty('--sr-delay', delays[Math.min(i, 4)] + 'ms');
      srObserver.observe(el);
    });

    /* Team cards – staggered up */
    document.querySelectorAll('.rs-team-card').forEach(function (el, i) {
      el.classList.add('rs-sr');
      el.style.setProperty('--sr-delay', delays[Math.min(i, 4)] + 'ms');
      srObserver.observe(el);
    });

    /* Section headings */
    document.querySelectorAll('.rs-section-row, .rs-heading').forEach(function (el) {
      el.classList.add('rs-sr');
      srObserver.observe(el);
    });

    /* Stats section */
    document.querySelectorAll('.rs-stats').forEach(function (el) {
      el.classList.add('rs-sr');
      srObserver.observe(el);
    });

    /* ── CAROUSEL items: apply reveal only to the parent section wrapper,
       never to individual cards inside the scroll container. */
    var carouselGrids = document.querySelectorAll('.rs-activity-grid, .rs-event-grid, .rs-gallery-grid');
    carouselGrids.forEach(function (grid) {
      var section = grid.closest('.rs-content-section') || grid.closest('section');
      if (section && !section.classList.contains('rs-sr')) {
        section.classList.add('rs-sr');
        srObserver.observe(section);
      }
    });

  }

  /* ─────────────────────────────────────────────────────────────
     3. RIPPLE ON BUTTONS
  ───────────────────────────────────────────────────────────── */
  document.querySelectorAll('.rs-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      var rect   = btn.getBoundingClientRect();
      var size   = Math.max(rect.width, rect.height) * 1.6;
      var x      = e.clientX - rect.left - size / 2;
      var y      = e.clientY - rect.top  - size / 2;
      var ripple = document.createElement('span');
      ripple.className = 'rs-btn-ripple';
      ripple.style.cssText = 'width:' + size + 'px;height:' + size + 'px;left:' + x + 'px;top:' + y + 'px;';
      btn.appendChild(ripple);
      ripple.addEventListener('animationend', function () { ripple.remove(); });
    });
  });

  /* ─────────────────────────────────────────────────────────────
     4. SHIMMER on value cards
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    document.querySelectorAll('.rs-value-card').forEach(function (card) {
      card.style.position = 'relative';
      var shimmer = document.createElement('span');
      shimmer.className = 'rse-shimmer';
      shimmer.setAttribute('aria-hidden', 'true');
      shimmer.style.cssText = 'position:absolute;inset:0;pointer-events:none;z-index:5;background:linear-gradient(105deg,transparent 30%,rgba(255,255,255,.5) 50%,transparent 70%);transform:translateX(-120%);transition:transform 0ms;';
      card.appendChild(shimmer);
      card.addEventListener('mouseenter', function () {
        shimmer.style.transition = 'transform 550ms ease';
        shimmer.style.transform  = 'translateX(120%)';
      });
      card.addEventListener('mouseleave', function () {
        shimmer.style.transition = 'transform 0ms';
        shimmer.style.transform  = 'translateX(-120%)';
      });
    });

    /* Overlay for activity cards */
    document.querySelectorAll('.rs-activity-card').forEach(function (card) {
      if (getComputedStyle(card).position === 'static') card.style.position = 'relative';
      var overlay = document.createElement('span');
      overlay.className = 'rse-overlay';
      overlay.setAttribute('aria-hidden', 'true');
      card.appendChild(overlay);
    });
  }

  /* ─────────────────────────────────────────────────────────────
     5. HERO PARALLAX — image depth on mouse move
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    var hero   = document.querySelector('.rs-hero');
    var visual = document.querySelector('.rs-hero-visual');
    if (hero && visual) {
      hero.addEventListener('mousemove', function (e) {
        var rect = hero.getBoundingClientRect();
        var dx   = (e.clientX - rect.left - rect.width  / 2) / (rect.width  / 2);
        var dy   = (e.clientY - rect.top  - rect.height / 2) / (rect.height / 2);
        visual.style.transform = 'translate(' + (dx * 8) + 'px,' + (dy * 5) + 'px)';
      });
      hero.addEventListener('mouseleave', function () {
        visual.style.transition = 'transform 600ms ease';
        visual.style.transform  = '';
        setTimeout(function () { visual.style.transition = ''; }, 650);
      });
    }
  }

  /* ─────────────────────────────────────────────────────────────
     6. MAGNETIC PRIMARY BUTTON
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    document.querySelectorAll('.rs-btn-primary').forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var rect = btn.getBoundingClientRect();
        var dx   = e.clientX - rect.left - rect.width  / 2;
        var dy   = e.clientY - rect.top  - rect.height / 2;
        btn.style.transform = 'translate(' + dx * 0.22 + 'px,' + dy * 0.22 + 'px)';
      });
      btn.addEventListener('mouseleave', function () { btn.style.transform = ''; });
    });
  }

  /* ─────────────────────────────────────────────────────────────
     7. STAT COUNTER ANIMATION
  ───────────────────────────────────────────────────────────── */
  var statEls = document.querySelectorAll('.rs-stat-value[data-count]');
  if (statEls.length) {
    var statObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        obs.unobserve(entry.target);
        var el     = entry.target;
        var target = parseInt(el.dataset.count, 10);
        var suffix = el.dataset.suffix || '';
        var dur    = reducedMotion ? 0 : 1800;
        var start  = performance.now();
        (function step(now) {
          var p    = Math.min((now - start) / dur, 1);
          var ease = p === 1 ? 1 : 1 - Math.pow(2, -10 * p);
          el.textContent = Math.round(ease * target) + suffix;
          if (p < 1) requestAnimationFrame(step);
        })(performance.now());
      });
    }, { threshold: 0.3 });
    statEls.forEach(function (el) { statObserver.observe(el); });
  }

  /* ─────────────────────────────────────────────────────────────
     8. CARD TILT (3-D perspective on hover) – only for NON-carousel cards
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    /* Exclude cards inside horizontal-scroll containers */
    var allCards = Array.from(document.querySelectorAll('.rs-activity-card, .rs-event-card, .rs-center-card'));
    allCards.forEach(function (card) {
      /* Check if card is inside a scroll container */
      var parent = card.parentElement;
      var inScroll = parent && (
        parent.classList.contains('rs-activity-grid') ||
        parent.classList.contains('rs-event-grid')
      );
      /* Apply tilt only to cards NOT in scroll containers */
      if (!inScroll) {
        card.style.transition = 'transform 200ms ease, box-shadow 200ms ease, border-color 200ms ease';
        card.addEventListener('mousemove', function (e) {
          var rect = card.getBoundingClientRect();
          var xRel = (e.clientX - rect.left) / rect.width  - 0.5;
          var yRel = (e.clientY - rect.top ) / rect.height - 0.5;
          card.style.transform = 'perspective(700px) rotateY(' + xRel * 6 + 'deg) rotateX(' + -yRel * 4 + 'deg) translateY(-5px)';
        });
        card.addEventListener('mouseleave', function () { card.style.transform = ''; });
      }
    });
  }

  /* ─────────────────────────────────────────────────────────────
     9. NAVBAR SCROLL shadow
  ───────────────────────────────────────────────────────────── */
  var navbar = document.querySelector('.rs-navbar');
  if (navbar) {
    var wasScrolled = false;
    window.addEventListener('scroll', function () {
      var isScrolled = window.scrollY > 30;
      if (isScrolled !== wasScrolled) {
        wasScrolled = isScrolled;
        navbar.style.boxShadow   = isScrolled ? '0 8px 32px rgba(82,38,18,.12)' : '';
        navbar.style.borderColor = isScrolled ? 'rgba(143,23,29,.15)' : '';
      }
    }, { passive: true });
  }

  /* ─────────────────────────────────────────────────────────────
     10. HORIZONTAL CAROUSEL — drag-scroll & infinite loop feel
         The grids already scroll naturally; we add drag support
         and a subtle "nudge" entrance animation to each card.
  ───────────────────────────────────────────────────────────── */
  document.querySelectorAll('.rs-activity-grid, .rs-event-grid, .rs-gallery-grid').forEach(function (grid) {
    var isDown = false, startX = 0, scrollLeft = 0;

    grid.addEventListener('mousedown', function (e) {
      isDown = true;
      grid.classList.add('rse-dragging');
      startX     = e.pageX - grid.offsetLeft;
      scrollLeft = grid.scrollLeft;
    });
    grid.addEventListener('mouseleave', function () {
      isDown = false;
      grid.classList.remove('rse-dragging');
    });
    grid.addEventListener('mouseup', function () {
      isDown = false;
      grid.classList.remove('rse-dragging');
    });
    grid.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      e.preventDefault();
      var x    = e.pageX - grid.offsetLeft;
      var walk = (x - startX) * 1.4;
      grid.scrollLeft = scrollLeft - walk;
    });
  });

  /* ─────────────────────────────────────────────────────────────
     11. FLOATING PARTICLES on hero section
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    var heroEl = document.querySelector('.rs-hero');
    if (heroEl) {
      function spawnParticle() {
        var p = document.createElement('span');
        p.className = 'rse-hero-particle';
        var size = 4 + Math.random() * 8;
        var left = 10 + Math.random() * 45; /* left half only, over content */
        var dur  = 3 + Math.random() * 4;
        p.style.cssText = [
          'position:absolute',
          'pointer-events:none',
          'border-radius:50%',
          'z-index:2',
          'width:' + size + 'px',
          'height:' + size + 'px',
          'left:' + left + '%',
          'bottom:' + (8 + Math.random() * 20) + '%',
          'background:radial-gradient(circle,rgba(249,183,42,.85),rgba(243,106,33,.55))',
          'opacity:0',
          'animation:rse-ptcl ' + dur.toFixed(1) + 's ease-out forwards'
        ].join(';');
        heroEl.appendChild(p);
        setTimeout(function () { p.remove(); }, dur * 1000 + 200);
      }
      var ptclInterval = setInterval(spawnParticle, 900);
      /* Stop after 30s to save resources */
      setTimeout(function () { clearInterval(ptclInterval); }, 30000);
    }
  }

  /* ─────────────────────────────────────────────────────────────
     12. SECTION ENTRANCE – stagger children of value-grid on reveal
  ───────────────────────────────────────────────────────────── */
  if (!reducedMotion) {
    var valueGridObs = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        obs.unobserve(entry.target);
        /* Cards already have rs-sr-left; just make sure they all become visible */
      });
    }, { threshold: 0.05 });
    var vg = document.querySelector('.rs-value-grid');
    if (vg) valueGridObs.observe(vg);
  }

})();
