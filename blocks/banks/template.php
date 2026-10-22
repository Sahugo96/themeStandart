<?php

defined('ABSPATH') || exit;

set_query_var('banks_data', [
    'badge' => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'lead' => isset($attributes['lead']) ? $attributes['lead'] : '',
    'items' => isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [],
]);

get_template_part('pages/sections/banks');
