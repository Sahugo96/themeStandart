<?php
// Глобальные переменные
require_once(dirname(__FILE__) . '/inc/consts.php');
// Фолбэк ACF (если плагин ACF не активен — не даём сайту упасть)
require_once(dirname(__FILE__) . '/inc/acf-fallback.php');
// Мета-поля члена команды (CPT teammate) без ACF
require_once(dirname(__FILE__) . '/inc/teammate-meta-boxes.php');
//Подключение стиоей и скриптов
require_once(dirname(__FILE__) . '/inc/enqueue.php');
//Базовые настройки
require_once(dirname(__FILE__) . '/inc/base.php');
//svg-fix
require_once(dirname(__FILE__) . '/inc/svg-fix.php');

// Очистка HTML-контента (kses-хелперы)
require_once(dirname(__FILE__) . '/inc/kses.php');

define('OPTION_ID', 63);

//Атрибуты изображений
require_once(dirname(__FILE__) . '/inc/get/Image.php');
//Атрибуты
require_once(dirname(__FILE__) . '/inc/get/Get.php');

//Отключаем автовывод Reading Time WP
require_once __DIR__ . '/inc/reading-time-acf.php';

// Отключаем автовывод просмотров и лайков в конце статьи блога
require_once __DIR__ . '/inc/blog-plugins-display.php';


require_once get_template_directory() . '/inc/admin-menu/cpt.php';
require_once get_template_directory() . '/inc/settings-i18n.php';
require_once get_template_directory() . '/inc/block-defaults-admin.php';
require_once get_template_directory() . '/inc/contact-data-admin.php';
require_once get_template_directory() . '/inc/case-metabox.php';
require_once get_template_directory() . '/inc/review-metabox.php';
require_once get_template_directory() . '/inc/blog-metabox.php';
require_once get_template_directory() . '/inc/service-metabox.php';
require_once get_template_directory() . '/inc/primary-term-metabox.php';
require_once get_template_directory() . '/inc/blog/allowed-blocks.php';
// Статьи: хелперы, авторы, метабокс, блоки тела, комментарии с модерацией
require_once get_template_directory() . '/inc/blog/helpers.php';
require_once get_template_directory() . '/inc/blog/authors-admin.php';
require_once get_template_directory() . '/inc/blog/metabox.php';
require_once get_template_directory() . '/inc/blog/content-blocks.php';
require_once get_template_directory() . '/inc/blog/comment-queue.php';
require_once get_template_directory() . '/inc/blog/grid.php';




require_once __DIR__ . '/inc/rewrite/primary-term-permalinks.php';
require_once __DIR__ . '/inc/rewrite/blog-rewrite.php';
require_once __DIR__ . '/inc/rewrite/service-rewrite.php';
require_once __DIR__ . '/inc/cf7/custom-elements.php';
require_once __DIR__ . '/inc/cf7/quiz-answers.php';

require_once __DIR__ . '/inc/ajax/blog-section.php';
require_once __DIR__ . '/inc/ajax/service-section.php';
require_once __DIR__ . '/inc/ajax/case-section.php';
require_once __DIR__ . '/inc/ajax/services-slider.php';

require_once __DIR__ . '/inc/ajax/blog-page.php';

require_once __DIR__ . '/inc/blocks.php';
require_once __DIR__ . '/inc/search.php';
