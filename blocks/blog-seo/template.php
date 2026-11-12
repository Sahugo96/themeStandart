<?php

/**
 * Статья: SEO / CTA — плашка с заголовком и кнопкой в теле статьи.
 *
 * Пустые поля — из «Настройки сайта → Блоки для статей → SEO / CTA».
 * Кнопка без ссылки открывает модальное окно (#modal).
 * Перенесено из tolstenko.marketing (template-parts/blocks/blog-seo.php).
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$defaults = tolstenko_get_blog_content_defaults('blog_seo');

$value = static function (string $key) use ($attributes, $defaults): string {
    $own = trim((string) ($attributes[$key] ?? ''));

    return $own !== '' ? $own : trim((string) ($defaults[$key] ?? ''));
};

$title    = $value('title');
$btn_text = $value('btn');
$btn_url  = $value('btn_url') ?: '#modal';

if ($title === '' && $btn_text === '') {
    return;
}
?>
<div class="single-blog__cta">
  <?php if ($title !== '') : ?>
    <p class="single-blog__cta-title"><?= tolstenko_kses_html($title); ?></p>
  <?php endif; ?>

  <?php if ($btn_text !== '') : ?>
    <a class="single-blog__cta-btn default-btn default-btn--brown" href="<?= esc_url($btn_url); ?>">
      <span><?= esc_html($btn_text); ?></span>
      <svg class="single-blog__cta-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6" /></svg>
    </a>
  <?php endif; ?>
</div>
