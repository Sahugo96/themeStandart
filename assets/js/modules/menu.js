const header = document.querySelector('.header');
const burger = document.querySelector('.header__burger');

if (header && burger) {
  const setOpen = (open) => {
    header.classList.toggle('active', open);
    document.querySelector('body').classList.toggle('lock', open);
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
  };

  burger.addEventListener('click', function (e) {
    e.preventDefault();
    setOpen(!header.classList.contains('active'));
  });

  // Закрываем по клику вне меню и по переходу по ссылке внутри него.
  document.addEventListener('click', function (e) {
    if (!header.classList.contains('active') || e.target.closest('.header__burger')) {
      return;
    }
    if (!e.target.closest('.header__mobile-inner') || e.target.closest('.header__mobile-inner a')) {
      setOpen(false);
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && header.classList.contains('active')) {
      setOpen(false);
    }
  });
}
