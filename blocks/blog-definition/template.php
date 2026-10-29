<?php

/**
 * Статья: определение / термин.
 *
 * define — метка + термин — пояснение; card — заголовок + текст.
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$defaults = tolstenko_get_blog_content_defaults('blog_definition');

$value = static function (string $key) use ($attributes, $defaults): string {
    $own = trim((string) ($attributes[$key] ?? ''));

    return $own !== '' ? $own : trim((string) ($defaults[$key] ?? ''));
};

$mode = sanitize_key($value('mode'));

if ($mode !== 'card') :
    $kicker = $value('kicker') ?: 'Определение';
    $term   = $value('term');
    $suffix = preg_replace('/^[\s—\-–]+/u', '', $value('suffix'));

    if ($term === '' && $suffix === '') {
        return;
    }
?>
  <div class="single-blog__define single-blog__define--term">
    <p class="single-blog__define-kicker">
      <span class="single-blog__define-kicker-icon" aria-hidden="true"></span>
      <?= esc_html($kicker); ?>
    </p>
    <p class="single-blog__define-lead">
      <?php if ($term !== '') : ?>
        <strong class="single-blog__define-term"><?= esc_html($term); ?></strong>
      <?php endif; ?>
      <?php if ($suffix !== '') : ?>
        <span class="single-blog__define-fixed"><?= ($term !== '' ? ' — ' : '') . esc_html($suffix); ?></span>
      <?php endif; ?>
    </p>
  </div>
<?php
    return;
endif;

$title = $value('title');
$text  = $value('text');

if ($title === '' && $text === '') {
    return;
}
?>
<div class="single-blog__define single-blog__define--note">
  <?php if ($title !== '') : ?>
    <p class="single-blog__define-title"><?= esc_html($title); ?></p>
  <?php endif; ?>
  <?php if ($text !== '') : ?>
    <p class="single-blog__define-text"><?= esc_html($text); ?></p>
  <?php endif; ?>
</div>
