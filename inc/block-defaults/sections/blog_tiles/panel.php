<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="blog_tiles" data-group="post_sliders">
			<?php
			$bt = $all['blog_tiles'] ?? array();
			// Не сохранён — показываем то же, что выводит сайт (tolstenko_get_block_defaults_raw):
			// раньше плитка брала шапку из таба «Статьи».
			if ( ! array_key_exists( 'blog_tiles', $saved ) && isset( $saved['blog_section_filters'] ) && is_array( $saved['blog_section_filters'] ) ) {
				$bt = tolstenko_blog_tiles_legacy_defaults( $bt, $saved['blog_section_filters'] );
			}
			?>
			<p class="description"><?php esc_html_e( 'Блок «Плитка статей» (архив блога, страница с шаблоном «Archive blog», и рубрики блога): все статьи по 3 в ряд и пагинация. Статьи — основной запрос страницы (рубрика, номер страницы).', 'tolstenko-theme' ); ?></p>

			<div class="muted"><?php esc_html_e( '1. Надзаголовок', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_tiles][badge]" value="<?php echo esc_attr( $bt['badge'] ?? '' ); ?>" style="width:100%" placeholder="Статьи и новости"></div>

			<div class="muted"><?php esc_html_e( '2. Заголовок (HTML, акцентная часть — в <span>)', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[blog_tiles][title]" rows="2" style="width:100%" placeholder="Следим за изменениями <span>в отрасли</span>"><?php echo esc_textarea( $bt['title'] ?? '' ); ?></textarea></div>

			<div class="muted"><?php esc_html_e( '3. Текст под заголовком', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[blog_tiles][text]" rows="3" style="width:100%"><?php echo esc_textarea( $bt['text'] ?? '' ); ?></textarea></div>
		</div>
