<?php
/**
 * Блоки тела статьи (my-theme/blog-*): общие хелперы.
 * Вставляются внутрь «Контент статьи» (my-theme/blog-content) вместе с текстом.
 *
 * Перенесено из tolstenko.marketing (inc/blog/content-blocks.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Слаги блоков тела статьи (папки в /blocks).
 *
 * @return string[]
 */
function tolstenko_get_blog_content_block_slugs() {
	return array(
		'blog-large-img',
		'blog-video',
		'blog-blockquote',
		'blog-number-list',
		'blog-warning',
		'blog-pros-cons',
		'blog-definition',
		'blog-seo',
	);
}

/**
 * Полные имена блоков тела статьи.
 *
 * @return string[]
 */
function tolstenko_get_blog_content_block_names() {
	$out = array();
	foreach ( tolstenko_get_blog_content_block_slugs() as $slug ) {
		$out[] = THEME_BLOCKS_NAMESPACE . '/' . $slug;
	}
	return $out;
}

/**
 * Блоки, доступные внутри «Контент статьи»: текст Gutenberg + блоки тела.
 *
 * @return string[]
 */
function tolstenko_get_blog_content_inner_blocks() {
	return array_merge(
		array(
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/list-item',
			'core/quote',
			'core/image',
			'core/table',
			'core/separator',
			'core/embed',
			'core/html',
		),
		tolstenko_get_blog_content_block_names()
	);
}

/**
 * URL страницы видео → embed URL (YouTube / Rutube / Vimeo).
 *
 * @param string $url Raw URL.
 * @return string Embed URL or empty.
 */
function tolstenko_blog_video_to_embed_url( $url ) {
	$url = trim( (string) $url );
	if ( $url === '' ) {
		return '';
	}

	$rutube_id = theme_get_rutube_video_id( $url );
	if ( $rutube_id !== '' ) {
		return 'https://rutube.ru/play/embed/' . rawurlencode( $rutube_id );
	}

	if ( preg_match( '#(?:youtube\.com/embed/|youtube\.com/watch\?(?:[^#]*&)?v=|youtu\.be/)([a-zA-Z0-9_-]{6,})#i', $url, $m ) ) {
		return 'https://www.youtube.com/embed/' . $m[1];
	}

	if ( preg_match( '#(?:player\.)?vimeo\.com/(?:video/)?(\d+)#i', $url, $m ) ) {
		return 'https://player.vimeo.com/video/' . $m[1];
	}

	// Уже embed-ссылка.
	if ( preg_match( '#/(?:embed|play/embed)/#i', $url ) ) {
		return $url;
	}

	return '';
}

/**
 * Прямой файл видео (mp4 и т.п.).
 *
 * @param string $url URL.
 * @return bool
 */
function tolstenko_blog_video_is_file_url( $url ) {
	return (bool) preg_match( '#\.(mp4|webm|ogg|ogv|mov|m4v)(\?|#|$)#i', (string) $url );
}

/**
 * Разрешённый HTML для rutube/iframe в блоке видео (и в его дефолтах).
 *
 * @return array
 */
function tolstenko_blog_video_iframe_allowed_html() {
	return array(
		'iframe' => array(
			'src'             => true,
			'width'           => true,
			'height'          => true,
			'frameborder'     => true,
			'allow'           => true,
			'allowfullscreen' => true,
			'style'           => true,
			'class'           => true,
			'title'           => true,
			'loading'         => true,
			'referrerpolicy'  => true,
			'data-src'        => true,
		),
		'div'    => array(
			'class' => true,
			'style' => true,
		),
	);
}
