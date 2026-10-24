<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="compare" data-group="landing">
			<?php $lp = $all['compare'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[compare][lead]" rows="3" style="width:100%" placeholder="Текст под заголовком (перенос строки = новая строка)"><?php echo esc_textarea( $lp['lead'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_criterion]" value="<?php echo esc_attr( $lp['th_criterion'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: критерий"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_self]" value="<?php echo esc_attr( $lp['th_self'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 1"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_mediator]" value="<?php echo esc_attr( $lp['th_mediator'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 2"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_us]" value="<?php echo esc_attr( $lp['th_us'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 3 (золотая)"></div>
			<div class="row">
				<div class="muted">Строки таблицы</div>
				<div data-repeater-list="compare-rows-list">
					<?php foreach ( (array) ( $lp['rows'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][criterion]" value="<?php echo esc_attr( $it['criterion'] ?? '' ); ?>" placeholder="Критерий">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][self]" value="<?php echo esc_attr( $it['self'] ?? '' ); ?>" placeholder="Сам">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][mediator]" value="<?php echo esc_attr( $it['mediator'] ?? '' ); ?>" placeholder="Через посредника">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][us]" value="<?php echo esc_attr( $it['us'] ?? '' ); ?>" placeholder="Напрямую с нами">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="compare-rows-list"><?php esc_html_e( 'Добавить строку', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row"><textarea name="tolstenko_block_defaults[compare][foot_text]" rows="3" style="width:100%" placeholder="Текст под таблицей (перенос строки = новая строка)"><?php echo esc_textarea( $lp['foot_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][btn_url]" value="<?php echo esc_attr( $lp['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		</div>

		