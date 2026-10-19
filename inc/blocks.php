<?php

defined('ABSPATH') || exit;

define('THEME_BLOCKS_NAMESPACE', 'my-theme');
define('THEME_BLOCKS_CATEGORY', 'tolstenko-general');

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

function theme_get_service_single_block_template(): array
{
    return [
        ['my-theme/faq'],
        ['my-theme/reviews-section'],
    ];
}

function theme_get_blog_single_block_template(): array
{
    return [
        ['my-theme/blog-content'],
        ['my-theme/services-slider-simple'],
        ['my-theme/faq'],
        ['my-theme/blog-related'],
    ];
}

function theme_get_reviews_page_block_template(): array
{
    return [
        ['my-theme/reviews-section'],
        ['my-theme/faq'],
    ];
}

function theme_is_reviews_page(WP_Post $post): bool
{
    return $post->post_type === 'page' && get_page_template_slug($post) === 'page-reviews.php';
}


function theme_get_service_archive_block_template(): array
{
    return [
        ['my-theme/service-section'],
        ['my-theme/documents'],
        ['my-theme/reviews-section'],
        ['my-theme/blog-section'],
        ['my-theme/faq'],
    ];
}

function theme_is_service_archive_page(WP_Post $post): bool
{
    return $post->post_type === 'page' && get_page_template_slug($post) === 'archive-service.php';
}

function theme_get_blog_archive_block_template(): array
{
    return [
        ['my-theme/blog-archive'],
        ['my-theme/faq'],
    ];
}

function theme_is_blog_archive_page(WP_Post $post): bool
{
    return $post->post_type === 'page' && get_page_template_slug($post) === 'archive-blog.php';
}

function theme_get_front_page_block_template(): array
{
    return [
        ['my-theme/result'],
        ['my-theme/compare'],
        ['my-theme/why-us'],
        ['my-theme/infra'],
        ['my-theme/about'],
        ['my-theme/guide'],
        ['my-theme/consult'],
        ['my-theme/hero-stats'],
        ['my-theme/situations'],
        ['my-theme/process'],
        ['my-theme/cost'],
        ['my-theme/blog-more'],
        ['my-theme/documents'],
        ['my-theme/team'],
        ['my-theme/blog-section'],
        ['my-theme/service-section'],
        ['my-theme/faq'],
        ['my-theme/reviews-section'],
    ];
}

function theme_is_front_page(WP_Post $post): bool
{
    if ($post->post_type !== 'page') {
        return false;
    }

    $front_page_id = (int) get_option('page_on_front');

    if ($front_page_id && $post->ID === $front_page_id) {
        return true;
    }

    return get_page_template_slug($post) === 'front-page.php';
}

function theme_filter_service_post_type_args(array $args, string $post_type): array
{
    if ($post_type !== 'service') {
        return $args;
    }

    $args['template'] = theme_get_service_single_block_template();
    $args['template_lock'] = false;

    return $args;
}
add_filter('register_post_type_args', 'theme_filter_service_post_type_args', 10, 2);

function theme_filter_blog_post_type_args(array $args, string $post_type): array
{
    if ($post_type !== 'blog') {
        return $args;
    }

    $args['template'] = theme_get_blog_single_block_template();
    $args['template_lock'] = false;

    return $args;
}
add_filter('register_post_type_args', 'theme_filter_blog_post_type_args', 10, 2);

function theme_filter_page_block_editor_settings(array $settings, $context): array
{
    $post = $context->post ?? null;

    if (!$post instanceof WP_Post || $post->post_type !== 'page' || trim($post->post_content) !== '') {
        return $settings;
    }

    if (theme_is_service_archive_page($post)) {
        $settings['template'] = theme_get_service_archive_block_template();
        $settings['templateLock'] = false;
    } elseif (theme_is_blog_archive_page($post)) {
        $settings['template'] = theme_get_blog_archive_block_template();
        $settings['templateLock'] = false;
    } elseif (theme_is_front_page($post)) {
        $settings['template'] = theme_get_front_page_block_template();
        $settings['templateLock'] = false;
    } elseif (theme_is_reviews_page($post)) {
        $settings['template'] = theme_get_reviews_page_block_template();
        $settings['templateLock'] = false;
    }

    return $settings;
}
add_filter('block_editor_settings_all', 'theme_filter_page_block_editor_settings', 10, 2);



