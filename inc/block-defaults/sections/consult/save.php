<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['consult'] = array(
	'badge' => tolstenko_kses_html( $raw['consult']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['consult']['title'] ?? '' ),
	'text' => tolstenko_kses_html( $raw['consult']['text'] ?? '' ),
	'contact_label' => tolstenko_kses_html( $raw['consult']['contact_label'] ?? '' ),
	'phone' => tolstenko_kses_html( $raw['consult']['phone'] ?? '' ),
	// Только шорткод CF7, а не произвольный текст.
	'form_shortcode' => preg_match( '/^\[contact-form-7\s[^\]]*\]$/', trim( (string) ( $raw['consult']['form_shortcode'] ?? '' ) ) ) ? trim( sanitize_text_field( $raw['consult']['form_shortcode'] ) ) : '',
	'image' => isset( $raw['consult']['image'] ) ? (int) $raw['consult']['image'] : 0,
);
