(function () {
  function mountSplide(container) {
    if (!container || typeof Splide === 'undefined') {
      return;
    }

    var existing = container.splide;

    if (existing && typeof existing.destroy === 'function') {
      existing.destroy(true);
    }

    var splide = new Splide(container, {
      perPage: 3,
      perMove: 1,
      gap: '20px',
      pagination: false,
      arrows: true,
      updateOnMove: true,
      breakpoints: {
        991.9: {
          perPage: 1,
          perMove: 1,
          gap: '20px',
          arrows: false,
          pagination: true,
        },
      },
    });

    splide.mount();
    container.classList.add('splide--initialized');
  }

  document.addEventListener('DOMContentLoaded', function () {
    var sections = document.querySelectorAll('.service-section--slider');

    sections.forEach(function (section) {
      var radios = section.querySelectorAll('.service-filter-radio');

      radios.forEach(function (radio) {
        radio.addEventListener('change', function () {
          if (!this.checked) {
            return;
          }

          var sectionId = this.getAttribute('data-section-id');
          var category = this.value;
          var container = document.getElementById(sectionId + '-container');

          if (!container || !section) {
            return;
          }

          container.classList.add('loading');

          var taxonomy = section.getAttribute('data-taxonomy') || 'service_cat';
          var postType = section.getAttribute('data-post-type') || 'service';
          var postsPerPage = section.getAttribute('data-posts-per-page') || '-1';
          var postIds = section.getAttribute('data-post-ids') || '';
          var ajaxUrl = window.service_ajax && window.service_ajax.ajax_url
            ? window.service_ajax.ajax_url
            : '/wp-admin/admin-ajax.php';

          var formData = new FormData();
          formData.append('action', 'filter_service_section');
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
                console.error('Filter error:', data.data);
                return;
              }

              container.innerHTML = data.data.html;
              mountSplide(container);
            })
            .catch(function (error) {
              console.error('AJAX error:', error);
            })
            .finally(function () {
              container.classList.remove('loading');
            });
        });
      });
    });
  });
})();
