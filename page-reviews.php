<?php

/**
 * Template Name: Reviews page
 */

get_header();
?>

<main class="main">
  <?php
  // Крошки — блоком «Хлебные крошки» в шаблоне страницы; если блока нет — здесь, в начале.
  if (!has_block('my-theme/breadcrumbs', get_queried_object_id())) {
      theme_render_breadcrumb();
  }

  while (have_posts()) {
      the_post();
      the_content();
  }
  ?>
</main>

<?php get_footer(); ?>
