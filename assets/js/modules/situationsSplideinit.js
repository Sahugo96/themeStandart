// Слайдер «Ситуации»: каждый слайд — две карточки друг под другом.
// Десктоп: 3 слайда в кадре, дальше «выглядывают» справа (трек не обрезается, см. _situations.scss).
const situations_Splide = new Splide(".situations__splide", {
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