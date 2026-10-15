<?php

defined('ABSPATH') || exit;

set_query_var('why_us_data', [
    'subtitle'     => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'        => isset($attributes['title']) ? $attributes['title'] : '',
    'title_accent' => isset($attributes['title_accent']) ? $attributes['title_accent'] : '',
    'items'        => isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [],
]);

get_template_part('pages/sections/why-us');
