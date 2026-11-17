<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ct_raw = is_array( $raw['contacts'] ?? null ) ? $raw['contacts'] : array();

$out['contacts'] = array(
	'badge'     => sanitize_text_field( $ct_raw['badge'] ?? '' ),
	'title'     => tolstenko_kses_html( $ct_raw['title'] ?? '' ),
	'call_text' => sanitize_text_field( $ct_raw['call_text'] ?? '' ),
	'tg_text'   => sanitize_text_field( $ct_raw['tg_text'] ?? '' ),
	'addresses' => theme_contacts_normalize_addresses( $ct_raw['addresses'] ?? array(), true ),
);
