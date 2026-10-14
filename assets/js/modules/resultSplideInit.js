// Слайдер «Что вы получаете»: на мобильных — слайдер с точками,
// на десктопе (от 992px) слайдер выключается и карточки лежат сеткой 3×2 (см. _result.scss).
const result_Splide = new Splide(".result__splide", {
  mediaQuery: "min", // брейкпоинты работают от min-width (mobile first)
  perPage: 1,
  perMove: 1,
  gap: "20px",
  pagination: true,
  arrows: false,
  updateOnMove: true,
  breakpoints: {
    992: {
      destroy: true,
    },
  },
}).mount();