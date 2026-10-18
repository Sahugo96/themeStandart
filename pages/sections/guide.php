<?php

defined('ABSPATH') || exit;

/**
 * Секция «Подробнее» (статья-гид).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('guide')
 * (таб «Секции лендинга → Подробнее»): subtitle, title, post_id.
 * Если выбрана статья (post_id) — карточка собирается из записи,
 * иначе используются статичные дефолты (перекрываются атрибутами блока).
 */

$admin = function_exists('tolstenko_get_block_defaults')
    ? tolstenko_get_block_defaults('guide')
    : [];

$static = [
    'tags'       => [['text' => 'Счета'], ['text' => 'ОАЭ']],
    'time'       => '10 мин',
    'views'      => '234',
    'date'       => '2026-07-19',
    'date_label' => '19 июля 2026',
    'card_title' => 'Почему ОАЭ',
    'text'       => '<p>Объединённые Арабские Эмираты — одна из самых устойчивых финансовых юрисдикций мира с нулевым личным подоходным налогом и развитой банковской системой под контролем Центрального банка ОАЭ. Резидентский статус открывает доступ к международным сервисам, а компания во фризоне позволяет вести бизнес со 100% иностранным владением.</p><p>Relocate-World помогает пройти этот путь без ошибок: подбираем банк и программу под ваш профиль, готовим документы под требования комплаенса и сопровождаем до результата.</p>',
    'btn_text'   => 'Читать полностью',
    'image'      => ['url' => THEME_PATH . '/assets/img/guide.jpg', 'alt' => 'Почему ОАЭ'],
];

// Если в админке выбрана статья — берём данные карточки из записи.
$post_id = (int) ($admin['post_id'] ?? 0);
if ($post_id > 0 && ($guide_post = get_post($post_id))) {
    $static['card_title'] = get_the_title($guide_post);
    $static['date_label'] = get_the_date('j F Y', $guide_post);
    $static['date']       = get_the_date('Y-m-d', $guide_post);

    $excerpt = get_the_excerpt($guide_post);
    if (is_string($excerpt) && $excerpt !== '') {
        $static['text'] = '<p>' . $excerpt . '</p>';
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    if ($thumb_id) {
        $static['image'] = (int) $thumb_id;
    }
}

$defaults = array_merge($static, [
    'subtitle'     => $admin['subtitle'] ?? '',
    'title'        => $admin['title'] ?? '',
]);

$overrides = get_query_var('guide_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$tags = isset($data['tags']) && is_array($data['tags']) ? $data['tags'] : [];
$image = tolstenko_contact_get_image_attrs($data['image'] ?? null);

if (empty($image['url'])) {
    $image = ['url' => THEME_PATH . '/assets/img/guide.jpg', 'srcset' => '', 'sizes' => '', 'alt' => 'Почему ОАЭ'];
}

?>
<section class="guide section">
  <div class="container">
    <div class="guide__top">
      <span class="guide__badge"><?= $data['subtitle']; ?></span>
      <h2 class="guide__title"><?= $data['title']; ?></h2>
    </div>

    <article class="guide__card" data-read-more>
      <div class="guide__content">

        <div class="guide__meta">
          <?php if (!empty($tags)) : ?>
            <ul class="guide__tags">
              <?php foreach ($tags as $tag) : ?>
                <li class="guide__tag"><?= $tag['text'] ?? ''; ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <ul class="guide__info">
            <?php if (!empty($data['time'])) : ?>
              <li class="guide__info-item">
                <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <circle cx="12" cy="12" r="9"/>
                  <path d="M12 7v5l3 2"/>
                </svg>
                <?= $data['time']; ?>
              </li>
            <?php endif; ?>
            <?php if (!empty($data['views'])) : ?>
              <li class="guide__info-item">
                <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                <?= $data['views']; ?>
              </li>
            <?php endif; ?>
            <?php if (!empty($data['date_label'])) : ?>
              <li class="guide__info-item">
                <time datetime="<?= esc_attr($data['date']); ?>"><?= $data['date_label']; ?></time>
                <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <rect x="3" y="5" width="18" height="16" rx="2"/>
                  <path d="M3 10h18M8 3v4M16 3v4"/>
                </svg>
              </li>
            <?php endif; ?>
          </ul>
        </div>

        <h3 class="guide__card-title"><?= $data['card_title']; ?></h3>

        <div class="guide__text">
          <?= $data['text']; ?>

          <div class="guide__more">
            <!-- Продолжение статьи: показывается по кнопке «Читать полностью» -->
          </div>
        </div>

        <button class="guide__btn" type="button" aria-expanded="false" data-read-more-btn>
          <span data-read-more-label><?= $data['btn_text']; ?></span>
          <svg class="guide__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>

      </div>

      <div class="guide__image">
        <img src="<?= $image['url']; ?>" <?php if ($image['srcset']) echo 'srcset="' . $image['srcset'] . '"'; ?> alt="<?= $image['alt']; ?>" loading="lazy">
      </div>
    </article>
  </div>
</section>
