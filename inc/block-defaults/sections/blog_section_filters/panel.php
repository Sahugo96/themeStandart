<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="blog_section_filters" data-group="post_sliders">
			<?php
			$bsf     = $all['blog_section_filters'] ?? array();
			$bsf_ids = tolstenko_sanitize_service_section_ids( $bsf['ids'] ?? array() );
			?>
			<p class="description"><?php esc_html_e( 'Секция «Статьи» (блок «Секция статей», на главной — после «ВНЖ в Европе»). На десктопе первая статья крупная, остальные — списком справа; на мобильных — слайдер по одной карточке.', 'tolstenko-theme' ); ?></p>

			<div class="muted"><?php esc_html_e( '1. Бейдж над заголовком', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_section_filters][badge]" value="<?php echo esc_attr( $bsf['badge'] ?? '' ); ?>" style="width:100%" placeholder="Статьи и новости"></div>

			<div class="muted"><?php esc_html_e( '2. Заголовок (HTML, акцентная часть — в <span>)', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[blog_section_filters][title]" rows="2" style="width:100%" placeholder="Следим за изменениями <span>в отрасли</span>"><?php echo esc_textarea( $bsf['title'] ?? '' ); ?></textarea></div>

			<div class="muted"><?php esc_html_e( '3. Статьи', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<?php
				tolstenko_render_post_select(
					'tolstenko_block_defaults[blog_section_filters][ids]',
					$bsf_ids,
					'blog',
					'Статьи (пусто = самые новые)'
				);
				?>
			</div>

			<div class="muted"><?php esc_html_e( '4. Сколько статей выводить, если выше ничего не выбрано', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="number" min="1" max="12" name="tolstenko_block_defaults[blog_section_filters][posts_per_page]" value="<?php echo esc_attr( (string) ( $bsf['posts_per_page'] ?? 4 ) ); ?>" style="width:120px"></div>

			<div class="muted"><?php esc_html_e( '5. Текст кнопки (ведёт на страницу блога)', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_section_filters][btn_text]" value="<?php echo esc_attr( $bsf['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Перейти в блог"></div>

			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[blog_section_filters][show_filter]" value="1" <?php checked( ! empty( $bsf['show_filter'] ) ); ?>>
					<?php esc_html_e( 'Фильтр по рубрикам над статьями (переключение без перезагрузки)', 'tolstenko-theme' ); ?>
				</label>
			</div>
		</div>

