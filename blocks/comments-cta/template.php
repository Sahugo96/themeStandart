<?php

defined('ABSPATH') || exit;

/**
 * Блок «Это ещё не конец» (my-theme/comments-cta). Пустые атрибуты — из таба
 * «Это ещё не конец», см. pages/sections/comments-cta.php.
 */

$comments_cta_data = [];

foreach (['title', 'text', 'btn_text', 'btn_url'] as $key) {
    $comments_cta_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

set_query_var('comments_cta_data', $comments_cta_data);

get_template_part('pages/sections/comments-cta');

set_query_var('comments_cta_data', []);
