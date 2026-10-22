<?php

defined('ABSPATH') || exit;

/**
 * Секция «Другие программы — ВНЖ в Европе» (europe).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('europe')
 * (таб «Дефолты блоков → Секции лендинга → ВНЖ в Европе»).
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('europe') : [];

$defaults = [
    'title'      => $admin['title'] ?? '',
    'columns'    => is_array($admin['columns'] ?? null) ? $admin['columns'] : [],
    'rows'       => is_array($admin['rows'] ?? null) ? $admin['rows'] : [],
    'link_text'  => $admin['link_text'] ?? '',
    'link_url'   => $admin['link_url'] ?? '',
    'foot_text'  => $admin['foot_text'] ?? '',
    'btn_text'   => $admin['btn_text'] ?? '',
    'btn_url'    => $admin['btn_url'] ?? '',
];

$overrides = get_query_var('europe_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$rows = isset($data['rows']) && is_array($data['rows']) ? array_values($data['rows']) : [];
$columns = isset($data['columns']) && is_array($data['columns']) ? array_values($data['columns']) : [];

if (empty($rows)) {
    return;
}

$columns = array_pad($columns, 5, '');
$link_text = trim((string) $data['link_text']);
$link_url = trim((string) $data['link_url']);
$foot_text = theme_section_text_html($data['foot_text']);
$btn_url = trim((string) $data['btn_url']);
?>
<section class="europe section">
  <div class="container">
    <?php if (trim((string) $data['title']) !== '') : ?>
      <h3 class="europe__title"><?= $data['title']; ?></h3>
    <?php endif; ?>

    <div class="europe__table-wrap">
      <table class="europe__table">
        <thead>
          <tr>
            <?php foreach ($columns as $index => $column) : ?>
              <th class="europe__th" scope="col">
                <?php if ($index === 4) : ?>
                  <span class="europe__sr"><?= $column !== '' ? $column : 'Действие'; ?></span>
                <?php else : ?>
                  <?= $column; ?>
                <?php endif; ?>
              </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) :
            $row = is_array($row) ? $row : [];
            $flag = tolstenko_contact_get_image_attrs($row['flag'] ?? null);
            $benefits_raw = preg_split('/\r\n|\r|\n/', (string) ($row['benefits'] ?? ''));
            $benefits = array_values(array_filter(array_map('trim', (array) $benefits_raw), static function ($line) {
                return $line !== '';
            }));
            $row_link = trim((string) ($row['link_url'] ?? ''));
            $row_link_text = trim((string) ($row['link_text'] ?? ''));
          ?>
            <tr class="europe__row">
              <td class="europe__cell europe__cell--country">
                <?php if ($flag['url'] !== '') : ?>
                  <img class="europe__flag" src="<?= $flag['url']; ?>" alt="" width="16" height="12" loading="lazy">
                <?php endif; ?>
                <span class="europe__country-name"><?= $row['country'] ?? ''; ?></span>
                <?php if (trim((string) ($row['note'] ?? '')) !== '') : ?>
                  <span class="europe__country-note"><?= $row['note']; ?></span>
                <?php endif; ?>
              </td>
              <td class="europe__cell europe__cell--strong"><?= $row['price'] ?? ''; ?></td>
              <td class="europe__cell europe__cell--strong"><?= $row['term'] ?? ''; ?></td>
              <td class="europe__cell">
                <?php if (!empty($benefits)) : ?>
                  <ul class="europe__benefits">
                    <?php foreach ($benefits as $benefit) : ?>
                      <li><?= esc_html($benefit); ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </td>
              <td class="europe__cell europe__cell--action">
                <?php if ($row_link_text !== '') : ?>
                  <a class="europe__link" href="<?= esc_url($row_link !== '' ? $row_link : '#modal'); ?>">
                    <span><?= esc_html($row_link_text); ?></span>
                    <svg class="europe__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if ($foot_text !== '' || trim((string) $data['btn_text']) !== '') : ?>
      <div class="europe__foot">
        <?php if ($foot_text !== '') : ?>
          <div class="europe__foot-text"><?= $foot_text; ?></div>
        <?php endif; ?>

        <?php if (trim((string) $data['btn_text']) !== '') : ?>
          <a class="europe__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
            <span><?= $data['btn_text']; ?></span>
            <svg class="europe__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