function theme_get_service_page_id(): int
{
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'archive-service.php',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $page_id = $pages ? (int) $pages[0] : 656;

    return $page_id;
}

function theme_get_blog_page_id(): int
{
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'archive-blog.php',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $page_id = $pages ? (int) $pages[0] : 0;

    return $page_id;
}

function theme_get_front_page_id(): int
{
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $front_page_id = (int) get_option('page_on_front');

    if ($front_page_id && get_post_status($front_page_id) === 'publish') {
        $page_id = $front_page_id;

        return $page_id;
    }

    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'front-page.php',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $page_id = $pages ? (int) $pages[0] : 0;

    return $page_id;
}
function theme_get_service_section_data(array $attrs): array
{
    return [
        'title' => ($attrs['title'] ?? '') !== '' ? $attrs['title'] : (get_field('service_section_title', OPTION_ID) ?: ''),
        'text'  => ($attrs['text'] ?? '') !== '' ? $attrs['text'] : (get_field('service_section_text', OPTION_ID) ?: ''),
    ];
}

/**
 * Достаёт ID записей из ACF-поля repeater/relationship.
 *
 * @param mixed $items
 * @return int[]
 */
function theme_extract_post_ids_from_acf_items($items): array
{
    if (!is_array($items) || empty($items)) {
        return [];
    }

    $post_ids = [];

    foreach ($items as $item) {
        if (is_object($item) && isset($item->ID)) {
            $post_ids[] = (int) $item->ID;
        } elseif (is_numeric($item)) {
            $post_ids[] = (int) $item;
        }
    }

    return array_values(array_filter($post_ids));
}

function theme_get_services_slider_data(array $attrs): array
{
    $title = ($attrs['title'] ?? '') !== '' ? $attrs['title'] : (get_field('service_section_title', OPTION_ID) ?: '');
    $text = ($attrs['text'] ?? '') !== '' ? $attrs['text'] : (get_field('service_section_text', OPTION_ID) ?: '');
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    } else {
        $post_ids = theme_extract_post_ids_from_acf_items(get_field('service_section_items', OPTION_ID));
    }

    return [
        'title'    => $title,
        'text'     => $text,
        'post_ids' => $post_ids,
    ];
}

function theme_get_services_slider_simple_data(array $attrs): array
{
    return theme_get_services_slider_data($attrs);
}


function theme_get_blog_section_data(array $attrs): array
{
    return [
        'title' => ($attrs['title'] ?? '') !== '' ? $attrs['title'] : (get_field('blog_section_title', OPTION_ID) ?: ''),
        'text'  => ($attrs['text'] ?? '') !== '' ? $attrs['text'] : (get_field('blog_section_text', OPTION_ID) ?: ''),
    ];
}

function theme_get_blog_slider_data(array $attrs): array
{
    $title = ($attrs['title'] ?? '') !== ''
        ? $attrs['title']
        : (get_field('blog_section_title', OPTION_ID) ?: 'Статьи');
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    }

    return [
        'title'    => $title,
        'post_ids' => $post_ids,
    ];
}

