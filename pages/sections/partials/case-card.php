<?php

/**
 * Карточка кейса для секции «Кейсы» (CPT case).
 *
 * Мета-поля записи (inc/case-metabox.php):
 * - case_title          — заголовок карточки (пусто = заголовок записи);
 * - case_category_title — метка над заголовком (пусто = рубрика case_cat);
 * - case_items          — этапы «Задача / Решение / Результат»: text = подпись, value = текст;
 * - case_indicators     — факты «Срок / Экономия»: icon (ID вложения), criteria, value.
 */

$case_id = get_the_ID();

$case_title = trim((string) get_post_meta($case_id, 'case_title', true));
$case_link  = (string) get_permalink($case_id);
$case_tag   = trim((string) get_post_meta($case_id, 'case_category_title', true));

$case_steps = get_post_meta($case_id, 'case_items', true);
$case_steps = is_array($case_steps) ? $case_steps : [];

$case_facts = get_post_meta($case_id, 'case_indicators', true);
$case_facts = is_array($case_facts) ? $case_facts : [];

if ($case_title === '') {
    $case_title = get_the_title();
}

if ($case_tag === '') {
    $case_terms = get_the_terms($case_id, 'case_cat');

    if ($case_terms && !is_wp_error($case_terms)) {
        $case_tag = (string) $case_terms[0]->name;
    }
}
?>
<article class="cases__card fade-in-element splide__slide">
  <?php if ($case_tag !== '') : ?>
    <span class="cases__card-tag"><?= esc_html($case_tag); ?></span>
  <?php endif; ?>

  <h3 class="cases__card-title">
    <a class="cases__card-title-link" href="<?= esc_url($case_link); ?>"><?= $case_title; ?></a>
  </h3>

  <?php if (!empty($case_steps)) : ?>
    <div class="cases__story">
      <?php foreach ($case_steps as $step) :
        $step = is_array($step) ? $step : [];
        $step_label = trim((string) ($step['text'] ?? ''));
        $step_text  = trim((string) ($step['value'] ?? ''));

        if ($step_label === '' && $step_text === '') {
            continue;
        }

        if ($step_label !== '' && substr($step_label, -1) !== ':') {
            $step_label .= ':';
        }
      ?>
        <div class="cases__step">
          <?php if ($step_label !== '') : ?>
            <span class="cases__step-label"><?= esc_html($step_label); ?></span>
          <?php endif; ?>
          <?php if ($step_text !== '') : ?>
            <p class="cases__step-text"><?= esc_html($step_text); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($case_facts)) : ?>
    <ul class="cases__facts">
      <?php foreach ($case_facts as $fact) :
        $fact = is_array($fact) ? $fact : [];
        $icon_raw = $fact['icon'] ?? 0;
        // Иконка — ID вложения; старые записи могли хранить URL строкой.
        $icon_url = is_numeric($icon_raw)
            ? (string) wp_get_attachment_image_url((int) $icon_raw, 'full')
            : trim((string) $icon_raw);
        $fact_label = trim((string) ($fact['criteria'] ?? ''));
        $fact_value = trim((string) ($fact['value'] ?? ''));

        if ($fact_label === '' && $fact_value === '') {
            continue;
        }
      ?>
        <li class="cases__fact">
          <span class="cases__fact-label">
            <?php if ($icon_url !== '') : ?>
              <img class="cases__fact-icon" src="<?= esc_url($icon_url); ?>" alt="" loading="lazy">
            <?php endif; ?>
            <?= esc_html($fact_label); ?>
          </span>
          <span class="cases__fact-value"><?= esc_html($fact_value); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</article>
