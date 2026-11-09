<?php

defined('ABSPATH') || exit;

add_action('wp', 'theme_disable_blog_auto_views_likes', 20);

function theme_disable_blog_auto_views_likes(): void
{
    if (!(is_singular('blog') || (function_exists('theme_is_document_page') && is_page() && theme_is_document_page(get_queried_object_id())))) {
        return;
    }

    remove_filter('the_content', 'wp_ulike_put_posts', 15);
    remove_filter('the_excerpt', 'wp_ulike_put_posts', 15);
}

add_filter('pvc_display_views_count', 'theme_hide_blog_post_views_auto_display');

function theme_hide_blog_post_views_auto_display($display)
{
    if ((is_singular('blog') || (function_exists('theme_is_document_page') && is_page() && theme_is_document_page(get_queried_object_id())))) {
        return false;
    }

    return $display;
}

/**
 * Число просмотров записи (Post Views Counter) — без подписи «Post Views:» и разметки плагина.
 *
 * @param int $post_id Post ID (0 — текущая запись).
 * @return int
 */
function theme_get_post_views_count(int $post_id = 0): int
{
    $post_id = $post_id ?: (int) get_the_ID();

    if ($post_id <= 0) {
        return 0;
    }

    if (function_exists('pvc_get_post_views')) {
        return (int) pvc_get_post_views($post_id);
    }

    // Запасной вариант: из вывода шорткода берём только цифры.
    $html = wp_strip_all_tags((string) do_shortcode('[post-views id="' . $post_id . '"]'));

    return preg_match('/(\d[\d\s.,]*)/u', $html, $matches) ? (int) preg_replace('/\D/', '', $matches[1]) : 0;
}
