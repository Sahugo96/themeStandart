<?php

defined('ABSPATH') || exit;

//Путь до темы
define('THEME_PATH', get_bloginfo('template_url'));
//Версиии стилей и скриптов
define('VERSION', '1.0');
//Текущий язык
$current_lang = 'ru';
if (function_exists('pll_the_languages')) {
$current_lang = pll_current_language();
//Текущий язык
define('LANG', $current_lang);
}
//Sizes для srset
define('SIZES', '((min-width: 300px) and (max-width: 769px)) 30vw, 100vw');