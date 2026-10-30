// «SEO-наполнение» (pages/sections/seo-section.php): свёрнутая панель с кнопкой
// «Читать далее» / «Свернуть» и галерея в Fancybox (как в «Документах»).
import { Fancybox } from "https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.esm.js";

Fancybox.bind('.seo-section [data-fancybox]', {});

document.querySelectorAll('.seo-section__panel').forEach((panel) => {
  const body = panel.querySelector('[data-seo-body]');
  const btn = panel.querySelector('[data-seo-more]');

  if (!body || !btn || btn.dataset.ready) {
    return;
  }

  btn.dataset.ready = '1';

  const label = btn.querySelector('[data-seo-more-label]');
  const moreText = label ? label.textContent : '';
  const lessText = btn.dataset.less || moreText;

  // Текст короче свёрнутой высоты — кнопка и затемнение не нужны.
  const syncOverflow = () => {
    if (panel.classList.contains('is-expanded')) {
      return;
    }
    panel.classList.toggle('is-short', body.scrollHeight <= body.clientHeight + 4);
  };

  syncOverflow();
  window.addEventListener('resize', syncOverflow, { passive: true });

  btn.addEventListener('click', () => {
    const expanded = panel.classList.toggle('is-expanded');

    btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');

    if (label) {
      label.textContent = expanded ? lessText : moreText;
    }

    if (!expanded) {
      const top = panel.getBoundingClientRect().top + window.scrollY - 120;
      window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
    }
  });
});
