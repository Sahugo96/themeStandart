<?php

/**
 * Template Name: Services page
 */

get_header(); ?>

<main class="main">

  <?php
  theme_render_breadcrumb();
  get_template_part('pages/services/sections/hero');
  get_template_part('pages/services/sections/services');
  get_template_part('pages/services/sections/calc');
  ?>

</main>

<?php get_footer(); ?>