<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['service_section_filters'] = array(
	'subtitle'        => tolstenko_kses_html( $raw['service_section_filters']['subtitle'] ?? '' ),
	'title'          => tolstenko_kses_html( $raw['service_section_filters']['title'] ?? '' ),
	'text'           => tolstenko_kses_html( $raw['service_section_filters']['text'] ?? '' ),
	'posts_per_page' => isset( $raw['service_section_filters']['posts_per_page'] ) ? (int) $raw['service_section_filters']['posts_per_page'] : 6,
	'ids'            => tolstenko_sanitize_service_section_ids( $raw['service_section_filters']['ids'] ?? array() ),
);
