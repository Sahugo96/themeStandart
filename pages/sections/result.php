<?php

defined('ABSPATH') || exit;

/**
 * Секция «Что вы получаете» (Result).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('result')
 * (таб «Секции лендинга → Результат»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('result')
    : [];

$defaults = [
    'subtitle' => $admin['badge'] ?? '',
    'title'    => $admin['title'] ?? '',
    'items'    => is_array($admin['items'] ?? null) ? $admin['items'] : [],
];

$overrides = get_query_var('result_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? $data['items'] : [];

if (empty($items)) {
    return;
}
?>
<section class="result section section--white">
    <div class="container">
        <div class="result__top section-top">
            <span class="result__badge section-subtitle"><?= $data['subtitle']; ?></span>
            <h2 class="result__title section-title"><?= $data['title']; ?></h2>
        </div>

        <div class="result__panel br-30">
            <div class="fade-in-container result__splide splide load-on-vissible--js"
                aria-label="<?= esc_attr(wp_strip_all_tags($data['title'])); ?>"
                data-module="./libs/splide.min.js,./modules/resultSplideInit.js"
                data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
                id="result-container">
                <div class="splide__track">
                    <div class="result__splide-list splide__list">

                        <?php foreach ($items as $index => $item) :
                            $icon = tolstenko_landing_icon('result', $index, $item['icon'] ?? 0, 'result__item-icon');
                        ?>
                            <article class="result__item br-15 fade-in-element splide__slide">
                                <div class="result__item-head">
                                    <?= $icon; ?>
                                    <h3 class="result__item-title h4"><?= $item['title'] ?? ''; ?></h3>
                                </div>
                                <p class="result__item-text reg-par-14-20"><?= $item['text'] ?? ''; ?></p>
                            </article>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="splide__bottom">
                    <div class="splide__pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
