<?php

defined('ABSPATH') || exit;

function theme_get_service_section_data(array $attrs): array
{
    return [
        'title' => ($attrs['title'] ?? '') !== '' ? $attrs['title'] : (theme_get_field('service_section_title', OPTION_ID) ?: ''),
        'text'  => ($attrs['text'] ?? '') !== '' ? $attrs['text'] : (theme_get_field('service_section_text', OPTION_ID) ?: ''),
    ];
}

/**
 * Достаёт ID записей из ACF-поля repeater/relationship.
 *
 * @param mixed $items
 * @return int[]
 */
function theme_extract_post_ids_from_acf_items($items): array
{
    if (!is_array($items) || empty($items)) {
        return [];
    }

    $post_ids = [];

    foreach ($items as $item) {
        if (is_object($item) && isset($item->ID)) {
            $post_ids[] = (int) $item->ID;
        } elseif (is_numeric($item)) {
            $post_ids[] = (int) $item;
        }
    }

    return array_values(array_filter($post_ids));
}

function theme_get_services_slider_data(array $attrs): array
{
    $title = ($attrs['title'] ?? '') !== '' ? $attrs['title'] : (theme_get_field('service_section_title', OPTION_ID) ?: '');
    $text = ($attrs['text'] ?? '') !== '' ? $attrs['text'] : (theme_get_field('service_section_text', OPTION_ID) ?: '');
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    } else {
        $post_ids = theme_extract_post_ids_from_acf_items(theme_get_field('service_section_items', OPTION_ID));
    }

    return [
        'title'    => $title,
        'text'     => $text,
        'post_ids' => $post_ids,
    ];
}

function theme_get_services_slider_simple_data(array $attrs): array
{
    return theme_get_services_slider_data($attrs);
}


function theme_get_blog_slider_data(array $attrs): array
{
    $title = ($attrs['title'] ?? '') !== ''
        ? $attrs['title']
        : (theme_get_field('blog_section_title', OPTION_ID) ?: 'Статьи');
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    }

    return [
        'title'    => $title,
        'post_ids' => $post_ids,
    ];
}

function theme_get_blog_related_data(array $attrs): array
{
    $post_id = get_the_ID() ?: get_queried_object_id();
    $title = ($attrs['title'] ?? '') !== '' ? $attrs['title'] : 'Похожие статьи';
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    } elseif ($post_id && function_exists('get_field')) {
        $post_ids = theme_extract_post_ids_from_acf_items(theme_get_field('blog_articles', $post_id));
    }

    if ($post_id) {
        $post_ids = array_values(array_diff($post_ids, [(int) $post_id]));
    }

    if (empty($post_ids)) {
        $query_args = [
            'post_type'      => 'blog',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'fields'         => 'ids',
        ];

        if ($post_id) {
            $query_args['post__not_in'] = [(int) $post_id];
        }

        $query = new WP_Query($query_args);
        $post_ids = $query->posts;
        wp_reset_postdata();
    }

    return [
        'title'    => $title,
        'post_ids' => $post_ids,
    ];
}


function theme_get_faq_section_data(array $attrs): array
{
    // Дефолты — из админки: tolstenko_get_block_defaults('faq')
    // (таб «Дефолты блоков → FAQ»). Атрибуты блока имеют приоритет.
    $defaults = function_exists('tolstenko_get_block_defaults')
        ? tolstenko_get_block_defaults('faq')
        : [];

    $items = !empty($attrs['items']) && is_array($attrs['items'])
        ? $attrs['items']
        : (is_array($defaults['items'] ?? null) ? $defaults['items'] : []);

    return [
        'badge'       => (string) (($attrs['badge'] ?? '') !== '' ? $attrs['badge'] : ($defaults['badge'] ?? '')),
        'title'       => (string) (($attrs['title'] ?? '') !== '' ? $attrs['title'] : ($defaults['title'] ?? '')),
        'items'       => $items,
        'form_title'  => (string) (($attrs['form_title'] ?? '') !== '' ? $attrs['form_title'] : ($defaults['form_title'] ?? '')),
        'form_text'   => (string) (($attrs['form_text'] ?? '') !== '' ? $attrs['form_text'] : ($defaults['form_text'] ?? '')),
        'teammate_id' => (int) (($attrs['teammate_id'] ?? 0) ?: ($defaults['teammate_id'] ?? 0)),
    ];
}



