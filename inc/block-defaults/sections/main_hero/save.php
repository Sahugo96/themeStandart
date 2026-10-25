<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['main_hero'] = array(
	'badge'           => tolstenko_kses_html( $raw['main_hero']['badge'] ?? '' ),
	'title'           => tolstenko_kses_html( $raw['main_hero']['title'] ?? '' ),
	'title_tag'       => tolstenko_kses_html( $raw['main_hero']['title_tag'] ?? 'h1' ),
	'text'            => tolstenko_kses_html( $raw['main_hero']['text'] ?? '' ),
	'items'           => array(),
	'btn_text'        => tolstenko_kses_html( $raw['main_hero']['btn_text'] ?? '' ),
	'btn_subtext'     => tolstenko_kses_html( $raw['main_hero']['btn_subtext'] ?? '' ),
	'show_promo'      => ! empty( $raw['main_hero']['show_promo'] ),
	'promo_text'      => tolstenko_kses_html( $raw['main_hero']['promo_text'] ?? '' ),
	'present_image'   => isset( $raw['main_hero']['present_image'] ) ? (int) $raw['main_hero']['present_image'] : 0,
	'person_name'     => tolstenko_kses_html( $raw['main_hero']['person_name'] ?? '' ),
	'person_position' => tolstenko_kses_html( $raw['main_hero']['person_position'] ?? '' ),
	'image'           => isset( $raw['main_hero']['image'] ) ? (int) $raw['main_hero']['image'] : 0,
);
if ( isset( $raw['main_hero']['items'] ) && is_array( $raw['main_hero']['items'] ) ) {
	foreach ( $raw['main_hero']['items'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$row = array(
			'title' => tolstenko_kses_html( $it['title'] ?? '' ),
			'text'  => tolstenko_kses_html( $it['text'] ?? '' ),
		);
		$has_value = false;
		foreach ( $row as $row_val ) {
			if ( '' !== $row_val && 0 !== $row_val ) {
				$has_value = true;
				break;
			}
		}
		if ( ! $has_value ) {
			continue;
		}
		$out['main_hero']['items'][] = $row;
	}
}
