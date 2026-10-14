<?php
$cd = tolstenko_get_contact_data();
$title = $cd['modal_title'];
$text = $cd['modal_text'];
$thanks = $cd['modal_thanks_title'];
$thanks_text = $cd['modal_thanks_text'];
$thanks_btn = $cd['modal_btn'];
?>

<div class="modal load-on-vissible--js" data-module="./modules/form.js">
  <div class="modal__inner">
    <div class="modal__wrapper">
      <h2 class="modal__title h2"><?= $title; ?></h2>

      <span class="modal__subtitle">
        <?= $text; ?>
      </span>

      <div class="modal__form form">
        <?php echo do_shortcode('[contact-form-7 id="1cd1085" title="Модалка"]'); ?>
      </div>
    </div>
    <div class="modal__thanks">
      <h2 class="modal__title h2"><?= $thanks; ?></h2>

      <span class="modal__subtitle">
        <?= $thanks_text; ?>
      </span>

      <a class="modal__link default-btn" href="<?= home_url(); ?>">
        <?= $thanks_btn ?: 'На главную'; ?>
      </a>
    </div>

    <svg class="modal__close" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M9.33398 9.33334L22.6673 22.6667" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M9.33398 22.6667L22.6673 9.33334" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>

  </div>
</div>
