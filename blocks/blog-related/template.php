<?php

defined('ABSPATH') || exit;

$post = get_post();

if (!$post instanceof WP_Post || $post->post_type !== 'blog') {
    return;
}

setup_postdata($post);

$blog_related_data = theme_get_blog_related_data([
    'title'   => isset($attributes['title']) ? $attributes['title'] : '',
    'postIds' => isset($attributes['postIds']) ? $attributes['postIds'] : [],
]);

set_query_var('blog_related_data', $blog_related_data);
get_template_part('pages/sections/blog-section-related');

wp_reset_postdata();
