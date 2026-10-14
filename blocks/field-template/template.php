<?php

defined('ABSPATH') || exit;

// Эталонный шаблон гутенберг-блока.
//
// Принцип: атрибуты блока (заданы в редакторе) имеют приоритет,
// иначе берём дефолты со страницы «Дефолты блоков» через
// tolstenko_get_block_defaults( '<ключ>' ), где <ключ> совпадает с data-panel таба.
//
// Демонстрирует типы полей: чекбокс, текстовое поле, текстовая область,
// визуальный редактор (rich text), изображение, повторитель (repeater),
// множественный выбор записей и выбор одной записи.

$data = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('field_template')
    : array();

// 0. Чекбокс (булев флаг включения блока).
$enabled = !empty($attributes['enabled'])
    || !empty($data['enabled']);

if (!$enabled) {
    return;
}

// 1. Текстовое поле (одна строка).
$text_field = (string) (
    ($attributes['text_field'] ?? '') !== ''
        ? $attributes['text_field']
        : ($data['text_field'] ?? '')
);

// 2. Текстовая область (многострочный текст).
$textarea_field = (string) (
    ($attributes['textarea_field'] ?? '') !== ''
        ? $attributes['textarea_field']
        : ($data['textarea_field'] ?? '')
);

// 3. Редактор (rich text / HTML).
$editor_field = (string) (
    ($attributes['editor_field'] ?? '') !== ''
        ? $attributes['editor_field']
        : ($data['editor_field'] ?? '')
);

// 4. Изображение (id вложения).
$image_id = (int) (
    !empty($attributes['image_id'])
        ? $attributes['image_id']
        : ($data['image'] ?? 0)
);

// 6. Множественный выбор записей (массив id).
$post_ids = !empty($attributes['post_ids']) && is_array($attributes['post_ids'])
    ? array_map('intval', $attributes['post_ids'])
    : (is_array($data['post_ids'] ?? null) ? array_map('intval', $data['post_ids']) : array());

// 7. Выбор одной записи (одиночный id).
$single_post_id = (int) (
    !empty($attributes['single_post_id'])
        ? $attributes['single_post_id']
        : ($data['single_post_id'] ?? 0)
);

// 5. Повторитель (массив элементов с title/text).
$items = !empty($attributes['items']) && is_array($attributes['items'])
    ? $attributes['items']
    : (is_array($data['items'] ?? null) ? $data['items'] : array());
?>

<section class="field-template section">
    <div class="container">

        <?php if ($text_field !== '') : ?>
            <h2 class="field-template__title h2"><?= esc_html($text_field); ?></h2>
        <?php endif; ?>

        <?php if ($textarea_field !== '') : ?>
            <div class="field-template__textarea lead-20-25"><?= nl2br(esc_html($textarea_field)); ?></div>
        <?php endif; ?>

        <?php if ($editor_field !== '') : ?>
            <div class="field-template__editor content-styles"><?= wp_kses_post($editor_field); ?></div>
        <?php endif; ?>

        <?php if ($image_id) :
            echo wp_get_attachment_image($image_id, 'large', false, array('class' => 'field-template__image'));
        endif; ?>

        <?php if (!empty($items)) : ?>
            <div class="field-template__items">
                <?php foreach ($items as $item) :
                    $item = is_array($item) ? $item : array();
                    $item_title    = (string) ($item['title'] ?? '');
                    $item_text     = (string) ($item['text'] ?? '');
                    if ($item_title === '' && $item_text === '') {
                        continue;
                    }
                    ?>
                    <div class="field-template__item br-30">
                        <?php if ($item_title !== '') : ?>
                            <h3 class="field-template__item-title"><?= esc_html($item_title); ?></h3>
                        <?php endif; ?>

                        <?php if ($item_text !== '') : ?>
                            <p class="field-template__item-text"><?= nl2br(esc_html($item_text)); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($post_ids)) :
            $ftpl_posts = get_posts(array(
                'post__in'            => $post_ids,
                'post_type'           => 'any',
                'post_status'         => 'publish',
                'orderby'             => 'post__in',
                'ignore_sticky_posts' => true,
            ));
            if ($ftpl_posts) : ?>
                <div class="field-template__posts">
                    <?php foreach ($ftpl_posts as $ftpl_post) : ?>
                        <a class="field-template__post" href="<?= esc_url((string) get_permalink($ftpl_post)); ?>">
                            <?= esc_html(get_the_title($ftpl_post)); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif;
        endif; ?>

        <?php if ($single_post_id && ($ftpl_single = get_post($single_post_id))) : ?>
            <a class="field-template__single-post" href="<?= esc_url((string) get_permalink($ftpl_single)); ?>">
                <?= esc_html(get_the_title($ftpl_single)); ?>
            </a>
        <?php endif; ?>

    </div>
</section>
