<?php

defined('ABSPATH') || exit;

/**
 * Секция «Кейсы» (CPT case + таксономия case_cat).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('cases')
 * (таб «Дефолты блоков → Секции лендинга → Кейсы»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('cases') : [];

$defaults = [
    'badge'        => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'all_text'     => $admin['all_text'] ?? '',
    'all_url'      => $admin['all_url'] ?? '',
    'foot_text'    => $admin['foot_text'] ?? '',
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_url'      => $admin['btn_url'] ?? '',
    'post_ids'     => is_array($admin['post_ids'] ?? null) ? $admin['post_ids'] : [],
];

$overrides = get_query_var('cases_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$post_ids = array_values(array_filter(array_map('intval', (array) $data['post_ids'])));

$section_id = isset($args['section_id']) ? $args['section_id'] : 'cases_' . wp_unique_id();
$taxonomy   = 'case_cat';
$post_type  = 'case';
$posts_per_page = !empty($post_ids) ? -1 : 6;

theme_enqueue_cases_section_assets();

$all_categories = get_terms([
    'taxonomy'   => $taxonomy,
    'hide_empty' => true,
]);

$section_query = new WP_Query(theme_get_cases_query_args([
    'category'       => '',
    'taxonomy'       => $taxonomy,
    'post_type'      => $post_type,
    'posts_per_page' => $posts_per_page,
    'post_ids'       => $post_ids,
]));

if (!$section_query->have_posts() && trim((string) $data['title']) === '') {
    return;
}

$all_url = (string) $data['all_url'];
$btn_url = (string) $data['btn_url'];
?>
<section class="cases load-on-vissible--js"
  data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
  data-post-type="<?php echo esc_attr($post_type); ?>"
  data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>"
  data-post-ids="<?php echo esc_attr(implode(',', $post_ids)); ?>">
  <div class="container">
    <div class="cases__top section-top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="cases__badge section-subtitle"><?= $data['badge']; ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="cases__title"><?= $data['title']; ?></h2>
      <?php endif; ?>
    </div>

    <?php if (($all_categories && !is_wp_error($all_categories)) || $all_url !== '') : ?>
      <div class="cases__filter">
        <ul class="cases__tabs">
          <li><button class="cases__tab active" type="button" data-filter="">Все кейсы</button></li>

          <?php if ($all_categories && !is_wp_error($all_categories)) : ?>
            <?php foreach ($all_categories as $cat) : ?>
              <li>
                <button class="cases__tab" type="button" data-filter="<?= esc_attr($cat->slug); ?>">
                  <?= esc_html($cat->name); ?>
                </button>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>

        <?php if ($all_url !== '' && trim((string) $data['all_text']) !== '') : ?>
          <a class="cases__all" href="<?= esc_url($all_url); ?>">
            <span><?= $data['all_text']; ?></span>
            <svg class="cases__all-arrow" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 12h16M14 6l6 6-6 6"/>
            </svg>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="fade-in-container cases__splide splide load-on-vissible--js"
      aria-label="<?= esc_attr(wp_strip_all_tags($data['title'])); ?>"
      data-module="./libs/splide.min.js,./modules/casesSplideInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="<?= esc_attr($section_id); ?>-container">
      <div class="splide__track">
        <div class="cases__splide-list splide__list">
          <?php while ($section_query->have_posts()) : $section_query->the_post(); ?>
            <?php get_template_part('pages/sections/partials/case-card'); ?>
          <?php endwhile; ?>
        </div>
      </div>

      <div class="splide__bottom">
        <div class="splide__pagination"></div>
      </div>
    </div>

    <?php if (trim((string) $data['foot_text']) !== '' || trim((string) $data['btn_text']) !== '') : ?>
      <div class="cases__foot">
        <?php if (trim((string) $data['foot_text']) !== '') : ?>
          <p class="cases__foot-text"><?= $data['foot_text']; ?></p>
        <?php endif; ?>

        <?php if (trim((string) $data['btn_text']) !== '') : ?>
          <a class="cases__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
            <span><?= $data['btn_text']; ?></span>
            <svg class="cases__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 12h16M14 6l6 6-6 6"/>
            </svg>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php wp_reset_postdata(); ?>