<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="about" data-group="landing">
			<?php $lp = $all['about'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[about][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[about][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="muted">Текст (визуальный редактор)</div>
			<div class="row tolstenko-faq-editor-wrap"><?php tolstenko_field_template_editor( (string) ( $lp['text'] ?? '' ), 'tolstenko_field_template_about_text', 'tolstenko_block_defaults[about][text]' ); ?></div>
			<div class="row">
				<div class="muted">Фото слева</div>
				<?php $lp_img_id = (int) ( $lp['image'] ?? 0 ); $lp_img_url = $lp_img_id ? wp_get_attachment_image_url( $lp_img_id, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[about][image]" value="<?php echo (int) $lp_img_id; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $lp_img_url ) : ?><img src="<?php echo esc_url( $lp_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
			<div class="row">
				<div class="muted">Цифры (число + подпись)</div>
				<div data-repeater-list="about-stats-list">
					<?php foreach ( (array) ( $lp['stats'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[about][stats][<?php echo (int) $idx; ?>][num]" value="<?php echo esc_attr( $it['num'] ?? '' ); ?>" placeholder="Число">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[about][stats][<?php echo (int) $idx; ?>][label]" rows="2" placeholder="Подпись (перенос строки = новая строка)"><?php echo esc_textarea( $it['label'] ?? '' ); ?></textarea></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="about-stats-list"><?php esc_html_e( 'Добавить цифру', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		