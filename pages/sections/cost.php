<?php

defined('ABSPATH') || exit;

/**
 * Секция «Стоимость» (cost).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('cost')
 * (таб «Дефолты блоков → Стоимость»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('cost') : [];

$defaults = [
    'badge'        => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'title_accent' => $admin['title_accent'] ?? '',
    'lead'         => $admin['lead'] ?? '',
    'prices'       => is_array($admin['prices'] ?? null) ? $admin['prices'] : [],
    'card_title'   => $admin['card_title'] ?? '',
    'card_text'    => $admin['card_text'] ?? '',
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_link'     => ['url' => $admin['btn_url'] ?? '', 'title' => $admin['btn_text'] ?? '', 'target' => ''],
    'image'        => $admin['image'] ?? 0,
];

$overrides = get_query_var('cost_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$prices = isset($data['prices']) && is_array($data['prices']) ? array_values($data['prices']) : [];

if (empty($prices) && trim((string) $data['title']) === '') {
    return;
}

$image = tolstenko_contact_get_image_attrs($data['image'] ?? null);

if (empty($image['url'])) {
    $image = ['url' => THEME_PATH . '/assets/img/cost.jpg', 'srcset' => '', 'sizes' => '', 'alt' => 'Расчёт стоимости'];
}

$btn_link = isset($data['btn_link']) && is_array($data['btn_link']) ? $data['btn_link'] : ['url' => '', 'title' => '', 'target' => ''];
$btn_url = $btn_link['url'] ?? '';

$cd = tolstenko_get_contact_data();
$cd_whatsapp = trim((string) ($cd['whatsapp'] ?? ''));
$cd_telegram = trim((string) ($cd['telegram'] ?? ''));
$cd_phone_href = trim((string) ($cd['phone_href'] ?? ''));
?>
<section class="cost section">
  <div class="container">
    <div class="cost__top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="cost__badge"><?= $data['badge']; ?></span>
      <?php endif; ?>
      <h2 class="cost__title">
        <span class="cost__title-accent"><?= $data['title_accent']; ?></span>
        <?= $data['title']; ?>
      </h2>
      <?php if (trim((string) $data['lead']) !== '') : ?>
        <p class="cost__lead"><?= $data['lead']; ?></p>
      <?php endif; ?>
    </div>

    <?php if (!empty($prices)) : ?>
      <ul class="cost__prices">
        <?php foreach ($prices as $price) : ?>
          <li class="cost__price">
            <span class="cost__price-name"><?= $price['name'] ?? ''; ?></span>
            <span class="cost__price-value"><?= $price['value'] ?? ''; ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <div class="cost__card">
      <div class="cost__content">
        <h3 class="cost__card-title"><?= $data['card_title']; ?></h3>
        <p class="cost__card-text"><?= $data['card_text']; ?></p>

        <div class="cost__actions">
          <a class="cost__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#'); ?>">
            <span><?= $data['btn_text']; ?></span>
            <svg class="cost__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 12h16M14 6l6 6-6 6"/>
            </svg>
          </a>

          <?php if ($cd_whatsapp !== '') : ?>
            <a class="cost__round" href="<?= esc_url($cd_whatsapp); ?>" aria-label="WhatsApp" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Z"/>
                <path d="M8.8 8.6c.3 2.7 3.9 6 6.6 6.2l1.2-1.4-2.2-1.2-1 .8c-1-.4-2-1.4-2.4-2.4l.8-1-1.2-2.2-1.8 1.2Z"/>
              </svg>
            </a>
          <?php endif; ?>

          <?php if ($cd_telegram !== '') : ?>
            <a class="cost__round" href="<?= esc_url($cd_telegram); ?>" aria-label="Telegram" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M21 4 3 11l5.5 2L10 19l3-3 4.5 3.5L21 4Z"/>
                <path d="m8.5 13 12-8.5"/>
              </svg>
            </a>
          <?php endif; ?>

          <?php if ($cd_phone_href !== '') : ?>
            <a class="cost__round" href="tel:<?= esc_attr($cd_phone_href); ?>" aria-label="Позвонить">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 4h4l1.5 4-2.3 1.5a11 11 0 0 0 5.3 5.3L15 12.5l4 1.5v4a2 2 0 0 1-2 2A14 14 0 0 1 3 6a2 2 0 0 1 2-2Z"/>
              </svg>
            </a>
          <?php endif; ?>
        </div>
      </div>

      <div class="cost__image">
        <img src="<?= $image['url']; ?>" <?php if ($image['srcset']) echo 'srcset="' . $image['srcset'] . '"'; ?> alt="<?= $image['alt']; ?>" loading="lazy">
      </div>
    </div>
  </div>
</section>
