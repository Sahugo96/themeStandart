<?php

defined('ABSPATH') || exit;

/**
 * Блок «Плитка отзывов» (my-theme/reviews-tiles). Пустые атрибуты — из таба «Отзывы»
 * в дефолтах блоков (как у блока «Отзывы (секция)»), см. pages/sections/reviews-tiles.php.
 */

$reviews_tiles_data = theme_get_reviews_section_data([
    'title'   => isset($attributes['title']) ? (string) $attributes['title'] : '',
    'postIds' => isset($attributes['postIds']) && is_array($attributes['postIds']) ? $attributes['postIds'] : [],
]);

set_query_var('reviews_tiles_data', $reviews_tiles_data);

get_template_part('pages/sections/reviews-tiles');

set_query_var('reviews_tiles_data', []);
