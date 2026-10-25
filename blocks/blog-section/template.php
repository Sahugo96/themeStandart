<?php

defined('ABSPATH') || exit;

/**
 * Блок «Секция статей» (my-theme/blog-section).
 * Значения блока имеют приоритет, пустые берутся из таба «Статьи»
 * (tolstenko_get_block_defaults('blog_section_filters')) — см. pages/sections/blog-section.php.
 */

set_query_var('blog_section_data', [
    'badge'    => isset($attributes['badge']) ? (string) $attributes['badge'] : '',
    'title'    => isset($attributes['title']) ? (string) $attributes['title'] : '',
    'ids'      => isset($attributes['postIds']) && is_array($attributes['postIds']) ? $attributes['postIds'] : [],
    'btn_text' => isset($attributes['btn_text']) ? (string) $attributes['btn_text'] : '',
]);

get_template_part('pages/sections/blog-section');
