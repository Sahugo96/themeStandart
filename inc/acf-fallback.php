<?php

defined('ABSPATH') || exit;

/**
 * Безопасный доступ к Advanced Custom Fields (ACF).
 *
 * Тема читает поля только через theme_get_field(), а не через get_field()
 * напрямую. Обёртка проверяет наличие ACF в момент вызова:
 * - ACF активен — возвращает get_field();
 * - ACF не активен — возвращает null, сайт не падает с
 *   «Call to undefined function get_field()».
 *
 * Глобальные заглушки get_field() и т.п. тема НЕ объявляет: иначе при
 * активации ACF (плагин подключается уже после темы) возникает
 * «Cannot redeclare get_field()», и ACF не активируется.
 */

/**
 * @param string           $selector
 * @param int|string|false $post_id
 * @param bool             $format_value
 * @return mixed
 */
function theme_get_field($selector, $post_id = false, $format_value = true)
{
    if (!function_exists('get_field')) {
        return null;
    }

    return get_field($selector, $post_id, $format_value);
}

// Если ACF отсутствует — сообщаем администратору (в админке).
add_action('admin_notices', function () {
    if (function_exists('get_field') || !current_user_can('manage_options')) {
        return;
    }

    echo '<div class="notice notice-warning"><p><strong>Tolstenko Theme:</strong> не активен плагин <strong>Advanced Custom Fields (ACF)</strong>. Поля, которые хранятся в ACF, будут пустыми. Установите и активируйте ACF.</p></div>';
});
