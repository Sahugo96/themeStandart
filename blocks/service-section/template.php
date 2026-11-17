<?php

defined('ABSPATH') || exit;

/**
 * Блок «Плитка услуг» (my-theme/service-section). Пустые атрибуты — из таба «Плитка услуг»
 * (tolstenko_get_block_defaults('services_tiles')), см. pages/sections/services-tiles.php.
 */

$services_tiles_data = [];

foreach (['subtitle', 'title', 'text'] as $key) {
    $services_tiles_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

set_query_var('services_tiles_data', $services_tiles_data);

get_template_part('pages/sections/services-tiles');

set_query_var('services_tiles_data', []);
