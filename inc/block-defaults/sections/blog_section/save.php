<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['blog_section'] = array(
	'subtitle'        => tolstenko_kses_html( $raw['blog_section']['subtitle'] ?? '' ),
	'title'          => tolstenko_kses_html( $raw['blog_section']['title'] ?? '' ),
	'text'           => tolstenko_kses_html( $raw['blog_section']['text'] ?? '' ),
	'posts_per_page' => isset( $raw['blog_section']['posts_per_page'] ) ? (int) $raw['blog_section']['posts_per_page'] : 12,
	'ids'            => tolstenko_sanitize_service_section_ids( $raw['blog_section']['ids'] ?? array() ),
);
