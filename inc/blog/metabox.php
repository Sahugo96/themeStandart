<?php
/**
 * Нативный метабокс статьи (CPT blog) — работает без ACF Pro:
 * лид, автор, кнопка «Задать вопрос», кураторские комментарии.
 * Текст карточки и время чтения — в «Карточке статьи» (inc/blog-metabox.php).
 *
 * Ключ лида совпадает с прежним ACF-полем (single-blog_text),
 * поэтому уже заполненные статьи подхватываются. Если ACF-поле с таким именем
 * зарегистрировано, его редактирует ACF, а здесь поле не дублируется.
 *
 * Перенесено из tolstenko.marketing (inc/blog/metabox.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes_blog', 'tolstenko_blog_article_add_metabox' );
add_action( 'save_post_blog', 'tolstenko_blog_article_save_metabox', 10, 2 );
add_action( 'admin_enqueue_scripts', 'tolstenko_blog_article_metabox_assets' );

/**
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param mixed  $default Default.
 * @return mixed
 */
function tolstenko_blog_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, $key, true );
	return ( $val === '' || $val === false || $val === null ) ? $default : $val;
}

/**
 * Поле с таким именем уже ведёт ACF (тогда метабокс его не трогает).
 *
 * @param string $name Field name.
 * @return bool
 */
function tolstenko_blog_meta_owned_by_acf( $name ) {
	return function_exists( 'acf_get_field' ) && acf_get_field( $name );
}

function tolstenko_blog_article_add_metabox() {
	add_meta_box(
		'tolstenko_blog_article_fields',
		__( 'Статья: шапка, автор, комментарии', 'tolstenko-theme' ),
		'tolstenko_blog_article_render_metabox',
		'blog',
		'normal',
		'high'
	);
}

/**
 * @param string $hook Admin page hook.
 */
function tolstenko_blog_article_metabox_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== 'blog' ) {
		return;
	}
	wp_enqueue_media();
}

/**
 * @param WP_Post $post Post.
 */
