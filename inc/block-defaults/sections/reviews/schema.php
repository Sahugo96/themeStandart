<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'subtitle'   => 'Отзывы',
	'title'      => 'Что говорят клиенты',
	'text'       => '',
	'score'      => '4.9',
	'score_max'  => '5',
	'score_text' => 'На основе 300+ отзывов',
	'btn_text'   => 'Оставить отзыв',
	'btn_url'    => '',
	'show_items' => true,
	'ids'        => array(),
	// Карточки площадок (иконку и ссылку задают в табе «Отзывы»).
	'cards'      => array(
		array( 'title' => 'Все отзывы', 'url' => '', 'rating' => '4.9', 'icon' => 0 ),
		array( 'title' => 'Яндекс.Карты', 'url' => '', 'rating' => '5.0', 'icon' => 0 ),
		array( 'title' => 'Google Maps', 'url' => '', 'rating' => '4.8', 'icon' => 0 ),
		array( 'title' => '2 ГИС', 'url' => '', 'rating' => '5.0', 'icon' => 0 ),
	),
);
