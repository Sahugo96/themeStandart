<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'badge'        => 'Стоимость',
	'title'        => '<span>Сколько стоит</span> решить задачу в ОАЭ',
	'lead'         => 'Точная цена зависит от услуги, программы и объёма сопровождения.<br>Ниже ориентиры.',
	'prices'       => array(
		array( 'name' => 'Банковский счёт', 'value' => '<small>от</small> $ –' ),
		array( 'name' => 'ВНЖ ОАЭ', 'value' => '<small>от</small> $ 6 500' ),
		array( 'name' => 'Компания', 'value' => '<small>от</small> $ –' ),
		array( 'name' => 'Виза фрилансера', 'value' => '<small>от</small> $ 9 500' ),
	),
	'card_title'   => 'Рассчитаем стоимость<br>под вашу задачу',
	'card_text'    => 'Пришлём персональную смету со всеми сопутствующими расходами и сборами — ещё до консультации.',
	'btn_text'     => 'Получить расчёт',
	'btn_url'      => '#modal',
	'image'        => 0,
	'links'        => array(
		array( 'icon_id' => THEME_PATH . '/assets/img/WA Icon.svg', 'title' => 'WhatsApp', 'link' => '#' ),
		array( 'icon_id' => THEME_PATH . '/assets/img/TG Icon.svg', 'title' => 'Telegram', 'link' => '#' ),
	),
);
