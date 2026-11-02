<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ct = $all['contacts'] ?? array();
?>
<div class="tolstenko-df-panel" data-panel="contacts" data-group="landing">
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts][badge]" value="<?php echo esc_attr( $ct['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts][title]" value="<?php echo esc_attr( $ct['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
	<div class="cols">
		<input type="text" name="tolstenko_block_defaults[contacts][call_text]" value="<?php echo esc_attr( $ct['call_text'] ?? '' ); ?>" placeholder="Кнопка звонка (Позвонить сейчас)" style="flex:1">
		<input type="text" name="tolstenko_block_defaults[contacts][tg_text]" value="<?php echo esc_attr( $ct['tg_text'] ?? '' ); ?>" placeholder="Кнопка Telegram (Написать в Telegram)" style="flex:1">
	</div>
	<p class="description"><?php esc_html_e( 'Номер для «Позвонить» и ссылка Telegram — из «Настройки сайта → Контактные данные». Пустой текст кнопки — кнопки нет.', 'tolstenko-theme' ); ?></p>

	<div class="muted"><?php esc_html_e( 'Адреса (вкладки; при одном адресе вкладок нет)', 'tolstenko-theme' ); ?></div>
	<div data-repeater-list="contacts-addresses-list" data-name-prefix="tolstenko_block_defaults[contacts][addresses]">
		<?php foreach ( (array) ( $ct['addresses'] ?? array() ) as $a_idx => $addr ) : ?>
			<?php theme_contacts_admin_address_row( 'tolstenko_block_defaults[contacts][addresses][' . (int) $a_idx . ']', is_array( $addr ) ? $addr : array() ); ?>
		<?php endforeach; ?>
	</div>
	<div class="actions"><button type="button" class="button" data-add-item="contacts-addresses-list"><?php esc_html_e( 'Добавить адрес', 'tolstenko-theme' ); ?></button></div>

	<?php theme_contacts_admin_templates(); ?>
</div>
