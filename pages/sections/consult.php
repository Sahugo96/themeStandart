<?php

defined('ABSPATH') || exit;

/**
 * Секция «Бесплатная консультация» (consult).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('consult')
 * (таб «Секции лендинга → Начните с бесплатной консультации»).
 * Атрибуты блока имеют приоритет.
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
    'input_placeholder' => $admin['input_placeholder'] ?? '',
    'btn_text'          => $admin['btn_text'] ?? '',
    'consents'          => is_array($admin['consents'] ?? null) ? $admin['consents'] : [],
    'image'             => $admin['image'] ?? 0,
];

$overrides = get_query_var('consult_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$consents = isset($data['consents']) && is_array($data['consents']) ? $data['consents'] : [];
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

          <form class="consult__form" action="" method="post">
            <div class="consult__field">
              <input class="consult__input" type="text" name="contact" placeholder="<?= esc_attr($data['input_placeholder']); ?>" autocomplete="tel" required>
              <button class="consult__submit" type="submit"><?= esc_html($data['btn_text']); ?></button>
            </div>

            <?php foreach ($consents as $consent_index => $consent) :
                $consent = is_array($consent) ? $consent : [];
            ?>
              <label class="consult__check">
                <input class="consult__check-input" type="checkbox" name="agree_<?= (int) $consent_index; ?>" <?= $consent_index === 0 ? 'checked' : ''; ?> required>
                <span class="consult__check-box"></span>
                <span class="consult__check-text"><?= $consent['text'] ?? ''; ?> <a href="<?= esc_url($consent['link_url'] ?? ''); ?>" target="_blank" rel="noopener"><?= esc_html($consent['link_text'] ?? ''); ?></a></span>
              </label>
            <?php endforeach; ?>
          </form>
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
