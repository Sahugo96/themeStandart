<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['process'] = array(
	'badge'        => tolstenko_kses_html( $raw['process']['badge'] ?? '' ),
	'title'        => tolstenko_kses_html( $raw['process']['title'] ?? '' ),
	'image'        => isset( $raw['process']['image'] ) ? (int) $raw['process']['image'] : 0,
	'items'        => array(),
);
if ( isset( $raw['process']['items'] ) && is_array( $raw['process']['items'] ) ) {
	foreach ( $raw['process']['items'] as $it ) {
		if ( ! is_array( $it ) ) { continue; }
		$t = tolstenko_kses_html( $it['title'] ?? '' );
		$x = tolstenko_kses_redactor( $it['text'] ?? '' );
		if ( $t === '' && trim( wp_strip_all_tags( $x ) ) === '' ) { continue; }
		$out['process']['items'][] = array( 'title' => $t, 'text' => $x );
	}
}
