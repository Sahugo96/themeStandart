<?php
/**
 * Нативный метабокс CPT «Статья» (blog) — данные карточки статьи.
 * Используются в карточках: секция «Статьи» на главной, архив блога, похожие статьи, поиск.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'tolstenko_blog_add_metabox' );
add_action( 'save_post_blog', 'tolstenko_blog_save_metabox', 10, 2 );

function tolstenko_blog_add_metabox() {
	add_meta_box(
		'tolstenko_blog_card_fields',
		__( 'Карточка статьи', 'tolstenko-theme' ),
		'tolstenko_blog_render_metabox',
		'blog',
		'normal',
		'default'
	);
}

/**
 * Текст карточки статьи. Ключ мета-поля тот же, что был у ACF-поля,
 * поэтому уже заполненные значения подхватываются.
 *
 * @param int $post_id Post ID (0 = текущая запись).
 * @return string
 */
function theme_get_blog_card_text( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();

	return $post_id ? trim( (string) get_post_meta( $post_id, 'blog_card_text', true ) ) : '';
}

/**
 * Время чтения из метабокса (мин) или 0, если не задано.
 *
 * @param int $post_id Post ID (0 = текущая запись).
 * @return int
 */
function theme_get_blog_reading_minutes( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();

	return $post_id ? absint( get_post_meta( $post_id, 'blog_reading_time', true ) ) : 0;
}

/**
 * @param WP_Post $post Post.
 */
function tolstenko_blog_render_metabox( $post ) {
	wp_nonce_field( 'tolstenko_blog_save', 'tolstenko_blog_nonce' );

	$card_text    = theme_get_blog_card_text( $post->ID );
	$reading_time = theme_get_blog_reading_minutes( $post->ID );
	?>
	<style>
		.tolstenko-blog-box .tolstenko-blog-field{margin:0 0 14px}
		.tolstenko-blog-box .tolstenko-blog-field textarea{width:100%}
		.tolstenko-blog-box .tolstenko-blog-field input[type=number]{width:120px}
		.tolstenko-blog-box .description{color:#646970;margin:4px 0 0}
	</style>

	<div class="tolstenko-blog-box">
		<p class="tolstenko-blog-field">
			<label for="tolstenko_blog_card_text"><strong><?php esc_html_e( 'Текст на карточке', 'tolstenko-theme' ); ?></strong></label><br>
			<textarea id="tolstenko_blog_card_text" name="tolstenko_blog_card_text" rows="3"><?php echo esc_textarea( $card_text ); ?></textarea>
			<span class="description"><?php esc_html_e( 'Короткое описание под заголовком в карточках статьи (1–2 предложения).', 'tolstenko-theme' ); ?></span>
		</p>

		<p class="tolstenko-blog-field">
			<label for="tolstenko_blog_reading_time"><strong><?php esc_html_e( 'Время чтения, мин', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="number" min="0" step="1" id="tolstenko_blog_reading_time" name="tolstenko_blog_reading_time" value="<?php echo $reading_time ? (int) $reading_time : ''; ?>">
			<span class="description"><?php esc_html_e( 'Пусто = считает плагин Reading Time WP.', 'tolstenko-theme' ); ?></span>
		</p>
	</div>
	<?php
}

/**
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function tolstenko_blog_save_metabox( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['tolstenko_blog_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_blog_nonce'] ) ), 'tolstenko_blog_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text = isset( $_POST['tolstenko_blog_card_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tolstenko_blog_card_text'] ) ) : '';
	if ( $text !== '' ) {
		update_post_meta( $post_id, 'blog_card_text', $text );
	} else {
		delete_post_meta( $post_id, 'blog_card_text' );
	}

	$minutes = isset( $_POST['tolstenko_blog_reading_time'] ) ? absint( $_POST['tolstenko_blog_reading_time'] ) : 0;
	if ( $minutes > 0 ) {
		update_post_meta( $post_id, 'blog_reading_time', $minutes );
	} else {
		delete_post_meta( $post_id, 'blog_reading_time' );
	}
}
