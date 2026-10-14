<?php

defined('ABSPATH') || exit;

$slider_data = theme_get_blog_slider_data([
    'title'   => isset($attributes['title']) ? $attributes['title'] : '',
    'postIds' => isset($attributes['postIds']) ? $attributes['postIds'] : [],
]);

set_query_var('blog_related_data', $slider_data);

get_template_part('pages/sections/blog-section-related', null, [
    'title'      => $slider_data['title'],
    'post_ids'   => $slider_data['post_ids'],
    'section_id' => 'blog_slider_' . wp_unique_id(),
]);
