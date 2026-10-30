// Видео в статье (my-theme/blog-video): iframe получает src только по клику —
// страница не грузит плеер заранее, а autoplay срабатывает в жесте пользователя.
// Перенесено из tolstenko.marketing (assets/js/script.js).

function withAutoplay(src) {
  try {
    const url = new URL(src, window.location.href);

    if (/rutube\.ru/i.test(url.hostname)) {
      url.searchParams.set('autoplay', 'true');
    } else {
      url.searchParams.set('autoplay', '1');
    }

    return url.toString();
  } catch (e) {
    return src + (src.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1';
  }
}

function playVideo(root) {
  if (root.classList.contains('active')) {
    return;
  }

  const embed = root.querySelector('.video__embed');
  const iframe = root.querySelector('.video__embed iframe');
  const video = root.querySelector('video.video__iframe');

  // Сначала показываем блок: iframe в display:none не стартует autoplay.
  root.classList.add('active');

  if (embed) {
    embed.hidden = false;
  }

  if (iframe) {
    const src = iframe.getAttribute('data-src') || '';

    if (src) {
      const fresh = iframe.cloneNode(false);
      fresh.removeAttribute('data-src');
      fresh.src = withAutoplay(src);
      iframe.replaceWith(fresh);
    }
  }

  if (video) {
    video.hidden = false;

    if (typeof video.play === 'function') {
      video.play().catch(() => {});
    }
  }
}

document.querySelectorAll('[data-blog-video]').forEach((root) => {
  root.addEventListener('click', (e) => {
    if (root.classList.contains('active')) {
      return;
    }

    e.preventDefault();
    playVideo(root);
  });
});
