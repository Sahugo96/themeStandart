<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * «Карты» (contacts_maps): адреса-вкладки, у каждого — карта (iframe Яндекс/Google/OSM
 * или ссылка на такую карту). Перенесено из tolstenko.marketing (contacts_maps).
 */
return array(
	'badge' => 'Как добраться',
	'title' => 'Мы <span>на карте</span>',
	'items' => array(
		array(
			'address' => 'Дубай',
			'map'     => '',
		),
	),
);
