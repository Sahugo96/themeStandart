<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gl_raw = is_array( $raw['goals'] ?? null ) ? $raw['goals'] : array();

$out['goals'] = array(
	'badge' => sanitize_text_field( $gl_raw['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $gl_raw['title'] ?? '' ),
	'text'  => tolstenko_kses_html( $gl_raw['text'] ?? '' ),
	'items' => array(),
);

foreach ( (array) ( $gl_raw['items'] ?? array() ) as $it ) {
	if ( ! is_array( $it ) ) {
		continue;
	}
	$row = array(
		'icon'  => (int) ( $it['icon'] ?? 0 ),
		'title' => tolstenko_kses_html( $it['title'] ?? '' ),
		'text'  => tolstenko_kses_html( $it['text'] ?? '' ),
	);
	if ( $row['title'] === '' && trim( wp_strip_all_tags( $row['text'] ) ) === '' && $row['icon'] <= 0 ) {
		continue;
	}
	$out['goals']['items'][] = $row;
}
