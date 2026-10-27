// Слайдер «Банки-партнёры»: ширину карточек задаёт CSS (autoWidth), стрелки только на десктопе.
const banks_Splide = new Splide(".banks__splide", {
  autoWidth: true,
  perMove: 1,
  gap: "20px",
  pagination: true,
  arrows: true,
  updateOnMove: true,
  breakpoints: {
    991.9: {
      autoWidth: false,
      perPage: 1,
      arrows: false,
    },
  },
}).mount();