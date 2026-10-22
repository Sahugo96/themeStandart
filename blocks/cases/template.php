<?php

defined('ABSPATH') || exit;

set_query_var('cases_data', [
    'badge' => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'all_text' => isset($attributes['all_text']) ? $attributes['all_text'] : '',
    'all_url' => isset($attributes['all_url']) ? $attributes['all_url'] : '',
    'foot_text' => isset($attributes['foot_text']) ? $attributes['foot_text'] : '',
    'btn_text' => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
    'btn_url' => isset($attributes['btn_url']) ? $attributes['btn_url'] : '',
    'post_ids' => isset($attributes['post_ids']) && is_array($attributes['post_ids']) ? $attributes['post_ids'] : [],
]);

get_template_part('pages/sections/cases');
