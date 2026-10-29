<?php

/**
 * Single blog template
 */

get_header();
?>

<main class="main">
  <?php
  theme_render_breadcrumb();

  while (have_posts()) {
      the_post();
      the_content();

      // Статьи, созданные до появления блока «Комментарии статьи», получают комментарии в конце.
      if (!has_block('my-theme/blog-comments')) {
          get_template_part('pages/single-blog/sections/comments');
      }
  }
  ?>
</main>

<?php get_footer(); ?>
