<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="hero_stats" data-group="landing">
			<?php $hs = $all['hero_stats'] ?? array(); ?>
			<div class="muted"><?php esc_html_e( 'Пункты (значение + подпись)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="hero-stats-list">
				<?php foreach ( (array) ( $hs['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[hero_stats][items][<?php echo (int) $idx; ?>][num]" value="<?php echo esc_attr( $it['num'] ?? '' ); ?>" placeholder="Значение">
							<input type="text" name="tolstenko_block_defaults[hero_stats][items][<?php echo (int) $idx; ?>][label]" value="<?php echo esc_attr( $it['label'] ?? '' ); ?>" placeholder="Подпись">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="hero-stats-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
		</div>
		