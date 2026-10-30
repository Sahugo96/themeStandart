<?php
/**
 * «Сетка статей» (my-theme/blog-grid) для страницы-архива /blog/ и рубрик /blog/{cat}/:
 * первая статья крупно + карточка автора, остальные — сеткой, внизу пагинация.
 *
 * Пагинация серверная (ссылки /blog/page/N/), поэтому число статей на странице
 * из настроек блока передаётся основному запросу архива — иначе WordPress
 * отдаст 404 на страницах, которых нет в основном запросе.
 *
 * Сетка перенесена из tolstenko.marketing (blog-section-tile + rest-posts-filter).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const THEME_BLOG_GRID_PER_PAGE = 9;

/**
 * Атрибуты первого блока «Сетка статей» на странице-архиве блога (или null).
 *
 * @return array|null
 */
function theme_get_blog_grid_attrs() {
	static $attrs = false;

	if ( $attrs !== false ) {
		return $attrs;
	}

	$attrs   = null;
	$page_id = theme_get_blog_page_id();
	$page    = $page_id ? get_post( $page_id ) : null;

	if ( $page instanceof WP_Post && has_block( THEME_BLOCKS_NAMESPACE . '/blog-grid', $page ) ) {
		foreach ( parse_blocks( $page->post_content ) as $block ) {
			if ( ( $block['blockName'] ?? '' ) === THEME_BLOCKS_NAMESPACE . '/blog-grid' ) {
				$attrs = (array) ( $block['attrs'] ?? array() );
				break;
			}
		}
	}

	return $attrs;
}

/**
 * Статей на странице для сетки.
 *
 * @param array $attrs Block attributes.
 * @return int
 */
function theme_get_blog_grid_per_page( array $attrs ) {
	$per_page = (int) ( $attrs['postsPerPage'] ?? 0 );

	return $per_page > 0 ? min( $per_page, 60 ) : THEME_BLOG_GRID_PER_PAGE;
}

/**
 * Основной запрос архива/рубрики подстраиваем под «Сетку статей».
 * Срабатывает после theme_blog_posts_per_page (приоритет 10).
 *
 * @param WP_Query $query Query.
 */
function theme_blog_grid_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_post_type_archive( 'blog' ) && ! $query->is_tax( 'blog_cat' ) ) {
		return;
	}

	$attrs = theme_get_blog_grid_attrs();

	if ( $attrs !== null ) {
		$query->set( 'posts_per_page', theme_get_blog_grid_per_page( $attrs ) );
	}
}
add_action( 'pre_get_posts', 'theme_blog_grid_posts_per_page', 20 );

/**
 * Активная рубрика (корневая) на странице /blog/{cat}/.
 *
 * @return WP_Term|null
 */
function theme_get_blog_grid_active_term() {
	if ( ! is_tax( 'blog_cat' ) ) {
		return null;
	}

	$term = get_queried_object();

	if ( ! $term instanceof WP_Term ) {
		return null;
	}

	while ( $term->parent ) {
		$parent = get_term( $term->parent, 'blog_cat' );
		if ( ! $parent instanceof WP_Term ) {
			break;
		}
		$term = $parent;
	}

	return $term;
}

/**
 * Рубрики первого уровня со статьями — для фильтра.
 *
 * @return WP_Term[]
 */
function theme_get_blog_grid_terms() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'blog_cat',
			'parent'     => 0,
			'hide_empty' => false,
			'pad_counts' => true,
		)
	);

	if ( is_wp_error( $terms ) ) {
		return array();
	}

	return array_values(
		array_filter(
			$terms,
			static function ( $term ) {
				return $term instanceof WP_Term && (int) $term->count > 0;
			}
		)
	);
}

/**
 * Запрос статей для сетки: на архиве/рубрике — основной запрос (он уже
 * постранично и по рубрике), в остальных местах — собственный.
 *
 * @param int $per_page Posts per page.
 * @return WP_Query
 */
function theme_get_blog_grid_query( $per_page ) {
	global $wp_query;

	if ( ( is_post_type_archive( 'blog' ) || is_tax( 'blog_cat' ) ) && $wp_query instanceof WP_Query ) {
		return $wp_query;
	}

	return new WP_Query(
		array(
			'post_type'      => 'blog',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'paged'          => theme_get_blog_paged(),
		)
	);
}

/**
 * HTML пагинации сетки (пусто, если страница одна).
 *
 * @param int $total   Total pages.
 * @param int $current Current page.
 * @return string
 */
function theme_render_blog_pagination( $total, $current ) {
	$args         = theme_get_blog_pagination_args( (int) $total, (int) $current );
	$args['type'] = 'plain';
	$links        = paginate_links( $args );

	if ( ! $links ) {
		return '';
	}

	// У стрелок только SVG — даём им подписи для скринридеров.
	$links = str_replace(
		array( 'class="prev page-numbers"', 'class="next page-numbers"' ),
		array( 'class="prev page-numbers" aria-label="Предыдущая страница"', 'class="next page-numbers" aria-label="Следующая страница"' ),
		$links
	);

	return '<nav class="blog-section__pagination pagination-page" aria-label="Страницы статей"><div class="pagination">' . $links . '</div></nav>';
}
