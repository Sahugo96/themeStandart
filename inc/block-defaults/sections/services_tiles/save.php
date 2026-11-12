<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$st_raw = isset( $raw['services_tiles'] ) && is_array( $raw['services_tiles'] ) ? $raw['services_tiles'] : array();

$out['services_tiles'] = array(
	'subtitle'      => tolstenko_kses_html( $st_raw['subtitle'] ?? '' ),
	'title'         => tolstenko_kses_html( $st_raw['title'] ?? '' ),
	'text'          => tolstenko_kses_html( $st_raw['text'] ?? '' ),
	'show_filter'   => ! empty( $st_raw['show_filter'] ),
	'all_label'     => sanitize_text_field( $st_raw['all_label'] ?? '' ),
	'card_more'     => sanitize_text_field( $st_raw['card_more'] ?? '' ),
	'card_consult'  => sanitize_text_field( $st_raw['card_consult'] ?? '' ),
	'card_price'    => sanitize_text_field( $st_raw['card_price'] ?? '' ),
);
