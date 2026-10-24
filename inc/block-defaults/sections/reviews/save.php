<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['reviews'] = array(
	'subtitle'   => tolstenko_kses_html( $raw['reviews']['subtitle'] ?? '' ),
	'title'      => tolstenko_kses_html( $raw['reviews']['title'] ?? '' ),
	'text'       => tolstenko_kses_html( $raw['reviews']['text'] ?? '' ),
	'show_items' => ! empty( $raw['reviews']['show_items'] ),
	'ids'        => tolstenko_sanitize_ids( $raw['reviews']['ids'] ?? array() ),
	'cards'      => array(),
);
if ( isset( $raw['reviews']['cards'] ) && is_array( $raw['reviews']['cards'] ) ) {
	foreach ( $raw['reviews']['cards'] as $card ) {
		if ( ! is_array( $card ) ) {
			continue;
		}
		$c_title = sanitize_text_field( $card['title'] ?? '' );
		$c_url   = esc_url_raw( $card['url'] ?? '' );
		$c_rating = isset( $card['rating'] ) ? (int) $card['rating'] : 5;
		if ( $c_rating < 1 ) {
			$c_rating = 5;
		}
		if ( $c_rating > 5 ) {
			$c_rating = 5;
		}
		if ( $c_title === '' ) {
			continue;
		}
		$out['reviews']['cards'][] = array(
			'title'  => $c_title,
			'url'    => $c_url,
			'rating' => $c_rating,
		);
	}
}
