<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="situations" data-group="landing">
			<?php $st = $all['situations'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[situations][badge]" value="<?php echo esc_attr( $st['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[situations][title]" value="<?php echo esc_attr( $st['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="muted"><?php esc_html_e( 'Карточки (по две в слайде)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="situations-list">
				<?php foreach ( (array) ( $st['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[situations][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заголовок">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[situations][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст (можно <span>)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="situations-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
		</div>
		