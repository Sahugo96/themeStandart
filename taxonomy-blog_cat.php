<?php

/**
 * Taxonomy archive: blog_cat
 */

get_header();
?>

<main class="main">
  <?php
  theme_render_breadcrumb();
  theme_output_blog_page_blocks();
  ?>
</main>

<?php get_footer(); ?>
