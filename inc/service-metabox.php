<?php
/**
 * Нативный метабокс CPT «Услуга» (service) — данные карточки для секции «Услуги» (слайдер с фильтром).
 * Изображение карточки — миниатюра записи, метка — рубрика service_cat.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'tolstenko_service_add_metabox' );
add_action( 'save_post_service', 'tolstenko_service_save_metabox', 10, 2 );

function tolstenko_service_add_metabox() {
	add_meta_box(
		'tolstenko_service_card_fields',
		__( 'Карточка услуги (слайдер «Услуги»)', 'tolstenko-theme' ),
		'tolstenko_service_render_metabox',
		'service',
		'normal',
		'default'
	);
}

/**
 * Данные карточки услуги с фолбэками (заголовок — заголовок записи, кнопка — модалка).
 *
 * @param int $post_id Post ID (0 = текущая запись).
 * @return array{title: string, text: string, price: string, consult_url: string}
 */
function theme_get_service_card_data( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();

	$title       = trim( (string) get_post_meta( $post_id, 'service_card_title', true ) );
	$consult_url = trim( (string) get_post_meta( $post_id, 'service_card_consult_url', true ) );

	return array(
		'title'       => $title !== '' ? $title : get_the_title( $post_id ),
		'text'        => trim( (string) get_post_meta( $post_id, 'service_card_text', true ) ),
		'price'       => trim( (string) get_post_meta( $post_id, 'service_card_price', true ) ),
		'consult_url' => $consult_url !== '' ? $consult_url : '#modal',
	);
}

/**
 * @param WP_Post $post Post.
 */
function tolstenko_service_render_metabox( $post ) {
	wp_nonce_field( 'tolstenko_service_save', 'tolstenko_service_nonce' );

	$title       = (string) get_post_meta( $post->ID, 'service_card_title', true );
	$text        = (string) get_post_meta( $post->ID, 'service_card_text', true );
	$price       = (string) get_post_meta( $post->ID, 'service_card_price', true );
	$consult_url = (string) get_post_meta( $post->ID, 'service_card_consult_url', true );
	?>
	<style>
		.tolstenko-service-box .tolstenko-service-field{margin:0 0 14px}
		.tolstenko-service-box .tolstenko-service-field input[type=text],
		.tolstenko-service-box .tolstenko-service-field textarea{width:100%}
		.tolstenko-service-box .description{color:#646970;margin:4px 0 0}
	</style>

	<div class="tolstenko-service-box">
		<p class="description" style="margin:0 0 14px">
			<?php esc_html_e( 'Изображение карточки — миниатюра записи, метка на фото — рубрика услуги. Кнопка «Подробнее» ведёт на страницу услуги.', 'tolstenko-theme' ); ?>
		</p>

		<p class="tolstenko-service-field">
			<label for="tolstenko_service_card_title"><strong><?php esc_html_e( 'Заголовок на карточке', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_service_card_title" name="tolstenko_service_card_title" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php esc_attr_e( 'Пусто = заголовок записи', 'tolstenko-theme' ); ?>">
		</p>

		<p class="tolstenko-service-field">
			<label for="tolstenko_service_card_text"><strong><?php esc_html_e( 'Текст на карточке', 'tolstenko-theme' ); ?></strong></label><br>
			<textarea id="tolstenko_service_card_text" name="tolstenko_service_card_text" rows="3"><?php echo esc_textarea( $text ); ?></textarea>
		</p>

		<p class="tolstenko-service-field">
			<label for="tolstenko_service_card_price"><strong><?php esc_html_e( 'Стоимость', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_service_card_price" name="tolstenko_service_card_price" value="<?php echo esc_attr( $price ); ?>" placeholder="12 000 $">
			<span class="description"><?php esc_html_e( 'Выводится как «от 12 000 $». Пусто = строка не выводится.', 'tolstenko-theme' ); ?></span>
		</p>

		<p class="tolstenko-service-field">
			<label for="tolstenko_service_card_consult_url"><strong><?php esc_html_e( 'Ссылка кнопки «Консультация»', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_service_card_consult_url" name="tolstenko_service_card_consult_url" value="<?php echo esc_attr( $consult_url ); ?>" placeholder="#modal">
			<span class="description"><?php esc_html_e( 'Пусто = открывается форма заявки (#modal). Можно указать URL или якорь.', 'tolstenko-theme' ); ?></span>
		</p>
	</div>
	<?php
}

/**
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function tolstenko_service_save_metabox( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['tolstenko_service_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_service_nonce'] ) ), 'tolstenko_service_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'service_card_title'       => isset( $_POST['tolstenko_service_card_title'] ) ? sanitize_text_field( wp_unslash( $_POST['tolstenko_service_card_title'] ) ) : '',
		'service_card_text'        => isset( $_POST['tolstenko_service_card_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tolstenko_service_card_text'] ) ) : '',
		'service_card_price'       => isset( $_POST['tolstenko_service_card_price'] ) ? sanitize_text_field( wp_unslash( $_POST['tolstenko_service_card_price'] ) ) : '',
		'service_card_consult_url' => isset( $_POST['tolstenko_service_card_consult_url'] ) ? tolstenko_service_sanitize_link( wp_unslash( $_POST['tolstenko_service_card_consult_url'] ) ) : '',
	);

	foreach ( $fields as $meta_key => $value ) {
		if ( $value !== '' ) {
			update_post_meta( $post_id, $meta_key, $value );
		} else {
			delete_post_meta( $post_id, $meta_key );
		}
	}
}

/**
 * Ссылка кнопки: якорь (#modal) сохраняем как есть, остальное — как URL.
 *
 * @param string $raw Значение из формы.
 * @return string
 */
function tolstenko_service_sanitize_link( $raw ) {
	$raw = trim( (string) $raw );

	if ( $raw === '' ) {
		return '';
	}

	if ( $raw[0] === '#' ) {
		return '#' . sanitize_title( substr( $raw, 1 ) );
	}

	return esc_url_raw( $raw );
}
