<?php

defined('ABSPATH') || exit;

add_action('init', 'theme_disable_reading_time_wp_auto_output', 20);

function theme_disable_reading_time_wp_auto_output(): void
{
    global $reading_time_wp;

    if (!isset($reading_time_wp) || !is_object($reading_time_wp)) {
        return;
    }

    remove_filter('the_content', [$reading_time_wp, 'rt_add_reading_time_before_content']);
    remove_filter('get_the_excerpt', [$reading_time_wp, 'rt_add_reading_time_before_excerpt'], 1000);
}

function theme_get_reading_time_text(int $post_id = 0): string
{
    $post_id = $post_id ?: (int) get_the_ID();

    if (!$post_id) {
        return '';
    }

    // Время, заданное вручную в метабоксе статьи (inc/blog-metabox.php), важнее плагина.
    $minutes = function_exists('theme_get_blog_reading_minutes') ? theme_get_blog_reading_minutes($post_id) : 0;

    if ($minutes > 0) {
        return $minutes . ' мин';
    }

    if (!shortcode_exists('rt_reading_time')) {
        return '';
    }

    $text = wp_strip_all_tags(
        do_shortcode(
            sprintf(
                '[rt_reading_time post_id="%d" postfix="мин" postfix_singular="мин"]',
                $post_id
            )
        )
    );

    return trim(preg_replace('/\s+/u', ' ', html_entity_decode($text, ENT_QUOTES, 'UTF-8')));
}

function theme_the_reading_time(int $post_id = 0): void
{
    $text = theme_get_reading_time_text($post_id);

    if ($text === '') {
        return;
    }

    echo esc_html($text);
}
