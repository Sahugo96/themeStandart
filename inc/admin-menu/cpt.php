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

add_action('admin_init', function () {
    remove_meta_box('slugdiv', 'service', 'normal');
    remove_meta_box('slugdiv', 'blog', 'normal');
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