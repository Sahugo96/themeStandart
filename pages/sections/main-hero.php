<?php

defined('ABSPATH') || exit;

/**
 * Секция «Главный баннер» (main-hero).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('main_hero')
 * (таб «Дефолты блоков → Секции лендинга → Главный баннер»).
 * Блок my-theme/main-hero передаёт свои значения через query var main_hero_data,
 * они имеют приоритет. Без блока на странице секция выводится по дефолтам.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('main_hero') : [];

$defaults = [
    'badge'            => $admin['badge'] ?? '',
    'title'            => $admin['title'] ?? '',
    'title_tag'        => $admin['title_tag'] ?? 'h1',
    'text'             => $admin['text'] ?? '',
    'items'            => is_array($admin['items'] ?? null) ? $admin['items'] : [],
    'btn_text'         => $admin['btn_text'] ?? '',
    'btn_subtext'      => $admin['btn_subtext'] ?? '',
    'show_promo'       => !empty($admin['show_promo']),
    'promo_text'       => $admin['promo_text'] ?? '',
    'present_image_id' => (int) ($admin['present_image'] ?? 0),
    'person_name'      => $admin['person_name'] ?? '',
    'person_position'  => $admin['person_position'] ?? '',
    'image_id'         => (int) ($admin['image'] ?? 0),
];

$overrides = get_query_var('main_hero_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$title_tag = in_array($data['title_tag'], ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], true) ? $data['title_tag'] : 'h1';

$items = [];
foreach ((array) $data['items'] as $item) {
    $item = is_object($item) ? (array) $item : $item;

    if (!is_array($item)) {
        continue;
    }

    $item_title = trim((string) ($item['title'] ?? ''));
    $item_text  = trim((string) ($item['text'] ?? ''));

    if ($item_title !== '' || $item_text !== '') {
        $items[] = ['title' => $item_title, 'text' => $item_text];
    }
}

$show_promo   = !empty($data['show_promo']) && trim((string) $data['promo_text']) !== '';
$present_url  = $data['present_image_id'] ? (string) wp_get_attachment_image_url((int) $data['present_image_id'], 'thumbnail') : '';
$present_url  = $present_url !== '' ? $present_url : THEME_PATH . '/assets/img/present.svg';
$has_person   = trim((string) $data['person_name']) !== '' || trim((string) $data['person_position']) !== '';
$image_id     = (int) $data['image_id'];

if (trim((string) $data['title']) === '' && !$image_id) {
    return;
}
?>
<section class="main-hero section">
  <div class="main-hero__box br-30">
    <div class="main-hero__inner<?= $image_id ? ' main-hero__inner--media' : ''; ?>">
      <div class="main-hero__head">
        <?php if (trim((string) $data['badge']) !== '') : ?>
          <span class="main-hero__badge section-subtitle"><?= wp_kses_post($data['badge']); ?></span>
        <?php endif; ?>

        <?php if (trim((string) $data['title']) !== '') : ?>
          <<?= $title_tag; ?> class="main-hero__title"><?= wp_kses_post($data['title']); ?></<?= $title_tag; ?>>
        <?php endif; ?>
      </div>

      <div class="main-hero__content">
        <?php if (trim((string) $data['text']) !== '') : ?>
          <div class="main-hero__text"><?= theme_section_text_html(wp_kses_post($data['text'])); ?></div>
        <?php endif; ?>

        <?php if ($items) : ?>
          <ul class="main-hero__list">
            <?php foreach ($items as $item) : ?>
              <li class="main-hero__item">
                <span class="main-hero__item-icon" aria-hidden="true">
                  <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </span>
                <p class="main-hero__item-text">
                  <?php if ($item['title'] !== '') : ?>
                    <span class="main-hero__item-accent"><?= wp_kses_post($item['title']); ?></span>
                  <?php endif; ?>
                  <?= wp_kses_post($item['text']); ?>
                </p>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php if (trim((string) $data['btn_text']) !== '') : ?>
          <div class="main-hero__bottom<?= $show_promo ? ' main-hero__bottom--promo' : ''; ?>">
            <a class="main-hero__btn" href="#modal">
              <span class="main-hero__btn-body">
                <span class="main-hero__btn-title"><?= esc_html($data['btn_text']); ?></span>
                <?php if (trim((string) $data['btn_subtext']) !== '') : ?>
                  <span class="main-hero__btn-subtitle"><?= esc_html($data['btn_subtext']); ?></span>
                <?php endif; ?>
              </span>
              <span class="main-hero__btn-arrow" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </span>
            </a>

            <?php if ($show_promo) : ?>
              <div class="main-hero__promo">
                <span class="main-hero__promo-text"><?= wp_kses_post($data['promo_text']); ?></span>
                <img class="main-hero__promo-icon" src="<?= esc_url($present_url); ?>" alt="" loading="lazy">
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($image_id) : ?>
        <div class="main-hero__media">
          <div class="main-hero__frame">
            <?= wp_get_attachment_image($image_id, 'large', false, ['class' => 'main-hero__img', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>
          </div>

          <?php if ($has_person) : ?>
            <div class="main-hero__person">
              <span class="main-hero__person-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M12 3.5l2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.9l-5.2 2.7 1-5.8-4.3-4.1 5.9-.9z"/></svg>
              </span>
              <span class="main-hero__person-body">
                <?php if (trim((string) $data['person_name']) !== '') : ?>
                  <span class="main-hero__person-name"><?= esc_html($data['person_name']); ?></span>
                <?php endif; ?>
                <?php if (trim((string) $data['person_position']) !== '') : ?>
                  <span class="main-hero__person-position"><?= esc_html($data['person_position']); ?></span>
                <?php endif; ?>
              </span>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
