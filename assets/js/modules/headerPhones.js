// Телефоны в шапке (modules/header-menu.php): клик по номеру раскрывает список номеров,
// клик вне списка и Esc — закрывают. Работает и в верхней строке, и в мобильном меню.
export default function headerPhones() {
  const groups = document.querySelectorAll('[data-header-phones]');

  if (!groups.length) {
    return;
  }

  const close = (group) => {
    const button = group.querySelector('.header__phone');
    const list = group.querySelector('.header__phones-list');
    if (!button || !list) return;
    button.setAttribute('aria-expanded', 'false');
    group.classList.remove('is-open');
    list.hidden = true;
  };

  groups.forEach((group) => {
    const button = group.querySelector('.header__phone');
    const list = group.querySelector('.header__phones-list');
    if (!button || !list) return;

    button.addEventListener('click', (event) => {
      event.preventDefault();
      const isOpen = button.getAttribute('aria-expanded') === 'true';
      groups.forEach(close);
      if (!isOpen) {
        button.setAttribute('aria-expanded', 'true');
        group.classList.add('is-open');
        list.hidden = false;
      }
    });
  });

  document.addEventListener('click', (event) => {
    groups.forEach((group) => {
      if (!group.contains(event.target)) close(group);
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') groups.forEach(close);
  });
}
