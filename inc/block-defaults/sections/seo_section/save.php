<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$seo_raw = is_array( $raw['seo_section'] ?? null ) ? $raw['seo_section'] : array();

$out['seo_section'] = array(
	'badge'     => sanitize_text_field( $seo_raw['badge'] ?? '' ),
	'title'     => tolstenko_kses_html( $seo_raw['title'] ?? '' ),
	'more_text' => sanitize_text_field( $seo_raw['more_text'] ?? '' ),
	'rows'      => theme_seo_section_sanitize_rows( $seo_raw['rows'] ?? array() ),
);
