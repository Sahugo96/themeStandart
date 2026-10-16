<?php

defined('ABSPATH') || exit;

set_query_var('blog_more_data', [
    'text' => isset($attributes['text']) ? $attributes['text'] : '',
    'url' => isset($attributes['url']) ? $attributes['url'] : '',
]);

get_template_part('pages/sections/blog-more');
