<?php
/**
 * FAQ под статьёй (CPT blog): группа мета-полей на статье.
 * Пустые поля → таб «Дефолты блоков → FAQ» (форма справа — всегда оттуда).
 *
 * Перенесено из tolstenko.marketing (inc/blog/faq-metabox.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes_blog', 'tolstenko_blog_faq_add_metabox' );
add_action( 'save_post_blog', 'tolstenko_blog_faq_save_metabox', 10, 2 );

function tolstenko_blog_faq_add_metabox() {
	add_meta_box(
		'tolstenko_blog_faq',
		__( 'FAQ статьи', 'tolstenko-theme' ),
		'tolstenko_blog_faq_render_metabox',
		'blog',
		'normal',
		'default'
	);
}

/**
 * Переопределения секции FAQ для статьи (для theme_get_faq_section_data()).
 * null — FAQ на статье скрыт; пустой массив — всё из дефолтов.
 *
 * @param int $post_id Post ID.
 * @return array|null
 */
function tolstenko_get_blog_faq_overrides( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( ! $post_id ) {
		return array();
	}

	if ( get_post_meta( $post_id, 'blog_faq_hidden', true ) === '1' ) {
		return null;
	}

	$items = get_post_meta( $post_id, 'blog_faq_items', true );

	return array(
		'badge' => trim( (string) get_post_meta( $post_id, 'blog_faq_badge', true ) ),
		'title' => trim( (string) get_post_meta( $post_id, 'blog_faq_title', true ) ),
		'items' => is_array( $items ) ? array_values( $items ) : array(),
	);
}

/**
 * @param WP_Post $post Post.
 */
