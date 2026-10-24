<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'badge' => 'Сравнение программ',
	'title' => '<span>ВНЖ ОАЭ</span> и популярная альтернатива',
	'lead'  => 'Подбираем банк под ваш профиль. Ниже — стоимость и срок открытия.<br>Точный список готовим индивидуально.',
	'columns' => array(
		array( 'name' => 'Категория', 'flag' => 0, 'accent' => '' ),
		array( 'name' => 'ОАЭ', 'flag' => 0, 'accent' => '1' ),
		array( 'name' => 'Испания', 'flag' => 0, 'accent' => '' ),
		array( 'name' => 'Португалия', 'flag' => 0, 'accent' => '' ),
		array( 'name' => 'Мальта', 'flag' => 0, 'accent' => '' ),
	),
	'rows' => array(
		array( 'criterion' => 'Срок оформления', 'values' => "от 2 недель\n1,5 месяца\nот 6 мес\nот 2 мес" ),
		array( 'criterion' => 'Стоимость', 'values' => "от 3 000 $\nот 3 000 €\nот 250 000 €\nот 150 000 €" ),
		array( 'criterion' => 'Налог на мировой доход', 'values' => "0%\nот 19%\nот 20%\nот 15%" ),
		array( 'criterion' => 'Налог на наследство', 'values' => "0%\nот 7,65%\n10%\n0%" ),
		array( 'criterion' => 'Требование проживания', 'values' => "Не требуется\nЕсть\nМинимальное\nМинимальное" ),
	),
	'btn_text' => 'Открыть ВНЖ в ОАЭ',
	'btn_url'  => '#modal',
);
