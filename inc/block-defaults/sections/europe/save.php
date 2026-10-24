<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['europe'] = array(
	'title'     => tolstenko_kses_html( $raw['europe']['title'] ?? '' ),
	'columns'   => array(),
	'rows'      => array(),
	'link_text' => sanitize_text_field( $raw['europe']['link_text'] ?? '' ),
	'link_url'  => esc_url_raw( $raw['europe']['link_url'] ?? '' ),
	'foot_text' => tolstenko_kses_html( $raw['europe']['foot_text'] ?? '' ),
	'btn_text'  => tolstenko_kses_html( $raw['europe']['btn_text'] ?? '' ),
	'btn_url'   => esc_url_raw( $raw['europe']['btn_url'] ?? '' ),
);

if ( isset( $raw['europe']['columns'] ) && is_array( $raw['europe']['columns'] ) ) {
	foreach ( $raw['europe']['columns'] as $col ) {
		$out['europe']['columns'][] = tolstenko_kses_html( $col );
	}
}

if ( isset( $raw['europe']['rows'] ) && is_array( $raw['europe']['rows'] ) ) {
	foreach ( $raw['europe']['rows'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}

		$country = sanitize_text_field( $it['country'] ?? '' );
		$flag    = isset( $it['flag'] ) ? (int) $it['flag'] : 0;

		if ( $country === '' && $flag === 0 ) {
			continue;
		}

		$out['europe']['rows'][] = array(
			'country'   => $country,
			'flag'      => $flag,
			'note'      => sanitize_text_field( $it['note'] ?? '' ),
			'price'     => tolstenko_kses_html( $it['price'] ?? '' ),
			'term'      => tolstenko_kses_html( $it['term'] ?? '' ),
			'benefits'  => sanitize_textarea_field( $it['benefits'] ?? '' ),
			'link_text' => sanitize_text_field( $it['link_text'] ?? '' ),
			'link_url'  => esc_url_raw( $it['link_url'] ?? '' ),
		);
	}
}
