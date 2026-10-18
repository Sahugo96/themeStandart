<?php

defined('ABSPATH') || exit;

set_query_var('compare_data', [
    'subtitle'     => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'        => isset($attributes['title']) ? $attributes['title'] : '',
    'text'         => isset($attributes['text']) ? $attributes['text'] : '',
    'rows'         => isset($attributes['rows']) && is_array($attributes['rows']) ? $attributes['rows'] : [],
    'foot_text'    => isset($attributes['foot_text']) ? $attributes['foot_text'] : '',
    'btn_text'     => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
]);

get_template_part('pages/sections/compare');
