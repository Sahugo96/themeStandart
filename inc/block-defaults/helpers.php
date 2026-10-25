<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URL статического файла админки (CSS/JS) с версией по времени изменения.
 *
 * Файлы подключаются тегом в том же месте страницы, где раньше стоял
 * встроенный <style>/<script>, поэтому порядок выполнения не меняется.
 *
 * @param string $path Путь относительно корня темы.
 * @return string
 */
function tolstenko_block_defaults_asset_url( $path ) {
	$file = get_template_directory() . '/' . $path;
	$ver  = file_exists( $file ) ? (string) filemtime( $file ) : '';

	return add_query_arg( 'ver', $ver, get_template_directory_uri() . '/' . $path );
}

/**
 * ID одиночной записи нужного типа (иначе 0).
 */
function tolstenko_landing_sanitize_post_id( $raw, $post_type ) {
	$id = (int) $raw;
	return ( $id > 0 && get_post_type( $id ) === $post_type ) ? $id : 0;
}

/**
 * Нормализация ID записей для слайдеров.
 */
function tolstenko_sanitize_ids( $raw ) {
	$ids = array();
	if ( is_string( $raw ) ) {
		$raw = preg_split( '/[\s,]+/', $raw, -1, PREG_SPLIT_NO_EMPTY );
	}
	if ( ! is_array( $raw ) ) {
		return array();
	}
	foreach ( $raw as $id ) {
		$id = (int) $id;
		if ( $id > 0 ) {
			$ids[] = $id;
		}
	}
	return array_values( array_unique( $ids ) );
}

/**
 * Получение списка записей для select2-подобного поля.
 */
function tolstenko_get_posts_for_select( $post_type ) {
	$posts = get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);
	$result = array();
	foreach ( $posts as $post ) {
		$result[] = array(
			'id'    => $post->ID,
			'title' => get_the_title( $post ),
		);
	}
	return $result;
}

/**
 * Рендер поля мультивыбора записей (как в Gutenberg).
 *
 * @param string               $name         Имя input (без []).
 * @param int[]|mixed          $selected_ids Выбранные ID.
 * @param string               $post_type    CPT.
 * @param string               $label        Подпись над полем.
 * @param array<string,mixed>  $args         exclude_ids, placeholder.
 */
