<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
		$ftpl = $all['field_template'] ?? array();
		$ftpl_img_id = isset( $ftpl['image'] ) ? (int) $ftpl['image'] : 0;
		$ftpl_img_url = $ftpl_img_id ? wp_get_attachment_image_url( $ftpl_img_id, 'medium' ) : '';
		$ftpl_post_ids = isset( $ftpl['post_ids'] ) && is_array( $ftpl['post_ids'] ) ? array_map( 'intval', $ftpl['post_ids'] ) : array();
		$ftpl_single_post_id = isset( $ftpl['single_post_id'] ) ? (int) $ftpl['single_post_id'] : 0;
		$ftpl_action_posts = get_posts(
			array(
				'post_type'      => 'actions',
				'posts_per_page' => 100,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
?>
<div class="tolstenko-df-panel" data-panel="field_template">
			<p class="description"><?php esc_html_e( 'Эталонная панель со всеми типами полей: чекбокс, текстовое поле, текстовая область, визуальный редактор, изображение, повторитель, множественный выбор записей и выбор одной записи. Ключ панели (field_template) совпадает с ключом блока my-theme/field-template.', 'tolstenko-theme' ); ?></p>
			<div class="muted"><?php esc_html_e( '0. Чекбокс', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[field_template][enabled]" value="1" <?php checked( ! empty( $ftpl['enabled'] ) ); ?>>
					<?php esc_html_e( 'Включить / показывать блок', 'tolstenko-theme' ); ?>
				</label>
			</div>
			<div class="muted"><?php esc_html_e( '1. Текстовое поле', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[field_template][text_field]" value="<?php echo esc_attr( $ftpl['text_field'] ?? '' ); ?>" style="width:100%" placeholder="Однострочное текстовое поле"></div>
			<div class="muted"><?php esc_html_e( '2. Текстовая область', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[field_template][textarea_field]" rows="3" style="width:100%" placeholder="Многострочная текстовая область"><?php echo esc_textarea( $ftpl['textarea_field'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( '3. Редактор (rich text)', 'tolstenko-theme' ); ?></div>
			<div class="row tolstenko-faq-editor-wrap"><?php tolstenko_field_template_editor( (string) ( $ftpl['editor_field'] ?? '' ), 'tolstenko_field_template_editor_0', 'tolstenko_block_defaults[field_template][editor_field]' ); ?></div>
			<div class="muted"><?php esc_html_e( '4. Изображение', 'tolstenko-theme' ); ?></div>
			<div class="row tolstenko-defaults-image-row">
				<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[field_template][image]" value="<?php echo (int) $ftpl_img_id; ?>">
				<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
				<div class="icon-preview field-template-preview"><?php if ( $ftpl_img_url ) : ?><img src="<?php echo esc_url( $ftpl_img_url ); ?>" alt=""><?php endif; ?></div>
			</div>
			<div class="muted"><?php esc_html_e( '5. Повторитель', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<div data-repeater-list="field-template-list">
					<?php foreach ( (array) ( $ftpl['items'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array( 'title' => '', 'text' => '' ); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[field_template][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Текстовое поле (заголовок)" style="flex:1">
								<button type="button" class="button move-btn" data-move-up title="<?php esc_attr_e( 'Вверх', 'tolstenko-theme' ); ?>">&uarr;</button>
								<button type="button" class="button move-btn" data-move-down title="<?php esc_attr_e( 'Вниз', 'tolstenko-theme' ); ?>">&darr;</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[field_template][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="<?php esc_attr_e( 'Текстовая область', 'tolstenko-theme' ); ?>"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="field-template-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
			<div class="muted"><?php esc_html_e( '6. Множественный выбор записей', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<?php tolstenko_render_post_select(
					'tolstenko_block_defaults[field_template][post_ids]',
					$ftpl_post_ids,
					'case',
					'Записи (пусто = все)'
				); ?>
			</div>
			<div class="muted"><?php esc_html_e( '7. Выбор одной записи', 'tolstenko-theme' ); ?></div>
			<div class="cols">
				<select name="tolstenko_block_defaults[field_template][single_post_id]" style="min-width:220px">
					<option value="0"><?php esc_html_e( '— Без ссылки —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $ftpl_action_posts as $ap ) : ?>
						<option value="<?php echo (int) $ap->ID; ?>" <?php selected( $ftpl_single_post_id, (int) $ap->ID ); ?>><?php echo esc_html( get_the_title( $ap ) ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			</div>
		</div>

		<?php $lp_blog_posts = tolstenko_get_posts_for_select( 'blog' ); ?>
		<?php $mh = $all['main_hero'] ?? array(); ?>
		<?php $mh_img_id = isset( $mh['image'] ) ? (int) $mh['image'] : 0; ?>
		<?php $mh_img_url = $mh_img_id ? wp_get_attachment_image_url( $mh_img_id, 'medium' ) : ''; ?>
		<?php $mh_present_id = isset( $mh['present_image'] ) ? (int) $mh['present_image'] : 0; ?>
		<?php $mh_present_url = $mh_present_id ? wp_get_attachment_image_url( $mh_present_id, 'medium' ) : ''; ?>

		