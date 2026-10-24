<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['cases'] = array(
	'badge'     => tolstenko_kses_html( $raw['cases']['badge'] ?? '' ),
	'title'     => tolstenko_kses_html( $raw['cases']['title'] ?? '' ),
	'all_text'  => tolstenko_kses_html( $raw['cases']['all_text'] ?? '' ),
	'all_url'   => esc_url_raw( $raw['cases']['all_url'] ?? '' ),
	'foot_text' => tolstenko_kses_html( $raw['cases']['foot_text'] ?? '' ),
	'btn_text'  => tolstenko_kses_html( $raw['cases']['btn_text'] ?? '' ),
	'btn_url'   => esc_url_raw( $raw['cases']['btn_url'] ?? '' ),
	'post_ids'  => tolstenko_sanitize_service_section_ids( $raw['cases']['post_ids'] ?? array() ),
);
