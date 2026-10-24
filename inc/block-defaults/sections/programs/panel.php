<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="programs" data-group="landing">
			<?php $prg = $all['programs'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[programs][badge]" value="<?php echo esc_attr( $prg['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[programs][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $prg['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[programs][lead]" rows="3" placeholder="Текст под заголовком (HTML)"><?php echo esc_textarea( $prg['lead'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Колонки (первая — категория; «Акцент» = 1 — золотая)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="programs-columns-list">
				<?php foreach ( (array) ( $prg['columns'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$flag_id = (int) ( $it['flag'] ?? 0 );
					$flag_url = $flag_id ? wp_get_attachment_image_url( $flag_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[programs][columns][<?php echo (int) $idx; ?>][name]" value="<?php echo esc_attr( $it['name'] ?? '' ); ?>" placeholder="Название">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[programs][columns][<?php echo (int) $idx; ?>][flag]" value="<?php echo (int) $flag_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></button>
							<input type="text" name="tolstenko_block_defaults[programs][columns][<?php echo (int) $idx; ?>][accent]" value="<?php echo esc_attr( $it['accent'] ?? '' ); ?>" placeholder="Акцент (1)" style="width:110px">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $flag_url ) : ?><img src="<?php echo esc_url( $flag_url ); ?>" alt=""><?php endif; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="programs-columns-list"><?php esc_html_e( 'Добавить колонку', 'tolstenko-theme' ); ?></button></div>
			<div class="muted"><?php esc_html_e( 'Строки таблицы', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="programs-rows-list">
				<?php foreach ( (array) ( $prg['rows'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[programs][rows][<?php echo (int) $idx; ?>][criterion]" value="<?php echo esc_attr( $it['criterion'] ?? '' ); ?>" placeholder="Критерий">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[programs][rows][<?php echo (int) $idx; ?>][values]" rows="4" placeholder="Значения по колонкам (по одному в строке)"><?php echo esc_textarea( $it['values'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="programs-rows-list"><?php esc_html_e( 'Добавить строку', 'tolstenko-theme' ); ?></button></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[programs][btn_text]" value="<?php echo esc_attr( $prg['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Кнопка"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[programs][btn_url]" value="<?php echo esc_attr( $prg['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		</div>