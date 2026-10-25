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

// Остальные секции статей (например, «Статьи» на главной): слайдер по одной карточке
// только на мобильных. С 992px Splide полностью снимается (вместе с inline-стилями),
// и карточки раскладываются сеткой в CSS. Опция destroy в breakpoints в этой сборке
// Splide не срабатывает, поэтому переключаем вручную через matchMedia.
const desktopQuery = window.matchMedia('(min-width: 992px)');

document.querySelectorAll('.blog-section__splide, .blog-section__slider').forEach((slider) => {
  if (slider.closest('.blog-section--same')) {
    return;
  }

  let instance = null;

  const sync = () => {
    if (desktopQuery.matches) {
      if (instance) {
        instance.destroy(true);
        instance = null;
        // destroy() оставляет классы состояния, а splide-core для
        // .is-initialized:not(.is-active) делает список display: block.
        slider.classList.remove('is-initialized', 'is-overflow', 'is-rendered');
      }
      return;
    }

    if (!instance) {
      instance = new Splide(slider, {
        perPage: 1,
        perMove: 1,
        gap: '20px',
        pagination: true,
        arrows: false,
        updateOnMove: true,
      }).mount();
    }
  };

  sync();
  desktopQuery.addEventListener('change', sync);
});
