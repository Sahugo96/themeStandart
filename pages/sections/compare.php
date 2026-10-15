<?php

defined('ABSPATH') || exit;

/**
 * Секция «Сравнение».
 *
 * Дефолты подставляются, если соответствующий блок на странице не заполнен.
 * Если блок my-theme/compare заполнен — данные приходят через query var compare_data.
 */

$defaults = [
    'subtitle' => 'Сравнение',
    'title'    => 'Сам, через посредника',
    'title_accent' => 'или напрямую с нами',
    'text'     => 'Мы — исполнитель на земле в DIFC.<br>Посредник из РФ перепродаёт нашу же работу с наценкой.<br>Разница видна по каждому пункту.',
    'columns'  => ['Критерий', 'Сам', 'Через посредника', 'Напрямую с нами'],
    'rows'     => [
        ['criterion' => 'Цена', 'self' => 'Скрытые расходы', 'middle' => '+ наценка посредника', 'direct' => 'Без наценки, от исполнителя'],
        ['criterion' => 'Кто оформляет', 'self' => 'Вы сами', 'middle' => 'Перепродаёт исполнителю', 'direct' => 'Мы, напрямую'],
        ['criterion' => 'Доступ к банкам', 'self' => 'Общие условия', 'middle' => 'Через третьи руки', 'direct' => 'Свои банкиры, прямые отношения'],
        ['criterion' => 'Помощь с комплаенсом', 'self' => 'Разбираетесь сами', 'middle' => 'Обычно не сопровождают', 'direct' => 'Закрываем вопросы комплаенса'],
        ['criterion' => 'Сопровождение после', 'self' => 'Нет', 'middle' => 'До открытия счёта', 'direct' => 'Дальнейшая поддержка'],
        ['criterion' => 'Ответственность', 'self' => 'На вас', 'middle' => 'Размыта между звеньями', 'direct' => 'Одна команда по договору'],
        ['criterion' => 'Скорость и риск отказа', 'self' => 'Медленно, высокий риск', 'middle' => 'Задержки на передаче', 'direct' => 'Быстрее, ниже риск'],
    ],
    'foot_text' => 'Большинство компаний на рынке — посредники.<br>В итоге всё равно приходят к исполнителю.<br>Так почему бы не сразу к нам?',
    'btn_text'  => 'Начать сотрудничество',
    'btn_link'  => ['url' => '#modal', 'title' => 'Начать сотрудничество', 'target' => ''],
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
$btn_url = $btn_link['url'] ?? '';
?>
<section class="compare section section--white">
    <div class="container">
        <div class="compare__top section-top">
            <span class="compare__badge section-subtitle"><?= $data['subtitle']; ?></span>
            <h2 class="compare__title section-title">
                <?= $data['title']; ?>
                <span><?= $data['title_accent']; ?></span>
            </h2>
            <p class="compare__lead section-text">
                <?= $data['text']; ?>
            </p>
        </div>

        <div class="compare__table-wrap">
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

        <div class="compare__foot">
            <p class="compare__foot-text">
                <?= $data['foot_text']; ?>
            </p>
            <?php if ($btn_url !== '' || !empty($data['btn_text'])) : ?>
                <a class="compare__btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#'); ?>">
                    <span><?= $data['btn_text']; ?></span>
                    <svg class="compare__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 12h16M14 6l6 6-6 6" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
