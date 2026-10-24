<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['guide'] = array(
	'subtitle' => tolstenko_kses_html( $raw['guide']['subtitle'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['guide']['title'] ?? '' ),
	'time' => tolstenko_kses_html( $raw['guide']['time'] ?? '' ),
	'views' => tolstenko_kses_html( $raw['guide']['views'] ?? '' ),
	'date' => sanitize_text_field( $raw['guide']['date'] ?? '' ),
	'date_label' => tolstenko_kses_html( $raw['guide']['date_label'] ?? '' ),
	'card_title' => tolstenko_kses_html( $raw['guide']['card_title'] ?? '' ),
	'text' => tolstenko_kses_html( $raw['guide']['text'] ?? '' ),
	'btn_text' => tolstenko_kses_html( $raw['guide']['btn_text'] ?? '' ),
	'image' => isset( $raw['guide']['image'] ) ? (int) $raw['guide']['image'] : 0,
	'tags' => array(),
	'post_id' => tolstenko_landing_sanitize_post_id( $raw['guide']['post_id'] ?? 0, 'blog' ),
);
if ( isset( $raw['guide']['tags'] ) && is_array( $raw['guide']['tags'] ) ) {
	foreach ( $raw['guide']['tags'] as $it ) {
		if ( ! is_array( $it ) ) { continue; }
		$tag = tolstenko_kses_html( $it['text'] ?? '' );
		if ( $tag === '' ) { continue; }
		$out['guide']['tags'][] = array( 'text' => $tag );
	}
}
