<?php
/**
 * Шапка: верхняя строка (языки, меню, адрес, соцсети, телефоны) и плашка
 * (логотип, «Все услуги», поиск, меню, Telegram, кнопка заявки), плюс мобильное меню.
 *
 * Данные — «Настройки сайта → Контактные данные» (блок «Шапка» и «Телефоны в шапке»),
 * меню — Внешний вид → Меню: header-menu (верхняя строка) и header-service-menu (в плашке).
 */

defined('ABSPATH') || exit;

$cd = tolstenko_get_contact_data();
$logo_img = tolstenko_contact_get_image_attrs($cd['logo_header']);
$theme_uri = get_template_directory_uri();

$header_menu = wp_nav_menu([
    'menu'       => 'header-menu',
    'container'  => false,
    'menu_class' => 'header__menu-list menu__list',
    'fallback_cb' => false,
    'echo'       => false,
]);

$header_service_menu = wp_nav_menu([
    'menu'       => 'header-service-menu',
    'container'  => false,
    'menu_class' => 'header__nav-list menu__list',
    'fallback_cb' => false,
    'echo'       => false,
]);

// Телефоны: список из «Телефонов в шапке», иначе — основной телефон.
$phones = [];
foreach ((array) ($cd['header_phones'] ?? []) as $phone_row) {
    $phones[] = [
        'phone' => (string) $phone_row['phone'],
        'href'  => tolstenko_contact_phone_href($phone_row['phone']),
        'label' => (string) $phone_row['label'],
        'flag'  => !empty($phone_row['flag']) ? tolstenko_contact_get_image_attrs((int) $phone_row['flag']) : [],
    ];
}
if (empty($phones) && trim((string) $cd['phone']) !== '') {
    $phones[] = [
        'phone' => (string) $cd['phone'],
        'href'  => tolstenko_contact_phone_href($cd['phone']),
        'label' => '',
        'flag'  => [],
    ];
}

$main_phone = $phones[0] ?? null;
$phones_title = trim((string) $cd['header_phones_title']) ?: 'Нажмите для вызова';
$address = trim((string) $cd['header_address']);
$hours = trim((string) $cd['header_hours']);
$services_btn = trim((string) $cd['header_services_btn']) ?: 'Все услуги';
$btn_text = trim((string) $cd['header_btn_text']) ?: 'Оставить заявку';
$btn_url = trim((string) $cd['header_btn_url']) ?: '#modal';
$telegram = trim((string) $cd['telegram']);

$arrow_svg = '<svg class="header__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6" /></svg>';
$telegram_svg = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5 3.8 10.2c-.9.4-.9 1.6.1 1.9l4.3 1.4 1.6 5c.3.9 1.4 1.1 2 .4l2.4-2.6 4.3 3.1c.7.5 1.7.1 1.9-.8L23 4.9c.2-1-.8-1.8-1.7-1.4ZM9.4 13.2l8.4-6.1-6.6 7.2-.3 3.1-1.5-4.2Z" /></svg>';

/**
 * Выпадающий список телефонов (верхняя строка и мобильное меню).
 */
$render_phones = static function (array $phones, ?array $main_phone, string $title, string $id) {
    if (!$main_phone) {
        return;
    }
    ?>
    <div class="header__phones" data-header-phones>
        <button class="header__phone" type="button" aria-expanded="false" aria-controls="<?= esc_attr($id); ?>">
            <span><?= esc_html($main_phone['phone']); ?></span>
            <?php if (!empty($main_phone['flag']['url'])) : ?>
                <img class="header__phone-flag" src="<?= esc_url($main_phone['flag']['url']); ?>" alt="<?= esc_attr($main_phone['label']); ?>">
            <?php endif; ?>
        </button>

        <div class="header__phones-list br-20" id="<?= esc_attr($id); ?>" hidden>
            <p class="header__phones-title"><?= esc_html($title); ?></p>

            <?php foreach ($phones as $phone) : ?>
                <a class="header__phones-item" href="tel:<?= esc_attr($phone['href']); ?>">
                    <span class="header__phones-number"><?= esc_html($phone['phone']); ?></span>
                    <?php if ($phone['label'] !== '') : ?>
                        <span class="header__phones-label"><?= esc_html($phone['label']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($phone['flag']['url'])) : ?>
                        <img class="header__phone-flag" src="<?= esc_url($phone['flag']['url']); ?>" alt="">
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
};
?>

<div class="header__top">
    <div class="container">
        <?php get_template_part('modules/lang', null, ['class' => 'header__lang']); ?>

        <?php if ($header_menu) : ?>
            <nav class="header__top-menu menu" aria-label="<?php esc_attr_e('О компании', 'tolstenko-theme'); ?>">
                <?= $header_menu; ?>
            </nav>
        <?php endif; ?>

        <?php if ($address !== '' || $hours !== '') : ?>
            <div class="header__address">
                <?php if ($address !== '') : ?>
                    <span><?= esc_html($address); ?></span>
                <?php endif; ?>
                <?php if ($hours !== '') : ?>
                    <span class="header__hours"><?= esc_html($hours); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="header__socials">
            <?php get_template_part('modules/socials/socials'); ?>
        </div>

        <?php $render_phones($phones, $main_phone, $phones_title, 'header-phones-list'); ?>
    </div>
