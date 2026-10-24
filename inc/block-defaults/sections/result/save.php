<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['result'] = array(
	'badge' => tolstenko_kses_html( $raw['result']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['result']['title'] ?? '' ),
	'items' => array(),
);
if ( isset( $raw['result']['items'] ) && is_array( $raw['result']['items'] ) ) {
	foreach ( $raw['result']['items'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$row = array(
			'icon' => isset( $it['icon'] ) ? (int) $it['icon'] : 0,
			'title' => tolstenko_kses_html( $it['title'] ?? '' ),
			'text' => tolstenko_kses_html( $it['text'] ?? '' ),
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
		$out['result']['items'][] = $row;
	}
}
