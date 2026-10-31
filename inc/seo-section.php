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
 * Какие поля строки нужны каждому виду: таб и блок показывают только их.
 *
 * @return array<string,string[]> Поле → виды, в которых оно есть.
 */
function theme_seo_section_field_layouts() {
	return array(
		'image'    => array( 'image_text', 'text_image' ),
		'text'     => array( 'text', 'image_text', 'text_image', 'two_columns' ),
		'text_2'   => array( 'two_columns' ),
		'btn'      => array( 'image_text', 'text_image' ),
		'items'    => array( 'two_columns' ),
		'gallery'  => array( 'gallery' ),
	);
}

/**
 * Строка повторителя в табе «Дефолты блоков → SEO-наполнение».
 * Обёртки с data-seo-show скрывает assets/js/admin/block-defaults.js по выбранному виду.
 *
 * @param string $prefix Префикс имён полей, например tolstenko_block_defaults[seo_section][rows][0].
 * @param array  $row    Сохранённая строка (пусто — шаблон новой).
 */
function theme_seo_section_render_admin_row( $prefix, array $row ) {
	$layouts = theme_seo_section_layout_labels();
	$fields  = theme_seo_section_field_layouts();
	$layout  = isset( $layouts[ $row['layout'] ?? '' ] ) ? $row['layout'] : 'text';
	$img_id  = (int) ( $row['image'] ?? 0 );
	$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';

	$show = static function ( $field ) use ( $fields, $layout ) {
		$for = $fields[ $field ];
		echo ' data-seo-show="' . esc_attr( implode( ' ', $for ) ) . '"';
		if ( ! in_array( $layout, $for, true ) ) {
			echo ' hidden';
		}
	};
	?>
	<div class="repeater-item" data-repeater-item data-seo-row>
		<div class="cols">
			<select name="<?php echo esc_attr( $prefix ); ?>[layout]" data-seo-layout>
				<?php foreach ( $layouts as $layout_key => $layout_label ) : ?>
					<option value="<?php echo esc_attr( $layout_key ); ?>" <?php selected( $layout, $layout_key ); ?>><?php echo esc_html( $layout_label ); ?></option>
				<?php endforeach; ?>
			</select>
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[title]" value="<?php echo esc_attr( $row['title'] ?? '' ); ?>" placeholder="Заголовок блока" style="flex:1">
			<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
			<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
			<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
		</div>

		<div class="tolstenko-defaults-image-row"<?php $show( 'image' ); ?>>
			<div class="cols">
				<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $prefix ); ?>[image]" value="<?php echo (int) $img_id; ?>">
				<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать фото', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="icon-preview" style="margin-top:8px;"><?php if ( $img_url ) : ?><img src="<?php echo esc_url( $img_url ); ?>" alt=""><?php endif; ?></div>
		</div>

		<div class="row"<?php $show( 'text' ); ?>><textarea name="<?php echo esc_attr( $prefix ); ?>[text]" rows="5" placeholder="Текст (HTML); в «Двух колонках» — левая колонка"><?php echo esc_textarea( $row['text'] ?? '' ); ?></textarea></div>
		<div class="row"<?php $show( 'text_2' ); ?>><textarea name="<?php echo esc_attr( $prefix ); ?>[text_2]" rows="5" placeholder="Правая колонка (HTML)"><?php echo esc_textarea( $row['text_2'] ?? '' ); ?></textarea></div>

		<div class="cols"<?php $show( 'btn' ); ?>>
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[btn_text]" value="<?php echo esc_attr( $row['btn_text'] ?? '' ); ?>" placeholder="Кнопка (пусто — без кнопки)">
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[btn_url]" value="<?php echo esc_attr( $row['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки (пусто = #modal)" style="flex:1">
		</div>

		<div<?php $show( 'items' ); ?>>
			<div class="muted"><?php esc_html_e( 'Пункты под колонками', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="seo-items-list" data-name-prefix="<?php echo esc_attr( $prefix ); ?>[items]">
				<?php foreach ( (array) ( $row['items'] ?? array() ) as $i_idx => $item ) : ?>
					<?php $item = is_array( $item ) ? $item : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="<?php echo esc_attr( $prefix ); ?>[items][<?php echo (int) $i_idx; ?>][title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" placeholder="Заголовок пункта" style="flex:1">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="<?php echo esc_attr( $prefix ); ?>[items][<?php echo (int) $i_idx; ?>][text]" rows="2" placeholder="Текст пункта (HTML)"><?php echo esc_textarea( $item['text'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="seo-items-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
		</div>

		<div<?php $show( 'gallery' ); ?>>
			<div class="muted"><?php esc_html_e( 'Фото галереи', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="seo-gallery-list" data-name-prefix="<?php echo esc_attr( $prefix ); ?>[gallery]">
				<?php foreach ( (array) ( $row['gallery'] ?? array() ) as $g_idx => $g_item ) : ?>
					<?php
					$g_id  = (int) ( is_array( $g_item ) ? ( $g_item['image'] ?? 0 ) : $g_item );
					$g_url = $g_id ? wp_get_attachment_image_url( $g_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $prefix ); ?>[gallery][<?php echo (int) $g_idx; ?>][image]" value="<?php echo (int) $g_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Фото', 'tolstenko-theme' ); ?></button>
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $g_url ) : ?><img src="<?php echo esc_url( $g_url ); ?>" alt=""><?php endif; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="seo-gallery-list"><?php esc_html_e( 'Добавить фото', 'tolstenko-theme' ); ?></button></div>
		</div>
	</div>
	<?php
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
