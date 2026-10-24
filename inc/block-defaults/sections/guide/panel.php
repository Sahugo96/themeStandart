<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="guide" data-group="landing">
			<?php $lp = $all['guide'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][subtitle]" value="<?php echo esc_attr( $lp['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[guide][title]" rows="3" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $lp['title'] ?? '' ); ?></textarea></div>
			<div class="muted">Статья (запись блога)</div>
			<div class="row">
				<select name="tolstenko_block_defaults[guide][post_id]" style="min-width:320px;max-width:100%">
					<option value="0"><?php esc_html_e( '— Не выбрано —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $lp_blog_posts as $lp_post ) : ?>
						<option value="<?php echo (int) $lp_post['id']; ?>" <?php selected( (int) ( $lp['post_id'] ?? 0 ), (int) $lp_post['id'] ); ?>><?php echo esc_html( $lp_post['title'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="muted">Карточка статьи</div>
			<div class="row">
				<div data-repeater-list="guide-tags-list">
					<?php foreach ( (array) ( $lp['tags'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array(); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[guide][tags][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Тег">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="guide-tags-list"><?php esc_html_e( 'Добавить тег', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][time]" value="<?php echo esc_attr( $lp['time'] ?? '' ); ?>" style="width:100%" placeholder="Время чтения"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][views]" value="<?php echo esc_attr( $lp['views'] ?? '' ); ?>" style="width:100%" placeholder="Просмотры"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][date_label]" value="<?php echo esc_attr( $lp['date_label'] ?? '' ); ?>" style="width:100%" placeholder="Дата (подпись)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][date]" value="<?php echo esc_attr( $lp['date'] ?? '' ); ?>" style="width:100%" placeholder="Дата ISO (2026-07-19)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][card_title]" value="<?php echo esc_attr( $lp['card_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок карточки"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[guide][text]" rows="5" placeholder="Текст карточки (HTML)"><?php echo esc_textarea( $lp['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row">
				<div class="muted">Изображение</div>
				<?php $g_img = (int) ( $lp['image'] ?? 0 ); $g_url = $g_img ? wp_get_attachment_image_url( $g_img, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[guide][image]" value="<?php echo (int) $g_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $g_url ) : ?><img src="<?php echo esc_url( $g_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>

		