</div>

<div class="header__bottom">
    <div class="container">
        <div class="header__bar">
            <a class="header__logo logo" href="<?= esc_url(home_url('/')); ?>">
                <?php if ($logo_img['url'] !== '') : ?>
                    <img class="logo__img" src="<?= esc_url($logo_img['url']); ?>" <?php if ($logo_img['srcset']) echo 'srcset="' . esc_attr($logo_img['srcset']) . '"'; ?> alt="<?= esc_attr($logo_img['alt'] ?: get_bloginfo('name')); ?>">
                <?php else : ?>
                    <span class="header__logo-text">Relocate<br>World</span>
                <?php endif; ?>
            </a>

            <button class="header__bottom-service default-btn default-btn--brown" type="button" aria-expanded="false" aria-controls="header-services-panel">
                <svg viewBox="0 0 20 20" aria-hidden="true">
                    <circle cx="4" cy="4" r="1.6" /><circle cx="10" cy="4" r="1.6" /><circle cx="16" cy="4" r="1.6" />
                    <circle cx="4" cy="10" r="1.6" /><circle cx="10" cy="10" r="1.6" /><circle cx="16" cy="10" r="1.6" />
                    <circle cx="4" cy="16" r="1.6" /><circle cx="10" cy="16" r="1.6" /><circle cx="16" cy="16" r="1.6" />
                </svg>
                <span><?= esc_html($services_btn); ?></span>
            </button>

            <div class="header__search header-search">
                <button type="button" class="header__search-btn header__round js-header-search" aria-label="<?php esc_attr_e('Поиск', 'tolstenko-theme'); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5" /><path d="m16 16 4 4" /></svg>
                </button>
                <form class="header-search-form" role="search" method="get" action="<?= esc_url(home_url('/')); ?>">
                    <input type="text" name="s" placeholder="<?php esc_attr_e('Найти', 'tolstenko-theme'); ?>" class="header-search-input">
                    <button type="button" class="header-search-form-close js-header-search-close" aria-label="<?php esc_attr_e('Закрыть поиск', 'tolstenko-theme'); ?>">
                        <img src="<?= esc_url($theme_uri . '/assets/img/promo-notice-close.svg'); ?>" alt="">
                    </button>
                </form>
            </div>

            <?php if ($header_service_menu) : ?>
                <nav class="header__nav" aria-label="<?php esc_attr_e('Основное меню', 'tolstenko-theme'); ?>">
                    <?= $header_service_menu; ?>
                </nav>
            <?php endif; ?>

            <?php if ($telegram !== '') : ?>
                <a class="header__tg header__round" href="<?= esc_url($telegram); ?>" target="_blank" rel="noopener" aria-label="Telegram"><?= $telegram_svg; ?></a>
            <?php endif; ?>

            <a class="header__modal-btn default-btn" href="<?= esc_url($btn_url); ?>">
                <span><?= esc_html($btn_text); ?></span>
                <?= $arrow_svg; ?>
            </a>

            <button class="header__burger" type="button" aria-label="<?php esc_attr_e('Меню', 'tolstenko-theme'); ?>">
                <span></span>
            </button>
        </div>
    </div>
</div>

<div class="header__mobile">
    <div class="header__mobile-inner br-30">
        <?php if ($header_service_menu) : ?>
            <nav class="header__mobile-nav header__nav"><?= $header_service_menu; ?></nav>
        <?php endif; ?>

        <?php if ($header_menu) : ?>
            <nav class="header__mobile-menu"><?= $header_menu; ?></nav>
        <?php endif; ?>

        <?php $render_phones($phones, $main_phone, $phones_title, 'header-mobile-phones-list'); ?>

        <?php if ($address !== '' || $hours !== '') : ?>
            <div class="header__address">
                <?php if ($address !== '') : ?>
                    <span><?= esc_html($address); ?></span>
                <?php endif; ?>
                <?php if ($hours !== '') : ?>
                    <span class="header__hours"><?= esc_html($hours); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="header__mobile-bottom">
            <?php get_template_part('modules/lang', null, ['class' => 'header__lang']); ?>
            <div class="header__socials"><?php get_template_part('modules/socials/socials'); ?></div>
        </div>

        <a class="header__modal-btn default-btn" href="<?= esc_url($btn_url); ?>">
            <span><?= esc_html($btn_text); ?></span>
            <?= $arrow_svg; ?>
        </a>
    </div>
</div>

<?php get_template_part('modules/header-services-panel'); ?>
