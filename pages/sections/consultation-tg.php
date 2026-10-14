<?php
$cd = tolstenko_get_contact_data();
$svg_url = tolstenko_contact_resolve_icon_url($cd['telegram_ico']);
$title = get_field('consultation_tg_title', OPTION_ID);
$text = get_field('consultation_tg_text', OPTION_ID);
$btn = get_field('consultation_tg_btn', OPTION_ID);
$text_btn = get_field('consultation_tg_text_btn', OPTION_ID);
$img = get_field('consultation_tg_img', OPTION_ID);
$img = Image::get_image_attrs($img);
?>
<section class="consultation-tg section">
  <div class="container">
    <div class="consultation-tg__inner">
      <div class="consultation-tg__img">
        <img class="lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $img['url']; ?>" data-srcset="<?= $img['srcset']; ?>" alt="<?= $img['alt']; ?>" data-sizes="<?= $img['sizes']; ?>">
      </div>



      <div class="consultation-tg__wrapper tg-block">
        <?php if ($title) { ?>
        <h2 class="tg-block__title h2"><?= $title; ?></h2>
        <?php } ?>
          <?php if ($text) { ?>
        <p class="tg-block__content"><?= $text; ?></p>
        <?php } ?>

        <div class="tg-block__bottom">
          <a class="tg-block__btn default-btn default-btn--tg" href="<?= $btn['url'];  ?>" target="_blank">
            <?php
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>

            <?= $btn['title'];  ?>
          </a>


          <?php if ($text_btn) { ?>
          <p class="tg-block__text line-13-15"><?= $text_btn; ?></p>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>