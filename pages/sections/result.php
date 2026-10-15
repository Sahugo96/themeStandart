<?php

defined('ABSPATH') || exit;

/**
 * Секция «Что вы получаете» (Result).
 *
 * Дефолты подставляются, если соответствующий блок на странице не заполнен.
 * Если блок my-theme/result заполнен — данные приходят через query var result_data.
 */

$icons = [
    '<path d="M3 9.5 12 4l9 5.5M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 20h18M4 9.5h16" />',
    '<rect x="3" y="5" width="18" height="14" rx="2" /><rect x="6" y="8.5" width="4.5" height="3.5" rx=".6" /><path d="M13.5 9h4M13.5 12h4M6 15.5h11.5" />',
    '<rect x="3" y="5" width="18" height="14" rx="2.5" /><path d="M3 9.5h18M6.5 15h2.5M12 15h2.5" />',
    '<rect x="3" y="8" width="18" height="12" rx="2" /><path d="M8.5 8V6.5A1.5 1.5 0 0 1 10 5h4a1.5 1.5 0 0 1 1.5 1.5V8M3 13l9 3 9-3" />',
    '<path d="M3 4v16h18" /><path d="m6.5 14 4-4 3 3 5-6" /><path d="M15.5 7h3.5v3.5" />',
    '<path d="M4 14v-2a8 8 0 0 1 16 0v2" /><rect x="3" y="13" width="4" height="6" rx="1.5" /><rect x="17" y="13" width="4" height="6" rx="1.5" /><path d="M19 19c0 1.5-1.5 2.5-4 2.5h-2" />',
];

$defaults = [
    'subtitle' => 'Результат',
    'title'    => 'Что вы получаете',
    'items'    => [
        ['title' => 'IBAN и счёт', 'text' => 'Мультивалютный счёт с международными переводами.'],
        ['title' => 'Emirates ID', 'text' => 'Резидентский статус и спонсорство семьи.'],
        ['title' => 'Карты', 'text' => 'Дебетовые и кредитные для платежей по миру.'],
        ['title' => 'Компания и лицензия', 'text' => 'Устав, юр. адрес и корпоративный счёт.'],
        ['title' => 'Доступ к инвестициям', 'text' => 'Брокерский счёт и верификация на платформах.'],
        ['title' => 'Сопровождение после', 'text' => 'Помощь с комплаенсом и обслуживанием.'],
    ],
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
                            $icon = !empty($item['icon']) ? $item['icon'] : ($icons[$index] ?? $icons[0]);
                        ?>
                            <article class="result__item fade-in-element splide__slide br-15">
                                <div class="result__item-head">
                                    <svg class="result__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <?= $icon; ?>
                                    </svg>
                                    <h3 class="result__item-title h4"><?= $item['title'] ?? ''; ?></h3>
                                </div>
                                <p class="result__item-text reg-par"><?= $item['text'] ?? ''; ?></p>
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
