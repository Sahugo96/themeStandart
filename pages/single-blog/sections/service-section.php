<?php
  $title = 'Рекомендуем так же ознакомиться';
  $items = theme_get_field('blog_services');
  
  $post_type = isset($args['post_type']) ? $args['post_type'] : 'service';
  $posts_per_page = isset($args['posts_per_page']) ? $args['posts_per_page'] : 1;


  // Первоначальный запрос (без фильтрации)
  $args_query = [
    'post_type'      => $post_type,
    'posts_per_page' => $posts_per_page,
    'paged'  => 6,
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

  <section class="service-section section">
    <div class="container">
      <div class="section-top">
        <h2 class="service-section__title h2"><?= $title; ?></h2>
      </div>

      <?php
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
                        if (theme_get_field('single_service_hit', get_the_ID()) && theme_get_field('single_service_action', get_the_ID())) {
                        ?>
                          <span><?= theme_get_field('single_service_action', get_the_ID()); ?>%</span>
                        <?php
                        }
                        ?>
                      </span>
                    </div>
                  <?php endif; ?>
                  <div class="service-card__wrapper">

                    <h4 class="service-card__title paragraph-15-15"><?= get_the_title(); ?></h4>

                    <div class="service-card__text line-13-15"><?= theme_get_field('single_service_description', get_the_ID()); ?></div>


                    <div class="service-card__cost line-13-15">
                      Цена от <?= theme_get_field('single_service_same_cost', get_the_ID()); ?>₽
                      <?php
                      if (theme_get_field('single_service_cost', get_the_ID())) {
                      ?>
                        <span><?= theme_get_field('single_service_cost', get_the_ID()); ?>₽</span>
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
                        if (theme_get_field('single_service_hit', get_the_ID()) && theme_get_field('single_service_action', get_the_ID())) {
                        ?>
                          <span><?= theme_get_field('single_service_action', get_the_ID()); ?>%</span>
                        <?php
                        }
                        ?>
                      </span>
                    </div>
                  <?php endif; ?>
                  <div class="service-card__wrapper">

                    <h4 class="service-card__title paragraph-15-15"><?= get_the_title(); ?></h4>

                    <div class="service-card__text line-13-15"><?= theme_get_field('single_service_description', get_the_ID()); ?></div>


                    <div class="service-card__cost line-13-15">
                      Цена от <?= theme_get_field('single_service_same_cost', get_the_ID()); ?>₽
                      <?php
                      if (theme_get_field('single_service_cost', get_the_ID())) {
                      ?>
                        <span><?= theme_get_field('single_service_cost', get_the_ID()); ?>₽</span>
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
  <?php
        wp_reset_postdata();
      else : ?>
  <?php endif; ?>
  </div>
  </section>

