<?php

defined('ABSPATH') || exit;

$faq_data = theme_get_faq_section_data([
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'text' => isset($attributes['text']) ? $attributes['text'] : '',
    'items' => isset($attributes['items']) ? $attributes['items'] : [],
]);

set_query_var('faq_data', $faq_data);
get_template_part('pages/sections/faq');
