<?php

defined('ABSPATH') || exit;

function theme_get_primary_term_post_configs(): array
{
    return [
        'service' => [
            'base'     => 'service',
            'taxonomy' => 'service_cat',
        ],
        'blog' => [
            'base'     => 'blog',
            'taxonomy' => 'blog_cat',
        ],
    ];
}

function theme_get_primary_term_slug(int $post_id, string $taxonomy): string
{
    // Основная категория из правой колонки редактора (inc/primary-term-metabox.php).
    if (function_exists('theme_get_primary_term')) {
        $term = theme_get_primary_term($post_id, $taxonomy);

        return $term instanceof WP_Term ? $term->slug : '';
    }

    if (function_exists('yoast_get_primary_term_id')) {
        $term_id = yoast_get_primary_term_id($taxonomy, $post_id);

        if ($term_id) {
            $term = get_term((int) $term_id, $taxonomy);

            if ($term instanceof WP_Term && !is_wp_error($term)) {
                return $term->slug;
            }
        }
    }

    $terms = get_the_terms($post_id, $taxonomy);

    if (!is_array($terms) || !$terms) {
        return '';
    }

    return $terms[0]->slug ?? '';
}

function theme_filter_primary_term_permalink(string $permalink, WP_Post $post): string
{
    $configs = theme_get_primary_term_post_configs();

    if (!isset($configs[$post->post_type])) {
        return $permalink;
    }

    $config = $configs[$post->post_type];
    $term_slug = theme_get_primary_term_slug((int) $post->ID, $config['taxonomy']);

    if ($term_slug === '') {
        return $permalink;
    }

    return home_url(
        user_trailingslashit($config['base'] . '/' . $term_slug . '/' . $post->post_name)
    );
}
add_filter('post_type_link', 'theme_filter_primary_term_permalink', 10, 2);

function theme_primary_term_post_rewrite_rules(): void
{
    foreach (theme_get_primary_term_post_configs() as $post_type => $config) {
        $base = preg_quote($config['base'], '/');

        add_rewrite_rule(
            '^' . $base . '/([^/]+)/([^/]+)/?$',
            'index.php?post_type=' . $post_type . '&name=$matches[2]',
            'top'
        );
    }
}
add_action('init', 'theme_primary_term_post_rewrite_rules', 21);

function theme_primary_term_flush_rewrite_rules(): void
{
    if (function_exists('theme_service_rewrite_rules')) {
        theme_service_rewrite_rules();
    }

    if (function_exists('theme_blog_rewrite_rules')) {
        theme_blog_rewrite_rules();
    }

    if (function_exists('theme_case_rewrite_rules')) {
        theme_case_rewrite_rules();
    }

    theme_primary_term_post_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'theme_primary_term_flush_rewrite_rules');
