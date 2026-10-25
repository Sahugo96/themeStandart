<?php

defined('ABSPATH') || exit;

/**
 * Секция «Флагманские программы резидентства» (flagship).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('flagship')
 * (таб «Дефолты блоков → Секции лендинга → Флагманские программы»).
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('flagship') : [];

$defaults = [
    'badge' => $admin['badge'] ?? '',
    'title' => $admin['title'] ?? '',
    'cards' => is_array($admin['cards'] ?? null) ? $admin['cards'] : [],
    'links' => is_array($admin['links'] ?? null) ? $admin['links'] : [],
    'table_title'  => $admin['table_title'] ?? '',
    'col_country'  => $admin['col_country'] ?? '',
    'col_price'    => $admin['col_price'] ?? '',
    'col_term'     => $admin['col_term'] ?? '',
    'col_benefits' => $admin['col_benefits'] ?? '',
    'row_btn_text' => $admin['row_btn_text'] ?? '',
    'rows'         => is_array($admin['rows'] ?? null) ? $admin['rows'] : [],
    'foot_text'    => $admin['foot_text'] ?? '',
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_url'      => $admin['btn_url'] ?? '',
];

$overrides = get_query_var('flagship_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$cards = isset($data['cards']) && is_array($data['cards']) ? array_values($data['cards']) : [];

if (empty($cards)) {
    return;
}

// Иконка из таба — ID вложения, из блока — {id, url}.
$icon_raw = static function ($icon): string {
    if (is_array($icon)) {
        $icon_id = (int) ($icon['id'] ?? $icon['ID'] ?? 0);

        return $icon_id ? (string) $icon_id : (string) ($icon['url'] ?? '');
    }

    return trim((string) $icon);
};

// Кнопки-ссылки карточек. Пусто = WhatsApp и Telegram из «Контактных данных».
$links = [];
foreach ((array) $data['links'] as $link) {
    $link = is_array($link) ? $link : [];
    $link_url = trim((string) ($link['url'] ?? ''));

    if ($link_url !== '') {
        $links[] = ['icon' => $icon_raw($link['icon'] ?? ''), 'url' => $link_url];
    }
}

if (!$links && function_exists('tolstenko_get_contact_data')) {
    $contacts = tolstenko_get_contact_data();

    // Иконка из контактов; если её нет — иконка мессенджера из темы.
    $default_icons = [
        'whatsapp' => get_template_directory_uri() . '/assets/img/WA Icon.svg',
        'telegram' => get_template_directory_uri() . '/assets/img/TG Icon.svg',
    ];

    foreach ($default_icons as $messenger => $default_icon) {
        if (trim((string) ($contacts[$messenger] ?? '')) === '') {
            continue;
        }

        $contact_icon = trim((string) ($contacts[$messenger . '_ico'] ?? ''));
        $links[] = [
            'icon'    => $contact_icon !== '' ? $contact_icon : $default_icon,
            'url'     => trim((string) $contacts[$messenger]),
            'default' => $contact_icon === '',
        ];
    }
}

$rows = array_values(array_filter((array) $data['rows'], static function ($row) {
    return is_array($row) && trim(wp_strip_all_tags((string) ($row['name'] ?? ''))) !== '';
}));

$columns = [
    trim((string) $data['col_country']),
    trim((string) $data['col_price']),
    trim((string) $data['col_term']),
    trim((string) $data['col_benefits']),
];

$foot_text = theme_section_text_html($data['foot_text'] ?? '');
$btn_url   = trim((string) ($data['btn_url'] ?? ''));

$split_lines = static function ($value): array {
    $lines = preg_split('/\r\n|\r|\n/', (string) $value);

    return array_values(array_filter(array_map('trim', (array) $lines), static function ($line) {
        return $line !== '';
    }));
};
?>
<section class="flagship section">
  <div class="container">
    <div class="flagship__top section-top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="flagship__badge section-subtitle"><?= $data['badge']; ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="flagship__title section-title"><?= $data['title']; ?></h2>
      <?php endif; ?>
    </div>

    <div class="flagship__list">
      <?php foreach ($cards as $card) :
        $card = is_array($card) ? $card : [];
        $flag = tolstenko_contact_get_image_attrs($card['flag'] ?? null);
        $facts = $split_lines($card['facts'] ?? '');
        $card_btn_url = trim((string) ($card['btn_url'] ?? ''));
      ?>
        <article class="flagship__card br-30">
          <div class="flagship__card-top">
            <?php if (trim((string) ($card['country'] ?? '')) !== '') : ?>
              <span class="flagship__country">
                <?php if ($flag['url'] !== '') : ?>
                  <img class="flagship__flag" src="<?= $flag['url']; ?>" alt="" width="14" height="10" loading="lazy">
                <?php endif; ?>
                <?= $card['country']; ?>
              </span>
            <?php endif; ?>

            <?php if (trim((string) ($card['price'] ?? '')) !== '') : ?>
              <span class="flagship__price"><?= $card['price']; ?></span>
            <?php endif; ?>
          </div>

          <?php if (trim((string) ($card['title'] ?? '')) !== '') : ?>
            <h3 class="flagship__card-title"><?= $card['title']; ?></h3>
          <?php endif; ?>

          <?php if (trim((string) ($card['text'] ?? '')) !== '') : ?>
            <div class="flagship__card-text"><?= theme_section_text_html($card['text']); ?></div>
          <?php endif; ?>

          <?php if (!empty($facts)) : ?>
            <ul class="flagship__facts">
              <?php foreach ($facts as $fact) :
                $parts = array_map('trim', explode(':', $fact, 2));
                $fact_label = $parts[0] ?? '';
                $fact_value = $parts[1] ?? '';
              ?>
                <li class="flagship__fact">
                  <span class="flagship__fact-label">
                    <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    <?= esc_html($fact_label); ?><?= $fact_value !== '' ? ':' : ''; ?>
                  </span>
                  <?php if ($fact_value !== '') : ?>
                    <span class="flagship__fact-value"><?= esc_html($fact_value); ?></span>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php if (trim((string) ($card['btn_text'] ?? '')) !== '' || $links) : ?>
            <div class="flagship__actions">
              <?php if (trim((string) ($card['btn_text'] ?? '')) !== '') : ?>
                <a class="flagship__btn" href="<?= esc_url($card_btn_url !== '' ? $card_btn_url : '#modal'); ?>">
                  <span><?= $card['btn_text']; ?></span>
                  <svg class="flagship__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
                </a>
              <?php endif; ?>

              <?php foreach ($links as $link) :
                $svg = function_exists('tolstenko_contact_get_inline_svg') ? tolstenko_contact_get_inline_svg($link['icon']) : '';
                $icon_url = $svg === '' ? tolstenko_contact_resolve_icon_url($link['icon']) : '';
              ?>
                <a class="flagship__round<?= !empty($link['default']) ? ' flagship__round--default' : ''; ?>" href="<?= esc_url($link['url']); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc_attr(wp_strip_all_tags((string) ($card['title'] ?? ''))); ?> — написать">
                  <?php if ($svg !== '') : ?>
                    <?= $svg; ?>
                  <?php elseif ($icon_url !== '') : ?>
                    <img src="<?= esc_url($icon_url); ?>" alt="" loading="lazy">
                  <?php endif; ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($rows) : ?>
      <div class="flagship__other">
        <?php if (trim((string) $data['table_title']) !== '') : ?>
          <h3 class="flagship__table-title"><?= wp_kses_post($data['table_title']); ?></h3>
        <?php endif; ?>

        <div class="flagship__table-wrap">
          <table class="flagship__table">
            <thead>
              <tr>
                <?php foreach ($columns as $column) : ?>
                  <th class="flagship__th" scope="col"><?= esc_html($column); ?></th>
                <?php endforeach; ?>
                <th class="flagship__th" scope="col"><span class="flagship__sr">Действие</span></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $row) :
                $flag = tolstenko_contact_get_image_attrs($row['flag'] ?? null);
                $benefits = array_values(array_filter(array_map(static function ($benefit) {
                    return trim((string) (is_array($benefit) ? ($benefit['text'] ?? '') : $benefit));
                }, (array) ($row['benefits'] ?? [])), 'strlen'));
                $row_link = trim((string) ($row['link'] ?? ''));
              ?>
                <tr class="flagship__row">
                  <td class="flagship__cell flagship__cell--country">
                    <?php if ($flag['url'] !== '') : ?>
                      <img class="flagship__row-flag" src="<?= $flag['url']; ?>" alt="" width="16" height="12" loading="lazy">
                    <?php endif; ?>
                    <span class="flagship__country-name"><?= wp_kses_post($row['name']); ?></span>
                  </td>
                  <td class="flagship__cell flagship__cell--strong"><?= wp_kses_post($row['price'] ?? ''); ?></td>
                  <td class="flagship__cell flagship__cell--strong"><?= wp_kses_post($row['term'] ?? ''); ?></td>
                  <td class="flagship__cell">
                    <?php if ($benefits) : ?>
                      <ul class="flagship__benefits">
                        <?php foreach ($benefits as $benefit) : ?>
                          <li><?= esc_html($benefit); ?></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  </td>
                  <td class="flagship__cell flagship__cell--action">
                    <?php if (trim((string) $data['row_btn_text']) !== '') : ?>
                      <a class="flagship__row-link" href="<?= esc_url($row_link !== '' ? $row_link : '#modal'); ?>">
                        <span><?= esc_html($data['row_btn_text']); ?></span>
                        <svg class="flagship__row-link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($foot_text !== '' || trim((string) $data['btn_text']) !== '') : ?>
      <div class="flagship__foot">
        <?php if ($foot_text !== '') : ?>
          <div class="flagship__foot-text"><?= $foot_text; ?></div>
        <?php endif; ?>

        <?php if (trim((string) $data['btn_text']) !== '') : ?>
          <a class="flagship__more" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
            <span><?= esc_html($data['btn_text']); ?></span>
            <svg class="flagship__more-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
