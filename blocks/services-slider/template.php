<?php

defined('ABSPATH') || exit;

/**
 * Блок «Слайдер услуг» (my-theme/services-slider).
 * Значения блока имеют приоритет, пустые берутся из таба «Слайдер услуг (фильтры)»
 * (tolstenko_get_block_defaults('service_section_filters')) — см. pages/sections/services-slider.php.
 */

set_query_var('services_slider_data', [
    'subtitle' => isset($attributes['subtitle']) ? (string) $attributes['subtitle'] : '',
    'title'    => isset($attributes['title']) ? (string) $attributes['title'] : '',
    'text'     => isset($attributes['text']) ? (string) $attributes['text'] : '',
    'ids'      => isset($attributes['postIds']) && is_array($attributes['postIds']) ? $attributes['postIds'] : [],
]);

get_template_part('pages/sections/services-slider');
