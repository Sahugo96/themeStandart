<?php

defined('ABSPATH') || exit;

/**
 * Секция «Банки-партнёры» (banks).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('banks')
 * (таб «Дефолты блоков → Секции лендинга → Банки-партнёры»).
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('banks') : [];

$defaults = [
    'badge'        => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'lead'         => $admin['lead'] ?? '',
    'items'        => is_array($admin['items'] ?? null) ? $admin['items'] : [],
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_url'      => $admin['btn_url'] ?? '',
];

$overrides = get_query_var('banks_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? array_values($data['items']) : [];

if (empty($items)) {
    return;
}

$lead     = theme_section_text_html($data['lead'] ?? '');
$btn_text = trim((string) ($data['btn_text'] ?? ''));
$btn_url  = trim((string) ($data['btn_url'] ?? ''));
?>
<section class="banks section section--white">
  <div class="container">
    <div class="banks__top section-top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="banks__badge section-subtitle"><?= $data['badge']; ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="banks__title section-title"><?= $data['title']; ?></h2>
      <?php endif; ?>

      <?php if ($lead !== '') : ?>
        <div class="banks__lead section-text"><?= $lead; ?></div>
      <?php endif; ?>
    </div>

    <div class="fade-in-container banks__splide splide load-on-vissible--js"
      aria-label="<?= esc_attr(wp_strip_all_tags($data['title'])); ?>"
      data-module="./libs/splide.min.js,./modules/banksSplideInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="banks-container">

      <div class="banks__stage">
        <div class="splide__track">
          <div class="banks__splide-list splide__list">

            <?php foreach ($items as $item) :
              $item = is_array($item) ? $item : [];
              $logo = tolstenko_contact_get_image_attrs($item['logo'] ?? null);
              $type_text = trim((string) ($item['type_text'] ?? ''));
              $link_text = trim((string) ($item['link_text'] ?? ''));
              $link_url = trim((string) ($item['link_url'] ?? ''));
              $fact_1_label = trim((string) ($item['fact_1_label'] ?? ''));
              $fact_1_value = trim((string) ($item['fact_1_value'] ?? ''));
              $fact_2_label = trim((string) ($item['fact_2_label'] ?? ''));
              $fact_2_value = trim((string) ($item['fact_2_value'] ?? ''));
            ?>
              <article class="banks__card br-20 fade-in-element splide__slide">
                <?php if (trim((string) ($item['title'] ?? '')) !== '') : ?>
                  <h3 class="banks__card-title"><?= $item['title']; ?></h3>
                <?php endif; ?>

                <?php if ($logo['url'] !== '') : ?>
                  <div class="banks__logo">
                    <img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" loading="lazy">
                  </div>
                <?php endif; ?>

                <?php if ($type_text !== '') : ?>
                  <div class="banks__type br-20">
                    <svg class="banks__check" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10"/><path d="m5.8 10.3 2.7 2.7 5.2-5.6"/></svg>
                    <span class="banks__type-text tag-10-10"><?= esc_html($type_text); ?></span>
                  </div>
                <?php endif; ?>

                <?php if ($fact_1_label !== '' || $fact_2_label !== '') : ?>
                  <ul class="banks__facts br-20">
                    <?php if ($fact_1_label !== '' || $fact_1_value !== '') : ?>
                      <li class="banks__fact">
                        <span class="banks__fact-label"><?= esc_html($fact_1_label); ?></span>
                        <span class="banks__fact-value"><?= esc_html($fact_1_value); ?></span>
                      </li>
                    <?php endif; ?>
                    <?php if ($fact_2_label !== '' || $fact_2_value !== '') : ?>
                      <li class="banks__fact">
                        <span class="banks__fact-label"><?= esc_html($fact_2_label); ?></span>
                        <span class="banks__fact-value"><?= esc_html($fact_2_value); ?></span>
                      </li>
                    <?php endif; ?>
                  </ul>
                <?php endif; ?>

                <?php if ($link_text !== '') : ?>
                  <a class="banks__link" href="<?= esc_url($link_url !== '' ? $link_url : '#modal'); ?>">
                    <span><?= esc_html($link_text); ?></span>
                    <svg class="banks__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
                  </a>
                <?php endif; ?>
              </article>
            <?php endforeach; ?>

          </div>
        </div>
      </div>

      <div class="splide__arrows splide__arrows--ltr">
        <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Предыдущий слайд">
          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
        <button class="splide__arrow splide__arrow--next" type="button" aria-label="Следующий слайд">
          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>

      <div class="splide__bottom">
        <div class="splide__pagination"></div>
      </div>
    </div>

    <?php if ($btn_text !== '') : ?>
      <div class="banks__foot">
        <a class="banks__btn default-btn default-btn--brown" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
          <span><?= esc_html($btn_text); ?></span>
          <svg class="banks__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4 12h16M14 6l6 6-6 6"/>
          </svg>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>