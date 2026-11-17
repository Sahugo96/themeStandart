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
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][form_shortcode]" value="<?php echo esc_attr( $lp['form_shortcode'] ?? '' ); ?>" style="width:100%" placeholder='Шорткод формы CF7, например [contact-form-7 id="d0819d8" title="Бесплатная консультация"]'></div>
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

		