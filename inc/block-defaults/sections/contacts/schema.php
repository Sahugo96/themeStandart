<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * «Контакты» (contacts): адреса-вкладки, у каждого — контакты (заголовок, иконка, строки-ссылки)
 * и галерея фото офиса. Кнопки «Позвонить» / «Telegram» — номер и ссылка из «Контактных данных».
 * Перенесено из tolstenko.marketing (contacts_page).
 */
return array(
	'badge'     => 'Контакты',
	'title'     => 'Свяжитесь <span>с нами</span>',
	'call_text' => 'Позвонить сейчас',
	'tg_text'   => 'Написать в Telegram',
	'addresses' => array(
		array(
			'address' => 'Дубай',
			'items'   => array(
				array(
					'title' => 'Адрес',
					'icon'  => 0,
					'links' => array( array( 'text' => 'Дубай, Business Bay', 'link' => '' ) ),
				),
				array(
					'title' => 'Телефон',
					'icon'  => 0,
					'links' => array( array( 'text' => '+971 00 000 00 00', 'link' => 'tel:+971000000000' ) ),
				),
				array(
					'title' => 'Почта',
					'icon'  => 0,
					'links' => array( array( 'text' => 'info@example.com', 'link' => 'mailto:info@example.com' ) ),
				),
				array(
					'title' => 'Время работы',
					'icon'  => 0,
					'links' => array( array( 'text' => 'Пн–Пт: 9:00–18:00', 'link' => '' ) ),
				),
			),
			'gallery' => array(),
		),
	),
);
