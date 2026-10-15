<?php

defined('ABSPATH') || exit;

set_query_var('consult_data', [
    'subtitle'     => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'        => isset($attributes['title']) ? $attributes['title'] : '',
    'title_accent' => isset($attributes['title_accent']) ? $attributes['title_accent'] : '',
    'text'         => isset($attributes['text']) ? $attributes['text'] : '',
    'image'        => isset($attributes['image']) && is_array($attributes['image']) ? $attributes['image'] : [],
]);

get_template_part('pages/sections/consult');
