<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['compare'] = array(
	'badge' => tolstenko_kses_html( $raw['compare']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['compare']['title'] ?? '' ),
	'lead' => tolstenko_kses_html( $raw['compare']['lead'] ?? '' ),
	'th_criterion' => tolstenko_kses_html( $raw['compare']['th_criterion'] ?? '' ),
	'th_self' => tolstenko_kses_html( $raw['compare']['th_self'] ?? '' ),
	'th_mediator' => tolstenko_kses_html( $raw['compare']['th_mediator'] ?? '' ),
	'th_us' => tolstenko_kses_html( $raw['compare']['th_us'] ?? '' ),
	'rows' => array(),
	'foot_text' => tolstenko_kses_html( $raw['compare']['foot_text'] ?? '' ),
	'btn_text' => tolstenko_kses_html( $raw['compare']['btn_text'] ?? '' ),
	'btn_url' => esc_url_raw( $raw['compare']['btn_url'] ?? '' ),
);
if ( isset( $raw['compare']['rows'] ) && is_array( $raw['compare']['rows'] ) ) {
	foreach ( $raw['compare']['rows'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$row = array(
			'criterion' => tolstenko_kses_html( $it['criterion'] ?? '' ),
			'self' => tolstenko_kses_html( $it['self'] ?? '' ),
			'mediator' => tolstenko_kses_html( $it['mediator'] ?? '' ),
			'us' => tolstenko_kses_html( $it['us'] ?? '' ),
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
		$out['compare']['rows'][] = $row;
	}
}
