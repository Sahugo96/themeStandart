<?php

defined('ABSPATH') || exit;

set_query_var('team_data', [
    'badge' => isset($attributes['badge']) ? $attributes['badge'] : '',
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'text'  => isset($attributes['text']) ? $attributes['text'] : '',
]);

get_template_part('pages/sections/team');
