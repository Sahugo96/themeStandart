<?php

/**
 * Статья: плюсы и минусы.
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$defaults = tolstenko_get_blog_content_defaults('blog_pros_cons');

$lines = static function ($rows): array {
    $out = [];

    foreach ((array) $rows as $row) {
        $text = (string) (is_array($row) ? ($row['text'] ?? '') : $row);

        if (trim(wp_strip_all_tags($text)) !== '') {
            $out[] = $text;
        }
    }

    return $out;
};

$columns = [
    'pro' => [
        'title' => trim((string) ($attributes['pros_title'] ?? '')) ?: trim((string) ($defaults['pros_title'] ?? '')) ?: 'Плюсы',
        'lines' => $lines($attributes['pros'] ?? []) ?: $lines($defaults['pros'] ?? []),
        'icon'  => '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 3.5v9M3.5 8h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
    ],
    'con' => [
        'title' => trim((string) ($attributes['cons_title'] ?? '')) ?: trim((string) ($defaults['cons_title'] ?? '')) ?: 'Минусы',
        'lines' => $lines($attributes['cons'] ?? []) ?: $lines($defaults['cons'] ?? []),
        'icon'  => '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.5 8h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
    ],
];

if (!$columns['pro']['lines'] && !$columns['con']['lines']) {
    return;
}
?>
<div class="single-blog__pros-cons">
  <?php foreach ($columns as $mod => $column) : ?>
    <div class="single-blog__pros-cons-item single-blog__pros-cons-item--<?= esc_attr($mod); ?>">
      <p class="single-blog__pros-cons-title">
        <span class="single-blog__pros-cons-icon" aria-hidden="true"><?= $column['icon']; ?></span>
        <?= esc_html($column['title']); ?>
      </p>

      <?php if ($column['lines']) : ?>
        <ul class="single-blog__pros-cons-list">
          <?php foreach ($column['lines'] as $line) : ?>
            <li><?= tolstenko_kses_html($line); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
