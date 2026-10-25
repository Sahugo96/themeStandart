// Слайдер «Услуги» (services--slider): инициализируем каждую секцию на странице.
// Экземпляр сохраняем в элементе — фильтр (servicesSliderFilter.js) удаляет его
// перед заменой карточек и создаёт заново.
window.themeServicesSliderOptions = {
  perPage: 3,
  perMove: 1,
  gap: "20px",
  pagination: true,
  arrows: false,
  updateOnMove: true,
  breakpoints: {
    991.9: {
      perPage: 1,
      perMove: 1,
      gap: "16px",
    },
  },
};

document.querySelectorAll(".services--slider .services__slider").forEach((el) => {
  if (el.splide) {
    return;
  }

  el.splide = new Splide(el, window.themeServicesSliderOptions).mount();
});
