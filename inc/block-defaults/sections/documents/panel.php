<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="documents" data-group="landing">
			<div class="row"><input type="text" name="tolstenko_block_defaults[documents][subtitle]" value="<?php echo esc_attr( $all['documents']['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[documents][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $all['documents']['title'] ?? '' ); ?></textarea></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Документы (картинка + заглавие + описание + атрибуты)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="documents-list">
					<?php foreach ( (array) ( $all['documents']['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$img_id = isset( $it['image'] ) ? (int) $it['image'] : 0;
						$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заглавие">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][image]" value="<?php echo (int) $img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Описание"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="row"><textarea name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][attributes]" rows="2" placeholder="Атрибуты (по одному в строке)"><?php echo esc_textarea( $it['attributes'] ?? '' ); ?></textarea></div>
							<div class="icon-preview cert-preview" style="margin-top:8px;"><?php if ( $img_url ) : ?><img src="<?php echo esc_url( $img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="documents-list"><?php esc_html_e( 'Добавить документ', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		