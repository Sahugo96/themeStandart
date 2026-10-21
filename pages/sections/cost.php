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
    'lead'         => $admin['lead'] ?? '',
    'prices'       => is_array($admin['prices'] ?? null) ? $admin['prices'] : [],
    'card_title'   => $admin['card_title'] ?? '',
    'card_text'    => $admin['card_text'] ?? '',
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_link'     => ['url' => $admin['btn_url'] ?? '', 'title' => $admin['btn_text'] ?? '', 'target' => ''],
    'image'        => $admin['image'] ?? 0,
    'links'        => is_array($admin['links'] ?? null) ? $admin['links'] : [],
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

$btn_url = $data['btn_url'] ?? '';
$btn_url = $btn_url !== '' ? $btn_url : (isset($data['btn_link']['url']) ? $data['btn_link']['url'] : '');

$links = is_array($data['links'] ?? null) ? $data['links'] : [];
?>
<section class="cost section">
  <div class="container">
    <div class="cost__top section-top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="cost__badge section-subtitle"><?= $data['badge']; ?></span>
      <?php endif; ?>
      <h2 class="cost__title section-title"><?= $data['title']; ?></h2>
      <?php if (trim((string) $data['lead']) !== '') : ?>
        <?php $cost_lead = theme_section_text_html($data['lead'] ?? ''); ?>
        <?php if ($cost_lead !== '') : ?>
          <div class="cost__lead section-text"><?= $cost_lead; ?></div>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <?php if (!empty($prices)) : ?>
      <ul class="cost__prices br-30">
        <?php foreach ($prices as $price) : ?>
          <li class="cost__price br-20">
            <span class="cost__price-name h2-18-20"><?= $price['name'] ?? ''; ?></span>
            <span class="cost__price-value h2-18-20"><?= $price['value'] ?? ''; ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <div class="cost__card  br-30">
      <div class="cost__content">
        <h3 class="cost__card-title h2-18-20"><?= $data['card_title']; ?></h3>
        <p class="cost__card-text lead-16-25"><?= $data['card_text']; ?></p>

        <div class="cost__actions">
          <a class="cost__btn default-btn default-btn--brown" href="<?= esc_url($btn_url !== '' ? $btn_url : '#'); ?>">
            <span><?= $data['btn_text']; ?></span>
            <svg class="cost__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 12h16M14 6l6 6-6 6"/>
            </svg>
          </a>

          <?php if (!empty($links)) : ?>
            <div class="cost__links">
              <?php foreach ($links as $link) :
                $link = is_array($link) ? $link : [];
                $icon_raw = $link['icon_id'] ?? '';

                if (is_array($icon_raw)) {
                    $icon_raw = $icon_raw['id'] ?? ($icon_raw['url'] ?? '');
                }

                $link_title = trim((string) ($link['title'] ?? ''));
                $link_url = trim((string) ($link['link'] ?? ''));

                if ($link_url === '') {
                    continue;
                }

                $svg = function_exists('tolstenko_contact_get_inline_svg') ? tolstenko_contact_get_inline_svg($icon_raw) : '';
                $icon_url = tolstenko_contact_resolve_icon_url($icon_raw);
              ?>
                <a class="cost__round" href="<?= esc_url($link_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc_attr($link_title !== '' ? $link_title : ($data['title'] ?? '')); ?>">
                  <?php if ($svg !== '') : ?>
                    <?= $svg; ?>
                  <?php elseif ($icon_url !== '') : ?>
                    <img src="<?= esc_url($icon_url); ?>" alt="" loading="lazy">
                  <?php else : ?>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/></svg>
                  <?php endif; ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

        </div>
      </div>

      <div class="cost__image br-30">
        <img src="<?= $image['url']; ?>" <?php if ($image['srcset']) echo 'srcset="' . $image['srcset'] . '"'; ?> alt="<?= $image['alt']; ?>" loading="lazy">
      </div>
    </div>
  </div>
</section>
