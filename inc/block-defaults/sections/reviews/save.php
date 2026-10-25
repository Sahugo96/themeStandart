<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['reviews'] = array(
	'subtitle'   => tolstenko_kses_html( $raw['reviews']['subtitle'] ?? '' ),
	'title'      => tolstenko_kses_html( $raw['reviews']['title'] ?? '' ),
	'text'       => tolstenko_kses_html( $raw['reviews']['text'] ?? '' ),
	'score'      => tolstenko_reviews_sanitize_rating( $raw['reviews']['score'] ?? '' ),
	'score_max'  => sanitize_text_field( $raw['reviews']['score_max'] ?? '' ),
	'score_text' => sanitize_text_field( $raw['reviews']['score_text'] ?? '' ),
	'btn_text'   => sanitize_text_field( $raw['reviews']['btn_text'] ?? '' ),
	'btn_url'    => esc_url_raw( $raw['reviews']['btn_url'] ?? '' ),
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
		$c_rating = tolstenko_reviews_sanitize_rating( $card['rating'] ?? '' );
		if ( $c_title === '' ) {
			continue;
		}
		$out['reviews']['cards'][] = array(
			'title'  => $c_title,
			'url'    => $c_url,
			'rating' => $c_rating,
			'icon'   => isset( $card['icon'] ) ? (int) $card['icon'] : 0,
		);
	}
}
