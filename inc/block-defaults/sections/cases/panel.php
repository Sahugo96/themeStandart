<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="cases" data-group="landing">
			<?php $csd = $all['cases'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][badge]" value="<?php echo esc_attr( $csd['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cases][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $csd['title'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][all_text]" value="<?php echo esc_attr( $csd['all_text'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка «Все кейсы» — текст"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][all_url]" value="<?php echo esc_attr( $csd['all_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка «Все кейсы» — URL"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cases][foot_text]" rows="2" placeholder="Текст под слайдером"><?php echo esc_textarea( $csd['foot_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][btn_text]" value="<?php echo esc_attr( $csd['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Кнопка под слайдером"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][btn_url]" value="<?php echo esc_attr( $csd['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
			<p class="description"><?php esc_html_e( 'Карточки берутся из записей «Кейсы» (CPT case), фильтр — по категориям кейсов.', 'tolstenko-theme' ); ?></p>
		</div>