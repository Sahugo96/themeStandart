<?php

defined('ABSPATH') || exit;

/**
 * ACF-поля секции FAQ (локальная группа).
 *
 * Поля больше не берутся со страницы опций — они задаются у самой записи/страницы,
 * где выводится секция FAQ (блок my-theme/faq или страница блога).
 *
 * Состав полей:
 *  - faq_badge       — текстовое поле (надзаголовок/бейдж)
 *  - faq_title       — текстовое поле (заголовок)
 *  - faq_items       — повторитель: quest (текст) + unswer (редактор)
 *  - faq_form_title  — текстовое поле (заголовок формы)
 *  - faq_form_text   — текстовое поле (текст формы)
 *
 * @return void
 */
function tolstenko_register_faq_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'      => 'group_tolstenko_faq',
        'title'    => 'FAQ (частые вопросы)',
        'position' => 'normal',
        'active'   => true,
        'fields'   => array(
            array(
                'key'   => 'field_tolstenko_faq_badge',
                'label' => 'Надзаголовок (бейдж)',
                'name'  => 'faq_badge',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_tolstenko_faq_title',
                'label' => 'Заголовок',
                'name'  => 'faq_title',
                'type'  => 'text',
            ),
            array(
                'key'          => 'field_tolstenko_faq_items',
                'label'        => 'Вопросы и ответы',
                'name'         => 'faq_items',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Добавить вопрос',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_tolstenko_faq_item_quest',
                        'label' => 'Вопрос',
                        'name'  => 'quest',
                        'type'  => 'text',
                    ),
                    array(
                        'key'          => 'field_tolstenko_faq_item_unswer',
                        'label'        => 'Ответ',
                        'name'         => 'unswer',
                        'type'         => 'wysiwyg',
                        'media_upload' => 0,
                        'toolbar'      => 'basic',
                        'tabs'         => 'all',
                    ),
                ),
            ),
            array(
                'key'   => 'field_tolstenko_faq_form_title',
                'label' => 'Заголовок формы',
                'name'  => 'faq_form_title',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_tolstenko_faq_form_text',
                'label' => 'Текст формы',
                'name'  => 'faq_form_text',
                'type'  => 'text',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'page',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'blog',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'service',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'tolstenko_register_faq_fields');
