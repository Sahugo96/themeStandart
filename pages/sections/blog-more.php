<?php

defined('ABSPATH') || exit;

/**
 * Секция «Перейти в блог» (blog-more).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('blog_more')
 * (таб «Дефолты блоков → Кнопка в блог»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('blog_more') : [];

$defaults = [
    'text' => $admin['text'] ?? '',
    'url'  => $admin['url'] ?? '',
];

$overrides = get_query_var('blog_more_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

if (trim((string) $data['text']) === '') {
    return;
}
?>
<div class="blog-more">
  <div class="container">
    <a class="blog-more__btn" href="<?= esc_url($data['url'] !== '' ? $data['url'] : '/blog/'); ?>">
      <span><?= $data['text']; ?></span>
      <svg class="blog-more__arrow" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M4 12h16M14 6l6 6-6 6"/>
      </svg>
    </a>
  </div>
</div>
