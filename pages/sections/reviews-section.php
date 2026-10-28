<?php

defined('ABSPATH') || exit;

/**
 * Секция «Отзывы» на главной без блока my-theme/reviews-section (theme_render_front_section).
 * Данные — как у блока: таб «Отзывы» в дефолтах блоков (заголовок, отзывы, рейтинги).
 * Разметка — pages/sections/reviews.php.
 */

set_query_var('reviews_data', theme_get_reviews_section_data([]));

get_template_part('pages/sections/reviews');
