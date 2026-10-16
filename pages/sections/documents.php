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
    'text'     => $admin['text'] ?? '',
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
<section class="documents section">
  <div class="container">
    <div class="documents__inner br-30">
      <div class="documents__top section-top">
        <?php if (trim((string) $data['subtitle']) !== '') : ?>
          <span class="documents__badge section-subtitle"><?= $data['subtitle']; ?></span>
        <?php endif; ?>

        <?php if (trim((string) $data['title']) !== '') : ?>
          <h2 class="documents__title h2"><?= $data['title']; ?></h2>
        <?php endif; ?>

        <?php if (trim((string) $data['text']) !== '') : ?>
          <p class="documents__text paragraph-15-15"><?= $data['text']; ?></p>
        <?php endif; ?>
      </div>

      <?php if (!empty($items)) : ?>
        <div class="documents__splide splide load-on-vissible--js"
          aria-label="<?= esc_attr(wp_strip_all_tags($data['title'])); ?>"
          data-module="./libs/splide.min.js,./modules/documentsSplideInit.js,./modules/documentsFancybox.js"
          data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css,<?= THEME_PATH; ?>/assets/css/libs/fancybox.css">

          <div class="splide__track">

            <div class="documents__list splide__list">
              <?php foreach ($items as $item) :
                $image = tolstenko_contact_get_image_attrs($item['image'] ?? null);
              ?>
                <div class="documents__list-item splide__slide">
                  <div class="documents__list-image">
                    <img src="<?= $image['url']; ?>" alt="<?= esc_attr($item['title'] ?? ''); ?>" data-fancybox="documents">
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="splide__bottom">
            <ul class="splide__pagination"></ul>

            <div class="splide__arrows splide__arrows--ltr">
              <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide">
                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
                </svg>
              </button>

              <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide">
                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
