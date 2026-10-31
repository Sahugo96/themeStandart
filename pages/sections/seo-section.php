<?php

defined('ABSPATH') || exit;

/**
 * Секция «SEO-наполнение» (seo-section).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('seo_section')
 * (таб «Дефолты блоков → SEO-наполнение»). Атрибуты блока имеют приоритет.
 *
 * Содержимое — строки разных видов (текст, фото + текст, две колонки, галерея).
 * Карточка: первая строка видна сразу (теги, заголовок, текст, фото справа),
 * «Читать полностью» раскрывает остальные строки (modules/seoSection.js);
 * фото галереи открываются в Fancybox.
 *
 * Перенесено из tolstenko.marketing («SEO продвижение»).
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('seo_section') : [];

$overrides = get_query_var('seo_section_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$rows      = theme_seo_section_normalize_rows($data['rows'] ?? []);
$badge     = trim((string) ($data['badge'] ?? ''));
$title     = trim((string) ($data['title'] ?? ''));
$more_text = trim((string) ($data['more_text'] ?? '')) ?: 'Читать полностью';

if (!$rows && $title === '') {
    return;
}

$section_uid   = wp_unique_id();
$rest_id       = 'seo-rest-' . $section_uid;
$gallery_group = 'seo-gallery-' . $section_uid;

// Первая строка видна сразу, остальные — по кнопке (modules/seoSection.js).
$lead_row  = $rows ? array_shift($rows) : null;
$rest_rows = $rows;

$more_button = '';
if ($rest_rows) {
    $more_button = '<button type="button" class="seo-section__more default-btn default-btn--transparent" data-seo-more data-less="Свернуть" aria-expanded="false" aria-controls="' . esc_attr($rest_id) . '">'
        . '<span data-seo-more-label>' . esc_html($more_text) . '</span>'
        . '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>'
        . '</button>';
}

/**
 * Строка содержимого. $after — HTML в конце текстовой колонки (кнопка «Читать полностью»).
 */
$render_row = static function (array $row, string $after = '') use ($gallery_group): void {
    $head = static function () use ($row): void {
        if ($row['tags']) {
            echo '<ul class="seo-section__tags">';
            foreach ($row['tags'] as $tag) {
                echo '<li class="seo-section__tag">' . esc_html($tag) . '</li>';
            }
            echo '</ul>';
        }
        if ($row['title'] !== '') {
            echo '<h3 class="seo-section__row-title">' . esc_html($row['title']) . '</h3>';
        }
    };
    $text = static function (string $html): void {
        if (trim(wp_strip_all_tags($html)) !== '') {
            echo '<div class="seo-section__text redactor">' . tolstenko_kses_redactor($html) . '</div>';
        }
    };

    if ($row['layout'] === 'image_text' || $row['layout'] === 'text_image') {
        $image = $row['image'] ? tolstenko_get_image_attrs($row['image'], 'large') : null;
        $classes = 'seo-section__row seo-section__row--media';
        $classes .= $row['layout'] === 'image_text' ? ' seo-section__row--reverse' : '';
        $classes .= $image ? '' : ' seo-section__row--no-media';
        ?>
        <div class="<?= esc_attr($classes); ?>">
          <div class="seo-section__content">
            <?php $head(); $text($row['text']); ?>
            <?php if ($row['btn_text'] !== '') : ?>
              <a class="seo-section__btn default-btn default-btn--brown" href="<?= esc_url($row['btn_url'] ?: '#modal'); ?>"><?= esc_html($row['btn_text']); ?></a>
            <?php endif; ?>
            <?php if ($after !== '') : ?>
              <div class="seo-section__foot"><?= $after; ?></div>
            <?php endif; ?>
          </div>
          <?php if ($image) : ?>
            <div class="seo-section__media">
              <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt'] ?: $row['title']); ?>" loading="lazy" decoding="async">
            </div>
          <?php endif; ?>
        </div>
        <?php
        return;
    }

    ?>
    <div class="seo-section__row seo-section__row--<?= esc_attr(str_replace('_', '-', $row['layout'])); ?>">
      <?php $head(); ?>

      <?php if ($row['layout'] === 'two_columns') : ?>
        <div class="seo-section__columns">
          <?php $text($row['text']); $text($row['text_2']); ?>
        </div>
        <?php if ($row['items']) : ?>
          <ul class="seo-section__items">
            <?php foreach ($row['items'] as $item) : ?>
              <li class="seo-section__item br-20">
                <?php if ($item['title'] !== '') : ?>
                  <div class="seo-section__item-title"><?= esc_html($item['title']); ?></div>
                <?php endif; ?>
                <?php if (trim(wp_strip_all_tags($item['text'])) !== '') : ?>
                  <div class="seo-section__item-text redactor"><?= tolstenko_kses_redactor($item['text']); ?></div>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

      <?php elseif ($row['layout'] === 'gallery') : ?>
        <div class="seo-section__gallery">
          <?php foreach ($row['gallery'] as $image_id) :
            $thumb = tolstenko_get_image_attrs($image_id, 'medium_large');
            if (!$thumb) {
                continue;
            }
            $full = (string) wp_get_attachment_image_url($image_id, 'full');
          ?>
            <a class="seo-section__gallery-item br-20" href="<?= esc_url($full ?: $thumb['url']); ?>" data-fancybox="<?= esc_attr($gallery_group); ?>"<?= $thumb['alt'] !== '' ? ' data-caption="' . esc_attr($thumb['alt']) . '"' : ''; ?>>
              <img src="<?= esc_url($thumb['url']); ?>" alt="<?= esc_attr($thumb['alt']); ?>" loading="lazy" decoding="async">
            </a>
          <?php endforeach; ?>
        </div>

      <?php else : ?>
        <?php $text($row['text']); ?>
      <?php endif; ?>

      <?php if ($after !== '') : ?>
        <div class="seo-section__foot"><?= $after; ?></div>
      <?php endif; ?>
    </div>
    <?php
};
?>
<section class="seo-section section">
  <div class="container">
    <?php if ($badge !== '' || $title !== '') : ?>
      <div class="seo-section__top section-top">
        <?php if ($badge !== '') : ?>
          <span class="seo-section__badge section-subtitle"><?= esc_html($badge); ?></span>
        <?php endif; ?>

        <?php if ($title !== '') : ?>
          <h2 class="seo-section__title section-title"><?= wp_kses_post($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($lead_row) : ?>
      <div class="seo-section__panel br-30 load-on-vissible--js"
        data-module="./modules/seoSection.js"
        data-css="<?= THEME_PATH; ?>/assets/css/libs/fancybox.css">
        <?php $render_row($lead_row, $more_button); ?>

        <?php if ($rest_rows) : ?>
          <div class="seo-section__rest" id="<?= esc_attr($rest_id); ?>" data-seo-rest>
            <?php foreach ($rest_rows as $row) : ?>
              <?php $render_row($row); ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
