<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$seo         = $all['seo_section'] ?? array();
$seo_layouts = theme_seo_section_layout_labels();
?>
<div class="tolstenko-df-panel" data-panel="seo_section" data-group="landing">
	<div class="row"><input type="text" name="tolstenko_block_defaults[seo_section][badge]" value="<?php echo esc_attr( $seo['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[seo_section][title]" value="<?php echo esc_attr( $seo['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[seo_section][more_text]" value="<?php echo esc_attr( $seo['more_text'] ?? '' ); ?>" style="width:100%" placeholder="Кнопка раскрытия (Читать далее)"></div>

	<div class="muted"><?php esc_html_e( 'Содержимое (текст свёрнут, полностью — по кнопке)', 'tolstenko-theme' ); ?></div>
	<p class="description"><?php esc_html_e( 'Выберите вид блока — появятся только его поля. Тексты — HTML (абзацы <p>, списки, <h3>).', 'tolstenko-theme' ); ?></p>
	<div data-repeater-list="seo-rows-list">
		<?php foreach ( (array) ( $seo['rows'] ?? array() ) as $idx => $row ) : ?>
			<?php theme_seo_section_render_admin_row( 'tolstenko_block_defaults[seo_section][rows][' . (int) $idx . ']', is_array( $row ) ? $row : array() ); ?>
		<?php endforeach; ?>
	</div>
	<template id="seo-row-template"><?php theme_seo_section_render_admin_row( 'tolstenko_block_defaults[seo_section][rows][__i__]', array() ); ?></template>
	<div class="actions"><button type="button" class="button" data-add-item="seo-rows-list"><?php esc_html_e( 'Добавить блок', 'tolstenko-theme' ); ?></button></div>
</div>
