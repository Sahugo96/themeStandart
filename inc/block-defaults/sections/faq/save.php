<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['faq'] = array(
	'badge'      => tolstenko_kses_html( $raw['faq']['badge'] ?? '' ),
	'title'      => tolstenko_kses_html( $raw['faq']['title'] ?? ''  ),
	'form_title' => tolstenko_kses_html( $raw['faq']['form_title'] ?? ''  ),
	'form_text'  => tolstenko_kses_html( $raw['faq']['form_text'] ?? ''  ),
	'teammate_id' => isset( $raw['faq']['teammate_id'] ) ? (int) $raw['faq']['teammate_id'] : 0,
	'items'      => array(),
);
if ( isset( $raw['faq']['items'] ) && is_array( $raw['faq']['items'] ) ) {
	foreach ( $raw['faq']['items'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$q = tolstenko_kses_html( $it['quest'] ?? ''  );
		$a = tolstenko_kses_redactor( $it['unswer'] ?? '' );
		if ( $q === '' && trim( wp_strip_all_tags( $a ) ) === '' ) {
			continue;
		}
		$out['faq']['items'][] = array(
			'quest'  => $q,
			'unswer' => $a,
		);
	}
}
