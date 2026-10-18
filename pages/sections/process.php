<?php

defined('ABSPATH') || exit;

/**
 * Секция «Как проходит работа» (process).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('process')
 * (таб «Дефолты блоков → Как проходит работа»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('process') : [];

$defaults = [
    'badge'        => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'image'        => $admin['image'] ?? 0,
    'items'        => is_array($admin['items'] ?? null) ? $admin['items'] : [],
];

$overrides = get_query_var('process_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? array_values($data['items']) : [];

if (empty($items)) {
    return;
}

$image = tolstenko_contact_get_image_attrs($data['image'] ?? null);

if (empty($image['url'])) {
    $image = ['url' => THEME_PATH . '/assets/img/process.jpg', 'srcset' => '', 'sizes' => '', 'alt' => 'Координатор Relocate-World'];
}
?>
<section class="process section load-on-vissible--js" data-module="./modules/processAccordioninit.js">
  <div class="container">
    <div class="process__top section-top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="process__badge section-subtitle"><?= $data['badge']; ?></span>
      <?php endif; ?>
      <h2 class="process__title section-title"><?= $data['title']; ?></h2>
    </div>

    <div class="process__card br-30">
      <div class="process__image br-30">
        <img src="<?= $image['url']; ?>" <?php if ($image['srcset']) echo 'srcset="' . $image['srcset'] . '"'; ?> alt="<?= $image['alt']; ?>" loading="lazy">
      </div>

      <div class="process__steps" data-accordion>

        <?php foreach ($items as $index => $step) : ?>
          <div class="process__item<?= $index === 0 ? ' active' : ''; ?>" data-accordion-item>
            <button class="process__item-top" type="button" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>" data-accordion-btn>
              <span class="process__item-num h4"><?= $index + 1; ?></span>
              <span class="process__item-title h4"><?= $step['title'] ?? ''; ?></span>
              <svg class="process__item-plus" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M10 3v14M3 10h14"/>
              </svg>
            </button>
            <div class="process__item-body">
              <div class="process__item-inner reg-par-14-20">
                <?= $step['text'] ?? ''; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</section>
