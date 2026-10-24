<?php

defined('ABSPATH') || exit;

function theme_render_breadcrumb(): void
{
    static $rendered = false;

    if ($rendered) {
        return;
    }

    $rendered = true;
    get_template_part('modules/breadcrumb/breadcrumb');
}

/**
 * Мержит дефолты секции с данными из блока.
 * Заполненные значения перекрывают дефолт; пустые строки/массивы — нет.
 *
 * @param array $defaults  Дефолтные данные секции.
 * @param array $overrides Данные из атрибутов блока.
 * @return array
 */
/**
 * Текст секции для вывода как HTML.
 *
 * Значение из редактора/дефолтов может быть как готовым HTML (<p>, <em>…),
 * так и plain-text с переносами строк (старые значения из textarea).
 * Во втором случае переносы превращаются в настоящие абзацы.
 *
 * @param mixed $value Значение поля.
 * @return string
 */
function theme_section_text_html($value): string
{
    $value = (string) $value;

    if (trim($value) === '') {
        return '';
    }

    if (preg_match('/<(p|div|ul|ol|h[1-6]|blockquote|table|figure)\b/i', $value)) {
        return $value;
    }

    return function_exists('wpautop') ? wpautop($value) : nl2br(esc_html($value));
}

function theme_section_merge_defaults(array $defaults, array $overrides): array
{
    foreach ($overrides as $key => $value) {
        if (is_array($value)) {
            if (!empty($value)) {
                $defaults[$key] = $value;
            }

            continue;
        }

        if ($value !== '' && $value !== null) {
            $defaults[$key] = $value;
        }
    }

    return $defaults;
}

/**
 * Выводит секцию фронта.
 *
 * Если на текущей странице есть соответствующий Gutenberg-блок (my-theme/<slug>),
 * он уже выведен через the_content — тогда ничего не делаем.
 * Иначе подставляются дефолты секции (pages/sections/<slug>.php).
 */
function theme_render_front_section(string $slug): void
{
    $block_name = 'my-theme/' . $slug;

    $post_id = is_front_page() ? theme_get_front_page_id() : (int) get_queried_object_id();
    $post = $post_id ? get_post($post_id) : null;

    if ($post instanceof WP_Post && has_block($block_name, $post)) {
        return;
    }

    get_template_part('pages/sections/' . $slug);
}

