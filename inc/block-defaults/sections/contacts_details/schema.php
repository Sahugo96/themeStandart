<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * «Реквизиты» (contacts_details): пункты реквизитов (HTML) слева, форма справа.
 * Перенесено из tolstenko.marketing (contacts_details); форма — шорткод CF7 из таба.
 */
return array(
	'badge'          => 'Реквизиты',
	'title'          => 'Юридическая <span>информация</span>',
	'items'          => array(
		array( 'text' => '<p><strong>Компания:</strong> ООО «Название»</p>' ),
		array( 'text' => '<p><strong>ИНН / КПП:</strong> 0000000000 / 000000000</p>' ),
		array( 'text' => '<p><strong>ОГРН:</strong> 0000000000000</p>' ),
		array( 'text' => '<p><strong>Юридический адрес:</strong> город, улица, дом</p>' ),
	),
	'form_title'     => 'Свяжитесь с нами',
	'form_text'      => 'Оставьте заявку — мы перезвоним и ответим на вопросы',
	'form_shortcode' => '[contact-form-7 id="a5143be" title="Модалка"]',
);
