<?php

defined('ABSPATH') || exit;

/**
 * Секция «Почему именно мы».
 *
 * Дефолты подставляются, если соответствующий блок на странице не заполнен.
 * Если блок my-theme/why-us заполнен — данные приходят через query var why_us_data.
 */

$icons = [
    '<circle cx="12" cy="13.5" r="7.5" /><path d="M10 3h4M12 3v3M18.2 7.3l1.3-1.3" /><path d="m12.8 10.5-2.3 3h3l-2.3 3" />',
    '<path d="M12 3 4.5 5.5v6c0 4.4 3 7.6 7.5 9.5 4.5-1.9 7.5-5.1 7.5-9.5v-6L12 3Z" /><circle cx="12" cy="10.5" r="2.5" /><path d="M7.8 17c.8-2 2.4-3 4.2-3s3.4 1 4.2 3" />',
    '<rect x="3" y="4" width="14" height="11" rx="2" /><circle cx="10" cy="8.5" r="1.8" /><path d="M6.5 13c.6-1.6 1.9-2.3 3.5-2.3s2.9.7 3.5 2.3" /><path d="M7 18.5h12a2 2 0 0 0 2-2V8.5" />',
    '<path d="m12 2.5 2.3 1.8 2.9-.1 1.1 2.7 2.5 1.5-.9 2.8.9 2.8-2.5 1.5-1.1 2.7-2.9-.1L12 21.5l-2.3-1.8-2.9.1-1.1-2.7-2.5-1.5.9-2.8-.9-2.8 2.5-1.5 1.1-2.7 2.9.1L12 2.5Z" /><path d="m9 15 6-6" /><circle cx="9.4" cy="9.4" r=".9" /><circle cx="14.6" cy="14.6" r=".9" />',
    '<path d="M12.5 21H6.5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v6" /><path d="M8 8h6M8 11.5h6M8 15h3" /><path d="m14.5 18.5 2 2 4-4.5" />',
    '<path d="M8 4h8v5a4 4 0 0 1-8 0V4Z" /><path d="M8 6H5v1.5A3 3 0 0 0 8 10.5M16 6h3v1.5a3 3 0 0 1-3 3" /><path d="M12 13v4M8.5 20.5h7M9.5 17h5v3.5h-5z" />',
];

$defaults = [
    'subtitle'     => 'Почему именно мы',
    'title'        => 'Почему платят нам,',
    'title_accent' => 'а не идут к 10 другим',
    'items'        => [
        ['title' => 'Экономим ваше время', 'text' => 'Оформление, документы и переписку с банком берём на себя.'],
        ['title' => 'Паспорт РФ и сложные случаи', 'text' => 'Открываем там, где другим отказывают — это наша специализация.'],
        ['title' => 'Свои банкиры', 'text' => 'Прямые отношения с банками ускоряют одобрение и снижают риск отказа.'],
        ['title' => 'Цена ниже рынка', 'text' => 'Мы исполнитель на земле в DIFC — без наценки посредников.'],
        ['title' => 'Официальный договор', 'text' => 'Лицензия DIFC 6502 и прозрачные условия — всё по закону.'],
        ['title' => 'Проходим с первого раза', 'text' => 'Готовим пакет под требования комплаенса — без пересдач и задержек.'],
    ],
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
                $icon = !empty($item['icon']) ? $item['icon'] : ($icons[$index] ?? $icons[0]);
            ?>
                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <svg class="why-us__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <?= $icon; ?>
                        </svg>
                        <h3 class="why-us__item-title h4"><?= $item['title'] ?? ''; ?></h3>
                    </div>
                    <p class="why-us__item-text reg-par"><?= $item['text'] ?? ''; ?></p>
                </li>
            <?php endforeach; ?>

        </ul>
    </div>
</section>
