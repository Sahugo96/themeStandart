<?php

defined('ABSPATH') || exit;

/**
 * Секция «Ситуации, с которыми к нам приходят» (situations).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('situations')
 * (таб «Дефолты блоков → Ситуации»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('situations') : [];

$defaults = [
    'badge'        => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'items'        => is_array($admin['items'] ?? null) ? $admin['items'] : [],
];

$overrides = get_query_var('situations_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? array_values($data['items']) : [];

if (empty($items)) {
    return;
}

// Слайд = две карточки друг под другом.
$slides = array_chunk($items, 2);
?>
<section class="situations section">
  <div class="container">
    <div class="situations__top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="situations__badge"><?= $data['badge']; ?></span>
      <?php endif; ?>
      <h2 class="situations__title"><?= $data['title']; ?></h2>
    </div>

    <div class="fade-in-container situations__splide splide load-on-vissible--js"
      aria-label="<?= esc_attr(wp_strip_all_tags($data['title'])); ?>"
      data-module="./libs/splide.min.js,./modules/situationsSplideinit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="situations-container">
      <div class="splide__track">
        <div class="situations__splide-list splide__list">

          <?php foreach ($slides as $slide) : ?>
            <div class="situations__slide fade-in-element splide__slide">
              <?php foreach ($slide as $card) : ?>
                <article class="situations__card">
                  <div class="situations__card-head">
                    <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                      <circle cx="15" cy="15" r="15"/>
                      <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                    </svg>
                    <h3 class="situations__card-title"><?= $card['title'] ?? ''; ?></h3>
                  </div>
                  <p class="situations__card-text"><?= $card['text'] ?? ''; ?></p>
                </article>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>

        </div>
      </div>

      <div class="splide__bottom">
        <div class="splide__pagination"></div>
      </div>
    </div>
  </div>
</section>
