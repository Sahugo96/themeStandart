<?php

defined('ABSPATH') || exit;

$services_slider_data = theme_get_services_slider_data([
    'title'   => isset($attributes['title']) ? $attributes['title'] : '',
    'text'    => isset($attributes['text']) ? $attributes['text'] : '',
    'postIds' => isset($attributes['postIds']) ? $attributes['postIds'] : [],
]);

set_query_var('services_slider_data', $services_slider_data);

$slider_post_ids = $services_slider_data['post_ids'] ?? [];
$posts_per_page = !empty($slider_post_ids) ? -1 : 6;

get_template_part('pages/sections/service-section', null, [
    'section_id'     => 'service_slider_' . wp_unique_id(),
    'taxonomy'       => 'service_cat',
    'post_type'      => 'service',
    'posts_per_page' => $posts_per_page,
]);
