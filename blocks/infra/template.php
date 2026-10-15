<?php

defined('ABSPATH') || exit;

set_query_var('infra_data', [
    'subtitle'     => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'        => isset($attributes['title']) ? $attributes['title'] : '',
    'title_accent' => isset($attributes['title_accent']) ? $attributes['title_accent'] : '',
    'text'         => isset($attributes['text']) ? $attributes['text'] : '',
    'btn_text'     => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
    'items'        => isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [],
]);

get_template_part('pages/sections/infra');
