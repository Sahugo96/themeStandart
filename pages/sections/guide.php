<?php

defined('ABSPATH') || exit;

/**
 * Секция «Подробнее» (статья-гид).
 *
 * Шапка и подпись кнопки — из админки tolstenko_get_block_defaults('guide')
 * (таб «Секции лендинга → Подробнее»), перекрываются атрибутами блока.
 * Карточка целиком собирается из выбранной статьи (post_id, «Выбор одной записи»):
 * рубрики, время чтения, просмотры, дата, заголовок, текст карточки и миниатюра.
 * Статья не выбрана — берётся последняя опубликованная; статей нет — секция не выводится.
 */

$defaults = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('guide')
    : [];

$overrides = get_query_var('guide_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$guide_post = null;
$post_id = (int) ($data['post_id'] ?? 0);

if ($post_id > 0) {
    $guide_post = get_post($post_id);
    if (!$guide_post || $guide_post->post_type !== 'blog' || $guide_post->post_status !== 'publish') {
        $guide_post = null;
    }
}

if (!$guide_post) {
    $latest = get_posts([
        'post_type'           => 'blog',
        'post_status'         => 'publish',
        'posts_per_page'      => 1,
        'ignore_sticky_posts' => true,
    ]);
    $guide_post = $latest[0] ?? null;
}

if (!$guide_post) {
    return;
}

$post_id = (int) $guide_post->ID;

// Рубрики — как в карточках статей (не больше двух).
$tags = get_the_terms($post_id, 'blog_cat');
$tags = $tags && !is_wp_error($tags) ? array_slice($tags, 0, 2) : [];

$reading_time = function_exists('theme_get_reading_time_text') ? theme_get_reading_time_text($post_id) : '';
$views = function_exists('pvc_get_post_views') ? (int) pvc_get_post_views($post_id) : 0;

// Текст: «Текст на карточке» из метабокса → отрывок → начало записи.
$text = function_exists('theme_get_blog_card_text') ? theme_get_blog_card_text($post_id) : '';
if ($text === '' && has_excerpt($guide_post)) {
    $text = get_the_excerpt($guide_post);
}
if ($text === '') {
    $text = wp_trim_words(wp_strip_all_tags(strip_shortcodes($guide_post->post_content)), 55, '…');
}

$thumb_id = (int) get_post_thumbnail_id($post_id);
$image = $thumb_id ? tolstenko_contact_get_image_attrs($thumb_id) : [];

$card_title = get_the_title($guide_post);
$btn_text = trim((string) ($data['btn_text'] ?? ''));
$link = (string) get_permalink($guide_post);
?>
<section class="guide section">
  <div class="container">
    <div class="guide__top section-top">
      <?php if (trim((string) ($data['subtitle'] ?? '')) !== '') : ?>
        <span class="guide__badge section-subtitle"><?= $data['subtitle']; ?></span>
      <?php endif; ?>

      <?php if (trim((string) ($data['title'] ?? '')) !== '') : ?>
        <h2 class="guide__title section-title"><?= $data['title']; ?></h2>
      <?php endif; ?>
    </div>

    <article class="guide__card<?= empty($image['url']) ? ' guide__card--no-image' : ''; ?> br-30">
      <div class="guide__content">
        <div class="guide__meta">
          <?php if (!empty($tags)) : ?>
            <ul class="guide__tags">
              <?php foreach ($tags as $tag) : ?>
                <li class="guide__tag"><?= esc_html($tag->name); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <ul class="guide__info">
            <?php if ($reading_time !== '') : ?>
              <li class="guide__info-item">
                <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <circle cx="12" cy="12" r="9"/>
                  <path d="M12 7v5l3 2"/>
                </svg>
                <?= esc_html($reading_time); ?>
              </li>
            <?php endif; ?>
            <?php if ($views > 0) : ?>
              <li class="guide__info-item">
                <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                <?= esc_html(number_format_i18n($views)); ?>
              </li>
            <?php endif; ?>
            <li class="guide__info-item">
              <time datetime="<?= esc_attr(get_the_date('Y-m-d', $guide_post)); ?>"><?= esc_html(get_the_date('j F Y', $guide_post)); ?></time>
              <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="5" width="18" height="16" rx="2"/>
                <path d="M3 10h18M8 3v4M16 3v4"/>
              </svg>
            </li>
          </ul>
        </div>

        <h3 class="guide__card-title"><?= esc_html($card_title); ?></h3>

        <?php if ($text !== '') : ?>
          <div class="guide__text"><?= wpautop(esc_html($text)); ?></div>
        <?php endif; ?>

        <?php if ($btn_text !== '') : ?>
          <a class="guide__btn" href="<?= esc_url($link); ?>">
            <span><?= esc_html($btn_text); ?></span>
            <svg class="guide__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 12h16M14 6l6 6-6 6"/>
            </svg>
          </a>
        <?php endif; ?>
      </div>

      <?php if (!empty($image['url'])) : ?>
        <div class="guide__image br-20">
          <img src="<?= esc_url($image['url']); ?>"<?php if (!empty($image['srcset'])) : ?> srcset="<?= esc_attr($image['srcset']); ?>" sizes="<?= esc_attr($image['sizes'] ?: '(min-width: 992px) 560px, 100vw'); ?>"<?php endif; ?> alt="<?= esc_attr($image['alt'] ?: $card_title); ?>" loading="lazy">
        </div>
      <?php endif; ?>
    </article>
  </div>
</section>
