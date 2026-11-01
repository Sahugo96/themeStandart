<?php
/**
 * Язык для архивов, ссылок и запросов «мимо» основного цикла (AJAX, REST, правила URL).
 * Без Polylang всё работает как на одном языке.
 */

defined('ABSPATH') || exit;

/**
 * Slug текущего языка ('' без Polylang).
 */
function theme_current_lang(): string
{
    return function_exists('pll_current_language') ? (string) pll_current_language('slug') : '';
}

/**
 * Slug языка из запроса (REST/AJAX), только из языков сайта.
 */
function theme_request_lang($value): string
{
    $lang = sanitize_key((string) $value);

    if ($lang === '' || !function_exists('pll_languages_list')) {
        return '';
    }

    return in_array($lang, (array) pll_languages_list(['fields' => 'slug']), true) ? $lang : '';
}

/**
 * Главная текущего языка: /ru/ (или / для языка без префикса).
 */
function theme_lang_home_url(): string
{
    return function_exists('pll_home_url') ? (string) pll_home_url() : home_url('/');
}

/**
 * admin-ajax.php с ?lang= — Polylang берёт язык AJAX-запроса из этого параметра
 * (без него — из cookie/браузера, и карточки могут прийти на другом языке).
 */
function theme_ajax_url(): string
{
    $url  = admin_url('admin-ajax.php');
    $lang = theme_current_lang();

    return $lang !== '' ? add_query_arg('lang', $lang, $url) : $url;
}

/**
 * Префиксы URL для правил рубрики: '' и, с Polylang, «{язык}/» её языка.
 *
 * @return string[]
 */
function theme_term_rewrite_prefixes(WP_Term $term): array
{
    $prefixes = [''];

    if (function_exists('pll_get_term_language')) {
        $lang = (string) pll_get_term_language($term->term_id, 'slug');

        if ($lang !== '') {
            $prefixes[] = $lang . '/';
        }
    }

    return $prefixes;
}

/**
 * Все рубрики таксономии на всех языках (для правил URL; Polylang иначе отдаёт только язык админки).
 *
 * @return WP_Term[]
 */
function theme_get_terms_all_langs(string $taxonomy): array
{
    $args = [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ];

    if (function_exists('pll_languages_list')) {
        $args['lang'] = '';
    }

    $terms = get_terms($args);

    return is_wp_error($terms) ? [] : $terms;
}

/**
 * Страница с шаблоном $template на текущем языке: перевод найденной страницы через Polylang.
 * $fallback_id — запасная страница (тоже переводится).
 */
function theme_get_template_page_id(string $template, int $fallback_id = 0): int
{
    $args = [
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => $template,
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ];

    $lang = theme_current_lang();

    if ($lang !== '') {
        $args['lang'] = '';
        $args['suppress_filters'] = false;
    }

    $ids = array_map('intval', (array) get_posts($args));

    if ($fallback_id > 0) {
        $ids[] = $fallback_id;
    }

    if (!$ids) {
        return 0;
    }

    if ($lang === '' || !function_exists('pll_get_post')) {
        return $ids[0];
    }

    foreach ($ids as $id) {
        $translated = (int) pll_get_post($id, $lang);

        if ($translated > 0 && get_post_status($translated) === 'publish') {
            return $translated;
        }
    }

    return $ids[0];
}
