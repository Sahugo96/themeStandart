<?php

defined('ABSPATH') || exit;

/**
 * Блок «Контакты» (my-theme/contacts). Пустые атрибуты — из таба «Контакты»,
 * см. pages/sections/contacts.php.
 */

$contacts_data = [];

foreach (['badge', 'title', 'call_text', 'tg_text'] as $key) {
    $contacts_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

// Адреса без содержимого не перекрывают таб.
$addresses = isset($attributes['addresses']) && is_array($attributes['addresses']) ? $attributes['addresses'] : [];
$contacts_data['addresses'] = theme_contacts_normalize_addresses($addresses) ? $addresses : [];

set_query_var('contacts_data', $contacts_data);

get_template_part('pages/sections/contacts');

set_query_var('contacts_data', []);
