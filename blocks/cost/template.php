<?php

defined('ABSPATH') || exit;

set_query_var('cost_data', [
    'badge' => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'title_accent' => isset($attributes['title_accent']) ? $attributes['title_accent'] : '',
    'lead' => isset($attributes['lead']) ? $attributes['lead'] : '',
    'prices' => isset($attributes['prices']) && is_array($attributes['prices']) ? $attributes['prices'] : [],
    'card_title' => isset($attributes['card_title']) ? $attributes['card_title'] : '',
    'card_text' => isset($attributes['card_text']) ? $attributes['card_text'] : '',
    'btn_text' => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
    'image' => isset($attributes['image']) && is_array($attributes['image']) ? $attributes['image'] : [],
]);

get_template_part('pages/sections/cost');
