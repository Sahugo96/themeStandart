<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['cost'] = array(
	'badge'        => tolstenko_kses_html( $raw['cost']['badge'] ?? '' ),
	'title'        => tolstenko_kses_html( $raw['cost']['title'] ?? '' ),
	'lead'         => tolstenko_kses_html( $raw['cost']['lead'] ?? '' ),
	'prices'       => array(),
	'card_title'   => tolstenko_kses_html( $raw['cost']['card_title'] ?? '' ),
	'card_text'    => tolstenko_kses_html( $raw['cost']['card_text'] ?? '' ),
	'btn_text'     => tolstenko_kses_html( $raw['cost']['btn_text'] ?? '' ),
	'btn_url'      => esc_url_raw( $raw['cost']['btn_url'] ?? '' ),
	'image'        => isset( $raw['cost']['image'] ) ? (int) $raw['cost']['image'] : 0,
	'links'        => array(),
);
if ( isset( $raw['cost']['links'] ) && is_array( $raw['cost']['links'] ) ) {
	foreach ( $raw['cost']['links'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$icon = $it['icon_id'] ?? '';
		$icon = is_array( $icon ) ? ( $icon['id'] ?? ( $icon['url'] ?? '' ) ) : $icon;
		$icon = ( is_string( $icon ) && $icon !== '' && ctype_digit( $icon ) ) ? (int) $icon : sanitize_text_field( (string) $icon );
		$title = sanitize_text_field( $it['title'] ?? '' );
		$url   = esc_url_raw( $it['link'] ?? '' );
		if ( $url === '' && $title === '' && empty( $icon ) ) {
			continue;
		}
		$out['cost']['links'][] = array(
			'icon_id' => $icon,
			'title'   => $title,
			'link'    => $url,
		);
	}
}
if ( isset( $raw['cost']['prices'] ) && is_array( $raw['cost']['prices'] ) ) {
	foreach ( $raw['cost']['prices'] as $it ) {
		if ( ! is_array( $it ) ) { continue; }
		$n = tolstenko_kses_html( $it['name'] ?? '' );
		$v = tolstenko_kses_html( $it['value'] ?? '' );
		if ( $n === '' && $v === '' ) { continue; }
		$out['cost']['prices'][] = array( 'name' => $n, 'value' => $v );
	}
}
