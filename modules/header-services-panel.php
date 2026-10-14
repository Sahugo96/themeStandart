<?php
defined('ABSPATH') || exit;

$cd = tolstenko_get_contact_data();
$menu_items = $cd['header_services_menu'];

if (!is_array($menu_items) || empty($menu_items)) {
    return;
}

if (!function_exists('theme_resolve_service_post_id_from_url')) {
    function theme_resolve_service_post_id_from_url(string $url): int
    {
        $url = trim($url);
        if ($url === '') {
            return 0;
        }

        $path = wp_parse_url($url, PHP_URL_PATH);
        if (!$path) {
            $path = parse_url($url, PHP_URL_PATH);
        }

        $path = trim((string) $path, '/');
        if ($path === '') {
            return 0;
        }

        $segments = array_values(array_filter(explode('/', $path)));
        if (empty($segments)) {
            return 0;
        }

        $slug = (string) end($segments);
        if ($slug === '') {
            return 0;
        }

        $post = get_page_by_path($slug, OBJECT, 'service');
        if ($post instanceof WP_Post) {
            return (int) $post->ID;
        }

        $ids = get_posts([
            'post_type' => 'service',
            'post_status' => 'publish',
            'name' => $slug,
            'posts_per_page' => 1,
            'fields' => 'ids',
        ]);

        return (is_array($ids) && !empty($ids)) ? (int) $ids[0] : 0;
    }
}

$panels = [];

foreach ($menu_items as $row) {
    if (!is_array($row)) {
        continue;
    }

    $rubrika = trim((string) ($row['rubrika'] ?? ''));
    $groups = $row['groups'] ?? [];

    if ($rubrika === '' || !is_array($groups) || empty($groups)) {
        continue;
    }

    $panels[] = [
        'rubrika' => $rubrika,
        'groups' => $groups,
    ];
}

if (!$panels) {
    return;
}

$cta_title = trim((string) $cd['header_services_right_title']);
$cta_text  = trim((string) $cd['header_services_right_text']);
$cta_btn   = $cd['header_services_right_link'];

if ($cta_title === '') {
    $cta_title = 'ПОМОЩЬ С ВЫБОРОМ?';
}

if ($cta_text === '') {
    $cta_text = 'Расскажем, какие задачи решают конкретные продукты и что подойдет именно вам.';
}

if (!is_array($cta_btn) || empty($cta_btn['url'])) {
    $cta_btn = [
        'url' => '#modal',
        'title' => 'СВЯЗАТЬСЯ С НАМИ',
        'target' => '',
    ];
}
?>
<div class="header-services container" id="header-services-panel" hidden>
        <div class="header-services__inner br-30">
            <div class="header-services__tabs" role="tablist" aria-label="Рубрики услуг">
                <?php foreach ($panels as $index => $panel) : ?>
                    <button
                        class="header-services__tab line-caps-bold-13-15<?= $index === 0 ? ' is-active' : ''; ?>"
                        type="button"
                        role="tab"
                        aria-selected="<?= $index === 0 ? 'true' : 'false'; ?>"
                        aria-controls="header-services-tabpanel-<?= esc_attr((string) $index); ?>"
                        data-tab-index="<?= esc_attr((string) $index); ?>"
                    >
                        <?= esc_html((string) $panel['rubrika']); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="header-services__content">
                <?php foreach ($panels as $index => $panel) :
                    $groups = $panel['groups'];
                    $half = (int) ceil(count($groups) / 2);
                    $columns = [
                        array_slice($groups, 0, $half),
                        array_slice($groups, $half),
                    ];
                ?>
                    <div
                        class="header-services__panel<?= $index === 0 ? ' is-active' : ''; ?>"
                        id="header-services-tabpanel-<?= esc_attr((string) $index); ?>"
                        role="tabpanel"
                        data-tab-index="<?= esc_attr((string) $index); ?>"
                        <?= $index === 0 ? '' : 'hidden'; ?>
                    >
                        <div class="header-services__columns">
                            <?php foreach ($columns as $column_groups) : ?>
                                <?php if (!$column_groups) {
                                    continue;
                                } ?>
                                <div class="header-services__column">
                                    <?php foreach ($column_groups as $group) :
                                        if (!is_array($group)) {
                                            continue;
                                        }

                                        $group_title = trim((string) ($group['title'] ?? ''));
                                        $group_services = $group['services'] ?? [];
                                    ?>
                                        <div class="header-services__group">
                                            <?php if ($group_title !== '') : ?>
                                                <div class="header-services__group-title line-caps-bold-13-15">
                                                    <?= esc_html($group_title); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (is_array($group_services) && !empty($group_services)) : ?>
                                                <ul class="header-services__links">
                                                    <?php foreach ($group_services as $service_row) :
                                                        if (!is_array($service_row)) {
                                                            continue;
                                                        }

                                                        $link = $service_row;
                                                        $service_url = is_array($link) ? trim((string) ($link['url'] ?? '')) : '';
                                                        if ($service_url === '') {
                                                            continue;
                                                        }

                                                        $service_title = is_array($link) ? trim((string) ($link['title'] ?? '')) : '';
                                                        if ($service_title === '') {
                                                            $service_title = $service_url;
                                                        }

                                                        $service_id = theme_resolve_service_post_id_from_url($service_url);
                                                        $service_hit = $service_id ? get_field('single_service_hit', $service_id) : null;
                                                        $service_action = $service_id ? get_field('single_service_action', $service_id) : null;

                                                        $show_hit_badge = !empty($service_hit);
                                                        $show_action_percent = !empty($service_hit) && !empty($service_action);
                                                    ?>
                                                        <li class="header-services__item">
                                                            <a class="header-services__link line-13-15" href="<?= esc_url($service_url); ?>">
                                                                <span class="header-services__service-title">
                                                                    <?= esc_html($service_title); ?>
                                                                </span>

                                                                <?php if ($show_hit_badge) : ?>
                                                                    <span class="header-services__hit-badge caption-8-10<?= $show_action_percent ? ' is-has-action' : ''; ?>">
                                                                        ХИТ
                                                                        <?php if ($show_action_percent) : ?>
                                                                            <span class="header-services__hit-action">
                                                                                <?= esc_html((string) $service_action); ?>%
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="header-services__cta">
                <div class="header-services__cta-title line-caps-bold-16-15"><?= esc_html($cta_title); ?></div>
                <p class="header-services__cta-text paragraph-15-25"><?= esc_html($cta_text); ?></p>
                <a
                    class="header-services__cta-btn default-btn line-caps-bold-13-15"
                    href="<?= esc_url($cta_btn['url']); ?>"
                    <?= !empty($cta_btn['target']) ? ' target="' . esc_attr($cta_btn['target']) . '"' : ''; ?>
                >
                    <span><?= esc_html($cta_btn['title']); ?></span>
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M6 14L14 6M14 6H8M14 6V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
</div>
