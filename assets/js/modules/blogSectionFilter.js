// Секция «Статьи»: фильтр по рубрикам (радио .tolstenko-filter-radio) без перезагрузки.
// Карточки берутся из REST /wp-json/theme/v1/blog-section (inc/blog/blog-section.php).
// Перенесено из tolstenko.marketing (assets/js/script.js, «Универсальный REST-фильтр»).

const restUrl = `${window.location.origin}/wp-json/theme/v1/blog-section`;

function animateFadeIn(container) {
  container.querySelectorAll('.fade-in-element').forEach((el, index) => {
    el.classList.remove('visible');
    window.setTimeout(() => el.classList.add('visible'), index * 100);
  });
}

function loadTerm(section, term) {
  const container = document.getElementById(`${section.dataset.sectionId}-container`);

  if (!container) {
    return;
  }

  const url = new URL(restUrl);
  url.searchParams.set('term', term || '');
  url.searchParams.set('posts_per_page', section.dataset.postsPerPage || '4');
  url.searchParams.set('post_ids', section.dataset.postIds || '');
  url.searchParams.set('btn_text', section.dataset.btnText || '');

  container.classList.add('loading');

  fetch(url.toString(), { headers: { Accept: 'application/json' }, credentials: 'same-origin' })
    .then((response) => {
      if (!response.ok) {
        throw new Error('Blog section filter request failed');
      }
      return response.json();
    })
    .then((data) => {
      container.innerHTML = data && typeof data.html === 'string' ? data.html : '';
      animateFadeIn(container);

      if (typeof window.themeBlogSectionResync === 'function') {
        window.themeBlogSectionResync(container);
      }
    })
    .catch((error) => console.error(error))
    .finally(() => container.classList.remove('loading'));
}

document.querySelectorAll('.blog-section[data-tolstenko-filter]').forEach((section) => {
  if (section.dataset.filterBound) {
    return;
  }

  section.dataset.filterBound = '1';

  section.querySelectorAll('.tolstenko-filter-radio').forEach((radio) => {
    radio.addEventListener('change', () => {
      if (radio.checked) {
        loadTerm(section, radio.value);
      }
    });
  });
});
