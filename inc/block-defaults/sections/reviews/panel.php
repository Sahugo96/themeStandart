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
			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[reviews][show_items]" value="1" <?php checked( ! empty( $rv['show_items'] ) ); ?>>
					<?php esc_html_e( 'Показывать блок рейтингов (reviews__items)', 'tolstenko-theme' ); ?>
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
				<div class="muted"><?php esc_html_e( 'Карточки рейтингов (reviews__items)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="reviews-cards-list">
					<?php foreach ( $rv_cards as $idx => $card ) : ?>
						<?php
						$card    = is_array( $card ) ? $card : array();
						$c_title = (string) ( $card['title'] ?? '' );
						$c_url   = (string) ( $card['url'] ?? '' );
						$c_rating = isset( $card['rating'] ) ? (int) $card['rating'] : 5;
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $c_title ); ?>" placeholder="Название (Яндекс, 2ГИС…)" style="flex:1">
								<input type="url" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][url]" value="<?php echo esc_attr( $c_url ); ?>" placeholder="Ссылка" style="flex:1">
								<input type="number" min="1" max="5" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][rating]" value="<?php echo (int) $c_rating; ?>" style="width:80px" title="Рейтинг">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<button type="button" class="button" data-add-item="reviews-cards-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button>
			</div>
		</div>

		