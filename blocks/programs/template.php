<?php

defined('ABSPATH') || exit;

set_query_var('programs_data', [
    'badge' => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'lead' => isset($attributes['lead']) ? $attributes['lead'] : '',
    'columns' => isset($attributes['columns']) && is_array($attributes['columns']) ? $attributes['columns'] : [],
    'rows' => isset($attributes['rows']) && is_array($attributes['rows']) ? $attributes['rows'] : [],
    'btn_text' => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
    'btn_url' => isset($attributes['btn_url']) ? $attributes['btn_url'] : '',
]);

get_template_part('pages/sections/programs');
