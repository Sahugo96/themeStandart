<?php

defined('ABSPATH') || exit;

/**
 * Секция «Документы и лицензии» (documents).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('documents')
 * (таб «Дефолты блоков → Документы»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('documents') : [];

$defaults = [
    'subtitle' => $admin['subtitle'] ?? '',
    'title'    => $admin['title'] ?? '',
    'items'    => is_array($admin['items'] ?? null) ? $admin['items'] : [],
];

$overrides = get_query_var('documents_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? $data['items'] : [];

if (empty($items) && trim((string) $data['title']) === '') {
    return;
}
?>
<section class="documents section section--white">
  <div class="container">
      <div class="documents__top section-top">
        <?php if (trim((string) $data['subtitle']) !== '') : ?>
          <span class="documents__badge section-subtitle"><?= $data['subtitle']; ?></span>
        <?php endif; ?>

        <?php if (trim((string) $data['title']) !== '') : ?>
          <h2 class="documents__title section-title"><?= $data['title']; ?></h2>
        <?php endif; ?>
      </div>

      <?php if (!empty($items)) : ?>
        <div class="documents__splide splide load-on-vissible--js"
          aria-label="<?= esc_attr(wp_strip_all_tags($data['title'])); ?>"
          data-module="./libs/splide.min.js,./modules/documentsSplideInit.js,./modules/documentsFancybox.js"
          data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css,<?= THEME_PATH; ?>/assets/css/libs/fancybox.css"
          id="documents-container">

          <div class="splide__track">
            <div class="documents__list splide__list">

              <?php foreach ($items as $item) :
                $item = is_array($item) ? $item : [];
                $image = tolstenko_contact_get_image_attrs($item['image'] ?? null);
                $tags_raw = preg_split('/\r\n|\r|\n/', (string) ($item['attributes'] ?? ''));
                $tags = array_values(array_filter(array_map('trim', (array) $tags_raw), static function ($tag) {
                    return $tag !== '';
                }));
              ?>
                <article class="documents__item fade-in-element splide__slide">
                  <?php if ($image['url'] !== '') : ?>
                    <div class="documents__item-image" data-fancybox="documents" data-src="<?= $image['url']; ?>">
                      <img src="<?= $image['url']; ?>" alt="<?= esc_attr($item['title'] ?? ''); ?>" loading="lazy">
                    </div>
                  <?php endif; ?>

                  <?php if (trim((string) ($item['title'] ?? '')) !== '') : ?>
                    <h3 class="documents__item-title"><?= $item['title']; ?></h3>
                  <?php endif; ?>

                  <?php if (trim((string) ($item['text'] ?? '')) !== '') : ?>
                    <p class="documents__item-text"><?= $item['text']; ?></p>
                  <?php endif; ?>

                  <?php if (!empty($tags)) : ?>
                    <ul class="documents__item-tags">
                      <?php foreach ($tags as $tag) : ?>
                        <li class="documents__item-tag"><?= esc_html($tag); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </article>
              <?php endforeach; ?>

            </div>
          </div>

          <div class="splide__bottom">
            <div class="splide__pagination"></div>
          </div>
        </div>
      <?php endif; ?>
  </div>
</section>
