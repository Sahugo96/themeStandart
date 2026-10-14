<?php
/**
 * Секция рекомендуемых услуг для single-записей.
 *
 * Использование:
 * get_template_part('pages/sections/service-section-related', null, [
 *   'title' => 'Рекомендуем так же ознакомиться',
 *   'items_field' => 'blog_services',
 *   'section_id' => 'related_services',
 *   'post_type' => 'service',
 *   'posts_per_page' => 1,
 * ]);
 */

$title = isset($args['title']) ? $args['title'] : 'Рекомендуем так же ознакомиться';
$items_field = isset($args['items_field']) ? $args['items_field'] : 'blog_services';
$items = get_field($items_field);
$post_type = isset($args['post_type']) ? $args['post_type'] : 'service';
$posts_per_page = isset($args['posts_per_page']) ? $args['posts_per_page'] : 1;
$section_id = isset($args['section_id']) ? $args['section_id'] : 'related_services_' . uniqid();

$args_query = [
  'post_type'      => $post_type,
  'posts_per_page' => $posts_per_page,
  'paged'          => 6,
];

if ($items) {
  $section_query = new WP_Query([
    'post_type'      => 'any',
    'post__in'       => wp_list_pluck($items, 'ID'),
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
  ]);
} else {
  $section_query = new WP_Query($args_query);
}

if (!$section_query->have_posts()) {
  return;
}
?>

<section class="service-section section">
  <div class="container">
    <div class="section-top">
      <h2 class="service-section__title h2"><?= esc_html($title); ?></h2>
    </div>

    <div class="fade-in-container service-section__splide splide load-on-vissible--js"
      aria-label="Splide direction"
      data-module="./libs/splide.min.js,./modules/serviceSectionSplideInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="<?php echo esc_attr($section_id); ?>-container">
      <div class="splide__track">
        <div class="service-section__splide-list splide__list">
          <?php while ($section_query->have_posts()) : $section_query->the_post(); ?>
            <?php get_template_part('pages/sections/partials/service-card'); ?>
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
