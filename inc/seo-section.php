<?php
/**
 * Секция «SEO-наполнение» (seo-section): раскладки гибкого содержимого,
 * санитизация (таб «Дефолты блоков») и нормализация (таб + блок).
 *
 * Перенесено из tolstenko.marketing (inc/seo-section-helpers.php, «SEO продвижение»).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Раскладки: ключ → подпись.
 *
 * @return array<string,string>
 */
function theme_seo_section_layout_labels() {
	return array(
		'text'        => __( 'Текст', 'tolstenko-theme' ),
		'image_text'  => __( 'Фото + текст', 'tolstenko-theme' ),
		'text_image'  => __( 'Текст + фото', 'tolstenko-theme' ),
		'two_columns' => __( 'Две колонки', 'tolstenko-theme' ),
		'gallery'     => __( 'Галерея', 'tolstenko-theme' ),
	);
}

/**
 * ID вложения: число (таб) или {id,url,alt} (блок).
 *
 * @param mixed $value Value.
 * @return int
 */
function theme_seo_section_image_id( $value ) {
	if ( is_array( $value ) ) {
		return (int) ( $value['id'] ?? $value['ID'] ?? 0 );
	}
	return (int) $value;
}

/**
 * Санитизация строк для таба (save.php).
 *
 * @param mixed $raw Rows from POST.
 * @return array
 */
function theme_seo_section_sanitize_rows( $raw ) {
	$layouts = theme_seo_section_layout_labels();
	$out     = array();

	foreach ( (array) $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$layout = sanitize_key( $row['layout'] ?? 'text' );
		$items  = array();
		foreach ( (array) ( $row['items'] ?? array() ) as $item ) {
			$item = is_array( $item ) ? $item : array();
			$it   = array(
				'title' => sanitize_text_field( $item['title'] ?? '' ),
				'text'  => tolstenko_kses_redactor( $item['text'] ?? '' ),
			);
			if ( $it['title'] !== '' || trim( wp_strip_all_tags( $it['text'] ) ) !== '' ) {
				$items[] = $it;
			}
		}

		$gallery = array();
		foreach ( (array) ( $row['gallery'] ?? array() ) as $g_item ) {
			$g_id = theme_seo_section_image_id( is_array( $g_item ) && isset( $g_item['image'] ) ? $g_item['image'] : $g_item );
			if ( $g_id > 0 ) {
				$gallery[] = array( 'image' => $g_id );
			}
		}

		$clean = array(
			'layout'   => isset( $layouts[ $layout ] ) ? $layout : 'text',
			'title'    => sanitize_text_field( $row['title'] ?? '' ),
			'image'    => (int) ( $row['image'] ?? 0 ),
			'text'     => tolstenko_kses_redactor( $row['text'] ?? '' ),
			'text_2'   => tolstenko_kses_redactor( $row['text_2'] ?? '' ),
			'items'    => $items,
			'gallery'  => $gallery,
			'btn_text' => sanitize_text_field( $row['btn_text'] ?? '' ),
			'btn_url'  => esc_url_raw( trim( (string) ( $row['btn_url'] ?? '' ) ) ),
		);

		if ( theme_seo_section_normalize_row( $clean ) !== null ) {
			$out[] = $clean;
		}
	}

	return $out;
}

/**
 * Строка → данные для вывода; null — выводить нечего.
 *
 * @param mixed $row Row from the tab or the block.
 * @return array|null
 */
function theme_seo_section_normalize_row( $row ) {
	if ( ! is_array( $row ) ) {
		return null;
	}

	$layouts = theme_seo_section_layout_labels();
	$layout  = (string) ( $row['layout'] ?? 'text' );
	$layout  = isset( $layouts[ $layout ] ) ? $layout : 'text';

	$items = array();
	foreach ( (array) ( $row['items'] ?? array() ) as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$title = trim( (string) ( $item['title'] ?? '' ) );
		$text  = (string) ( $item['text'] ?? '' );
		if ( $title !== '' || trim( wp_strip_all_tags( $text ) ) !== '' ) {
			$items[] = array(
				'title' => $title,
				'text'  => $text,
			);
		}
	}

	$gallery = array();
	foreach ( (array) ( $row['gallery'] ?? array() ) as $g_item ) {
		$g_id = theme_seo_section_image_id( is_array( $g_item ) && array_key_exists( 'image', $g_item ) ? $g_item['image'] : $g_item );
		if ( $g_id > 0 ) {
			$gallery[] = $g_id;
		}
	}

	$data = array(
		'layout'   => $layout,
		'title'    => trim( (string) ( $row['title'] ?? '' ) ),
		'image'    => theme_seo_section_image_id( $row['image'] ?? 0 ),
		'text'     => (string) ( $row['text'] ?? '' ),
		'text_2'   => (string) ( $row['text_2'] ?? '' ),
		'items'    => $items,
		'gallery'  => $gallery,
		'btn_text' => trim( (string) ( $row['btn_text'] ?? '' ) ),
		'btn_url'  => trim( (string) ( $row['btn_url'] ?? '' ) ),
	);

	// Пусто ли то, что этот вид действительно выводит (лишние поля других видов не считаются).
	$has_text   = trim( wp_strip_all_tags( $data['text'] ) ) !== '';
	$has_text_2 = trim( wp_strip_all_tags( $data['text_2'] ) ) !== '';
	$has_title  = $data['title'] !== '';

	switch ( $layout ) {
		case 'gallery':
			$has_content = (bool) $gallery;
			break;
		case 'image_text':
		case 'text_image':
			$has_content = $has_title || $has_text || $data['image'] > 0 || $data['btn_text'] !== '';
			break;
		case 'two_columns':
			$has_content = $has_title || $has_text || $has_text_2 || (bool) $items;
			break;
		default:
			$has_content = $has_title || $has_text;
	}

	if ( ! $has_content ) {
		return null;
	}

	return $data;
}

/**
 * Все строки → данные для вывода.
 *
 * @param mixed $rows Rows.
 * @return array<int,array>
 */
function theme_seo_section_normalize_rows( $rows ) {
	$out = array();
	foreach ( (array) $rows as $row ) {
		$data = theme_seo_section_normalize_row( $row );
		if ( $data !== null ) {
			$out[] = $data;
		}
	}
	return $out;
}
