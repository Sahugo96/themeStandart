<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cdt = $all['contacts_details'] ?? array();
?>
<div class="tolstenko-df-panel" data-panel="contacts_details" data-group="contacts">
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts_details][badge]" value="<?php echo esc_attr( $cdt['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts_details][title]" value="<?php echo esc_attr( $cdt['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>

	<div class="muted"><?php esc_html_e( 'Реквизиты (каждый пункт — HTML: <p>, <strong>, ссылки)', 'tolstenko-theme' ); ?></div>
	<div data-repeater-list="contacts-details-list" data-name-prefix="tolstenko_block_defaults[contacts_details][items]">
		<?php foreach ( (array) ( $cdt['items'] ?? array() ) as $idx => $it ) : ?>
			<?php $it = is_array( $it ) ? $it : array( 'text' => (string) $it ); ?>
			<div class="repeater-item" data-repeater-item>
				<div class="cols">
					<textarea name="tolstenko_block_defaults[contacts_details][items][<?php echo (int) $idx; ?>][text]" rows="2" style="flex:1" placeholder="<?php esc_attr_e( '<p><strong>ИНН:</strong> …</p>', 'tolstenko-theme' ); ?>"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea>
					<?php theme_contacts_admin_row_buttons(); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="actions"><button type="button" class="button" data-add-item="contacts-details-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>

	<div class="muted"><?php esc_html_e( 'Форма', 'tolstenko-theme' ); ?></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts_details][form_title]" value="<?php echo esc_attr( $cdt['form_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок формы"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts_details][form_text]" value="<?php echo esc_attr( $cdt['form_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст над формой"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[contacts_details][form_shortcode]" value="<?php echo esc_attr( $cdt['form_shortcode'] ?? '' ); ?>" style="width:100%" placeholder='Шорткод формы CF7, например [contact-form-7 id="a5143be" title="Модалка"]'></div>

	<template data-repeater-template="contacts-details-list">
		<div class="repeater-item" data-repeater-item>
			<div class="cols">
				<textarea name="__prefix__[__i__][text]" rows="2" style="flex:1" placeholder="<?php esc_attr_e( '<p><strong>ИНН:</strong> …</p>', 'tolstenko-theme' ); ?>"></textarea>
				<?php theme_contacts_admin_row_buttons(); ?>
			</div>
		</div>
	</template>
</div>
