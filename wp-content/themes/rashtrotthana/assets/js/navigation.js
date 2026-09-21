document.addEventListener('DOMContentLoaded', function () {
  const button = document.querySelector('.rs-menu-toggle');
  const menu = document.querySelector('.rs-navigation');
  if (button && menu) {
    button.addEventListener('click', function () {
      const isOpen = menu.classList.toggle('is-open');
      button.setAttribute('aria-expanded', String(isOpen));
    });
  }

  const innerPage = document.querySelector('body:not(.home) main[class$="-page"]');
  if (innerPage && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const revealItems = innerPage.querySelectorAll('section, article, .rs-container > h1, .rs-container > h2');
    const revealObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.08 });
    revealItems.forEach(function (item, index) {
      item.classList.add('rs-page-reveal');
      item.style.setProperty('--reveal-delay', String(Math.min(index * 35, 280)) + 'ms');
      revealObserver.observe(item);
    });
  }

  const slideshow = document.querySelector('.rs-hero-slideshow');
  if (slideshow) {

  const slides = Array.from(slideshow.querySelectorAll('.rs-hero-slide'));
  const dots = Array.from(slideshow.querySelectorAll('.rs-hero-slide-dots button'));
  const interval = Number(slideshow.dataset.slideInterval) || 4000;
  let current = 0;
  let timer;

  function showSlide(index) {
    current = (index + slides.length) % slides.length;
    slides.forEach(function (slide, slideIndex) {
      slide.classList.toggle('is-active', slideIndex === current);
    });
    dots.forEach(function (dot, dotIndex) {
      const active = dotIndex === current;
      dot.classList.toggle('is-active', active);
      dot.setAttribute('aria-current', active ? 'true' : 'false');
    });
  }

  function startSlideshow() {
    window.clearInterval(timer);
    timer = window.setInterval(function () {
      showSlide(current + 1);
    }, interval);
  }

  dots.forEach(function (dot, dotIndex) {
    dot.addEventListener('click', function () {
      showSlide(dotIndex);
      startSlideshow();
    });
  });

  slideshow.addEventListener('mouseenter', function () {
    window.clearInterval(timer);
  });
  slideshow.addEventListener('mouseleave', startSlideshow);
  showSlide(0);
  startSlideshow();
  }

  const eventPage = document.querySelector('.rs-events-page');
  if (eventPage) {
    const eventSearch = eventPage.querySelector('.rs-event-search input');
    const eventSearchButton = eventPage.querySelector('.rs-event-search button');
    const eventCategory = eventPage.querySelector('.rs-events-filter select');
    const eventCards = Array.from(eventPage.querySelectorAll('.rs-event-list-card'));
    const filterEvents = function () {
      const query = eventSearch ? eventSearch.value.toLowerCase().trim() : '';
      const category = eventCategory ? eventCategory.value.toLowerCase() : 'all categories';
      eventCards.forEach(function (card) {
        const matchesQuery = !query || card.textContent.toLowerCase().includes(query);
        const matchesCategory = category === 'all categories' || card.textContent.toLowerCase().includes(category);
        card.hidden = !(matchesQuery && matchesCategory);
      });
    };
    if (eventSearch) eventSearch.addEventListener('input', filterEvents);
    if (eventCategory) eventCategory.addEventListener('change', filterEvents);
    if (eventSearchButton) eventSearchButton.addEventListener('click', filterEvents);
  }



  const galleryPage = document.querySelector('.rs-gallery-page');
  if (galleryPage) {
    const photoItems = Array.from(galleryPage.querySelectorAll('.rs-photo-grid .rs-media-item'));
    const loadPhotos = galleryPage.querySelector('.rs-load-photos');
    if (loadPhotos) {
      photoItems.slice(6).forEach(function (item) { item.hidden = true; });
      loadPhotos.hidden = photoItems.length <= 6;
      loadPhotos.addEventListener('click', function () {
        photoItems.forEach(function (item) { item.hidden = false; });
        loadPhotos.hidden = true;
      });
    }
  }
});
