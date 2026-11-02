<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cm_raw = is_array( $raw['contacts_maps'] ?? null ) ? $raw['contacts_maps'] : array();

$out['contacts_maps'] = array(
	'badge' => sanitize_text_field( $cm_raw['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $cm_raw['title'] ?? '' ),
	'items' => theme_contacts_normalize_maps( $cm_raw['items'] ?? array(), true ),
);
