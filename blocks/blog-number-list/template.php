<?php

/**
 * Статья: нумерованный список.
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$collect = static function ($rows): array {
    $out = [];

    foreach ((array) $rows as $row) {
        $text = trim((string) (is_array($row) ? ($row['text'] ?? '') : $row));

        if (trim(wp_strip_all_tags($text)) !== '') {
            $out[] = $text;
        }
    }

    return $out;
};

$items = $collect($attributes['items'] ?? []);

if (!$items) {
    $items = $collect(tolstenko_get_blog_content_defaults('blog_number_list')['items'] ?? []);
}

if (!$items) {
    return;
}
?>
<div class="single-blog__content-block single-blog__content-block--number br-30">
  <ul class="single-blog__content-list">
    <?php foreach ($items as $text) : ?>
      <li><span></span><?= tolstenko_kses_html($text); ?></li>
    <?php endforeach; ?>
  </ul>
</div>
