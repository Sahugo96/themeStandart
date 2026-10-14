const sameSliders = document.querySelectorAll('.blog-section--same .blog-section__splide');

sameSliders.forEach((slider) => {
  new Splide(slider, {
    perPage: 3,
    perMove: 1,
    gap: '20px',
    pagination: false,
    arrows: true,
    updateOnMove: true,
    breakpoints: {
      991.9: {
        perPage: 1,
        perMove: 1,
        gap: '20px',
        arrows: false,
        pagination: true,
      },
    },
  }).mount();
});

if (window.innerWidth < 992) {
  document.querySelectorAll('.blog-section__splide').forEach((slider) => {
    if (slider.closest('.blog-section--same')) {
      return;
    }

    new Splide(slider, {
      perPage: 1,
      perMove: 1,
      gap: '20px',
      pagination: true,
      arrows: false,
      updateOnMove: true,
    }).mount();
  });
}
