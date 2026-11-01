<?php

defined('ABSPATH') || exit;

/**
 * Блок «Реквизиты» (my-theme/contacts-details). Пустые атрибуты — из таба «Реквизиты»
 * (там же шорткод формы), см. pages/sections/contacts-details.php.
 */

$contacts_details_data = [];

foreach (['badge', 'title', 'form_title', 'form_text'] as $key) {
    $contacts_details_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

// Пустые пункты не перекрывают таб.
$items = isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [];
$contacts_details_data['items'] = theme_contacts_normalize_details($items) ? $items : [];

set_query_var('contacts_details_data', $contacts_details_data);

get_template_part('pages/sections/contacts-details');

set_query_var('contacts_details_data', []);
