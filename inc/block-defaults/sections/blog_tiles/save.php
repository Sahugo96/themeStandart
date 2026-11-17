<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['blog_tiles'] = array(
	'badge' => tolstenko_kses_html( $raw['blog_tiles']['badge'] ?? '' ),
	'title' => tolstenko_kses_html( $raw['blog_tiles']['title'] ?? '' ),
	'text'  => tolstenko_kses_html( $raw['blog_tiles']['text'] ?? '' ),
);
