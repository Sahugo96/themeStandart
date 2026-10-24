<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['infra'] = array(
	'badge' => tolstenko_kses_html( $raw['infra']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['infra']['title'] ?? '' ),
	'text' => tolstenko_kses_html( $raw['infra']['text'] ?? '' ),
	'btn_text' => tolstenko_kses_html( $raw['infra']['btn_text'] ?? '' ),
	'btn_url' => esc_url_raw( $raw['infra']['btn_url'] ?? '' ),
	'items' => array(),
);
if ( isset( $raw['infra']['items'] ) && is_array( $raw['infra']['items'] ) ) {
	foreach ( $raw['infra']['items'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$row = array(
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
		$out['infra']['items'][] = $row;
	}
}
