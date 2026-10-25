<?php

defined('ABSPATH') || exit;

/**
 * Блок «Главный баннер» (my-theme/main-hero).
 *
 * Принцип: атрибуты блока (заданы в редакторе) имеют приоритет,
 * иначе берём дефолты со страницы «Дефолты блоков» через
 * tolstenko_get_block_defaults( 'main_hero' ).
 */

$data = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('main_hero')
    : array();

// 0. Флаг показа (чекбокс) — для совместимости с паттерном field-template.
//    Если в будущем нужно будет скрывать блок через админку — раскомментируйте.
// $enabled = !empty($attributes['block_main_hero_enabled'] ?? false) || !empty($data['enabled']);
// if (!$enabled) {
//     return;
// }

// 0.1. Бейдж над заголовком
$badge = (string) (
    ($attributes['block_main_hero_badge'] ?? '') !== ''
        ? $attributes['block_main_hero_badge']
        : ($data['badge'] ?? '')
);

// 1. Заголовок (HTML)
$title = (string) (
    ($attributes['block_main_hero_title'] ?? '') !== ''
        ? $attributes['block_main_hero_title']
        : ($data['title'] ?? '')
);

// 2. Тег заголовка
$title_tag = (string) (
    ($attributes['block_main_hero_title_tag'] ?? '') !== ''
        ? $attributes['block_main_hero_title_tag']
        : ($data['title_tag'] ?? 'h1')
);

// 3. Текст (HTML)
$text = (string) (
    ($attributes['block_main_hero_text'] ?? '') !== ''
        ? $attributes['block_main_hero_text']
        : ($data['text'] ?? '')
);

// 4. Пункты списка (HTML) — массив объектов {title, text}
$items = array();
if (!empty($attributes['block_main_hero_items']) && is_array($attributes['block_main_hero_items'])) {
    foreach ($attributes['block_main_hero_items'] as $it) {
        if (is_array($it)) {
            $items[] = array(
                'title' => isset($it['title']) ? (string) $it['title'] : '',
                'text'  => isset($it['text']) ? (string) $it['text'] : '',
            );
        } elseif (is_object($it)) {
            $items[] = array(
                'title' => isset($it->title) ? (string) $it->title : '',
                'text'  => isset($it->text) ? (string) $it->text : '',
            );
        }
    }
}
if (empty($items) && is_array($data['items'] ?? null)) {
    foreach ($data['items'] as $it) {
        if (is_array($it)) {
            $items[] = array(
                'title' => isset($it['title']) ? (string) $it['title'] : '',
                'text'  => isset($it['text']) ? (string) $it['text'] : '',
            );
        } elseif (is_object($it)) {
            $items[] = array(
                'title' => isset($it->title) ? (string) $it->title : '',
                'text'  => isset($it->text) ? (string) $it->text : '',
            );
        }
    }
}

// 5. Текст кнопки
$btn_text = (string) (
    ($attributes['block_main_hero_btn_text'] ?? '') !== ''
        ? $attributes['block_main_hero_btn_text']
        : ($data['btn_text'] ?? '')
);

// 5.1. Подпись под текстом кнопки
$btn_subtext = (string) (
    ($attributes['block_main_hero_btn_subtext'] ?? '') !== ''
        ? $attributes['block_main_hero_btn_subtext']
        : ($data['btn_subtext'] ?? '')
);

// 6. Показывать ли промо у кнопки
//    Пусто = как в дефолтах, «1»/«0» — явный выбор в блоке.
$show_promo_attr = (string) ($attributes['block_main_hero_show_promo'] ?? '');
$show_promo = $show_promo_attr === ''
    ? !empty($data['show_promo'])
    : filter_var($show_promo_attr, FILTER_VALIDATE_BOOLEAN);

// 7. Текст промо (HTML)
$promo_text = (string) (
    ($attributes['block_main_hero_promo_text'] ?? '') !== ''
        ? $attributes['block_main_hero_promo_text']
        : ($data['promo_text'] ?? '')
);

// 8. Изображение «подарка» (ID вложения)
$present_image_id = (int) (
    !empty($attributes['block_main_hero_present_image'])
        ? $attributes['block_main_hero_present_image']
        : ($data['present_image'] ?? 0)
);

// 9. Имя персоны
$person_name = (string) (
    ($attributes['block_main_hero_person_name'] ?? '') !== ''
        ? $attributes['block_main_hero_person_name']
        : ($data['person_name'] ?? '')
);

// 10. Должность персоны
$person_position = (string) (
    ($attributes['block_main_hero_person_position'] ?? '') !== ''
        ? $attributes['block_main_hero_person_position']
        : ($data['person_position'] ?? '')
);

// 11. Основное изображение баннера (ID вложения)
$image_id = (int) (
    !empty($attributes['block_main_hero_image'])
        ? $attributes['block_main_hero_image']
        : ($data['image'] ?? 0)
);

set_query_var('main_hero_data', array(
    'badge'          => $badge,
    'title'          => $title,
    'title_tag'      => in_array($title_tag, array('h1','h2','h3','h4','h5','h6'), true) ? $title_tag : 'h1',
    'text'           => $text,
    'items'          => $items,
    'btn_text'       => $btn_text,
    'btn_subtext'    => $btn_subtext,
    'show_promo'     => (bool) $show_promo,
    'promo_text'     => $promo_text,
    'present_image_id' => $present_image_id,
    'person_name'    => $person_name,
    'person_position'=> $person_position,
    'image_id'       => $image_id,
));

get_template_part('pages/sections/main-hero');
