<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out['documents']['subtitle'] = tolstenko_kses_html( $raw['documents']['subtitle'] ?? '' );
$out['documents']['title'] = tolstenko_kses_html( $raw['documents']['title'] ?? ''  );
$out['documents']['items'] = array();
if ( isset( $raw['documents']['items'] ) && is_array( $raw['documents']['items'] ) ) {
	foreach ( $raw['documents']['items'] as $it ) {
		if ( ! is_array( $it ) ) {
			continue;
		}
		$title = tolstenko_kses_html( $it['title'] ?? ''  );
		$text = tolstenko_kses_html( $it['text'] ?? ''  );
		$image = isset( $it['image'] ) ? (int) $it['image'] : 0;
		$attributes = sanitize_textarea_field( $it['attributes'] ?? '' );
		if ( $title === '' && $image === 0 && $text === '' && $attributes === '' ) {
			continue;
		}
		$out['documents']['items'][] = array(
			'image' => $image,
			'title' => $title,
			'text' => $text,
			'attributes' => $attributes,
		);
	}
}
