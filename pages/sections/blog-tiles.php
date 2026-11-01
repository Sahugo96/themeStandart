<?php

defined('ABSPATH') || exit;

/**
 * Секция «Плитка статей» (blog-tiles) — для архива блога (страница с шаблоном «Archive blog»).
 *
 * Копия секции «Статьи» (pages/sections/blog-section.php) без слайдера и разных размеров
 * карточек: все статьи одинаковыми карточками (pages/sections/partials/blog-section-card.php)
 * в плитке .blog-section__tiles — 3 в ряд с переносом, внизу пагинация
 * (THEME_BLOG_ARCHIVE_PER_PAGE статей на странице).
 *
 * Шапка — из админки: tolstenko_get_block_defaults('blog_section_filters')
 * (таб «Дефолты блоков → Слайдера записей → Статьи»), атрибуты блока my-theme/blog-tiles
 * имеют приоритет. Статьи: в архиве блога и рубриках — основной запрос (рубрика, страница),
 * на других страницах — свой запрос.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('blog_section_filters') : [];

$defaults = [
    'badge' => $admin['badge'] ?? '',
    'title' => $admin['title'] ?? '',
    'text'  => $admin['text'] ?? '',
];

$overrides = get_query_var('blog_tiles_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$badge = trim((string) $data['badge']);
$title = trim((string) $data['title']);
$text  = trim((string) $data['text']);

global $wp_query;

$is_archive = (is_post_type_archive('blog') || is_tax('blog_cat')) && $wp_query instanceof WP_Query;
$paged      = theme_get_blog_paged();
$query      = $is_archive ? $wp_query : new WP_Query([
    'post_type'      => 'blog',
    'post_status'    => 'publish',
    'posts_per_page' => THEME_BLOG_ARCHIVE_PER_PAGE,
    'paged'          => $paged,
]);

if (!$query->have_posts() && $title === '' && $text === '') {
    return;
}
?>
<section class="blog-section blog-tiles section" data-card="blog_slider">
	<div class="container">
		<?php if ($badge !== '' || $title !== '' || $text !== '') : ?>
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
		<?php endif; ?>

		<?php if ($query->have_posts()) : ?>
			<div class="blog-section__tiles">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php
					get_template_part('pages/sections/partials/blog-section-card', null, [
						'post'  => get_post(),
						'class' => 'blog-section__item blog-card',
					]);
					?>
				<?php endwhile; ?>
			</div>

			<?= theme_render_blog_pagination((int) $query->max_num_pages, $paged); ?>
		<?php endif; ?>
		<?php
		if (!$is_archive) {
			wp_reset_postdata();
		} else {
			rewind_posts();
		}
		?>
	</div>
</section>