function tolstenko_blog_faq_render_metabox( $post ) {
	wp_nonce_field( 'tolstenko_blog_faq_save', 'tolstenko_blog_faq_nonce' );

	$hidden = (string) get_post_meta( $post->ID, 'blog_faq_hidden', true );
	$badge  = (string) get_post_meta( $post->ID, 'blog_faq_badge', true );
	$title  = (string) get_post_meta( $post->ID, 'blog_faq_title', true );
	$items  = get_post_meta( $post->ID, 'blog_faq_items', true );
	if ( ! is_array( $items ) || ! $items ) {
		$items = array(
			array(
				'quest'  => '',
				'unswer' => '',
			),
		);
	}
	?>
	<style>
		.tolstenko-blog-faq .tolstenko-bf-field{margin:0 0 12px}
		.tolstenko-blog-faq .tolstenko-bf-field input[type=text],
		.tolstenko-blog-faq .tolstenko-bf-field textarea,
		.tolstenko-blog-faq .tolstenko-bf-item input[type=text],
		.tolstenko-blog-faq .tolstenko-bf-item textarea{width:100%;max-width:none;box-sizing:border-box}
		.tolstenko-blog-faq .tolstenko-bf-item{border:1px solid #dcdcde;background:#fff;padding:12px;margin:0 0 10px;max-width:none;width:100%;box-sizing:border-box}
		.tolstenko-blog-faq .tolstenko-bf-item label{display:block;font-weight:600;margin:0 0 4px}
		.tolstenko-blog-faq .tolstenko-bf-item-actions{display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin:10px 0 0}
		.tolstenko-blog-faq .tolstenko-bf-item-actions .move-btn{min-width:34px;padding:0 8px}
		.tolstenko-blog-faq .description{margin:0 0 12px}
	</style>

	<div class="tolstenko-blog-faq" id="tolstenko-blog-faq">
		<p class="description">
			<?php esc_html_e( 'Пустые поля — из «Настройки сайта → Дефолты блоков → FAQ». Форма справа всегда из общих настроек.', 'tolstenko-theme' ); ?>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=tolstenko-site-settings' ) ); ?>">
				<?php esc_html_e( 'Открыть настройки', 'tolstenko-theme' ); ?>
			</a>
		</p>

		<p class="tolstenko-bf-field">
			<label>
				<input type="hidden" name="tolstenko_blog_faq_hidden" value="0">
				<input type="checkbox" name="tolstenko_blog_faq_hidden" value="1" <?php checked( $hidden, '1' ); ?>>
				<?php esc_html_e( 'Скрыть блок FAQ на этой статье', 'tolstenko-theme' ); ?>
			</label>
		</p>

		<p class="tolstenko-bf-field">
			<label for="tolstenko_blog_faq_badge"><strong><?php esc_html_e( 'Надзаголовок', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_blog_faq_badge" name="tolstenko_blog_faq_badge" value="<?php echo esc_attr( $badge ); ?>" placeholder="<?php esc_attr_e( 'Пусто = из общих настроек', 'tolstenko-theme' ); ?>">
		</p>

		<p class="tolstenko-bf-field">
			<label for="tolstenko_blog_faq_title"><strong><?php esc_html_e( 'Заголовок (HTML, акцент — <span>)', 'tolstenko-theme' ); ?></strong></label><br>
			<input type="text" id="tolstenko_blog_faq_title" name="tolstenko_blog_faq_title" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php esc_attr_e( 'Пусто = из общих настроек', 'tolstenko-theme' ); ?>">
		</p>

		<p><strong><?php esc_html_e( 'Вопросы и ответы', 'tolstenko-theme' ); ?></strong></p>
		<div data-bf-list>
			<?php foreach ( $items as $i => $item ) : ?>
				<?php tolstenko_blog_faq_render_item_row( (string) $i, is_array( $item ) ? $item : array() ); ?>
			<?php endforeach; ?>
		</div>
		<p>
			<button type="button" class="button" data-bf-add><?php esc_html_e( 'Добавить вопрос', 'tolstenko-theme' ); ?></button>
		</p>
		<template data-bf-tpl>
			<?php tolstenko_blog_faq_render_item_row( '__INDEX__', array() ); ?>
		</template>
	</div>
	<script>
	(function(){
		const root = document.getElementById('tolstenko-blog-faq');
		if (!root) return;
		const list = root.querySelector('[data-bf-list]');
		const tpl = root.querySelector('[data-bf-tpl]');

		function refreshMoveButtons(){
			if (!list) return;
			const items = list.querySelectorAll('.tolstenko-bf-item');
			items.forEach(function(item, index){
				const up = item.querySelector('[data-bf-move-up]');
				const down = item.querySelector('[data-bf-move-down]');
				if (up) up.disabled = index === 0;
				if (down) down.disabled = index === items.length - 1;
			});
		}

		function moveItem(item, direction){
			if (!list || !item) return;
			const items = Array.prototype.slice.call(list.querySelectorAll('.tolstenko-bf-item'));
			const index = items.indexOf(item);
			const newIndex = index + direction;
			if (index < 0 || newIndex < 0 || newIndex >= items.length) return;
			if (direction > 0) {
				list.insertBefore(item, items[newIndex].nextSibling);
			} else {
				list.insertBefore(item, items[newIndex]);
			}
			refreshMoveButtons();
		}

		root.addEventListener('click', function(e){
			const add = e.target.closest('[data-bf-add]');
			if (add && tpl && list) {
				list.insertAdjacentHTML('beforeend', tpl.innerHTML.replace(/__INDEX__/g, Date.now().toString()));
				refreshMoveButtons();
				return;
			}
			const up = e.target.closest('[data-bf-move-up]');
			if (up) {
				e.preventDefault();
				moveItem(up.closest('.tolstenko-bf-item'), -1);
				return;
			}
			const down = e.target.closest('[data-bf-move-down]');
			if (down) {
				e.preventDefault();
				moveItem(down.closest('.tolstenko-bf-item'), 1);
				return;
			}
			const remove = e.target.closest('[data-bf-remove]');
			if (remove) {
				const row = remove.closest('.tolstenko-bf-item');
				if (row) row.remove();
				refreshMoveButtons();
			}
		});

		refreshMoveButtons();
	})();
	</script>
	<?php
}

/**
 * @param string $index Row index.
 * @param array  $item  FAQ item (quest / unswer — как в секции FAQ).
 */
function tolstenko_blog_faq_render_item_row( $index, array $item ) {
	$base = 'tolstenko_blog_faq_items[' . $index . ']';
	?>
	<div class="tolstenko-bf-item" data-bf-item>
		<label><?php esc_html_e( 'Вопрос', 'tolstenko-theme' ); ?></label>
		<input type="text" name="<?php echo esc_attr( $base . '[quest]' ); ?>" value="<?php echo esc_attr( (string) ( $item['quest'] ?? '' ) ); ?>">
		<label><?php esc_html_e( 'Ответ (можно HTML)', 'tolstenko-theme' ); ?></label>
		<textarea name="<?php echo esc_attr( $base . '[unswer]' ); ?>" rows="4"><?php echo esc_textarea( (string) ( $item['unswer'] ?? '' ) ); ?></textarea>
		<p class="tolstenko-bf-item-actions">
			<button type="button" class="button move-btn" data-bf-move-up title="<?php esc_attr_e( 'Вверх', 'tolstenko-theme' ); ?>">↑</button>
			<button type="button" class="button move-btn" data-bf-move-down title="<?php esc_attr_e( 'Вниз', 'tolstenko-theme' ); ?>">↓</button>
			<button type="button" class="button-link-delete" data-bf-remove><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
		</p>
	</div>
	<?php
}

/**
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function tolstenko_blog_faq_save_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['tolstenko_blog_faq_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_blog_faq_nonce'] ) ), 'tolstenko_blog_faq_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, 'blog_faq_hidden', ! empty( $_POST['tolstenko_blog_faq_hidden'] ) ? '1' : '0' );
	update_post_meta( $post_id, 'blog_faq_badge', isset( $_POST['tolstenko_blog_faq_badge'] ) ? sanitize_text_field( wp_unslash( $_POST['tolstenko_blog_faq_badge'] ) ) : '' );
	update_post_meta( $post_id, 'blog_faq_title', isset( $_POST['tolstenko_blog_faq_title'] ) ? tolstenko_kses_html( wp_unslash( $_POST['tolstenko_blog_faq_title'] ) ) : '' );

	$raw = isset( $_POST['tolstenko_blog_faq_items'] ) && is_array( $_POST['tolstenko_blog_faq_items'] )
		? wp_unslash( $_POST['tolstenko_blog_faq_items'] ) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized below.
		: array();

	$items = array();
	foreach ( $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$q = sanitize_text_field( (string) ( $row['quest'] ?? '' ) );
		$a = wp_kses_post( (string) ( $row['unswer'] ?? '' ) );
		if ( $q === '' && trim( wp_strip_all_tags( $a ) ) === '' ) {
			continue;
		}
		$items[] = array(
			'quest'  => $q,
			'unswer' => $a,
		);
	}
	update_post_meta( $post_id, 'blog_faq_items', $items );
}
