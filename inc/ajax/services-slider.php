<?php

defined('ABSPATH') || exit;

/**
 * AJAX-фильтр секции «Услуги» (services services--slider, CPT service / таксономия service_cat).
 *
 * Реализовано по образцу «Кейсов» (inc/ajax/case-section.php). Тип записи и таксономия
 * зафиксированы на сервере: из запроса берём только рубрику, ID выбранных услуг и количество.
 */

const THEME_SERVICES_SLIDER_POST_TYPE = 'service';
const THEME_SERVICES_SLIDER_TAXONOMY  = 'service_cat';
const THEME_SERVICES_SLIDER_MAX_POSTS = 24;

function theme_get_services_slider_section_query_args(array $params): array
{
    $category       = isset($params['category']) ? sanitize_title((string) $params['category']) : '';
    $posts_per_page = isset($params['posts_per_page']) ? (int) $params['posts_per_page'] : 6;
    $post_ids       = isset($params['post_ids']) ? (array) $params['post_ids'] : [];
    $post_ids       = array_slice(array_values(array_filter(array_map('intval', $post_ids))), 0, THEME_SERVICES_SLIDER_MAX_POSTS);

    $args = [
        'post_type'      => THEME_SERVICES_SLIDER_POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => max(1, min(THEME_SERVICES_SLIDER_MAX_POSTS, $posts_per_page)),
        'no_found_rows'  => true,
    ];

    if (!empty($post_ids)) {
        $args['post__in']       = $post_ids;
        $args['orderby']        = 'post__in';
        $args['posts_per_page'] = count($post_ids);
    }

    if ($category !== '') {
        $args['tax_query'] = [
            [
                'taxonomy' => THEME_SERVICES_SLIDER_TAXONOMY,
                'field'    => 'slug',
                'terms'    => $category,
            ],
        ];
    }

    return $args;
}

function theme_enqueue_services_slider_section_assets(): void
{
    static $enqueued = false;

    if ($enqueued) {
        return;
    }

    $enqueued = true;

    $script_path = get_template_directory() . '/assets/js/modules/servicesSliderFilter.js';

    wp_register_script(
        'theme-services-slider-filter',
        get_template_directory_uri() . '/assets/js/modules/servicesSliderFilter.js',
        [],
        file_exists($script_path) ? filemtime($script_path) : null,
        true
    );

    wp_enqueue_script('theme-services-slider-filter');

    wp_add_inline_script(
        'theme-services-slider-filter',
        'window.services_slider_ajax = ' . wp_json_encode([
            'ajax_url' => admin_url('admin-ajax.php'),
        ]) . ';',
        'before'
    );
}

add_action('wp_ajax_filter_services_slider', 'handle_services_slider_filter');
add_action('wp_ajax_nopriv_filter_services_slider', 'handle_services_slider_filter');

function handle_services_slider_filter()
{
    $post_ids = [];

    if (!empty($_POST['post_ids'])) {
        $raw_ids  = is_array($_POST['post_ids']) ? $_POST['post_ids'] : explode(',', sanitize_text_field(wp_unslash($_POST['post_ids'])));
        $post_ids = array_map('intval', $raw_ids);
    }

    $query = new WP_Query(theme_get_services_slider_section_query_args([
        'category'       => isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '',
        'posts_per_page' => isset($_POST['posts_per_page']) ? (int) $_POST['posts_per_page'] : 6,
        'post_ids'       => $post_ids,
    ]));

    ob_start();

    if ($query->have_posts()) : ?>
        <div class="splide__track">
            <div class="services__list splide__list">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php get_template_part('pages/sections/partials/services-card'); ?>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="splide__pagination"></div>
    <?php else : ?>
        <p class="services__empty">В этой рубрике пока нет услуг.</p>
    <?php endif;

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
    ]);
}
