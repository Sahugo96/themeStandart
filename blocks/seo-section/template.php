<?php

defined('ABSPATH') || exit;

/**
 * Блок «SEO-наполнение» (my-theme/seo-section). Пустые атрибуты — из таба
 * «Дефолты блоков → SEO-наполнение», см. pages/sections/seo-section.php.
 */

$seo_section_data = [];

foreach (['badge', 'title', 'more_text'] as $key) {
    $seo_section_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

// Блок со строками без содержимого не перекрывает таб.
$rows = isset($attributes['rows']) && is_array($attributes['rows']) ? $attributes['rows'] : [];
$seo_section_data['rows'] = theme_seo_section_normalize_rows($rows) ? $rows : [];

set_query_var('seo_section_data', $seo_section_data);

get_template_part('pages/sections/seo-section');

set_query_var('seo_section_data', []);
