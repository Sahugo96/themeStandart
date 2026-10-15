<?php

defined('ABSPATH') || exit;

$faq_data = theme_get_faq_section_data([
    'badge'      => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title'      => isset($attributes['title']) ? $attributes['title'] : '',
    'items'      => isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [],
    'form_title' => isset($attributes['form_title']) ? $attributes['form_title'] : '',
    'form_text'  => isset($attributes['form_text']) ? $attributes['form_text'] : '',
]);

set_query_var('faq_data', $faq_data);
get_template_part('pages/sections/faq');
