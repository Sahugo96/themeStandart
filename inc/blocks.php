<?php

defined('ABSPATH') || exit;

define('THEME_BLOCKS_NAMESPACE', 'my-theme');
define('THEME_BLOCKS_CATEGORY', 'tolstenko-general');

// Код блоков разнесён по файлам в inc/blocks/.
// Порядок подключения повторяет порядок кода в прежнем файле
// (важно для фильтров на одном хуке, например block_editor_settings_all).
require_once __DIR__ . '/blocks/registration.php';
require_once __DIR__ . '/blocks/page-templates.php';
require_once __DIR__ . '/blocks/pages.php';
require_once __DIR__ . '/blocks/section-data.php';
require_once __DIR__ . '/blocks/editor-config.php';
require_once __DIR__ . '/blocks/editor-assets.php';
require_once __DIR__ . '/blocks/front-sections.php';
