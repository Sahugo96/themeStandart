<?php

defined('ABSPATH') || exit;

/**
 * Секция «Статьи» (blog-section) — на главной после «ВНЖ в Европе».
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('blog_section_filters')
 * (таб «Дефолты блоков → Слайдера записей → Статьи»). Атрибуты блока
 * my-theme/blog-section имеют приоритет.
 *
 * Все карточки — в одном родителе (.splide__list). На десктопе слайдер
 * отключён и список раскладывается сеткой: первая карточка — blog-card--large,
 * остальные — колонкой справа. На мобильных — слайдер по одной карточке
 * (assets/js/modules/blogSectionSplideInit.js).
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('blog_section_filters') : [];

$defaults = [
    'badge'          => $admin['badge'] ?? '',
    'title'          => $admin['title'] ?? '',
    'ids'            => is_array($admin['ids'] ?? null) ? $admin['ids'] : [],
    'posts_per_page' => (int) ($admin['posts_per_page'] ?? 4),
    'btn_text'       => $admin['btn_text'] ?? '',
];

$overrides = get_query_var('blog_section_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$post_ids       = array_values(array_filter(array_map('intval', (array) $data['ids'])));
$posts_per_page = max(1, min(12, (int) $data['posts_per_page']));

$query_args = [
    'post_type'           => 'blog',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
];

if ($post_ids) {
    $query_args['post__in']       = $post_ids;
    $query_args['orderby']        = 'post__in';
    $query_args['posts_per_page'] = count($post_ids);
} else {
    $query_args['posts_per_page'] = $posts_per_page;
    $query_args['orderby']        = 'date';
    $query_args['order']          = 'DESC';
}

$section_query = new WP_Query($query_args);

if (!$section_query->have_posts()) {
    return;
}

// Кнопка всегда ведёт на страницу блога.
$blog_page_id = function_exists('theme_get_blog_page_id') ? theme_get_blog_page_id() : 0;
$blog_url     = $blog_page_id ? (string) get_permalink($blog_page_id) : (string) get_post_type_archive_link('blog');
$blog_url     = $blog_url !== '' ? $blog_url : home_url('/blog/');
?>
<section class="blog-section blog-section--home section">
  <div class="container">
    <div class="blog-section__top section-top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="blog-section__badge section-subtitle"><?= wp_kses_post($data['badge']); ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="blog-section__title section-title"><?= wp_kses_post($data['title']); ?></h2>
      <?php endif; ?>
    </div>

    <div class="blog-section__panel">
      <div class="blog-section__slider splide load-on-vissible--js"
        aria-label="<?= esc_attr(wp_strip_all_tags((string) $data['title'])); ?>"
        data-module="./libs/splide.min.js,./modules/blogSectionSplideInit.js"
        data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css">
        <div class="splide__track">
          <div class="blog-section__cards splide__list">
            <?php
            $index = 0;

            while ($section_query->have_posts()) {
                $section_query->the_post();
                get_template_part('pages/sections/partials/blog-card-section', null, ['large' => $index === 0]);
                $index++;
            }

            wp_reset_postdata();
            ?>
          </div>
        </div>

        <div class="splide__pagination"></div>
      </div>

      <?php if (trim((string) $data['btn_text']) !== '') : ?>
        <div class="blog-section__foot">
          <a class="blog-section__more" href="<?= esc_url($blog_url); ?>">
            <span><?= esc_html($data['btn_text']); ?></span>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
