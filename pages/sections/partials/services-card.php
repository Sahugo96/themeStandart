<?php

defined('ABSPATH') || exit;

/**
 * Карточка услуги для секции «Услуги» (pages/sections/services-slider.php и AJAX-фильтр).
 *
 * Мета-поля записи (inc/service-metabox.php): service_card_title, service_card_text,
 * service_card_price, service_card_consult_url. Изображение — миниатюра записи,
 * метка — основная рубрика service_cat (правая колонка редактора, inc/primary-term-metabox.php).
 *
 * Используется и в «Плитке услуг» (pages/sections/services-tiles.php), $args:
 *   class        — класс вместо splide__slide;
 *   more_text, consult_text, price_prefix — подписи (по умолчанию «Подробнее», «Консультация», «от»).
 */

$args = isset($args) && is_array($args) ? $args : [];

$card_class   = trim((string) ($args['class'] ?? '')) ?: 'splide__slide';
$more_text    = trim((string) ($args['more_text'] ?? '')) ?: 'Подробнее';
$consult_text = trim((string) ($args['consult_text'] ?? '')) ?: 'Консультация';
$price_prefix = trim((string) ($args['price_prefix'] ?? '')) ?: 'от';

$service_id = get_the_ID();
$card       = theme_get_service_card_data($service_id);
$term       = function_exists('theme_get_primary_term') ? theme_get_primary_term($service_id, 'service_cat') : null;
$tag        = $term instanceof WP_Term ? (string) $term->name : '';
$link       = (string) get_permalink($service_id);
?>
<article class="services__card <?= esc_attr($card_class); ?>">
  <a class="services__card-image" href="<?= esc_url($link); ?>" tabindex="-1" aria-hidden="true">
    <?php if (has_post_thumbnail($service_id)) : ?>
      <?= get_the_post_thumbnail($service_id, 'medium_large', ['loading' => 'lazy']); ?>
    <?php endif; ?>

    <?php if ($tag !== '') : ?>
      <span class="services__card-tag"><?= esc_html($tag); ?></span>
    <?php endif; ?>
  </a>

  <div class="services__card-body">
    <h3 class="services__card-title">
      <a href="<?= esc_url($link); ?>"><?= esc_html($card['title']); ?></a>
    </h3>

    <?php if ($card['text'] !== '') : ?>
      <p class="services__card-text"><?= esc_html($card['text']); ?></p>
    <?php endif; ?>

    <?php if ($card['price'] !== '') : ?>
      <p class="services__card-price"><?= esc_html($price_prefix); ?> <span><?= esc_html($card['price']); ?></span></p>
    <?php endif; ?>

    <div class="services__card-actions">
      <a class="services__card-btn services__card-btn--more" href="<?= esc_url($link); ?>"><?= esc_html($more_text); ?></a>
      <a class="services__card-btn services__card-btn--consult" href="<?= esc_url($card['consult_url']); ?>"><?= esc_html($consult_text); ?></a>
    </div>
  </div>
</article>
