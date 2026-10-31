// «SEO-наполнение» (pages/sections/seo-section.php): первая строка видна сразу,
// «Читать полностью» / «Свернуть» раскрывает остальные; галерея — в Fancybox.
import { Fancybox } from "https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.esm.js";

Fancybox.bind('.seo-section [data-fancybox]', {});

document.querySelectorAll('.seo-section__panel').forEach((panel) => {
  const btn = panel.querySelector('[data-seo-more]');

  if (!btn || btn.dataset.ready) {
    return;
  }

  btn.dataset.ready = '1';

  const label = btn.querySelector('[data-seo-more-label]');
  const moreText = label ? label.textContent : '';
  const lessText = btn.dataset.less || moreText;

  btn.addEventListener('click', () => {
    const expanded = panel.classList.toggle('is-expanded');

    btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');

    if (label) {
      label.textContent = expanded ? lessText : moreText;
    }

    // После сворачивания возвращаем к карточке, если она ушла за верх экрана.
    if (!expanded && panel.getBoundingClientRect().top < 0) {
      const top = panel.getBoundingClientRect().top + window.scrollY - 120;
      window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
    }
  });
});
