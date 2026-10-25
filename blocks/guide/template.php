<?php

defined('ABSPATH') || exit;

set_query_var('guide_data', [
    'subtitle' => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'    => isset($attributes['title']) ? $attributes['title'] : '',
    // Выбор одной записи: 0 = из настроек темы.
    'post_id'  => !empty($attributes['post_id']) ? (int) $attributes['post_id'] : '',
    'btn_text' => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
]);

get_template_part('pages/sections/guide');
