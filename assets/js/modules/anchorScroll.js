const MODAL_HASHES = new Set(['#', '#modal', '#modalUp']);

function getScrollOffset() {
  const header = document.querySelector('.header');

  return (header ? header.offsetHeight : 0) + 20;
}

function scrollToElement(target, behavior = 'smooth') {
  const top = target.getBoundingClientRect().top + window.scrollY - getScrollOffset();

  window.scrollTo({
    top: Math.max(0, top),
    behavior,
  });
}

function scrollToHash(hash, smooth = true) {
  const target = document.querySelector(hash);

  if (!target) {
    return false;
  }

  if (typeof window.themeLoadLazyImagesNow === 'function') {
    window.themeLoadLazyImagesNow();
  }

  scrollToElement(target, smooth ? 'smooth' : 'auto');

  [150, 400, 800].forEach((delay) => {
    window.setTimeout(() => {
      const element = document.querySelector(hash);

      if (element) {
        scrollToElement(element, 'auto');
      }
    }, delay);
  });

  return true;
}

export default function anchorScroll() {
  document.addEventListener('click', (event) => {
    const link = event.target.closest('a[href^="#"]');

    if (!link) {
      return;
    }

    const hash = link.getAttribute('href');

    if (!hash || MODAL_HASHES.has(hash) || !document.querySelector(hash)) {
      return;
    }

    event.preventDefault();

    if (window.history.pushState) {
      window.history.pushState(null, '', hash);
    } else {
      window.location.hash = hash;
    }

    scrollToHash(hash);
  });

  const initialHash = window.location.hash;

  if (initialHash && !MODAL_HASHES.has(initialHash) && document.querySelector(initialHash)) {
    window.addEventListener('load', () => {
      window.setTimeout(() => scrollToHash(initialHash, false), 100);
    });
  }
}
