<?php

/**
 * Single service template
 */

get_header();
?>

<main class="main">
  <?php
  theme_render_breadcrumb();

  while (have_posts()) {
      the_post();
      the_content();
  }
  ?>
</main>

<?php get_footer(); ?>
