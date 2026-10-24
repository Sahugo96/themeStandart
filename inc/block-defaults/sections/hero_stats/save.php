<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['hero_stats'] = array( 'items' => array() );
if ( isset( $raw['hero_stats']['items'] ) && is_array( $raw['hero_stats']['items'] ) ) {
	foreach ( $raw['hero_stats']['items'] as $it ) {
		if ( ! is_array( $it ) ) { continue; }
		$num   = tolstenko_kses_html( $it['num'] ?? '' );
		$label = tolstenko_kses_html( $it['label'] ?? '' );
		if ( $num === '' && $label === '' ) { continue; }
		$out['hero_stats']['items'][] = array( 'num' => $num, 'label' => $label );
	}
}
