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
];

$overrides = get_query_var('flagship_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$cards = isset($data['cards']) && is_array($data['cards']) ? array_values($data['cards']) : [];

if (empty($cards)) {
    return;
}

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
        $btn_url = trim((string) ($card['btn_url'] ?? ''));
      ?>
        <article class="flagship__card">
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

          <?php if (trim((string) ($card['btn_text'] ?? '')) !== '') : ?>
            <div class="flagship__actions">
              <a class="flagship__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
                <span><?= $card['btn_text']; ?></span>
                <svg class="flagship__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
              </a>
            </div>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
