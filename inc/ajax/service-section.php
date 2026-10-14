<?php

defined('ABSPATH') || exit;

function theme_get_services_slider_query_args(array $params): array
{
    $category = isset($params['category']) ? sanitize_text_field((string) $params['category']) : '';
    $taxonomy = isset($params['taxonomy']) ? sanitize_text_field((string) $params['taxonomy']) : 'service_cat';
    $post_type = isset($params['post_type']) ? sanitize_text_field((string) $params['post_type']) : 'service';
    $posts_per_page = isset($params['posts_per_page']) ? (int) $params['posts_per_page'] : -1;
    $post_ids = isset($params['post_ids']) ? (array) $params['post_ids'] : [];

    $post_ids = array_values(array_filter(array_map('intval', $post_ids)));

    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'paged'          => 1,
    ];

    if (!empty($post_ids)) {
        $args['post__in'] = $post_ids;
        $args['orderby'] = 'post__in';
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

function theme_enqueue_services_slider_assets(): void
{
    static $enqueued = false;

    if ($enqueued) {
        return;
    }

    $enqueued = true;

    $script_path = get_template_directory() . '/assets/js/modules/serviceSectionFilter.js';

    wp_register_script(
        'theme-service-slider-filter',
        get_template_directory_uri() . '/assets/js/modules/serviceSectionFilter.js',
        [],
        file_exists($script_path) ? filemtime($script_path) : null,
        true
    );

    wp_enqueue_script('theme-service-slider-filter');

    wp_add_inline_script(
        'theme-service-slider-filter',
        'window.service_ajax = ' . wp_json_encode([
            'ajax_url' => admin_url('admin-ajax.php'),
        ]) . ';',
        'before'
    );
}

add_action('wp_ajax_filter_service_section', 'handle_service_section_filter');
add_action('wp_ajax_nopriv_filter_service_section', 'handle_service_section_filter');

function handle_service_section_filter()
{
    $post_ids = [];

    if (!empty($_POST['post_ids'])) {
        if (is_array($_POST['post_ids'])) {
            $post_ids = array_map('intval', $_POST['post_ids']);
        } else {
            $post_ids = array_map('intval', explode(',', sanitize_text_field(wp_unslash($_POST['post_ids']))));
        }
    }

    $taxonomy = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : 'service_cat';
    $category = isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';

    $query_args = theme_get_services_slider_query_args([
        'category'       => $category,
        'taxonomy'       => $taxonomy,
        'post_type'      => isset($_POST['post_type']) ? sanitize_text_field(wp_unslash($_POST['post_type'])) : 'service',
        'posts_per_page' => isset($_POST['posts_per_page']) ? (int) $_POST['posts_per_page'] : -1,
        'post_ids'       => $post_ids,
    ]);

    $query = new WP_Query($query_args);

    ob_start();

    if ($query->have_posts()) : ?>
        <div class="splide__track">
            <div class="service-section__splide-list splide__list">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php get_template_part('pages/sections/partials/service-card', null, [
                        'taxonomy'          => $taxonomy,
                        'selected_category' => $category,
                    ]); ?>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="splide__bottom">
            <div class="splide__pagination"></div>

            <div class="splide__arrows splide__arrows--ltr">
                <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide">
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>

                <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide">
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif;

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
    ]);
}
