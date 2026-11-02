<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cm = $all['contacts_maps'] ?? array();
?>
<div class="tolstenko-df-panel" data-panel="contacts_maps" data-group="contacts">
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts_maps][badge]" value="<?php echo esc_attr( $cm['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts_maps][title]" value="<?php echo esc_attr( $cm['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>

	<div class="muted"><?php esc_html_e( 'Адреса (вкладки; при одном адресе вкладок нет)', 'tolstenko-theme' ); ?></div>
	<p class="description"><?php esc_html_e( 'Карта — код iframe из конструктора Яндекс Карт / Google Maps (или ссылка на такую карту). Другие iframe не сохраняются.', 'tolstenko-theme' ); ?></p>
	<div data-repeater-list="contacts-maps-list" data-name-prefix="tolstenko_block_defaults[contacts_maps][items]">
		<?php foreach ( (array) ( $cm['items'] ?? array() ) as $idx => $it ) : ?>
			<?php $it = is_array( $it ) ? $it : array(); ?>
			<div class="repeater-item" data-repeater-item>
				<div class="cols">
					<input type="text" name="tolstenko_block_defaults[contacts_maps][items][<?php echo (int) $idx; ?>][address]" value="<?php echo esc_attr( $it['address'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Адрес — подпись вкладки', 'tolstenko-theme' ); ?>" style="flex:1">
					<?php theme_contacts_admin_row_buttons(); ?>
				</div>
				<div class="row"><textarea name="tolstenko_block_defaults[contacts_maps][items][<?php echo (int) $idx; ?>][map]" rows="3" placeholder="<?php esc_attr_e( '<iframe src="https://yandex.ru/map-widget/v1/?…"></iframe>', 'tolstenko-theme' ); ?>"><?php echo esc_textarea( $it['map'] ?? '' ); ?></textarea></div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="actions"><button type="button" class="button" data-add-item="contacts-maps-list"><?php esc_html_e( 'Добавить адрес', 'tolstenko-theme' ); ?></button></div>

	<template data-repeater-template="contacts-maps-list">
		<div class="repeater-item" data-repeater-item>
			<div class="cols">
				<input type="text" name="__prefix__[__i__][address]" value="" placeholder="<?php esc_attr_e( 'Адрес — подпись вкладки', 'tolstenko-theme' ); ?>" style="flex:1">
				<?php theme_contacts_admin_row_buttons(); ?>
			</div>
			<div class="row"><textarea name="__prefix__[__i__][map]" rows="3" placeholder="<?php esc_attr_e( '<iframe src="https://yandex.ru/map-widget/v1/?…"></iframe>', 'tolstenko-theme' ); ?>"></textarea></div>
		</div>
	</template>
</div>
