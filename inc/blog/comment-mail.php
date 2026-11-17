<?php
/**
 * Письма авторам комментариев к статьям.
 *
 * - Комментарий одобрен (очередь «Комментарии с сайта») → письмо его автору.
 * - Опубликован ответ (одобрен из очереди или добавлен в статье, в метабоксе
 *   «Комментарии») → письмо автору комментария, на который ответили.
 *
 * Каждое письмо уходит один раз: отправленные отмечаются в meta статьи
 * blog_comments_notified. Email берётся из комментария (на сайте не выводится).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Отметить письмо как отправленное; false — уже было отправлено.
 *
 * @param int    $post_id Article ID.
 * @param string $key     published:<id> | reply:<id>.
 * @return bool
 */
function tolstenko_blog_comment_mail_claim( $post_id, $key ) {
	$sent = get_post_meta( $post_id, 'blog_comments_notified', true );
	$sent = is_array( $sent ) ? $sent : array();

	if ( in_array( $key, $sent, true ) ) {
		return false;
	}

	$sent[] = $key;
	update_post_meta( $post_id, 'blog_comments_notified', array_slice( $sent, -500 ) );

	return true;
}

/**
 * HTML письма: заголовок, абзацы, цитата комментария и кнопка-ссылка.
 *
 * @param string   $heading Heading.
 * @param string[] $lines   Paragraphs (plain text).
 * @param string   $quote   Comment text (plain).
 * @param string   $url     Link to the comment.
 * @return string
 */
