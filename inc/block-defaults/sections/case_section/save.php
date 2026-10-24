<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['case_section'] = array(
	'subtitle'        => tolstenko_kses_html( $raw['case_section']['subtitle'] ?? '' ),
	'title'          => tolstenko_kses_html( $raw['case_section']['title'] ?? '' ),
	'text'           => tolstenko_kses_html( $raw['case_section']['text'] ?? '' ),
	'posts_per_page' => isset( $raw['case_section']['posts_per_page'] ) ? (int) $raw['case_section']['posts_per_page'] : 4,
	'ids'            => tolstenko_sanitize_ids( $raw['case_section']['ids'] ?? array() ),
);
