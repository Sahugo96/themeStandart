<?php

defined('ABSPATH') || exit;

/**
 * Секция «Бесплатная консультация» (consult).
 *
 * Дефолты подставляются, если соответствующий блок на странице не заполнен.
 * Если блок my-theme/consult заполнен — данные приходят через query var consult_data.
 */

$defaults = [
    'subtitle'     => 'Начните с бесплатной консультации',
    'title'        => 'Разбор вашей ситуации<br>и решение',
    'title_accent' => '— бесплатно',
    'text'         => '<p>Оставьте номер — перезвоним, зададим пару вопросов и подберём решение под вашу задачу: счёт, ВНЖ или компанию.</p><p>Или напишите нам: <a href="tel:+971554352459">+971 55 435 2459</a></p>',
    'image'        => ['url' => THEME_PATH . '/assets/img/consult.jpg', 'alt' => 'Консультант Relocate-World'],
];

$overrides = get_query_var('consult_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$image = tolstenko_contact_get_image_attrs($data['image'] ?? null);

if (empty($image['url'])) {
    $image = ['url' => THEME_PATH . '/assets/img/consult.jpg', 'srcset' => '', 'sizes' => '', 'alt' => 'Консультант Relocate-World'];
}
?>
<section class="consult section">
  <div class="container">
    <div class="consult__inner">

      <div class="consult__content">
        <span class="consult__badge section-subtitle"><?= $data['subtitle']; ?></span>
        <h2 class="consult__title section-title">
          <?= $data['title']; ?>
          <span><?= $data['title_accent']; ?></span>
        </h2>
        <div class="consult__text">
          <?= $data['text']; ?>
        </div>

        <form class="consult__form" action="" method="post">
          <div class="consult__field">
            <input class="consult__input" type="text" name="contact" placeholder="Ваш телефон или телеграм" autocomplete="tel" required>
            <button class="consult__submit" type="submit">Получить консультацию</button>
          </div>

          <label class="consult__check">
            <input class="consult__check-input" type="checkbox" name="agree_policy" checked required>
            <span class="consult__check-box"></span>
            <span class="consult__check-text">Согласен с <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a></span>
          </label>

          <label class="consult__check">
            <input class="consult__check-input" type="checkbox" name="agree_data" required>
            <span class="consult__check-box"></span>
            <span class="consult__check-text">Согласен с <a href="/personal-data/" target="_blank">обработкой данных</a></span>
          </label>
        </form>
      </div>

      <div class="consult__image">
        <img src="<?= $image['url']; ?>" <?php if ($image['srcset']) echo 'srcset="' . $image['srcset'] . '"'; ?> alt="<?= $image['alt']; ?>" loading="lazy">
      </div>

    </div>
  </div>
</section>
