<?php

defined('ABSPATH') || exit;

/**
 * Секция «SEO-наполнение» (seo-section).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('seo_section')
 * (таб «Дефолты блоков → SEO-наполнение»). Атрибуты блока имеют приоритет.
 *
 * Содержимое — строки разных видов (текст, фото + текст, две колонки, галерея).
 * Панель свёрнута по высоте; «Читать далее» раскрывает её (modules/seoSection.js),
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
$more_text = trim((string) ($data['more_text'] ?? '')) ?: 'Читать далее';

if (!$rows && $title === '') {
    return;
}

$gallery_group = 'seo-gallery-' . wp_unique_id();

$row_title = static function (array $row): void {
    if ($row['title'] !== '') {
        echo '<h3 class="seo-section__row-title">' . esc_html($row['title']) . '</h3>';
    }
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

    <?php if ($rows) : ?>
      <div class="seo-section__panel br-30 load-on-vissible--js"
        data-module="./modules/seoSection.js"
        data-css="<?= THEME_PATH; ?>/assets/css/libs/fancybox.css">
        <div class="seo-section__body" data-seo-body>
          <?php foreach ($rows as $row) : ?>
            <?php if ($row['layout'] === 'image_text' || $row['layout'] === 'text_image') :
              $image = $row['image'] ? tolstenko_get_image_attrs($row['image'], 'large') : null;
            ?>
              <div class="seo-section__row seo-section__row--media<?= $row['layout'] === 'text_image' ? ' seo-section__row--reverse' : ''; ?>">
                <?php if ($image) : ?>
                  <div class="seo-section__media br-20">
                    <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt'] ?: $row['title']); ?>" loading="lazy" decoding="async">
                  </div>
                <?php endif; ?>

                <div class="seo-section__content">
                  <?php $row_title($row); ?>

                  <?php if (trim(wp_strip_all_tags($row['text'])) !== '') : ?>
                    <div class="seo-section__text redactor"><?= tolstenko_kses_redactor($row['text']); ?></div>
                  <?php endif; ?>

                  <?php if ($row['btn_text'] !== '') : ?>
                    <a class="seo-section__btn default-btn default-btn--brown" href="<?= esc_url($row['btn_url'] ?: '#modal'); ?>"><?= esc_html($row['btn_text']); ?></a>
                  <?php endif; ?>
                </div>
              </div>

            <?php elseif ($row['layout'] === 'two_columns') : ?>
              <div class="seo-section__row seo-section__row--columns">
                <?php $row_title($row); ?>

                <div class="seo-section__columns">
                  <?php foreach ([$row['text'], $row['text_2']] as $column) : ?>
                    <?php if (trim(wp_strip_all_tags($column)) !== '') : ?>
                      <div class="seo-section__text redactor"><?= tolstenko_kses_redactor($column); ?></div>
                    <?php endif; ?>
                  <?php endforeach; ?>
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
              </div>

            <?php elseif ($row['layout'] === 'gallery') : ?>
              <div class="seo-section__row seo-section__row--gallery">
                <?php $row_title($row); ?>

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
              </div>

            <?php else : ?>
              <div class="seo-section__row seo-section__row--text">
                <?php $row_title($row); ?>

                <?php if (trim(wp_strip_all_tags($row['text'])) !== '') : ?>
                  <div class="seo-section__text redactor"><?= tolstenko_kses_redactor($row['text']); ?></div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <div class="seo-section__foot">
          <button type="button" class="seo-section__more default-btn default-btn--transparent" data-seo-more data-less="Свернуть" aria-expanded="false">
            <span data-seo-more-label><?= esc_html($more_text); ?></span>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
          </button>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
