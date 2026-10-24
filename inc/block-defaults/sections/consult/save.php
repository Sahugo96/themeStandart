<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['consult'] = array(
	'badge' => tolstenko_kses_html( $raw['consult']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['consult']['title'] ?? '' ),
	'text' => tolstenko_kses_html( $raw['consult']['text'] ?? '' ),
	'contact_label' => tolstenko_kses_html( $raw['consult']['contact_label'] ?? '' ),
	'phone' => tolstenko_kses_html( $raw['consult']['phone'] ?? '' ),
	'input_placeholder' => tolstenko_kses_html( $raw['consult']['input_placeholder'] ?? '' ),
	'btn_text' => tolstenko_kses_html( $raw['consult']['btn_text'] ?? '' ),
	'consents' => array(),
	'image' => isset( $raw['consult']['image'] ) ? (int) $raw['consult']['image'] : 0,
);
if ( isset( $raw['consult']['consents'] ) && is_array( $raw['consult']['consents'] ) ) {
	foreach ( $raw['consult']['consents'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$row = array(
			'text' => tolstenko_kses_html( $it['text'] ?? '' ),
			'link_text' => tolstenko_kses_html( $it['link_text'] ?? '' ),
			'link_url' => esc_url_raw( $it['link_url'] ?? '' ),
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
		$out['consult']['consents'][] = $row;
	}
}
