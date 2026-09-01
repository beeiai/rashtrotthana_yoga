document.addEventListener('DOMContentLoaded', function () {
  const button = document.querySelector('.rs-menu-toggle');
  const menu = document.querySelector('.rs-navigation');
  if (!button || !menu) return;
  button.addEventListener('click', function () {
    const isOpen = menu.classList.toggle('is-open');
    button.setAttribute('aria-expanded', String(isOpen));
  });
});
