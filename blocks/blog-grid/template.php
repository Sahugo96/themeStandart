<?php

defined('ABSPATH') || exit;

get_template_part('pages/blog/sections/blog-grid', null, [
    'attributes' => isset($attributes) && is_array($attributes) ? $attributes : [],
]);
