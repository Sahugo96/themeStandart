<?php

/**
 * Слайдер услуг без фильтров.
 */

$services_slider_simple_data = get_query_var('services_slider_simple_data');

if (is_array($services_slider_simple_data) && $services_slider_simple_data) {
    $title = $services_slider_simple_data['title'] ?? '';
    $text = $services_slider_simple_data['text'] ?? '';
    $post_ids = $services_slider_simple_data['post_ids'] ?? [];
} else {
    $title = $args['title'] ?? '';
    $text = $args['text'] ?? '';
    $post_ids = $args['post_ids'] ?? [];
}

$post_ids = array_values(array_filter(array_map('intval', (array) $post_ids)));
$section_id = isset($args['section_id']) ? $args['section_id'] : 'services_simple_' . wp_unique_id();
$taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : 'service_cat';

if ($post_ids) {
    $section_query = new WP_Query([
        'post_type'      => 'service',
        'post__in'       => $post_ids,
        'posts_per_page' => -1,
        'orderby'        => 'post__in',
    ]);
} else {
    $section_query = new WP_Query([
        'post_type'      => 'service',
        'posts_per_page' => isset($args['posts_per_page']) ? (int) $args['posts_per_page'] : 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}

if (!$section_query->have_posts()) {
    wp_reset_postdata();
    return;
}
?>

<section class="service-section section">
  <div class="container">
    <div class="service-section__top section-top">
      <?php if ($title !== '') : ?>
        <h2 class="service-section__title h2"><?= $title; ?></h2>
      <?php endif; ?>

      <?php if ($text !== '') : ?>
        <div class="service-section__text paragraph-15-15"><?= theme_section_text_html($text); ?></div>
      <?php endif; ?>
    </div>

    <div class="fade-in-container service-section__splide splide load-on-vissible--js"
      aria-label="Слайдер услуг"
      data-module="./libs/splide.min.js,./modules/serviceSectionSplideInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="<?= esc_attr($section_id); ?>-container">
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
</section>

<?php wp_reset_postdata(); ?>
