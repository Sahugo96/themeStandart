<?php
/**
 * Слайдеры под статьёй (CPT blog): «Похожие статьи» и «Слайдер услуг» —
 * группа мета-полей на статье. Пустые поля → общие настройки секций.
 *
 * Перенесено из tolstenko.marketing (inc/blog/sliders-metabox.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes_blog', 'tolstenko_blog_sliders_add_metabox' );
add_action( 'save_post_blog', 'tolstenko_blog_sliders_save_metabox', 10, 2 );

/**
 * Данные «Похожих статей» для статьи (для theme_get_blog_related_data()).
 * null — блок на статье скрыт.
 *
 * @param int $post_id Post ID.
 * @return array|null
 */
function tolstenko_get_blog_related_overrides( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();

	if ( get_post_meta( $post_id, 'blog_related_hidden', true ) === '1' ) {
		return null;
	}

	return array(
		'title'   => trim( (string) get_post_meta( $post_id, 'blog_related_title', true ) ),
		'postIds' => tolstenko_sanitize_ids( get_post_meta( $post_id, 'blog_related_ids', true ) ),
	);
}

/**
 * Данные «Слайдера услуг» для статьи (для theme_get_services_slider_simple_data()).
 * null — блок на статье скрыт.
 *
 * @param int $post_id Post ID.
 * @return array|null
 */
function tolstenko_get_blog_services_overrides( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();

	if ( get_post_meta( $post_id, 'blog_services_hidden', true ) === '1' ) {
		return null;
	}

	return array(
		'title'   => trim( (string) get_post_meta( $post_id, 'blog_services_title', true ) ),
		'text'    => trim( (string) get_post_meta( $post_id, 'blog_services_text', true ) ),
		'postIds' => tolstenko_sanitize_ids( get_post_meta( $post_id, 'blog_services_ids', true ) ),
	);
}

function tolstenko_blog_sliders_add_metabox() {
	add_meta_box(
		'tolstenko_blog_sliders',
		__( 'Слайдеры под статьёй', 'tolstenko-theme' ),
		'tolstenko_blog_sliders_render_metabox',
		'blog',
		'normal',
		'default'
	);
}

/**
 * @param WP_Post $post Post.
 */
