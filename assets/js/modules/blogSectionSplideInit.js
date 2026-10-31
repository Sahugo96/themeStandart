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

// Секция «Статьи» (.blog-section__splide): слайдер по одной карточке из трека
// только на мобильных; первая (крупная) карточка — вне трека и не листается.
// Экземпляр хранится на элементе, чтобы фильтр мог пересобрать слайдер.
const syncSlider = (slider) => {
  if (desktopQuery.matches || slider.querySelectorAll('.splide__track .splide__slide').length < 2) {
    if (slider.splideInstance) {
      slider.splideInstance.destroy(true);
      slider.splideInstance = null;
      // destroy() оставляет классы состояния, а splide-core для
      // .is-initialized:not(.is-active) делает список display: block.
      slider.classList.remove('is-initialized', 'is-overflow', 'is-rendered');
    }
    return;
  }

  if (!slider.splideInstance) {
    slider.splideInstance = new Splide(slider, {
      perPage: 1,
      perMove: 1,
      gap: '20px',
      pagination: true,
      arrows: false,
      updateOnMove: true,
    }).mount();
  }
};

// После замены карточек (фильтр по рубрикам): снять старый слайдер и собрать заново.
window.themeBlogSectionResync = (slider) => {
  if (slider && slider.splideInstance) {
    try {
      slider.splideInstance.destroy(true);
    } catch (e) {
      // разметка уже заменена
    }
    slider.splideInstance = null;
    slider.classList.remove('is-initialized', 'is-overflow', 'is-rendered');
  }
  if (slider) {
    syncSlider(slider);
  }
};

document.querySelectorAll('.blog-section__splide, .blog-section__slider').forEach((slider) => {
  if (slider.closest('.blog-section--same') || slider.dataset.splideBound) {
    return;
  }

  slider.dataset.splideBound = '1';
  syncSlider(slider);
  desktopQuery.addEventListener('change', () => syncSlider(slider));
});
