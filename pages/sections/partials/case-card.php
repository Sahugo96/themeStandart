<?php

/**
 * Карточка кейса для секции «Кейсы» (CPT case).
 *
 * @var array $args Дополнительные аргументы (не используются, оставлено для совместимости).
 */

$case_id = get_the_ID();

$case_tag   = (string) get_post_meta($case_id, 'case_tag', true);
$case_title = (string) get_post_meta($case_id, 'case_title', true);
$case_steps = get_post_meta($case_id, 'case_steps', true);
$case_facts = get_post_meta($case_id, 'case_facts', true);

$case_steps = is_array($case_steps) ? $case_steps : [];
$case_facts = is_array($case_facts) ? $case_facts : [];

if ($case_title === '') {
    $case_title = get_the_title();
}
?>
<article class="cases__card fade-in-element splide__slide">
  <?php if ($case_tag !== '') : ?>
    <span class="cases__card-tag"><?= esc_html($case_tag); ?></span>
  <?php endif; ?>

  <h3 class="cases__card-title"><?= $case_title; ?></h3>

  <?php if (!empty($case_steps)) : ?>
    <div class="cases__story">
      <?php foreach ($case_steps as $step) :
        $step = is_array($step) ? $step : [];
        $step_label = (string) ($step['label'] ?? '');
        $step_text = (string) ($step['text'] ?? '');

        if ($step_label === '' && $step_text === '') {
            continue;
        }
      ?>
        <div class="cases__step">
          <?php if ($step_label !== '') : ?>
            <span class="cases__step-label"><?= esc_html($step_label); ?>:</span>
          <?php endif; ?>
          <?php if ($step_text !== '') : ?>
            <p class="cases__step-text"><?= nl2br(esc_html($step_text)); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($case_facts)) : ?>
    <ul class="cases__facts">
      <?php foreach ($case_facts as $index => $fact) :
        $fact = is_array($fact) ? $fact : [];
        $fact_label = (string) ($fact['label'] ?? '');
        $fact_value = (string) ($fact['value'] ?? '');

        if ($fact_label === '' && $fact_value === '') {
            continue;
        }
      ?>
        <li class="cases__fact">
          <span class="cases__fact-label">
            <?php if ($index === 0) : ?>
              <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6.5V12l3.5 2" /></svg>
            <?php else : ?>
              <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 8V6a2 2 0 0 1 2-2h11v4"/><rect x="3" y="8" width="18" height="12" rx="2"/><circle cx="16.5" cy="14" r="1.3"/></svg>
            <?php endif; ?>
            <?= esc_html($fact_label); ?>
          </span>
          <span class="cases__fact-value"><?= esc_html($fact_value); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</article>