function tolstenko_blog_sliders_render_metabox( $post ) {
	wp_nonce_field( 'tolstenko_blog_sliders_save', 'tolstenko_blog_sliders_nonce' );

	$rel_hidden = (string) get_post_meta( $post->ID, 'blog_related_hidden', true );
	$rel_title  = (string) get_post_meta( $post->ID, 'blog_related_title', true );
	$rel_ids    = tolstenko_sanitize_ids( get_post_meta( $post->ID, 'blog_related_ids', true ) );

	$svc_hidden = (string) get_post_meta( $post->ID, 'blog_services_hidden', true );
	$svc_title  = (string) get_post_meta( $post->ID, 'blog_services_title', true );
	$svc_text   = (string) get_post_meta( $post->ID, 'blog_services_text', true );
	$svc_ids    = tolstenko_sanitize_ids( get_post_meta( $post->ID, 'blog_services_ids', true ) );

	tolstenko_post_select_print_assets();
	?>
	<style>
		.tolstenko-blog-sliders .tolstenko-bs-block{border:1px solid #dcdcde;background:#fff;padding:14px 16px;margin:0 0 16px;max-width:none;width:100%;box-sizing:border-box}
		.tolstenko-blog-sliders .tolstenko-bs-block h3{margin:0 0 8px;font-size:14px}
		.tolstenko-blog-sliders .tolstenko-bs-field{margin:0 0 12px}
		.tolstenko-blog-sliders .tolstenko-bs-field input[type=text],
		.tolstenko-blog-sliders .tolstenko-bs-field textarea{width:100%;max-width:none;box-sizing:border-box}
		.tolstenko-blog-sliders .description{margin:0 0 12px}
	</style>

	<div class="tolstenko-blog-sliders">
		<p class="description"><?php esc_html_e( 'Выводятся под статьёй после FAQ теми же секциями, что на главной («Статьи» и «Услуги»). Пустые поля — из «Дефолтов блоков».', 'tolstenko-theme' ); ?></p>

		<div class="tolstenko-bs-block">
			<h3><?php esc_html_e( 'Похожие статьи', 'tolstenko-theme' ); ?></h3>
			<p class="tolstenko-bs-field">
				<label>
					<input type="hidden" name="tolstenko_blog_related_hidden" value="0">
					<input type="checkbox" name="tolstenko_blog_related_hidden" value="1" <?php checked( $rel_hidden, '1' ); ?>>
					<?php esc_html_e( 'Скрыть «Похожие статьи» на этой статье', 'tolstenko-theme' ); ?>
				</label>
			</p>
			<p class="tolstenko-bs-field">
				<label for="tolstenko_blog_related_title"><strong><?php esc_html_e( 'Заголовок (HTML, акцент — <span>)', 'tolstenko-theme' ); ?></strong></label><br>
				<input type="text" id="tolstenko_blog_related_title" name="tolstenko_blog_related_title" value="<?php echo esc_attr( $rel_title ); ?>" placeholder="<?php esc_attr_e( 'Пусто = «Похожие <span>статьи</span>»', 'tolstenko-theme' ); ?>">
			</p>
			<div class="tolstenko-bs-field">
				<strong><?php esc_html_e( 'Статьи', 'tolstenko-theme' ); ?></strong>
				<p class="description" style="margin:4px 0 8px;"><?php esc_html_e( 'Пусто — последние статьи. Текущая статья исключается.', 'tolstenko-theme' ); ?></p>
				<?php
				tolstenko_render_post_select(
					'tolstenko_blog_related_ids',
					$rel_ids,
					'blog',
					'',
					array( 'exclude_ids' => array( (int) $post->ID ) )
				);
				?>
			</div>
		</div>

		<div class="tolstenko-bs-block">
			<h3><?php esc_html_e( 'Слайдер услуг', 'tolstenko-theme' ); ?></h3>
			<p class="tolstenko-bs-field">
				<label>
					<input type="hidden" name="tolstenko_blog_services_hidden" value="0">
					<input type="checkbox" name="tolstenko_blog_services_hidden" value="1" <?php checked( $svc_hidden, '1' ); ?>>
					<?php esc_html_e( 'Скрыть слайдер услуг на этой статье', 'tolstenko-theme' ); ?>
				</label>
			</p>
			<p class="tolstenko-bs-field">
				<label for="tolstenko_blog_services_title"><strong><?php esc_html_e( 'Заголовок (HTML, акцент — <span>)', 'tolstenko-theme' ); ?></strong></label><br>
				<input type="text" id="tolstenko_blog_services_title" name="tolstenko_blog_services_title" value="<?php echo esc_attr( $svc_title ); ?>" placeholder="<?php esc_attr_e( 'Пусто = из общих настроек', 'tolstenko-theme' ); ?>">
			</p>
			<p class="tolstenko-bs-field">
				<label for="tolstenko_blog_services_text"><strong><?php esc_html_e( 'Текст под заголовком', 'tolstenko-theme' ); ?></strong></label><br>
				<textarea id="tolstenko_blog_services_text" name="tolstenko_blog_services_text" rows="2" placeholder="<?php esc_attr_e( 'Пусто = из общих настроек', 'tolstenko-theme' ); ?>"><?php echo esc_textarea( $svc_text ); ?></textarea>
			</p>
			<div class="tolstenko-bs-field">
				<strong><?php esc_html_e( 'Услуги', 'tolstenko-theme' ); ?></strong>
				<p class="description" style="margin:4px 0 8px;"><?php esc_html_e( 'Пусто — услуги из «Дефолты блоков → Слайдер услуг (фильтры)».', 'tolstenko-theme' ); ?></p>
				<?php tolstenko_render_post_select( 'tolstenko_blog_services_ids', $svc_ids, 'service' ); ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function tolstenko_blog_sliders_save_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['tolstenko_blog_sliders_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_blog_sliders_nonce'] ) ), 'tolstenko_blog_sliders_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, 'blog_related_hidden', ! empty( $_POST['tolstenko_blog_related_hidden'] ) ? '1' : '0' );
	update_post_meta( $post_id, 'blog_related_title', isset( $_POST['tolstenko_blog_related_title'] ) ? tolstenko_kses_html( wp_unslash( $_POST['tolstenko_blog_related_title'] ) ) : '' );
	$rel_ids = tolstenko_sanitize_ids( isset( $_POST['tolstenko_blog_related_ids'] ) ? wp_unslash( $_POST['tolstenko_blog_related_ids'] ) : array() ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	update_post_meta( $post_id, 'blog_related_ids', array_values( array_diff( $rel_ids, array( (int) $post_id ) ) ) );

	update_post_meta( $post_id, 'blog_services_hidden', ! empty( $_POST['tolstenko_blog_services_hidden'] ) ? '1' : '0' );
	update_post_meta( $post_id, 'blog_services_title', isset( $_POST['tolstenko_blog_services_title'] ) ? tolstenko_kses_html( wp_unslash( $_POST['tolstenko_blog_services_title'] ) ) : '' );
	update_post_meta( $post_id, 'blog_services_text', isset( $_POST['tolstenko_blog_services_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tolstenko_blog_services_text'] ) ) : '' );
	update_post_meta( $post_id, 'blog_services_ids', tolstenko_sanitize_ids( isset( $_POST['tolstenko_blog_services_ids'] ) ? wp_unslash( $_POST['tolstenko_blog_services_ids'] ) : array() ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
}
