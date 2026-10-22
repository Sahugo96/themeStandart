<?php

defined('ABSPATH') || exit;

/**
 * Секция «Сравнение программ» (programs).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('programs')
 * (таб «Дефолты блоков → Секции лендинга → Сравнение программ»).
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('programs') : [];

$defaults = [
    'badge'        => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'lead'         => $admin['lead'] ?? '',
    'columns'      => is_array($admin['columns'] ?? null) ? $admin['columns'] : [],
    'rows'         => is_array($admin['rows'] ?? null) ? $admin['rows'] : [],
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_url'      => $admin['btn_url'] ?? '',
];

$overrides = get_query_var('programs_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$columns = isset($data['columns']) && is_array($data['columns']) ? array_values($data['columns']) : [];
$rows = isset($data['rows']) && is_array($data['rows']) ? array_values($data['rows']) : [];

if (empty($columns) && empty($rows)) {
    return;
}

$lead = theme_section_text_html($data['lead'] ?? '');
$btn_url = (string) $data['btn_url'];
?>
<section class="programs section">
  <div class="container">
    <div class="programs__top section-top">
      <?php if (trim((string) $data['badge']) !== '') : ?>
        <span class="programs__badge section-subtitle"><?= $data['badge']; ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="programs__title"><?= $data['title']; ?></h2>
      <?php endif; ?>

      <?php if ($lead !== '') : ?>
        <div class="programs__lead"><?= $lead; ?></div>
      <?php endif; ?>
    </div>

    <div class="programs__table-wrap">
      <table class="programs__table">
        <thead>
          <tr>
            <?php foreach ($columns as $index => $column) :
              $column = is_array($column) ? $column : [];
              $flag = tolstenko_contact_get_image_attrs($column['flag'] ?? null);
              $accent = !empty($column['accent']) && (string) $column['accent'] === '1';
            ?>
              <th class="programs__th<?= $accent ? ' programs__th--accent' : ''; ?>" scope="col">
                <?php if ($flag['url'] !== '') : ?>
                  <img class="programs__flag" src="<?= $flag['url']; ?>" alt="" width="12" height="9" loading="lazy">
                <?php endif; ?>
                <?= $column['name'] ?? ''; ?>
              </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) :
            $row = is_array($row) ? $row : [];
            $values_raw = preg_split('/\r\n|\r|\n/', (string) ($row['values'] ?? ''));
            $values = array_values(array_map('trim', (array) $values_raw));
          ?>
            <tr class="programs__row">
              <th class="programs__criterion" scope="row"><?= $row['criterion'] ?? ''; ?></th>

              <?php foreach ($columns as $index => $column) :
                $column = is_array($column) ? $column : [];
                $accent = !empty($column['accent']) && (string) $column['accent'] === '1';
                $value = $values[$index] ?? '';
              ?>
                <td class="programs__cell<?= $accent ? ' programs__cell--accent' : ''; ?>"><?= $value; ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (trim((string) $data['btn_text']) !== '') : ?>
      <div class="programs__foot">
        <a class="programs__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
          <span><?= $data['btn_text']; ?></span>
          <svg class="programs__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4 12h16M14 6l6 6-6 6"/>
          </svg>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>