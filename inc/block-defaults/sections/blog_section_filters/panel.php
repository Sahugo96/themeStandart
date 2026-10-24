<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="blog_section_filters" data-group="post_sliders">
			<?php
			$bsf = $all['blog_section_filters'] ?? array();
			tolstenko_render_blog_section_defaults_fields( 'blog_section_filters', $bsf );
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_section_filters][btn_text]" value="<?php echo esc_attr( $bsf['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки под списком (Все статьи)"></div>
			<p class="description"><?php esc_html_e( 'Слайдер с фильтром по рубрикам blog_cat. Кнопка всегда ведёт на страницу блога.', 'tolstenko-theme' ); ?></p>
		</div>


		