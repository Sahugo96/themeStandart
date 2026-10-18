<?php

defined('ABSPATH') || exit;

set_query_var('process_data', [
    'badge' => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'image' => isset($attributes['image']) && is_array($attributes['image']) ? $attributes['image'] : [],
    'items' => isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [],
]);

get_template_part('pages/sections/process');
