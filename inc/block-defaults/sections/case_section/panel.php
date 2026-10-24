<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="case_section" data-group="post_sliders">
			<?php
			$cs = $all['case_section'] ?? array();
			$cs_ids = isset( $cs['ids'] ) && is_array( $cs['ids'] ) ? array_map( 'intval', $cs['ids'] ) : array();
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[case_section][subtitle]" value="<?php echo esc_attr( $cs['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[case_section][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $cs['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[case_section][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $cs['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="number" min="-1" name="tolstenko_block_defaults[case_section][posts_per_page]" value="<?php echo esc_attr( (string) ( $cs['posts_per_page'] ?? 4 ) ); ?>" style="width:100%" placeholder="Количество кейсов (4, -1 = все)"></div>
			<div class="row">
				<?php tolstenko_render_post_select( 
					'tolstenko_block_defaults[case_section][ids]',
					$cs_ids,
					'case',
					'Кейсы (пусто = все)'
				); ?>
			</div>
		</div>

		