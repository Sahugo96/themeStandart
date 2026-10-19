// Слайдер «Документы»: как result — точки-пагинация, без стрелок.
const documents_splide = new Splide(".documents__splide", {
  perPage: 5,
  perMove: 1,
  gap: "20px",
  arrows: false,
  pagination: true,
  updateOnMove: true,
  breakpoints: {
    991.9: {
      perPage: 1,
      perMove: 1,
      gap: "20px",
    },
  },
}).mount();
