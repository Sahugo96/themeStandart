<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['team'] = array(
	'badge' => tolstenko_kses_html( $raw['team']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['team']['title'] ?? '' ),
	'text'  => tolstenko_kses_html( $raw['team']['text'] ?? '' ),
);
