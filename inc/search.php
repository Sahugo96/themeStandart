<?php

defined('ABSPATH') || exit;

/**
 * Поиск по сайту (форма в шапке, шаблон search.php).
 *
 * Ищем только по услугам, статьям и кейсам. Результаты на странице
 * разбиты на табы по типу записи, поэтому пагинации нет — берём
 * разумный максимум записей за один запрос.
 */

/**
 * Типы записей в поиске в порядке табов: тип => подпись таба.
 *
 * @return array<string, string>
 */
function theme_search_post_types(): array
{
    return [
        'service' => 'Услуги',
        'blog'    => 'Статьи',
        'case'    => 'Кейсы',
    ];
}

function theme_search_pre_get_posts(WP_Query $query): void
{
    if (is_admin() || !$query->is_main_query() || !$query->is_search()) {
        return;
    }

    $query->set('post_type', array_keys(theme_search_post_types()));
    $query->set('post_status', 'publish');
    $query->set('posts_per_page', 60);
    $query->set('no_found_rows', true);
}
add_action('pre_get_posts', 'theme_search_pre_get_posts');
