<?php

/**
 * Template Name: Archive service
 * Archive: service
 */

get_header();
?>

<main class="main">
  <?php
  theme_render_breadcrumb();

  if (is_post_type_archive('service') || is_tax('service_cat')) {
      theme_output_service_page_blocks();
  } else {
      while (have_posts()) {
          the_post();
          the_content();
      }
  }
  ?>
</main>

<?php get_footer(); ?>
