<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['banks'] = array(
	'badge' => tolstenko_kses_html( $raw['banks']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['banks']['title'] ?? '' ),
	'lead'  => tolstenko_kses_html( $raw['banks']['lead'] ?? '' ),
	'items' => array(),
	'btn_text' => sanitize_text_field( $raw['banks']['btn_text'] ?? '' ),
	'btn_url'  => esc_url_raw( $raw['banks']['btn_url'] ?? '' ),
);

if ( isset( $raw['banks']['items'] ) && is_array( $raw['banks']['items'] ) ) {
	foreach ( $raw['banks']['items'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}

		$title = tolstenko_kses_html( $it['title'] ?? '' );
		$logo  = isset( $it['logo'] ) ? (int) $it['logo'] : 0;

		if ( $title === '' && $logo === 0 ) {
			continue;
		}

		$out['banks']['items'][] = array(
			'title'         => $title,
			'logo'          => $logo,
			'type_text'     => sanitize_text_field( $it['type_text'] ?? '' ),
			'fact_1_label'  => sanitize_text_field( $it['fact_1_label'] ?? '' ),
			'fact_1_value'  => sanitize_text_field( $it['fact_1_value'] ?? '' ),
			'fact_2_label'  => sanitize_text_field( $it['fact_2_label'] ?? '' ),
			'fact_2_value'  => sanitize_text_field( $it['fact_2_value'] ?? '' ),
			'link_text'     => sanitize_text_field( $it['link_text'] ?? '' ),
			'link_url'      => esc_url_raw( $it['link_url'] ?? '' ),
		);
	}
}
