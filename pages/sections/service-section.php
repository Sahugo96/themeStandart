<?php
$services_slider_data = get_query_var('services_slider_data');
$section = get_query_var('section');
$post_ids = [];

if (is_array($services_slider_data) && !empty($services_slider_data)) {
  $title = $services_slider_data['title'] ?? '';
  $text = $services_slider_data['text'] ?? '';
  $post_ids = $services_slider_data['post_ids'] ?? [];
} elseif ($section && $section !== true && is_array($section) && !empty($section['service_section_rewrite'])) {
  $title = $section['service_section_title'];
  $text = $section['service_section_text'];
  $items = $section['service_section_items'];
} else {
  $title = theme_get_field('service_section_title', OPTION_ID);
  $text = theme_get_field('service_section_text', OPTION_ID);
  $items = theme_get_field('service_section_items');
}

if (!empty($items) && empty($post_ids)) {
  $post_ids = wp_list_pluck($items, 'ID');
}

$post_ids = array_values(array_filter(array_map('intval', (array) $post_ids)));

theme_enqueue_services_slider_assets();

/**
 * Section template for Services slider with AJAX radio filters
 * Использование: get_template_part('pages/sections/service-section', null, ['section_id' => 'unique_id', 'taxonomy' => 'service_cat', 'post_type' => 'service'])
 */

$section_id = isset($args['section_id']) ? $args['section_id'] : 'services_' . uniqid();
$taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : 'service_cat';
$post_type = isset($args['post_type']) ? $args['post_type'] : 'service';

if (isset($args['posts_per_page'])) {
  $posts_per_page = (int) $args['posts_per_page'];
} elseif (!empty($post_ids)) {
  $posts_per_page = -1;
} else {
  $posts_per_page = 6;
}

$all_categories = get_terms([
  'taxonomy'   => $taxonomy,
  'hide_empty' => false,
]);

$section_query = new WP_Query(theme_get_services_slider_query_args([
  'category'       => '',
  'taxonomy'       => $taxonomy,
  'post_type'      => $post_type,
  'posts_per_page' => $posts_per_page,
  'post_ids'       => $post_ids,
]));
?>

<section class="service-section service-section--slider section service-section load-on-vissible--js"
  data-section-id="<?php echo esc_attr($section_id); ?>"
  data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
  data-post-type="<?php echo esc_attr($post_type); ?>"
  data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>"
  data-post-ids="<?php echo esc_attr(implode(',', $post_ids)); ?>">
  <div class="container">
    <div class="service-section__top section-top">
      <h2 class="service-section__title h2"><?= $title; ?></h2>

      <?php
      if ($text) {
      ?>
        <div class="service-section__text paragraph-15-15"><?= theme_section_text_html($text); ?></div>
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
              <?php get_template_part('pages/sections/partials/service-card', null, ['taxonomy' => $taxonomy]); ?>
            <?php endwhile; ?>
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