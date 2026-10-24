<?php
/**
 * Нативный метабокс CPT «Кейс» — данные карточки для блока «Кейсы».
 * Страница кейса заполняется как статья (Gutenberg + метабоксы блога); комментарии не используются.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'tolstenko_case_add_metabox' );
add_action( 'save_post_case', 'tolstenko_case_save_metabox', 10, 2 );
add_action( 'admin_enqueue_scripts', 'tolstenko_case_metabox_assets' );

/**
 * @param string $hook Admin hook.
 */
function tolstenko_case_metabox_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== 'case' ) {
		return;
	}
	wp_enqueue_media();
}

function tolstenko_case_add_metabox() {
	add_meta_box(
		'tolstenko_case_fields',
		__( 'Данные кейса (карточка слайдера)', 'tolstenko-theme' ),
		'tolstenko_case_render_metabox',
		'case',
		'normal',
		'default'
	);
}

/**
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param mixed  $default Default.
 * @return mixed
 */
function tolstenko_case_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, $key, true );
	return ( $val === '' || $val === false || $val === null ) ? $default : $val;
}

/**
 * ID иконки показателя. Раньше иконка хранилась строкой (URL) — такой URL
 * переводим в ID вложения, если файл есть в медиабиблиотеке.
 *
 * @param mixed $raw Сохранённое значение.
 * @return int
 */
function tolstenko_case_indicator_icon_id( $raw ) {
	if ( is_numeric( $raw ) ) {
		return (int) $raw;
	}
	$raw = trim( (string) $raw );
	return $raw !== '' ? (int) attachment_url_to_postid( $raw ) : 0;
}

/**
 * Строка повторителя «Показатели (иконка, критерий, значение)».
 * Поле иконки — выбор из медиабиблиотеки, как «Фото» в текстовом отзыве.
 *
 * @param string $idx      Индекс строки (или «__i__» для шаблона).
 * @param int    $icon_id  ID вложения.
 * @param string $criteria Критерий.
 * @param string $value    Значение.
 */
