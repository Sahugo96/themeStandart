<?php
/**
 * Авторы статей — члены команды (CPT teammate), отдельных авторов нет.
 *
 * Настройки сайта → Авторы статей: выбор автора по умолчанию (запись «Команды»).
 * В статье (и на странице документа) — выбор автора в метабоксе «Статья: шапка, автор, комментарии»
 * (мета blog_author_id; пусто — автор по умолчанию).
 * Данные автора: фото — teammate_image_id, имя — teammate_name (или заголовок записи),
 * подпись — первая строка «Списка» (teammate_list), описание — teammate_description.
 * На других языках подставляется перевод члена команды (Polylang, если перевод «Команды» включён),
 * без перевода — первый член команды этого языка.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TOLSTENKO_BLOG_DEFAULT_AUTHOR_OPTION', 'tolstenko_blog_default_teammate' );

add_action( 'admin_menu', 'tolstenko_register_blog_authors_admin_page', 21 );

/**
 * Член команды → данные автора для вывода.
 *
 * @param int $teammate_id ID записи teammate.
 * @return array{photo:int,name:string,title:string,description:string}|null
 */
function tolstenko_blog_teammate_to_person( $teammate_id ) {
	$teammate_id = theme_teammate_id_for_lang( (int) $teammate_id );
	if ( ! $teammate_id ) {
		return null;
	}

	$name = theme_teammate_name( $teammate_id );

	$lines = preg_split( '/\r\n|\r|\n/', (string) get_post_meta( $teammate_id, 'teammate_list', true ) );
	$lines = array_values( array_filter( array_map( 'trim', (array) $lines ), 'strlen' ) );

	return array(
		'photo'       => (int) get_post_meta( $teammate_id, 'teammate_image_id', true ),
		'name'        => $name,
		'title'       => (string) ( $lines[0] ?? '' ),
		'description' => trim( wp_strip_all_tags( (string) get_post_meta( $teammate_id, 'teammate_description', true ) ) ),
	);
}

/**
 * ID автора по умолчанию на текущем языке: выбранный в «Авторы статей» (его перевод),
 * иначе первый член команды по порядку.
 *
 * @return int
 */
function tolstenko_get_blog_default_author_id() {
	return theme_teammate_resolve( (int) get_option( TOLSTENKO_BLOG_DEFAULT_AUTHOR_OPTION, 0 ) );
}

/**
 * Селект члена команды.
 *
 * @param string $field_name  name.
 * @param int    $selected    Выбранный ID.
 * @param string $empty_label Подпись пустого варианта ('' — без пустого варианта).
 * @param string $lang        Язык списка.
 * @param string $select_id   id.
 */
function tolstenko_render_blog_author_select( $field_name, $selected, $empty_label, $lang = '', $select_id = '' ) {
	$choices = theme_teammate_choices( (string) $lang );
	?>
	<select<?php echo $select_id !== '' ? ' id="' . esc_attr( $select_id ) . '"' : ''; ?> name="<?php echo esc_attr( $field_name ); ?>" style="width:100%;max-width:420px;box-sizing:border-box">
		<?php if ( $empty_label !== '' ) : ?>
			<option value=""><?php echo esc_html( $empty_label ); ?></option>
		<?php endif; ?>
		<?php foreach ( $choices as $id => $label ) : ?>
			<option value="<?php echo (int) $id; ?>" <?php selected( (int) $selected, (int) $id ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function tolstenko_register_blog_authors_admin_page() {
	add_submenu_page(
		'tolstenko-site-settings',
		__( 'Авторы статей', 'tolstenko-theme' ),
		__( 'Авторы статей', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-blog-authors',
		'tolstenko_render_blog_authors_admin_page'
	);
}

function tolstenko_render_blog_authors_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if (
		isset( $_POST['tolstenko_blog_authors_nonce'] )
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_blog_authors_nonce'] ) ), 'tolstenko_blog_authors_save' )
	) {
		$id = isset( $_POST['tolstenko_blog_default_author'] ) ? absint( $_POST['tolstenko_blog_default_author'] ) : 0;
		$post = $id ? get_post( $id ) : null;
		if ( $post instanceof WP_Post && $post->post_type === 'teammate' ) {
			update_option( TOLSTENKO_BLOG_DEFAULT_AUTHOR_OPTION, $id, false );
		} else {
			delete_option( TOLSTENKO_BLOG_DEFAULT_AUTHOR_OPTION );
		}
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Сохранено.', 'tolstenko-theme' ) . '</p></div>';
	}

	$default_lang = theme_teammate_default_lang();
	$selected     = (int) get_option( TOLSTENKO_BLOG_DEFAULT_AUTHOR_OPTION, 0 );
	$has_team     = (bool) theme_teammate_choices( $default_lang );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Авторы статей', 'tolstenko-theme' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Авторы статей — члены команды. Здесь выбирается автор по умолчанию: он показывается в статьях без выбранного автора и в «Сетке статей». Автора конкретной статьи выбирают в её метабоксе «Статья: шапка, автор, комментарии».', 'tolstenko-theme' ); ?>
		</p>

		<?php if ( ! $has_team ) : ?>
			<div class="notice notice-warning inline"><p>
				<?php esc_html_e( 'Членов команды пока нет.', 'tolstenko-theme' ); ?>
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=teammate' ) ); ?>"><?php esc_html_e( 'Добавить члена команды', 'tolstenko-theme' ); ?></a>
			</p></div>
		<?php endif; ?>

		<form method="post" action="">
			<?php wp_nonce_field( 'tolstenko_blog_authors_save', 'tolstenko_blog_authors_nonce' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tolstenko_blog_default_author"><?php esc_html_e( 'Автор по умолчанию', 'tolstenko-theme' ); ?></label></th>
					<td>
						<?php tolstenko_render_blog_author_select( 'tolstenko_blog_default_author', $selected, __( '— Первый член команды по порядку —', 'tolstenko-theme' ), $default_lang, 'tolstenko_blog_default_author' ); ?>
						<p class="description">
							<?php esc_html_e( 'Фото, имя и описание — из записи «Команды»; подпись под именем — первая строка её «Списка». На других языках выводится перевод члена команды.', 'tolstenko-theme' ); ?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
