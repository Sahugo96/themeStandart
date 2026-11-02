<?php

/**
 * Статья (CPT blog).
 *
 * Редактор статьи заполняет только тело (.single-blog__content-blocks).
 * Остальное собирается здесь по группам мета-полей статьи:
 * шапка и сайдбар — «Карточка статьи» / «Статья: шапка, автор, комментарии»,
 * FAQ — «FAQ статьи», похожие статьи и услуги — «Слайдеры под статьёй».
 *
 * Статьи в старом формате (секции-блоки в содержимом) выводятся как раньше.
 */

get_header();
?>

<main class="main">
  <?php
  theme_render_breadcrumb();

  while (have_posts()) {
      the_post();

      if (has_block('my-theme/blog-content') || has_block('my-theme/single-blog')) {
          the_content();
          get_template_part('pages/single-blog/sections/comments');
          continue;
      }

      get_template_part('pages/single-blog/layout');
  }
  ?>
</main>

<?php get_footer(); ?>
