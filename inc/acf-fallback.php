<?php

defined('ABSPATH') || exit;

/**
 * Мягкий фолбэк для Advanced Custom Fields (ACF).
 *
 * Тема построена на ACF: во всех секциях/настройках используется get_field()
 * (200+ вызовов). Если плагин ACF не активен, эти функции не существуют,
 * и любой вызов приводит к «Fatal error: Call to undefined function get_field()».
 *
 * Здесь объявляются безопасные заглушки ТОЛЬКО при отсутствии ACF
 * (проверка function_exists). При активном ACF ничего не переопределяется.
 *
 * ВАЖНО: заглушки лишь предотвращают падение сайта и отдают пустые значения.
 * Для реального контента (секции, «Настройки сайта → дефолты блоков»)
 * плагин Advanced Custom Fields обязателен.
 */

define('TOLSTENKO_ACF_FALLBACK', !function_exists('get_field'));

if (TOLSTENKO_ACF_FALLBACK) {
    /**
     * @param string     $selector
     * @param int|string|false $post_id
     * @param bool       $format_value
     * @return mixed
     */
    function get_field($selector = '', $post_id = false, $format_value = true)
    {
        return null;
    }
}

if (!function_exists('the_field')) {
    function the_field($selector = '', $post_id = false)
    {
        echo '';
    }
}

if (!function_exists('get_fields')) {
    function get_fields($post_id = false, $format_value = true)
    {
        return array();
    }
}

if (!function_exists('get_field_object')) {
    function get_field_object($selector = '', $post_id = false, $format_value = true)
    {
        return false;
    }
}

if (!function_exists('update_field')) {
    function update_field($selector = '', $value = '', $post_id = false)
    {
        return false;
    }
}

if (!function_exists('have_rows')) {
    function have_rows($selector = '', $post_id = false)
    {
        return false;
    }
}

if (!function_exists('the_row')) {
    function the_row()
    {
    }
}

if (!function_exists('get_sub_field')) {
    function get_sub_field($selector = '', $format_value = true)
    {
        return null;
    }
}

if (!function_exists('acf_get_attachment')) {
    function acf_get_attachment($attachment = 0)
    {
        return null;
    }
}

if (!function_exists('acf_add_options_page')) {
    function acf_add_options_page($settings = array())
    {
        return false;
    }
}

if (!function_exists('acf_add_local_field_group')) {
    function acf_add_local_field_group($group = array())
    {
    }
}

// Если ACF отсутствует — сообщаем администратору (в админке).
if (TOLSTENKO_ACF_FALLBACK) {
    add_action('admin_notices', function () {
        if (!function_exists('current_user_can') || !current_user_can('manage_options')) {
            return;
        }

        echo '<div class="notice notice-warning"><p><strong>Tolstenko Theme:</strong> не активен плагин <strong>Advanced Custom Fields (ACF)</strong>. Секции и настройки темы будут пустыми (сейчас работают заглушки). Установите и активируйте ACF.</p></div>';
    });
}