function tolstenko_blog_comment_mail_html( $heading, array $lines, $quote, $url ) {
	$site = wp_specialchars_decode( (string) get_bloginfo( 'name' ), ENT_QUOTES );

	ob_start();
	?>
	<div style="margin:0;padding:24px;background:#F3F0E9;font-family:Arial,Helvetica,sans-serif;color:#18212A;">
		<div style="max-width:560px;margin:0 auto;padding:32px;border-radius:20px;background:#ffffff;">
			<p style="margin:0 0 20px;font-size:12px;letter-spacing:.06em;text-transform:uppercase;color:#B89A68;"><?php echo esc_html( $site ); ?></p>
			<h1 style="margin:0 0 16px;font-size:22px;line-height:1.25;color:#18212A;"><?php echo esc_html( $heading ); ?></h1>
			<?php foreach ( $lines as $line ) : ?>
				<p style="margin:0 0 12px;font-size:15px;line-height:1.5;"><?php echo esc_html( $line ); ?></p>
			<?php endforeach; ?>
			<?php if ( $quote !== '' ) : ?>
				<blockquote style="margin:20px 0;padding:14px 18px;border-left:3px solid #B89A68;border-radius:8px;background:#F3F0E9;font-size:14px;line-height:1.5;color:#4D4D4D;"><?php echo nl2br( esc_html( $quote ) ); ?></blockquote>
			<?php endif; ?>
			<?php if ( $url !== '' ) : ?>
				<p style="margin:24px 0 0;"><a href="<?php echo esc_url( $url ); ?>" style="display:inline-block;padding:14px 26px;border-radius:40px;background:#B89A68;color:#ffffff;font-size:14px;font-weight:bold;text-decoration:none;"><?php esc_html_e( 'Открыть комментарий', 'tolstenko-theme' ); ?></a></p>
			<?php endif; ?>
		</div>
		<p style="max-width:560px;margin:16px auto 0;font-size:12px;line-height:1.5;color:#808080;text-align:center;"><?php esc_html_e( 'Письмо отправлено автоматически, отвечать на него не нужно.', 'tolstenko-theme' ); ?></p>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * @param string $to      Email.
 * @param string $subject Subject (без названия сайта).
 * @param string $html    Body.
 * @return bool
 */
function tolstenko_blog_comment_mail_send( $to, $subject, $html ) {
	$site = wp_specialchars_decode( (string) get_bloginfo( 'name' ), ENT_QUOTES );

	return wp_mail(
		$to,
		sprintf( '[%s] %s', $site, $subject ),
		$html,
		array( 'Content-Type: text/html; charset=UTF-8' )
	);
}

/**
 * @param string $text Text.
 * @return string
 */
function tolstenko_blog_comment_mail_excerpt( $text ) {
	$text = trim( wp_strip_all_tags( (string) $text ) );

	return function_exists( 'mb_substr' ) && mb_strlen( $text ) > 300
		? rtrim( mb_substr( $text, 0, 300 ) ) . '…'
		: $text;
}

/**
 * Ссылка на комментарий в статье.
 *
 * @param int    $post_id    Article ID.
 * @param string $comment_id Comment id.
 * @return string
 */
function tolstenko_blog_comment_url( $post_id, $comment_id ) {
	$url = (string) get_permalink( $post_id );

	return ( $url !== '' && $comment_id !== '' ) ? $url . '#comment-' . rawurlencode( $comment_id ) : $url;
}

/**
 * Автору: «Ваш комментарий опубликован».
 *
 * @param int    $post_id    Article ID.
 * @param array  $comment    Comment row (name, email, text).
 * @param string $comment_id Comment id.
 * @return bool Отправлено.
 */
function tolstenko_blog_comment_mail_published( $post_id, array $comment, $comment_id ) {
	$email = tolstenko_blog_comment_sanitize_email( $comment['email'] ?? '' );
	if ( $email === '' || ! tolstenko_blog_comment_mail_claim( $post_id, 'published:' . $comment_id ) ) {
		return false;
	}

	$name  = trim( (string) ( $comment['name'] ?? '' ) );
	$title = wp_strip_all_tags( (string) get_the_title( $post_id ) );

	$html = tolstenko_blog_comment_mail_html(
		__( 'Ваш комментарий опубликован', 'tolstenko-theme' ),
		array(
			$name !== '' ? sprintf( __( 'Здравствуйте, %s!', 'tolstenko-theme' ), $name ) : __( 'Здравствуйте!', 'tolstenko-theme' ),
			sprintf( __( 'Ваш комментарий к статье «%s» прошёл модерацию и опубликован на сайте.', 'tolstenko-theme' ), $title ),
			__( 'Если на него ответят, мы пришлём письмо.', 'tolstenko-theme' ),
		),
		tolstenko_blog_comment_mail_excerpt( $comment['text'] ?? '' ),
		tolstenko_blog_comment_url( $post_id, $comment_id )
	);

	return tolstenko_blog_comment_mail_send( $email, __( 'Ваш комментарий опубликован', 'tolstenko-theme' ), $html );
}

/**
 * Автору комментария: «На ваш комментарий ответили».
 * Не отправляется, если отвечает сам автор (тот же email).
 *
 * @param int    $post_id  Article ID.
 * @param array  $parent   Parent comment row.
 * @param array  $reply    Reply row (name, email, text).
 * @param string $reply_id Reply id.
 * @return bool Отправлено.
 */
function tolstenko_blog_comment_mail_reply( $post_id, array $parent, array $reply, $reply_id ) {
	$to          = tolstenko_blog_comment_sanitize_email( $parent['email'] ?? '' );
	$reply_email = tolstenko_blog_comment_sanitize_email( $reply['email'] ?? '' );

	if ( $to === '' || ( $reply_email !== '' && strcasecmp( $to, $reply_email ) === 0 ) ) {
		return false;
	}
	if ( ! tolstenko_blog_comment_mail_claim( $post_id, 'reply:' . $reply_id ) ) {
		return false;
	}

	$parent_name = trim( (string) ( $parent['name'] ?? '' ) );
	$reply_name  = trim( (string) ( $reply['name'] ?? '' ) );
	$title       = wp_strip_all_tags( (string) get_the_title( $post_id ) );

	$lines = array(
		$parent_name !== '' ? sprintf( __( 'Здравствуйте, %s!', 'tolstenko-theme' ), $parent_name ) : __( 'Здравствуйте!', 'tolstenko-theme' ),
		sprintf( __( 'На ваш комментарий к статье «%s» ответили.', 'tolstenko-theme' ), $title ),
	);
	if ( $reply_name !== '' ) {
		$lines[] = sprintf( __( 'Автор ответа: %s', 'tolstenko-theme' ), $reply_name );
	}

	$html = tolstenko_blog_comment_mail_html(
		__( 'Новый ответ на ваш комментарий', 'tolstenko-theme' ),
		$lines,
		tolstenko_blog_comment_mail_excerpt( $reply['text'] ?? '' ),
		tolstenko_blog_comment_url( $post_id, $reply_id )
	);

	return tolstenko_blog_comment_mail_send( $to, __( 'Новый ответ на ваш комментарий', 'tolstenko-theme' ), $html );
}

/**
 * Плоский список комментариев дерева: id → [comment, parent|null].
 *
 * @param array $comments Comments tree.
 * @return array<string, array{comment:array,parent:?array}>
 */
function tolstenko_blog_comments_flatten( array $comments ) {
	$out = array();

	$walk = static function ( array $rows, $parent ) use ( &$walk, &$out ) {
		foreach ( $rows as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$id = tolstenko_blog_comment_normalize_id( $row['id'] ?? '' );
			if ( $id !== '' ) {
				$out[ $id ] = array(
					'comment' => $row,
					'parent'  => $parent,
				);
			}
			if ( ! empty( $row['replies'] ) && is_array( $row['replies'] ) ) {
				$walk( $row['replies'], $row );
			}
		}
	};
	$walk( $comments, null );

	return $out;
}

/**
 * Ответы, добавленные в статье (метабокс «Комментарии»): письмо автору
 * комментария, на который ответили. Новые — id, которых не было до сохранения.
 *
 * @param int   $post_id Article ID.
 * @param array $before  Tree before save.
 * @param array $after   Tree after save.
 */
function tolstenko_blog_comments_notify_new_replies( $post_id, array $before, array $after ) {
	$old = tolstenko_blog_comments_flatten( $before );

	foreach ( tolstenko_blog_comments_flatten( $after ) as $id => $row ) {
		if ( isset( $old[ $id ] ) || ! is_array( $row['parent'] ) ) {
			continue;
		}
		tolstenko_blog_comment_mail_reply( $post_id, $row['parent'], $row['comment'], $id );
	}
}
