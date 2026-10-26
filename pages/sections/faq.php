<?php
$faq_data = get_query_var('faq_data');

if (is_array($faq_data) && $faq_data) {
  $badge = $faq_data['badge'] ?? '';
  $title = $faq_data['title'] ?? '';
  $items = $faq_data['items'] ?? [];
  $form_title = $faq_data['form_title'] ?? '';
  $form_text = $faq_data['form_text'] ?? '';
  $teammate_id = (int) ($faq_data['teammate_id'] ?? 0);
} else {
  // Дефолты из админки: «Дефолты блоков → FAQ».
  $defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('faq') : [];

  $badge = $defaults['badge'] ?? '';
  $title = $defaults['title'] ?? '';
  $items = $defaults['items'] ?? [];
  $form_title = $defaults['form_title'] ?? '';
  $form_text = $defaults['form_text'] ?? '';
  $teammate_id = (int) ($defaults['teammate_id'] ?? 0);
}

$items = is_array($items ?? null) ? $items : [];

if (empty($items) && trim((string) $badge) === '' && trim((string) $title) === '') {
  return;
}

$cd = tolstenko_get_contact_data();
$faq_phone = trim((string) $cd['phone']);
$faq_phone_href = preg_replace('/[^0-9+]/', '', $faq_phone);
$faq_tg_link = trim((string) $cd['telegram']);

$teammate_name = '';
$teammate_image = ['url' => '', 'srcset' => '', 'sizes' => '', 'alt' => ''];
$teammate_tags = [];

// Сотрудник не выбран — первый из «Команды».
if ($teammate_id <= 0) {
  $teammate_first = get_posts([
    'post_type'      => 'teammate',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
    'fields'         => 'ids',
  ]);
  $teammate_id = (int) ($teammate_first[0] ?? 0);
}

if ($teammate_id > 0 && ($teammate_post = get_post($teammate_id))) {
    $teammate_name = trim((string) get_post_meta($teammate_id, 'teammate_name', true));

    if ($teammate_name === '') {
        $teammate_name = get_the_title($teammate_post);
    }

    $teammate_image = tolstenko_contact_get_image_attrs((int) get_post_meta($teammate_id, 'teammate_image_id', true));

    $tags_raw = preg_split('/\r\n|\r|\n/', (string) get_post_meta($teammate_id, 'teammate_list', true));
    $teammate_tags = array_values(array_filter(array_map('trim', (array) $tags_raw), static function ($tag) {
        return $tag !== '';
    }));
}
?>

<section class="faq section load-on-vissible--js" data-module="./modules/processAccordioninit.js" id="faq">
  <div class="container">
    <div class="faq__top section-top">
      <?php if (trim((string) $badge) !== '') : ?>
        <span class="faq__badge section-subtitle"><?= $badge; ?></span>
      <?php endif; ?>

      <?php if (trim((string) $title) !== '') : ?>
        <h2 class="faq__title section-title"><?= $title; ?></h2>
      <?php endif; ?>
    </div>

    <div class="faq__inner">
      <div class="faq__items" data-accordion>

        <?php foreach ($items as $index => $item) : ?>
          <div class="faq__item<?= $index === 0 ? ' active' : ''; ?>" data-accordion-item>
            <button type="button" class="faq__item-top" data-accordion-btn aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>">
              <p class="faq__item-title h4-16-20"><?= $item['quest'] ?? ''; ?></p>

              <svg class="faq__item-plus" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.99992 3.33398V16.6673M16.6666 10.0007L3.33325 10.0007" stroke-width="2" stroke-linecap="round" />
              </svg>
            </button>

            <div class="faq__item-body">
              <div class="faq__item-inner reg-par-14-20"><?= $item['unswer'] ?? ''; ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="faq__right br-30">
        <?php if (trim((string) $form_title) !== '' || trim((string) $form_text) !== '') : ?>
          <div class="faq__right-top">
            <?php if (trim((string) $form_title) !== '') : ?>
              <div class="faq__form-title"><?= $form_title; ?></div>
            <?php endif; ?>
            <?php if (trim((string) $form_text) !== '') : ?>
              <div class="faq__form-text reg-par-14-20"><?= $form_text; ?></div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <div class="faq__form form form--dark br-20">
          <?php echo do_shortcode('[contact-form-7 id="a80aad5" title="Телефон"]'); ?>
        </div>

        <?php if ($teammate_name !== '' || $faq_phone !== '' || $faq_tg_link !== '') : ?>
          <div class="faq__teammate br-20">
            <?php if ($teammate_name !== '') : ?>
              <div class="faq__teammate-head">
                <?php if ($teammate_image['url'] !== '') : ?>
                  <div class="faq__teammate-avatar">
                    <img src="<?= esc_url($teammate_image['url']); ?>" alt="<?= esc_attr($teammate_name); ?>" loading="lazy">
                  </div>
                <?php endif; ?>

                <div class="faq__teammate-info">
                  <div class="faq__teammate-name"><?= esc_html($teammate_name); ?></div>

                  <?php if (!empty($teammate_tags)) : ?>
                    <ul class="faq__teammate-tags">
                      <?php foreach ($teammate_tags as $tag) : ?>
                        <li class="faq__teammate-tag"><?= esc_html($tag); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($faq_phone !== '' || $faq_tg_link !== '') : ?>
              <div class="faq__contact-links">
                <?php if ($faq_phone !== '' && $faq_phone_href !== '') : ?>
                  <a class="faq__contact-link default-btn" href="tel:<?= esc_attr($faq_phone_href); ?>">Позвонить</a>
                <?php endif; ?>

                <?php if ($faq_tg_link !== '') : ?>
                  <a class="faq__contact-link faq__contact-link--outline default-btn" href="<?= esc_url($faq_tg_link); ?>" target="_blank" rel="noopener noreferrer">Телеграм</a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
