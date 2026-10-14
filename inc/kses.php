<?php
defined('ABSPATH') || exit;

/**
 * КСЕС-очистка HTML для текстовых полей и содержимого блоков:
 * тайтлов, текстов, областей, повторителей (примеры, FAQ-ответы, дефолтные данные блоков).
 *
 * Разрешает валидные HTML-теги по умолчанию (набор wp_kses_post).
 *
 * @param string $string Исходная строка.
 * @return string Очищенная строка.
 */
function tolstenko_kses_html( $string ) {
	return wp_kses_post( (string) $string );
}

/**
 * КСЕС-очистка для Rich-редактора (TinyMCE / Redactor):
 * текстовые и блочные элементы, ссылки с атрибутами, изображения, списки.
 *
 * @param string $string Исходная строка.
 * @return string Очищенная строка.
 */
function tolstenko_kses_redactor( $string ) {
	$allowed = array(
		// Инлайновые теги
		'a'          => array( 'href' => true, 'title' => true, 'target' => true, 'rel' => true ),
		'abbr'       => array( 'title' => true ),
		'acronym'    => array( 'title' => true ),
		'b'          => array(),
		'bdo'        => array(),
		'blockquote' => array( 'cite' => true ),
		'br'         => array(),
		'cite'       => array(),
		'code'       => array(),
		'del'        => array( 'datetime' => true, 'cite' => true ),
		'dfn'        => array(),
		'em'         => array(),
		'i'          => array(),
		'img'        => array( 'src' => true, 'alt' => true, 'title' => true, 'width' => true, 'height' => true ),
		'ins'        => array( 'datetime' => true ),
		'kbd'        => array(),
		'q'          => array( 'cite' => true ),
		's'          => array(),
		'samp'       => array(),
		'small'      => array(),
		'span'       => array( 'style' => true, 'class' => true ),
		'strike'     => array(),
		'strong'     => array(),
		'sub'        => array(),
		'sup'        => array(),
		'u'          => array(),
		'var'        => array(),
		// Блочные теги
		'p'          => array(),
		'pre'        => array(),
		'h1'         => array(), 'h2'         => array(), 'h3'         => array(),
		'h4'         => array(), 'h5'         => array(), 'h6'         => array(),
		'hr'         => array(),
		'ul'         => array(), 'ol'         => array(), 'li'         => array(),
		'dl'         => array(), 'dt'         => array(), 'dd'         => array(),
		'div'        => array( 'class' => true, 'style' => true ),
		'table'      => array( 'border' => true, 'cellpadding' => true, 'cellspacing' => true ),
		'thead'      => array(), 'tbody'      => array(), 'tfoot'      => array(),
		'tr'         => array(), 'th'         => array(), 'td'         => array(),
		'caption'    => array(),
		'figure'     => array(), 'figcaption' => array(),
	);

	return wp_kses( (string) $string, $allowed );
}
