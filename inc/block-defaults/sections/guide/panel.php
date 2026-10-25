<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="guide" data-group="landing">
			<?php $lp = $all['guide'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][subtitle]" value="<?php echo esc_attr( $lp['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[guide][title]" rows="3" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $lp['title'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Статья', 'tolstenko-theme' ); ?></div>
			<div class="cols">
				<select name="tolstenko_block_defaults[guide][post_id]" style="min-width:320px;max-width:100%">
					<option value="0"><?php esc_html_e( '— Последняя статья —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $lp_blog_posts as $lp_post ) : ?>
						<option value="<?php echo (int) $lp_post['id']; ?>" <?php selected( (int) ( $lp['post_id'] ?? 0 ), (int) $lp_post['id'] ); ?>><?php echo esc_html( $lp_post['title'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<p class="description"><?php esc_html_e( 'Карточка (рубрики, время чтения, просмотры, дата, заголовок, текст, изображение) берётся из статьи: метабокс «Карточка статьи» и миниатюра записи.', 'tolstenko-theme' ); ?></p>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
		</div>

		