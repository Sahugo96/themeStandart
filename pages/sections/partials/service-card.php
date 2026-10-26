<?php
/**
 * Карточка услуги для секции service-section.
 *
 * @var array $args {
 *   @type string $selected_category Slug категории для приоритетного отображения тега.
 *   @type string $taxonomy          Таксономия тегов. По умолчанию service_cat.
 * }
 */

$post_id = get_the_ID();
$taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : 'service_cat';
$selected_category = isset($args['selected_category'])
  ? $args['selected_category']
  : (isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '');
?>

<article class="service-section__item service-card fade-in-element splide__slide">
  <?php if (has_post_thumbnail()) : ?>
    <a class="service-card__image" href="<?= get_permalink(); ?>">
      <?= get_the_post_thumbnail($post_id); ?>

      <?php
      $tags = get_the_terms($post_id, $taxonomy);

      if ($tags && !is_wp_error($tags)) :
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
        } elseif ($taxonomy === 'service_cat' && function_exists('theme_get_primary_term')) {
          // Без фильтра в метке — основная категория (правая колонка редактора).
          $primary_term = theme_get_primary_term($post_id, $taxonomy);
          if ($primary_term) {
            $tags = [$primary_term];
          }
        }

        $tags = array_slice($tags, 0, 1);
        foreach ($tags as $tag) : ?>
          <span class="service-card__tag caption-8-10">
            <?= esc_html($tag->name); ?>
          </span>
      <?php endforeach;
      endif; ?>

      <span class="service-card__hit caption-8-10">
        хит

        <?php if (theme_get_field('single_service_hit', $post_id) && theme_get_field('single_service_action', $post_id)) : ?>
          <span><?= theme_get_field('single_service_action', $post_id); ?>%</span>
        <?php endif; ?>
      </span>
    </a>
  <?php endif; ?>

  <div class="service-card__wrapper">
    <a class="service-card__title paragraph-15-15" href="<?= get_permalink(); ?>"><?= get_the_title(); ?></a>

    <div class="service-card__text line-13-15"><?= theme_get_field('single_service_description', $post_id); ?></div>

    <div class="service-card__cost line-13-15">
      Цена от <?= theme_get_field('single_service_same_cost', $post_id); ?>₽
      <?php if (theme_get_field('single_service_cost', $post_id)) : ?>
        <span><?= theme_get_field('single_service_cost', $post_id); ?>₽</span>
      <?php endif; ?>
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
