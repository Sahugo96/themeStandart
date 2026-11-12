<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gl = $all['goals'] ?? array();

/**
 * Строка-цель таба (иконка + заголовок + текст); она же — <template> для «Добавить цель».
 */
$goals_row = static function ( string $prefix, array $it ): void {
	$icon     = (int) ( $it['icon'] ?? 0 );
	$icon_url = $icon ? wp_get_attachment_image_url( $icon, 'thumbnail' ) : '';
	?>
	<div class="repeater-item" data-repeater-item>
		<div class="cols">
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заголовок цели" style="flex:1">
			<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $prefix ); ?>[icon]" value="<?php echo (int) $icon; ?>">
			<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Иконка', 'tolstenko-theme' ); ?></button>
			<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
			<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
			<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
		</div>
		<div class="row"><textarea name="<?php echo esc_attr( $prefix ); ?>[text]" rows="2" placeholder="Текст"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
		<div class="icon-preview" style="margin-top:8px;"><?php if ( $icon_url ) : ?><img src="<?php echo esc_url( $icon_url ); ?>" alt=""><?php endif; ?></div>
	</div>
	<?php
};
?>
<div class="tolstenko-df-panel" data-panel="goals" data-group="landing">
	<div class="row"><input type="text" name="tolstenko_block_defaults[goals][badge]" value="<?php echo esc_attr( $gl['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (с золотой чертой)"></div>
	<div class="row"><input type="text" name="tolstenko_block_defaults[goals][title]" value="<?php echo esc_attr( $gl['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
	<div class="row"><textarea name="tolstenko_block_defaults[goals][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $gl['text'] ?? '' ); ?></textarea></div>

	<div class="muted"><?php esc_html_e( 'Цели (иконка + заголовок + текст; без иконки — стандартная по номеру)', 'tolstenko-theme' ); ?></div>
	<div data-repeater-list="goals-items-list" data-name-prefix="tolstenko_block_defaults[goals][items]">
		<?php foreach ( (array) ( $gl['items'] ?? array() ) as $idx => $it ) : ?>
			<?php $goals_row( 'tolstenko_block_defaults[goals][items][' . (int) $idx . ']', is_array( $it ) ? $it : array() ); ?>
		<?php endforeach; ?>
	</div>
	<div class="actions"><button type="button" class="button" data-add-item="goals-items-list"><?php esc_html_e( 'Добавить цель', 'tolstenko-theme' ); ?></button></div>

	<template data-repeater-template="goals-items-list"><?php $goals_row( '__prefix__[__i__]', array() ); ?></template>
</div>
