<?php

/**
 * «Сетка статей»: заголовок, табы-ссылки по рубрикам, первая статья крупно +
 * карточка автора, остальные — сеткой, пагинация.
 *
 * Карточки и панель — как в секции «Статьи» на главной
 * (pages/sections/partials/blog-card-section.php, стили .blog-section--home).
 *
 * @var array $args { @type array $attributes Атрибуты блока my-theme/blog-grid. }
 */

defined('ABSPATH') || exit;

$attrs      = isset($args['attributes']) && is_array($args['attributes']) ? $args['attributes'] : [];
$is_listing = is_post_type_archive('blog') || is_tax('blog_cat');

$title = trim((string) ($attrs['title'] ?? '')) ?: (string) theme_get_field('blog_section_title', OPTION_ID);
$text  = trim((string) ($attrs['text'] ?? '')) ?: (string) theme_get_field('blog_section_text', OPTION_ID);

$per_page    = theme_get_blog_grid_per_page($attrs);
$show_filter = !array_key_exists('showFilter', $attrs) || !empty($attrs['showFilter']);
$show_author = !array_key_exists('showAuthor', $attrs) || !empty($attrs['showAuthor']);

$active_term = theme_get_blog_grid_active_term();
$terms       = $show_filter ? theme_get_blog_grid_terms() : [];

$query = theme_get_blog_grid_query($per_page);
$paged = max(1, theme_get_blog_paged(), (int) $query->get('paged'));

$author       = $show_author ? tolstenko_get_blog_default_author() : null;
$author_photo = $author && $author['photo'] ? tolstenko_get_image_attrs($author['photo'], 'medium') : null;
$has_author   = $author && ($author_photo || $author['name'] !== '' || $author['description'] !== '');

$title_tag    = $is_listing ? 'h1' : 'h2';
$card_heading = $title_tag === 'h1' ? 'h2' : 'h3';
?>

<section class="blog-section blog-section--home blog-section--grid section">
  <div class="container">
    <?php if ($title !== '' || $text !== '') : ?>
      <div class="blog-section__top section-top">
        <?php if ($title !== '') : ?>
          <<?= $title_tag; ?> class="blog-section__title section-title"><?= tolstenko_kses_html($title); ?></<?= $title_tag; ?>>
        <?php endif; ?>

        <?php if ($text !== '') : ?>
          <div class="blog-section__text section-text"><?= theme_section_text_html($text); ?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($terms) : ?>
      <nav class="blog-section__filter filter filter--tabs filter--dark" aria-label="Рубрики статей">
        <div class="filter__form">
          <a class="filter__link<?= $active_term ? '' : ' active'; ?>" href="<?= esc_url(get_post_type_archive_link('blog')); ?>"<?= $active_term ? '' : ' aria-current="page"'; ?>>
            <span class="filter__label">Все записи</span>
          </a>

          <?php foreach ($terms as $term) :
            $is_active = $active_term && $active_term->term_id === $term->term_id;
          ?>
            <a class="filter__link<?= $is_active ? ' active' : ''; ?>" href="<?= esc_url(get_term_link($term)); ?>"<?= $is_active ? ' aria-current="page"' : ''; ?>>
              <span class="filter__label"><?= esc_html($term->name); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </nav>
    <?php endif; ?>

    <div class="blog-section__panel">
      <?php if ($query->have_posts()) : ?>
        <div class="blog-section__cards">
          <?php
          $index = 0;

          while ($query->have_posts()) :
              $query->the_post();

              get_template_part('pages/sections/partials/blog-card-section', null, [
                  'large'   => $index === 0,
                  'class'   => '',
                  'heading' => $card_heading,
              ]);

              if ($index === 0 && $has_author) : ?>
                <aside class="blog-section__author">
                  <div class="blog-section__author-head">
                    <?php if ($author_photo) : ?>
                      <img class="blog-section__author-photo" src="<?= esc_url($author_photo['url']); ?>" alt="<?= esc_attr($author_photo['alt'] ?: $author['name']); ?>" loading="lazy" decoding="async">
                    <?php endif; ?>

                    <div class="blog-section__author-info">
                      <?php if ($author['name'] !== '') : ?>
                        <div class="blog-section__author-name"><?= esc_html($author['name']); ?></div>
                      <?php endif; ?>
                      <?php if ($author['title'] !== '') : ?>
                        <div class="blog-section__author-job"><?= esc_html($author['title']); ?></div>
                      <?php endif; ?>
                    </div>
                  </div>

                  <?php if ($author['description'] !== '') : ?>
                    <div class="blog-section__author-text"><?= tolstenko_kses_html(wpautop($author['description'])); ?></div>
                  <?php endif; ?>

                  <a class="blog-section__author-btn default-btn default-btn--brown" href="#modal">Бесплатный аудит</a>
                </aside>
              <?php endif;

              $index++;
          endwhile;
          ?>
        </div>
      <?php else : ?>
        <p class="blog-section__empty">В этой рубрике пока нет статей.</p>
      <?php endif; ?>
    </div>

    <?= theme_render_blog_pagination((int) $query->max_num_pages, $paged); ?>
  </div>
</section>
<?php
// Основной запрос архива возвращаем в исходное состояние для остального шаблона.
if ($query === $GLOBALS['wp_query']) {
    $query->rewind_posts();
}

wp_reset_postdata();
