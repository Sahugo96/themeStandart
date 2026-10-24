<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="main_hero" data-group="landing">
		<?php $mh = $all['main_hero'] ?? array(); ?>
		<?php $mh_img_id = (int) ( $mh['image'] ?? 0 ); $mh_img_url = $mh_img_id ? wp_get_attachment_image_url( $mh_img_id, 'medium' ) : ''; ?>
		<?php $mh_present_id = (int) ( $mh['present_image'] ?? 0 ); $mh_present_url = $mh_present_id ? wp_get_attachment_image_url( $mh_present_id, 'medium' ) : ''; ?>

		<div class="muted"><?php esc_html_e( '1. Тег заголовка', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][title_tag]" value="<?php echo esc_attr( $mh['title_tag'] ?? 'h1' ); ?>" style="width:100%" placeholder="h1"></div>

		<div class="muted"><?php esc_html_e( '2. Заголовок (HTML)', 'tolstenko-theme' ); ?></div>
		<div class="row"><textarea name="tolstenko_block_defaults[main_hero][title]" rows="2" style="width:100%" placeholder="Заголовок баннера"><?php echo esc_textarea( $mh['title'] ?? '' ); ?></textarea></div>

		<div class="muted"><?php esc_html_e( '3. Текст (HTML)', 'tolstenko-theme' ); ?></div>
		<div class="row"><textarea name="tolstenko_block_defaults[main_hero][text]" rows="3" style="width:100%" placeholder="Текст баннера"><?php echo esc_textarea( $mh['text'] ?? '' ); ?></textarea></div>

		<div class="muted"><?php esc_html_e( '4. Пункты списка (HTML)', 'tolstenko-theme' ); ?></div>
		<div data-repeater-list="main-hero-list">
			<?php foreach ( (array) ( $mh['items'] ?? array() ) as $idx => $it ) : ?>
				<?php $it = is_array( $it ) ? $it : array(); ?>
				<div class="repeater-item" data-repeater-item>
					<div class="cols">
						<input type="text" name="tolstenko_block_defaults[main_hero][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Пункт списка" style="flex:1">
						<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
						<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
						<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
					</div>
					<div class="row"><textarea name="tolstenko_block_defaults[main_hero][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст пункта"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="actions"><button type="button" class="button" data-add-item="main-hero-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>

		<div class="muted"><?php esc_html_e( '5. Текст кнопки', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][btn_text]" value="<?php echo esc_attr( $mh['btn_text'] ?? 'Оставить заявку' ); ?>" style="width:100%" placeholder="Оставить заявку"></div>

		<div class="muted"><?php esc_html_e( '6. Показывать промо у кнопки', 'tolstenko-theme' ); ?></div>
		<div class="row">
			<label>
				<input type="checkbox" name="tolstenko_block_defaults[main_hero][show_promo]" value="1" <?php checked( ! empty( $mh['show_promo'] ) ); ?>>
				<?php esc_html_e( 'Включить промо', 'tolstenko-theme' ); ?>
			</label>
		</div>

		<div class="muted"><?php esc_html_e( '7. Текст промо (HTML)', 'tolstenko-theme' ); ?></div>
		<div class="row"><textarea name="tolstenko_block_defaults[main_hero][promo_text]" rows="2" style="width:100%" placeholder="Текст промо"><?php echo esc_textarea( $mh['promo_text'] ?? '' ); ?></textarea></div>

		<div class="muted"><?php esc_html_e( '8. Иконка подарка (изображение)', 'tolstenko-theme' ); ?></div>
		<div class="row tolstenko-defaults-image-row">
			<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[main_hero][present_image]" value="<?php echo (int) $mh_present_id; ?>">
			<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
			<div class="icon-preview"><?php if ( $mh_present_url ) : ?><img src="<?php echo esc_url( $mh_present_url ); ?>" alt=""><?php endif; ?></div>
		</div>

		<div class="muted"><?php esc_html_e( '9. Имя персоны', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][person_name]" value="<?php echo esc_attr( $mh['person_name'] ?? '' ); ?>" style="width:100%" placeholder="Имя"></div>

		<div class="muted"><?php esc_html_e( '10. Должность', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][person_position]" value="<?php echo esc_attr( $mh['person_position'] ?? '' ); ?>" style="width:100%" placeholder="Должность"></div>

		<div class="muted"><?php esc_html_e( '11. Изображение баннера', 'tolstenko-theme' ); ?></div>
		<div class="row tolstenko-defaults-image-row">
			<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[main_hero][image]" value="<?php echo (int) $mh_img_id; ?>">
			<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
			<div class="icon-preview"><?php if ( $mh_img_url ) : ?><img src="<?php echo esc_url( $mh_img_url ); ?>" alt=""><?php endif; ?></div>
		</div>
		</div>

