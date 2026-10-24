<?php
$hero_data = get_query_var('hero_data');
$section = get_query_var('section');

if (is_array($hero_data) && $hero_data) {
  $title = $hero_data['title'] ?? '';
  $text = $hero_data['text'] ?? '';
  $items = $hero_data['items'] ?? [];
  $btn_text = $hero_data['btn_text'] ?? '';
  $btn_text_hide = !empty($hero_data['show_promo']);
  $btn_close_text = $hero_data['promo_text'] ?? '';
  $name = $hero_data['person_name'] ?? '';
  $position = $hero_data['person_position'] ?? '';
  $img = Image::get_image_attrs($hero_data['image'] ?? null);
} elseif ($section) {
  if ($section != true && $section['hero_rewrite']) {
    $title = $section['hero_title'];
    $text = $section['hero_text'];
    $img = $section['hero_img'];
    $items = $section['hero_items'];

    $btn_text = $section['hero_btn'];
    $btn_text_hide = $section['hero_btn_hide'];
    $btn_close_text = $section['hero_btn_close'];
    $name = $section['hero_name'];
    $position = $section['hero_position'];
  } else {
    $title = theme_get_field('hero_title', OPTION_ID);
    $text = theme_get_field('hero_text', OPTION_ID);
    $img = theme_get_field('hero_img', OPTION_ID);
    $items = theme_get_field('hero_items', OPTION_ID);

    $btn_text = theme_get_field('hero_btn', OPTION_ID);
    $btn_text_hide = theme_get_field('hero_btn_hide', OPTION_ID);
    $btn_close_text = theme_get_field('hero_btn_close', OPTION_ID);
    $name = theme_get_field('hero_name', OPTION_ID);
    $position = theme_get_field('hero_position', OPTION_ID);
  }

  $img = Image::get_image_attrs($img);
} else {
  return;
}

$present = theme_get_field('present_ico', OPTION_ID);
$present = $present ? Image::get_image_attrs($present) : null;
?>
<section class="hero">
  <div class="container">
    <div class="hero__inner">
      <div class="hero__title h1"><?= $title; ?></div>

      <?php if ($text) { ?>
        <div class="hero__text line-13-15"><?= $text; ?></div>
      <?php } ?>

      <?php if ($items) { ?>
        <div class="hero__list">
          <?php foreach ($items as $item) { ?>
            <div class="hero__list-item">
              <svg class="hero__list-svg" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15 28.75C22.5941 28.75 28.75 22.5941 28.75 15C28.75 7.40588 22.5941 1.25 15 1.25C7.40588 1.25 1.25 7.40588 1.25 15C1.25 22.5941 7.40588 28.75 15 28.75ZM15.6463 10.1463C15.8396 9.95313 16.1017 9.84466 16.375 9.84466C16.6483 9.84466 16.9104 9.95313 17.1037 10.1463L21.2288 14.2713C21.4219 14.4646 21.5303 14.7267 21.5303 15C21.5303 15.2733 21.4219 15.5354 21.2288 15.7287L17.1037 19.8537C17.0093 19.9551 16.8955 20.0363 16.769 20.0927C16.6425 20.1491 16.5059 20.1794 16.3675 20.1818C16.229 20.1843 16.0915 20.1588 15.9631 20.1069C15.8346 20.0551 15.718 19.9779 15.6201 19.8799C15.5221 19.782 15.4449 19.6654 15.3931 19.5369C15.3412 19.4085 15.3157 19.271 15.3182 19.1325C15.3206 18.9941 15.3509 18.8575 15.4073 18.731C15.4637 18.6045 15.5449 18.4907 15.6463 18.3963L18.0112 16.0312H9.5C9.2265 16.0312 8.96419 15.9226 8.7708 15.7292C8.5774 15.5358 8.46875 15.2735 8.46875 15C8.46875 14.7265 8.5774 14.4642 8.7708 14.2708C8.96419 14.0774 9.2265 13.9688 9.5 13.9688H18.0112L15.6463 11.6037C15.4531 11.4104 15.3447 11.1483 15.3447 10.875C15.3447 10.6017 15.4531 10.3396 15.6463 10.1463Z" />
              </svg>

              <p class="hero__list-text line-13-15"><?= $item['text']; ?></p>
            </div>
          <?php } ?>
        </div>
      <?php } ?>

      <div class="hero__bottom">
        <a class="hero__btn default-btn default-btn--huge" href="#modal"><?= $btn_text; ?></a>

        <?php if ($btn_text_hide && !empty($present['url'])) { ?>
          <div class="hero__bottom-text line-13-15"><?= $btn_close_text; ?></div>

          <img class="hero__bottom-present lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $present['url']; ?>" data-srcset="<?= $present['srcset']; ?>" alt="<?= $present['alt']; ?>" data-sizes="<?= $present['sizes']; ?>">

        <?php } ?>
      </div>

      <?php if (!empty($img['url'])) { ?>
        <div class="hero__img">
          <img class="lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $img['url']; ?>" data-srcset="<?= $img['srcset']; ?>" alt="<?= $img['alt']; ?>" data-sizes="<?= $img['sizes']; ?>">
        </div>
      <?php } ?>

      <div class="hero__person">
        <div class="hero__person-wrapper">
          <span class="hero__person-name line-caps-bold-13-15"><?= $name; ?></span>
          <span class="hero__person-position paragraph-13-20"><?= $position; ?></span>
        </div>

        <div class="hero__person-svg">
          <svg viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.13293 0L9.30186 4.51473L14.2659 5.18237L10.6423 8.64027L11.5413 13.5676L7.13293 11.19L2.72455 13.5676L3.62354 8.64027L1.04904e-05 5.18237L4.96401 4.51473L7.13293 0Z" />
          </svg>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
set_query_var('section', null);
?>
