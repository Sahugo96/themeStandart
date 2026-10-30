<?php

/**
 * Статья: SEO / CTA плашка с кнопкой.
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$defaults = tolstenko_get_blog_content_defaults('blog_seo');
$title    = trim((string) ($attributes['title'] ?? '')) ?: trim((string) ($defaults['title'] ?? ''));
$btn_text = trim((string) ($attributes['btn'] ?? '')) ?: trim((string) ($defaults['btn'] ?? ''));
$btn_url  = trim((string) ($attributes['btn_url'] ?? '')) ?: trim((string) ($defaults['btn_url'] ?? ''));

if ($title === '' && $btn_text === '') {
    return;
}
?>
<div class="article-cta article-cta--seo">
  <?php if ($title !== '') : ?>
    <div class="article-cta__content">
      <p class="article-cta__title"><?= tolstenko_kses_html($title); ?></p>
    </div>
  <?php endif; ?>

  <?php if ($btn_text !== '') : ?>
    <a class="article-cta__btn default-btn" href="<?= esc_url($btn_url ?: '#modal'); ?>"><?= esc_html($btn_text); ?></a>
  <?php endif; ?>
</div>
