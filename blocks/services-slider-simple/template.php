<?php

defined('ABSPATH') || exit;

$services_slider_simple_data = theme_get_services_slider_simple_data([
    'title'   => isset($attributes['title']) ? $attributes['title'] : '',
    'text'    => isset($attributes['text']) ? $attributes['text'] : '',
    'postIds' => isset($attributes['postIds']) ? $attributes['postIds'] : [],
]);

set_query_var('services_slider_simple_data', $services_slider_simple_data);

get_template_part('pages/sections/service-section-simple', null, [
    'section_id' => 'service_slider_simple_' . wp_unique_id(),
]);
