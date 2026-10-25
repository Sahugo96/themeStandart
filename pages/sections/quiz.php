<?php

defined('ABSPATH') || exit;

/**
 * Секция «Квиз-диагностика» (quiz).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('quiz')
 * (таб «Дефолты блоков → Секции лендинга → Квиз»). Атрибуты блока имеют приоритет.
 *
 * Человек по очереди отвечает на шаги (вопрос + варианты), затем видит общий
 * финальный экран с формой CF7. Ответы JS кладёт в скрытое поле quiz_answers,
 * в письмо их добавляет inc/cf7/quiz-answers.php. Логика — assets/js/modules/quiz.js.
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('quiz') : [];

$overrides = get_query_var('quiz_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$steps = [];
foreach ((array) ($data['steps'] ?? []) as $step) {
    $question = is_array($step) ? trim((string) ($step['question'] ?? '')) : '';
    $options = [];

    foreach ((array) ($step['options'] ?? []) as $option) {
        $option_text = is_array($option) ? trim((string) ($option['text'] ?? '')) : '';
        if ($option_text !== '') {
            $options[] = $option_text;
        }
    }

    if ($question !== '' && !empty($options)) {
        $steps[] = ['question' => $question, 'options' => $options];
    }
}

if (empty($steps)) {
    return;
}

$stats = array_filter((array) ($data['stats'] ?? []), static function ($stat) {
    return is_array($stat) && (trim((string) ($stat['value'] ?? '')) !== '' || trim((string) ($stat['label'] ?? '')) !== '');
});

$badge = trim((string) ($data['badge'] ?? ''));
$title = trim((string) ($data['title'] ?? ''));
$text = trim((string) ($data['text'] ?? ''));
$final_thanks = trim((string) ($data['final_thanks'] ?? ''));
$final_title = trim((string) ($data['final_title'] ?? ''));
$final_text = trim((string) ($data['final_text'] ?? ''));
$form_shortcode = trim((string) ($data['form_shortcode'] ?? ''));
$btn_text = trim((string) ($data['btn_text'] ?? ''));
$final_note = trim((string) ($data['final_note'] ?? ''));
?>
<section class="quiz section">
  <div class="container">
    <?php if ($badge !== '') : ?>
      <div class="quiz__top section-top">
        <span class="quiz__badge section-subtitle"><?= $badge; ?></span>
      </div>
    <?php endif; ?>

    <div class="quiz__inner">
      <div class="quiz__intro br-30">
        <?php if ($title !== '') : ?>
          <h2 class="quiz__title"><?= $title; ?></h2>
        <?php endif; ?>

        <?php if ($text !== '') : ?>
          <div class="quiz__text lead-16-25"><?= theme_section_text_html($text); ?></div>
        <?php endif; ?>

        <?php if (!empty($stats)) : ?>
          <ul class="quiz__stats">
            <?php foreach ($stats as $stat) : ?>
              <li class="quiz__stat">
                <span class="quiz__stat-value h2-18-20"><?= esc_html($stat['value'] ?? ''); ?></span>
                <span class="quiz__stat-label reg-par-14-20"><?= esc_html($stat['label'] ?? ''); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <div class="quiz__body br-30 load-on-vissible--js" data-module="./modules/quiz.js" data-quiz>
        <div class="quiz__progress" aria-hidden="true">
          <?php foreach ($steps as $index => $step) : ?>
            <span class="quiz__progress-bar<?= $index === 0 ? ' active' : ''; ?>" data-quiz-bar></span>
          <?php endforeach; ?>
        </div>

        <?php foreach ($steps as $index => $step) : ?>
          <div class="quiz__step" data-quiz-step<?= $index > 0 ? ' hidden' : ''; ?>>
            <h3 class="quiz__question line-caps-bold-16-15" data-quiz-question><?= ($index + 1) . '. ' . esc_html($step['question']); ?></h3>

            <div class="quiz__options" role="group" aria-label="<?= esc_attr($step['question']); ?>">
              <?php foreach ($step['options'] as $option) : ?>
                <button class="quiz__option reg-par-14-20" type="button" aria-pressed="false" data-quiz-option><?= esc_html($option); ?></button>
              <?php endforeach; ?>
            </div>

            <?php if ($index > 0) : ?>
              <button class="quiz__back reg-small-12-15" type="button" data-quiz-back>
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H4M10 6l-6 6 6 6"/></svg>
                <span>Назад</span>
              </button>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

        <div class="quiz__step quiz__final" data-quiz-final hidden>
          <?php if ($final_thanks !== '') : ?>
            <p class="quiz__thanks line-caps-bold-16-15"><?= $final_thanks; ?></p>
          <?php endif; ?>

          <?php if ($final_title !== '') : ?>
            <h3 class="quiz__final-title h2-18-20"><?= $final_title; ?></h3>
          <?php endif; ?>

          <?php if ($final_text !== '') : ?>
            <p class="quiz__final-text reg-par-14-20"><?= $final_text; ?></p>
          <?php endif; ?>

          <?php if ($form_shortcode !== '') : ?>
            <div class="quiz__form form"<?php if ($btn_text !== '') : ?> data-quiz-btn-text="<?= esc_attr($btn_text); ?>"<?php endif; ?>>
              <?= do_shortcode($form_shortcode); ?>
            </div>
          <?php endif; ?>

          <?php if ($final_note !== '') : ?>
            <p class="quiz__note reg-small-12-15"><?= $final_note; ?></p>
          <?php endif; ?>

          <button class="quiz__back reg-small-12-15" type="button" data-quiz-back>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 12H4M10 6l-6 6 6 6"/></svg>
            <span>Изменить ответы</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
