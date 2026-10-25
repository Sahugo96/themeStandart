<?php

defined('ABSPATH') || exit;

/**
 * Блок «Квиз-диагностика» (my-theme/quiz).
 * Значения блока имеют приоритет, пустые берутся из таба «Квиз»
 * (tolstenko_get_block_defaults('quiz')) — см. pages/sections/quiz.php.
 */

$quiz_data = [];

foreach (['badge', 'title', 'text', 'final_thanks', 'final_title', 'final_text', 'form_shortcode', 'btn_text', 'final_note'] as $key) {
    $quiz_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

foreach (['stats', 'steps'] as $key) {
    $quiz_data[$key] = isset($attributes[$key]) && is_array($attributes[$key]) ? $attributes[$key] : [];
}

set_query_var('quiz_data', $quiz_data);

get_template_part('pages/sections/quiz');
