<?php

defined('ABSPATH') || exit;

/**
 * Секция «Цифры под hero» (hero-stats).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('hero_stats')
 * (таб «Дефолты блоков → Цифры под hero»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('hero_stats') : [];

$defaults = [
    'items' => is_array($admin['items'] ?? null) ? $admin['items'] : [],
];

$overrides = get_query_var('hero_stats_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? $data['items'] : [];

if (empty($items)) {
    return;
}
?>
<section class="hero-stats">
  <div class="container">
    <ul class="hero-stats__list">
      <?php foreach ($items as $item) : ?>
        <li class="hero-stats__item">
          <span class="hero-stats__num"><?= $item['num'] ?? ''; ?></span>
          <span class="hero-stats__label"><?= $item['label'] ?? ''; ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
