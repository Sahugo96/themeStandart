<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="cost" data-group="landing">
			<?php $cst = $all['cost'] ?? array(); $cst_img = (int) ( $cst['image'] ?? 0 ); $cst_img_url = $cst_img ? wp_get_attachment_image_url( $cst_img, 'medium' ) : ''; ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][badge]" value="<?php echo esc_attr( $cst['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][title]" value="<?php echo esc_attr( $cst['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][lead]" rows="3" placeholder="Текст под заголовком (HTML)"><?php echo esc_textarea( $cst['lead'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Цены', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="cost-prices-list">
				<?php foreach ( (array) ( $cst['prices'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[cost][prices][<?php echo (int) $idx; ?>][name]" value="<?php echo esc_attr( $it['name'] ?? '' ); ?>" placeholder="Услуга">
							<input type="text" name="tolstenko_block_defaults[cost][prices][<?php echo (int) $idx; ?>][value]" value="<?php echo esc_attr( $it['value'] ?? '' ); ?>" placeholder="Значение (HTML)">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="cost-prices-list"><?php esc_html_e( 'Добавить цену', 'tolstenko-theme' ); ?></button></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][card_title]" rows="2" placeholder="Заголовок карточки (HTML)"><?php echo esc_textarea( $cst['card_title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][card_text]" rows="2" placeholder="Текст карточки"><?php echo esc_textarea( $cst['card_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][btn_text]" value="<?php echo esc_attr( $cst['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[cost][btn_url]" value="<?php echo esc_attr( $cst['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		<div class="muted"><?php esc_html_e( 'Ссылки с иконками (под кнопкой)', 'tolstenko-theme' ); ?></div>
		<div id="cost-links-template" style="display:none;">
			<div class="cost-link-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
				<input type="hidden" name="tolstenko_block_defaults[cost][links][__INDEX__][icon_id]" class="cost-link-icon-id" value="" />
				<img src="" class="cost-link-icon-preview" style="max-width:32px;max-height:32px;display:none;" />
				<button type="button" class="button cost-link-choose-icon">Загрузить SVG</button>
				<button type="button" class="button cost-link-remove-icon hidden" style="margin-left:4px;">Удалить иконку</button>
				<input type="text" name="tolstenko_block_defaults[cost][links][__INDEX__][title]" placeholder="Название" style="min-width:120px;" />
				<input type="text" name="tolstenko_block_defaults[cost][links][__INDEX__][link]" placeholder="Ссылка" style="flex:1; min-width:220px;" />
				<button type="button" class="button cost-remove-link">Удалить строку</button>
			</div>
		</div>

		<div class="cost-links-repeater">
			<?php foreach ( (array) ( $cst['links'] ?? array() ) as $idx => $lk ) : ?>
				<?php
				$lk       = is_array( $lk ) ? $lk : array();
				$icon_raw = $lk['icon_id'] ?? '';
				$icon_url = tolstenko_contact_resolve_icon_url( $icon_raw );
				?><div class="cost-link-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
					<input type="hidden" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][icon_id]" class="cost-link-icon-id" value="<?php echo esc_attr( $icon_raw ); ?>" />
					<img src="<?php echo esc_url( $icon_url ); ?>" class="cost-link-icon-preview" style="max-width:32px;max-height:32px;<?php echo empty( $icon_url ) ? 'display:none;' : ''; ?>" />
					<button type="button" class="button cost-link-choose-icon">Загрузить SVG</button>
					<button type="button" class="button cost-link-remove-icon<?php echo empty( $icon_url ) ? ' hidden' : ''; ?>" style="margin-left:4px;">Удалить иконку</button>
					<input type="text" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][title]" placeholder="Название" value="<?php echo esc_attr( $lk['title'] ?? '' ); ?>" style="min-width:120px;" />
					<input type="text" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][link]" placeholder="Ссылка" value="<?php echo esc_attr( $lk['link'] ?? '' ); ?>" style="flex:1; min-width:220px;" />
					<button type="button" class="button cost-remove-link">Удалить строку</button>
				</div>
			<?php endforeach; ?>
		</div>

		<button type="button" class="button cost-add-link" style="margin-top:8px;"><?php esc_html_e( 'Добавить ссылку', 'tolstenko-theme' ); ?></button>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Изображение', 'tolstenko-theme' ); ?></div>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[cost][image]" value="<?php echo (int) $cst_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $cst_img_url ) : ?><img src="<?php echo esc_url( $cst_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>
		