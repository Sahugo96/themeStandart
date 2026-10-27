<?php

defined('ABSPATH') || exit;

function theme_enqueue_block_editor_assets(): void
{
    // Плейсхолдеры полей блоков — дефолты на языке редактируемой страницы (inc/settings-i18n.php).
    if (function_exists('theme_settings_set_lang')) {
        theme_settings_set_lang(theme_get_editor_post_lang());
    }

    theme_enqueue_block_editor_assets_localized();

    if (function_exists('theme_settings_set_lang')) {
        theme_settings_set_lang(null);
    }
}

/**
 * Язык редактируемой записи (Polylang): существующая запись или новая (?new_lang=).
 *
 * @return string|null Slug или null — язык по умолчанию.
 */
function theme_get_editor_post_lang(): ?string
{
    // phpcs:disable WordPress.Security.NonceVerification.Recommended -- только чтение параметров экрана.
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    if ($post_id > 0 && function_exists('pll_get_post_language')) {
        $lang = pll_get_post_language($post_id, 'slug');
        if (is_string($lang) && $lang !== '') {
            return $lang;
        }
    }
    if (!empty($_GET['new_lang'])) {
        return sanitize_key(wp_unslash($_GET['new_lang']));
    }
    // phpcs:enable
    return null;
}

function theme_enqueue_block_editor_assets_localized(): void
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
        'main_hero' => function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('main_hero') : [],
        'reviewsSection' => [
            'title'   => $acf_get ? ($acf_get('reviews_title', OPTION_ID) ?: 'Отзывы') : 'Отзывы',
            'postIds' => [],
        ],
        'serviceSection' => [
            'title' => $acf_get ? ($acf_get('service_section_title', OPTION_ID) ?: '') : '',
            'text'  => $acf_get ? ($acf_get('service_section_text', OPTION_ID) ?: '') : '',
        ],
        'servicesSlider' => function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('service_section_filters') : [],
        'servicesSliderSimple' => [
            'title'   => $acf_get ? ($acf_get('service_section_title', OPTION_ID) ?: '') : '',
            'text'    => $acf_get ? ($acf_get('service_section_text', OPTION_ID) ?: '') : '',
            'postIds' => [],
        ],
        'blogSection' => function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('blog_section_filters') : [],
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

