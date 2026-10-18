<?php

defined('ABSPATH') || exit;

set_query_var('guide_data', [
    'subtitle'     => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'        => isset($attributes['title']) ? $attributes['title'] : '',
    'tags'         => isset($attributes['tags']) && is_array($attributes['tags']) ? $attributes['tags'] : [],
    'time'         => isset($attributes['time']) ? $attributes['time'] : '',
    'views'        => isset($attributes['views']) ? $attributes['views'] : '',
    'date_label'   => isset($attributes['date_label']) ? $attributes['date_label'] : '',
    'card_title'   => isset($attributes['card_title']) ? $attributes['card_title'] : '',
    'text'         => isset($attributes['text']) ? $attributes['text'] : '',
    'btn_text'     => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
    'image'        => isset($attributes['image']) && is_array($attributes['image']) ? $attributes['image'] : [],
]);

get_template_part('pages/sections/guide');
