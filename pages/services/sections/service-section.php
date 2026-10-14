<?php
$service_section_data = get_query_var('service_section_data');
$section = get_query_var('section');

if (is_array($service_section_data) && !empty($service_section_data)) {
  $title = $service_section_data['title'] ?? '';
  $text = $service_section_data['text'] ?? '';
} elseif ($section && $section !== true && is_array($section) && !empty($section['service_section_rewrite'])) {
  $title = $section['service_section_title'];
  $text = $section['service_section_text'];
} else {
  $title = get_field('service_section_title', OPTION_ID);
  $text = get_field('service_section_text', OPTION_ID);
}


/**
 * Section template for Services archive with taxonomy links

 * Использование: get_template_part('pages/services/sections/service-section', null, ['section_id' => 'unique_id', 'taxonomy' => 'service_cat', 'post_type' => 'service'])
 */


$section_id = isset($args['section_id']) ? $args['section_id'] : 'services_' . uniqid();
$taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : 'service_cat';
$post_type = isset($args['post_type']) ? $args['post_type'] : 'service';


$all_categories = get_terms([
  'taxonomy'   => $taxonomy,
  'hide_empty' => false,
]);

$args_query = [
  'post_type'      => $post_type,
  'posts_per_page' => -1,
  'paged'          => 1,
];


$current_term = null;
if (!empty($args['term']) && $args['term'] instanceof WP_Term) {
  $current_term = $args['term'];
} elseif (is_tax($taxonomy)) {
  $queried_object = get_queried_object();
  if ($queried_object instanceof WP_Term && $queried_object->taxonomy === $taxonomy) {
    $current_term = $queried_object;
  }
}

if ($current_term) {
  $args_query['tax_query'] = [
    [
      'taxonomy' => $taxonomy,
      'field'    => 'term_id',
      'terms'    => $current_term->term_id,
    ],
  ];
}

$section_query = new WP_Query($args_query);
$selected_category = $current_term ? $current_term->slug : '';
$posts_count = (int) $section_query->post_count;
$toggle_id = $section_id . '_toggle';
?>

<section class="service-section service-section--archive section load-on-vissible--js">
  <div class="container">
    <div class="service-section__top section-top">
      <h2 class="service-section__title h2"><?= $title; ?></h2>

      <?php if ($text) { ?>
        <p class="service-section__text paragraph-15-15"><?= $text; ?></p>
      <?php } ?>
    </div>

    <?php
    if ($all_categories && !is_wp_error($all_categories)) :
      $categories_with_posts = array_filter($all_categories, static function ($cat) {
        return $cat->count > 0;
      });
      if (!empty($categories_with_posts)) :
    ?>

        <div class="service-section__filter filter">
          <div class="filter__form">
            <a href="<?php echo esc_url(get_post_type_archive_link($post_type)); ?>" class="filter__link <?php echo !is_tax($taxonomy) ? 'active' : ''; ?>">
              <span class="filter__label">Все услуги</span>
            </a>

            <?php foreach ($categories_with_posts as $cat) : ?>
              <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="filter__link <?php echo (is_tax($taxonomy) && get_queried_object()->slug === $cat->slug) ? 'active' : ''; ?>">
                <span class="filter__label"><?php echo esc_html($cat->name); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php
      endif;
    endif;

    if ($section_query->have_posts()) :
      ?>

      <input type="checkbox" class="service-section__toggle" id="<?= esc_attr($toggle_id); ?>" hidden>

      <div class="fade-in-container service-section__grid">
        <?php while ($section_query->have_posts()) : $section_query->the_post(); ?>
          <?php get_template_part('pages/sections/partials/service-card', null, [
            'taxonomy'          => $taxonomy,
            'selected_category' => $selected_category,
          ]); ?>
        <?php endwhile; ?>
      </div>

      <?php if ($posts_count > 6) { ?>
        <label class="service-section__more more-btn" for="<?= esc_attr($toggle_id); ?>">
          Показать еще

          <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.25 6.25L7.94194 9.55806C7.69786 9.80214 7.30214 9.80214 7.05806 9.55806L3.75 6.25" stroke-linecap="round" />
          </svg>
        </label>
      <?php } ?>
    <?php
      wp_reset_postdata();
    endif;
    ?>
  </div>
</section>