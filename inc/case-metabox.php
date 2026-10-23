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
 * Список опубликованных услуг для select.
 *
 * @return array<int,string> id => title
 */
function tolstenko_case_get_service_choices() {
	$posts = get_posts(
		array(
			'post_type'              => 'service',
			'post_status'            => 'publish',
			'posts_per_page'         => 200,
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);
	$out = array();
	foreach ( $posts as $p ) {
		if ( $p instanceof WP_Post ) {
			$out[ (int) $p->ID ] = get_the_title( $p );
		}
	}
	return $out;
}

/**
 * @param WP_Post $post Post.
 */
function tolstenko_case_render_metabox( $post ) {
	wp_nonce_field( 'tolstenko_case_save', 'tolstenko_case_nonce' );

	$card_title = (string) tolstenko_case_meta( $post->ID, 'case_title', '' );
	$card_text  = (string) tolstenko_case_meta( $post->ID, 'case_text', '' );
	$case_link  = (string) tolstenko_case_meta( $post->ID, 'case_link', '' );
	$service_id = (int) tolstenko_case_meta( $post->ID, 'case_service', 0 );
	$items_raw  = tolstenko_case_meta( $post->ID, 'case_items', array() );
	$items      = is_array( $items_raw ) ? $items_raw : array();
	if ( empty( $items ) ) {
		$items = array( array( 'value' => '', 'text' => '' ) );
	}
	$case_category_title = (string) tolstenko_case_meta( $post->ID, 'case_category_title', '' );
	$case_non_resident   = (string) tolstenko_case_meta( $post->ID, 'case_non_resident', '' );
	$case_indicators_raw = tolstenko_case_meta( $post->ID, 'case_indicators', array() );
	$case_indicators     = is_array( $case_indicators_raw ) ? $case_indicators_raw : array();
	if ( empty( $case_indicators ) ) {
		$case_indicators = array( array( 'icon' => '', 'criteria' => '', 'value' => '' ) );
	}

	$services = tolstenko_case_get_service_choices();
	?>
	<style>
		.tolstenko-case-box .tolstenko-case-field{margin:0 0 14px}
		.tolstenko-case-box .tolstenko-case-field input[type=text],
		.tolstenko-case-box .tolstenko-case-field input[type=url],
		.tolstenko-case-box .tolstenko-case-field select,
		.tolstenko-case-box .tolstenko-case-field textarea{width:100%}
		.tolstenko-case-box .tolstenko-case-item{display:flex;gap:8px;align-items:flex-start;margin:0 0 8px;padding:10px;background:#f6f7f7;border:1px solid #dcdcde;border-radius:4px}
		.tolstenko-case-box .tolstenko-case-item input{flex:1;width:auto}
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
			<label for="tolstenko_case_text"><strong><?php esc_html_e( 'Текст на карточке', 'tolstenko-theme' ); ?></strong></label><br>
			<textarea id="tolstenko_case_text" name="tolstenko_case_text" rows="3"><?php echo esc_textarea( $card_text ); ?></textarea>
		</p>

		<p class="tolstenko-case-field">
			<label for="tolstenko_case_link"><strong><?php esc_html_e( 'Ссылка кнопки «Разобрать кейс»', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="url" id="tolstenko_case_link" name="tolstenko_case_link" value="<?php echo esc_attr( $case_link ); ?>" placeholder="https://…">
			<span class="description"><?php esc_html_e( 'Пусто = ссылка на эту страницу кейса.', 'tolstenko-theme' ); ?></span>
		</p>

		<p class="tolstenko-case-field">
			<label for="tolstenko_case_service"><strong><?php esc_html_e( 'Услуга (ссылка «Подробнее об услуге»)', 'tolstenko-theme' ); ?></strong></label><br>
			<select id="tolstenko_case_service" name="tolstenko_case_service">
				<option value="0"><?php esc_html_e( '— Не выбрано —', 'tolstenko-theme' ); ?></option>
				<?php foreach ( $services as $sid => $stitle ) : ?>
					<option value="<?php echo (int) $sid; ?>" <?php selected( $service_id, (int) $sid ); ?>><?php echo esc_html( $stitle ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p class="tolstenko-case-field">
			<label for="tolstenko_case_category_title"><strong><?php esc_html_e( 'Подробное название рубрики', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_case_category_title" name="tolstenko_case_category_title" value="<?php echo esc_attr( $case_category_title ); ?>" placeholder="<?php esc_attr_e( 'Например: ООО «Релокейшн Ворлд»', 'tolstenko-theme' ); ?>">
		</p>

		<p class="tolstenko-case-field">
			<label for="tolstenko_case_non_resident"><strong><?php esc_html_e( 'Счет нерезиденту', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_case_non_resident" name="tolstenko_case_non_resident" value="<?php echo esc_attr( $case_non_resident ); ?>" placeholder="<?php esc_attr_e( 'Номер счета или данные', 'tolstenko-theme' ); ?>">
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
					$row      = is_array( $row ) ? $row : array();
					$icon     = (string) ( $row['icon'] ?? '' );
					$criteria = (string) ( $row['criteria'] ?? '' );
					$value    = (string) ( $row['value'] ?? '' );
					?>
					<div class="tolstenko-case-item" data-case-indicator>
						<input type="text" name="tolstenko_case_indicators[<?php echo (int) $idx; ?>][icon]" value="<?php echo esc_attr( $icon ); ?>" placeholder="<?php esc_attr_e( 'Иконка', 'tolstenko-theme' ); ?>">
						<input type="text" name="tolstenko_case_indicators[<?php echo (int) $idx; ?>][criteria]" value="<?php echo esc_attr( $criteria ); ?>" placeholder="<?php esc_attr_e( 'Критерий', 'tolstenko-theme' ); ?>">
						<input type="text" name="tolstenko_case_indicators[<?php echo (int) $idx; ?>][value]" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php esc_attr_e( 'Значение', 'tolstenko-theme' ); ?>">
						<button type="button" class="button" data-case-indicator-remove><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
					</div>
				<?php endforeach; ?>
			</div>
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

		initRepeater({
			listAttr: 'data-case-indicators',
			addAttr: 'data-case-indicator-add',
			itemAttr: 'data-case-indicator',
			removeAttr: 'data-case-indicator-remove',
			name: 'tolstenko_case_indicators',
			fields: [
				{ key: 'icon', placeholder: 'Иконка' },
				{ key: 'criteria', placeholder: 'Критерий' },
				{ key: 'value', placeholder: 'Значение' }
			]
		});
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

	$text = isset( $_POST['tolstenko_case_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tolstenko_case_text'] ) ) : '';
	if ( $text !== '' ) {
		update_post_meta( $post_id, 'case_text', $text );
	} else {
		delete_post_meta( $post_id, 'case_text' );
	}

	$link = isset( $_POST['tolstenko_case_link'] ) ? esc_url_raw( wp_unslash( $_POST['tolstenko_case_link'] ) ) : '';
	if ( $link !== '' ) {
		update_post_meta( $post_id, 'case_link', $link );
	} else {
		delete_post_meta( $post_id, 'case_link' );
	}

	$service_id = isset( $_POST['tolstenko_case_service'] ) ? absint( $_POST['tolstenko_case_service'] ) : 0;
	if ( $service_id > 0 && get_post_type( $service_id ) === 'service' ) {
		update_post_meta( $post_id, 'case_service', $service_id );
	} else {
		delete_post_meta( $post_id, 'case_service' );
	}

	$case_category_title = isset( $_POST['tolstenko_case_category_title'] ) ? sanitize_text_field( wp_unslash( $_POST['tolstenko_case_category_title'] ) ) : '';
	if ( $case_category_title !== '' ) {
		update_post_meta( $post_id, 'case_category_title', $case_category_title );
	} else {
		delete_post_meta( $post_id, 'case_category_title' );
	}

	$case_non_resident = isset( $_POST['tolstenko_case_non_resident'] ) ? sanitize_text_field( wp_unslash( $_POST['tolstenko_case_non_resident'] ) ) : '';
	if ( $case_non_resident !== '' ) {
		update_post_meta( $post_id, 'case_non_resident', $case_non_resident );
	} else {
		delete_post_meta( $post_id, 'case_non_resident' );
	}

	$case_indicators_out = array();
	if ( isset( $_POST['tolstenko_case_indicators'] ) && is_array( $_POST['tolstenko_case_indicators'] ) ) {
		foreach ( wp_unslash( $_POST['tolstenko_case_indicators'] ) as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$icon     = isset( $row['icon'] ) ? sanitize_text_field( (string) $row['icon'] ) : '';
			$criteria = isset( $row['criteria'] ) ? sanitize_text_field( (string) $row['criteria'] ) : '';
			$value    = isset( $row['value'] ) ? sanitize_text_field( (string) $row['value'] ) : '';
			if ( $icon === '' && $criteria === '' && $value === '' ) {
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