<?php

defined('ABSPATH') || exit;

function theme_service_cat_taxonomy_args($args, $taxonomy)
{
    if ($taxonomy !== 'service_cat') {
        return $args;
    }

    // Отключаем автоматические правила — они перехватывают URL записей.
    // Маршруты рубрик задаём вручную ниже (только для известных slug).
    $args['rewrite'] = false;

    return $args;
}
add_filter('register_taxonomy_args', 'theme_service_cat_taxonomy_args', 10, 2);

function theme_service_resolve_request($query_vars)
{
    if (empty($query_vars['service_cat']) || !empty($query_vars['service'])) {
        return $query_vars;
    }

    $slug = $query_vars['service_cat'];
    $term = get_term_by('slug', $slug, 'service_cat');

    if ($term instanceof WP_Term) {
        return $query_vars;
    }

    $post = get_page_by_path($slug, OBJECT, 'service');

    if ($post instanceof WP_Post) {
        unset($query_vars['service_cat']);
        $query_vars['service']      = $slug;
        $query_vars['name']      = $slug;
        $query_vars['post_type'] = 'service';
    }

    return $query_vars;
}
add_filter('request', 'theme_service_resolve_request');

function theme_service_rewrite_rules()
{
    add_rewrite_rule(
        '^service/page/([0-9]{1,})/?$',
        'index.php?post_type=service&paged=$matches[1]',
        'top'
    );

    $terms = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => false,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return;
    }

    foreach ($terms as $term) {
        $slug = preg_quote($term->slug, '/');

        add_rewrite_rule(
            '^service/' . $slug . '/?$',
            'index.php?service_cat=' . $term->slug,
            'top'
        );

        add_rewrite_rule(
            '^service/' . $slug . '/page/([0-9]{1,})/?$',
            'index.php?service_cat=' . $term->slug . '&paged=$matches[1]',
            'top'
        );
    }
}
add_action('init', 'theme_service_rewrite_rules', 20);

function theme_service_term_link($termlink, $term, $taxonomy)
{
    if ($taxonomy === 'service_cat') {
        return home_url('/service/' . $term->slug . '/');
    }

    return $termlink;
}
add_filter('term_link', 'theme_service_term_link', 10, 3);

function theme_service_flush_rewrite_rules()
{
    theme_service_rewrite_rules();
    theme_primary_term_post_rewrite_rules();
    flush_rewrite_rules();
}
add_action('created_service_cat', 'theme_service_flush_rewrite_rules');
add_action('edited_service_cat', 'theme_service_flush_rewrite_rules');
add_action('delete_service_cat', 'theme_service_flush_rewrite_rules');
add_action('after_switch_theme', 'theme_service_flush_rewrite_rules');

function theme_service_posts_per_page($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (is_post_type_archive('service') || is_tax('service_cat')) {
        $query->set('posts_per_page', 2);
    }
}
add_action('pre_get_posts', 'theme_service_posts_per_page');

function theme_get_service_paged()
{
    $paged = (int) get_query_var('paged');
    $page  = (int) get_query_var('page');

    return max(1, $paged, $page);
}

function theme_get_service_pagination_args($total_pages, $current_page)
{
    $args = [
        'total'     => $total_pages,
        'current'   => max(1, (int) $current_page),
        'show_all'  => false,
        'end_size'  => 1,
        'mid_size'  => 1,
        'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 18" fill="none">
  <path d="M8.146 4.75L4.09634 8.79965C3.98569 8.9103 3.98569 9.0897 4.09634 9.20035L8.146 13.25" stroke-linecap="round"/>
  <path d="M4.25 9L12.75 9" stroke-linecap="round"/>
</svg>',
        'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 18" fill="none">
  <path d="M8.854 13.25L12.9037 9.20035C13.0143 9.0897 13.0143 8.9103 12.9037 8.79965L8.854 4.75" stroke-linecap="round"/>
  <path d="M12.75 9L4.25 9" stroke-linecap="round"/>
</svg>',
    ];

    if (is_tax('service_cat')) {
        $term = get_queried_object();
        if ($term instanceof WP_Term) {
            $args['base']   = user_trailingslashit(get_term_link($term), 'page') . '%_%';
            $args['format'] = user_trailingslashit('page/%#%', 'page');
        }
    } elseif (is_post_type_archive('service')) {
        $args['base']   = str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999)));
        $args['format'] = '';
    } elseif (is_page()) {
        $args['base']   = trailingslashit(get_permalink()) . 'page/%_%';
        $args['format'] = '%#%/';
    }

    return $args;
}
