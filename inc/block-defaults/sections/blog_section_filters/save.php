<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['blog_section_filters'] = array(
	'badge'          => tolstenko_kses_html( $raw['blog_section_filters']['badge'] ?? '' ),
	'title'          => tolstenko_kses_html( $raw['blog_section_filters']['title'] ?? '' ),
	'posts_per_page' => isset( $raw['blog_section_filters']['posts_per_page'] ) ? (int) $raw['blog_section_filters']['posts_per_page'] : 4,
	'ids'            => tolstenko_sanitize_service_section_ids( $raw['blog_section_filters']['ids'] ?? array() ),
	'btn_text'       => sanitize_text_field( $raw['blog_section_filters']['btn_text'] ?? '' ),
);
