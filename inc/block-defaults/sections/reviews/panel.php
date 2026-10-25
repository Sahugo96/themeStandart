<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="reviews" data-group="post_sliders">
			<?php
			$rv      = $all['reviews'] ?? array();
			$rv_ids  = isset( $rv['ids'] ) && is_array( $rv['ids'] ) ? array_map( 'intval', $rv['ids'] ) : array();
			$rv_cards = isset( $rv['cards'] ) && is_array( $rv['cards'] ) ? $rv['cards'] : array();
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[reviews][subtitle]" value="<?php echo esc_attr( $rv['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[reviews][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $rv['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[reviews][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $rv['text'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Общий рейтинг', 'tolstenko-theme' ); ?></div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[reviews][score]" value="<?php echo esc_attr( $rv['score'] ?? '' ); ?>" placeholder="Оценка (4.9)" style="width:120px">
				<input type="text" name="tolstenko_block_defaults[reviews][score_max]" value="<?php echo esc_attr( $rv['score_max'] ?? '' ); ?>" placeholder="Из (5)" style="width:80px">
				<input type="text" name="tolstenko_block_defaults[reviews][score_text]" value="<?php echo esc_attr( $rv['score_text'] ?? '' ); ?>" placeholder="Подпись (На основе 300+ отзывов)" style="flex:1">
			</div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[reviews][btn_text]" value="<?php echo esc_attr( $rv['btn_text'] ?? '' ); ?>" placeholder="Кнопка справа от табов (Оставить отзыв)">
				<input type="text" name="tolstenko_block_defaults[reviews][btn_url]" value="<?php echo esc_attr( $rv['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки (пусто = #modal)" style="flex:1">
			</div>
			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[reviews][show_items]" value="1" <?php checked( ! empty( $rv['show_items'] ) ); ?>>
					<?php esc_html_e( 'Показывать карточки площадок (рейтинги)', 'tolstenko-theme' ); ?>
				</label>
			</div>
			<div class="row">
				<?php tolstenko_render_post_select( 
					'tolstenko_block_defaults[reviews][ids]',
					$rv_ids,
					'review',
					'Отзывы (пусто = все)'
				); ?>
			</div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Карточки площадок: название (подпись), ссылка, рейтинг, иконка', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="reviews-cards-list">
					<?php foreach ( $rv_cards as $idx => $card ) : ?>
						<?php
						$card    = is_array( $card ) ? $card : array();
						$c_title = (string) ( $card['title'] ?? '' );
						$c_url   = (string) ( $card['url'] ?? '' );
						$c_rating = (string) ( $card['rating'] ?? '' );
						$c_icon   = (int) ( $card['icon'] ?? 0 );
						$c_icon_url = $c_icon ? wp_get_attachment_image_url( $c_icon, 'thumbnail' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $c_title ); ?>" placeholder="Название (Яндекс, 2ГИС…)" style="flex:1">
								<input type="url" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][url]" value="<?php echo esc_attr( $c_url ); ?>" placeholder="Ссылка" style="flex:1">
								<input type="number" min="0" max="5" step="0.1" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][rating]" value="<?php echo esc_attr( $c_rating ); ?>" style="width:80px" title="Рейтинг (4.9)">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $c_icon; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Иконка', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="icon-preview" style="margin-top:8px;"><?php if ( $c_icon_url ) : ?><img src="<?php echo esc_url( $c_icon_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<button type="button" class="button" data-add-item="reviews-cards-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button>
			</div>
		</div>

		