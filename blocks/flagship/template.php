<?php

defined('ABSPATH') || exit;

set_query_var('flagship_data', [
    'badge' => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'cards' => isset($attributes['cards']) && is_array($attributes['cards']) ? $attributes['cards'] : [],
]);

get_template_part('pages/sections/flagship');
