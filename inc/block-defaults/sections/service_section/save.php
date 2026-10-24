<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['service_section'] = array(
	'subtitle'        => tolstenko_kses_html( $raw['service_section']['subtitle'] ?? '' ),
	'title'          => tolstenko_kses_html( $raw['service_section']['title'] ?? '' ),
	'text'           => tolstenko_kses_html( $raw['service_section']['text'] ?? '' ),
	'posts_per_page' => isset( $raw['service_section']['posts_per_page'] ) ? (int) $raw['service_section']['posts_per_page'] : 6,
	'ids'            => tolstenko_sanitize_service_section_ids( $raw['service_section']['ids'] ?? array() ),
);
