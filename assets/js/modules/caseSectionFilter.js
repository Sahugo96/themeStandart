(function () {
  function mountSplide(container) {
    if (!container || typeof Splide === 'undefined') {
      return;
    }

    var splide = new Splide(container, {
      perPage: 3,
      perMove: 1,
      gap: '20px',
      pagination: true,
      arrows: false,
      updateOnMove: true,
      breakpoints: {
        991.9: {
          perPage: 1,
          perMove: 1,
          gap: '20px',
        },
      },
    });

    splide.mount();
    container.splide = splide;
    container.classList.add('splide--initialized');
  }

  document.addEventListener('DOMContentLoaded', function () {
    var sections = document.querySelectorAll('.cases');

    sections.forEach(function (section) {
      var tabs = section.querySelectorAll('.filter__link[data-filter]');

      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          if (this.classList.contains('active')) {
            return;
          }

          tabs.forEach(function (other) {
            other.classList.remove('active');
          });

          this.classList.add('active');

          var category = this.getAttribute('data-filter') || '';
          var container = section.querySelector('.cases__splide');

          if (!container) {
            return;
          }

          container.classList.add('loading');

          var taxonomy = section.getAttribute('data-taxonomy') || 'case_cat';
          var postType = section.getAttribute('data-post-type') || 'case';
          var postsPerPage = section.getAttribute('data-posts-per-page') || '-1';
          var postIds = section.getAttribute('data-post-ids') || '';
          var ajaxUrl = window.cases_ajax && window.cases_ajax.ajax_url
            ? window.cases_ajax.ajax_url
            : '/wp-admin/admin-ajax.php';

          var formData = new FormData();
          formData.append('action', 'filter_cases_section');
          formData.append('category', category);
          formData.append('taxonomy', taxonomy);
          formData.append('post_type', postType);
          formData.append('posts_per_page', postsPerPage);

          if (postIds) {
            formData.append('post_ids', postIds);
          }

          fetch(ajaxUrl, {
            method: 'POST',
            body: formData,
          })
            .then(function (response) {
              return response.json();
            })
            .then(function (data) {
              if (!data.success) {
                console.error('Cases filter error:', data.data);
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
              console.error('Cases AJAX error:', error);
            })
            .finally(function () {
              container.classList.remove('loading');
            });
        });
      });
    });
  });
})();