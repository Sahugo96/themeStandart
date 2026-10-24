<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['why_us'] = array(
	'badge' => tolstenko_kses_html( $raw['why_us']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['why_us']['title'] ?? '' ),
	'items' => array(),
);
if ( isset( $raw['why_us']['items'] ) && is_array( $raw['why_us']['items'] ) ) {
	foreach ( $raw['why_us']['items'] as $it ) {
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
		$out['why_us']['items'][] = $row;
	}
}
