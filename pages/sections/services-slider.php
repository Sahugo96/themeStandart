<?php

defined('ABSPATH') || exit;

/**
 * Секция «Услуги» — слайдер с фильтром по рубрикам (services services--slider).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('service_section_filters')
 * (таб «Дефолты блоков → Слайдера записей → Слайдер услуг (фильтры)»).
 * Атрибуты блока my-theme/services-slider имеют приоритет.
 *
 * Фильтр — универсальные табы .filter--tabs, переключение — AJAX
 * (inc/ajax/services-slider.php, assets/js/modules/servicesSliderFilter.js),
 * по образцу секции «Кейсы».
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('service_section_filters') : [];

$defaults = [
    'subtitle'       => $admin['subtitle'] ?? '',
    'title'          => $admin['title'] ?? '',
    'text'           => $admin['text'] ?? '',
    'posts_per_page' => (int) ($admin['posts_per_page'] ?? 6),
    'ids'            => is_array($admin['ids'] ?? null) ? $admin['ids'] : [],
];

$overrides = get_query_var('services_slider_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$post_ids       = array_values(array_filter(array_map('intval', (array) $data['ids'])));
$posts_per_page = (int) $data['posts_per_page'];
$posts_per_page = $posts_per_page > 0 ? $posts_per_page : THEME_SERVICES_SLIDER_MAX_POSTS;

theme_enqueue_services_slider_section_assets();

// Табы — рубрики service_cat. Если выбраны конкретные услуги — только их рубрики.
$term_args = [
    'taxonomy'   => THEME_SERVICES_SLIDER_TAXONOMY,
    'hide_empty' => true,
];

if ($post_ids) {
    $term_args['object_ids'] = $post_ids;
}

$categories = get_terms($term_args);
$categories = ($categories && !is_wp_error($categories)) ? $categories : [];

// get_terms с object_ids может вернуть рубрику несколько раз.
$unique_categories = [];
foreach ($categories as $cat) {
    $unique_categories[$cat->term_id] = $cat;
}
$categories = array_values($unique_categories);

$section_query = new WP_Query(theme_get_services_slider_section_query_args([
    'category'       => '',
    'posts_per_page' => $posts_per_page,
    'post_ids'       => $post_ids,
]));

if (!$section_query->have_posts()) {
    return;
}

$section_id = 'services_slider_' . wp_unique_id();
?>
<section class="services services--slider section"
  data-posts-per-page="<?= esc_attr($posts_per_page); ?>"
  data-post-ids="<?= esc_attr(implode(',', $post_ids)); ?>">
  <div class="container">
    <div class="services__top section-top">
      <?php if (trim((string) $data['subtitle']) !== '') : ?>
        <span class="services__badge section-subtitle"><?= wp_kses_post($data['subtitle']); ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="services__title section-title"><?= wp_kses_post($data['title']); ?></h2>
      <?php endif; ?>

      <?php if (trim((string) $data['text']) !== '') : ?>
        <div class="services__text section-text"><?= theme_section_text_html(wp_kses_post($data['text'])); ?></div>
      <?php endif; ?>
    </div>

    <?php if (count($categories) > 1) : ?>
      <div class="services__filter filter filter--tabs filter--dark">
        <div class="filter__form">
          <button class="filter__link active" type="button" data-filter="">
            <span class="filter__label">Все решения</span>
          </button>

          <?php foreach ($categories as $cat) : ?>
            <button class="filter__link" type="button" data-filter="<?= esc_attr($cat->slug); ?>">
              <span class="filter__label"><?= esc_html($cat->name); ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="services__slider splide load-on-vissible--js"
      aria-label="<?= esc_attr(wp_strip_all_tags((string) $data['title'])); ?>"
      data-module="./libs/splide.min.js,./modules/servicesSliderInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="<?= esc_attr($section_id); ?>-container">
      <div class="splide__track">
        <div class="services__list splide__list">
          <?php while ($section_query->have_posts()) : $section_query->the_post(); ?>
            <?php get_template_part('pages/sections/partials/services-card'); ?>
          <?php endwhile; ?>
        </div>
      </div>

      <div class="splide__pagination"></div>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
