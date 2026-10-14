<?php

defined('ABSPATH') || exit;

function theme_blog_cat_taxonomy_args($args, $taxonomy)
{
    if ($taxonomy !== 'blog_cat') {
        return $args;
    }

    // Отключаем автоматические правила — они перехватывают URL записей.
    // Маршруты рубрик задаём вручную ниже (только для известных slug).
    $args['rewrite'] = false;

    return $args;
}
add_filter('register_taxonomy_args', 'theme_blog_cat_taxonomy_args', 10, 2);

function theme_blog_resolve_request($query_vars)
{
    if (empty($query_vars['blog_cat']) || !empty($query_vars['blog'])) {
        return $query_vars;
    }

    $slug = $query_vars['blog_cat'];
    $term = get_term_by('slug', $slug, 'blog_cat');

    if ($term instanceof WP_Term) {
        return $query_vars;
    }

    $post = get_page_by_path($slug, OBJECT, 'blog');

    if ($post instanceof WP_Post) {
        unset($query_vars['blog_cat']);
        $query_vars['blog']      = $slug;
        $query_vars['name']      = $slug;
        $query_vars['post_type'] = 'blog';
    }

    return $query_vars;
}
add_filter('request', 'theme_blog_resolve_request');

function theme_blog_rewrite_rules()
{
    add_rewrite_rule(
        '^blog/page/([0-9]{1,})/?$',
        'index.php?post_type=blog&paged=$matches[1]',
        'top'
    );

    $terms = get_terms([
        'taxonomy'   => 'blog_cat',
        'hide_empty' => false,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return;
    }

    foreach ($terms as $term) {
        $slug = preg_quote($term->slug, '/');

        add_rewrite_rule(
            '^blog/' . $slug . '/?$',
            'index.php?blog_cat=' . $term->slug,
            'top'
        );

        add_rewrite_rule(
            '^blog/' . $slug . '/page/([0-9]{1,})/?$',
            'index.php?blog_cat=' . $term->slug . '&paged=$matches[1]',
            'top'
        );
    }
}
add_action('init', 'theme_blog_rewrite_rules', 20);

function theme_blog_term_link($termlink, $term, $taxonomy)
{
    if ($taxonomy === 'blog_cat') {
        return home_url('/blog/' . $term->slug . '/');
    }

    return $termlink;
}
add_filter('term_link', 'theme_blog_term_link', 10, 3);

function theme_blog_flush_rewrite_rules()
{
    theme_blog_rewrite_rules();
    theme_primary_term_post_rewrite_rules();
    flush_rewrite_rules();
}
add_action('created_blog_cat', 'theme_blog_flush_rewrite_rules');
add_action('edited_blog_cat', 'theme_blog_flush_rewrite_rules');
add_action('delete_blog_cat', 'theme_blog_flush_rewrite_rules');
add_action('after_switch_theme', 'theme_blog_flush_rewrite_rules');

function theme_blog_posts_per_page($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (is_post_type_archive('blog') || is_tax('blog_cat')) {
        $query->set('posts_per_page', 17);
    }
}
add_action('pre_get_posts', 'theme_blog_posts_per_page');

function theme_get_blog_paged()
{
    $paged = (int) get_query_var('paged');
    $page  = (int) get_query_var('page');

    return max(1, $paged, $page);
}

function theme_get_blog_pagination_args($total_pages, $current_page)
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

    if (is_tax('blog_cat')) {
        $term = get_queried_object();
        if ($term instanceof WP_Term) {
            $args['base']   = user_trailingslashit(get_term_link($term), 'page') . '%_%';
            $args['format'] = user_trailingslashit('page/%#%', 'page');
        }
    } elseif (is_post_type_archive('blog')) {
        $args['base']   = str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999)));
        $args['format'] = '';
    } elseif (is_page()) {
        $args['base']   = trailingslashit(get_permalink()) . 'page/%_%';
        $args['format'] = '%#%/';
    }

    return $args;
}
