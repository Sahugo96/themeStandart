<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['about'] = array(
	'badge' => tolstenko_kses_html( $raw['about']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['about']['title'] ?? '' ),
	'text' => tolstenko_kses_redactor( $raw['about']['text'] ?? '' ),
	'image' => isset( $raw['about']['image'] ) ? (int) $raw['about']['image'] : 0,
	'stats' => array(),
);
if ( isset( $raw['about']['stats'] ) && is_array( $raw['about']['stats'] ) ) {
	foreach ( $raw['about']['stats'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$row = array(
			'num' => tolstenko_kses_html( $it['num'] ?? '' ),
			'label' => tolstenko_kses_html( $it['label'] ?? '' ),
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
		$out['about']['stats'][] = $row;
	}
}
