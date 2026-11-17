<?php

/**
 * Single service template.
 *
 * Страница услуги заполняется как главная: секции-блоки в редакторе
 * (шаблон новой услуги — theme_get_service_single_block_template()).
 * Хлебные крошки — блок «Хлебные крошки»; у старых услуг без него выводятся сверху.
 */

get_header();
?>

<main class="main">
  <?php
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
