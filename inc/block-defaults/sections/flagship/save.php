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

// Круглые кнопки-ссылки карточек.
$out['flagship']['links'] = array();
if ( isset( $raw['flagship']['links'] ) && is_array( $raw['flagship']['links'] ) ) {
	foreach ( $raw['flagship']['links'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$link_url = esc_url_raw( trim( (string) ( $it['url'] ?? '' ) ) );
		if ( $link_url === '' ) {
			continue;
		}
		$out['flagship']['links'][] = array(
			'icon' => isset( $it['icon'] ) ? (int) $it['icon'] : 0,
			'url'  => $link_url,
		);
	}
}

// Таблица «Другие программы».
$out['flagship']['table_title']  = tolstenko_kses_html( $raw['flagship']['table_title'] ?? '' );
$out['flagship']['col_country']  = sanitize_text_field( $raw['flagship']['col_country'] ?? '' );
$out['flagship']['col_price']    = sanitize_text_field( $raw['flagship']['col_price'] ?? '' );
$out['flagship']['col_term']     = sanitize_text_field( $raw['flagship']['col_term'] ?? '' );
$out['flagship']['col_benefits'] = sanitize_text_field( $raw['flagship']['col_benefits'] ?? '' );
$out['flagship']['row_btn_text'] = sanitize_text_field( $raw['flagship']['row_btn_text'] ?? '' );
$out['flagship']['rows']         = array();

if ( isset( $raw['flagship']['rows'] ) && is_array( $raw['flagship']['rows'] ) ) {
	foreach ( $raw['flagship']['rows'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}

		$row_name = tolstenko_kses_html( $it['name'] ?? '' );
		if ( trim( wp_strip_all_tags( $row_name ) ) === '' ) {
			continue;
		}

		$benefits = array();
		foreach ( (array) ( $it['benefits'] ?? array() ) as $benefit ) {
			$benefit_text = sanitize_text_field( is_array( $benefit ) ? ( $benefit['text'] ?? '' ) : '' );
			if ( $benefit_text !== '' ) {
				$benefits[] = array( 'text' => $benefit_text );
			}
		}

		$out['flagship']['rows'][] = array(
			'flag'     => isset( $it['flag'] ) ? (int) $it['flag'] : 0,
			'name'     => $row_name,
			'price'    => tolstenko_kses_html( $it['price'] ?? '' ),
			'term'     => tolstenko_kses_html( $it['term'] ?? '' ),
			'benefits' => $benefits,
			'link'     => esc_url_raw( trim( (string) ( $it['link'] ?? '' ) ) ),
		);
	}
}

$out['flagship']['foot_text'] = tolstenko_kses_html( $raw['flagship']['foot_text'] ?? '' );
$out['flagship']['btn_text']  = sanitize_text_field( $raw['flagship']['btn_text'] ?? '' );
$out['flagship']['btn_url']   = esc_url_raw( $raw['flagship']['btn_url'] ?? '' );