function theme_block_image_to_attribute($image): array
{
    if (!is_array($image) || empty($image)) {
        return ['id' => 0, 'url' => '', 'alt' => ''];
    }

    $id = (int) ($image['ID'] ?? $image['id'] ?? 0);

    return [
        'id'  => $id,
        'url' => $image['url'] ?? ($id ? (string) wp_get_attachment_url($id) : ''),
        'alt' => $image['alt'] ?? '',
    ];
}

function theme_block_attribute_to_acf_image(?array $image): ?array
{
    if (empty($image) || !is_array($image)) {
        return null;
    }

    $id = (int) ($image['id'] ?? $image['ID'] ?? 0);

    if ($id > 0) {
        $acf_image = function_exists('acf_get_attachment') ? acf_get_attachment($id) : null;

        if (is_array($acf_image) && !empty($acf_image)) {
            return $acf_image;
        }

        return [
            'ID'  => $id,
            'url' => $image['url'] ?? (string) wp_get_attachment_url($id),
            'alt' => $image['alt'] ?? '',
        ];
    }

    if (!empty($image['url'])) {
        return [
            'ID'  => 0,
            'url' => $image['url'],
            'alt' => $image['alt'] ?? '',
        ];
    }

    return null;
}

function theme_block_string_attr(array $attrs, string $key, string $option_key): string
{
    $value = $attrs[$key] ?? '';

    if ($value !== '') {
        return (string) $value;
    }

    return (string) (theme_get_field($option_key, OPTION_ID) ?: '');
}

function theme_block_bool_attr(array $attrs, string $key, string $option_key): bool
{
    if (array_key_exists($key, $attrs) && $attrs[$key] !== '' && $attrs[$key] !== null) {
        return (bool) $attrs[$key];
    }

    $option_value = theme_get_field($option_key, OPTION_ID);

    if ($option_value !== null && $option_value !== '') {
        return (bool) $option_value;
    }

    return false;
}

function theme_block_items_attr(array $attrs, string $key, string $option_key): array
{
    $items = $attrs[$key] ?? null;

    if (is_array($items) && !empty($items)) {
        return $items;
    }

    $option_items = theme_get_field($option_key, OPTION_ID);

    return is_array($option_items) ? $option_items : [];
}

function theme_normalize_block_link($link): array
{
    if (!is_array($link)) {
        return ['url' => '', 'title' => '', 'target' => ''];
    }

    return [
        'url'    => isset($link['url']) ? (string) $link['url'] : '',
        'title'  => isset($link['title']) ? (string) $link['title'] : '',
        'target' => isset($link['target']) ? (string) $link['target'] : '',
    ];
}

function theme_block_link_attr(array $attrs, string $key, string $option_key): array
{
    $override = $attrs[$key] ?? null;

    if (is_array($override) && (!empty($override['url']) || !empty($override['title']))) {
        return theme_normalize_block_link($override);
    }

    return theme_normalize_block_link(theme_get_field($option_key, OPTION_ID));
}

function theme_get_reviews_section_data(array $attrs, $section = null): array
{
    if ($section && $section !== true && !empty($section['reviews_rewrite'])) {
        return [
            'title'             => $section['reviews_title'] ?? '',
            'reviews_list'      => is_array($section['reviews_list'] ?? null) ? $section['reviews_list'] : [],
            'reviews_list_hide' => !empty($section['reviews_list_hide']),
            'reviews'           => is_array($section['reviews_reviews'] ?? null) ? $section['reviews_reviews'] : [],
        ];
    }

    $title = trim((string) ($attrs['title'] ?? ''));
    $tab = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('reviews') : [];
    $tab_title = trim((string) ($tab['title'] ?? ''));
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    }

    $reviews = [];

    if (!empty($post_ids)) {
        foreach ($post_ids as $post_id) {
            $post = get_post($post_id);

            if ($post instanceof WP_Post) {
                $reviews[] = $post;
            }
        }
    } else {
        $fallback = theme_get_field('reviews_review', OPTION_ID);
        $reviews = is_array($fallback) ? $fallback : [];
    }

    return [
        // Заголовок: блок → таб «Отзывы» в дефолтах блоков → ACF-опция.
        'title'             => $title !== '' ? $title : ($tab_title !== '' ? $tab_title : (theme_get_field('reviews_title', OPTION_ID) ?: 'Отзывы')),
        'reviews_list'      => theme_get_field('reviews_list', OPTION_ID) ?: [],
        'reviews_list_hide' => (bool) theme_get_field('reviews_list_hide', OPTION_ID),
        'reviews'           => $reviews,
    ];
}


