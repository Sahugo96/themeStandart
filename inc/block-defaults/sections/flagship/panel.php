<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="flagship" data-group="landing">
			<?php $flg = $all['flagship'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[flagship][badge]" value="<?php echo esc_attr( $flg['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[flagship][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $flg['title'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Карточки программ', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="flagship-cards-list">
				<?php foreach ( (array) ( $flg['cards'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$flag_id = (int) ( $it['flag'] ?? 0 );
					$flag_url = $flag_id ? wp_get_attachment_image_url( $flag_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][country]" value="<?php echo esc_attr( $it['country'] ?? '' ); ?>" placeholder="Страна">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][flag]" value="<?php echo (int) $flag_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></button>
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $flag_url ) : ?><img src="<?php echo esc_url( $flag_url ); ?>" alt=""><?php endif; ?></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][price]" value="<?php echo esc_attr( $it['price'] ?? '' ); ?>" placeholder="Цена (HTML)">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название программы">
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][text]" rows="3" placeholder="Описание (HTML)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
						<div class="row"><textarea name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][facts]" rows="3" placeholder="Факты (по одному в строке: «Подпись: значение»)"><?php echo esc_textarea( $it['facts'] ?? '' ); ?></textarea></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][btn_text]" value="<?php echo esc_attr( $it['btn_text'] ?? '' ); ?>" placeholder="Кнопка">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][btn_url]" value="<?php echo esc_attr( $it['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="flagship-cards-list"><?php esc_html_e( 'Добавить программу', 'tolstenko-theme' ); ?></button></div>
		</div>