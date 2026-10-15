<section class="partners section">
  <div class="container">
    <div class="partners__inner br-30">
      <div class="partners__top section-top">
        <h2 class="partners__title h2"><?= get_field('partners_title', OPTION_ID); ?></h2>

        <?php if (get_field('partners_text', OPTION_ID)) { ?>
        <p class="partners__text paragraph-15-15"><?= get_field('partners_text', OPTION_ID); ?></p>
        <?php } ?>
      </div>

      <div class="partners__splide splide load-on-vissible--js"
        aria-label="Splide direction"
        data-module="./libs/splide.min.js,./modules/partnersSplideInit.js"
        data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css">

        <div class="splide__track">

          <div class="partners__list splide__list">
            <?php
            $items = get_field('partners_items', OPTION_ID);
            $items = is_array($items) ? $items : [];
            foreach ($items as $item) {
              $image = $item['image'];
              $image = Image::get_image_attrs($image);
            ?>
              <div class="partners__list-item splide__slide">
                <div class="partners__list-image">
                  <img src="<?= $image['url']; ?>" alt="<?= $item['title']; ?>">
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