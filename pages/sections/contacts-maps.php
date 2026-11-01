<?php

defined('ABSPATH') || exit;

/**
 * Секция «Карты» (contacts-maps) — страница с шаблоном «Contacts page».
 * Перенесено из tolstenko.marketing (template-parts/blocks/contacts-maps.php), вид — текущая тема.
 *
 * Дефолты — tolstenko_get_block_defaults('contacts_maps') (таб «Дефолты блоков → Карты»),
 * атрибуты блока my-theme/contacts-maps имеют приоритет. Адреса — вкладки (при одном
 * адресе вкладок нет), под ними карта; iframe — только Яндекс/Google/OSM
 * (theme_contacts_map_embed). Переключение — modules/contactsTabs.js.
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('contacts_maps') : [];

$overrides = get_query_var('contacts_maps_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$badge = trim((string) ($data['badge'] ?? ''));
$title = trim((string) ($data['title'] ?? ''));

$items = [];
foreach (theme_contacts_normalize_maps($data['items'] ?? []) as $item) {
    $embed = theme_contacts_map_embed($item['map']);
    if ($embed !== '') {
        $items[] = ['address' => $item['address'], 'embed' => $embed];
    }
}

if (!$items) {
    return;
}

$uid      = wp_unique_id();
$has_tabs = count($items) > 1;
?>
<section class="contacts-maps section load-on-vissible--js"
  data-contacts-tabs
  data-module="./modules/contactsTabs.js">
  <div class="container">
    <?php if ($badge !== '' || $title !== '') : ?>
      <div class="contacts-maps__top section-top">
        <?php if ($badge !== '') : ?>
          <span class="contacts-maps__badge section-subtitle"><?= esc_html($badge); ?></span>
        <?php endif; ?>
        <?php if ($title !== '') : ?>
          <h2 class="contacts-maps__title section-title"><?= tolstenko_kses_html($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($has_tabs) : ?>
      <div class="contacts-maps__tabs filter filter--tabs">
        <div class="contacts-maps__labels filter__form" role="tablist">
          <?php foreach ($items as $index => $item) : ?>
            <label class="contacts-maps__label filter__link">
              <input type="radio" name="contacts-maps-<?= (int) $uid; ?>" value="<?= (int) $index; ?>" data-tab-index="<?= (int) $index; ?>"<?= $index === 0 ? ' checked' : ''; ?>>
              <span class="filter__label"><?= esc_html($item['address'] !== '' ? $item['address'] : 'Адрес ' . ($index + 1)); ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="contacts-maps__items">
      <?php foreach ($items as $index => $item) : ?>
        <div class="contacts-maps__item br-30" data-tab-panel="<?= (int) $index; ?>"<?= $index === 0 ? '' : ' hidden'; ?>>
          <?= $item['embed']; // Собран в theme_contacts_map_embed(): только проверенный src. ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
