// Фильтр секции «Услуги» (services--slider) по рубрикам service_cat — по образцу caseSectionFilter.js.
// Табы — универсальный .filter--tabs, карточки приходят HTML-ом из inc/ajax/services-slider.php.
(function () {
  function mountSplide(container) {
    if (!container || typeof Splide === 'undefined' || !container.querySelector('.splide__list')) {
      return;
    }

    container.splide = new Splide(container, window.themeServicesSliderOptions || {
      perPage: 3,
      perMove: 1,
      gap: '20px',
      pagination: true,
      arrows: false,
      breakpoints: { 991.9: { perPage: 1, gap: '16px' } },
    }).mount();
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.services--slider').forEach(function (section) {
      var tabs = section.querySelectorAll('.filter__link[data-filter]');
      var container = section.querySelector('.services__slider');
      var ajaxUrl = window.services_slider_ajax && window.services_slider_ajax.ajax_url
        ? window.services_slider_ajax.ajax_url
        : '/wp-admin/admin-ajax.php';
      var request = 0;

      if (!container) {
        return;
      }

      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          if (tab.classList.contains('active')) {
            return;
          }

          tabs.forEach(function (other) {
            other.classList.toggle('active', other === tab);
          });

          var formData = new FormData();
          formData.append('action', 'filter_services_slider');
          formData.append('category', tab.getAttribute('data-filter') || '');
          formData.append('posts_per_page', section.getAttribute('data-posts-per-page') || '6');

          var postIds = section.getAttribute('data-post-ids') || '';
          if (postIds) {
            formData.append('post_ids', postIds);
          }

          // Ответ на устаревший клик (пользователь уже выбрал другой таб) игнорируем.
          var current = ++request;
          container.classList.add('loading');

          fetch(ajaxUrl, { method: 'POST', body: formData })
            .then(function (response) {
              return response.json();
            })
            .then(function (data) {
              if (current !== request) {
                return;
              }

              if (!data.success) {
                console.error('Services filter error:', data.data);
                return;
              }

              if (container.splide && typeof container.splide.destroy === 'function') {
                container.splide.destroy(true);
                container.splide = null;
              }

              container.innerHTML = data.data.html;
              mountSplide(container);
            })
            .catch(function (error) {
              console.error('Services AJAX error:', error);
            })
            .finally(function () {
              if (current === request) {
                container.classList.remove('loading');
              }
            });
        });
      });
    });
  });
})();
