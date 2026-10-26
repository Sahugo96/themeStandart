<?php
/**
 * «Основная категория» в правой колонке редактора записи.
 *
 * Выбранная рубрика выводится в метке карточки и используется в ЧПУ записи
 * (inc/rewrite/primary-term-permalinks.php). Хранится в мета-поле primary_<таксономия>.
 * При сохранении выбранная рубрика добавляется к рубрикам записи, если её там нет.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Тип записи → таксономия, для которой выбирается основная рубрика.
 *
 * @return array<string, string>
 */
function theme_get_primary_term_taxonomies() {
	return array(
		'service' => 'service_cat',
	);
}

/**
 * Основная рубрика записи: выбранная в редакторе → основная в Yoast → первая из рубрик.
 *
 * @param int    $post_id  Post ID.
 * @param string $taxonomy Таксономия.
 * @return WP_Term|null
 */
function theme_get_primary_term( $post_id, $taxonomy ) {
	$post_id = (int) $post_id;
	$terms   = get_the_terms( $post_id, $taxonomy );

	if ( ! is_array( $terms ) || ! $terms ) {
		return null;
	}

	$primary_id = (int) get_post_meta( $post_id, 'primary_' . $taxonomy, true );

	if ( ! $primary_id && function_exists( 'yoast_get_primary_term_id' ) ) {
		$primary_id = (int) yoast_get_primary_term_id( $taxonomy, $post_id );
	}

	foreach ( $terms as $term ) {
		if ( (int) $term->term_id === $primary_id ) {
			return $term;
		}
	}

	return $terms[0];
}

add_action( 'add_meta_boxes', 'theme_primary_term_add_metabox' );
add_action( 'save_post', 'theme_primary_term_save_metabox', 10, 2 );

function theme_primary_term_add_metabox() {
	foreach ( theme_get_primary_term_taxonomies() as $post_type => $taxonomy ) {
		add_meta_box(
			'theme_primary_term_' . $taxonomy,
			__( 'Основная категория', 'tolstenko-theme' ),
			'theme_primary_term_render_metabox',
			$post_type,
			'side',
			'default',
			array( 'taxonomy' => $taxonomy )
		);
	}
}

/**
 * @param WP_Post $post Post.
 * @param array   $box  Параметры метабокса.
 */
function theme_primary_term_render_metabox( $post, $box ) {
	$taxonomy = (string) ( $box['args']['taxonomy'] ?? '' );
	$terms    = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
		)
	);
	$current  = (int) get_post_meta( $post->ID, 'primary_' . $taxonomy, true );

	wp_nonce_field( 'theme_primary_term_save', 'theme_primary_term_nonce' );

	if ( is_wp_error( $terms ) || ! $terms ) {
		echo '<p class="description">' . esc_html__( 'Категорий пока нет — добавьте их в «Категориях услуг».', 'tolstenko-theme' ) . '</p>';
		return;
	}
	?>
	<p>
		<label class="screen-reader-text" for="theme_primary_<?php echo esc_attr( $taxonomy ); ?>"><?php esc_html_e( 'Основная категория', 'tolstenko-theme' ); ?></label>
		<select id="theme_primary_<?php echo esc_attr( $taxonomy ); ?>" name="theme_primary_term[<?php echo esc_attr( $taxonomy ); ?>]" style="width:100%">
			<option value="0"><?php esc_html_e( '— Первая из отмеченных —', 'tolstenko-theme' ); ?></option>
			<?php foreach ( $terms as $term ) : ?>
				<option value="<?php echo (int) $term->term_id; ?>" <?php selected( $current, (int) $term->term_id ); ?>><?php echo esc_html( $term->name ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p class="description"><?php esc_html_e( 'Выводится в метке карточки. Если категория не отмечена у записи — добавится при сохранении.', 'tolstenko-theme' ); ?></p>
	<?php
}

/**
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function theme_primary_term_save_metabox( $post_id, $post ) {
	$taxonomies = theme_get_primary_term_taxonomies();

	if ( ! isset( $taxonomies[ $post->post_type ] ) ) {
		return;
	}
	if ( ! isset( $_POST['theme_primary_term_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['theme_primary_term_nonce'] ) ), 'theme_primary_term_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$taxonomy = $taxonomies[ $post->post_type ];
	$raw      = isset( $_POST['theme_primary_term'] ) && is_array( $_POST['theme_primary_term'] ) ? wp_unslash( $_POST['theme_primary_term'] ) : array();
	$term_id  = isset( $raw[ $taxonomy ] ) ? absint( $raw[ $taxonomy ] ) : 0;
	$term     = $term_id ? get_term( $term_id, $taxonomy ) : null;

	if ( ! $term instanceof WP_Term ) {
		delete_post_meta( $post_id, 'primary_' . $taxonomy );
		return;
	}

	update_post_meta( $post_id, 'primary_' . $taxonomy, $term_id );

	if ( ! has_term( $term_id, $taxonomy, $post_id ) ) {
		wp_set_post_terms( $post_id, array( $term_id ), $taxonomy, true );
	}
}
