<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Список ли это (0..n), а не ассоциативный массив полей.
 */
function tolstenko_is_list_array( $value ) {
	if ( ! is_array( $value ) ) {
		return false;
	}
	if ( array() === $value ) {
		return true;
	}
	return array_keys( $value ) === range( 0, count( $value ) - 1 );
}

/**
 * Склейка схемы и сохранённых дефолтов.
 */
function tolstenko_merge_block_defaults_data( $base, $saved ) {
	if ( ! is_array( $base ) ) {
		$base = array();
	}
	if ( ! is_array( $saved ) ) {
		return $base;
	}

	// Пустое значение в сохранённых данных = «поле не заполнено»:
	// не затираем непустой дефолт из схемы (иначе секции с пустыми
	// сохранёнными полями/списками перестают выводиться).
	foreach ( $saved as $saved_key => $saved_value ) {
		if ( ! array_key_exists( $saved_key, $base ) ) {
			continue;
		}

		$base_value = $base[ $saved_key ];

		// Пустая строка vs непустая строка в схеме.
		if ( is_string( $saved_value ) ) {
			if ( trim( $saved_value ) === '' && is_string( $base_value ) && trim( $base_value ) !== '' ) {
				unset( $saved[ $saved_key ] );
			}

			continue;
		}

		// Пустой список vs непустой список в схеме.
		if ( is_array( $saved_value ) && empty( $saved_value ) && is_array( $base_value ) && ! empty( $base_value ) ) {
			unset( $saved[ $saved_key ] );
		}
	}

	$data = array_replace_recursive( $base, $saved );
	foreach ( $saved as $key => $value ) {
		if ( ! is_array( $value ) ) {
			continue;
		}
		$base_val = $base[ $key ] ?? null;
		if ( tolstenko_is_list_array( $value ) && ( null === $base_val || tolstenko_is_list_array( $base_val ) ) ) {
			$data[ $key ] = $value;
			continue;
		}
		if ( is_array( $base_val ) && ! tolstenko_is_list_array( $base_val ) && ! tolstenko_is_list_array( $value ) ) {
			$data[ $key ] = tolstenko_merge_block_defaults_data( $base_val, $value );
		}
	}
	return $data;
}

/**
 * Смержить сохранённые дефолты поверх схемы для набора ключей.
 *
 * @param string[] $keys Ключи блоков.
 * @return array<string, array>
 */
function tolstenko_get_merged_defaults_for_keys( $keys ) {
	$schema = function_exists( 'tolstenko_block_defaults_schema' ) ? tolstenko_block_defaults_schema() : array();
	$lang   = function_exists( 'theme_settings_lang' ) ? theme_settings_lang() : '';
	$saved  = tolstenko_block_defaults_saved( $lang );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$all = array();
	foreach ( $keys as $key ) {
		$base = isset( $schema[ $key ] ) && is_array( $schema[ $key ] ) ? $schema[ $key ] : array();
		$cur  = isset( $saved[ $key ] ) && is_array( $saved[ $key ] ) ? $saved[ $key ] : array();
		$all[ $key ] = function_exists( 'tolstenko_merge_block_defaults_data' )
			? tolstenko_merge_block_defaults_data( $base, $cur )
			: array_replace_recursive( $base, $cur );
		if ( function_exists( 'theme_settings_translate_post_ids' ) ) {
			$all[ $key ] = theme_settings_translate_post_ids( $all[ $key ], $lang );
		}
	}
	return $all;
}


/**
 * Сохранённые дефолты для языка: основной язык + отличия перевода (inc/settings-i18n.php).
 *
 * @param string $lang Slug языка ('' — основной).
 * @return array
 */
function tolstenko_block_defaults_saved( $lang = '' ) {
	if ( function_exists( 'theme_settings_get_saved' ) ) {
		return theme_settings_get_saved( 'tolstenko_block_defaults', $lang );
	}
	$saved = get_option( 'tolstenko_block_defaults', array() );
	return is_array( $saved ) ? $saved : array();
}

function tolstenko_get_block_defaults( $block ) {
	$data = tolstenko_get_block_defaults_raw( $block );
	// Выборы записей общие для языков: подставляем перевод записи, если он есть.
	if ( function_exists( 'theme_settings_translate_post_ids' ) ) {
		$data = theme_settings_translate_post_ids( $data, theme_settings_lang() );
	}
	return $data;
}

/**
 * Дефолты блока на текущем языке без подстановки переводов записей.
 *
 * @param string $block Ключ блока.
 * @return array
 */
function tolstenko_get_block_defaults_raw( $block ) {
	$schema = tolstenko_block_defaults_schema();
	$base = isset( $schema[ $block ] ) ? $schema[ $block ] : array();
	$saved = tolstenko_block_defaults_saved( function_exists( 'theme_settings_lang' ) ? theme_settings_lang() : '' );
	if ( ! is_array( $saved ) || ! isset( $saved[ $block ] ) || ! is_array( $saved[ $block ] ) ) {
		if ( $block === 'service_section_filters' && is_array( $saved ) && isset( $saved['service_section'] ) && is_array( $saved['service_section'] ) ) {
			$data = tolstenko_merge_block_defaults_data( $base, $saved['service_section'] );
			$data['ids'] = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
			return $data;
		}
		return $base;
	}
	$data = tolstenko_merge_block_defaults_data( $base, $saved[ $block ] );
	if ( $block === 'service_section' || $block === 'service_section_filters' || $block === 'blog_section' || $block === 'blog_section_filters' || $block === 'case_section' || $block === 'reviews' ) {
		$data['ids'] = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
	}
	return $data;
}

