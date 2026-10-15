<?php

defined('ABSPATH') || exit;

/**
 * Секция «Инфраструктура за пределами РФ».
 *
 * Дефолты подставляются, если соответствующий блок на странице не заполнен.
 * Если блок my-theme/infra заполнен — данные приходят через query var infra_data.
 */

$defaults = [
    'subtitle'     => 'Для клиентов с капиталом и бизнесом',
    'title'        => 'Нужна не одна услуга,',
    'title_accent' => 'а инфраструктура за пределами РФ',
    'text'         => 'Соберём комплексное решение под перевод и владение активами, международные платежи и структуру бизнеса. Конфиденциально, с персональным менеджером.',
    'btn_text'     => 'Обсудить конфиденциально',
    'btn_link'     => ['url' => '#contact', 'title' => 'Обсудить конфиденциально', 'target' => ''],
    'items'        => [
        ['text' => 'Регистрация компании за рубежом'],
        ['text' => 'Международные платежи'],
        ['text' => 'Ведение и сохранность активов'],
        ['text' => 'Сопровождение комплаенса'],
        ['text' => 'Корпоративный счёт'],
        ['text' => 'Офшорные счета и структуры'],
        ['text' => 'Налоговое планирование'],
        ['text' => 'ВНЖ для бенефициаров'],
    ],
];

$overrides = get_query_var('infra_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? array_values($data['items']) : [];

if (empty($items)) {
    return;
}

$btn_link = isset($data['btn_link']) && is_array($data['btn_link']) ? $data['btn_link'] : ['url' => '', 'title' => '', 'target' => ''];
$btn_url = $btn_link['url'] ?? '';

$half = (int) ceil(count($items) / 2);
$lists = array_chunk($items, $half);
?>
<section class="infra section">
    <div class="container">
        <div class="infra__inner">

            <div class="infra__left">
                <span class="infra__badge"><?= $data['subtitle']; ?></span>
                <h2 class="infra__title">
                    <?= $data['title']; ?>
                    <span class="infra__title-accent"><?= $data['title_accent']; ?></span>
                </h2>
                <p class="infra__text">
                    <?= $data['text']; ?>
                </p>
                <?php if ($btn_url !== '' || !empty($data['btn_text'])) : ?>
                    <a class="infra__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#'); ?>">
                        <span><?= $data['btn_text']; ?></span>
                        <svg class="infra__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <div class="infra__right">
                <?php foreach ($lists as $list) : ?>
                    <ul class="infra__list">
                        <?php foreach ($list as $item) : ?>
                            <li class="infra__list-item"><?= $item['text'] ?? ''; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
