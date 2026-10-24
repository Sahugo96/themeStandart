<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['flagship'] = array(
	'badge' => tolstenko_kses_html( $raw['flagship']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['flagship']['title'] ?? '' ),
	'cards' => array(),
);

if ( isset( $raw['flagship']['cards'] ) && is_array( $raw['flagship']['cards'] ) ) {
	foreach ( $raw['flagship']['cards'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}

		$card_title = tolstenko_kses_html( $it['title'] ?? '' );
		$flag       = isset( $it['flag'] ) ? (int) $it['flag'] : 0;

		if ( $card_title === '' && $flag === 0 ) {
			continue;
		}

		$out['flagship']['cards'][] = array(
			'country'  => sanitize_text_field( $it['country'] ?? '' ),
			'flag'     => $flag,
			'price'    => tolstenko_kses_html( $it['price'] ?? '' ),
			'title'    => $card_title,
			'text'     => tolstenko_kses_html( $it['text'] ?? '' ),
			'facts'    => sanitize_textarea_field( $it['facts'] ?? '' ),
			'btn_text' => tolstenko_kses_html( $it['btn_text'] ?? '' ),
			'btn_url'  => esc_url_raw( $it['btn_url'] ?? '' ),
		);
	}
}
