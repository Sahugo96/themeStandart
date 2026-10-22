<?php

defined('ABSPATH') || exit;

set_query_var('europe_data', [
    'title'     => isset($attributes['title']) ? $attributes['title'] : '',
    'columns'   => isset($attributes['columns']) && is_array($attributes['columns']) ? $attributes['columns'] : [],
    'rows'      => isset($attributes['rows']) && is_array($attributes['rows']) ? $attributes['rows'] : [],
    'link_text' => isset($attributes['link_text']) ? $attributes['link_text'] : '',
    'link_url'  => isset($attributes['link_url']) ? $attributes['link_url'] : '',
    'foot_text' => isset($attributes['foot_text']) ? $attributes['foot_text'] : '',
    'btn_text'  => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
    'btn_url'   => isset($attributes['btn_url']) ? $attributes['btn_url'] : '',
]);

get_template_part('pages/sections/europe');
