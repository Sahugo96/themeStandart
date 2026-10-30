<?php

/**
 * Статья: цитата с автором.
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$defaults = tolstenko_get_blog_content_defaults('blog_blockquote');

$value = static function (string $key) use ($attributes, $defaults): string {
    $own = trim((string) ($attributes[$key] ?? ''));

    return $own !== '' ? $own : trim((string) ($defaults[$key] ?? ''));
};

$text   = $value('text');
$cite   = $value('link');
$author = $value('author');
$under  = $value('author_under');
$btn_t  = $value('btn_text');
$btn_u  = $value('btn_url') ?: '#modal';
$img_id = tolstenko_block_image_id($attributes['image'] ?? 0) ?: (int) ($defaults['image'] ?? 0);
$show   = array_key_exists('show_author', $attributes)
    ? !empty($attributes['show_author'])
    : !empty($defaults['show_author']);

if (trim(wp_strip_all_tags($text)) === '') {
    return;
}

$image = $img_id ? tolstenko_get_image_attrs($img_id, 'medium') : null;

$quote_svg = '<svg viewBox="0 0 35 30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M22.3571 29.7308C29.866 24.7733 34.0377 19.0027 34.872 12.4193C36.1713 2.17096 27.2564 -2.84506 22.739 1.66146C18.2217 6.16798 20.9291 11.8893 24.1999 13.4537C27.4708 15.018 29.4711 14.4726 29.1221 16.5629C28.7731 18.6532 24.1202 24.4462 20.0316 27.1444C19.887 27.2712 19.7947 27.4499 19.7736 27.6441C19.7524 27.8383 19.8041 28.0336 19.9179 28.1901L20.9291 29.5422C21.3679 30.1286 21.7887 30.106 22.3571 29.7319M2.58657 29.7308C10.0955 24.7733 14.2671 19.0027 15.1015 12.4193C16.4018 2.17096 7.48683 -2.84506 2.96951 1.66146C-1.54782 6.16798 1.15958 11.8893 4.4314 13.4537C7.70322 15.018 9.70261 14.4726 9.35359 16.5629C9.00457 18.6532 4.35063 24.4462 0.2621 27.1444C0.117573 27.2713 0.0254824 27.4501 0.00455495 27.6443C-0.0163763 27.8385 0.0354196 28.0337 0.149414 28.1901L1.15958 29.5422C1.59835 30.1286 2.01917 30.106 2.58657 29.7319"/></svg>';
?>
<blockquote class="single-blog__content-block single-blog__content-block--blockquote br-30 blockquote"<?= $cite !== '' ? ' cite="' . esc_url($cite) . '"' : ''; ?>>
  <div class="blockquote__content">
    <?= $quote_svg; ?>
    <p class="paragraph-15-25"><?= tolstenko_kses_html($text); ?></p>
    <?= $quote_svg; ?>
  </div>

  <?php if ($show && ($image || $author !== '' || $under !== '' || $btn_t !== '')) : ?>
    <div class="blockquote__right">
      <?php if ($image) : ?>
        <img
          class="blockquote__right-img"
          src="<?= esc_url($image['url']); ?>"
          <?php if ($image['srcset'] !== '') : ?>srcset="<?= esc_attr($image['srcset']); ?>" sizes="<?= esc_attr($image['sizes']); ?>"<?php endif; ?>
          alt="<?= esc_attr($author); ?>"
          loading="lazy"
          decoding="async"
        >
      <?php endif; ?>

      <?php if ($author !== '' || $under !== '') : ?>
        <div class="blockquote__right-wrapper">
          <?php if ($author !== '') : ?>
            <cite class="line-caps-bold-16-15"><?= esc_html($author); ?></cite>
          <?php endif; ?>
          <?php if ($under !== '') : ?>
            <span><?= esc_html($under); ?></span>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if ($btn_t !== '') : ?>
        <a class="blockquote__right-btn default-btn" href="<?= esc_url($btn_u); ?>"><?= esc_html($btn_t); ?></a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</blockquote>
