document.addEventListener('DOMContentLoaded', function () {
  const button = document.querySelector('.rs-menu-toggle');
  const menu = document.querySelector('.rs-navigation');
  if (!button || !menu) return;
  button.addEventListener('click', function () {
    const isOpen = menu.classList.toggle('is-open');
    button.setAttribute('aria-expanded', String(isOpen));
  });

  const slideshow = document.querySelector('.rs-hero-slideshow');
  if (!slideshow) return;

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
});
