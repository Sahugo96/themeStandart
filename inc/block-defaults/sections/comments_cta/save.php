<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cc_raw = is_array( $raw['comments_cta'] ?? null ) ? $raw['comments_cta'] : array();

$out['comments_cta'] = array(
	'title'    => tolstenko_kses_html( $cc_raw['title'] ?? '' ),
	'text'     => tolstenko_kses_html( $cc_raw['text'] ?? '' ),
	'btn_text' => sanitize_text_field( $cc_raw['btn_text'] ?? '' ),
	'btn_url'  => trim( (string) ( $cc_raw['btn_url'] ?? '' ) ) !== '' && strpos( trim( (string) $cc_raw['btn_url'] ), '#' ) === 0
		? '#' . sanitize_html_class( substr( trim( (string) $cc_raw['btn_url'] ), 1 ) )
		: esc_url_raw( $cc_raw['btn_url'] ?? '' ),
);
