// Слайдеры секции «Отзывы» (pages/sections/reviews.php): по одному на тип отзывов,
// переключаются табами (CSS :has по радио-кнопкам). Пагинация — точки, как в «Кейсах».
const reviewsSliders = {
  ".reviews__splide--thenks": { perPage: 5 },
  ".reviews__splide--video": { perPage: 3 },
  // Текстовые: ширина карточки задаётся в CSS, карточки уходят за край контейнера.
  ".reviews__splide--text": { autoWidth: true },
};

Object.keys(reviewsSliders).forEach((selector) => {
  document.querySelectorAll(selector).forEach((el) => {
    if (el.splide) {
      return;
    }

    el.splide = new Splide(el, Object.assign({
      perMove: 1,
      gap: "20px",
      arrows: false,
      pagination: true,
      updateOnMove: true,
      breakpoints: {
        991.9: {
          autoWidth: false,
          perPage: 1,
          perMove: 1,
          gap: "16px",
        },
      },
    }, reviewsSliders[selector])).mount();
  });
});
