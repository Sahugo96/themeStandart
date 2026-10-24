<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="process" data-group="landing">
			<?php $pr2 = $all['process'] ?? array(); $pr2_img = (int) ( $pr2['image'] ?? 0 ); $pr2_img_url = $pr2_img ? wp_get_attachment_image_url( $pr2_img, 'medium' ) : ''; ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[process][badge]" value="<?php echo esc_attr( $pr2['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[process][title]" value="<?php echo esc_attr( $pr2['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Изображение', 'tolstenko-theme' ); ?></div>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[process][image]" value="<?php echo (int) $pr2_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $pr2_img_url ) : ?><img src="<?php echo esc_url( $pr2_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
			<div class="muted"><?php esc_html_e( 'Шаги (нумерация автоматически)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="process-list">
				<?php foreach ( (array) ( $pr2['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[process][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название шага">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[process][items][<?php echo (int) $idx; ?>][text]" rows="3" placeholder="Описание (HTML)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="process-list"><?php esc_html_e( 'Добавить шаг', 'tolstenko-theme' ); ?></button></div>
		</div>

		