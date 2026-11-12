<?php

defined('ABSPATH') || exit;

/**
 * Секция «Бесплатная консультация» (consult).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('consult')
 * (таб «Секции лендинга → Начните с бесплатной консультации»).
 * Атрибуты блока имеют приоритет. Форма — CF7 из поля «Шорткод формы» таба
 * (по умолчанию «Бесплатная консультация», d0819d8), оформление — светлый .form--dark.
 */

$admin = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('consult')
    : [];

$defaults = [
    'subtitle'          => $admin['badge'] ?? '',
    'title'             => isset($admin['title']) ? tolstenko_landing_text($admin['title']) : '',
    'text'              => $admin['text'] ?? '',
    'contact_label'     => $admin['contact_label'] ?? '',
    'phone'             => $admin['phone'] ?? '',
    'form_shortcode'    => $admin['form_shortcode'] ?? '',
    'image'             => $admin['image'] ?? 0,
];

$overrides = get_query_var('consult_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

// Форма — CF7 из таба (поля, кнопка и согласия задаются в самой форме).
$form_shortcode = trim((string) ($data['form_shortcode'] ?? ''));
$form_html      = $form_shortcode !== '' ? trim((string) do_shortcode($form_shortcode)) : '';
$phone = trim((string) ($data['phone'] ?? ''));
$phone_href = preg_replace('/[^0-9+]/', '', $phone);
$image = tolstenko_contact_get_image_attrs($data['image'] ?? null);

$text = theme_section_text_html($data['text'] ?? '');
?>
<section class="consult section">
  <div class="consult__wrapper br-30">
    <div class="container">
      <div class="consult__inner<?= $image['url'] === '' ? ' consult__inner--no-image' : ''; ?>">
        <div class="consult__content">
          <?php if (trim((string) $data['subtitle']) !== '') : ?>
            <span class="consult__badge section-subtitle"><?= $data['subtitle']; ?></span>
          <?php endif; ?>

          <?php if (trim((string) $data['title']) !== '') : ?>
            <h2 class="consult__title section-title"><?= $data['title']; ?></h2>
          <?php endif; ?>

          <?php if ($text !== '' || $phone !== '') : ?>
            <div class="consult__text">
              <?= $text; ?>
              <?php if ($phone !== '') : ?>
                <p><?= esc_html($data['contact_label']); ?> <a href="tel:<?= esc_attr($phone_href); ?>"><?= esc_html($phone); ?></a></p>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <?php if ($form_html !== '') : ?>
            <div class="consult__form form form--dark">
              <?= $form_html; ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ($image['url'] !== '') : ?>
          <div class="consult__image br-30">
            <img src="<?= esc_url($image['url']); ?>" <?php if ($image['srcset']) echo 'srcset="' . esc_attr($image['srcset']) . '"'; ?> alt="<?= esc_attr($image['alt']); ?>" loading="lazy">
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
