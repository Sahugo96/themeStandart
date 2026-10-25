<?php

defined('ABSPATH') || exit;

/**
 * Блок «Флагманские программы» (my-theme/flagship).
 * Значения блока имеют приоритет, пустые берутся из таба «Флагманские программы»
 * (tolstenko_get_block_defaults('flagship')) — см. pages/sections/flagship.php.
 */

$flagship_data = [];

foreach (['badge', 'title', 'table_title', 'col_country', 'col_price', 'col_term', 'col_benefits', 'row_btn_text', 'foot_text', 'btn_text', 'btn_url'] as $key) {
    $flagship_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

foreach (['cards', 'links', 'rows'] as $key) {
    $flagship_data[$key] = isset($attributes[$key]) && is_array($attributes[$key]) ? $attributes[$key] : [];
}

set_query_var('flagship_data', $flagship_data);

get_template_part('pages/sections/flagship');
