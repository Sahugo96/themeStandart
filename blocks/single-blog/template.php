<?php

defined('ABSPATH') || exit;

$post = get_post();

if (!$post instanceof WP_Post) {
    return;
}

setup_postdata($post);
set_query_var('single_blog_is_block', true);
get_template_part('pages/single-blog/sections/single-blog');
wp_reset_postdata();
