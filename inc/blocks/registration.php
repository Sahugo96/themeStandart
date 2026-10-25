<?php

defined('ABSPATH') || exit;

/**
 * Подгруппы блоков в inserter (как в аудите блоков).
 *
 * @return array<int, array{slug: string, title: string}>
 */
function theme_get_block_inserter_categories(): array
{
    return [
        [
            'slug'  => 'tolstenko-general',
            'title' => 'TM: Главная / общие секции',
        ],
        [
            'slug'  => 'tolstenko-blog',
            'title' => 'TM: Блог',
        ],
        [
            'slug'  => 'tolstenko-services',
            'title' => 'TM: Услуги / кейсы',
        ],
        [
            'slug'  => 'tolstenko-reviews',
            'title' => 'TM: Отзывы',
        ],
    ];
}

/**
 * slug папки блока → категория inserter.
 *
 * @return array<string, string>
 */
function theme_get_block_category_map(): array
{
    return [
        // Главная / общие секции
        'main-hero'              => 'tolstenko-general',
        'result'                 => 'tolstenko-general',
        'compare'                => 'tolstenko-general',
        'why-us'                 => 'tolstenko-general',
        'infra'                  => 'tolstenko-general',
        'about'                  => 'tolstenko-general',
        'guide'                  => 'tolstenko-general',
        'consult'                => 'tolstenko-general',
        'hero-stats'             => 'tolstenko-general',
        'situations'             => 'tolstenko-general',
        'process'                => 'tolstenko-general',
        'cost'                   => 'tolstenko-general',
        'blog-more'              => 'tolstenko-general',
        'documents'           => 'tolstenko-general',
        'team'                  => 'tolstenko-general',
        'cases'                 => 'tolstenko-general',
        'programs'              => 'tolstenko-general',
        'banks'                 => 'tolstenko-general',
        'flagship'              => 'tolstenko-general',
        'europe'                => 'tolstenko-general',
        'quiz'                  => 'tolstenko-general',
        'faq'                    => 'tolstenko-general',
        'field-template'         => 'tolstenko-general',
        'hidden-block'           => 'tolstenko-general',

        // Блог
        'blog-archive'           => 'tolstenko-blog',
        'blog-section'           => 'tolstenko-blog',
        'blog-slider'            => 'tolstenko-blog',
        'blog-content'           => 'tolstenko-blog',
        'single-blog'            => 'tolstenko-blog',
        'blog-related'           => 'tolstenko-blog',

        // Услуги / кейсы
        'services-hero'          => 'tolstenko-services',
        'services-list'          => 'tolstenko-services',
        'services-calc'          => 'tolstenko-services',
        'service-section'        => 'tolstenko-services',
        'services-slider'        => 'tolstenko-services',
        'services-slider-simple' => 'tolstenko-services',


        // Отзывы
        'reviews-section'        => 'tolstenko-reviews',
        'reviews-slider'         => 'tolstenko-reviews',
    ];
}

function theme_get_block_category_for_slug(string $slug): string
{
    $map = theme_get_block_category_map();

    return $map[$slug] ?? THEME_BLOCKS_CATEGORY;
}

function theme_get_block_category_for_name(string $block_name): string
{
    $prefix = THEME_BLOCKS_NAMESPACE . '/';

    if (strpos($block_name, $prefix) === 0) {
        return theme_get_block_category_for_slug(substr($block_name, strlen($prefix)));
    }

    return THEME_BLOCKS_CATEGORY;
}

/**
 * Добавляет category в конфиг редактора (section-blocks.js).
 *
 * @param array<int, array<string, mixed>> $blocks
 * @return array<int, array<string, mixed>>
 */
function theme_attach_block_categories_to_editor_config(array $blocks): array
{
    foreach ($blocks as $index => $block) {
        $blocks[$index]['category'] = theme_get_block_category_for_name((string) ($block['name'] ?? ''));
    }

    return $blocks;
}

add_filter('block_categories_all', function (array $categories): array {
    return array_merge(theme_get_block_inserter_categories(), $categories);
});

function theme_register_blocks(): void
{
    $blocks_dir = get_template_directory() . '/blocks';

    foreach (glob($blocks_dir . '/*', GLOB_ONLYDIR) ?: [] as $block_dir) {
        if (!is_readable($block_dir . '/block.json')) {
            continue;
        }

        $slug = basename($block_dir);

        register_block_type($block_dir, [
            'category' => theme_get_block_category_for_slug($slug),
        ]);
    }
}
add_action('init', 'theme_register_blocks');

/**
 * В редакторе оставляем только кастомные блоки темы (my-theme/*).
 */
function theme_allowed_block_types($allowed_block_types, $editor_context)
{
    $allowed = [];

    foreach (WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $block) {
        if (strpos($name, THEME_BLOCKS_NAMESPACE . '/') === 0) {
            $allowed[] = $name;
        }
    }

    // Нужны для InnerBlocks в «Скрытый блок» (SEO-редактор).
    $allowed = array_merge($allowed, [
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/quote',
        'core/html',
    ]);

    return array_values(array_unique($allowed));
}
add_filter('allowed_block_types_all', 'theme_allowed_block_types', 10, 2);

/**
 * Обычный текст редактора (не my-theme/*) на статьях и акциях
 * оборачиваем в .container, чтобы не ломать сетку между секциями.
 */
function theme_wrap_non_theme_blocks_in_container(string $block_content, array $block): string
{
    if (is_admin() || trim($block_content) === '') {
        return $block_content;
    }

    if (!is_singular(['blog'])) {
        return $block_content;
    }

    $name = $block['blockName'] ?? null;

    if (is_string($name) && strpos($name, THEME_BLOCKS_NAMESPACE . '/') === 0) {
        return $block_content;
    }

    $has_media = (bool) preg_match('/<(?:img|iframe|video|figure|svg)\b/i', $block_content);

    if (!$has_media && trim(wp_strip_all_tags($block_content)) === '') {
        return $block_content;
    }

    return '<div class="container"><div class="redactor">' . $block_content . '</div></div>';
}
add_filter('render_block', 'theme_wrap_non_theme_blocks_in_container', 10, 2);

