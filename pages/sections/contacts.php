<?php

defined('ABSPATH') || exit;

/**
 * Секция «Контакты» (contacts) — страница с шаблоном «Contacts page».
 * Перенесено из tolstenko.marketing (template-parts/blocks/contacts-page.php), вид — текущая тема.
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('contacts')
 * (таб «Дефолты блоков → Контакты»). Атрибуты блока my-theme/contacts имеют приоритет.
 *
 * Адреса — вкладки (при одном адресе вкладок нет). У адреса: карточка контактов
 * (иконка, заголовок, строки-ссылки) + кнопки «Позвонить» / «Telegram» (номер и ссылка —
 * «Контактные данные»), справа галерея фото офиса (Splide: фото + миниатюры).
 * Переключение вкладок и галереи — modules/contactsTabs.js.
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('contacts') : [];

$overrides = get_query_var('contacts_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$badge     = trim((string) ($data['badge'] ?? ''));
$title     = trim((string) ($data['title'] ?? ''));
$call_text = trim((string) ($data['call_text'] ?? ''));
$tg_text   = trim((string) ($data['tg_text'] ?? ''));
$addresses = theme_contacts_normalize_addresses($data['addresses'] ?? []);

if (!$addresses) {
    return;
}

$cd         = function_exists('tolstenko_get_contact_data') ? tolstenko_get_contact_data() : [];
$phone_href = trim((string) ($cd['phone_href'] ?? ''));
$telegram   = trim((string) ($cd['telegram'] ?? ''));

$uid      = wp_unique_id();
$has_tabs = count(array_filter($addresses, static function ($a) {
    return $a['address'] !== '';
})) > 1;
?>
<section class="contacts section load-on-vissible--js"
  data-contacts-tabs
  data-module="./libs/splide.min.js,./modules/contactsTabs.js"
  data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css">
  <div class="container">
    <?php if ($badge !== '' || $title !== '') : ?>
      <div class="contacts__top section-top">
        <?php if ($badge !== '') : ?>
          <span class="contacts__badge section-subtitle"><?= esc_html($badge); ?></span>
        <?php endif; ?>
        <?php if ($title !== '') : ?>
          <h2 class="contacts__title section-title"><?= tolstenko_kses_html($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($has_tabs) : ?>
      <div class="contacts__tabs filter filter--tabs filter--dark">
        <div class="filter__form" role="tablist">
          <?php foreach ($addresses as $index => $addr) : ?>
            <?php if ($addr['address'] === '') continue; ?>
            <button class="filter__link<?= $index === 0 ? ' active' : ''; ?>" type="button" role="tab" aria-selected="<?= $index === 0 ? 'true' : 'false'; ?>" data-tab-index="<?= (int) $index; ?>">
              <span class="filter__label"><?= esc_html($addr['address']); ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="contacts__panels">
      <?php foreach ($addresses as $index => $addr) :
        $images = [];
        foreach ($addr['gallery'] as $image_id) {
            $image = tolstenko_get_image_attrs($image_id, 'large');
            if ($image) {
                $images[] = $image;
            }
        }
      ?>
        <div class="contacts__panel<?= $images ? '' : ' contacts__panel--no-media'; ?>" data-tab-panel="<?= (int) $index; ?>"<?= $index === 0 ? '' : ' hidden'; ?>>
          <div class="contacts__info br-30">
            <?php if ($addr['items']) : ?>
              <ul class="contacts__items">
                <?php foreach ($addr['items'] as $item) :
                  $icon = $item['icon'] ? tolstenko_get_image_attrs($item['icon'], 'thumbnail') : null;
                ?>
                  <li class="contacts__item">
                    <?php if ($icon) : ?>
                      <span class="contacts__item-icon" aria-hidden="true"><img src="<?= esc_url($icon['url']); ?>" alt="" loading="lazy"></span>
                    <?php endif; ?>
                    <div class="contacts__item-body">
                      <?php if ($item['title'] !== '') : ?>
                        <div class="contacts__item-title"><?= esc_html($item['title']); ?></div>
                      <?php endif; ?>
                      <?php foreach ($item['links'] as $link) : ?>
                        <?php if ($link['text'] === '') continue; ?>
                        <?php if ($link['link'] !== '') : ?>
                          <a class="contacts__item-link" href="<?= esc_url($link['link'], ['http', 'https', 'tel', 'mailto']); ?>"<?= preg_match('#^https?://#i', $link['link']) ? ' target="_blank" rel="noopener"' : ''; ?>><?= esc_html($link['text']); ?></a>
                        <?php else : ?>
                          <span class="contacts__item-text"><?= esc_html($link['text']); ?></span>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

            <?php if (($call_text !== '' && $phone_href !== '') || ($tg_text !== '' && $telegram !== '')) : ?>
              <div class="contacts__actions">
                <?php if ($call_text !== '' && $phone_href !== '') : ?>
                  <a class="contacts__btn default-btn default-btn--brown" href="tel:<?= esc_attr($phone_href); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 0 1 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1l-2.3 2.2Z"/></svg>
                    <span><?= esc_html($call_text); ?></span>
                  </a>
                <?php endif; ?>
                <?php if ($tg_text !== '' && $telegram !== '') : ?>
                  <a class="contacts__btn default-btn default-btn--tg" href="<?= esc_url($telegram); ?>" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.4 4.1 2.9 11.2c-1.3.5-1.2 1.2-.2 1.5l4.7 1.5 1.8 5.6c.2.6.1.9.8.9.5 0 .7-.2 1-.5l2.3-2.2 4.8 3.5c.9.5 1.5.2 1.7-.8l3.1-14.7c.3-1.3-.5-1.9-1.5-1.4ZM8.9 14.5l9.4-5.9c.4-.3.9-.1.5.2l-8 7.3-.3 3.4-1.6-5Z"/></svg>
                    <span><?= esc_html($tg_text); ?></span>
                  </a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>

          <?php if ($images) : ?>
            <div class="contacts__gallery" data-contacts-gallery>
              <div class="contacts__gallery-main splide" aria-label="<?= esc_attr($addr['address'] !== '' ? $addr['address'] : 'Фото офиса'); ?>">
                <div class="splide__track">
                  <ul class="splide__list">
                    <?php foreach ($images as $image) : ?>
                      <li class="contacts__gallery-slide splide__slide br-30">
                        <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt'] ?: $addr['address']); ?>" loading="lazy" decoding="async">
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>

              <?php if (count($images) > 1) : ?>
                <div class="contacts__gallery-thumbs splide" aria-label="Миниатюры">
                  <div class="splide__track">
                    <ul class="splide__list">
                      <?php foreach ($images as $image) : ?>
                        <li class="contacts__gallery-thumb splide__slide">
                          <img src="<?= esc_url($image['url']); ?>" alt="" loading="lazy" decoding="async">
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
