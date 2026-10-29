<?php

/**
 * Статья: видео — превью + iframe (Rutube / YouTube / Vimeo) или mp4.
 * iframe получает src только по клику (modules/blogVideo.js).
 *
 * @var array $attributes Block attributes.
 */

defined('ABSPATH') || exit;

$defaults   = tolstenko_get_blog_content_defaults('blog_video');
$preview_id = tolstenko_block_image_id($attributes['preview'] ?? 0) ?: (int) ($defaults['preview'] ?? 0);
$video_url  = trim((string) ($attributes['url'] ?? '')) ?: trim((string) ($defaults['url'] ?? ''));
$iframe     = trim((string) ($attributes['iframe'] ?? '')) ?: trim((string) ($defaults['iframe'] ?? ''));

$embed_src = '';
$file_url  = '';

if ($iframe !== '' && preg_match('#src=(["\'])([^"\']+)\1#i', $iframe, $m)) {
    $embed_src = html_entity_decode($m[2], ENT_QUOTES, 'UTF-8');
}

if ($embed_src === '' && $video_url !== '') {
    $embed_src = tolstenko_blog_video_to_embed_url($video_url);
}

// Прямая ссылка на файл (в том числе CDN без расширения).
if ($embed_src === '' && preg_match('#^https?://#i', $video_url)) {
    $file_url = $video_url;
}

if ($embed_src === '' && $file_url === '') {
    return;
}

$preview = tolstenko_get_image_attrs($preview_id, 'large');
$preview_url = $preview ? $preview['url'] : '';

if ($preview_url === '' && $embed_src !== '') {
    $preview_url = theme_get_video_embed_poster($embed_src);
}
?>
<div class="single-blog__content-video video video--blog load-on-vissible--js" data-blog-video data-module="./modules/blogVideo.js">
  <?php if ($embed_src !== '') : ?>
    <div class="video__embed" hidden>
      <iframe
        class="video__iframe"
        data-src="<?= esc_url($embed_src); ?>"
        src="about:blank"
        title="Видео"
        allow="autoplay; fullscreen; picture-in-picture; encrypted-media; clipboard-write"
        allowfullscreen
        referrerpolicy="strict-origin-when-cross-origin"
      ></iframe>
    </div>
  <?php else : ?>
    <video class="video__iframe" src="<?= esc_url($file_url); ?>" playsinline controls preload="metadata" hidden></video>
  <?php endif; ?>

  <?php if ($preview_url !== '') : ?>
    <img
      class="video__img"
      src="<?= esc_url($preview_url); ?>"
      <?php if ($preview && $preview['srcset'] !== '') : ?>srcset="<?= esc_attr($preview['srcset']); ?>" sizes="<?= esc_attr($preview['sizes']); ?>"<?php endif; ?>
      alt="<?= esc_attr($preview && $preview['alt'] !== '' ? $preview['alt'] : 'Превью видео'); ?>"
      loading="lazy"
      decoding="async"
    >
  <?php endif; ?>

  <button class="video__btn" type="button" aria-label="Смотреть видео">
    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M3.82263 0.0285661C3.40033 0.0281482 2.98488 0.135329 2.61549 0.339995C2.23667 0.533082 1.91754 0.82562 1.6923 1.18625C1.46706 1.54688 1.34421 1.96201 1.33691 2.38714V17.64C1.34421 18.0651 1.46706 18.4803 1.6923 18.8409C1.91754 19.2015 2.23667 19.4941 2.61549 19.6871C2.99158 19.896 3.41545 20.0038 3.84565 19.9998C4.27584 19.9957 4.69764 19.8802 5.06977 19.6643L17.3983 12.0386C17.7788 11.8468 18.0985 11.5532 18.3219 11.1904C18.5452 10.8276 18.6634 10.4099 18.6633 9.98384C18.6631 9.5578 18.5446 9.14017 18.321 8.77753C18.0974 8.41488 17.7775 8.12146 17.3969 7.92999L5.06834 0.361423L5.04549 0.348566C4.67225 0.138309 4.25101 0.0280782 3.82263 0.0285661Z" />
    </svg>
  </button>
</div>
