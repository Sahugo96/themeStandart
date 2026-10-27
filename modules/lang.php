<?php
/**
 * Переключатель языков (шапка, мобильное меню).
 *
 * Языки — из Polylang: текущий подсвечен, остальные ведут на перевод текущей страницы
 * (GET-параметры сохраняются). Без Polylang выводится только текущий язык.
 *
 * @var array $args {
 *   @type string $class Дополнительный класс обёртки.
 * }
 */

defined('ABSPATH') || exit;

// Короткие подписи по slug языка, как в макете.
$lang_labels = [
    'ru' => 'Ру',
    'en' => 'Eng',
];

$lang_items = [];

if (function_exists('pll_the_languages')) {
    $translations = pll_the_languages(['raw' => 1, 'hide_if_empty' => 0, 'hide_if_no_translation' => 0]);
    $query_string = !empty($_GET) ? '?' . http_build_query(wp_unslash($_GET)) : '';

    foreach ((array) $translations as $slug => $translation) {
        $is_current = !empty($translation['current_lang']);

        $lang_items[] = [
            'label'   => $lang_labels[$slug] ?? ucfirst((string) $slug),
            'url'     => $is_current ? '' : (string) ($translation['url'] ?? '') . $query_string,
            'current' => $is_current,
            'locale'  => (string) ($translation['locale'] ?? $slug),
        ];
    }
} else {
    $current_slug = substr((string) get_locale(), 0, 2);

    $lang_items[] = [
        'label'   => $lang_labels[$current_slug] ?? ucfirst($current_slug),
        'url'     => '',
        'current' => true,
        'locale'  => (string) get_locale(),
    ];
}

if (empty($lang_items)) {
    return;
}

$lang_class = trim('lang ' . (string) ($args['class'] ?? ''));
?>
<div class="<?= esc_attr($lang_class); ?>">
    <?php foreach ($lang_items as $lang_item) : ?>
        <?php if ($lang_item['current'] || $lang_item['url'] === '') : ?>
            <span class="lang__item<?= $lang_item['current'] ? ' is-current' : ''; ?>" aria-current="<?= $lang_item['current'] ? 'true' : 'false'; ?>"><?= esc_html($lang_item['label']); ?></span>
        <?php else : ?>
            <a class="lang__item" href="<?= esc_url($lang_item['url']); ?>" hreflang="<?= esc_attr(str_replace('_', '-', $lang_item['locale'])); ?>"><?= esc_html($lang_item['label']); ?></a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
