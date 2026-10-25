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
    $title = theme_get_field('reviews_title', OPTION_ID);
    $reviews_list = theme_get_field('reviews_list', OPTION_ID);
    $reviews_list_hide = theme_get_field('reviews_list_hide', OPTION_ID);
    $reviews = theme_get_field('reviews_review', OPTION_ID);
  }
} else {
  return;
}

if (empty($reviews) || !is_array($reviews)) {
  return;
}

// Верх секции (бейдж, общий рейтинг, карточки площадок, кнопка) — из таба «Отзывы» в дефолтах блоков.
$reviews_tab = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('reviews') : [];
$badge = trim((string) ($reviews_tab['subtitle'] ?? ''));
$score = trim((string) ($reviews_tab['score'] ?? ''));
$score_max = trim((string) ($reviews_tab['score_max'] ?? ''));
$score_text = trim((string) ($reviews_tab['score_text'] ?? ''));
$leave_text = trim((string) ($reviews_tab['btn_text'] ?? ''));
$leave_url = trim((string) ($reviews_tab['btn_url'] ?? '')) ?: '#modal';

// Карточки площадок: из таба, иначе — прежний ACF-список reviews_list.
$platforms = [];
$tab_cards = is_array($reviews_tab['cards'] ?? null) ? $reviews_tab['cards'] : [];

if (!empty($tab_cards)) {
  if (!empty($reviews_tab['show_items'])) {
    foreach ($tab_cards as $card) {
      $platforms[] = [
        'title'  => (string) ($card['title'] ?? ''),
        'url'    => (string) ($card['url'] ?? ''),
        'rating' => (string) ($card['rating'] ?? ''),
        'icon'   => !empty($card['icon']) ? tolstenko_contact_get_image_attrs((int) $card['icon']) : [],
      ];
    }
  }
} elseif ($reviews_list && $reviews_list_hide) {
  foreach ((array) $reviews_list as $item) {
    $platforms[] = [
      'title'  => (string) ($item['link']['title'] ?? ''),
      'url'    => (string) ($item['link']['url'] ?? ''),
      'rating' => number_format((float) ($item['rating'] ?? 0), 1, '.', ''),
      'icon'   => [],
    ];
  }
}

// Группируем отзывы по типу (порядок — как у табов).
$grouped_reviews = array(
  'Текстовые' => array(),
  'Мессенджеры' => array(),
  'Видео' => array(),
);

foreach ($reviews as $review) {
  $review_type = theme_get_field('review_type', $review->ID);
  if (isset($grouped_reviews[$review_type])) {
    $grouped_reviews[$review_type][] = $review;
  }
}

// Значение радио-кнопки таба → модификатор слайдера (reviews__splide--<value>).
$review_tabs = array(
  'Текстовые' => 'text',
  'Мессенджеры' => 'thenks',
  'Видео' => 'video',
);