function theme_get_blog_related_data(array $attrs): array
{
    $post_id = get_the_ID() ?: get_queried_object_id();
    $title = ($attrs['title'] ?? '') !== '' ? $attrs['title'] : 'Похожие статьи';
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    } elseif ($post_id && function_exists('get_field')) {
        $post_ids = theme_extract_post_ids_from_acf_items(get_field('blog_articles', $post_id));
    }

    if ($post_id) {
        $post_ids = array_values(array_diff($post_ids, [(int) $post_id]));
    }

    if (empty($post_ids)) {
        $query_args = [
            'post_type'      => 'blog',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'fields'         => 'ids',
        ];

        if ($post_id) {
            $query_args['post__not_in'] = [(int) $post_id];
        }

        $query = new WP_Query($query_args);
        $post_ids = $query->posts;
        wp_reset_postdata();
    }

    return [
        'title'    => $title,
        'post_ids' => $post_ids,
    ];
}


function theme_output_service_page_blocks(): void
{
    $page_id = theme_get_service_page_id();

    if (!$page_id) {
        return;
    }

    $page = get_post($page_id);

    if (!$page instanceof WP_Post) {
        return;
    }

    echo apply_filters('the_content', $page->post_content);
}

function theme_output_blog_page_blocks(): void
{
    $page_id = theme_get_blog_page_id();

    if (!$page_id) {
        return;
    }

    $page = get_post($page_id);

    if (!$page instanceof WP_Post) {
        return;
    }

    echo apply_filters('the_content', $page->post_content);
}

function theme_output_front_page_blocks(): void
{
    $page_id = theme_get_front_page_id();

    if (!$page_id) {
        return;
    }

    $page = get_post($page_id);

    if (!$page instanceof WP_Post) {
        return;
    }

    echo apply_filters('the_content', $page->post_content);
}

