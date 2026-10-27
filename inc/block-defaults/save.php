<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tolstenko_save_block_defaults_from_request() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$lang = function_exists( 'theme_settings_admin_lang' ) ? theme_settings_admin_lang() : '';
	$is_translation = function_exists( 'theme_settings_is_translation' ) && theme_settings_is_translation( $lang );

	if ( isset( $_POST['tolstenko_defaults_reset_all'] ) ) {
		delete_option( $is_translation ? theme_settings_option_name( 'tolstenko_block_defaults', $lang ) : 'tolstenko_block_defaults' );
		return;
	}
	$raw = isset( $_POST['tolstenko_block_defaults'] ) ? wp_unslash( $_POST['tolstenko_block_defaults'] ) : array();
	$out = array();
	if ( ! is_array( $raw ) ) {
		$raw = array();
	}


	foreach ( tolstenko_block_defaults_section_keys() as $section_key ) {
		$save_file = tolstenko_block_defaults_section_file( $section_key, 'save.php' );
		if ( $save_file ) {
			include $save_file;
		}
	}

	// Перевод: храним только отличия от основного языка; выборы записей — общие.
	if ( $is_translation ) {
		theme_settings_save_translation( 'tolstenko_block_defaults', $lang, $out, theme_settings_post_id_keys() );
		return;
	}

	// Не затирать дефолты блоков тела статьи (правятся на отдельной странице).
	$prev = get_option( 'tolstenko_block_defaults', array() );
	if ( is_array( $prev ) && function_exists( 'tolstenko_blog_content_defaults_schema' ) ) {
		foreach ( array_keys( tolstenko_blog_content_defaults_schema() ) as $content_key ) {
			if ( isset( $prev[ $content_key ] ) ) {
				$out[ $content_key ] = $prev[ $content_key ];
			}
		}
	}

	// Не затирать видео-пузырь (отдельная страница настроек).
	if ( is_array( $prev ) && isset( $prev['video_bubble'] ) ) {
		$out['video_bubble'] = $prev['video_bubble'];
	}

	update_option( 'tolstenko_block_defaults', $out, false );
}

