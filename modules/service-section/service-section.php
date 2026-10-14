<?php
if (get_field('service_section_true')) {
  if (get_field('service_section_rewrite')) {
    $title = get_field('service_section_title') ?: get_field('service_section_title', OPTION_ID);
    $text = get_field('service_section_text') ?: get_field('service_section_text', OPTION_ID);
  } else {
    $title = get_field('service_section_title', OPTION_ID);
    $text = get_field('service_section_text', OPTION_ID);
  }
  $items = get_field('service_section_items');
  

  /**
   * Section template for Services with AJAX radio filters
   * Использование: get_template_part('sections/service-section', null, ['section_id' => 'unique_id', 'taxonomy' => 'service_cat', 'post_type' => 'service'])
   */

  // Уникальный ID для этой секции
  $section_id = isset($args['section_id']) ? $args['section_id'] : 'services_' . uniqid();
  $taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : 'service_cat';
  $post_type = isset($args['post_type']) ? $args['post_type'] : 'service';
  $posts_per_page = isset($args['posts_per_page']) ? $args['posts_per_page'] : 1;

  // Получаем все рубрики
  $all_categories = get_terms([
    'taxonomy'   => $taxonomy,
    'hide_empty' => false,
  ]);

  // Первоначальный запрос (без фильтрации)
  $args_query = [
    'post_type'      => $post_type,
    'posts_per_page' => $posts_per_page,
    'paged'          => 1,
  ];

  if ($items) {
    $section_query = new WP_Query([
      'post_type' => 'any', // или укажите конкретный тип постов
      'post__in' => wp_list_pluck($items, 'ID'),
      'posts_per_page' => -1,
      'orderby' => 'post__in', // сохраняет порядок из ACF
    ]);
  } else {
    $section_query = new WP_Query($args_query);
  }
?>

  <section class="service-section section service-section load-on-vissible--js"
    data-section-id="<?php echo esc_attr($section_id); ?>"
    data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
    data-post-type="<?php echo esc_attr($post_type); ?>"
    data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>">
    <div class="container">
      <div class="service-section__top section-top">
        <h2 class="service-section__title h2"><?= $title; ?></h2>

        <?php
        if ($text) {
        ?>
          <p class="service-section__text paragraph-15-15"><?= $text; ?></p>
        <?php
        }
        ?>
      </div>

      <!-- Фильтр с радиокнопками -->
      <?php
      if ($all_categories && !is_wp_error($all_categories)) :
        // Фильтруем категории, оставляя только те, у которых есть хотя бы 1 запись
        $categories_with_posts = array_filter($all_categories, function ($cat) {
          return $cat->count > 0; // count содержит количество записей в категории
        });

        // Проверяем, есть ли хотя бы одна категория с записями
        if (!empty($categories_with_posts)) :
      ?>
          <div class="service-section__filter filter">
            <div class="filter__form">
              <label class="filter__radio">
                <input type="radio"
                  name="<?php echo esc_attr($section_id); ?>_category"
                  value=""
                  data-section-id="<?php echo esc_attr($section_id); ?>"
                  class="service-filter-radio"
                  checked>
                <span class="filter__label">Все услуги</span>
              </label>

              <?php foreach ($categories_with_posts as $cat) : ?>
                <label class="filter__radio">
                  <input type="radio"
                    name="<?php echo esc_attr($section_id); ?>_category"
                    value="<?php echo esc_attr($cat->slug); ?>"
                    data-section-id="<?php echo esc_attr($section_id); ?>"
                    class="service-filter-radio">
                  <span class="filter__label"><?php echo esc_html($cat->name); ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        <?php
        endif;
      endif;
      if ($section_query->have_posts()) :
        ?>

        <!-- Контейнер для услуг -->
        <div class="fade-in-container service-section__splide splide load-on-vissible--js"
          aria-label="Splide direction"
          data-module="./libs/splide.min.js,./modules/serviceSectionSplideInit.js"
          data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
          id="<?php echo esc_attr($section_id); ?>-container">
          <div class="splide__track">
            <div class="service-section__splide-list splide__list">
              <?php while ($section_query->have_posts()) : $section_query->the_post(); ?>
                <article class="service-section__item service-card fade-in-element splide__slide">
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="service-card__image">
                      <?= get_the_post_thumbnail(get_the_ID()); ?>

                      <?php
                      $post_id = get_the_ID(); // или любой другой ID
                      $tags = get_the_terms($post_id, 'service_cat');

                      if ($tags && !is_wp_error($tags)) :

                        $selected_category = isset($_POST['category']) ? $_POST['category'] : '';

                        if (!empty($selected_category)) {
                          $selected_term = null;
                          $other_terms = [];

                          foreach ($tags as $tag) {
                            if ($tag->slug === $selected_category) {
                              $selected_term = $tag;
                            } else {
                              $other_terms[] = $tag;
                            }
                          }

                          if ($selected_term) {
                            $tags = array_merge([$selected_term], $other_terms);
                          }
                        }

                        if ($tags && !is_wp_error($tags)) :
                          $tags = array_slice($tags, 0, 1);
                          foreach ($tags as $tag) : ?>
                            <span class="service-card__tag caption-8-10">
                              <?= esc_html($tag->name); ?>
                            </span>
                      <?php endforeach;
                        endif;
                      endif; ?>

                      <span class="service-card__hit caption-8-10">
                        хит

                        <?php
                        if (get_field('single_service_hit', get_the_ID()) && get_field('single_service_action', get_the_ID())) {
                        ?>
                          <span><?= get_field('single_service_action', get_the_ID()); ?>%</span>
                        <?php
                        }
                        ?>
                      </span>
                    </div>
                  <?php endif; ?>
                  <div class="service-card__wrapper">

                    <h4 class="service-card__title paragraph-15-15"><?= get_the_title(); ?></h4>

                    <div class="service-card__text line-13-15"><?= get_field('single_service_description', get_the_ID()); ?></div>


                    <div class="service-card__cost line-13-15">
                      Цена от <?= get_field('single_service_same_cost', get_the_ID()); ?>₽
                      <?php
                      if (get_field('single_service_cost', get_the_ID())) {
                      ?>
                        <span><?= get_field('single_service_cost', get_the_ID()); ?>₽</span>
                      <?php
                      }
                      ?>
                    </div>
                  </div>

                  <div class="service-card__btns">
                    <a class="service-card__btn default-btn" href="<?= get_permalink(); ?>">
                      Подробнее
                    </a>

                    <a class="service-card__btn default-btn" href="#modal">
                      Консультация
                    </a>
                  </div>
                </article>
                <article class="service-section__item service-card fade-in-element splide__slide">
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="service-card__image">
                      <?= get_the_post_thumbnail(get_the_ID()); ?>

                      <?php
                      $post_id = get_the_ID(); // или любой другой ID
                      $tags = get_the_terms($post_id, 'service_cat');

                      if ($tags && !is_wp_error($tags)) :

                        $selected_category = isset($_POST['category']) ? $_POST['category'] : '';

                        if (!empty($selected_category)) {
                          $selected_term = null;
                          $other_terms = [];

                          foreach ($tags as $tag) {
                            if ($tag->slug === $selected_category) {
                              $selected_term = $tag;
                            } else {
                              $other_terms[] = $tag;
                            }
                          }

                          if ($selected_term) {
                            $tags = array_merge([$selected_term], $other_terms);
                          }
                        }

                        if ($tags && !is_wp_error($tags)) :
                          $tags = array_slice($tags, 0, 1);
                          foreach ($tags as $tag) : ?>
                            <span class="service-card__tag caption-8-10">
                              <?= esc_html($tag->name); ?>
                            </span>
                      <?php endforeach;
                        endif;
                      endif; ?>

                      <span class="service-card__hit caption-8-10">
                        хит

                        <?php
                        if (get_field('single_service_hit', get_the_ID()) && get_field('single_service_action', get_the_ID())) {
                        ?>
                          <span><?= get_field('single_service_action', get_the_ID()); ?>%</span>
                        <?php
                        }
                        ?>
                      </span>
                    </div>
                  <?php endif; ?>
                  <div class="service-card__wrapper">

                    <h4 class="service-card__title paragraph-15-15"><?= get_the_title(); ?></h4>

                    <div class="service-card__text line-13-15"><?= get_field('single_service_description', get_the_ID()); ?></div>


                    <div class="service-card__cost line-13-15">
                      Цена от <?= get_field('single_service_same_cost', get_the_ID()); ?>₽
                      <?php
                      if (get_field('single_service_cost', get_the_ID())) {
                      ?>
                        <span><?= get_field('single_service_cost', get_the_ID()); ?>₽</span>
                      <?php
                      }
                      ?>
                    </div>
                  </div>

                  <div class="service-card__btns">
                    <a class="service-card__btn default-btn" href="<?= get_permalink(); ?>">
                      Подробнее
                    </a>

                    <a class="service-card__btn default-btn" href="#modal">
                      Консультация
                    </a>
                  </div>
                </article>
              <?php
              endwhile;
              ?>
            </div>
          </div>

          <div class="splide__bottom">
            <div class="splide__pagination"></div>

            <div class="splide__arrows splide__arrows--ltr">
              <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide">
                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
                </svg>
              </button>

              <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide">
                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>
    </div>
  <?php
        wp_reset_postdata();
      endif; ?>
  </section>

  <script>
    // Глобальная функция для фильтрации
    document.addEventListener('DOMContentLoaded', function() {
      // Находим все радио-кнопки фильтров на странице
      const radioButtons = document.querySelectorAll('.service-filter-radio');

      radioButtons.forEach(radio => {
        radio.addEventListener('change', function(e) {
          if (!this.checked) return;

          const sectionId = this.getAttribute('data-section-id');
          const category = this.value;
          const container = document.getElementById(sectionId + '-container');
          const section = document.querySelector(`[data-section-id="${sectionId}"]`);

          if (!container || !section) return;

          // Показываем загрузку
          container.classList.add('loading');

          // Получаем параметры секции
          const taxonomy = section.getAttribute('data-taxonomy');
          const postType = section.getAttribute('data-post-type');
          const postsPerPage = section.getAttribute('data-posts-per-page');

          if (typeof service_ajax === 'undefined') {
            window.service_ajax = {
              ajax_url: '/wp-admin/admin-ajax.php'
            };
          }

          // Отправляем AJAX запрос
          const formData = new FormData();
          formData.append('action', 'filter_service_section');
          formData.append('category', category);
          formData.append('taxonomy', taxonomy);
          formData.append('post_type', postType);
          formData.append('posts_per_page', postsPerPage);
          formData.append('section_id', sectionId);

          fetch(typeof service_ajax !== 'undefined' ? service_ajax.ajax_url : '/wp-admin/admin-ajax.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                container.innerHTML = data.data.html;

                // Выполняем скрипты из ответа
                var scripts = container.querySelectorAll('script');
                console.log(scripts);

                scripts.forEach(function(script) {
                  var newScript = document.createElement('script');
                  if (script.src) {
                    newScript.src = script.src;
                  } else {
                    newScript.textContent = script.textContent;
                  }
                  document.body.appendChild(newScript);
                  script.remove();
                });
              } else {
                console.error('Filter error:', data.data);
              }
            })
            .catch(error => {
              console.error('AJAX error:', error);
            })
            .finally(() => {
              container.classList.remove('loading');
            });
        });
      });
    });
  </script>


<?php
}
?>