<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="result" data-group="landing">
			<?php $lp = $all['result'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[result][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[result][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок"></div>
			<div class="row">
				<div class="muted">Карточки (иконка + название + текст)</div>
				<div data-repeater-list="result-items-list">
					<?php foreach ( (array) ( $lp['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$it_img_id  = isset( $it['icon'] ) ? (int) $it['icon'] : 0;
						$it_img_url = $it_img_id ? wp_get_attachment_image_url( $it_img_id, 'thumbnail' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $it_img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать иконку', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="icon-preview" style="margin-top:8px;"><?php if ( $it_img_url ) : ?><img src="<?php echo esc_url( $it_img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="result-items-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		