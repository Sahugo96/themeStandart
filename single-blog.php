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

      get_template_part('pages/single-blog/sections/single-blog', null, [
          'body_html' => tolstenko_get_blog_body_html(get_the_ID()),
      ]);

      $faq = tolstenko_get_blog_faq_overrides();
      if ($faq !== null) {
          set_query_var('faq_data', theme_get_faq_section_data($faq));
          get_template_part('pages/sections/faq');
      }

      $related = tolstenko_get_blog_related_overrides();
      if ($related !== null) {
          set_query_var('blog_related_data', theme_get_blog_related_data($related));
          get_template_part('pages/sections/blog-section-related');
      }

      $services = tolstenko_get_blog_services_overrides();
      if ($services !== null) {
          set_query_var('services_slider_simple_data', theme_get_services_slider_simple_data($services));
          get_template_part('pages/sections/service-section-simple', null, [
              'section_id' => 'service_slider_simple_' . wp_unique_id(),
          ]);
      }

      get_template_part('pages/single-blog/sections/comments');
  }
  ?>
</main>

<?php get_footer(); ?>
