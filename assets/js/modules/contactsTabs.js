// Вкладки адресов секций «Контакты» и «Карты» (pages/sections/contacts*.php):
// кнопка .filter__link[data-tab-index] показывает панель [data-tab-panel] того же индекса.
// В «Контактах» в панели — галерея Splide (фото + миниатюры), монтируется,
// когда панель впервые становится видимой (в скрытой Splide не меряет размеры).

// Размеры миниатюр как в макете: 88px (моб. 387) / 110px (1280) / 110px (1920) — через vw темы.
const thumbsOptions = {
  mediaQuery: 'min',
  fixedWidth: '22.739vw',
  fixedHeight: '17.054vw',
  gap: '2.067vw',
  breakpoints: {
    992: { fixedWidth: '8.594vw', fixedHeight: '6.25vw', gap: '0.781vw' },
    1441: { fixedWidth: '5.729vw', fixedHeight: '4.167vw', gap: '0.521vw' },
  },
};

function mountGallery(gallery) {
  if (!gallery || gallery.dataset.ready || typeof Splide === 'undefined') {
    return;
  }
  gallery.dataset.ready = '1';

  const mainEl = gallery.querySelector('.contacts__gallery-main');
  const thumbsEl = gallery.querySelector('.contacts__gallery-thumbs');
  const many = mainEl && mainEl.querySelectorAll('.splide__slide').length > 1;

  // Без стрелок: фото переключаются миниатюрами и свайпом.
  const main = new Splide(mainEl, {
    type: 'fade',
    rewind: true,
    pagination: false,
    arrows: false,
    drag: many,
  });

  if (thumbsEl) {
    const thumbs = new Splide(thumbsEl, Object.assign({
      rewind: true,
      pagination: false,
      arrows: false,
      isNavigation: true,
    }, thumbsOptions));
    main.sync(thumbs);
    main.mount();
    thumbs.mount();
  } else {
    main.mount();
  }
}

document.querySelectorAll('[data-contacts-tabs]').forEach((root) => {
  if (root.dataset.tabsReady) {
    return;
  }
  root.dataset.tabsReady = '1';

  const panels = root.querySelectorAll('[data-tab-panel]');

  const show = (index) => {
    panels.forEach((panel) => {
      const active = panel.dataset.tabPanel === String(index);
      panel.hidden = !active;
      panel.classList.toggle('is-active', active);
      if (active) {
        panel.querySelectorAll('[data-contacts-gallery]').forEach(mountGallery);
      }
    });
  };

  // Вкладки — кнопки .filter__link (как фильтр «Слайдера услуг»), активная — .active.
  const tabs = root.querySelectorAll('.filter__link[data-tab-index]');

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      tabs.forEach((other) => {
        const active = other === tab;
        other.classList.toggle('active', active);
        other.setAttribute('aria-selected', active ? 'true' : 'false');
      });
      show(tab.dataset.tabIndex);
    });
  });

  const current = root.querySelector('.filter__link.active[data-tab-index]');
  show(current ? current.dataset.tabIndex : (panels[0] ? panels[0].dataset.tabPanel : 0));
});
