<?php

/**
 * Статья: шапка (фото, заголовок, лид, статистика, автор) + оглавление +
 * тело + сайдбар с автором.
 *
 * Тело — содержимое редактора статьи (single-blog.php передаёт его в body_html).
 * Если тела нет, выводится старое ACF-поле single-blog_content.
 *
 * @var array $args { @type string $body_html HTML тела статьи из редактора. }
 */

defined('ABSPATH') || exit;

$post_id = (int) get_the_ID();

if (!$post_id) {
    return;
}

$body_html = isset($args['body_html']) ? (string) $args['body_html'] : '';
$is_legacy = trim(wp_strip_all_tags($body_html, true)) === '' && !preg_match('/<(?:img|iframe|video)\b/i', $body_html);

if ($is_legacy) {
    $contents = theme_get_field('single-blog_content', $post_id);
    $body_html = '';

    if (is_array($contents) && $contents) {
        ob_start();
        get_template_part('pages/single-blog/sections/legacy-content', null, ['contents' => $contents]);
        $body_html = (string) ob_get_clean();
    }
}

$toc       = tolstenko_prepare_blog_toc($body_html);
$body_html = $toc['html'];
$toc_items = $toc['items'];

$pretext = trim((string) get_post_meta($post_id, 'single-blog_text', true));

$thumbnail = has_post_thumbnail($post_id)
    ? tolstenko_get_image_attrs(get_post_thumbnail_id($post_id))
    : null;

$director       = tolstenko_get_single_blog_director($post_id);
$director_photo = $director['photo'] ? tolstenko_get_image_attrs($director['photo'], 'medium') : null;
$director_alt   = $director_photo && $director_photo['alt'] !== '' ? $director_photo['alt'] : $director['name'];

// «Акции» в сайдбаре (ACF-поле blog_actions): выбранные записи,
// а если выбранные удалены — последние записи рубрики actions.
$actions_field = theme_get_field('blog_actions', $post_id);
$actions_query = null;

if ($actions_field) {
    $actions_ids = [];

    foreach (is_array($actions_field) ? $actions_field : [$actions_field] as $item) {
        $id = is_object($item) && isset($item->ID) ? (int) $item->ID : (int) $item;

        if ($id > 0 && get_post_status($id) === 'publish') {
            $actions_ids[] = $id;
        }
    }

    $actions_query = new WP_Query(
        $actions_ids
            ? ['post_type' => 'any', 'post__in' => array_values(array_unique($actions_ids)), 'orderby' => 'post__in', 'posts_per_page' => -1]
            : ['category_name' => 'actions', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => 5]
    );
}
?>

