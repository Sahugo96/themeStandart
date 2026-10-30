<?php
/**
 * Комментарии статьи: сверху карточка с формой CF7 (.form--dark), под ней —
 * карточка с одобренными комментариями (аватар, имя, дата, текст, ответы). Новые комментарии
 * попадают в очередь «Комментарии с сайта» (inc/blog/comment-queue.php).
 * Ответить можно на комментарий и на ответ (два уровня вложенности).
 *
 * Перенесено из tolstenko.marketing (pages/single-blog/sections/comments.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = (int) get_the_ID();
if ( ! $post_id || get_post_type( $post_id ) !== 'blog' ) {
	return;
}

$comments = tolstenko_blog_ensure_post_comment_ids( $post_id );
$count    = tolstenko_get_curated_blog_comments_count( $post_id );

if ( ! function_exists( 'tolstenko_render_blog_comment_item' ) ) {
	/**
	 * @param array $item  Comment row.
	 * @param int   $depth 0 = корень, 1 = ответ, 2 = ответ второго порядка.
	 */
	function tolstenko_render_blog_comment_item( array $item, $depth = 0 ) {
		$depth     = (int) $depth;
		$photo     = tolstenko_get_image_attrs( $item['photo'] ?? 0, 'thumbnail' );
		$name      = trim( (string) ( $item['name'] ?? '' ) );
		$date      = trim( (string) ( $item['date'] ?? '' ) );
		$text      = trim( (string) ( $item['text'] ?? '' ) );
		$cid       = tolstenko_blog_comment_normalize_id( $item['id'] ?? '' );
		$can_reply = ( $depth < 2 && $cid !== '' );
		$initial   = $name !== '' ? mb_strtoupper( mb_substr( $name, 0, 1 ) ) : '?';
		$replies   = $depth < 2 && is_array( $item['replies'] ?? null ) ? array_filter( $item['replies'], 'is_array' ) : array();
		?>
		<li
			class="comments__item"
			<?php if ( $cid !== '' ) : ?>
				id="comment-<?php echo esc_attr( $cid ); ?>"
				data-comment-id="<?php echo esc_attr( $cid ); ?>"
			<?php endif; ?>
		>
			<div class="comments__avatar">
				<?php if ( $photo ) : ?>
					<img src="<?php echo esc_url( $photo['url'] ); ?>" alt="<?php echo esc_attr( $photo['alt'] ?: $name ); ?>" loading="lazy" decoding="async">
				<?php else : ?>
					<span aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
				<?php endif; ?>
			</div>

			<div class="comments__body">
				<article class="comments__card">
					<div class="comments__head">
						<?php if ( $name !== '' ) : ?>
							<div class="comments__author"><?php echo esc_html( $name ); ?></div>
						<?php endif; ?>

						<?php if ( $date !== '' ) : ?>
							<span class="comments__date">
								<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
								<?php echo esc_html( $date ); ?>
							</span>
						<?php endif; ?>
					</div>

					<?php if ( $text !== '' ) : ?>
						<div class="comments__text reg-par-14-20"><?php echo nl2br( esc_html( $text ) ); ?></div>
					<?php endif; ?>

					<?php if ( $can_reply ) : ?>
						<button
							type="button"
							class="comments__reply"
							data-comment-reply
							data-comment-id="<?php echo esc_attr( $cid ); ?>"
							data-comment-author="<?php echo esc_attr( $name ); ?>"
						>
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H11"/></svg>
							<?php esc_html_e( 'Ответить', 'tolstenko-theme' ); ?>
						</button>
					<?php endif; ?>
				</article>

				<?php if ( $replies ) : ?>
					<ol class="comments__children">
						<?php foreach ( $replies as $reply ) : ?>
							<?php tolstenko_render_blog_comment_item( $reply, $depth + 1 ); ?>
						<?php endforeach; ?>
					</ol>
				<?php endif; ?>
			</div>
		</li>
		<?php
	}
}

?>

<section class="comments section load-on-vissible--js" id="comments" data-module="./modules/blogComments.js">
	<div class="container">
		<div class="comments__inner">
			<div class="comments__right br-30">
				<div class="comments__top section-top">
					<span class="comments__badge section-subtitle"><?php esc_html_e( 'Обсуждение', 'tolstenko-theme' ); ?></span>
					<h2 class="comments__title section-title">
					<?php esc_html_e( 'Комментарии', 'tolstenko-theme' ); ?>
					<?php if ( $count ) : ?>
						<span><?php echo (int) $count; ?></span>
					<?php endif; ?>
					</h2>
				</div>

				<div class="comments__reply-hint" data-comments-reply-hint hidden>
					<span class="comments__reply-hint-text" data-comments-reply-hint-text></span>
					<button type="button" class="comments__reply-cancel" data-comments-reply-cancel>
						<?php esc_html_e( 'Отмена', 'tolstenko-theme' ); ?>
					</button>
				</div>

				<div class="comments__form form form--dark br-20">
					<?php echo do_shortcode( tolstenko_blog_comment_form_shortcode() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CF7 markup. ?>
				</div>
			</div>

			<?php if ( $comments ) : ?>
				<div class="comments__list-card br-30">
					<ol class="comments__list">
						<?php foreach ( $comments as $comment ) : ?>
							<?php if ( is_array( $comment ) ) : ?>
								<?php tolstenko_render_blog_comment_item( $comment, 0 ); ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</ol>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
