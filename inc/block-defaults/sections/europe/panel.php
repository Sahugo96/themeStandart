<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="europe" data-group="landing">
			<?php $eur = $all['europe'] ?? array(); ?>
			<div class="row"><textarea name="tolstenko_block_defaults[europe][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $eur['title'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Страны (таблица)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="europe-rows-list">
				<?php foreach ( (array) ( $eur['rows'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$flag_id = (int) ( $it['flag'] ?? 0 );
					$flag_url = $flag_id ? wp_get_attachment_image_url( $flag_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][country]" value="<?php echo esc_attr( $it['country'] ?? '' ); ?>" placeholder="Страна">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][flag]" value="<?php echo (int) $flag_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></button>
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][note]" value="<?php echo esc_attr( $it['note'] ?? '' ); ?>" placeholder="Примечание">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $flag_url ) : ?><img src="<?php echo esc_url( $flag_url ); ?>" alt=""><?php endif; ?></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][price]" value="<?php echo esc_attr( $it['price'] ?? '' ); ?>" placeholder="Стоимость">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][term]" value="<?php echo esc_attr( $it['term'] ?? '' ); ?>" placeholder="Срок оформления">
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][benefits]" rows="3" placeholder="Преимущества (по одному в строке)"><?php echo esc_textarea( $it['benefits'] ?? '' ); ?></textarea></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][link_text]" value="<?php echo esc_attr( $it['link_text'] ?? '' ); ?>" placeholder="Ссылка — текст">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][link_url]" value="<?php echo esc_attr( $it['link_url'] ?? '' ); ?>" placeholder="Ссылка — URL">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="europe-rows-list"><?php esc_html_e( 'Добавить страну', 'tolstenko-theme' ); ?></button></div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[europe][link_text]" value="<?php echo esc_attr( $eur['link_text'] ?? '' ); ?>" placeholder="Ссылка по умолчанию — текст">
				<input type="text" name="tolstenko_block_defaults[europe][link_url]" value="<?php echo esc_attr( $eur['link_url'] ?? '' ); ?>" placeholder="Ссылка по умолчанию — URL">
			</div>
			<div class="row"><textarea name="tolstenko_block_defaults[europe][foot_text]" rows="2" placeholder="Текст под таблицей"><?php echo esc_textarea( $eur['foot_text'] ?? '' ); ?></textarea></div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[europe][btn_text]" value="<?php echo esc_attr( $eur['btn_text'] ?? '' ); ?>" placeholder="Кнопка под таблицей">
				<input type="text" name="tolstenko_block_defaults[europe][btn_url]" value="<?php echo esc_attr( $eur['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки">
			</div>
		</div>

		