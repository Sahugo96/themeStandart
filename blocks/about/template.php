<?php

defined('ABSPATH') || exit;

set_query_var('about_data', [
    'subtitle'     => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'        => isset($attributes['title']) ? $attributes['title'] : '',
    'text'         => isset($attributes['text']) ? $attributes['text'] : '',
    'stats'        => isset($attributes['stats']) && is_array($attributes['stats']) ? $attributes['stats'] : [],
    'image'        => isset($attributes['image']) && is_array($attributes['image']) ? $attributes['image'] : [],
]);

get_template_part('pages/sections/about');
