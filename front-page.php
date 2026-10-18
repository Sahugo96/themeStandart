<?php

/**
 * Template Name: Main page
 */

get_header();
?>

<main class="main">
    <?php
    if (is_front_page()) {
        theme_output_front_page_blocks();
    } else {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }

    // Hardcoded-секции вынесены в блоки (my-theme/*) с дефолтами.
    // Если на странице есть соответствующий Gutenberg-блок — выводится он,
    // иначе подставляются дефолты секции.
    theme_render_front_section('result');
    theme_render_front_section('compare');
    theme_render_front_section('why-us');
    theme_render_front_section('infra');
    theme_render_front_section('about');
    theme_render_front_section('guide');
    theme_render_front_section('consult');
    theme_render_front_section('hero-stats');
    theme_render_front_section('situations');
    theme_render_front_section('process');
    theme_render_front_section('cost');
    theme_render_front_section('blog-more');
    theme_render_front_section('documents');
    ?>
</main>

<?php get_footer(); ?>
