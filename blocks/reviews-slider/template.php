<?php

defined('ABSPATH') || exit;

$reviews_data = theme_get_reviews_section_data([
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'postIds' => isset($attributes['postIds']) ? $attributes['postIds'] : [],
]);

set_query_var('reviews_data', $reviews_data);
get_template_part('pages/sections/reviews');
