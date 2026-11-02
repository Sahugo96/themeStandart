<?php

add_action('init', 'register_blog_cpt');
function register_blog_cpt()
{
    register_post_type(
        'blog',
        array(
            'labels' => array(
                'name' => 'Статьи',
                'singular_name' => 'Статья',
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-welcome-write-blog',
            'menu_position' => -4,
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'blog'),
        )
    );
}

add_action('init', 'register_service_cpt');
function register_service_cpt()
{
    register_post_type(
        'service',
        array(
            'labels' => array(
                'name' => 'Услуги',
                'singular_name' => 'Услуга',
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-admin-page',
            'menu_position' => -4,
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'service'),
        )
    );

    // Категории услуг — по образцу «Категорий кейсов». Если таксономию уже
    // регистрирует плагин, не перезаписываем её. URL рубрик — inc/rewrite/service-rewrite.php.
    if (!taxonomy_exists('service_cat')) {
        register_taxonomy(
            'service_cat',
            array('service'),
            array(
                'labels' => array(
                    'name' => 'Категории услуг',
                    'singular_name' => 'Категория услуги',
                    'menu_name' => 'Категории услуг',
                    'all_items' => 'Все категории',
                    'add_new_item' => 'Добавить категорию',
                    'edit_item' => 'Редактировать категорию',
                ),
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_rest' => true,
                'hierarchical' => true,
                'rewrite' => array('slug' => 'service'),
            )
        );
    }
}



// Кейсы: CPT + таксономия для AJAX-фильтра
add_action('init', 'register_case_cpt');
function register_case_cpt()
{
    register_post_type(
        'case',
        array(
            'labels' => array(
                'name' => 'Кейсы',
                'singular_name' => 'Кейс',
                'add_new' => 'Добавить',
                'add_new_item' => 'Добавить кейс',
                'edit_item' => 'Редактировать',
                'all_items' => 'Все кейсы',
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-awards',
            'menu_position' => -4,
            // Без «Изображения записи»: карточка кейса выводит только текст и иконки фактов.
            'supports' => array('title'),
            'show_in_rest' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'cases'),
        )
    );

    register_taxonomy(
        'case_cat',
        array('case'),
        array(
            'labels' => array(
                'name' => 'Категории кейсов',
                'singular_name' => 'Категория кейса',
            ),
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'hierarchical' => true,
            'rewrite' => array('slug' => 'cases'),
        )
    );
}

// Члены команды: без собственной страницы, только поля.
add_action('init', 'register_teammate_cpt');
function register_teammate_cpt()
{
    register_post_type(
        'teammate',
        array(
            'labels' => array(
                'name' => 'Команда',
                'singular_name' => 'Член команды',
                'add_new' => 'Добавить',
                'add_new_item' => 'Добавить члена команды',
                'edit_item' => 'Редактировать',
                'all_items' => 'Все члены команды',
            ),
            'public' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-groups',
            'menu_position' => -4,
            'supports' => array('title'),
            'show_in_rest' => true,
            'has_archive' => false,
            'rewrite' => false,
        )
    );
}

add_action('admin_init', function () {
    remove_meta_box('slugdiv', 'service', 'normal');
    remove_meta_box('slugdiv', 'blog', 'normal');
    remove_meta_box('slugdiv', 'teammate', 'normal');
    remove_meta_box('slugdiv', 'case', 'normal');
});

add_action('init', 'register_review_cpt');
function register_review_cpt()
{
    register_post_type(
        'review',
        array(
            'labels' => array(
                'name' => 'Отзывы',
                'singular_name' => 'Отзыв',
                'add_new' => 'Добавить',
                'add_new_item' => 'Добавить отзыв',
                'edit_item' => 'Редактировать',
                'all_items' => 'Все отзывы',
            ),
            // Отзывы выводятся карточками на странице с шаблоном «Reviews page» и в секциях:
            // своих страниц и архива у них нет (иначе /review/… — пустые индексируемые URL).
            // public оставлен: по нему Polylang предлагает переводить тип записей.
            'public' => true,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-testimonial',
            'menu_position' => -4,
            // Без «Изображения записи»: карточка отзыва его не выводит.
            'supports' => array('title', 'editor'),
            'has_archive' => false,
            'rewrite' => false,
        )
    );
}

// Один раз сбросить правила URL после отключения архива отзывов (/review/…).
add_action('init', function () {
    if (get_option('theme_review_cpt_rewrite') !== '2') {
        flush_rewrite_rules(false);
        update_option('theme_review_cpt_rewrite', '2', false);
    }
}, 99);

// Старые адреса /review/ и /review/<отзыв>/ → страница отзывов (301), если она есть.
add_action('template_redirect', function () {
    if (!is_404()) {
        return;
    }

    $path = trim((string) wp_parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');

    if (!preg_match('#(^|/)review(/|$)#', $path)) {
        return;
    }

    $page_id = function_exists('theme_get_template_page_id') ? theme_get_template_page_id('page-reviews.php') : 0;

    if ($page_id) {
        wp_safe_redirect((string) get_permalink($page_id), 301);
        exit;
    }
});




// remove_menu_page('edit-comments.php'); // Удаляет "Комментарии"
// remove_menu_page('edit.php'); // Удаляет "Записи"