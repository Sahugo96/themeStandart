<?php

defined('ABSPATH') || exit;

/**
 * Блок «Сетка отзывов» (my-theme/reviews-grid) — для страницы с шаблоном «Reviews page».
 * Данные и разметка карточек — как у секции «Отзывы» (таб «Отзывы» в дефолтах блоков,
 * pages/sections/reviews.php), но вместо слайдеров сетка: в каждом табе видно per_page
 * карточек, остальные — по кнопке «Показать ещё».
 */

$reviews_data = theme_get_reviews_section_data([
    'title'   => isset($attributes['title']) ? $attributes['title'] : '',
    'postIds' => isset($attributes['postIds']) ? $attributes['postIds'] : [],
]);

$reviews_data['layout']    = 'grid';
$reviews_data['per_page']  = !empty($attributes['per_page']) ? (int) $attributes['per_page'] : 9;
$reviews_data['more_text'] = isset($attributes['more_text']) ? (string) $attributes['more_text'] : '';

set_query_var('reviews_data', $reviews_data);

get_template_part('pages/sections/reviews');

set_query_var('reviews_data', []);
