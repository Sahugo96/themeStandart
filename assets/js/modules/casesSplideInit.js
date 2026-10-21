const cases_Splide = new Splide(".cases__splide", {
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