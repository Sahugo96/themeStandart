<?php

/**
 * Карточка кейса для секции «Кейсы» (CPT case).
 *
 * Мета-поля записи (inc/case-metabox.php): case_title, case_text, case_link,
 * case_service, case_items (показатели: value + text). Метка — термин
 * таксономии case_cat, изображение — миниатюра записи.
 */

$case_id = get_the_ID();

$case_title = trim((string) get_post_meta($case_id, 'case_title', true));
$case_text  = (string) get_post_meta($case_id, 'case_text', true);
$case_link  = trim((string) get_post_meta($case_id, 'case_link', true));
$case_items = get_post_meta($case_id, 'case_items', true);
$case_items = is_array($case_items) ? $case_items : [];

// New fields
$case_category_title = trim((string) get_post_meta($case_id, 'case_category_title', ''));
$case_non_resident   = trim((string) get_post_meta($case_id, 'case_non_resident', ''));

// New indicators field
$case_indicators = get_post_meta($case_id, 'case_indicators', true);
$case_indicators = is_array($case_indicators) ? $case_indicators : [];

if ($case_title === '') {
    $case_title = get_the_title();
}

if ($case_link === '') {
    $case_link = (string) get_permalink($case_id);
}

$case_terms = get_the_terms($case_id, 'case_cat');
$case_tag   = '';

if ($case_terms && !is_wp_error($case_terms)) {
    $case_tag = (string) $case_terms[0]->name;
}

$case_text_html = theme_section_text_html($case_text);
?>
<article class="cases__card fade-in-element splide__slide">
  <?php if ($case_tag !== '') : ?>
    <span class="cases__card-tag"><?= esc_html($case_tag); ?></span>
  <?php endif; ?>

  <?php if ($case_category_title !== '') : ?>
    <span class="cases__card-subtitle"><?= esc_html($case_category_title); ?></span>
  <?php endif; ?>

  <h3 class="cases__card-title">
    <a class="cases__card-title-link" href="<?= esc_url($case_link); ?>"><?= $case_title; ?></a>
  </h3>

  <?php if ($case_text_html !== '') : ?>
    <div class="cases__story cases__story--text"><?= $case_text_html; ?></div>
  <?php endif; ?>

  <?php if (!empty($case_non_resident)) : ?>
    <p class="cases__card-non-resident"><?= esc_html($case_non_resident); ?></p>
  <?php endif; ?>

  <?php if (!empty($case_indicators)) : ?>
    <ul class="cases__indicators">
$item = is_array($item) ? $item : [];
      <?php foreach ($case_indicators as $index => $item) :\n        $item = is_array($item) ? $item : [];\n        $icon   = esc_url( $item['icon'] ?? '' );\n        $criteria = esc_html( $item['criteria'] ?? '' );\n        $value   = esc_html( $item['value'] ?? '' );\n      ?>\n        <li class="cases__indicator">\n          <?php if ($index === 0 && $icon !== '') : ?>\n            <img src="<?= $icon; ?>" alt="Иконка" class="cases__indicator-icon"/><?php endif; ?>\n            <span class="cases__indicator-criteria"><?= $criteria; ?></span>\n            <span class="cases__indicator-value"><?= $value; ?></span>\n          <?php endif; ?>\n        </li>\n      <?php endforeach; ?>\n    </ul>\n  <?php endif; ?>

  <?php if (!empty($case_items)) : ?>
    <ul class="cases__facts">
      <?php foreach ($case_items as $index => $item) :
        $item = is_array($item) ? $item : [];
        $item_value = trim((string) ($item['value'] ?? ''));
        $item_label = trim((string) ($item['text'] ?? ''));

        if ($item_value === '' && $item_label === '') {
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
            <?= esc_html($item_label); ?>
          </span>
          <span class="cases__fact-value"><?= esc_html($item_value); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</article>
