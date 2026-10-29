<?php

defined('ABSPATH') || exit;

function theme_get_service_single_block_template(): array
{
    return [
        ['my-theme/faq'],
        ['my-theme/reviews-section'],
    ];
}

function theme_get_blog_single_block_template(): array
{
    return [
        ['my-theme/blog-content'],
        ['my-theme/services-slider-simple'],
        ['my-theme/faq'],
        ['my-theme/blog-related'],
        ['my-theme/blog-comments'],
    ];
}

function theme_get_reviews_page_block_template(): array
{
    return [
        ['my-theme/reviews-section'],
        ['my-theme/faq'],
    ];
}

function theme_is_reviews_page(WP_Post $post): bool
{
    return $post->post_type === 'page' && get_page_template_slug($post) === 'page-reviews.php';
}


function theme_get_service_archive_block_template(): array
{
    return [
        ['my-theme/service-section'],
        ['my-theme/documents'],
        ['my-theme/reviews-section'],
        ['my-theme/blog-section'],
        ['my-theme/faq'],
    ];
}

function theme_is_service_archive_page(WP_Post $post): bool
{
    return $post->post_type === 'page' && get_page_template_slug($post) === 'archive-service.php';
}

function theme_get_blog_archive_block_template(): array
{
    return [
        ['my-theme/blog-grid'],
        ['my-theme/faq'],
    ];
}

function theme_is_blog_archive_page(WP_Post $post): bool
{
    return $post->post_type === 'page' && get_page_template_slug($post) === 'archive-blog.php';
}

function theme_get_front_page_block_template(): array
{
    return [
        ['my-theme/result'],
        ['my-theme/compare'],
        ['my-theme/why-us'],
        ['my-theme/infra'],
        ['my-theme/about'],
        ['my-theme/guide'],
        ['my-theme/consult'],
        ['my-theme/hero-stats'],
        ['my-theme/situations'],
        ['my-theme/process'],
        ['my-theme/cost'],
        ['my-theme/blog-more'],
        ['my-theme/documents'],
        ['my-theme/team'],
        ['my-theme/cases'],
        ['my-theme/programs'],
        ['my-theme/banks'],
        ['my-theme/flagship'],
        ['my-theme/quiz'],
        ['my-theme/blog-section'],
        ['my-theme/service-section'],
        ['my-theme/faq'],
        ['my-theme/reviews-section'],
    ];
}

function theme_is_front_page(WP_Post $post): bool
{
    if ($post->post_type !== 'page') {
        return false;
    }

    $front_page_id = (int) get_option('page_on_front');

    if ($front_page_id && $post->ID === $front_page_id) {
        return true;
    }

    return get_page_template_slug($post) === 'front-page.php';
}

function theme_filter_service_post_type_args(array $args, string $post_type): array
{
    if ($post_type !== 'service') {
        return $args;
    }

    $args['template'] = theme_get_service_single_block_template();
    $args['template_lock'] = false;

    return $args;
}
add_filter('register_post_type_args', 'theme_filter_service_post_type_args', 10, 2);

function theme_filter_blog_post_type_args(array $args, string $post_type): array
{
    if ($post_type !== 'blog') {
        return $args;
    }

    $args['template'] = theme_get_blog_single_block_template();
    $args['template_lock'] = false;

    return $args;
}
add_filter('register_post_type_args', 'theme_filter_blog_post_type_args', 10, 2);

function theme_filter_page_block_editor_settings(array $settings, $context): array
{
    $post = $context->post ?? null;

    if (!$post instanceof WP_Post || $post->post_type !== 'page' || trim($post->post_content) !== '') {
        return $settings;
    }

    if (theme_is_service_archive_page($post)) {
        $settings['template'] = theme_get_service_archive_block_template();
        $settings['templateLock'] = false;
    } elseif (theme_is_blog_archive_page($post)) {
        $settings['template'] = theme_get_blog_archive_block_template();
        $settings['templateLock'] = false;
    } elseif (theme_is_front_page($post)) {
        $settings['template'] = theme_get_front_page_block_template();
        $settings['templateLock'] = false;
    } elseif (theme_is_reviews_page($post)) {
        $settings['template'] = theme_get_reviews_page_block_template();
        $settings['templateLock'] = false;
    }

    return $settings;
}
add_filter('block_editor_settings_all', 'theme_filter_page_block_editor_settings', 10, 2);



