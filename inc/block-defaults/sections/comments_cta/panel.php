<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cc = $all['comments_cta'] ?? array();
?>
<div class="tolstenko-df-panel" data-panel="comments_cta" data-group="landing">
	<div class="row"><textarea name="tolstenko_block_defaults[comments_cta][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML: <br> — перенос, <span>…</span> — золотая строка)"><?php echo esc_textarea( $cc['title'] ?? '' ); ?></textarea></div>
	<div class="row"><textarea name="tolstenko_block_defaults[comments_cta][text]" rows="3" style="width:100%" placeholder="Текст"><?php echo esc_textarea( $cc['text'] ?? '' ); ?></textarea></div>
	<div class="cols">
		<input type="text" name="tolstenko_block_defaults[comments_cta][btn_text]" value="<?php echo esc_attr( $cc['btn_text'] ?? '' ); ?>" placeholder="Текст кнопки (Читать комментарии)" style="flex:1">
		<input type="text" name="tolstenko_block_defaults[comments_cta][btn_url]" value="<?php echo esc_attr( $cc['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки (пусто = к комментариям, #comments)" style="flex:1">
	</div>
	<p class="description"><?php esc_html_e( 'Выводится на страницах с шаблоном «Страница документа» между FAQ и «Похожими статьями».', 'tolstenko-theme' ); ?></p>
</div>
