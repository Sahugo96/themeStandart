<?php

defined('ABSPATH') || exit;

/**
 * Блок «С какой целью нужен ВНЖ» (my-theme/goals). Пустые атрибуты — из таба
 * «С какой целью нужен ВНЖ», см. pages/sections/goals.php.
 */

$goals_data = [];

foreach (['badge', 'title', 'text'] as $key) {
    $goals_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

// Пункты без заголовка и текста не перекрывают таб.
$items = isset($attributes['items']) && is_array($attributes['items']) ? $attributes['items'] : [];
$has_items = (bool) array_filter($items, static function ($item) {
    return is_array($item) && (trim((string) ($item['title'] ?? '')) !== '' || trim((string) ($item['text'] ?? '')) !== '');
});
$goals_data['items'] = $has_items ? $items : [];

set_query_var('goals_data', $goals_data);

get_template_part('pages/sections/goals');

set_query_var('goals_data', []);
