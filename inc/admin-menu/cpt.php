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
            'supports' => array('title', 'thumbnail'),
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
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-testimonial',
            'menu_position' => -4,
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'review'),
        )
    );
}




// remove_menu_page('edit-comments.php'); // Удаляет "Комментарии"
// remove_menu_page('edit.php'); // Удаляет "Записи"