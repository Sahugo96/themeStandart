<?php

defined('ABSPATH') || exit;

/**
 * Карточка статьи для секции «Статьи» (pages/sections/blog-section.php).
 *
 * @var array $args {
 *   @type bool   $large   Первая карточка: на десктопе — крупная (blog-card--large).
 *   @type string $class   Доп. класс карточки (по умолчанию splide__slide — для слайдера).
 *   @type string $heading Тег заголовка (h2 / h3, по умолчанию h3).
 * }
 *
 * Текст карточки и время чтения — метабокс «Карточка статьи» (inc/blog-metabox.php),
 * просмотры — плагин Post Views Counter (модуль stats), метки — рубрики blog_cat.
 */

$post_id  = get_the_ID();
$is_large = !empty($args['large']);
$class    = isset($args['class']) ? (string) $args['class'] : 'splide__slide';
$heading  = ($args['heading'] ?? '') === 'h2' ? 'h2' : 'h3';
$text     = theme_get_blog_card_text($post_id);
$tags     = get_the_terms($post_id, 'blog_cat');
$tags     = ($tags && !is_wp_error($tags)) ? array_slice($tags, 0, 2) : [];
?>
<article class="blog-section__card blog-card<?= $is_large ? ' blog-card--large' : ''; ?><?= $class !== '' ? ' ' . esc_attr($class) : ''; ?>">
  <a class="blog-card__link" href="<?= esc_url(get_permalink()); ?>">
    <?php if (has_post_thumbnail()) : ?>
      <div class="blog-card__image">
        <?= get_the_post_thumbnail($post_id, $is_large ? 'large' : 'medium_large', ['loading' => 'lazy']); ?>
      </div>
    <?php endif; ?>

    <div class="blog-card__wrapper">
      <?php if ($tags) : ?>
        <div class="blog-card__tags">
          <?php foreach ($tags as $tag) : ?>
            <span class="blog-card__tag"><?= esc_html($tag->name); ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <<?= $heading; ?> class="blog-card__title"><?= esc_html(get_the_title()); ?></<?= $heading; ?>>

      <?php if ($text !== '') : ?>
        <p class="blog-card__text"><?= esc_html($text); ?></p>
      <?php endif; ?>

      <div class="blog-card__meta">
        <?php get_template_part('modules/stats/stats', null, ['show_likes' => false]); ?>

        <span class="blog-card__date">
          <time datetime="<?= esc_attr(get_the_date('Y-m-d')); ?>"><?= esc_html(get_the_date('j F Y')); ?></time>
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
        </span>
      </div>
    </div>
  </a>
</article>
