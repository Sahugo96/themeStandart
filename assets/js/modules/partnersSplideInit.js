const team_splide = new Splide(".partners__splide", {
  // type: "loop",
  perPage: 5,
  perMove: 1,
  gap: "20px",
  arrows: true,
  pagination: false,
  updateOnMove: true,
  breakpoints: {
    991.9: {
      perPage: 1,
      perMove: 1,
      arrows: false,
      pagination: true,
    },
  },
}).mount();

