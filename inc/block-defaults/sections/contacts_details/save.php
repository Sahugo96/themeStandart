<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cdt_raw = is_array( $raw['contacts_details'] ?? null ) ? $raw['contacts_details'] : array();

$out['contacts_details'] = array(
	'badge'          => sanitize_text_field( $cdt_raw['badge'] ?? '' ),
	'title'          => tolstenko_kses_html( $cdt_raw['title'] ?? '' ),
	'items'          => theme_contacts_normalize_details( $cdt_raw['items'] ?? array(), true ),
	'form_title'     => sanitize_text_field( $cdt_raw['form_title'] ?? '' ),
	'form_text'      => sanitize_text_field( $cdt_raw['form_text'] ?? '' ),
	// Только шорткод CF7, а не произвольный текст.
	'form_shortcode' => preg_match( '/^\[contact-form-7\s[^\]]*\]$/', trim( (string) ( $cdt_raw['form_shortcode'] ?? '' ) ) ) ? trim( sanitize_text_field( $cdt_raw['form_shortcode'] ) ) : '',
);
