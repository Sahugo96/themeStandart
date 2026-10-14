<section class="calc section">
  <div class="container">
    <div class="section-top">
      <h2 class="calc__title h2"><?= get_field('calc_title') ?></h2>

      <a class="calc__btn default-btn" href="<?= get_field('calc_btn')['url']; ?>">
        <?= get_field('calc_btn')['title']; ?>
      </a>
    </div>
</section>