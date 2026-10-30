<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * «SEO-наполнение» (seo_section). Перенесено из tolstenko.marketing («SEO продвижение»).
 * rows — гибкое содержимое; layout: text | image_text | text_image | two_columns | gallery.
 */
return array(
	'badge'     => 'Полезно знать',
	'title'     => 'Подробнее <span>об услуге</span>',
	'more_text' => 'Читать далее',
	'rows'      => array(
		array(
			'layout'   => 'text',
			'title'    => '',
			'image'    => 0,
			'text'     => '<p>SEO-текст секции. Заполните его в «Дефолтах блоков → SEO-наполнение» или в блоке на странице.</p>',
			'text_2'   => '',
			'items'    => array(),
			'gallery'  => array(),
			'btn_text' => '',
			'btn_url'  => '',
		),
	),
);
