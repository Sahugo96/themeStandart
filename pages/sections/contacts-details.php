<?php

defined('ABSPATH') || exit;

/**
 * Секция «Реквизиты» (contacts-details) — страница с шаблоном «Contacts page».
 * Перенесено из tolstenko.marketing (template-parts/blocks/contacts-details.php), вид — текущая тема:
 * слева карточка реквизитов, справа форма (как правая колонка FAQ: .form.form--dark).
 *
 * Дефолты — tolstenko_get_block_defaults('contacts_details') (таб «Дефолты блоков → Реквизиты»),
 * атрибуты блока my-theme/contacts-details имеют приоритет. Форма — шорткод CF7 из таба.
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('contacts_details') : [];

$overrides = get_query_var('contacts_details_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$badge      = trim((string) ($data['badge'] ?? ''));
$title      = trim((string) ($data['title'] ?? ''));
$items      = theme_contacts_normalize_details($data['items'] ?? []);
$form_title = trim((string) ($data['form_title'] ?? ''));
$form_text  = trim((string) ($data['form_text'] ?? ''));
$shortcode  = trim((string) ($data['form_shortcode'] ?? ''));
$form_html  = $shortcode !== '' ? trim((string) do_shortcode($shortcode)) : '';

if (!$items && $form_html === '') {
    return;
}
?>
<section class="contacts-details section">
  <div class="container">
    <?php if ($badge !== '' || $title !== '') : ?>
      <div class="contacts-details__top section-top">
        <?php if ($badge !== '') : ?>
          <span class="contacts-details__badge section-subtitle"><?= esc_html($badge); ?></span>
        <?php endif; ?>
        <?php if ($title !== '') : ?>
          <h2 class="contacts-details__title section-title"><?= tolstenko_kses_html($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="contacts-details__inner<?= $form_html === '' ? ' contacts-details__inner--single' : ''; ?>">
      <?php if ($items) : ?>
        <div class="contacts-details__info br-30">
          <ul class="contacts-details__items">
            <?php foreach ($items as $item) : ?>
              <li class="contacts-details__item redactor"><?= tolstenko_kses_redactor($item['text']); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($form_html !== '') : ?>
        <div class="contacts-details__right br-30">
          <?php if ($form_title !== '' || $form_text !== '') : ?>
            <div class="contacts-details__right-top">
              <?php if ($form_title !== '') : ?>
                <div class="contacts-details__form-title"><?= esc_html($form_title); ?></div>
              <?php endif; ?>
              <?php if ($form_text !== '') : ?>
                <div class="contacts-details__form-text reg-par-14-20"><?= esc_html($form_text); ?></div>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <div class="contacts-details__form form form--dark br-20">
            <?= $form_html; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
