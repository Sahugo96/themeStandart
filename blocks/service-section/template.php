<?php

defined('ABSPATH') || exit;

$service_section_data = theme_get_service_section_data([
    'title' => isset($attributes['title']) ? $attributes['title'] : '',
    'text'  => isset($attributes['text']) ? $attributes['text'] : '',
]);

set_query_var('service_section_data', $service_section_data);

get_template_part('pages/services/sections/service-section', null, [
    'section_id' => 'main_service_' . wp_unique_id(),
    'taxonomy'   => 'service_cat',
    'post_type'  => 'service',
]);
