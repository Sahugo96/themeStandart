<?php

defined('ABSPATH') || exit;

$post = get_post();

if (!$post instanceof WP_Post) {
    return;
}

setup_postdata($post);
get_template_part('pages/single-blog/sections/single-blog');
wp_reset_postdata();
