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

// Дефолты: значения из таба «Дефолты блоков → Подробнее», иначе — статичный фолбэк.
$defaults = array_merge($static, $admin);

$defaults['subtitle'] = $admin['subtitle'] ?? '';
$defaults['title']    = $admin['title'] ?? '';

// Если в админке выбрана статья — карточка собирается из записи и перекрывает дефолты.
$post_id = (int) ($admin['post_id'] ?? 0);
if ($post_id > 0 && ($guide_post = get_post($post_id))) {
    $defaults['card_title'] = get_the_title($guide_post);
    $defaults['date_label'] = get_the_date('j F Y', $guide_post);
    $defaults['date']       = get_the_date('Y-m-d', $guide_post);

    $excerpt = get_the_excerpt($guide_post);
    if (is_string($excerpt) && $excerpt !== '') {
        $defaults['text'] = '<p>' . $excerpt . '</p>';
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    if ($thumb_id) {
        $defaults['image'] = (int) $thumb_id;
    }

    // Время чтения и рубрики — как в карточках статей.
    $reading_time = function_exists('theme_get_reading_time_text') ? theme_get_reading_time_text($post_id) : '';
    if ($reading_time !== '') {
        $defaults['time'] = $reading_time;
    }

    $post_terms = get_the_terms($post_id, 'blog_cat');
    if ($post_terms && !is_wp_error($post_terms)) {
        $defaults['tags'] = array_map(static function ($term) {
            return ['text' => $term->name];
        }, array_slice($post_terms, 0, 2));
    }

    // «Читать полностью» ведёт на выбранную статью.
    $defaults['link'] = (string) get_permalink($guide_post);
}

$overrides = get_query_var('guide_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$tags = isset($data['tags']) && is_array($data['tags']) ? $data['tags'] : [];
$image = tolstenko_contact_get_image_attrs($data['image'] ?? null);

if (empty($image['url'])) {
    $image = ['url' => THEME_PATH . '/assets/img/guide.jpg', 'srcset' => '', 'sizes' => '', 'alt' => 'Почему ОАЭ'];
}

$link = trim((string) ($data['link'] ?? ''));
?>
<section class="guide section">
  <div class="container">
    <div class="guide__top section-top">
      <?php if (trim((string) $data['subtitle']) !== '') : ?>
        <span class="guide__badge section-subtitle"><?= $data['subtitle']; ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="guide__title section-title"><?= $data['title']; ?></h2>
      <?php endif; ?>
    </div>

    <article class="guide__card br-30">
      <div class="guide__content">
        <div class="guide__meta">
          <?php if (!empty($tags)) : ?>
            <ul class="guide__tags">
              <?php foreach ($tags as $tag) : ?>
                <li class="guide__tag"><?= esc_html($tag['text'] ?? ''); ?></li>
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
                <?= esc_html($data['time']); ?>
              </li>
            <?php endif; ?>
            <?php if (!empty($data['views'])) : ?>
              <li class="guide__info-item">
                <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                <?= esc_html($data['views']); ?>
              </li>
            <?php endif; ?>
            <?php if (!empty($data['date_label'])) : ?>
              <li class="guide__info-item">
                <time datetime="<?= esc_attr($data['date']); ?>"><?= esc_html($data['date_label']); ?></time>
                <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <rect x="3" y="5" width="18" height="16" rx="2"/>
                  <path d="M3 10h18M8 3v4M16 3v4"/>
                </svg>
              </li>
            <?php endif; ?>
          </ul>
        </div>

        <?php if (trim((string) $data['card_title']) !== '') : ?>
          <h3 class="guide__card-title"><?= $data['card_title']; ?></h3>
        <?php endif; ?>

        <div class="guide__text"><?= theme_section_text_html($data['text'] ?? ''); ?></div>

        <?php if ($link !== '' && trim((string) $data['btn_text']) !== '') : ?>
          <a class="guide__btn" href="<?= esc_url($link); ?>">
            <span><?= esc_html($data['btn_text']); ?></span>
            <svg class="guide__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 12h16M14 6l6 6-6 6"/>
            </svg>
          </a>
        <?php endif; ?>
      </div>

      <div class="guide__image br-20">
        <img src="<?= esc_url($image['url']); ?>" <?php if ($image['srcset']) echo 'srcset="' . esc_attr($image['srcset']) . '"'; ?> alt="<?= esc_attr($image['alt']); ?>" loading="lazy">
      </div>
    </article>
  </div>
</section>
