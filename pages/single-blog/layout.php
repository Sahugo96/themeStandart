<?php

defined('ABSPATH') || exit;

/**
 * Макет статьи (single-blog.php) и страницы документа (page-document.php):
 * тело с шапкой и содержанием → FAQ → [«Это ещё не конец»] → похожие статьи → услуги → комментарии.
 * Данные — группы мета-полей записи (inc/blog/*).
 *
 * @var array $args { comments_cta: bool — вывести секцию «Это ещё не конец» после FAQ }
 */

$args = isset($args) && is_array($args) ? $args : [];

get_template_part('pages/single-blog/sections/single-blog', null, [
    'body_html' => tolstenko_get_blog_body_html(get_the_ID()),
]);

$faq = tolstenko_get_blog_faq_overrides();
if ($faq !== null) {
    set_query_var('faq_data', theme_get_faq_section_data($faq));
    get_template_part('pages/sections/faq');
}

// Страница документа: «Это ещё не конец» — между FAQ и «Похожими статьями».
if (!empty($args['comments_cta'])) {
    get_template_part('pages/sections/comments-cta');
}

// Похожие статьи — секция «Статьи» с главной (крупная карточка + колонка, на мобильных — слайдер).
$related = tolstenko_get_blog_related_overrides();
if ($related !== null) {
    $related_data = theme_get_blog_related_data($related);

    set_query_var('blog_section_data', [
        'title' => $related['title'] !== '' ? $related['title'] : 'Похожие <span>статьи</span>',
        'ids'   => $related_data['post_ids'],
    ]);
    get_template_part('pages/sections/blog-section');
    set_query_var('blog_section_data', []);
}

// Услуги — секция «Услуги» (карточки services-card, табы рубрик, слайдер).
$services = tolstenko_get_blog_services_overrides();
if ($services !== null) {
    set_query_var('services_slider_data', [
        'title' => $services['title'],
        'text'  => $services['text'],
        'ids'   => $services['postIds'],
    ]);
    get_template_part('pages/sections/services-slider');
    set_query_var('services_slider_data', []);
}

get_template_part('pages/single-blog/sections/comments');