function tolstenko_render_post_select( $name, $selected_ids, $post_type, $label = '', $args = array() ) {
	$args         = is_array( $args ) ? $args : array();
	$exclude_ids  = array_map( 'intval', (array) ( $args['exclude_ids'] ?? array() ) );
	$exclude_ids  = array_values( array_filter( $exclude_ids ) );
	$all_posts    = tolstenko_get_posts_for_select( $post_type );
	if ( $exclude_ids ) {
		$all_posts = array_values(
			array_filter(
				$all_posts,
				static function ( $p ) use ( $exclude_ids ) {
					return ! in_array( (int) ( $p['id'] ?? 0 ), $exclude_ids, true );
				}
			)
		);
	}
	$selected_ids = array_map( 'intval', (array) $selected_ids );
	$selected_ids = array_values( array_filter( $selected_ids, static function ( $id ) use ( $exclude_ids ) {
		return $id > 0 && ! in_array( $id, $exclude_ids, true );
	} ) );

	$placeholders = array(
		'service' => 'Поиск услуг...',
		'blog'    => 'Поиск статей...',
		'case'    => 'Поиск кейсов...',
		'review'  => 'Поиск отзывов...',
		'actions' => 'Поиск акций...',
	);
	$placeholder = (string) ( $args['placeholder'] ?? '' );
	if ( $placeholder === '' ) {
		$placeholder = $placeholders[ $post_type ] ?? ( 'Поиск ' . $post_type . '...' );
	}

	$posts_json = wp_json_encode( $all_posts, JSON_UNESCAPED_UNICODE );
	if ( ! is_string( $posts_json ) ) {
		$posts_json = '[]';
	}
	?>
	<div class="tolstenko-post-select-wrap">
		<?php if ( $label ) : ?>
			<div class="muted" style="margin-bottom:6px;"><?php echo esc_html( $label ); ?></div>
		<?php endif; ?>
		<div
			class="tolstenko-post-select-token-field"
			data-name="<?php echo esc_attr( $name ); ?>"
			data-post-type="<?php echo esc_attr( $post_type ); ?>"
			data-posts="<?php echo esc_attr( $posts_json ); ?>"
		>
			<div class="tolstenko-post-select-tokens">
				<?php foreach ( $selected_ids as $id ) : ?>
					<?php
					$title = '';
					foreach ( $all_posts as $p ) {
						if ( (int) $p['id'] === $id ) {
							$title = (string) $p['title'];
							break;
						}
					}
					if ( ! $title ) {
						$title = get_the_title( $id );
						$title = $title !== '' ? $title : ( '#' . $id );
					}
					?>
					<span class="tolstenko-post-select-token" data-id="<?php echo (int) $id; ?>">
						<span class="tolstenko-post-select-token-label"><?php echo esc_html( $title ); ?></span>
						<button type="button" class="tolstenko-post-select-token-remove" title="Удалить">×</button>
						<input type="hidden" name="<?php echo esc_attr( $name ); ?>[]" value="<?php echo (int) $id; ?>">
					</span>
				<?php endforeach; ?>
			</div>
			<div class="tolstenko-post-select-input-wrap">
				<input type="text" class="tolstenko-post-select-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off">
				<div class="tolstenko-post-select-suggestions" style="display:none;"></div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * CSS + JS для tolstenko_render_post_select (один раз за запрос).
 */
function tolstenko_post_select_print_assets() {
	static $printed = false;
	if ( $printed ) {
		return;
	}
	$printed = true;
	?>
	<link rel="stylesheet" href="<?php echo esc_url( tolstenko_block_defaults_asset_url( 'assets/css/admin/post-select.css' ) ); ?>">
	<script src="<?php echo esc_url( tolstenko_block_defaults_asset_url( 'assets/js/admin/post-select.js' ) ); ?>"></script>
	<?php
}

/**
 * Нормализация ID услуг в дефолтах слайдера.
 *
 * @param mixed $raw Сырые ID (массив или строка).
 * @return int[]
 */
function tolstenko_sanitize_service_section_ids( $raw ) {
	return tolstenko_sanitize_ids( $raw );
}

/**
 * Поля дефолтов для слайдера услуг (обычный / с фильтрами).
 */
function tolstenko_render_service_section_defaults_fields( $key, $data ) {
	$key  = sanitize_key( $key );
	$data = is_array( $data ) ? $data : array();
	$ids  = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
	?>
	<div class="row"><input type="text" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][subtitle]" value="<?php echo esc_attr( $data['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $data['title'] ?? '' ); ?></textarea></div>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $data['text'] ?? '' ); ?></textarea></div>
	<div class="row"><input type="number" min="-1" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][posts_per_page]" value="<?php echo esc_attr( (string) ( $data['posts_per_page'] ?? 6 ) ); ?>" style="width:100%" placeholder="Количество услуг, если ничего не выбрано (6, -1 = все)"></div>
	<div class="row">
		<?php tolstenko_render_post_select( 
			'tolstenko_block_defaults[' . $key . '][ids]',
			$ids,
			'service',
			'Услуги (пусто = самые новые по количеству выше)'
		); ?>
	</div>
	<?php
}

/**
 * Поля дефолтов для слайдера статей.
 */
function tolstenko_render_blog_section_defaults_fields( $key, $data ) {
	$key  = sanitize_key( $key );
	$data = is_array( $data ) ? $data : array();
	$ids  = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
	?>
	<?php if ( $key === 'blog_section' ) : ?>
	<div class="row"><input type="text" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][subtitle]" value="<?php echo esc_attr( $data['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
	<?php endif; ?>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $data['title'] ?? '' ); ?></textarea></div>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $data['text'] ?? '' ); ?></textarea></div>
	<div class="row"><input type="number" min="-1" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][posts_per_page]" value="<?php echo esc_attr( (string) ( $data['posts_per_page'] ?? 6 ) ); ?>" style="width:100%" placeholder="Количество статей, если ничего не выбрано (6, -1 = все)"></div>
	<div class="row">
		<?php tolstenko_render_post_select( 
			'tolstenko_block_defaults[' . $key . '][ids]',
			$ids,
			'blog',
			'Статьи (пусто = самые новые по количеству выше)'
		); ?>
	</div>
	<?php
}

/* ==========================================================================
   Хелперы для секций лендинга (why_us, result, compare, infra, about, guide, consult)
   ========================================================================== */

/**
 * Текст с переносами строк -> HTML (разрешённые теги + <br>).
 */
function tolstenko_landing_text( $value ) {
	return wp_kses_post( nl2br( (string) $value ) );
}

/**
 * Стандартные иконки карточек (используются, если в поле «Иконка» ничего не выбрано).
 */
