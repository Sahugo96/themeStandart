<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['quiz'] = array(
	'badge'          => tolstenko_kses_html( $raw['quiz']['badge'] ?? '' ),
	'title'          => tolstenko_kses_html( $raw['quiz']['title'] ?? '' ),
	'text'           => tolstenko_kses_html( $raw['quiz']['text'] ?? '' ),
	'stats'          => array(),
	'steps'          => array(),
	'final_thanks'   => tolstenko_kses_html( $raw['quiz']['final_thanks'] ?? '' ),
	'final_title'    => tolstenko_kses_html( $raw['quiz']['final_title'] ?? '' ),
	'final_text'     => tolstenko_kses_html( $raw['quiz']['final_text'] ?? '' ),
	'form_shortcode' => sanitize_text_field( $raw['quiz']['form_shortcode'] ?? '' ),
	'btn_text'       => sanitize_text_field( $raw['quiz']['btn_text'] ?? '' ),
	'final_note'     => tolstenko_kses_html( $raw['quiz']['final_note'] ?? '' ),
);

// Цифры под текстом (1 мин / на прохождение).
foreach ( (array) ( $raw['quiz']['stats'] ?? array() ) as $it ) {
	if ( ! is_array( $it ) ) {
		continue;
	}
	$stat_value = sanitize_text_field( $it['value'] ?? '' );
	$stat_label = sanitize_text_field( $it['label'] ?? '' );
	if ( $stat_value === '' && $stat_label === '' ) {
		continue;
	}
	$out['quiz']['stats'][] = array(
		'value' => $stat_value,
		'label' => $stat_label,
	);
}

// Шаги: вопрос + вложенный повторитель вариантов ответа.
foreach ( (array) ( $raw['quiz']['steps'] ?? array() ) as $it ) {
	if ( ! is_array( $it ) ) {
		continue;
	}

	$question = sanitize_text_field( $it['question'] ?? '' );
	$options  = array();
	foreach ( (array) ( $it['options'] ?? array() ) as $option ) {
		$option_text = sanitize_text_field( is_array( $option ) ? ( $option['text'] ?? '' ) : '' );
		if ( $option_text !== '' ) {
			$options[] = array( 'text' => $option_text );
		}
	}

	if ( $question === '' || empty( $options ) ) {
		continue;
	}

	$out['quiz']['steps'][] = array(
		'question' => $question,
		'options'  => $options,
	);
}
