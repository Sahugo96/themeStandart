<?php
// Глобальные переменные
require_once(dirname(__FILE__) . '/inc/consts.php');
// ACF — обязательная зависимость (без заглушек, чтобы ACF мог активироваться)
require_once(dirname(__FILE__) . '/inc/acf-required.php');
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
require_once get_template_directory() . '/inc/block-defaults-admin.php';
require_once get_template_directory() . '/inc/contact-data-admin.php';
require_once get_template_directory() . '/inc/blog/allowed-blocks.php';




require_once __DIR__ . '/inc/rewrite/primary-term-permalinks.php';
require_once __DIR__ . '/inc/rewrite/blog-rewrite.php';
require_once __DIR__ . '/inc/rewrite/service-rewrite.php';
require_once __DIR__ . '/inc/cf7/custom-elements.php';

require_once __DIR__ . '/inc/ajax/blog-section.php';
require_once __DIR__ . '/inc/ajax/service-section.php';

require_once __DIR__ . '/inc/ajax/blog-page.php';

require_once __DIR__ . '/inc/blocks.php';
