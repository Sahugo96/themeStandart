<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['situations'] = array(
	'badge'        => tolstenko_kses_html( $raw['situations']['badge'] ?? '' ),
	'title'        => tolstenko_kses_html( $raw['situations']['title'] ?? '' ),
	'items'        => array(),
);
if ( isset( $raw['situations']['items'] ) && is_array( $raw['situations']['items'] ) ) {
	foreach ( $raw['situations']['items'] as $it ) {
		if ( ! is_array( $it ) ) { continue; }
		$t = tolstenko_kses_html( $it['title'] ?? '' );
		$x = tolstenko_kses_html( $it['text'] ?? '' );
		if ( $t === '' && trim( wp_strip_all_tags( $x ) ) === '' ) { continue; }
		$out['situations']['items'][] = array( 'title' => $t, 'text' => $x );
	}
}
