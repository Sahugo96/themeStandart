<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Дефолты всех секций: inc/block-defaults/sections/<ключ>/schema.php.
 *
 * @return array<string, array>
 */
function tolstenko_block_defaults_schema() {
	$schema = array();
	foreach ( tolstenko_block_defaults_section_keys() as $key ) {
		$file = tolstenko_block_defaults_section_file( $key, 'schema.php' );
		$schema[ $key ] = $file ? require $file : array();
	}

	return $schema;
}
