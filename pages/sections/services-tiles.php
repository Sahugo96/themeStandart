<?php

defined('ABSPATH') || exit;

/**
 * Секция «Плитка услуг» — все услуги карточками по 3 в ряд с переносом.
 * Выводит блок my-theme/service-section («Плитка услуг», шаблон страницы «Archive service»,
 * он же — на страницах рубрик service_cat).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('services_tiles')
 * (таб «Дефолты блоков → Слайдера записей → Плитка услуг»), атрибуты блока имеют приоритет.
 *
 * Карточка — та же, что в «Слайдере услуг» (services services--slider):
 * pages/sections/partials/services-card.php. Табы рубрик — ссылки на страницы рубрик
 * (.filter--tabs), активный — текущая рубрика. Внизу — пагинация,
 * THEME_SERVICE_ARCHIVE_PER_PAGE (30) услуг на странице. В архиве услуг и рубриках —
 * основной запрос (рубрика, номер страницы), на других страницах — свой запрос.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('services_tiles') : [];

$defaults = [
    'subtitle'      => $admin['subtitle'] ?? '',
    'title'         => $admin['title'] ?? '',
    'text'          => $admin['text'] ?? '',
    'show_filter'   => !empty($admin['show_filter']),
    'all_label'     => $admin['all_label'] ?? '',
    'card_more'     => $admin['card_more'] ?? '',
    'card_consult'  => $admin['card_consult'] ?? '',
    'card_price'    => $admin['card_price'] ?? '',
];

$overrides = get_query_var('services_tiles_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$taxonomy  = 'service_cat';
$post_type = 'service';

$subtitle      = trim((string) $data['subtitle']);
$title         = trim((string) $data['title']);
$text          = trim((string) $data['text']);

global $wp_query;

$current_term = is_tax($taxonomy) ? get_queried_object() : null;
$current_term = $current_term instanceof WP_Term ? $current_term : null;
$is_archive   = (is_post_type_archive($post_type) || $current_term) && $wp_query instanceof WP_Query;
$paged        = theme_get_service_paged();

$section_query = $is_archive ? $wp_query : new WP_Query([
    'post_type'      => $post_type,
    'post_status'    => 'publish',
    'posts_per_page' => THEME_SERVICE_ARCHIVE_PER_PAGE,
    'paged'          => $paged,
]);

if (!$section_query->have_posts() && $title === '' && $text === '') {
    return;
}

$categories = [];

if (!empty($data['show_filter'])) {
    $categories = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => true,
    ]);
    $categories = ($categories && !is_wp_error($categories)) ? $categories : [];
}

$archive_link = get_post_type_archive_link($post_type);

$card_args = [
    'class'        => 'services__tile',
    'more_text'    => (string) $data['card_more'],
    'consult_text' => (string) $data['card_consult'],
    'price_prefix' => (string) $data['card_price'],
];
?>
<section class="services services--tiles section">
  <div class="container">
    <?php if ($subtitle !== '' || $title !== '' || $text !== '') : ?>
      <div class="services__top section-top">
        <?php if ($subtitle !== '') : ?>
          <span class="services__badge section-subtitle"><?= wp_kses_post($subtitle); ?></span>
        <?php endif; ?>

        <?php if ($title !== '') : ?>
          <h2 class="services__title section-title"><?= wp_kses_post($title); ?></h2>
        <?php endif; ?>

        <?php if ($text !== '') : ?>
          <div class="services__text section-text"><?= theme_section_text_html(wp_kses_post($text)); ?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (count($categories) > 1) : ?>
      <nav class="services__filter filter filter--tabs filter--dark">
        <div class="filter__form">
          <?php if ($archive_link) : ?>
            <a class="filter__link<?= $current_term ? '' : ' active'; ?>" href="<?= esc_url($archive_link); ?>">
              <span class="filter__label"><?= esc_html((string) $data['all_label']); ?></span>
            </a>
          <?php endif; ?>

          <?php foreach ($categories as $cat) : ?>
            <?php $cat_link = get_term_link($cat); ?>
            <?php if (is_wp_error($cat_link)) { continue; } ?>
            <a class="filter__link<?= $current_term && $current_term->term_id === $cat->term_id ? ' active' : ''; ?>" href="<?= esc_url($cat_link); ?>">
              <span class="filter__label"><?= esc_html($cat->name); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </nav>
    <?php endif; ?>

    <?php if ($section_query->have_posts()) : ?>
      <div class="services__tiles">
        <?php
        while ($section_query->have_posts()) :
            $section_query->the_post();
            get_template_part('pages/sections/partials/services-card', null, $card_args);
        endwhile;
        ?>
      </div>

      <?= theme_render_service_pagination((int) $section_query->max_num_pages, $paged); ?>
    <?php endif; ?>
    <?php
    if ($is_archive) {
        rewind_posts();
    } else {
        wp_reset_postdata();
    }
    ?>
  </div>
</section>
