<?php

defined('ABSPATH') || exit;

add_action('wp', 'theme_disable_blog_auto_views_likes', 20);

function theme_disable_blog_auto_views_likes(): void
{
    if (!is_singular('blog')) {
        return;
    }

    remove_filter('the_content', 'wp_ulike_put_posts', 15);
    remove_filter('the_excerpt', 'wp_ulike_put_posts', 15);
}

add_filter('pvc_display_views_count', 'theme_hide_blog_post_views_auto_display');

function theme_hide_blog_post_views_auto_display($display)
{
    if (is_singular('blog')) {
        return false;
    }

    return $display;
}
