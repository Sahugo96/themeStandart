<?php
$section = get_query_var('section');
$reviews_data = get_query_var('reviews_data');

if (is_array($reviews_data) && !empty($reviews_data)) {
  $title = $reviews_data['title'] ?? '';
  $reviews_list = $reviews_data['reviews_list'] ?? [];
  $reviews_list_hide = !empty($reviews_data['reviews_list_hide']);
  $reviews = $reviews_data['reviews'] ?? [];
} elseif ($section) {
  if ($section != true && $section['reviews_rewrite']) {
    $title = $section['reviews_title'];
    $reviews_list = $section['reviews_list'];
    $reviews_list_hide = $section['reviews_list_hide'];
    $reviews = $section['reviews_reviews'];
  } else {
    $title = get_field('reviews_title', OPTION_ID);
    $reviews_list = get_field('reviews_list', OPTION_ID);
    $reviews_list_hide = get_field('reviews_list_hide', OPTION_ID);
    $reviews = get_field('reviews_review', OPTION_ID);
  }
} else {
  return;
}

if (empty($reviews) || !is_array($reviews)) {
  return;
}
?>
<section class="reviews section load-on-vissible--js"
  aria-label="Splide direction"
  data-module="./libs/splide.min.js,./modules/reviewsSplideInit.js,./modules/reviewsFancybox.js,./modules/reviewsVideoLightbox.js"
  data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css,<?= THEME_PATH; ?>/assets/css/libs/fancybox.css">
  <div class="container">
    <div class="reviews__inner br-30">
      <div class="reviews__top section-top">
        <h2 class="reviews__title h2"><?= $title; ?></h2>
      </div>

      <?php
      if ($reviews_list && $reviews_list_hide) {
      ?>
        <div class="reviews__items">
          <?php
          foreach ($reviews_list as $item) {
            $rating = $item['rating'];
          ?>
            <a class="reviews__item" href="<?= $item['link']['url']; ?>">
              <span class="reviews__item-number line-caps-bold-16-15"><span><?= $rating; ?></span>/5</span>

              <div class="reviews__list-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="star <?php echo $i <= $rating ? 'filled' : 'empty'; ?>">★</span>
                <?php endfor; ?>
              </div>

              <div class="reviews__item-link line-caps-bold-16-15"><?= $item['link']['title']; ?></div>
              </a>
          <?php
          }
          ?>
        </div>
      <?php
      }

      // Группируем отзывы по типу
      $grouped_reviews = array(
        'Благодарности' => array(),
        'Видео' => array(),
        'Текстовые' => array(),
        'Месседжеры' => array()
      );

      foreach ($reviews as $review) {
        $review_type = get_field('review_type', $review->ID);
        if (isset($grouped_reviews[$review_type])) {
          $grouped_reviews[$review_type][] = $review;
        }
      }

      $checked = 'checked';
      ?>

      <div class="reviews__tabs">
        <div class="reviews__labels">
          <?php if (!empty($grouped_reviews['Благодарности'])): ?>
            <label class="reviews__label line-caps-bold-13-15">
              <input type="radio" value="thenks" name="reviews" <?= $checked; ?>>
              <span>Благодарности</span>
            </label>
          <?php
          $checked = '';
          endif;
          ?>
          <?php if (!empty($grouped_reviews['Видео'])): ?>
            <label class="reviews__label line-caps-bold-13-15">
              <input type="radio" value="video" name="reviews" <?= $checked; ?>
                <span>Видео</span>
            </label>
          <?php
          $checked = '';
          endif;
          ?>
          <?php if (!empty($grouped_reviews['Текстовые'])): ?>
            <label class="reviews__label line-caps-bold-13-15">
              <input type="radio" value="text" name="reviews" <?= $checked; ?>
                <span>Текстовые</span>
            </label>
          <?php
          $checked = '';
          endif;
          ?>
          <?php if (!empty($grouped_reviews['Месседжеры'])): ?>
            <label class="reviews__label line-caps-bold-13-15">
              <input type="radio" value="messengers" name="reviews" <?= $checked; ?>
                <span>Месседжеры</span>
            </label>
          <?php
          $checked = '';
          endif;
          ?>
        </div>
      </div>


      <!-- Блок благодарностей -->
      <?php if (!empty($grouped_reviews['Благодарности'])): ?>
        <div class="reviews__splide reviews__splide--thenks splide">
          <div class="splide__track">
            <div class="reviews__list splide__list">
              <?php
              foreach ($grouped_reviews['Благодарности'] as $review) {
                $image = get_field('review_thenks', $review->ID);
                $image = Image::get_image_attrs($image);
              ?>
                <div class="reviews__list-item splide__slide">
                  <div class="reviews__list-image">
                    <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" data-fancybox="reviews-thenks">
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
      <?php endif; ?>

      <!-- Блок видео-отзывов -->
      <?php if (!empty($grouped_reviews['Видео'])): ?>
        <div class="reviews__splide reviews__splide--video splide">
          <div class="splide__track">
            <div class="reviews__list splide__list">
              <?php
              foreach ($grouped_reviews['Видео'] as $review) {
                $video = html_entity_decode(trim((string) get_field('review_video', $review->ID)), ENT_QUOTES, 'UTF-8');

                if ($video === '') {
                  continue;
                }

                $video_src = '';

                if (preg_match('/src=(["\'])([^"\']+)\1/i', $video, $matches)) {
                  $video_src = html_entity_decode($matches[2], ENT_QUOTES, 'UTF-8');
                } elseif (preg_match('#https?://[^\s<>"\']+#', $video, $matches)) {
                  $video_src = $matches[0];
                }

                if ($video_src === '') {
                  continue;
                }

                $video_poster = theme_get_video_embed_poster($video_src);
                $rutube_id = theme_get_rutube_video_id($video_src);
                $video_name = trim((string) get_field('review_video_name', $review->ID));
                $video_text = trim((string) get_field('review_video_text', $review->ID));
                $video_has_meta = $video_name !== '' && $video_text !== '';

                $logo = get_field('review_logo', $review->ID);
                $logo = Image::get_image_attrs($logo);
              ?>
                <div class="reviews__list-item reviews__list-item--video<?= $video_has_meta ? ' reviews__list-item--video-meta' : ''; ?> splide__slide">
                  <button
                    type="button"
                    class="reviews__list-preview reviews__list-preview--embed"
                    data-video-src="<?= esc_url($video_src); ?>"
                    <?php if ($rutube_id !== '') : ?>
                      data-rutube-id="<?= esc_attr($rutube_id); ?>"
                    <?php endif; ?>
                    aria-label="<?= $video_name !== '' ? esc_attr($video_name) : 'Открыть видео'; ?>"
                  >
                    <div class="reviews__list-embed">
                      <img
                        class="reviews__list-poster"
                        <?php if ($video_poster !== '') : ?>
                          src="<?= esc_url($video_poster); ?>"
                        <?php endif; ?>
                        alt="<?= $video_name !== '' ? esc_attr($video_name) : ''; ?>"
                        loading="lazy"
                        decoding="async"
                      >
                    </div>

                    <span class="reviews__list-play video__btn" aria-hidden="true">
                      <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.82263 0.0285661C3.40033 0.0281482 2.98488 0.135329 2.61549 0.339995C2.23667 0.533082 1.91754 0.82562 1.6923 1.18625C1.46706 1.54688 1.34421 1.96201 1.33691 2.38714V17.64C1.34421 18.0651 1.46706 18.4803 1.6923 18.8409C1.91754 19.2015 2.23667 19.4941 2.61549 19.6871C2.99158 19.896 3.41545 20.0038 3.84565 19.9998C4.27584 19.9957 4.69764 19.8802 5.06977 19.6643L17.3983 12.0386C17.7788 11.8468 18.0985 11.5532 18.3219 11.1904C18.5452 10.8276 18.6634 10.4099 18.6633 9.98384C18.6631 9.5578 18.5446 9.14017 18.321 8.77753C18.0974 8.41488 17.7775 8.12146 17.3969 7.92999L5.06834 0.361423L5.04549 0.348566C4.67225 0.138309 4.25101 0.0280782 3.82263 0.0285661Z" />
                      </svg>
                    </span>
                  </button>

                  <?php if ($video_has_meta) : ?>
                    <div class="reviews__list-video-meta">
                      <?php if (!empty($logo['url'])) : ?>
                        <div class="reviews__list-video-logo">
                          <img src="<?= esc_url($logo['url']); ?>" alt="<?= esc_attr($logo['alt']); ?>">
                        </div>
                      <?php endif; ?>

                      <div class="reviews__list-video-text">
                        <div class="reviews__list-video-name paragraph-15-25"><?= esc_html($video_name); ?></div>
                        <div class="reviews__list-video-desc paragraph-13-20"><?= esc_html($video_text); ?></div>
                      </div>
                    </div>
                  <?php elseif (!empty($logo['url'])) : ?>
                    <div class="reviews__list-logo">
                      <img src="<?= esc_url($logo['url']); ?>" alt="<?= esc_attr($logo['alt']); ?>">
                    </div>
                  <?php endif; ?>
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
      <?php endif; ?>

      <!-- Блок текстовых отзывов -->
      <?php if (!empty($grouped_reviews['Текстовые'])): ?>
        <div class="reviews__splide reviews__splide--text splide">
          <div class="splide__track">
            <div class="reviews__list splide__list">
              <?php foreach ($grouped_reviews['Текстовые'] as $review) {
                $name = get_field('review_name', $review->ID);
                $position = get_field('review_position', $review->ID);
                $rating = get_field('review_rating', $review->ID);
                $redactor = get_field('review_redactor', $review->ID);
                $contact = get_field('review_contact', $review->ID);
                $case_file = get_field('review_case', $review->ID);

                $photo = get_field('review_photo', $review->ID);
                $photo = Image::get_image_attrs($photo);
              ?>
                <div class="reviews__list-item reviews__list-item--text splide__slide">
                  <div class="reviews__list-top">
                    <div class="reviews__list-photo">
                      <img src="<?= $photo['url']; ?>" alt="<?= $name; ?>">
                    </div>

                    <div class="reviews__list-wrapper">
                      <div class="reviews__list-name"><?= $name; ?></div>

                      <div class="reviews__list-position"><?= $position; ?></div>

                      <div class="reviews__list-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                          <span class="star <?php echo $i <= $rating ? 'filled' : 'empty'; ?>">★</span>
                        <?php endfor; ?>
                      </div>
                    </div>
                  </div>

                  <div class="reviews__list-redactor redactor">
                    <?= $redactor; ?>
                  </div>

                  <div class="reviews__list-btns">
                    <a class="reviews__list-btn reviews__list-btn--transparent default-btn" href="<?= $contact['url'];  ?>">
                      <!-- <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.9999 15.0003C14.9333 15.0003 15.4 15.0003 15.7566 14.8187C16.0702 14.6589 16.3251 14.4039 16.4849 14.0903C16.6666 13.7338 16.6666 13.2671 16.6666 12.3337V4.33366C16.6666 3.40024 16.6666 2.93353 16.4849 2.57701C16.3251 2.2634 16.0702 2.00844 15.7566 1.84865C15.4 1.66699 14.9333 1.66699 13.9999 1.66699H9.33325C8.39983 1.66699 7.93312 1.66699 7.5766 1.84865C7.263 2.00844 7.00803 2.2634 6.84824 2.57701C6.66659 2.93353 6.66659 3.40024 6.66659 4.33366M5.99992 18.3337H10.6666C11.6 18.3337 12.0667 18.3337 12.4232 18.152C12.7368 17.9922 12.9918 17.7372 13.1516 17.4236C13.3333 17.0671 13.3333 16.6004 13.3333 15.667V7.66699C13.3333 6.73357 13.3333 6.26686 13.1516 5.91034C12.9918 5.59674 12.7368 5.34177 12.4232 5.18198C12.0667 5.00033 11.6 5.00033 10.6666 5.00033H5.99992C5.0665 5.00033 4.59979 5.00033 4.24327 5.18198C3.92966 5.34177 3.6747 5.59674 3.51491 5.91034C3.33325 6.26686 3.33325 6.73357 3.33325 7.66699V15.667C3.33325 16.6004 3.33325 17.0671 3.51491 17.4236C3.6747 17.7372 3.92966 17.9922 4.24327 18.152C4.59979 18.3337 5.0665 18.3337 5.99992 18.3337Z" stroke-width="2" />
                      </svg> -->

                      <?= $contact['title'];  ?>
                    </a>

                    <a class="reviews__list-btn reviews__list-btn--shablon default-btn" href="<?= $case_file;  ?>">
                      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 4L12 13M16 10L12.7071 13.2929C12.3166 13.6834 11.6834 13.6834 11.2929 13.2929L8 10M20 20L4 20" stroke-width="2" stroke-linecap="round" />
                      </svg>

                      Получить кейс
                    </a>

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
      <?php endif; ?>

      <!-- Блок отзывов из мессенджеров -->
      <?php if (!empty($grouped_reviews['Месседжеры'])): ?>
        <div class="reviews__splide reviews__splide--messengers splide">
          <div class="splide__track">
            <div class="reviews__list splide__list">
              <?php
              foreach ($grouped_reviews['Месседжеры'] as $review) {
                $screenshot = get_field('review_screen', $review->ID);
                $screenshot = Image::get_image_attrs($screenshot);
              ?>
                <div class="reviews__list-item splide__slide">
                  <div class="reviews__list-screenshot">
                    <img src="<?= $screenshot['url']; ?>" alt="<?= $screenshot['alt']; ?>" data-fancybox="reviews-messengers">
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
      <?php endif; ?>

      <div class="reviews__splide splide">
        <div class="splide__track">
          <div class="reviews__list splide__list">
            <?php
            foreach ($items as $item) {
              $image = $item['image'];
              $image = Image::get_image_attrs($image);
            ?>
              <div class="reviews__list-item splide__slide">
                <div class="reviews__list-image">
                  <img src="<?= $image['url']; ?>" alt="<?= $item['title']; ?>" data-fancybox="reviews">
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
<?php
?>