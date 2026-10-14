<?php
$title = get_field('documents_title', OPTION_ID);
$text = get_field('documents_text', OPTION_ID);
$items = get_field('documents_items', OPTION_ID);
?>
<section class="documents section">
  <div class="container">
    <div class="documents__inner br-30">
      <div class="documents__top section-top">
        <?php if ($title) { ?>
          <h2 class="documents__title h2"><?= $title; ?></h2>
        <?php } ?>

        <?php if ($text) { ?>
          <p class="documents__text paragraph-15-15"><?= $text; ?></p>
        <?php } ?>
      </div>

      <div class="documents__splide splide load-on-vissible--js"
        aria-label="Splide direction"
        data-module="./libs/splide.min.js,./modules/documentsSplideInit.js,./modules/documentsFancybox.js"
        data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css,<?= THEME_PATH; ?>/assets/css/libs/fancybox.css">

        <div class="splide__track">

          <div class="documents__list splide__list">
            <?php
            foreach ($items as $item) {
              $image = $item['image'];
              $image = Image::get_image_attrs($image);
            ?>
              <div class="documents__list-item splide__slide">
                <div class="documents__list-image">
                  <img src="<?= $image['url']; ?>" alt="<?= $item['title']; ?>" data-fancybox="documents">
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>

        <div class="splide__bottom">
          <ul class="splide__pagination"></ul>

          <div class="splide__arrows splide__arrows--ltr">
            <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide">
              <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
              </svg>
            </button>

            <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide">
              <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>