<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="consult" data-group="landing">
			<?php $lp = $all['consult'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[consult][title]" rows="3" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $lp['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[consult][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $lp['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][contact_label]" value="<?php echo esc_attr( $lp['contact_label'] ?? '' ); ?>" style="width:100%" placeholder="Подпись перед телефоном"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][phone]" value="<?php echo esc_attr( $lp['phone'] ?? '' ); ?>" style="width:100%" placeholder="Телефон"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][input_placeholder]" value="<?php echo esc_attr( $lp['input_placeholder'] ?? '' ); ?>" style="width:100%" placeholder="Плейсхолдер поля"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row">
				<div class="muted">Согласия (текст + ссылка)</div>
				<div data-repeater-list="consult-consents-list">
					<?php foreach ( (array) ( $lp['consents'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Текст перед ссылкой">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][link_text]" value="<?php echo esc_attr( $it['link_text'] ?? '' ); ?>" placeholder="Текст ссылки">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][link_url]" value="<?php echo esc_attr( $it['link_url'] ?? '' ); ?>" placeholder="URL ссылки">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="consult-consents-list"><?php esc_html_e( 'Добавить согласие', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row">
				<div class="muted">Фото справа</div>
				<?php $lp_img_id = (int) ( $lp['image'] ?? 0 ); $lp_img_url = $lp_img_id ? wp_get_attachment_image_url( $lp_img_id, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[consult][image]" value="<?php echo (int) $lp_img_id; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $lp_img_url ) : ?><img src="<?php echo esc_url( $lp_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>

		