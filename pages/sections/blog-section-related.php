<?php
/**
 * Слайдер похожих статей для single-blog.
 *
 * get_template_part('pages/sections/blog-section-related', null, [
 *   'section_id' => 'related_blog',
 * ]);
 */

$blog_related_data = get_query_var('blog_related_data');

if (is_array($blog_related_data) && $blog_related_data) {
    $title = $blog_related_data['title'] ?? '';
    $post_ids = $blog_related_data['post_ids'] ?? [];
} else {
    $title = isset($args['title']) ? $args['title'] : 'Похожие статьи';
    $post_ids = isset($args['post_ids']) ? (array) $args['post_ids'] : [];
}

$title = $title !== '' ? $title : 'Похожие статьи';
$post_ids = array_values(array_filter(array_map('intval', (array) $post_ids)));
$section_id = isset($args['section_id']) ? $args['section_id'] : 'related_blog_' . wp_unique_id();

if (!$post_ids) {
    return;
}

$section_query = new WP_Query([
    'post_type'      => 'blog',
    'post__in'       => $post_ids,
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
]);

if (!$section_query->have_posts()) {
    wp_reset_postdata();
    return;
}
?>

<section class="blog-section blog-section--same section">
  <div class="container">
    <div class="section-top">
      <h2 class="blog-section__title h2"><?= esc_html($title); ?></h2>
    </div>

    <div class="fade-in-container blog-section__splide splide load-on-vissible--js"
      aria-label="Похожие статьи"
      data-module="./libs/splide.min.js,./modules/blogSectionSplideInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="<?= esc_attr($section_id); ?>-container">
      <div class="splide__track">
        <div class="blog-section__splide-list splide__list">
          <?php while ($section_query->have_posts()) : $section_query->the_post(); ?>
            <?php get_template_part('pages/sections/partials/blog-card-slide', null, ['modifier' => 'same']); ?>
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
