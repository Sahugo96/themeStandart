<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'enabled'       => false,
	'text_field'     => '',
	'textarea_field' => '',
	'editor_field'   => '<p>Пример текста в визуальном редакторе.</p>',
	'image'          => 0,
	'post_ids'       => array(),
	'single_post_id' => 0,
	'items'          => array(
		array(
			'title'    => 'Пример пункта повторителя',
			'text'     => 'Текстовая область внутри пункта.',
		),
	),
);
