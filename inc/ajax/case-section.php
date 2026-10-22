<?php

defined('ABSPATH') || exit;

/**
 * AJAX-фильтр секции «Кейсы» (CPT case / таксономия case_cat).
 *
 * Реализовано по образцу «Слайдер услуг (фильтр)» (inc/ajax/service-section.php).
 */

function theme_get_cases_query_args(array $params): array
{
    $category = isset($params['category']) ? sanitize_text_field((string) $params['category']) : '';
    $taxonomy = isset($params['taxonomy']) ? sanitize_text_field((string) $params['taxonomy']) : 'case_cat';
    $post_type = isset($params['post_type']) ? sanitize_text_field((string) $params['post_type']) : 'case';
    $posts_per_page = isset($params['posts_per_page']) ? (int) $params['posts_per_page'] : -1;
    $post_ids = isset($params['post_ids']) ? (array) $params['post_ids'] : [];

    $post_ids = array_values(array_filter(array_map('intval', $post_ids)));

    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'paged'          => 1,
        'post_status'    => 'publish',
    ];

    if (!empty($post_ids)) {
        $args['post__in'] = $post_ids;
        $args['orderby']  = 'post__in';
    }

    if ($category !== '') {
        $args['tax_query'] = [
            [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $category,
            ],
        ];
    }

    return $args;
}

function theme_enqueue_cases_section_assets(): void
{
    static $enqueued = false;

    if ($enqueued) {
        return;
    }

    $enqueued = true;

    $script_path = get_template_directory() . '/assets/js/modules/caseSectionFilter.js';

    wp_register_script(
        'theme-cases-filter',
        get_template_directory_uri() . '/assets/js/modules/caseSectionFilter.js',
        [],
        file_exists($script_path) ? filemtime($script_path) : null,
        true
    );

    wp_enqueue_script('theme-cases-filter');

    wp_add_inline_script(
        'theme-cases-filter',
        'window.cases_ajax = ' . wp_json_encode([
            'ajax_url' => admin_url('admin-ajax.php'),
        ]) . ';',
        'before'
    );
}

add_action('wp_ajax_filter_cases_section', 'handle_cases_section_filter');
add_action('wp_ajax_nopriv_filter_cases_section', 'handle_cases_section_filter');

function handle_cases_section_filter()
{
    $post_ids = [];

    if (!empty($_POST['post_ids'])) {
        if (is_array($_POST['post_ids'])) {
            $post_ids = array_map('intval', $_POST['post_ids']);
        } else {
            $post_ids = array_map('intval', explode(',', sanitize_text_field(wp_unslash($_POST['post_ids']))));
        }
    }

    $taxonomy = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : 'case_cat';
    $category = isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';

    $query = new WP_Query(theme_get_cases_query_args([
        'category'       => $category,
        'taxonomy'       => $taxonomy,
        'post_type'      => isset($_POST['post_type']) ? sanitize_text_field(wp_unslash($_POST['post_type'])) : 'case',
        'posts_per_page' => isset($_POST['posts_per_page']) ? (int) $_POST['posts_per_page'] : -1,
        'post_ids'       => $post_ids,
    ]));

    ob_start();

    if ($query->have_posts()) : ?>
        <div class="splide__track">
            <div class="cases__splide-list splide__list">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php get_template_part('pages/sections/partials/case-card'); ?>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="splide__bottom">
            <div class="splide__pagination"></div>
        </div>
    <?php endif;

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
    ]);
}