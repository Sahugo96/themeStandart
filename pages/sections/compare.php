<?php

defined('ABSPATH') || exit;

/**
 * Секция «Сравнение».
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('compare')
 * (таб «Секции лендинга → Сравнение»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('compare')
    : [];

$admin_rows = is_array($admin['rows'] ?? null) ? $admin['rows'] : [];
$rows = [];
foreach ($admin_rows as $row) {
    if (!is_array($row)) {
        continue;
    }
    $rows[] = [
        'criterion' => $row['criterion'] ?? '',
        'self'      => $row['self'] ?? '',
        'middle'    => $row['mediator'] ?? '',
        'direct'    => $row['us'] ?? '',
    ];
}

$defaults = [
    'subtitle'     => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'text'         => isset($admin['lead']) ? tolstenko_landing_text($admin['lead']) : '',
    'columns'      => [
        $admin['th_criterion'] ?? '',
        $admin['th_self'] ?? '',
        $admin['th_mediator'] ?? '',
        $admin['th_us'] ?? '',
    ],
    'rows'         => $rows,
    'foot_text'    => isset($admin['foot_text']) ? tolstenko_landing_text($admin['foot_text']) : '',
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_link'     => ['url' => $admin['btn_url'] ?? '', 'title' => $admin['btn_text'] ?? '', 'target' => ''],
];

$overrides = get_query_var('compare_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$rows = isset($data['rows']) && is_array($data['rows']) ? $data['rows'] : [];
$columns = isset($data['columns']) && is_array($data['columns']) ? array_values($data['columns']) : [];

if (empty($rows)) {
    return;
}

$columns = array_pad($columns, 4, '');
$btn_link = isset($data['btn_link']) && is_array($data['btn_link']) ? $data['btn_link'] : ['url' => '', 'title' => '', 'target' => ''];
$btn_url = trim((string) ($btn_link['url'] ?? ''));
$btn_text = trim((string) ($data['btn_text'] ?? ''));
$foot_text = trim((string) ($data['foot_text'] ?? ''));
$compare_lead = theme_section_text_html($data['text'] ?? '');
?>
<section class="compare section section--white">
    <div class="container">
        <div class="compare__top section-top">
            <?php if (trim((string) $data['subtitle']) !== '') : ?>
                <span class="compare__badge section-subtitle"><?= $data['subtitle']; ?></span>
            <?php endif; ?>

            <?php if (trim((string) $data['title']) !== '') : ?>
                <h2 class="compare__title section-title"><?= $data['title']; ?></h2>
            <?php endif; ?>

            <?php if ($compare_lead !== '') : ?>
                <div class="compare__lead section-text"><?= $compare_lead; ?></div>
            <?php endif; ?>
        </div>

        <div class="compare__table-wrap br-30">
            <table class="compare__table">
                <thead>
                    <tr>
                        <th class="compare__th" scope="col"><?= $columns[0]; ?></th>
                        <th class="compare__th" scope="col"><?= $columns[1]; ?></th>
                        <th class="compare__th" scope="col"><?= $columns[2]; ?></th>
                        <th class="compare__th compare__th--accent" scope="col"><?= $columns[3]; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row"><?= $row['criterion'] ?? ''; ?></th>
                            <td class="compare__cell"><?= $row['self'] ?? ''; ?></td>
                            <td class="compare__cell"><?= $row['middle'] ?? ''; ?></td>
                            <td class="compare__cell compare__cell--accent"><?= $row['direct'] ?? ''; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($foot_text !== '' || $btn_text !== '') : ?>
            <div class="compare__foot">
                <?php if ($foot_text !== '') : ?>
                    <p class="compare__foot-text"><?= $foot_text; ?></p>
                <?php endif; ?>

                <?php if ($btn_text !== '') : ?>
                    <a class="compare__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
                        <span><?= esc_html($btn_text); ?></span>
                        <svg class="compare__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
