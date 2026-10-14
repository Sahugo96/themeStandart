export default function reviewsVideoLightbox() {
  const triggers = document.querySelectorAll('.reviews__list-preview--embed[data-video-src]');

  if (!triggers.length) {
    return;
  }

  const loadPoster = async (trigger) => {
    const poster = trigger.querySelector('.reviews__list-poster');

    if (!poster || poster.getAttribute('src')) {
      return;
    }

    const videoSrc = trigger.dataset.videoSrc;
    const rutubeId = trigger.dataset.rutubeId;

    if (!videoSrc) {
      return;
    }

    if (rutubeId) {
      try {
        const response = await fetch(`https://rutube.ru/api/video/${rutubeId}/`);

        if (response.ok) {
          const data = await response.json();

          if (data && data.thumbnail_url) {
            poster.src = data.thumbnail_url;
            return;
          }
        }
      } catch (error) {
        // fallback below
      }
    }

    if (typeof ajax_params === 'undefined') {
      return;
    }

    try {
      const response = await fetch(
        `${ajax_params.ajax_url}?action=theme_video_poster&src=${encodeURIComponent(videoSrc)}`
      );

      if (!response.ok) {
        return;
      }

      const data = await response.json();

      if (data && data.success && data.data && data.data.poster) {
        poster.src = data.data.poster;
      }
    } catch (error) {
      // ignore poster load errors
    }
  };

  triggers.forEach((trigger) => {
    loadPoster(trigger);
  });

  let modal = document.querySelector('.reviews-video-modal');

  if (!modal) {
    modal = document.createElement('div');
    modal.className = 'reviews-video-modal';
    modal.innerHTML = `
      <button class="reviews-video-modal__overlay" type="button" aria-label="Закрыть видео"></button>
      <div class="reviews-video-modal__dialog" role="dialog" aria-modal="true" aria-label="Видео отзыв">
        <button class="reviews-video-modal__close" type="button" aria-label="Закрыть">
          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
        <div class="reviews-video-modal__content"></div>
      </div>
    `;
    document.body.appendChild(modal);
  }

  const content = modal.querySelector('.reviews-video-modal__content');
  const overlay = modal.querySelector('.reviews-video-modal__overlay');
  const closeBtn = modal.querySelector('.reviews-video-modal__close');
  const body = document.body;

  const getAutoplaySrc = (src) => {
    try {
      const url = new URL(src);
      url.searchParams.set('autoplay', '1');
      return url.toString();
    } catch (error) {
      return src;
    }
  };

  const closeModal = () => {
    modal.classList.remove('is-active');
    body.classList.remove('lock');
    content.innerHTML = '';
  };

  const openModal = (src) => {
    const iframe = document.createElement('iframe');
    iframe.src = getAutoplaySrc(src);
    iframe.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('title', 'Видео отзыв');

    content.innerHTML = '';
    content.appendChild(iframe);
    modal.classList.add('is-active');
    body.classList.add('lock');
  };

  triggers.forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const src = trigger.dataset.videoSrc;

      if (src) {
        openModal(src);
      }
    });
  });

  overlay.addEventListener('click', closeModal);
  closeBtn.addEventListener('click', closeModal);

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && modal.classList.contains('is-active')) {
      closeModal();
    }
  });
}
