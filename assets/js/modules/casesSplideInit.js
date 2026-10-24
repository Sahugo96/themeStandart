// Слайдер «Кейсы»: инициализируем каждую секцию на странице.
// Экземпляр сохраняем в элементе — фильтр (caseSectionFilter.js) удаляет его
// перед заменой карточек и создаёт заново.
document.querySelectorAll(".cases__splide").forEach((el) => {
  if (el.splide) {
    return;
  }

  el.splide = new Splide(el, {
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
        gap: "20px",
      },
    },
  }).mount();
});
