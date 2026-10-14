<?php
$items = get_field('team_items', OPTION_ID);
if ($items) {
?>
  <section class="team section">
    <div class="container">
      <div class="team__inner">
        <div class="team__top section-top">
          <h2 class="team__title h2"><?= get_field('team_title', OPTION_ID) ?></h2>

          <?php if (get_field('team_text', OPTION_ID)) { ?>
            <p class="team__text paragraph-15-15"><?= get_field('team_text', OPTION_ID) ?></p>
          <?php } ?>
        </div>

        <div class="team__splide splide load-on-vissible--js"
          aria-label="Splide direction"
          data-module="./modules/lazyLoad.js,./libs/splide.min.js,./modules/teamSplideInit.js"
          data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css">

          <div class="splide__track">
            <div class="team__list splide__list">
              <?php
              foreach ($items as $item) {
                $image = $item['image'];
                $image = Image::get_image_attrs($image);
              ?>
                <div class="team__item splide__slide border-card br-20">
                  <div class="team__item-img">
                    <!-- <img src="<?= $image['url']; ?>" alt="<?= $item['name']; ?>"> -->

                    <img class="lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $image['url']; ?>" data-srcset="<?= $image['srcset']; ?>" alt="<?= $image['alt']; ?>" data-sizes="<?= $image['sizes']; ?>">
                  </div>

                  <div class="team__item-info">
                    <p class="team__item-name line-caps-bold-15-15"><?= $item['name']; ?></p>

                    <p class="team__item-position footnote-12-10">
                      <?= $item['position']; ?>

                      <?php
                      if ($item['exp']) {
                      ?>
                        <span><?= $item['exp']; ?></span>
                      <?php
                      }
                      ?>
                    </p>


                    <?php
                    if ($item['exp']) {
                    ?>
                      <p class="team__item-text"><?= $item['text']; ?></p>
                    <?php
                    }
                    ?>
                  </div>

                  <a class="team__item-btn default-btn" href="<?= $item['btn']['url']; ?>">
                    <?= $item['btn']['title']; ?>
                  </a>
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
<?php
}
?>