function tolstenko_case_render_indicator_row( $idx, $icon_id, $criteria, $value ) {
	$name = 'tolstenko_case_indicators[' . $idx . ']';
	$url  = $icon_id ? wp_get_attachment_image_url( $icon_id, 'medium' ) : '';
	?>
	<div class="tolstenko-case-item" data-case-indicator>
		<span class="tolstenko-case-media" data-media-type="image">
			<label><strong><?php esc_html_e( 'Иконка', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="hidden" class="tolstenko-case-media-id" data-field="icon" name="<?php echo esc_attr( $name . '[icon]' ); ?>" value="<?php echo (int) $icon_id; ?>">
			<button type="button" class="button tolstenko-case-media-pick"><?php esc_html_e( 'Выбрать', 'tolstenko-theme' ); ?></button>
			<button type="button" class="button tolstenko-case-media-clear"<?php echo $icon_id ? '' : ' style="display:none"'; ?>><?php esc_html_e( 'Убрать', 'tolstenko-theme' ); ?></button>
			<span class="tolstenko-case-media-preview" style="display:block;margin-top:8px;">
				<?php if ( $url ) : ?>
					<img src="<?php echo esc_url( $url ); ?>" alt="" style="max-width:220px;height:auto;">
				<?php endif; ?>
			</span>
		</span>
		<input type="text" data-field="criteria" name="<?php echo esc_attr( $name . '[criteria]' ); ?>" value="<?php echo esc_attr( $criteria ); ?>" placeholder="<?php esc_attr_e( 'Критерий', 'tolstenko-theme' ); ?>">
		<input type="text" data-field="value" name="<?php echo esc_attr( $name . '[value]' ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php esc_attr_e( 'Значение', 'tolstenko-theme' ); ?>">
		<button type="button" class="button" data-case-indicator-remove><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
	</div>
	<?php
}

/**
 * @param WP_Post $post Post.
 */
function tolstenko_case_render_metabox( $post ) {
	wp_nonce_field( 'tolstenko_case_save', 'tolstenko_case_nonce' );

	$card_title = (string) tolstenko_case_meta( $post->ID, 'case_title', '' );
	$items_raw  = tolstenko_case_meta( $post->ID, 'case_items', array() );
	$items      = is_array( $items_raw ) ? $items_raw : array();
	if ( empty( $items ) ) {
		$items = array( array( 'value' => '', 'text' => '' ) );
	}
	$case_category_title = (string) tolstenko_case_meta( $post->ID, 'case_category_title', '' );
	$case_indicators_raw = tolstenko_case_meta( $post->ID, 'case_indicators', array() );
	$case_indicators     = is_array( $case_indicators_raw ) ? $case_indicators_raw : array();
	if ( empty( $case_indicators ) ) {
		$case_indicators = array( array( 'icon' => 0, 'criteria' => '', 'value' => '' ) );
	}
	?>
	<style>
		.tolstenko-case-box .tolstenko-case-field{margin:0 0 14px}
		.tolstenko-case-box .tolstenko-case-field input[type=text],
		.tolstenko-case-box .tolstenko-case-field input[type=url],
		.tolstenko-case-box .tolstenko-case-field select,
		.tolstenko-case-box .tolstenko-case-field textarea{width:100%}
		.tolstenko-case-box .tolstenko-case-item{display:flex;gap:8px;align-items:flex-start;margin:0 0 8px;padding:10px;background:#f6f7f7;border:1px solid #dcdcde;border-radius:4px}
		.tolstenko-case-box .tolstenko-case-item input{flex:1;width:auto}
		.tolstenko-case-box .tolstenko-case-media{flex:0 0 auto}
		.tolstenko-case-box .description{color:#646970;margin:4px 0 0}
	</style>

	<div class="tolstenko-case-box" id="tolstenko-case-box">
		<p class="description" style="margin:0 0 14px">
			<?php esc_html_e( 'Эти поля используются только в блоке «Кейсы» (карточка слайдера). Текст страницы кейса заполняется в редакторе и метабоксах ниже, как у статьи.', 'tolstenko-theme' ); ?>
		</p>

		<p class="tolstenko-case-field">
			<label for="tolstenko_case_title"><strong><?php esc_html_e( 'Заголовок на карточке', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_case_title" name="tolstenko_case_title" value="<?php echo esc_attr( $card_title ); ?>" placeholder="<?php esc_attr_e( 'Пусто = заголовок записи', 'tolstenko-theme' ); ?>">
		</p>

		<p class="tolstenko-case-field">
			<label for="tolstenko_case_category_title"><strong><?php esc_html_e( 'Название рубрики', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_case_category_title" name="tolstenko_case_category_title" value="<?php echo esc_attr( $case_category_title ); ?>" placeholder="<?php esc_attr_e( 'Например: ООО «Релокейшн Ворлд»', 'tolstenko-theme' ); ?>">
		</p>

		<div class="tolstenko-case-field">
			<strong><?php esc_html_e( 'Показатели (значение + подпись)', 'tolstenko-theme' ); ?></strong>
			<div class="tolstenko-case-items" data-case-items>
				<?php foreach ( $items as $idx => $row ) :
					$row = is_array( $row ) ? $row : array();
					$v   = (string) ( $row['value'] ?? '' );
					$t   = (string) ( $row['text'] ?? '' );
					?>
					<div class="tolstenko-case-item" data-case-item>
						<input type="text" name="tolstenko_case_items[<?php echo (int) $idx; ?>][value]" value="<?php echo esc_attr( $v ); ?>" placeholder="<?php esc_attr_e( 'Значение', 'tolstenko-theme' ); ?>">
						<input type="text" name="tolstenko_case_items[<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $t ); ?>" placeholder="<?php esc_attr_e( 'Подпись', 'tolstenko-theme' ); ?>">
						<button type="button" class="button" data-case-item-remove><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
					</div>
				<?php endforeach; ?>
			</div>
			<p>
				<button type="button" class="button" data-case-item-add><?php esc_html_e( 'Добавить показатель', 'tolstenko-theme' ); ?></button>
			</p>
		</div>

		<div class="tolstenko-case-field">
			<strong><?php esc_html_e( 'Показатели (иконка, критерий, значение)', 'tolstenko-theme' ); ?></strong>
			<div class="tolstenko-case-indicators" data-case-indicators>
				<?php foreach ( $case_indicators as $idx => $row ) :
					$row = is_array( $row ) ? $row : array();
					tolstenko_case_render_indicator_row(
						(string) (int) $idx,
						tolstenko_case_indicator_icon_id( $row['icon'] ?? 0 ),
						(string) ( $row['criteria'] ?? '' ),
						(string) ( $row['value'] ?? '' )
					);
				endforeach; ?>
			</div>
			<template data-case-indicator-template>
				<?php tolstenko_case_render_indicator_row( '__i__', 0, '', '' ); ?>
			</template>
			<p>
				<button type="button" class="button" data-case-indicator-add><?php esc_html_e( 'Добавить показатель', 'tolstenko-theme' ); ?></button>
			</p>
			<p class="description"><?php esc_html_e( 'Изображение карточки — миниатюра записи (блок справа).', 'tolstenko-theme' ); ?></p>
		</div>
	</div>

	<script>
	(function () {
		var box = document.getElementById('tolstenko-case-box');
		if (!box) return;

		/**
		 * Универсальный повторитель строк из текстовых полей.
		 * cfg: listAttr, addAttr, itemAttr, removeAttr, name, fields[{key, placeholder}]
		 */
		function initRepeater(cfg) {
			var list = box.querySelector('[' + cfg.listAttr + ']');
			var addBtn = box.querySelector('[' + cfg.addAttr + ']');
			if (!list || !addBtn) return;

			function reindex() {
				list.querySelectorAll('[' + cfg.itemAttr + ']').forEach(function (row, i) {
					row.querySelectorAll('input').forEach(function (input, n) {
						if (cfg.fields[n]) {
							input.name = cfg.name + '[' + i + '][' + cfg.fields[n].key + ']';
						}
					});
				});
			}

			addBtn.addEventListener('click', function (e) {
				e.preventDefault();
				var row = document.createElement('div');
				row.className = 'tolstenko-case-item';
				row.setAttribute(cfg.itemAttr, '');
				var html = '';
				cfg.fields.forEach(function (f) {
					html += '<input type="text" name="" value="" placeholder="' + f.placeholder + '">';
				});
				html += '<button type="button" class="button" ' + cfg.removeAttr + '>Удалить</button>';
				row.innerHTML = html;
				list.appendChild(row);
				reindex();
			});

			list.addEventListener('click', function (e) {
				var btn = e.target.closest('[' + cfg.removeAttr + ']');
				if (!btn) return;
				e.preventDefault();
				var row = btn.closest('[' + cfg.itemAttr + ']');
				if (row) row.remove();
				if (!list.querySelector('[' + cfg.itemAttr + ']')) {
					addBtn.click();
				}
				reindex();
			});
		}

		initRepeater({
			listAttr: 'data-case-items',
			addAttr: 'data-case-item-add',
			itemAttr: 'data-case-item',
			removeAttr: 'data-case-item-remove',
			name: 'tolstenko_case_items',
			fields: [
				{ key: 'value', placeholder: 'Значение' },
				{ key: 'text', placeholder: 'Подпись' }
			]
		});

		// Показатели с иконкой: строки из <template>, иконка — медиабиблиотека
		// (как «Фото» в текстовом отзыве).
		(function () {
			var list = box.querySelector('[data-case-indicators]');
			var addBtn = box.querySelector('[data-case-indicator-add]');
			var tpl = box.querySelector('template[data-case-indicator-template]');
			if (!list || !addBtn || !tpl) return;

			function reindex() {
				list.querySelectorAll('[data-case-indicator]').forEach(function (row, i) {
					row.querySelectorAll('[data-field]').forEach(function (input) {
						input.name = 'tolstenko_case_indicators[' + i + '][' + input.getAttribute('data-field') + ']';
					});
				});
			}

			addBtn.addEventListener('click', function (e) {
				e.preventDefault();
				list.appendChild(tpl.content.cloneNode(true));
				reindex();
			});

			list.addEventListener('click', function (e) {
				var removeBtn = e.target.closest('[data-case-indicator-remove]');
				if (removeBtn) {
					e.preventDefault();
					var row = removeBtn.closest('[data-case-indicator]');
					if (row) row.remove();
					if (!list.querySelector('[data-case-indicator]')) {
						addBtn.click();
					}
					reindex();
					return;
				}

				var wrap = e.target.closest('.tolstenko-case-media');
				if (!wrap) return;
				var idInput = wrap.querySelector('.tolstenko-case-media-id');
				var preview = wrap.querySelector('.tolstenko-case-media-preview');
				var clear = wrap.querySelector('.tolstenko-case-media-clear');

				if (e.target.closest('.tolstenko-case-media-pick')) {
					e.preventDefault();
					if (typeof wp === 'undefined' || !wp.media) return;
					var frame = wp.media({
						title: 'Выберите изображение',
						button: { text: 'Использовать' },
						multiple: false,
						library: { type: 'image' }
					});
					frame.on('select', function () {
						var att = frame.state().get('selection').first().toJSON();
						if (idInput) idInput.value = att.id || 0;
						if (preview) {
							preview.innerHTML = att.url ? '<img src="' + att.url + '" alt="" style="max-width:220px;height:auto;">' : '';
						}
						if (clear) clear.style.display = '';
					});
					frame.open();
				} else if (e.target.closest('.tolstenko-case-media-clear')) {
					e.preventDefault();
					if (idInput) idInput.value = '0';
					if (preview) preview.innerHTML = '';
					if (clear) clear.style.display = 'none';
				}
			});
		})();
	})();
	</script>
	<?php
}

/**
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function tolstenko_case_save_metabox( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['tolstenko_case_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_case_nonce'] ) ), 'tolstenko_case_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$title = isset( $_POST['tolstenko_case_title'] ) ? sanitize_text_field( wp_unslash( $_POST['tolstenko_case_title'] ) ) : '';
	if ( $title !== '' ) {
		update_post_meta( $post_id, 'case_title', $title );
	} else {
		delete_post_meta( $post_id, 'case_title' );
	}

	$case_category_title = isset( $_POST['tolstenko_case_category_title'] ) ? sanitize_text_field( wp_unslash( $_POST['tolstenko_case_category_title'] ) ) : '';
	if ( $case_category_title !== '' ) {
		update_post_meta( $post_id, 'case_category_title', $case_category_title );
	} else {
		delete_post_meta( $post_id, 'case_category_title' );
	}

	$case_indicators_out = array();
	if ( isset( $_POST['tolstenko_case_indicators'] ) && is_array( $_POST['tolstenko_case_indicators'] ) ) {
		foreach ( wp_unslash( $_POST['tolstenko_case_indicators'] ) as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$icon     = isset( $row['icon'] ) ? absint( $row['icon'] ) : 0;
			$criteria = isset( $row['criteria'] ) ? sanitize_text_field( (string) $row['criteria'] ) : '';
			$value    = isset( $row['value'] ) ? sanitize_text_field( (string) $row['value'] ) : '';
			if ( $icon && get_post_type( $icon ) !== 'attachment' ) {
				$icon = 0;
			}
			if ( $icon === 0 && $criteria === '' && $value === '' ) {
				continue;
			}
			$case_indicators_out[] = array(
				'icon'     => $icon,
				'criteria' => $criteria,
				'value'    => $value,
			);
		}
	}
	if ( ! empty( $case_indicators_out ) ) {
		update_post_meta( $post_id, 'case_indicators', $case_indicators_out );
	} else {
		delete_post_meta( $post_id, 'case_indicators' );
	}

	$items_out = array();
	if ( isset( $_POST['tolstenko_case_items'] ) && is_array( $_POST['tolstenko_case_items'] ) ) {
		foreach ( wp_unslash( $_POST['tolstenko_case_items'] ) as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$v = sanitize_text_field( (string) ( $row['value'] ?? '' ) );
			$t = sanitize_text_field( (string) ( $row['text'] ?? '' ) );
			if ( $v === '' && $t === '' ) {
				continue;
			}
			$items_out[] = array(
				'value' => $v,
				'text'  => $t,
			);
		}
	}
	if ( ! empty( $items_out ) ) {
		update_post_meta( $post_id, 'case_items', $items_out );
	} else {
		delete_post_meta( $post_id, 'case_items' );
	}
}