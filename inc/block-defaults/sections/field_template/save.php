<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['field_template'] = array(
	'enabled'       => ! empty( $raw['field_template']['enabled'] ),
	'text_field'     => tolstenko_kses_html( $raw['field_template']['text_field'] ?? '' ),
	'textarea_field' => tolstenko_kses_html( $raw['field_template']['textarea_field'] ?? '' ),
	'editor_field'   => tolstenko_kses_redactor( $raw['field_template']['editor_field'] ?? '' ),
	'image'          => isset( $raw['field_template']['image'] ) ? (int) $raw['field_template']['image'] : 0,
	'post_ids'       => tolstenko_sanitize_service_section_ids( $raw['field_template']['post_ids'] ?? array() ),
	'single_post_id' => isset( $raw['field_template']['single_post_id'] ) ? (int) $raw['field_template']['single_post_id'] : 0,
	'items'          => array(),
);
if ( isset( $raw['field_template']['items'] ) && is_array( $raw['field_template']['items'] ) ) {
	foreach ( $raw['field_template']['items'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$row = array(
			'title'    => tolstenko_kses_html( $it['title'] ?? '' ),
			'text'     => tolstenko_kses_html( $it['text'] ?? '' ),
		);
		if ( $row['title'] === '' && $row['text'] === '' ) {
			continue;
		}
		$out['field_template']['items'][] = $row;
	}
}
