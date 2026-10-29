<?php

/**
 * Статья: крупное фото.
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$defaults = tolstenko_get_blog_content_defaults('blog_large_img');
$image_id = tolstenko_block_image_id($attributes['image'] ?? 0) ?: (int) ($defaults['image'] ?? 0);
$image    = tolstenko_get_image_attrs($image_id);

if (!$image) {
    return;
}
?>
<img
  class="single-blog__content-img"
  src="<?= esc_url($image['url']); ?>"
  <?php if ($image['srcset'] !== '') : ?>srcset="<?= esc_attr($image['srcset']); ?>" sizes="<?= esc_attr($image['sizes']); ?>"<?php endif; ?>
  alt="<?= esc_attr($image['alt']); ?>"
  loading="lazy"
  decoding="async"
>
