<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Дефолты блоков: схема, API, страница настроек и сохранение.
 * Код разнесён по файлам в inc/block-defaults/.
 */
require_once __DIR__ . '/block-defaults/sections.php';
require_once __DIR__ . '/block-defaults/schema.php';
require_once __DIR__ . '/block-defaults/helpers.php';
require_once __DIR__ . '/block-defaults/api.php';
require_once __DIR__ . '/block-defaults/admin-page.php';
require_once __DIR__ . '/block-defaults/save.php';
