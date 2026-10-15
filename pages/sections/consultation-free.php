<?php
$cd = tolstenko_get_contact_data();
$consultation_data = get_query_var('consultation_free_data');
$section = get_query_var('section');

if ($consultation_data) {
  $title = $consultation_data['title'] ?? '';
  $text = $consultation_data['text'] ?? '';
  $subtitle = $consultation_data['subtitle'] ?? '';
  $img_raw = $consultation_data['image'] ?? null;
  $img = $img_raw ? Image::get_image_attrs($img_raw) : null;
} elseif ($section && $section !== true && is_array($section) && !empty($section['consultation_free_rewrite'])) {
  $title = $section['consultation_free_title'];
  $text = $section['consultation_free_text'];
  $subtitle = $section['consultation_free_subtitle'];
  $img = get_field('consultation_free_image', OPTION_ID);
  $img = Image::get_image_attrs($img);
} else {
  $title = get_field('consultation_free_title', OPTION_ID);
  $text = get_field('consultation_free_text', OPTION_ID);
  $subtitle = get_field('consultation_free_subtitle', OPTION_ID);
  $img = get_field('consultation_free_image', OPTION_ID);
  $img = Image::get_image_attrs($img);
}
?>
<section class="consultation-free section">
  <div class="container">
    <div class="consultation-free__inner br-30">
      <div class="consultation-free__left">
        <div class="consultation-free__top">
          <h2 class="consultation-free__title h2"><?= $title; ?></h2>

          <?php if ($text) { ?>
          <div class="consultation-free__text paragraph-15-15"><?= $text; ?></div>
          <?php } ?>
        </div>

        <div class="consultation-free__form form br-20">
          <?php if ($subtitle) { ?>
          <div class="consultation-free__subtitle line-caps-bold-16-15"><?= $subtitle; ?></div>
          <?php } ?>

          <?php echo do_shortcode('[contact-form-7 id="5d6571e" title="Бесплатная консультация"]'); ?>
        </div>

        <div class="consultation-free__btns">
          <div class="consultation-free__btns-text line-caps-bold-13-15">Или свяжитесь с нами:</div>

          
          <a class="consultation-free__btn consultation-free__btn--tel default-btn line-caps-bold-13-15" href="tel:<?= str_replace(['+', ' ', '(', ')', '-'], '', $cd['phone']); ?>" target="_blank">
            <?php
            $svg_url = tolstenko_contact_resolve_icon_url($cd['phone_ico']);
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>

            <span>
              <?= $cd['phone']; ?>
            </span>
          </a>

          <a class="consultation-free__btn default-btn line-caps-bold-13-15" href="<?= $cd['telegram']; ?>" target="_blank">
            <?php
            $svg_url = tolstenko_contact_resolve_icon_url($cd['telegram_ico']);
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>
          </a>

          <a class="consultation-free__btn default-btn line-caps-bold-13-15" href="<?= $cd['vk_link']; ?>" target="_blank">
            <?php
            $svg_url = tolstenko_contact_resolve_icon_url($cd['vk_ico']);
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>
          </a>

          <a class="consultation-free__btn default-btn line-caps-bold-13-15" href="<?= $cd['max_link']; ?>" target="_blank">
            <?php
            $svg_url = tolstenko_contact_resolve_icon_url($cd['max_ico']);
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>
          </a>
        </div>
      </div>


      <div class="consultation-free__img">
        <?php if (!empty($img['url'])) { ?>
        <img class="lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $img['url']; ?>" data-srcset="<?= $img['srcset']; ?>" alt="<?= $img['alt']; ?>" data-sizes="<?= $img['sizes']; ?>">
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<?php
?>