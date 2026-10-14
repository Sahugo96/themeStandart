const service_Section_splide = new Splide(".service-section__splide", {
  perPage: 3,
  perMove: 1,
  gap: "20px",
  pagination: false,
  arrows: true,
  updateOnMove: true,
  breakpoints: {
    991.9: {
      perPage: 1,
      perMove: 1,
      gap: "20px",
      arrows: false,
      pagination: true,
    },
  },
}).mount(); 

