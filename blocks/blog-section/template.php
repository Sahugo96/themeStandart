<?php

defined('ABSPATH') || exit;

$blog_section_data = theme_get_blog_section_data([
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'text'  => isset($attributes['text']) ? $attributes['text'] : '',
]);

set_query_var('blog_section_data', $blog_section_data);

get_template_part('pages/sections/blog-section', null, [
    'section_id'     => 'blog_slider_' . wp_unique_id(),
    'taxonomy'       => 'blog_cat',
    'post_type'      => 'blog',
    'posts_per_page' => 4,
]);