function tolstenko_blog_article_render_metabox( $post ) {
	wp_nonce_field( 'tolstenko_blog_article_save', 'tolstenko_blog_article_nonce' );

	$text      = (string) tolstenko_blog_meta( $post->ID, 'single-blog_text', '' );
	$quest     = (string) tolstenko_blog_meta( $post->ID, 'single-blog_quest', '1' );
	$quest     = ( $quest === '1' ) ? '1' : '0';
	$author    = (string) tolstenko_blog_meta( $post->ID, 'blog_author', '' );
	$comments  = tolstenko_blog_ensure_post_comment_ids( $post->ID );
	?>
	<style>
		.tolstenko-blog-box .tolstenko-blog-field{margin:0 0 14px}
		.tolstenko-blog-box .tolstenko-blog-field input[type=text],
		.tolstenko-blog-box .tolstenko-blog-field textarea,
		.tolstenko-blog-box .tolstenko-blog-field select{width:100%;max-width:none;box-sizing:border-box}
		.tolstenko-blog-box .tolstenko-blog-section{margin:20px 0 0;padding:16px 0 0;border-top:1px solid #dcdcde}
		.tolstenko-blog-box .tolstenko-blog-section h3{margin:0 0 10px;font-size:14px}
		.tolstenko-blog-box .tolstenko-bc-item{border:1px solid #dcdcde;background:#fff;padding:12px;margin:0 0 10px;width:100%;box-sizing:border-box}
		.tolstenko-blog-box .tolstenko-bc-item.is-reply{margin-left:24px;background:#f6f7f7}
		.tolstenko-blog-box .tolstenko-bc-item.is-nested{margin-left:48px}
		.tolstenko-blog-box .tolstenko-bc-grid{display:grid;grid-template-columns:90px 1fr;gap:12px}
		.tolstenko-blog-box .tolstenko-bc-preview img{max-width:80px;height:auto;display:block;margin-bottom:6px}
		.tolstenko-blog-box .tolstenko-bc-fields label{display:block;font-weight:600;margin:0 0 4px}
		.tolstenko-blog-box .tolstenko-bc-fields input,
		.tolstenko-blog-box .tolstenko-bc-fields textarea{width:100%;max-width:none;margin:0 0 8px;box-sizing:border-box}
		.tolstenko-blog-box .tolstenko-bc-replies{margin-top:10px;padding-top:10px;border-top:1px dashed #c3c4c7}
	</style>

	<div class="tolstenko-blog-box" id="tolstenko-blog-box">
		<div class="tolstenko-blog-section" style="margin-top:0;padding-top:0;border:0">
			<h3><?php esc_html_e( 'Шапка', 'tolstenko-theme' ); ?></h3>

			<?php if ( ! tolstenko_blog_meta_owned_by_acf( 'single-blog_text' ) ) : ?>
				<p class="tolstenko-blog-field">
					<label for="tolstenko_single_blog_text"><strong><?php esc_html_e( 'Текст под заголовком (лид)', 'tolstenko-theme' ); ?></strong></label><br>
					<textarea id="tolstenko_single_blog_text" name="tolstenko_single_blog_text" rows="3"><?php echo esc_textarea( $text ); ?></textarea>
				</p>
			<?php endif; ?>


			<p class="tolstenko-blog-field">
				<label>
					<input type="hidden" name="tolstenko_single_blog_quest" value="0">
					<input type="checkbox" name="tolstenko_single_blog_quest" value="1" <?php checked( $quest, '1' ); ?>>
					<?php esc_html_e( 'Кнопка «Задать вопрос» у автора', 'tolstenko-theme' ); ?>
				</label>
			</p>

			<p class="tolstenko-blog-field">
				<label for="tolstenko_blog_author"><strong><?php esc_html_e( 'Автор статьи', 'tolstenko-theme' ); ?></strong></label><br>
				<?php
				tolstenko_render_blog_author_select(
					'tolstenko_blog_author',
					$author,
					__( 'Главный автор (по умолчанию)', 'tolstenko-theme' ),
					'tolstenko_blog_author'
				);
				?>
				<br><span class="description">
					<?php esc_html_e( 'Список авторов:', 'tolstenko-theme' ); ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=tolstenko-blog-authors' ) ); ?>">
						<?php esc_html_e( 'Настройки сайта → Авторы статей', 'tolstenko-theme' ); ?>
					</a>
				</span>
			</p>
		</div>

		<div class="tolstenko-blog-section">
			<h3><?php esc_html_e( 'Комментарии', 'tolstenko-theme' ); ?></h3>
			<p class="description"><?php esc_html_e( 'Выводятся под статьёй. Комментарии с сайта попадают сюда после одобрения в «Комментарии с сайта».', 'tolstenko-theme' ); ?></p>

			<div data-bc-list>
				<?php foreach ( $comments as $i => $comment ) : ?>
					<?php tolstenko_blog_render_comment_admin_row( (string) $i, is_array( $comment ) ? $comment : array(), 0 ); ?>
				<?php endforeach; ?>
			</div>

			<p><button type="button" class="button" data-bc-add><?php esc_html_e( 'Добавить комментарий', 'tolstenko-theme' ); ?></button></p>

			<template data-bc-tpl>
				<?php tolstenko_blog_render_comment_admin_row( '__INDEX__', array(), 0 ); ?>
			</template>
			<template data-bc-reply-tpl>
				<?php tolstenko_blog_render_comment_admin_row( '__INDEX__', array(), 1 ); ?>
			</template>
			<template data-bc-nested-reply-tpl>
				<?php tolstenko_blog_render_comment_admin_row( '__INDEX__', array(), 2 ); ?>
			</template>
		</div>
	</div>

	<script>
	(function(){
		const root = document.getElementById('tolstenko-blog-box');
		if (!root) return;
		const list = root.querySelector('[data-bc-list]');
		const tpl = root.querySelector('[data-bc-tpl]');
		const replyTpl = root.querySelector('[data-bc-reply-tpl]');
		const nestedTpl = root.querySelector('[data-bc-nested-reply-tpl]');

		function uid(){ return Date.now().toString() + Math.floor(Math.random()*1000).toString(); }

		function bindPhoto(scope){
			scope.addEventListener('click', function(e){
				const pick = e.target.closest('[data-bc-pick]');
				if (pick && window.wp && wp.media) {
					const row = pick.closest('.tolstenko-bc-item');
					const input = row && row.querySelector('[data-bc-photo]');
					const preview = row && row.querySelector('[data-bc-preview]');
					const frame = wp.media({ title: 'Фото', multiple: false, library: { type: 'image' } });
					frame.on('select', function(){
						const att = frame.state().get('selection').first().toJSON();
						if (!att || !input) return;
						input.value = String(att.id || 0);
						if (preview) preview.innerHTML = att.url ? '<img src="'+att.url+'" alt="">' : '';
					});
					frame.open();
					return;
				}
				const clear = e.target.closest('[data-bc-clear]');
				if (clear) {
					const row = clear.closest('.tolstenko-bc-item');
					const input = row && row.querySelector('[data-bc-photo]');
					const preview = row && row.querySelector('[data-bc-preview]');
					if (input) input.value = '0';
					if (preview) preview.innerHTML = '';
				}
			});
		}
		bindPhoto(root);

		root.addEventListener('click', function(e){
			const add = e.target.closest('[data-bc-add]');
			if (add && tpl && list) {
				list.insertAdjacentHTML('beforeend', tpl.innerHTML.replace(/__INDEX__/g, uid()));
				return;
			}
			const addReply = e.target.closest('[data-bc-add-reply]');
			if (addReply) {
				const item = addReply.closest('.tolstenko-bc-item');
				let repliesBox = null;
				if (item) {
					for (let i = 0; i < item.children.length; i++) {
						if (item.children[i].hasAttribute && item.children[i].hasAttribute('data-bc-replies')) {
							repliesBox = item.children[i];
							break;
						}
					}
				}
				const itemIndex = item && item.getAttribute('data-bc-index');
				if (!repliesBox || !itemIndex) return;
				let html = '';
				if (item.classList.contains('is-reply')) {
					const rootItem = item.parentElement && item.parentElement.closest('.tolstenko-bc-item');
					const rootIndex = rootItem && rootItem.getAttribute('data-bc-index');
					if (!nestedTpl || !rootIndex) return;
					html = nestedTpl.innerHTML
						.replace(/__ROOT__/g, rootIndex)
						.replace(/__PARENT__/g, itemIndex)
						.replace(/__INDEX__/g, uid());
				} else if (replyTpl) {
					html = replyTpl.innerHTML
						.replace(/__PARENT__/g, itemIndex)
						.replace(/__INDEX__/g, uid());
				}
				if (html) repliesBox.insertAdjacentHTML('beforeend', html);
				return;
			}
			const remove = e.target.closest('[data-bc-remove]');
			if (remove) {
				const row = remove.closest('.tolstenko-bc-item');
				if (row) row.remove();
			}
		});
	})();
	</script>
	<?php
}

/**
 * @param string $index Row index.
 * @param array  $item  Comment data.
 * @param int    $depth 0 = корень, 1 = ответ, 2 = ответ второго порядка.
 */
function tolstenko_blog_render_comment_admin_row( $index, array $item, $depth = 0 ) {
	$depth = (int) $depth;
	$photo = (int) ( $item['photo'] ?? 0 );
	$url   = $photo ? (string) wp_get_attachment_image_url( $photo, 'thumbnail' ) : '';

	if ( $depth >= 2 ) {
		$root   = isset( $item['_root'] ) ? (string) $item['_root'] : '__ROOT__';
		$parent = isset( $item['_parent'] ) ? (string) $item['_parent'] : '__PARENT__';
		$base   = 'tolstenko_blog_comments[' . $root . '][replies][' . $parent . '][replies][' . $index . ']';
		$class  = 'tolstenko-bc-item is-reply is-nested';
	} elseif ( $depth === 1 ) {
		$parent = isset( $item['_parent'] ) ? (string) $item['_parent'] : '__PARENT__';
		$base   = 'tolstenko_blog_comments[' . $parent . '][replies][' . $index . ']';
		$class  = 'tolstenko-bc-item is-reply';
	} else {
		$base  = 'tolstenko_blog_comments[' . $index . ']';
		$class = 'tolstenko-bc-item';
	}
	?>
	<div class="<?php echo esc_attr( $class ); ?>" data-bc-index="<?php echo esc_attr( $index ); ?>">
		<input type="hidden" name="<?php echo esc_attr( $base . '[id]' ); ?>" value="<?php echo esc_attr( (string) ( $item['id'] ?? '' ) ); ?>">
		<div class="tolstenko-bc-grid">
			<div>
				<div class="tolstenko-bc-preview" data-bc-preview>
					<?php if ( $url ) : ?>
						<img src="<?php echo esc_url( $url ); ?>" alt="">
					<?php endif; ?>
				</div>
				<input type="hidden" data-bc-photo name="<?php echo esc_attr( $base . '[photo]' ); ?>" value="<?php echo (int) $photo; ?>">
				<button type="button" class="button button-small" data-bc-pick><?php esc_html_e( 'Фото', 'tolstenko-theme' ); ?></button>
				<button type="button" class="button button-small" data-bc-clear><?php esc_html_e( 'Убрать', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="tolstenko-bc-fields">
				<label><?php esc_html_e( 'Имя', 'tolstenko-theme' ); ?></label>
				<input type="text" name="<?php echo esc_attr( $base . '[name]' ); ?>" value="<?php echo esc_attr( (string) ( $item['name'] ?? '' ) ); ?>">
				<label><?php esc_html_e( 'Email', 'tolstenko-theme' ); ?></label>
				<input type="email" name="<?php echo esc_attr( $base . '[email]' ); ?>" value="<?php echo esc_attr( (string) ( $item['email'] ?? '' ) ); ?>">
				<p class="description"><?php esc_html_e( 'Не показывается на сайте. Нужен для писем об ответах.', 'tolstenko-theme' ); ?></p>
				<label><?php esc_html_e( 'Дата', 'tolstenko-theme' ); ?></label>
				<input type="text" name="<?php echo esc_attr( $base . '[date]' ); ?>" value="<?php echo esc_attr( (string) ( $item['date'] ?? '' ) ); ?>" placeholder="01.01.2026">
				<label><?php esc_html_e( 'Время', 'tolstenko-theme' ); ?></label>
				<input type="text" name="<?php echo esc_attr( $base . '[time]' ); ?>" value="<?php echo esc_attr( (string) ( $item['time'] ?? '' ) ); ?>" placeholder="12:00">
				<label><?php esc_html_e( 'Текст', 'tolstenko-theme' ); ?></label>
				<textarea name="<?php echo esc_attr( $base . '[text]' ); ?>" rows="3"><?php echo esc_textarea( (string) ( $item['text'] ?? '' ) ); ?></textarea>
				<p>
					<button type="button" class="button-link-delete" data-bc-remove><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
					<?php if ( $depth < 2 ) : ?>
						<button type="button" class="button button-small" data-bc-add-reply><?php esc_html_e( 'Добавить ответ', 'tolstenko-theme' ); ?></button>
					<?php endif; ?>
				</p>
			</div>
		</div>

		<?php if ( $depth < 2 ) : ?>
			<div class="tolstenko-bc-replies" data-bc-replies>
				<?php
				$replies = $item['replies'] ?? array();
				if ( is_array( $replies ) ) {
					foreach ( $replies as $ri => $reply ) {
						if ( ! is_array( $reply ) ) {
							continue;
						}
						if ( $depth === 0 ) {
							$reply['_parent'] = $index;
							tolstenko_blog_render_comment_admin_row( (string) $ri, $reply, 1 );
						} else {
							$reply['_root']   = isset( $item['_parent'] ) ? (string) $item['_parent'] : '__PARENT__';
							$reply['_parent'] = $index;
							tolstenko_blog_render_comment_admin_row( (string) $ri, $reply, 2 );
						}
					}
				}
				?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function tolstenko_blog_article_save_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['tolstenko_blog_article_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_blog_article_nonce'] ) ), 'tolstenko_blog_article_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array(
		'tolstenko_single_blog_text' => 'single-blog_text',
	);
	foreach ( $text_fields as $input => $meta_key ) {
		if ( isset( $_POST[ $input ] ) && ! tolstenko_blog_meta_owned_by_acf( $meta_key ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_textarea_field( wp_unslash( $_POST[ $input ] ) ) );
		}
	}

	update_post_meta( $post_id, 'single-blog_quest', ! empty( $_POST['tolstenko_single_blog_quest'] ) ? '1' : '0' );

	$author = isset( $_POST['tolstenko_blog_author'] )
		? sanitize_text_field( wp_unslash( $_POST['tolstenko_blog_author'] ) )
		: '';
	update_post_meta( $post_id, 'blog_author', $author );

	$comments_raw = isset( $_POST['tolstenko_blog_comments'] ) && is_array( $_POST['tolstenko_blog_comments'] )
		? wp_unslash( $_POST['tolstenko_blog_comments'] ) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized below.
		: array();
	update_post_meta( $post_id, 'blog_comments', tolstenko_blog_sanitize_comments( $comments_raw ) );
}
