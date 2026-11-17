<?php

defined('ABSPATH') || exit;

/**
 * Секция «Это ещё не конец» (comments-cta) — плашка-приглашение к комментариям.
 * Выводится на странице документа (page-document.php) между FAQ и «Похожими статьями»;
 * может стоять и блоком my-theme/comments-cta.
 *
 * Дефолты — tolstenko_get_block_defaults('comments_cta') (таб «Секции лендинга →
 * Это ещё не конец»), атрибуты блока имеют приоритет. Пустая ссылка кнопки — #comments.
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('comments_cta') : [];

$overrides = get_query_var('comments_cta_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$title    = trim((string) ($data['title'] ?? ''));
$text     = trim((string) ($data['text'] ?? ''));
$btn_text = trim((string) ($data['btn_text'] ?? ''));
$btn_url  = trim((string) ($data['btn_url'] ?? '')) ?: '#comments';

if ($title === '' && $text === '' && $btn_text === '') {
    return;
}
?>
<section class="comments-cta section">
  <div class="container">
    <div class="comments-cta__card br-30">
      <div class="comments-cta__head">
        <span class="comments-cta__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><path d="M12 3c5 0 9 3.6 9 8s-4 8-9 8c-1.1 0-2.2-.2-3.2-.5L4 20l1.3-3.7C3.9 14.9 3 13 3 11c0-4.4 4-8 9-8Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="8.5" cy="11" r="1.1"/><circle cx="12" cy="11" r="1.1"/><circle cx="15.5" cy="11" r="1.1"/></svg>
        </span>
        <?php if ($title !== '') : ?>
          <h2 class="comments-cta__title"><?= tolstenko_kses_html($title); ?></h2>
        <?php endif; ?>
      </div>

      <?php if ($text !== '') : ?>
        <p class="comments-cta__text"><?= tolstenko_kses_html($text); ?></p>
      <?php endif; ?>

      <div class="comments-cta__decor" aria-hidden="true">
        <span class="comments-cta__avatar comments-cta__avatar--1"></span>
        <span class="comments-cta__bubble"><i></i><i></i></span>
        <span class="comments-cta__bubble"><i></i><i></i></span>
        <span class="comments-cta__avatar comments-cta__avatar--2"></span>
      </div>

      <?php if ($btn_text !== '') : ?>
        <a class="comments-cta__btn default-btn default-btn--brown" href="<?= esc_url($btn_url); ?>">
          <span><?= esc_html($btn_text); ?></span>
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>
