<?php

defined('ABSPATH') || exit;

/**
 * Секция «Статьи» (blog-section) — разметка как в tolstenko.marketing
 * (template-parts/blocks/blog-section.php): первая статья крупно, до трёх следующих —
 * в .splide__track (на мобильных — слайдер, assets/js/modules/blogSectionSplideInit.js),
 * в конце трека — кнопка в блог. Карточки — pages/sections/partials/blog-section-card.php.
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('blog_section_filters')
 * (таб «Дефолты блоков → Слайдера записей → Статьи»). Атрибуты блока
 * my-theme/blog-section (и данные «Похожих статей» на статье) имеют приоритет.
 *
 * Фильтр по рубрикам (флажок в табе) — REST /theme/v1/blog-section
 * (inc/blog/blog-section.php, assets/js/modules/blogSectionFilter.js).
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('blog_section_filters') : [];

$defaults = [
    'badge'          => $admin['badge'] ?? '',
    'title'          => $admin['title'] ?? '',
    'text'           => $admin['text'] ?? '',
    'ids'            => is_array($admin['ids'] ?? null) ? $admin['ids'] : [],
    'posts_per_page' => (int) ($admin['posts_per_page'] ?? THEME_BLOG_SECTION_MAX_POSTS),
    'btn_text'       => $admin['btn_text'] ?? '',
    'show_filter'    => !empty($admin['show_filter']),
];

$overrides = get_query_var('blog_section_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$badge          = trim((string) $data['badge']);
$title          = trim((string) $data['title']);
$text           = trim((string) $data['text']);
$post_ids       = array_slice(tolstenko_sanitize_ids($data['ids']), 0, THEME_BLOG_SECTION_MAX_POSTS);
$posts_per_page = max(1, min(THEME_BLOG_SECTION_MAX_POSTS, (int) $data['posts_per_page']));
$btn_text       = trim((string) $data['btn_text']);

$section_id = 'blog_' . wp_unique_id();
$taxonomy   = 'blog_cat';
$post_type  = 'blog';

$categories_with_posts = !empty($data['show_filter']) && !$post_ids ? theme_get_blog_section_terms() : [];

$items_html = theme_render_blog_section_items([
    'posts_per_page' => $posts_per_page,
    'post_ids'       => $post_ids,
    'btn_text'       => $btn_text,
]);

if ($title === '' && $text === '' && $items_html === '') {
    return;
}
?>
<section
	class="blog-section section"
	data-tolstenko-filter
	data-section-id="<?= esc_attr($section_id); ?>"
	data-taxonomy="<?= esc_attr($taxonomy); ?>"
	data-post-type="<?= esc_attr($post_type); ?>"
	data-posts-per-page="<?= esc_attr((string) $posts_per_page); ?>"
	data-card="blog_slider"
	data-post-ids="<?= esc_attr(implode(',', $post_ids)); ?>"
	data-btn-text="<?= esc_attr($btn_text); ?>"
>
	<div class="container">
		<div class="blog-section__top section-top">
			<?php if ($badge !== '') : ?>
				<span class="blog-section__badge section-subtitle"><?= wp_kses_post($badge); ?></span>
			<?php endif; ?>
			<?php if ($title !== '') : ?>
				<h2 class="blog-section__title h2"><?= tolstenko_kses_html($title); ?></h2>
			<?php endif; ?>
			<?php if ($text !== '') : ?>
				<p class="blog-section__text paragraph-15-15"><?= tolstenko_kses_html($text); ?></p>
			<?php endif; ?>
		</div>

		<?php if (!empty($categories_with_posts)) : ?>
			<div class="blog-section__filter filter filter--slider load-on-vissible--js" data-module="./modules/blogSectionFilter.js">
				<div class="filter__form swiper">
					<div class="swiper-wrapper">
							<label class="filter__radio swiper-slide">
								<input
									type="radio"
									name="<?= esc_attr($section_id); ?>_category"
									value=""
									data-section-id="<?= esc_attr($section_id); ?>"
									class="tolstenko-filter-radio"
									checked
								>
								<span class="filter__label">Все записи</span>
							</label>
						<?php foreach ($categories_with_posts as $cat) : ?>
								<label class="filter__radio swiper-slide">
									<input
										type="radio"
										name="<?= esc_attr($section_id); ?>_category"
										value="<?= esc_attr($cat->slug); ?>"
										data-section-id="<?= esc_attr($section_id); ?>"
										class="tolstenko-filter-radio"
									>
									<span class="filter__label"><?= esc_html($cat->name); ?></span>
								</label>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($items_html !== '') : ?>
			<div
				class="fade-in-container blog-section__splide splide load-on-vissible--js"
				id="<?= esc_attr($section_id); ?>-container"
				aria-label="Статьи"
				data-module="./libs/splide.min.js,./modules/blogSectionSplideInit.js"
				data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
			>
				<?= $items_html; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
