<?php

defined('ABSPATH') || exit;

/**
 * Секция «Кратко о нас».
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('about')
 * (таб «Секции лендинга → Кратко о нас»). Атрибуты блока имеют приоритет.
 */

$admin = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('about')
    : [];

$admin_stats = is_array($admin['stats'] ?? null) ? $admin['stats'] : [];
$stats = [];
foreach ($admin_stats as $stat) {
    if (!is_array($stat)) {
        continue;
    }
    $stats[] = [
        'num'   => $stat['num'] ?? '',
        'label' => isset($stat['label']) ? tolstenko_landing_text($stat['label']) : '',
    ];
}

$defaults = [
    'subtitle'     => $admin['badge'] ?? '',
    'title'        => $admin['title'] ?? '',
    'title_accent' => $admin['title_accent'] ?? '',
    'text'         => $admin['text'] ?? '',
    'stats'        => $stats,
    'image'        => $admin['image'] ?? 0,
];

$overrides = get_query_var('about_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$stats = isset($data['stats']) && is_array($data['stats']) ? $data['stats'] : [];
$image = tolstenko_contact_get_image_attrs($data['image'] ?? null);

if (empty($image['url'])) {
    $image = ['url' => THEME_PATH . '/assets/img/about.jpg', 'srcset' => '', 'sizes' => '', 'alt' => 'Команда Relocate-World'];
}
?>
<section class="about section">
  <div class="container">
    <div class="about__inner br-30">

      <div class="about__image br-30">
        <img src="<?= $image['url']; ?>" <?php if ($image['srcset']) echo 'srcset="' . $image['srcset'] . '"'; ?> alt="<?= $image['alt']; ?>" loading="lazy">
      </div>

      <div class="about__content">
        <span class="about__badge section-subtitle"><?= $data['subtitle']; ?></span>
        <h2 class="about__title section-title h1">
          <span><?= $data['title_accent']; ?></span>
          <?= $data['title']; ?>
        </h2>

        <div class="about__text">
          <?= $data['text']; ?>
        </div>

        <?php if (!empty($stats)) : ?>
          <ul class="about__stats br-30">
            <?php foreach ($stats as $stat) : ?>
              <li class="about__stat br-20">
                <span class="about__stat-num"><?= $stat['num'] ?? ''; ?></span>
                <span class="about__stat-label"><?= $stat['label'] ?? ''; ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
