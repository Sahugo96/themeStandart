<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['blog_more'] = array(
	'text' => tolstenko_kses_html( $raw['blog_more']['text'] ?? '' ),
	'url'  => esc_url_raw( $raw['blog_more']['url'] ?? '' ),
);