$star_svg = '<svg viewBox="0 0 20 20" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.9-4.3 4.1 1 5.8L10 14.9l-5.2 2.7 1-5.8L1.5 7.7l5.9-.9L10 1.5z"/></svg>';
?>
<section class="reviews section section--white load-on-vissible--js"
  aria-label="Splide direction"
  data-module="./libs/splide.min.js,./modules/reviewsSplideInit.js,./modules/reviewsFancybox.js,./modules/reviewsVideoLightbox.js"
  data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css,<?= THEME_PATH; ?>/assets/css/libs/fancybox.css">
  <div class="container">
    <div class="reviews__inner">
      <div class="reviews__top section-top">
        <?php if ($badge !== '') : ?>
          <span class="reviews__badge section-subtitle"><?= esc_html($badge); ?></span>
        <?php endif; ?>
        <h2 class="reviews__title section-title"><?= $title; ?></h2>
      </div>

      <?php if ($score !== '') : ?>
        <div class="reviews__score">
          <div class="reviews__score-value">
            <span class="reviews__score-num"><?= esc_html($score); ?></span>
            <?php if ($score_max !== '') : ?>
              <span class="reviews__score-of reg-small-12-15">из</span>
              <span class="reviews__score-num"><?= esc_html($score_max); ?></span>
            <?php endif; ?>
          </div>

          <div class="reviews__score-stars" aria-label="<?= esc_attr($score . ($score_max !== '' ? ' из ' . $score_max : '')); ?>">
            <?php for ($i = 1; $i <= 5; $i++) echo $star_svg; ?>
          </div>

          <?php if ($score_text !== '') : ?>
            <p class="reviews__score-text reg-small-12-15"><?= esc_html($score_text); ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="reviews__panel">
        <?php if (!empty($platforms)) : ?>
          <div class="reviews__items">
            <?php foreach ($platforms as $platform) : ?>
              <?php $platform_tag = $platform['url'] !== '' ? 'a' : 'div'; ?>
              <<?= $platform_tag; ?> class="reviews__item"<?php if ($platform['url'] !== '') : ?> href="<?= esc_url($platform['url']); ?>" target="_blank" rel="noopener"<?php endif; ?>>
                <?php if (!empty($platform['icon']['url'])) : ?>
                  <img class="reviews__item-icon" src="<?= esc_url($platform['icon']['url']); ?>" alt="" loading="lazy">
                <?php endif; ?>
                <span class="reviews__item-body">
                  <?php if ($platform['rating'] !== '') : ?>
                    <span class="reviews__item-number h2-18-20"><?= esc_html($platform['rating']); ?></span>
                  <?php endif; ?>
                  <span class="reviews__item-link tag-10-10"><?= esc_html($platform['title']); ?></span>
                </span>
              </<?= $platform_tag; ?>>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php $checked = 'checked'; ?>
        <div class="reviews__tabs filter filter--tabs">
          <div class="reviews__labels filter__form">
            <?php foreach ($review_tabs as $tab_name => $tab_value) : ?>
              <?php if (!empty($grouped_reviews[$tab_name])) : ?>
                <label class="reviews__label filter__link">
                  <input type="radio" value="<?= esc_attr($tab_value); ?>" name="reviews" <?= $checked; ?>>
                  <span class="filter__label"><?= esc_html($tab_name); ?></span>
                </label>
                <?php $checked = ''; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>

          <?php if ($leave_text !== '') : ?>
            <a class="reviews__leave filter__more" href="<?= esc_url($leave_url); ?>">
              <span><?= esc_html($leave_text); ?></span>
              <svg class="filter__more-arrow" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 12h16M14 6l6 6-6 6"/>
              </svg>
            </a>
          <?php endif; ?>
        </div>
      </div>


      <!-- Блок Мессенджеры -->
      <?php if (!empty($grouped_reviews['Мессенджеры'])): ?>
        <div class="reviews__splide reviews__splide--thenks splide">
          <div class="splide__track">
            <div class="reviews__list splide__list">
              <?php
              foreach ($grouped_reviews['Мессенджеры'] as $review) {
                $image = theme_get_field('review_thenks', $review->ID);
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
                $video = html_entity_decode(trim((string) theme_get_field('review_video', $review->ID)), ENT_QUOTES, 'UTF-8');

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
                $video_name = trim((string) theme_get_field('review_video_name', $review->ID));
                $video_text = trim((string) theme_get_field('review_video_text', $review->ID));
                $video_has_meta = $video_name !== '' && $video_text !== '';

                $logo = theme_get_field('review_logo', $review->ID);
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
                $name = theme_get_field('review_name', $review->ID);
                $position = theme_get_field('review_position', $review->ID);
                $rating = theme_get_field('review_rating', $review->ID);
                $redactor = theme_get_field('review_redactor', $review->ID);
                $icon = Image::get_image_attrs(theme_get_field('review_platform_icon', $review->ID));
                $platform_name = theme_get_field('review_platform_name', $review->ID);
                $publish_date = '';
                if ( $pub_time = get_post_time('U', false, $review->ID) ) {
                    $day = date('j', $pub_time);
                    $month = date('M', $pub_time);
                    $year = date('Y', $pub_time);
                    $months = array('Jan'=>'янв','Feb'=>'фев','Mar'=>'мар','Apr'=>'апр','May'=>'май','Jun'=>'июн','Jul'=>'июл','Aug'=>'авг','Sep'=>'сен','Oct'=>'окт','Nov'=>'ноя','Dec'=>'дек');
                    $publish_date = sprintf( '%s %s. %s', $day, empty($months[$month]) ? $month : $months[$month], $year );
                }

                $photo = theme_get_field('review_photo', $review->ID);
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
                    <?php if ( ! empty( $icon['url'] ) ) : ?>
                      <div class="reviews__list-btn-icon">
                        <img src="<?= $icon['url']; ?>" alt="<?= $platform_name; ?>">
                      </div>
                    <?php endif; ?>
                    <?php if ( $platform_name ) : ?>
                      <div class="reviews__list-btn-name"><?= $platform_name; ?></div>
                    <?php endif; ?>
                    <div class="reviews__list-btn-date"><?= $publish_date; ?></div>
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
