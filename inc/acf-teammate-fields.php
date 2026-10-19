<?php

defined('ABSPATH') || exit;

/**
 * ACF-поля записи «Член команды» (CPT teammate).
 *
 * Поля: Имя, Картинка, Список, Описание, текст кнопки, ссылка кнопки,
 * повторитель ссылок (иконка SVG + ссылка).
 *
 * @return void
 */
function tolstenko_register_teammate_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'      => 'group_tolstenko_teammate',
        'title'    => 'Член команды',
        'position' => 'normal',
        'active'   => true,
        'fields'   => array(
            array(
                'key'   => 'field_teammate_name',
                'label' => 'Имя',
                'name'  => 'teammate_name',
                'type'  => 'text',
            ),
            array(
                'key'           => 'field_teammate_image',
                'label'         => 'Картинка',
                'name'          => 'teammate_image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
            ),
            array(
                'key'   => 'field_teammate_list',
                'label' => 'Список (по одному в строке)',
                'name'  => 'teammate_list',
                'type'  => 'textarea',
                'rows'  => 3,
            ),
            array(
                'key'   => 'field_teammate_description',
                'label' => 'Описание',
                'name'  => 'teammate_description',
                'type'  => 'textarea',
                'rows'  => 4,
            ),
            array(
                'key'   => 'field_teammate_btn_text',
                'label' => 'Текст кнопки',
                'name'  => 'teammate_btn_text',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_teammate_btn_url',
                'label' => 'Ссылка кнопки',
                'name'  => 'teammate_btn_url',
                'type'  => 'text',
            ),
            array(
                'key'          => 'field_teammate_links',
                'label'        => 'Ссылки',
                'name'         => 'teammate_links',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Добавить ссылку',
                'sub_fields'   => array(
                    array(
                        'key'           => 'field_teammate_link_icon',
                        'label'         => 'Иконка (SVG)',
                        'name'          => 'icon',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'thumbnail',
                    ),
                    array(
                        'key'   => 'field_teammate_link_url',
                        'label' => 'Ссылка',
                        'name'  => 'link',
                        'type'  => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'teammate',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'tolstenko_register_teammate_fields');
