<?php

defined('ABSPATH') || exit;

/**
 * Секция «Кратко о нас».
 *
 * Дефолты подставляются, если соответствующий блок на странице не заполнен.
 * Если блок my-theme/about заполнен — данные приходят через query var about_data.
 */

$defaults = [
    'subtitle'    => 'Кратко о нас',
    'title'       => 'исполнитель в DIFC',
    'title_accent' => 'Relocate-World —',
    'text'        => '<p>Мы — лицензированный провайдер в финансовом центре Дубая (DIFC). Не посредники: работаем на земле, напрямую с банками и фризонами, поэтому предлагаем цену ниже рынка и беремся за сложные случаи.</p><p>За каждым клиентом — персональный координатор и команда, которая ведёт процесс от заявки до результата и остаётся на связи после.</p>',
    'stats'       => [
        ['num' => '300+', 'label' => 'клиентов<br>по рекомендациям'],
        ['num' => '6+', 'label' => 'банков-<br>партнёров'],
        ['num' => '6502', 'label' => 'лицензия<br>DIFC'],
        ['num' => '~20', 'label' => 'специалистов<br>в команде'],
    ],
    'image'       => ['url' => THEME_PATH . '/assets/img/about.jpg', 'alt' => 'Команда Relocate-World'],
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
