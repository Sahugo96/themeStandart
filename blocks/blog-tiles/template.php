<?php

defined('ABSPATH') || exit;

/**
 * Блок «Плитка статей» (my-theme/blog-tiles). Пустые атрибуты — из таба «Статьи»
 * (tolstenko_get_block_defaults('blog_section_filters')), см. pages/sections/blog-tiles.php.
 */

$blog_tiles_data = [];

foreach (['badge', 'title', 'text'] as $key) {
    $blog_tiles_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

set_query_var('blog_tiles_data', $blog_tiles_data);

get_template_part('pages/sections/blog-tiles');

set_query_var('blog_tiles_data', []);
