<?php

/**
 * Статья: предупреждения / заметки.
 *
 * Типы: warn / pin / ide / err — встроенная иконка и цветная плашка;
 * custom — своя иконка (необязательна), без неё — нейтральная плашка.
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$allowed_types = tolstenko_blog_warning_allowed_types();

$normalize = static function ($rows) use ($allowed_types): array {
    $clean = [];

    foreach ((array) $rows as $row) {
        if (!is_array($row)) {
            continue;
        }

        $text = (string) ($row['text'] ?? '');

        if (trim(wp_strip_all_tags($text)) === '') {
            continue;
        }

        $type = sanitize_key((string) ($row['type'] ?? 'warn'));

        $clean[] = [
            'type'  => in_array($type, $allowed_types, true) ? $type : 'warn',
            'title' => sanitize_text_field((string) ($row['title'] ?? '')),
            'text'  => $text,
            'icon'  => tolstenko_block_image_id($row['icon'] ?? 0),
        ];
    }

    return $clean;
};

$items = $normalize($attributes['items'] ?? []);

if (!$items) {
    $items = $normalize(tolstenko_get_blog_content_defaults('blog_warning')['items'] ?? []);
}

if (!$items) {
    return;
}

$icons = [
    'warn' => '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 4.2v5.2M8 11.8h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
    'pin'  => '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 13.5V9.5M5.2 6.2C5.2 4.7 6.4 3.5 8 3.5C9.6 3.5 10.8 4.7 10.8 6.2C10.8 7.4 10 8.4 8.9 8.8L8.5 9.5H7.5L7.1 8.8C6 8.4 5.2 7.4 5.2 6.2Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'ide'  => '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.2 11.5h3.6M6.6 13h2.8M8 2.5c1.9 0 3.4 1.5 3.4 3.3 0 1.3-.8 2.4-1.9 2.9v1.3H6.5V8.7C5.4 8.2 4.6 7.1 4.6 5.8 4.6 4 6.1 2.5 8 2.5Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'err'  => '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5l6 6M11 5l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
];

/**
 * Своя иконка: SVG из медиатеки вставляем inline (красится через currentColor), иначе <img>.
 */
$custom_icon = static function (int $icon_id): string {
    if ($icon_id <= 0) {
        return '';
    }

    $path = get_attached_file($icon_id);

    if ($path && is_readable($path) && preg_match('/\.svg$/i', $path)) {
        $svg = trim((string) file_get_contents($path));

        if (stripos($svg, '<svg') !== false) {
            return $svg;
        }
    }

    $url = wp_get_attachment_image_url($icon_id, 'thumbnail') ?: wp_get_attachment_image_url($icon_id, 'full');

    return $url ? '<img src="' . esc_url($url) . '" alt="" width="55" height="55" loading="lazy" decoding="async">' : '';
};
?>
<ul class="single-blog__warnings">
  <?php foreach ($items as $item) :
    $type      = $item['type'];
    $icon_html = $type === 'custom' ? $custom_icon($item['icon']) : $icons[$type];
    $title     = $item['title'] !== '' ? $item['title'] : tolstenko_blog_warning_card_title($type);
    $classes   = ['single-blog__warnings-item', 'single-blog__warnings-item--' . $type];

    if ($icon_html === '') {
        $classes[] = 'single-blog__warnings-item--no-icon';
    }
  ?>
    <li class="<?= esc_attr(implode(' ', $classes)); ?>">
      <?php if ($icon_html !== '') : ?>
        <span class="single-blog__warnings-icon" aria-hidden="true"><?= $icon_html; ?></span>
      <?php endif; ?>

      <div class="single-blog__warnings-body">
        <?php if ($title !== '') : ?>
          <p class="single-blog__warnings-title"><?= esc_html($title); ?></p>
        <?php endif; ?>
        <div class="single-blog__warnings-text"><?= tolstenko_kses_html($item['text']); ?></div>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
