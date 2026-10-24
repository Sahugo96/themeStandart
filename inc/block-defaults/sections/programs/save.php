<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['programs'] = array(
	'badge'    => tolstenko_kses_html( $raw['programs']['badge'] ?? '' ),
	'title'    => tolstenko_kses_html( $raw['programs']['title'] ?? '' ),
	'lead'     => tolstenko_kses_html( $raw['programs']['lead'] ?? '' ),
	'columns'  => array(),
	'rows'     => array(),
	'btn_text' => tolstenko_kses_html( $raw['programs']['btn_text'] ?? '' ),
	'btn_url'  => esc_url_raw( $raw['programs']['btn_url'] ?? '' ),
);

if ( isset( $raw['programs']['columns'] ) && is_array( $raw['programs']['columns'] ) ) {
	foreach ( $raw['programs']['columns'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}

		$name   = tolstenko_kses_html( $it['name'] ?? '' );
		$flag   = isset( $it['flag'] ) ? (int) $it['flag'] : 0;
		$accent = ( isset( $it['accent'] ) && (string) $it['accent'] === '1' ) ? '1' : '';

		if ( $name === '' && $flag === 0 ) {
			continue;
		}

		$out['programs']['columns'][] = array( 'name' => $name, 'flag' => $flag, 'accent' => $accent );
	}
}

if ( isset( $raw['programs']['rows'] ) && is_array( $raw['programs']['rows'] ) ) {
	foreach ( $raw['programs']['rows'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}

		$criterion = tolstenko_kses_html( $it['criterion'] ?? '' );
		$values    = trim( (string) ( $it['values'] ?? '' ) );

		if ( $criterion === '' && $values === '' ) {
			continue;
		}

		$out['programs']['rows'][] = array( 'criterion' => $criterion, 'values' => $values );
	}
}