<section class="single-blog section">
  <div class="container">
    <div class="single-blog__wrapper">
      <div class="single-blog__content">
        <div class="single-blog__top">
          <?php if ($thumbnail) : ?>
            <img
              class="single-blog__top-img"
              src="<?= esc_url($thumbnail['url']); ?>"
              <?php if ($thumbnail['srcset'] !== '') : ?>srcset="<?= esc_attr($thumbnail['srcset']); ?>" sizes="<?= esc_attr($thumbnail['sizes']); ?>"<?php endif; ?>
              alt="<?= esc_attr($thumbnail['alt'] !== '' ? $thumbnail['alt'] : get_the_title($post_id)); ?>"
              decoding="async"
              fetchpriority="high"
            >
          <?php endif; ?>

          <h1 class="single-blog__title h2"><?= esc_html(get_the_title($post_id)); ?></h1>

          <?php if ($pretext !== '') : ?>
            <div class="single-blog__pretext paragraph-15-25"><?= esc_html($pretext); ?></div>
          <?php endif; ?>

          <div class="blog-card__stats">
            <?php get_template_part('modules/stats/stats'); ?>
          </div>

          <?php if ($director_photo && ($director['name'] !== '' || $director['title'] !== '')) : ?>
            <div class="single-blog__director">
              <img class="single-blog__director-photo" src="<?= esc_url($director_photo['url']); ?>" alt="<?= esc_attr($director_alt); ?>" loading="lazy" decoding="async">

              <div class="single-blog__director-wrapper">
                <?php if ($director['title'] !== '') : ?>
                  <div class="single-blog__director-title paragraph-15-25"><?= esc_html($director['title']); ?></div>
                <?php endif; ?>
                <?php if ($director['name'] !== '') : ?>
                  <div class="single-blog__director-name line-caps-bold-13-15"><?= esc_html($director['name']); ?></div>
                <?php endif; ?>
              </div>

              <?php if ($director['show_quest']) : ?>
                <a class="single-blog__director-btn default-btn default-btn--transparent" href="#comments">Задать вопрос</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="single-blog__content-blocks">
          <?php if ($toc_items) : ?>
            <div class="single-blog__content-article br-30">
              <div class="single-blog__content-article-title line-caps-bold-16-15">Содержание статьи</div>

              <div class="single-blog__content-article-items">
                <ol class="single-blog__toc">
                  <?php foreach ($toc_items as $item) : ?>
                    <li class="single-blog__toc-item single-blog__toc-item--h<?= (int) $item['level']; ?>">
                      <a class="single-blog__toc-link paragraph-15-25" href="#<?= esc_attr($item['id']); ?>"><?= esc_html($item['text']); ?></a>

                      <?php if ($item['children']) : ?>
                        <ul class="single-blog__toc-sub">
                          <?php foreach ($item['children'] as $child) : ?>
                            <li class="single-blog__toc-item single-blog__toc-item--h<?= (int) $child['level']; ?>">
                              <a class="single-blog__toc-link paragraph-15-25" href="#<?= esc_attr($child['id']); ?>"><?= esc_html($child['text']); ?></a>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ol>
              </div>

              <label class="single-blog__content-article-toggle" aria-label="Развернуть содержание">
                <input type="checkbox">
              </label>
            </div>
          <?php endif; ?>

          <?php if ($body_html !== '') : ?>
            <?php if ($is_legacy) : ?>
              <?= $body_html; ?>
            <?php else : ?>
              <div class="single-blog__content-contents redactor">
                <?= $body_html; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>

      <div class="single-blog__right">
        <div class="single-blog__right-info">
          <div class="single-blog__right-wrapper">
            <?php if ($director_photo) : ?>
              <img class="single-blog__right-photo" src="<?= esc_url($director_photo['url']); ?>" alt="<?= esc_attr($director_alt); ?>" loading="lazy" decoding="async">
            <?php endif; ?>

            <?php if ($director['name'] !== '') : ?>
              <div class="single-blog__right-name line-caps-bold-13-15"><?= esc_html($director['name']); ?></div>
            <?php endif; ?>

            <?php if ($director['description'] !== '') : ?>
              <div class="single-blog__right-text paragraph-15-25"><?= tolstenko_kses_html(wpautop($director['description'])); ?></div>
            <?php endif; ?>

            <?php get_template_part('modules/socials/socials-rgb'); ?>

            <a class="single-blog__right-btn default-btn default-btn--brown" href="#modal">Бесплатный аудит</a>

            <a class="single-blog__right-btn default-btn default-btn--transparent" href="#comments">Задать вопрос</a>
          </div>

          <?php if ($actions_query && $actions_query->have_posts()) : ?>
            <div class="single-blog__right-actions splide load-on-vissible--js"
              aria-label="Акции"
              data-module="./libs/splide.min.js,./modules/actionsBlogSplideInit.js"
              data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css">
              <div class="splide__track">
                <div class="single-blog__right-list splide__list">
                  <?php while ($actions_query->have_posts()) : $actions_query->the_post(); ?>
                    <article class="single-blog__right-list-item splide__slide">
                      <a class="single-blog__right-list-link line-caps-bold-15-15" href="<?= esc_url(get_permalink()); ?>">
                        <div class="single-blog__right-list-img">
                          <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                          <?php endif; ?>
                        </div>

                        <span class="single-blog__right-list-name"><?php the_title(); ?></span>
                      </a>
                    </article>
                  <?php endwhile; ?>
                  <?php wp_reset_postdata(); ?>
                </div>
              </div>

              <div class="splide__bottom">
                <div class="splide__pagination"></div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
