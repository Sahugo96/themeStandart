if (document.querySelector(".reviews__splide--thenks")) {
  const reviews_splide_thenks = new Splide(".reviews__splide--thenks", {
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
}

if (document.querySelector(".reviews__splide--video")) {
  const reviews_splide_video = new Splide(".reviews__splide--video", {
    // type: "loop",
    perPage: 3,
    perMove: 1,
    gap: "30px",
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
}

if (document.querySelector(".reviews__splide--text")) {
  const reviews_splide_text = new Splide(".reviews__splide--text", {
    // type: "loop",
    perPage: 2,
    perMove: 1,
    gap: "30px",
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
}

