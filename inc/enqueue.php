<?php

defined('ABSPATH') || exit;

// Отключение эмодзи
function disable_wp_emojicons() {
    // Удаление всех действий, связанных с эмодзи
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // Удаление плагина эмодзи из TinyMCE
    add_filter('tiny_mce_plugins', function ($plugins) {
        return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
    });
}
add_action('init', 'disable_wp_emojicons');

// Отключение ненужных стилей и добавление пользовательских
function theme_enqueue_scripts() {
    // Удаление ненужных стилей
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('wp-emoji-styles');
    wp_dequeue_style('global-styles');

    // Добавление пользовательских стилей
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.min.css', [], VERSION);

    // Добавление пользовательских скриптов (если требуется)
    // wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/app.js', [], VERSION, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Локализация данных для JS
function output_localized_data() {
    $localized_data = [
        'ajax_url' => admin_url('admin-ajax.php'),
    ];

    echo '<script>';
    echo 'var ajax_params = ' . json_encode($localized_data) . ';';
    echo '</script>';
}
add_action('wp_footer', 'output_localized_data');
