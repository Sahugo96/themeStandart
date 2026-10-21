<?php

defined('ABSPATH') || exit;

/**
 * Секция «Инфраструктура за пределами РФ».
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('infra')
 * (таб «Секции лендинга → Для клиентов с капиталом и бизнесом»).
 * Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('infra')
    : [];

$defaults = [
    'subtitle'     => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'text'         => $admin['text'] ?? '',
    'btn_text'     => $admin['btn_text'] ?? '',
    'btn_link'     => ['url' => $admin['btn_url'] ?? '', 'title' => $admin['btn_text'] ?? '', 'target' => ''],
    'items'        => is_array($admin['items'] ?? null) ? $admin['items'] : [],
];

$overrides = get_query_var('infra_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = isset($data['items']) && is_array($data['items']) ? array_values($data['items']) : [];

if (empty($items)) {
    return;
}

$btn_link = isset($data['btn_link']) && is_array($data['btn_link']) ? $data['btn_link'] : ['url' => '', 'title' => '', 'target' => ''];
$btn_url = $btn_link['url'] ?? '';

$half = (int) ceil(count($items) / 2);
$lists = array_chunk($items, $half);

// Текст выводится как HTML: если абзацев нет (старое значение из textarea),
// превращаем переносы строк в абзацы, чтобы форматирование не терялось.
$text_html = (string) ($data['text'] ?? '');

if ($text_html !== '' && !preg_match('/<(p|div|ul|ol|h[1-6]|blockquote|table)\b/i', $text_html)) {
    $text_html = function_exists('wpautop') ? wpautop($text_html) : nl2br(esc_html($text_html));
}
?>
<section class="infra section">
    <div class="container">
        <div class="infra__inner br-30">

            <div class="infra__left">
                <span class="infra__badge section-subtitle"><?= $data['subtitle']; ?></span>
                <h2 class="infra__title section-title"><?= $data['title']; ?></h2>
                <?php if (trim($text_html) !== '') : ?>
                    <div class="infra__text"><?= $text_html; ?></div>
                <?php endif; ?>
                <?php if ($btn_url !== '' || !empty($data['btn_text'])) : ?>
                    <a class="infra__btn default-btn default-btn--brown" href="<?= esc_url($btn_url !== '' ? $btn_url : '#'); ?>">
                        <span><?= $data['btn_text']; ?></span>
                        <svg class="infra__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <div class="infra__right">
                <?php foreach ($lists as $list) : ?>
                    <ul class="infra__list">
                        <?php foreach ($list as $item) : ?>
                            <li class="infra__list-item reg-par-14-20"><?= $item['text'] ?? ''; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
