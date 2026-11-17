<?php

/**
 * Template Name: Страница документа
 *
 * Страница, устроенная как статья (inc/document-page.php): редактор заполняет только тело
 * (как у статьи), шапка/автор/FAQ/слайдеры — метабоксы «Документ: …», «FAQ документа»,
 * «Слайдеры под документом». Между FAQ и «Похожими статьями» — «Это ещё не конец».
 */

get_header();
?>

<main class="main">
  <?php
  theme_render_breadcrumb();

  while (have_posts()) {
      the_post();

      get_template_part('pages/single-blog/layout', null, [
          'comments_cta' => true,
      ]);
  }
  ?>
</main>

<?php get_footer(); ?>
