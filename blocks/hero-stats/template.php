<?php

defined('ABSPATH') || exit;

set_query_var('hero_stats_data', [
    'items' => isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [],
]);

get_template_part('pages/sections/hero-stats');
