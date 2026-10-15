<?php

defined('ABSPATH') || exit;

/**
 * ACF — обязательная зависимость темы.
 *
 * Тема построена на Advanced Custom Fields: get_field() вызывается в секциях,
 * шаблонах и настройках (200+ вызовов).
 *
 * ВАЖНО: этот файл НЕ объявляет заглушки get_field()/the_field()/get_fields()/
 * acf_*() — иначе плагин Advanced Custom Fields не сможет активироваться:
 * ACF объявляет свои функции без проверки function_exists(), и появляется
 * «Fatal error: Cannot redeclare get_field()».
 *
 * Вместо заглушек показываем администратору уведомление, что нужен ACF.
 */

add_action('admin_notices', 'tolstenko_acf_required_notice');

/**
 * Уведомление в админке, если ACF не активен.
 *
 * Проверяем наличие функции в момент вывода (плагины уже загружены),
 * ничего не объявляя.
 *
 * @return void
 */
function tolstenko_acf_required_notice(): void
{
    if (function_exists('get_field')) {
        return;
    }

    if (!function_exists('current_user_can') || !current_user_can('manage_options')) {
        return;
    }

    // Не мешаем на экранах активации/установки плагинов.
    if (function_exists('get_current_screen')) {
        $screen = get_current_screen();

        if ($screen && isset($screen->id) && in_array($screen->id, array('plugins', 'plugin-install', 'update', 'update-core'), true)) {
            return;
        }
    }

    echo '<div class="notice notice-warning"><p><strong>Tolstenko Theme:</strong> требуется плагин <strong>Advanced Custom Fields (ACF)</strong>. Без него секции и настройки темы будут пустыми. Установите и активируйте ACF.</p></div>';
}
