<?php

defined('ABSPATH') || exit;

/**
 * Секция «Почему именно мы».
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('why_us')
 * (таб «Секции лендинга → Почему именно мы»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('why_us')
    : [];

$defaults = [
    'subtitle'     => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'title_accent' => $admin['title_accent'] ?? '',
    'items'        => is_array($admin['items'] ?? null) ? $admin['items'] : [],
];

$overrides = get_query_var('why_us_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? $data['items'] : [];

if (empty($items)) {
    return;
}
?>
<section class="why-us section">
    <div class="container">
        <div class="why-us__top section-top">
            <span class="why-us__badge section-subtitle"><?= $data['subtitle']; ?></span>
            <h2 class="why-us__title section-title">
                <?= $data['title']; ?>
                <span><?= $data['title_accent']; ?></span>
            </h2>
        </div>

        <ul class="why-us__items br-30">

            <?php foreach ($items as $index => $item) :
                $icon = tolstenko_landing_icon('why_us', $index, $item['icon'] ?? 0, 'why-us__item-icon');
            ?>
                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <?= $icon; ?>
                        <h3 class="why-us__item-title h4"><?= $item['title'] ?? ''; ?></h3>
                    </div>
                    <p class="why-us__item-text reg-par-14-20"><?= $item['text'] ?? ''; ?></p>
                </li>
            <?php endforeach; ?>

        </ul>
    </div>
</section>
