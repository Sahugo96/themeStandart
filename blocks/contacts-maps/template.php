<?php

defined('ABSPATH') || exit;

/**
 * Блок «Карты» (my-theme/contacts-maps). Пустые атрибуты — из таба «Карты»,
 * см. pages/sections/contacts-maps.php.
 */

$contacts_maps_data = [];

foreach (['badge', 'title'] as $key) {
    $contacts_maps_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

// Адреса без содержимого не перекрывают таб.
$items = isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [];
$contacts_maps_data['items'] = theme_contacts_normalize_maps($items) ? $items : [];

set_query_var('contacts_maps_data', $contacts_maps_data);

get_template_part('pages/sections/contacts-maps');

set_query_var('contacts_maps_data', []);
