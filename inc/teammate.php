<?php
/**
 * «Команда» (CPT teammate): выборки и выбор члена команды с учётом языка Polylang.
 *
 * У записей есть свои страницы (/teammate/<slug>/), но тема нигде не ставит на них ссылок.
 * Перевод включается в «Языки → Настройки → Типы записей и таксономии» (галочка «Команда»).
 * Пока перевод выключен — все функции работают как на одном языке.
 *
 * Места использования: секция «Команда» (pages/sections/team.php), карточка в FAQ
 * (pages/sections/faq.php, таб и блок FAQ), авторы статей (inc/blog/authors-admin.php,
 * метабокс статьи), список для блоков в редакторе (inc/blocks/editor-assets.php).
 */

defined('ABSPATH') || exit;

/**
 * Включён ли перевод «Команды» в Polylang.
 */
function theme_teammate_is_translated(): bool
{
    return function_exists('pll_is_translated_post_type') && pll_is_translated_post_type('teammate');
}

/**
 * Опубликованные члены команды на языке $lang (null — текущий язык, '' — все языки).
 *
 * @param array       $args Доп. аргументы get_posts.
 * @param string|null $lang Slug языка.
 * @return WP_Post[]|int[]
 */
function theme_teammate_query(array $args = [], ?string $lang = null): array
{
    $args = array_merge([
        'post_type'      => 'teammate',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'ASC'],
        'no_found_rows'  => true,
    ], $args);

    if (theme_teammate_is_translated()) {
        // Явно: в AJAX, REST (превью блока) и админке Polylang иначе берёт язык из cookie / фильтра админки.
        $args['lang']             = $lang ?? theme_current_lang();
        $args['suppress_filters'] = false;
    }

    return (array) get_posts($args);
}

/**
 * ID члена команды на языке $lang (null — текущий): перевод, если есть.
 * Перевода нет, а запись на другом языке — 0 (вызывающий берёт запасной вариант).
 */
function theme_teammate_id_for_lang(int $teammate_id, ?string $lang = null): int
{
    if ($teammate_id <= 0) {
        return 0;
    }

    if (theme_teammate_is_translated()) {
        $lang = $lang ?? theme_current_lang();

        if ($lang !== '') {
            $translated = (int) pll_get_post($teammate_id, $lang);

            if ($translated > 0) {
                $teammate_id = $translated;
            } else {
                $own = (string) pll_get_post_language($teammate_id, 'slug');

                if ($own !== '' && $own !== $lang) {
                    return 0;
                }
            }
        }
    }

    $post = get_post($teammate_id);

    return ($post instanceof WP_Post && $post->post_type === 'teammate' && $post->post_status === 'publish') ? $teammate_id : 0;
}

/**
 * Первый член команды по порядку на языке $lang (null — текущий).
 */
function theme_teammate_first_id(?string $lang = null): int
{
    $ids = theme_teammate_query(['posts_per_page' => 1, 'fields' => 'ids'], $lang);

    return $ids ? (int) $ids[0] : 0;
}

/**
 * Выбранный член команды на текущем языке, иначе первый по порядку.
 */
function theme_teammate_resolve(int $teammate_id): int
{
    return theme_teammate_id_for_lang($teammate_id) ?: theme_teammate_first_id();
}

/**
 * Отображаемое имя: поле «Имя», иначе заголовок записи.
 */
function theme_teammate_name(int $teammate_id): string
{
    $name = trim((string) get_post_meta($teammate_id, 'teammate_name', true));

    return $name !== '' ? $name : trim(wp_strip_all_tags(get_the_title($teammate_id)));
}

/**
 * Варианты для селектов в админке: ID => имя, на языке $lang ('' — все языки).
 *
 * @return array<int,string>
 */
function theme_teammate_choices(string $lang = ''): array
{
    $out = [];

    foreach (theme_teammate_query(['fields' => 'ids'], $lang) as $id) {
        $out[(int) $id] = theme_teammate_name((int) $id);
    }

    return $out;
}

/**
 * Основной язык настроек ('' без Polylang) — для общих (не переводимых) выборов в табах.
 * Совпадает с языком общих опций (inc/settings-i18n.php), а не с языком по умолчанию Polylang.
 */
function theme_teammate_default_lang(): string
{
    if (function_exists('theme_settings_default_lang')) {
        return theme_settings_default_lang();
    }

    return function_exists('pll_default_language') ? (string) pll_default_language('slug') : '';
}

/**
 * Перевод статьи / страницы документа: автор (член команды) копируется переводом на язык копии.
 * Polylang вызывает фильтр при копировании мета-полей в перевод.
 */
add_filter('pll_translate_post_meta', 'theme_teammate_translate_author_meta', 10, 3);
function theme_teammate_translate_author_meta($value, $key, $lang)
{
    if ($key !== 'blog_author_id' || !is_numeric($value) || !theme_teammate_is_translated()) {
        return $value;
    }

    $translated = (int) pll_get_post((int) $value, (string) $lang);

    return $translated > 0 ? $translated : $value;
}
