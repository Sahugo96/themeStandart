<?php
/**
 * «Страница документа» — страница (page) с шаблоном page-document.php, устроенная как статья:
 * редактор заполняет только тело, шапка/автор/FAQ/слайдеры — те же группы мета-полей,
 * что у статьи (метабоксы inc/blog/*), комментарии — та же очередь CF7.
 * Между FAQ и «Похожими статьями» — секция «Это ещё не конец» (comments-cta).
 */

defined('ABSPATH') || exit;

/**
 * Страница с шаблоном «Страница документа».
 *
 * @param int|WP_Post|null $post Post.
 */
function theme_is_document_page($post = null): bool
{
    $post = get_post($post);

    return $post instanceof WP_Post
        && $post->post_type === 'page'
        && get_page_template_slug($post) === 'page-document.php';
}

/**
 * Запись, устроенная как статья: статья (blog) или страница документа.
 *
 * @param int|WP_Post|null $post Post.
 */
function theme_is_article_like($post = null): bool
{
    $post = get_post($post);

    return $post instanceof WP_Post && ($post->post_type === 'blog' || theme_is_document_page($post));
}

/**
 * Метабоксы статьи на странице документа (те же поля и рендер, что у статьи).
 * Появляются после выбора шаблона и сохранения страницы.
 */
add_action('add_meta_boxes_page', 'theme_document_page_add_metaboxes');
function theme_document_page_add_metaboxes($post): void
{
    if (!theme_is_document_page($post)) {
        return;
    }

    $boxes = [
        ['tolstenko_blog_article_fields', 'Документ: шапка, автор, комментарии', 'tolstenko_blog_article_render_metabox', 'high'],
        ['tolstenko_blog_faq', 'FAQ документа', 'tolstenko_blog_faq_render_metabox', 'default'],
        ['tolstenko_blog_sliders', 'Слайдеры под документом', 'tolstenko_blog_sliders_render_metabox', 'default'],
    ];

    foreach ($boxes as [$id, $title, $callback, $priority]) {
        if (function_exists($callback)) {
            add_meta_box($id, $title, $callback, 'page', 'normal', $priority);
        }
    }
}

/**
 * Сохранение — теми же функциями, что у статьи (они сами проверяют nonce и права).
 */
add_action('save_post_page', 'theme_document_page_save_metaboxes', 10, 2);
function theme_document_page_save_metaboxes($post_id, $post): void
{
    if (!theme_is_document_page($post)) {
        return;
    }

    foreach (['tolstenko_blog_article_save_metabox', 'tolstenko_blog_faq_save_metabox', 'tolstenko_blog_sliders_save_metabox'] as $save) {
        if (function_exists($save)) {
            $save($post_id, $post);
        }
    }
}