function theme_get_posts_for_block_editor(string $post_type): array
{
    $posts = get_posts([
        'post_type'      => $post_type,
        'posts_per_page' => 200,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $items = [];

    foreach ($posts as $post) {
        $items[] = [
            'id'    => $post->ID,
            'label' => $post->post_title,
        ];
    }

    return $items;
}

function theme_get_section_blocks_editor_config(): array
{
    return [
        [
            'name'          => 'my-theme/result',
'defaultsKey'   => 'result',
            'title'         => 'Что вы получаете',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'subtitle', 'label' => 'Надзаголовок', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                [
                    'attr'       => 'items',
                    'label'      => 'Пункты',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить пункт',
                    'itemLabel'  => 'Пункт',
                    'itemFields' => [
                        ['key' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                        ['key' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
        [
            'name'          => 'my-theme/compare',
'defaultsKey'   => 'compare',
            'title'         => 'Сравнение',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'subtitle', 'label' => 'Надзаголовок', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                ['attr' => 'text', 'label' => 'Описание', 'type' => 'textarea'],
                [
                    'attr'       => 'rows',
                    'label'      => 'Строки таблицы',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить строку',
                    'itemLabel'  => 'Строка',
                    'itemFields' => [
                        ['key' => 'criterion', 'label' => 'Критерий', 'type' => 'text'],
                        ['key' => 'self', 'label' => 'Сам', 'type' => 'text'],
                        ['key' => 'middle', 'label' => 'Через посредника', 'type' => 'text'],
                        ['key' => 'direct', 'label' => 'Напрямую с нами', 'type' => 'text'],
                    ],
                ],
                ['attr' => 'foot_text', 'label' => 'Текст под таблицей', 'type' => 'textarea'],
                ['attr' => 'btn_text', 'label' => 'Кнопка', 'type' => 'text'],
            ],
        ],
        [
            'name'          => 'my-theme/why-us',
'defaultsKey'   => 'why_us',
            'title'         => 'Почему именно мы',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'subtitle', 'label' => 'Надзаголовок', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                [
                    'attr'       => 'items',
                    'label'      => 'Пункты',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить пункт',
                    'itemLabel'  => 'Пункт',
                    'itemFields' => [
                        ['key' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                        ['key' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
        [
            'name'          => 'my-theme/infra',
'defaultsKey'   => 'infra',
            'title'         => 'Инфраструктура за пределами РФ',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'subtitle', 'label' => 'Надзаголовок', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                ['attr' => 'text', 'label' => 'Описание', 'type' => 'textarea'],
                ['attr' => 'btn_text', 'label' => 'Кнопка', 'type' => 'text'],
                [
                    'attr'       => 'items',
                    'label'      => 'Пункты',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить пункт',
                    'itemLabel'  => 'Пункт',
                    'itemFields' => [
                        ['key' => 'text', 'label' => 'Текст', 'type' => 'text'],
                    ],
                ],
            ],
        ],
        [
            'name'          => 'my-theme/about',
'defaultsKey'   => 'about',
            'title'         => 'Кратко о нас',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'subtitle', 'label' => 'Надзаголовок', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                ['attr' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
                ['attr' => 'image', 'label' => 'Изображение', 'type' => 'image'],
                [
                    'attr'       => 'stats',
                    'label'      => 'Показатели',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить показатель',
                    'itemLabel'  => 'Показатель',
                    'itemFields' => [
                        ['key' => 'num', 'label' => 'Число', 'type' => 'text'],
                        ['key' => 'label', 'label' => 'Подпись', 'type' => 'text'],
                    ],
                ],
            ],
        ],
        [
            'name'          => 'my-theme/guide',
'defaultsKey'   => 'guide',
            'title'         => 'Подробнее (статья)',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'subtitle', 'label' => 'Надзаголовок', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                [
                    'attr'       => 'tags',
                    'label'      => 'Теги',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить тег',
                    'itemLabel'  => 'Тег',
                    'itemFields' => [
                        ['key' => 'text', 'label' => 'Текст', 'type' => 'text'],
                    ],
                ],
                ['attr' => 'time', 'label' => 'Время чтения', 'type' => 'text'],
                ['attr' => 'views', 'label' => 'Просмотры', 'type' => 'text'],
                ['attr' => 'date_label', 'label' => 'Дата', 'type' => 'text'],
                ['attr' => 'card_title', 'label' => 'Заголовок карточки', 'type' => 'text'],
                ['attr' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
                ['attr' => 'btn_text', 'label' => 'Кнопка', 'type' => 'text'],
                ['attr' => 'image', 'label' => 'Изображение', 'type' => 'image'],
            ],
        ],
        [
            'name'          => 'my-theme/consult',
'defaultsKey'   => 'consult',
            'title'         => 'Бесплатная консультация (CTA)',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'subtitle', 'label' => 'Надзаголовок', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                ['attr' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
                ['attr' => 'contact_label', 'label' => 'Подпись перед телефоном', 'type' => 'text'],
                ['attr' => 'phone', 'label' => 'Телефон', 'type' => 'text'],
                ['attr' => 'input_placeholder', 'label' => 'Плейсхолдер поля', 'type' => 'text'],
                ['attr' => 'btn_text', 'label' => 'Кнопка', 'type' => 'text'],
                [
                    'attr'       => 'consents',
                    'label'      => 'Согласия',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить согласие',
                    'itemLabel'  => 'Согласие',
                    'itemFields' => [
                        ['key' => 'text', 'label' => 'Текст перед ссылкой', 'type' => 'text'],
                        ['key' => 'link_text', 'label' => 'Текст ссылки', 'type' => 'text'],
                        ['key' => 'link_url', 'label' => 'URL ссылки', 'type' => 'text'],
                    ],
                ],
                ['attr' => 'image', 'label' => 'Изображение', 'type' => 'image'],
            ],
        ],
        [
            'name'          => 'my-theme/hero-stats',
'defaultsKey'   => 'hero_stats',
            'title'         => 'Цифры под hero',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                [
                    'attr'       => 'items',
                    'label'      => 'Пункты',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить пункт',
                    'itemLabel'  => 'Пункт',
                    'itemFields' => [
                        ['key' => 'num', 'label' => 'Значение', 'type' => 'text'],
                        ['key' => 'label', 'label' => 'Подпись', 'type' => 'text'],
                    ],
                ],
            ],
        ],
        [
            'name'          => 'my-theme/situations',
'defaultsKey'   => 'situations',
            'title'         => 'Ситуации',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'badge', 'label' => 'Надзаголовок (бейдж)', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                [
                    'attr'       => 'items',
                    'label'      => 'Карточки',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить карточку',
                    'itemLabel'  => 'Карточка',
                    'itemFields' => [
                        ['key' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                        ['key' => 'text', 'label' => 'Текст (можно <span>)', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
        [
            'name'          => 'my-theme/process',
'defaultsKey'   => 'process',
            'title'         => 'Как проходит работа',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'badge', 'label' => 'Надзаголовок (бейдж)', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                ['attr' => 'image', 'label' => 'Изображение', 'type' => 'image'],
                [
                    'attr'       => 'items',
                    'label'      => 'Шаги',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить шаг',
                    'itemLabel'  => 'Шаг',
                    'itemFields' => [
                        ['key' => 'title', 'label' => 'Название шага', 'type' => 'text'],
                        ['key' => 'text', 'label' => 'Описание (HTML)', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
        [
            'name'          => 'my-theme/cost',
'defaultsKey'   => 'cost',
            'title'         => 'Стоимость',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'badge', 'label' => 'Надзаголовок (бейдж)', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                ['attr' => 'lead', 'label' => 'Текст под заголовком', 'type' => 'textarea'],
                [
                    'attr'       => 'prices',
                    'label'      => 'Цены',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить цену',
                    'itemLabel'  => 'Цена',
                    'itemFields' => [
                        ['key' => 'name', 'label' => 'Услуга', 'type' => 'text'],
                        ['key' => 'value', 'label' => 'Значение (HTML)', 'type' => 'text'],
                    ],
                ],
                ['attr' => 'card_title', 'label' => 'Заголовок карточки (HTML)', 'type' => 'textarea'],
                ['attr' => 'card_text', 'label' => 'Текст карточки', 'type' => 'textarea'],
                ['attr' => 'btn_text', 'label' => 'Кнопка', 'type' => 'text'],
                ['attr' => 'image', 'label' => 'Изображение', 'type' => 'image'],
            ],
        ],
        [
            'name'          => 'my-theme/blog-more',
'defaultsKey'   => 'blog_more',
            'title'         => 'Кнопка «Перейти в блог»',
            'hint'          => 'Если пусто — из админки: Дефолты блоков → Секции лендинга',
            'color'         => '#2271b1',
            'fields'        => [
                ['attr' => 'text', 'label' => 'Текст кнопки', 'type' => 'text'],
                ['attr' => 'url', 'label' => 'Ссылка', 'type' => 'text'],
            ],
        ],
        [
            'name'          => 'my-theme/team',
            'title'         => 'Команда',
            'hint'          => 'Карточки — из записей «Команда» (CPT teammate). Заголовок/текст: если пусто — из админки',
            'color'         => '#2271b1',
            'defaultsKey'   => 'team',
            'fields'        => [
                ['attr' => 'badge', 'label' => 'Надзаголовок (бейдж)', 'type' => 'text'],
                ['attr' => 'title', 'label' => 'Заголовок (HTML, акцент — <span>)', 'type' => 'text'],
                ['attr' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
            ],
        ],
        [
            'name'          => 'my-theme/service-section',
            'title'         => 'Архив услуг',
            'hint'          => 'Заголовок и текст — из блока или настроек темы. Выводятся все услуги',
            'color'         => '#2271b1',
            'hasTextFields' => false,
        ],
        [
            'name'          => 'my-theme/services-slider',
            'title'         => 'Слайдер услуг',
            'hint'          => 'Заголовок, текст и выбор услуг — из блока или настроек темы. С AJAX-фильтром',
            'color'         => '#F7A800',
            'hasTextFields' => false,
        ],
        [
            'name'          => 'my-theme/services-slider-simple',
            'title'         => 'Слайдер услуг (без фильтра)',
            'hint'          => 'Простой слайдер услуг без фильтра по категориям',
            'color'         => '#2271b1',
            'hasTextFields' => false,
        ],
        [
            'name'          => 'my-theme/blog-section',
            'title'         => 'Секция статей',
            'hint'          => 'Заголовок и текст — из блока или настроек темы. Слайдер с AJAX-фильтром',
            'color'         => '#2271b1',
            'hasTextFields' => false,
        ],
        [
            'name'           => 'my-theme/blog-archive',
            'title'          => 'Архив блога',
            'hint'           => 'Сетка статей с фильтром по рубрикам и пагинацией. Заголовок — из настроек темы',
            'color'          => '#27AE60',
            'hasTextFields'  => false,
        ],
        [
            'name'          => 'my-theme/blog-content',
            'title'         => 'Контент статьи',
            'hint'          => 'Текст статьи и сайдбар из ACF текущей записи',
            'color'         => '#2271b1',
            'hasTextFields' => false,
        ],
        [
            'name'          => 'my-theme/blog-related',
            'title'         => 'Похожие статьи',
            'hint'          => 'Слайдер статей из ACF текущей записи (вкладка «Похожие статьи»)',
            'color'         => '#27AE60',
            'hasTextFields' => false,
        ],
    ];
}

function theme_enqueue_block_editor_assets(): void
{
    $controls_js = get_template_directory() . '/assets/js/block-controls.js';
    $blocks_js = get_template_directory() . '/assets/js/blocks.js';
    $section_blocks_js = get_template_directory() . '/assets/js/section-blocks.js';

    if (!is_readable($controls_js) || !is_readable($blocks_js)) {
        return;
    }

    wp_enqueue_script(
        'my-theme-block-controls',
        get_template_directory_uri() . '/assets/js/block-controls.js',
        ['wp-element', 'wp-components', 'wp-block-editor'],
        filemtime($controls_js),
        true
    );

    wp_enqueue_script(
        'my-theme-blocks',
        get_template_directory_uri() . '/assets/js/blocks.js',
        ['my-theme-block-controls', 'wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-data', 'editor'],
        filemtime($blocks_js),
        true
    );

    if (is_readable($section_blocks_js)) {
        wp_enqueue_script(
            'my-theme-section-blocks',
            get_template_directory_uri() . '/assets/js/section-blocks.js',
            ['my-theme-blocks', 'wp-blocks', 'wp-element', 'wp-block-editor'],
            filemtime($section_blocks_js),
            true
        );

        wp_localize_script('my-theme-section-blocks', 'themeSimpleSectionBlocks', theme_attach_block_categories_to_editor_config(theme_get_section_blocks_editor_config()));

        $section_defaults = array();

        if (function_exists('tolstenko_get_block_defaults')) {
            foreach (theme_get_section_blocks_editor_config() as $section_block) {
                if (empty($section_block['defaultsKey'])) {
                    continue;
                }

                $section_key = $section_block['defaultsKey'];
                $section_data = tolstenko_get_block_defaults($section_key);

                // В схеме поле может называться badge/lead, а в блоке — subtitle/text.
                if (!isset($section_data['subtitle']) && isset($section_data['badge'])) {
                    $section_data['subtitle'] = $section_data['badge'];
                }

                if (!isset($section_data['text']) && isset($section_data['lead'])) {
                    $section_data['text'] = $section_data['lead'];
                }

                $section_defaults[$section_key] = $section_data;
            }
        }

        wp_localize_script('my-theme-section-blocks', 'themeSectionBlockDefaults', $section_defaults);
    }

    $acf_get = function_exists('get_field') ? 'get_field' : null;

    wp_localize_script('my-theme-blocks', 'themeBlockDefaults', [
        'faq' => function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('faq') : [],
        'documents' => function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('documents') : [],
        'reviewsSection' => [
            'title'   => $acf_get ? ($acf_get('reviews_title', OPTION_ID) ?: 'Отзывы') : 'Отзывы',
            'postIds' => [],
        ],
        'serviceSection' => [
            'title' => $acf_get ? ($acf_get('service_section_title', OPTION_ID) ?: '') : '',
            'text'  => $acf_get ? ($acf_get('service_section_text', OPTION_ID) ?: '') : '',
        ],
        'servicesSlider' => [
            'title'   => $acf_get ? ($acf_get('service_section_title', OPTION_ID) ?: '') : '',
            'text'    => $acf_get ? ($acf_get('service_section_text', OPTION_ID) ?: '') : '',
            'postIds' => [],
        ],
        'blogSection' => [
            'title' => $acf_get ? ($acf_get('blog_section_title', OPTION_ID) ?: '') : '',
            'text'  => $acf_get ? ($acf_get('blog_section_text', OPTION_ID) ?: '') : '',
        ],
        'posts' => [
            'review'  => theme_get_posts_for_block_editor('review'),
            'service' => theme_get_posts_for_block_editor('service'),
            'blog'    => theme_get_posts_for_block_editor('blog'),
        ],
    ]);
}
add_action('enqueue_block_editor_assets', 'theme_enqueue_block_editor_assets');

/**
 * Стили превью холста редактора (внутрь iframe, не в админ-оболочку).
 */
function theme_block_editor_canvas_styles(array $settings): array
{
    $settings['styles'] = $settings['styles'] ?? [];
    $settings['styles'][] = [
        'css' => <<<'CSS'
html body .block-editor-block-list__layout.is-root-container > :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
	margin-left: max(15px, calc(50% - 640px)) !important;
	margin-right: max(15px, calc(50% - 640px)) !important;
}
CSS,
    ];

    return $settings;
}
add_filter('block_editor_settings_all', 'theme_block_editor_canvas_styles');

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

function theme_get_faq_section_data(array $attrs): array
{
    // Дефолты — из админки: tolstenko_get_block_defaults('faq')
    // (таб «Дефолты блоков → FAQ»). Атрибуты блока имеют приоритет.
    $defaults = function_exists('tolstenko_get_block_defaults')
        ? tolstenko_get_block_defaults('faq')
        : [];

    $items = !empty($attrs['items']) && is_array($attrs['items'])
        ? $attrs['items']
        : (is_array($defaults['items'] ?? null) ? $defaults['items'] : []);

    return [
        'badge'      => (string) (($attrs['badge'] ?? '') !== '' ? $attrs['badge'] : ($defaults['badge'] ?? '')),
        'title'      => (string) (($attrs['title'] ?? '') !== '' ? $attrs['title'] : ($defaults['title'] ?? '')),
        'items'      => $items,
        'form_title' => (string) (($attrs['form_title'] ?? '') !== '' ? $attrs['form_title'] : ($defaults['form_title'] ?? '')),
        'form_text'  => (string) (($attrs['form_text'] ?? '') !== '' ? $attrs['form_text'] : ($defaults['form_text'] ?? '')),
    ];
}



function theme_block_image_to_attribute($image): array
{
    if (!is_array($image) || empty($image)) {
        return ['id' => 0, 'url' => '', 'alt' => ''];
    }

    $id = (int) ($image['ID'] ?? $image['id'] ?? 0);

    return [
        'id'  => $id,
        'url' => $image['url'] ?? ($id ? (string) wp_get_attachment_url($id) : ''),
        'alt' => $image['alt'] ?? '',
    ];
}

function theme_block_attribute_to_acf_image(?array $image): ?array
{
    if (empty($image) || !is_array($image)) {
        return null;
    }

    $id = (int) ($image['id'] ?? $image['ID'] ?? 0);

    if ($id > 0) {
        $acf_image = function_exists('acf_get_attachment') ? acf_get_attachment($id) : null;

        if (is_array($acf_image) && !empty($acf_image)) {
            return $acf_image;
        }

        return [
            'ID'  => $id,
            'url' => $image['url'] ?? (string) wp_get_attachment_url($id),
            'alt' => $image['alt'] ?? '',
        ];
    }

    if (!empty($image['url'])) {
        return [
            'ID'  => 0,
            'url' => $image['url'],
            'alt' => $image['alt'] ?? '',
        ];
    }

    return null;
}

function theme_block_string_attr(array $attrs, string $key, string $option_key): string
{
    $value = $attrs[$key] ?? '';

    if ($value !== '') {
        return (string) $value;
    }

    return (string) (get_field($option_key, OPTION_ID) ?: '');
}

function theme_block_bool_attr(array $attrs, string $key, string $option_key): bool
{
    if (array_key_exists($key, $attrs) && $attrs[$key] !== '' && $attrs[$key] !== null) {
        return (bool) $attrs[$key];
    }

    $option_value = get_field($option_key, OPTION_ID);

    if ($option_value !== null && $option_value !== '') {
        return (bool) $option_value;
    }

    return false;
}

function theme_block_items_attr(array $attrs, string $key, string $option_key): array
{
    $items = $attrs[$key] ?? null;

    if (is_array($items) && !empty($items)) {
        return $items;
    }

    $option_items = get_field($option_key, OPTION_ID);

    return is_array($option_items) ? $option_items : [];
}

function theme_normalize_block_link($link): array
{
    if (!is_array($link)) {
        return ['url' => '', 'title' => '', 'target' => ''];
    }

    return [
        'url'    => isset($link['url']) ? (string) $link['url'] : '',
        'title'  => isset($link['title']) ? (string) $link['title'] : '',
        'target' => isset($link['target']) ? (string) $link['target'] : '',
    ];
}

function theme_block_link_attr(array $attrs, string $key, string $option_key): array
{
    $override = $attrs[$key] ?? null;

    if (is_array($override) && (!empty($override['url']) || !empty($override['title']))) {
        return theme_normalize_block_link($override);
    }

    return theme_normalize_block_link(get_field($option_key, OPTION_ID));
}

function theme_get_reviews_section_data(array $attrs, $section = null): array
{
    if ($section && $section !== true && !empty($section['reviews_rewrite'])) {
        return [
            'title'             => $section['reviews_title'] ?? '',
            'reviews_list'      => is_array($section['reviews_list'] ?? null) ? $section['reviews_list'] : [],
            'reviews_list_hide' => !empty($section['reviews_list_hide']),
            'reviews'           => is_array($section['reviews_reviews'] ?? null) ? $section['reviews_reviews'] : [],
        ];
    }

    $title = trim((string) ($attrs['title'] ?? ''));
    $post_ids = [];

    if (!empty($attrs['postIds']) && is_array($attrs['postIds'])) {
        $post_ids = array_values(array_filter(array_map('intval', $attrs['postIds'])));
    }

    $reviews = [];

    if (!empty($post_ids)) {
        foreach ($post_ids as $post_id) {
            $post = get_post($post_id);

            if ($post instanceof WP_Post) {
                $reviews[] = $post;
            }
        }
    } else {
        $fallback = get_field('reviews_review', OPTION_ID);
        $reviews = is_array($fallback) ? $fallback : [];
    }

    return [
        'title'             => $title !== '' ? $title : (get_field('reviews_title', OPTION_ID) ?: 'Отзывы'),
        'reviews_list'      => get_field('reviews_list', OPTION_ID) ?: [],
        'reviews_list_hide' => (bool) get_field('reviews_list_hide', OPTION_ID),
        'reviews'           => $reviews,
    ];
}


