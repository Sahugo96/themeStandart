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

// Пустая ссылка = страница блога (как кнопка в секции «Статьи»).
$url = trim((string) $data['url']);

if ($url === '') {
    $blog_page_id = function_exists('theme_get_blog_page_id') ? theme_get_blog_page_id() : 0;
    $url = $blog_page_id ? (string) get_permalink($blog_page_id) : (string) get_post_type_archive_link('blog');
    $url = $url !== '' ? $url : home_url('/blog/');
}
?>
<div class="blog-more">
  <div class="container">
    <a class="blog-more__btn default-btn default-btn--transparent" href="<?= esc_url($url); ?>">
      <span><?= esc_html($data['text']); ?></span>
      <svg class="blog-more__arrow" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M4 12h16M14 6l6 6-6 6"/>
      </svg>
    </a>
  </div>
</div>
