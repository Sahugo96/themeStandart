<?php
/**
 * Секция «Статьи» (pages/sections/blog-section.php): разметка как в tolstenko.marketing —
 * первая статья крупно, до трёх следующих — в .splide__track (на мобильных слайдер),
 * в конце трека кнопка «Перейти в блог». Фильтр по рубрикам — REST /theme/v1/blog-section.
 *
 * Перенесено из tolstenko.marketing (inc/rest-posts-filter.php: tolstenko_render_blog_slider_layout_payload,
 * tolstenko_render_blog_section_filters_button; template-parts/blocks/blog-card.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const THEME_BLOG_SECTION_MAX_POSTS = 4;

/**
 * Карточка статьи секции (разметка blog-card из tolstenko.marketing).
 *
 * @param WP_Post $post      Post.
 * @param bool    $featured  Первая (крупная) карточка.
 */
function theme_render_blog_section_card( $post, $featured = false ) {
	if ( ! $post instanceof WP_Post ) {
		return;
	}

	get_template_part(
		'pages/sections/partials/blog-section-card',
		null,
		array(
			'post'  => $post,
			'class' => 'blog-section__item blog-card fade-in-element splide__slide' . ( $featured ? ' blog-card--featured' : '' ),
		)
	);
}

/**
 * Кнопка под списком статей.
 *
 * @param string $text Button text.
 */
function theme_render_blog_section_button( $text ) {
	$text = trim( (string) $text );
	if ( $text === '' ) {
		return;
	}

	$page_id = function_exists( 'theme_get_blog_page_id' ) ? theme_get_blog_page_id() : 0;
	$url     = $page_id ? (string) get_permalink( $page_id ) : (string) get_post_type_archive_link( 'blog' );
	$url     = $url !== '' ? $url : home_url( '/blog/' );
	?>
	<a class="blog-section__btn default-btn" href="<?php echo esc_url( $url ); ?>">
		<?php echo esc_html( $text ); ?>
		<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
			<path d="M5.87524 14.1246L13.5356 6.46426M7.05376 5.875H13.2915C13.7517 5.875 14.1248 6.2481 14.1248 6.70833V12.9461" stroke="black" stroke-width="2" stroke-linecap="round" />
		</svg>
	</a>
	<?php
}

/**
 * HTML карточек секции: 1-я карточка + .splide__track с остальными и кнопкой.
 *
 * @param array $args { term, posts_per_page, post_ids, exclude, btn_text }.
 * @return string
 */
function theme_render_blog_section_items( array $args ) {
	$per_page = max( 1, min( THEME_BLOG_SECTION_MAX_POSTS, (int) ( $args['posts_per_page'] ?? THEME_BLOG_SECTION_MAX_POSTS ) ) );
	$post_ids = array_slice( tolstenko_sanitize_ids( $args['post_ids'] ?? array() ), 0, THEME_BLOG_SECTION_MAX_POSTS );
	$term     = sanitize_title( (string) ( $args['term'] ?? '' ) );

	$query_args = array(
		'post_type'           => 'blog',
		'post_status'         => 'publish',
		'posts_per_page'      => $per_page,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( $post_ids ) {
		$query_args['post__in']       = $post_ids;
		$query_args['orderby']        = 'post__in';
		$query_args['posts_per_page'] = count( $post_ids );
	}

	if ( ! empty( $args['exclude'] ) ) {
		$query_args['post__not_in'] = tolstenko_sanitize_ids( $args['exclude'] );
	}

	if ( $term !== '' ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'blog_cat',
				'field'    => 'slug',
				'terms'    => $term,
			),
		);
	}

	$query = new WP_Query( $query_args );
	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	$index = 0;
	while ( $query->have_posts() ) {
		$query->the_post();

		if ( 0 === $index ) {
			theme_render_blog_section_card( get_post(), true );
		} else {
			if ( 1 === $index ) {
				echo '<div class="splide__track"><div class="blog-section__splide-list splide__list">';
			}
			theme_render_blog_section_card( get_post(), false );
		}
		++$index;
	}

	if ( $index > 1 ) {
		echo '</div>';
		echo '<div class="splide__pagination"></div>';
		theme_render_blog_section_button( (string) ( $args['btn_text'] ?? '' ) );
		echo '</div>';
	}

	wp_reset_postdata();

	return (string) ob_get_clean();
}

/**
 * Рубрики первого уровня со статьями — для фильтра секции.
 *
 * @return WP_Term[]
 */
function theme_get_blog_section_terms() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'blog_cat',
			'parent'     => 0,
			'hide_empty' => true,
		)
	);

	return is_wp_error( $terms ) ? array() : array_values( $terms );
}

add_action( 'rest_api_init', 'theme_register_blog_section_rest_route' );

/**
 * GET /wp-json/theme/v1/blog-section?term=&posts_per_page=&post_ids=&btn_text=
 */
function theme_register_blog_section_rest_route() {
	register_rest_route(
		'theme/v1',
		'/blog-section',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => '__return_true',
			'callback'            => static function ( WP_REST_Request $request ) {
				return rest_ensure_response(
					array(
						'html' => theme_render_blog_section_items(
							array(
								'term'           => (string) $request->get_param( 'term' ),
								'posts_per_page' => (int) $request->get_param( 'posts_per_page' ),
								'post_ids'       => (string) $request->get_param( 'post_ids' ),
								'btn_text'       => sanitize_text_field( (string) $request->get_param( 'btn_text' ) ),
							)
						),
					)
				);
			},
		)
	);
}