function tolstenko_landing_default_icons() {
	return array(
		'why_us' => array(
			'<circle cx="12" cy="13.5" r="7.5"/><path d="M10 3h4M12 3v3M18.2 7.3l1.3-1.3"/><path d="m12.8 10.5-2.3 3h3l-2.3 3"/>',
			'<path d="M12 3 4.5 5.5v6c0 4.4 3 7.6 7.5 9.5 4.5-1.9 7.5-5.1 7.5-9.5v-6L12 3Z"/><circle cx="12" cy="10.5" r="2.5"/><path d="M7.8 17c.8-2 2.4-3 4.2-3s3.4 1 4.2 3"/>',
			'<rect x="3" y="4" width="14" height="11" rx="2"/><circle cx="10" cy="8.5" r="1.8"/><path d="M6.5 13c.6-1.6 1.9-2.3 3.5-2.3s2.9.7 3.5 2.3"/><path d="M7 18.5h12a2 2 0 0 0 2-2V8.5"/>',
			'<path d="m12 2.5 2.3 1.8 2.9-.1 1.1 2.7 2.5 1.5-.9 2.8.9 2.8-2.5 1.5-1.1 2.7-2.9-.1L12 21.5l-2.3-1.8-2.9.1-1.1-2.7-2.5-1.5.9-2.8-.9-2.8 2.5-1.5 1.1-2.7 2.9.1L12 2.5Z"/><path d="m9 15 6-6"/><circle cx="9.4" cy="9.4" r=".9"/><circle cx="14.6" cy="14.6" r=".9"/>',
			'<path d="M12.5 21H6.5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v6"/><path d="M8 8h6M8 11.5h6M8 15h3"/><path d="m14.5 18.5 2 2 4-4.5"/>',
			'<path d="M8 4h8v5a4 4 0 0 1-8 0V4Z"/><path d="M8 6H5v1.5A3 3 0 0 0 8 10.5M16 6h3v1.5a3 3 0 0 1-3 3"/><path d="M12 13v4M8.5 20.5h7M9.5 17h5v3.5h-5z"/>',
		),
		'result' => array(
			'<path d="M3 9.5 12 4l9 5.5M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 20h18M4 9.5h16"/>',
			'<rect x="3" y="5" width="18" height="14" rx="2"/><rect x="6" y="8.5" width="4.5" height="3.5" rx=".6"/><path d="M13.5 9h4M13.5 12h4M6 15.5h11.5"/>',
			'<rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3 9.5h18M6.5 15h2.5M12 15h2.5"/>',
			'<rect x="3" y="8" width="18" height="12" rx="2"/><path d="M8.5 8V6.5A1.5 1.5 0 0 1 10 5h4a1.5 1.5 0 0 1 1.5 1.5V8M3 13l9 3 9-3"/>',
			'<path d="M3 4v16h18"/><path d="m6.5 14 4-4 3 3 5-6"/><path d="M15.5 7h3.5v3.5"/>',
			'<path d="M4 14v-2a8 8 0 0 1 16 0v2"/><rect x="3" y="13" width="4" height="6" rx="1.5"/><rect x="17" y="13" width="4" height="6" rx="1.5"/><path d="M19 19c0 1.5-1.5 2.5-4 2.5h-2"/>',
		),
	);
}

/**
 * Иконка карточки: выбранное изображение или стандартная SVG по порядковому номеру.
 */
function tolstenko_landing_icon( $section, $index, $attachment_id, $class ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id > 0 ) {
		$img = wp_get_attachment_image(
			$attachment_id,
			'thumbnail',
			false,
			array(
				'class'   => $class,
				'alt'     => '',
				'loading' => 'lazy',
			)
		);
		if ( $img ) {
			return $img;
		}
	}
	$icons = tolstenko_landing_default_icons();
	if ( ! isset( $icons[ $section ][ $index ] ) ) {
		return '';
	}
	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 24 24" aria-hidden="true">' . $icons[ $section ][ $index ] . '</svg>';
}

/**
 * Рейтинг вида «4.9»: число от 0 до 5 с одним знаком, пусто — если не задан.
 *
 * @param mixed $value Значение из формы.
 * @return string
 */
function tolstenko_reviews_sanitize_rating( $value ) {
	$value = str_replace( ',', '.', trim( (string) $value ) );
	if ( $value === '' || ! is_numeric( $value ) ) {
		return '';
	}
	return number_format( max( 0, min( 5, (float) $value ) ), 1, '.', '' );
}
