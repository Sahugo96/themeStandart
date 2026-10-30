<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$seo         = $all['seo_section'] ?? array();
$seo_layouts = theme_seo_section_layout_labels();
?>
<div class="tolstenko-df-panel" data-panel="seo_section" data-group="landing">
	<div class="row"><input type="text" name="tolstenko_block_defaults[seo_section][badge]" value="<?php echo esc_attr( $seo['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[seo_section][title]" value="<?php echo esc_attr( $seo['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[seo_section][more_text]" value="<?php echo esc_attr( $seo['more_text'] ?? '' ); ?>" style="width:100%" placeholder="Кнопка раскрытия (Читать далее)"></div>

	<div class="muted"><?php esc_html_e( 'Содержимое (текст свёрнут, полностью — по кнопке)', 'tolstenko-theme' ); ?></div>
	<p class="description"><?php esc_html_e( 'Тексты — HTML (абзацы <p>, списки, <h3>). «Две колонки»: «Текст» — левая колонка, «Текст 2» — правая, пункты — карточки под колонками. «Галерея» — только фото.', 'tolstenko-theme' ); ?></p>
	<div data-repeater-list="seo-rows-list">
		<?php foreach ( (array) ( $seo['rows'] ?? array() ) as $idx => $row ) : ?>
			<?php
			$row        = is_array( $row ) ? $row : array();
			$row_prefix = 'tolstenko_block_defaults[seo_section][rows][' . (int) $idx . ']';
			$row_img    = (int) ( $row['image'] ?? 0 );
			$row_img_url = $row_img ? wp_get_attachment_image_url( $row_img, 'thumbnail' ) : '';
			?>
			<div class="repeater-item" data-repeater-item>
				<div class="cols">
					<select name="<?php echo esc_attr( $row_prefix ); ?>[layout]">
						<?php foreach ( $seo_layouts as $layout_key => $layout_label ) : ?>
							<option value="<?php echo esc_attr( $layout_key ); ?>" <?php selected( $row['layout'] ?? 'text', $layout_key ); ?>><?php echo esc_html( $layout_label ); ?></option>
						<?php endforeach; ?>
					</select>
					<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[title]" value="<?php echo esc_attr( $row['title'] ?? '' ); ?>" placeholder="Заголовок блока" style="flex:1">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $row_prefix ); ?>[image]" value="<?php echo (int) $row_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Фото', 'tolstenko-theme' ); ?></button>
					<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
					<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
					<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
				</div>
				<div class="icon-preview" style="margin-top:8px;"><?php if ( $row_img_url ) : ?><img src="<?php echo esc_url( $row_img_url ); ?>" alt=""><?php endif; ?></div>
				<div class="row"><textarea name="<?php echo esc_attr( $row_prefix ); ?>[text]" rows="5" placeholder="Текст (HTML)"><?php echo esc_textarea( $row['text'] ?? '' ); ?></textarea></div>
				<div class="row"><textarea name="<?php echo esc_attr( $row_prefix ); ?>[text_2]" rows="3" placeholder="Текст 2 — правая колонка (для «Две колонки»)"><?php echo esc_textarea( $row['text_2'] ?? '' ); ?></textarea></div>
				<div class="cols">
					<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[btn_text]" value="<?php echo esc_attr( $row['btn_text'] ?? '' ); ?>" placeholder="Кнопка (для «Фото + текст»)">
					<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[btn_url]" value="<?php echo esc_attr( $row['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки (пусто = #modal)" style="flex:1">
				</div>

				<div class="muted"><?php esc_html_e( 'Пункты (для «Две колонки»)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="seo-items-list" data-name-prefix="<?php echo esc_attr( $row_prefix ); ?>[items]">
					<?php foreach ( (array) ( $row['items'] ?? array() ) as $i_idx => $item ) : ?>
						<?php $item = is_array( $item ) ? $item : array(); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[items][<?php echo (int) $i_idx; ?>][title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" placeholder="Заголовок пункта" style="flex:1">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="<?php echo esc_attr( $row_prefix ); ?>[items][<?php echo (int) $i_idx; ?>][text]" rows="2" placeholder="Текст пункта (HTML)"><?php echo esc_textarea( $item['text'] ?? '' ); ?></textarea></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="seo-items-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>

				<div class="muted"><?php esc_html_e( 'Фото галереи (для «Галерея»)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="seo-gallery-list" data-name-prefix="<?php echo esc_attr( $row_prefix ); ?>[gallery]">
					<?php foreach ( (array) ( $row['gallery'] ?? array() ) as $g_idx => $g_item ) : ?>
						<?php
						$g_id  = (int) ( is_array( $g_item ) ? ( $g_item['image'] ?? 0 ) : $g_item );
						$g_url = $g_id ? wp_get_attachment_image_url( $g_id, 'thumbnail' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $row_prefix ); ?>[gallery][<?php echo (int) $g_idx; ?>][image]" value="<?php echo (int) $g_id; ?>">
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
		<?php endforeach; ?>
	</div>
	<div class="actions"><button type="button" class="button" data-add-item="seo-rows-list"><?php esc_html_e( 'Добавить блок', 'tolstenko-theme' ); ?></button></div>
</div>
