// «SEO-наполнение» (pages/sections/seo-section.php) — как в tolstenko.marketing:
// содержимое свёрнуто по высоте с затемнением снизу, кнопка под карточкой раскрывает
// его целиком и скрывается. Галерея — в Fancybox.
import { Fancybox } from "https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.esm.js";

Fancybox.bind('.seo-section [data-fancybox]', {});

document.querySelectorAll('.seo-section__wrap').forEach((wrap) => {
  const body = wrap.querySelector('[data-seo-body]');
  const btn = wrap.querySelector('[data-seo-more]');

  if (!body || !btn || btn.dataset.ready) {
    return;
  }

  btn.dataset.ready = '1';

  // Содержимое помещается без обрезки — затемнение и кнопка не нужны.
  const syncOverflow = () => {
    if (wrap.classList.contains('is-expanded')) {
      return;
    }
    wrap.classList.toggle('is-short', body.scrollHeight <= body.clientHeight + 4);
  };

  syncOverflow();
  window.addEventListener('resize', syncOverflow, { passive: true });

  // Высота может вырасти после загрузки шрифтов и картинок — проверяем ещё раз.
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(syncOverflow);
  }
  body.querySelectorAll('img').forEach((img) => {
    if (!img.complete) {
      img.addEventListener('load', syncOverflow, { once: true });
    }
  });

  btn.addEventListener('click', () => {
    wrap.classList.add('is-expanded');
    btn.setAttribute('aria-expanded', 'true');
  });
});
