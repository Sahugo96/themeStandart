<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['guide'] = array(
	'subtitle' => tolstenko_kses_html( $raw['guide']['subtitle'] ?? '' ),
	'title'    => tolstenko_kses_html( $raw['guide']['title'] ?? '' ),
	'btn_text' => tolstenko_kses_html( $raw['guide']['btn_text'] ?? '' ),
	'post_id'  => tolstenko_landing_sanitize_post_id( $raw['guide']['post_id'] ?? 0, 'blog' ),
);
