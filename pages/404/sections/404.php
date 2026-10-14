<?php
$home = 'Перейти на главную';
$error = 'Страница не найдена';
?>

<section class="error">
  <div class="error__title">
    404
  </div>
  <div class="error__text"><?= $error; ?></div>

  <a class="error__home default-btn" href="<?= esc_url(home_url()); ?>"><?= esc_html($home); ?></a>
</section>