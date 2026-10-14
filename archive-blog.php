<?php

/**
 * Template Name: Archive blog
 * Archive: blog
 */

get_header();
?>

<main class="main">
  <?php
  theme_render_breadcrumb();

  if (is_post_type_archive('blog') || is_tax('blog_cat')) {
      theme_output_blog_page_blocks();
  } else {
      while (have_posts()) {
          the_post();
          the_content();
      }
  }
  ?>
</main>

<?php get_footer(); ?>
