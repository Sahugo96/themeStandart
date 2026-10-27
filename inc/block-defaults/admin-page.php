<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'tolstenko_register_block_defaults_admin_page' );
add_action( 'admin_enqueue_scripts', 'tolstenko_block_defaults_admin_assets' );

function tolstenko_register_block_defaults_admin_page() {
	add_menu_page(
		__( 'Настройки сайта', 'tolstenko-theme' ),
		__( 'Настройки сайта', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-site-settings',
		'tolstenko_render_block_defaults_admin_page',
		'dashicons-admin-generic',
		58
	);
	add_submenu_page(
		'tolstenko-site-settings',
		__( 'Дефолты блоков', 'tolstenko-theme' ),
		__( 'Дефолты блоков', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-site-settings',
		'tolstenko_render_block_defaults_admin_page'
	);
}

function tolstenko_block_defaults_admin_assets( $hook ) {
	if ( $hook !== 'toplevel_page_tolstenko-site-settings' ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_editor();
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'wp-components' );
}

/**
 * Визуальный редактор ответа FAQ в дефолтах блоков.
 */
function tolstenko_faq_answer_editor( $content, $idx ) {
	$idx       = (int) $idx;
	$editor_id = 'tolstenko_faq_redactor_' . $idx;
	wp_editor(
		(string) $content,
		$editor_id,
		array(
			'textarea_name' => 'tolstenko_block_defaults[faq][items][' . $idx . '][unswer]',
			'textarea_rows' => 8,
			'media_buttons' => true,
			'teeny'         => false,
			'quicktags'     => true,
			'editor_height' => 180,
		)
	);
}

/**
 * Универсальный визуальный редактор (rich text) для шаблона полей в дефолтах блоков.
 *
 * @param string $content       HTML-содержимое редактора.
 * @param string $editor_id     Уникальный id редактора (tinymce/quicktags).
 * @param string $textarea_name Значение атрибута name у textarea.
 */
function tolstenko_field_template_editor( $content, $editor_id, $textarea_name ) {
	wp_editor(
		(string) $content,
		(string) $editor_id,
		array(
			'textarea_name' => $textarea_name,
			'textarea_rows' => 8,
			'media_buttons' => true,
			'teeny'         => false,
			'quicktags'     => true,
			'editor_height' => 180,
		)
	);
}

function tolstenko_render_block_defaults_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['tolstenko_block_defaults_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_block_defaults_nonce'] ) ), 'tolstenko_block_defaults_save' ) ) {
		tolstenko_save_block_defaults_from_request();
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Дефолты блоков сохранены.', 'tolstenko-theme' ) . '</p></div>';
	}

	$settings_lang = function_exists( 'theme_settings_admin_lang' ) ? theme_settings_admin_lang() : '';
	$all = tolstenko_block_defaults_schema();
	// Для перевода форма показывает основной язык + уже переведённое (inc/settings-i18n.php).
	$saved = tolstenko_block_defaults_saved( $settings_lang );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	foreach ( $saved as $block_key => $block_saved ) {
		if ( ! is_array( $block_saved ) ) {
			continue;
		}
		$base_block = isset( $all[ $block_key ] ) && is_array( $all[ $block_key ] ) ? $all[ $block_key ] : array();
		$all[ $block_key ] = tolstenko_merge_block_defaults_data( $base_block, $block_saved );
	}
	if ( empty( $all['documents']['items'] ) || ! is_array( $all['documents']['items'] ) ) {
		$all['documents']['items'] = array();
	}
	?>
	<div class="wrap">
	<h1><?php esc_html_e( 'Настройки сайта: дефолты блоков', 'tolstenko-theme' ); ?></h1>
	<?php
	if ( function_exists( 'theme_settings_render_lang_tabs' ) ) {
		theme_settings_render_lang_tabs( admin_url( 'admin.php?page=tolstenko-site-settings' ), array( __( 'выбранные статьи, услуги, кейсы, отзывы и сотрудники', 'tolstenko-theme' ) ) );
	}
	?>
	<form method="post" action="" class="tolstenko-df-form">
	<?php wp_nonce_field( 'tolstenko_block_defaults_save', 'tolstenko_block_defaults_nonce' ); ?>
	<?php if ( $settings_lang !== '' ) : ?>
		<input type="hidden" name="settings_lang" value="<?php echo esc_attr( $settings_lang ); ?>">
	<?php endif; ?>
	<p class="description"><?php esc_html_e( 'Редактируйте дефолтные значения блоков. Они используются, когда у конкретной страницы/блока нет своих значений.', 'tolstenko-theme' ); ?></p>
	<link rel="stylesheet" href="<?php echo esc_url( tolstenko_block_defaults_asset_url( 'assets/css/admin/block-defaults.css' ) ); ?>">
	<?php tolstenko_post_select_print_assets(); ?>
	<div class="tolstenko-df">
		<?php
		$is_first_group = true;
		foreach ( tolstenko_block_defaults_tab_groups() as $group_id => $group ) :
			?>
		<div class="tolstenko-df-tabs-group<?php echo $is_first_group ? ' is-active' : ''; ?>" data-group="<?php echo esc_attr( $group_id ); ?>">
			<div class="tolstenko-df-tabs-group-title"><?php echo esc_html( __( $group['title'], 'tolstenko-theme' ) ); ?></div>
			<div class="tolstenko-df-tabs">
				<?php foreach ( $group['tabs'] as $panel_key => $tab_label ) : ?>
				<button type="button" class="tolstenko-df-tab<?php echo $is_first_group && $panel_key === array_key_first( $group['tabs'] ) ? ' active' : ''; ?>" data-panel="<?php echo esc_attr( $panel_key ); ?>" data-group="<?php echo esc_attr( $group_id ); ?>"><?php echo esc_html( __( $tab_label, 'tolstenko-theme' ) ); ?></button>
				<?php endforeach; ?>
			</div>
			<div class="tolstenko-df-group-panels" data-group-panels="<?php echo esc_attr( $group_id ); ?>"></div>
		</div>
			<?php
			$is_first_group = false;
		endforeach;
		?>

		<div class="tolstenko-df-panels-source">
		<?php
		foreach ( tolstenko_block_defaults_tab_groups() as $group ) {
			foreach ( array_keys( $group['tabs'] ) as $panel_key ) {
				$panel_file = tolstenko_block_defaults_section_file( $panel_key, 'panel.php' );
				if ( $panel_file ) {
					include $panel_file;
				}
			}
		}
		?>
		</div><!-- .tolstenko-df-panels-source -->
	</div>
	<div class="actions">
		<!-- <button type="submit" name="tolstenko_defaults_reset_all" value="1" class="button"><?php esc_html_e( 'Сбросить всё к заводским', 'tolstenko-theme' ); ?></button> -->
	</div>
	<?php submit_button( __( 'Сохранить дефолты', 'tolstenko-theme' ) ); ?>
	<script src="<?php echo esc_url( tolstenko_block_defaults_asset_url( 'assets/js/admin/block-defaults.js' ) ); ?>"></script>
	</form>
	<?php
	if ( function_exists( 'theme_settings_render_shared_fields_script' ) ) {
		theme_settings_render_shared_fields_script( '.tolstenko-df-form', theme_settings_post_id_keys() );
	}
	?>
	</div>
	<?php
}

