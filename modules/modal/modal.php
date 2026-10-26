<?php
/**
 * Модальное окно заявки (открывается ссылками href="#modal", логика — assets/js/modules/modal.js).
 * Тексты — из «Контактных данных», при пустых значениях — фолбэки ниже.
 * После успешной отправки любой формы CF7 окно показывает экран «Спасибо» (класс .success).
 */

$cd = tolstenko_get_contact_data();
$title = trim((string) ($cd['modal_title'] ?? '')) ?: 'Бесплатная <span>консультация</span>';
$text = trim((string) ($cd['modal_text'] ?? '')) ?: 'Оставьте контакт — перезвоним, зададим пару вопросов и подберём решение под вашу задачу.';
$thanks = trim((string) ($cd['modal_thanks_title'] ?? '')) ?: 'Спасибо! Заявка <span>отправлена</span>';
$thanks_text = trim((string) ($cd['modal_thanks_text'] ?? '')) ?: 'Мы свяжемся с вами в ближайшее время.';
$thanks_btn = trim((string) ($cd['modal_btn'] ?? '')) ?: 'На главную';
?>

<div class="modal load-on-vissible--js" data-module="./modules/form.js" role="dialog" aria-modal="true" aria-labelledby="modal-title">
  <div class="modal__inner br-30">
    <button class="modal__close" type="button" aria-label="Закрыть">
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M6 6l12 12M6 18L18 6" />
      </svg>
    </button>

    <div class="modal__wrapper">
      <span class="modal__badge section-subtitle">Заявка</span>

      <h2 class="modal__title" id="modal-title"><?= $title; ?></h2>

      <p class="modal__subtitle reg-par-14-20"><?= $text; ?></p>

      <div class="modal__form form form--dark">
        <?php echo do_shortcode('[contact-form-7 id="1cd1085" title="Модалка"]'); ?>
      </div>
    </div>

    <div class="modal__thanks">
      <span class="modal__thanks-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5" /></svg>
      </span>

      <h2 class="modal__title"><?= $thanks; ?></h2>

      <p class="modal__subtitle reg-par-14-20"><?= $thanks_text; ?></p>

      <a class="modal__link default-btn default-btn--brown" href="<?= esc_url(home_url('/')); ?>"><?= esc_html($thanks_btn); ?></a>
    </div>
  </div>
</div>
