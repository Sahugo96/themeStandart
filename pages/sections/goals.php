<?php

defined('ABSPATH') || exit;

/**
 * Секция «С какой целью нужен ВНЖ» (goals) — на основе «Почему именно мы» (why-us).
 * Шапка слева (надзаголовок с чертой, заголовок, текст), ниже сетка целей 3 × N
 * с линиями между ячейками: иконка + заголовок + текст.
 *
 * Дефолты — tolstenko_get_block_defaults('goals') (таб «Секции лендинга → С какой целью нужен ВНЖ»),
 * атрибуты блока my-theme/goals имеют приоритет. Иконка пункта — выбранная или стандартная по номеру.
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('goals') : [];

$overrides = get_query_var('goals_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$badge = trim((string) ($data['badge'] ?? ''));
$title = trim((string) ($data['title'] ?? ''));
$text  = trim((string) ($data['text'] ?? ''));

$items = [];
foreach ((array) ($data['items'] ?? []) as $item) {
    if (!is_array($item)) {
        continue;
    }
    $item_title = trim((string) ($item['title'] ?? ''));
    $item_text  = trim((string) ($item['text'] ?? ''));
    if ($item_title === '' && $item_text === '') {
        continue;
    }
    $items[] = [
        'icon'  => is_array($item['icon'] ?? null) ? (int) ($item['icon']['id'] ?? 0) : (int) ($item['icon'] ?? 0),
        'title' => $item_title,
        'text'  => $item_text,
    ];
}

if (!$items) {
    return;
}
?>
<section class="goals section">
  <div class="container">
    <?php if ($badge !== '' || $title !== '' || $text !== '') : ?>
      <div class="goals__top">
        <?php if ($badge !== '') : ?>
          <span class="goals__badge"><?= esc_html($badge); ?></span>
        <?php endif; ?>
        <?php if ($title !== '') : ?>
          <h2 class="goals__title section-title"><?= tolstenko_kses_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($text !== '') : ?>
          <p class="goals__text"><?= tolstenko_kses_html($text); ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <ul class="goals__items">
      <?php foreach ($items as $index => $item) : ?>
        <li class="goals__item">
          <?= tolstenko_landing_icon('goals', $index, $item['icon'], 'goals__item-icon'); ?>
          <div class="goals__item-body">
            <?php if ($item['title'] !== '') : ?>
              <h3 class="goals__item-title"><?= tolstenko_kses_html($item['title']); ?></h3>
            <?php endif; ?>
            <?php if ($item['text'] !== '') : ?>
              <p class="goals__item-text"><?= tolstenko_kses_html($item['text']); ?></p>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
