<?php

defined('ABSPATH') || exit;

/**
 * Карточка услуги для секции «Услуги» (pages/sections/services-slider.php и AJAX-фильтр).
 *
 * Мета-поля записи (inc/service-metabox.php): service_card_title, service_card_text,
 * service_card_price, service_card_consult_url. Изображение — миниатюра записи,
 * метка — первая рубрика service_cat.
 */

$service_id = get_the_ID();
$card       = theme_get_service_card_data($service_id);
$terms      = get_the_terms($service_id, 'service_cat');
$tag        = ($terms && !is_wp_error($terms)) ? (string) $terms[0]->name : '';
$link       = (string) get_permalink($service_id);
?>
<article class="services__card splide__slide">
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
      <p class="services__card-price">от <span><?= esc_html($card['price']); ?></span></p>
    <?php endif; ?>

    <div class="services__card-actions">
      <a class="services__card-btn services__card-btn--more" href="<?= esc_url($link); ?>">Подробнее</a>
      <a class="services__card-btn services__card-btn--consult" href="<?= esc_url($card['consult_url']); ?>">Консультация</a>
    </div>
  </div>
</article>
