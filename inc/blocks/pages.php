<?php

defined('ABSPATH') || exit;

function theme_get_service_page_id(): int
{
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'archive-service.php',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $page_id = $pages ? (int) $pages[0] : 656;

    return $page_id;
}

function theme_get_blog_page_id(): int
{
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'archive-blog.php',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $page_id = $pages ? (int) $pages[0] : 0;

    return $page_id;
}

function theme_get_front_page_id(): int
{
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $front_page_id = (int) get_option('page_on_front');

    if ($front_page_id && get_post_status($front_page_id) === 'publish') {
        $page_id = $front_page_id;

        return $page_id;
    }

    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'front-page.php',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $page_id = $pages ? (int) $pages[0] : 0;

    return $page_id;
}
function theme_output_service_page_blocks(): void
{
    $page_id = theme_get_service_page_id();

    if (!$page_id) {
        return;
    }

    $page = get_post($page_id);

    if (!$page instanceof WP_Post) {
        return;
    }

    echo apply_filters('the_content', $page->post_content);
}

function theme_output_blog_page_blocks(): void
{
    $page_id = theme_get_blog_page_id();

    if (!$page_id) {
        return;
    }

    $page = get_post($page_id);

    if (!$page instanceof WP_Post) {
        return;
    }

    echo apply_filters('the_content', $page->post_content);
}

function theme_output_front_page_blocks(): void
{
    $page_id = theme_get_front_page_id();

    if (!$page_id) {
        return;
    }

    $page = get_post($page_id);

    if (!$page instanceof WP_Post) {
        return;
    }

    echo apply_filters('the_content', $page->post_content);
}

