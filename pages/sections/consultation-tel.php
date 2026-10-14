<?php
$cd = tolstenko_get_contact_data();
$section = get_query_var('section');

if ($section && $section !== true && is_array($section) && !empty($section['consultation_tel_rewrite'])) {
  $title = $section['consultation_tel_title'];
  $img = $section['consultation_tel_image'];
  $message = $section['consultation_tel_message'];
  $position = $section['consultation_tel_position'];
  $btn = $section['consultation_tel_btn'];
  $whatsapp = $section['consultation_tel_whatsapp'];
  $color = $section['consultation_tel_whatsapp_color'];
  $color_hover = $section['consultation_tel_whatsapp_color_hover'];
  $img = Image::get_image_attrs($img);
} else {
  $title = get_field('consultation_tel_title', OPTION_ID);
  $message = get_field('consultation_tel_message', OPTION_ID);
  $position = get_field('consultation_tel_position', OPTION_ID);
  $btn = get_field('consultation_tel_btn', OPTION_ID);
  $whatsapp = get_field('consultation_tel_whatsapp', OPTION_ID);
  $color = get_field('consultation_tel_whatsapp_color', OPTION_ID);
  $color_hover = get_field('consultation_tel_whatsapp_color_hover', OPTION_ID);
  $img = Image::get_image_attrs(get_field('consultation_tel_image', OPTION_ID));
}
?>
<section class="consultation-tel section">
  <div class="container">
    <div class="consultation-tel__inner">
      <div class="consultation-tel__left">
        <div class="consultation-tel__left-top">
          <div class="consultation-tel__img">
            <img class="lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $img['url']; ?>" data-srcset="<?= $img['srcset']; ?>" alt="<?= $img['alt']; ?>" data-sizes="<?= $img['sizes']; ?>">
          </div>

          <div class="consultation-tel__message br-20">
            <?php if ($message) { ?>
              <div class="consultation-tel__message-text"> <?= $message;  ?> </div>
            <?php } ?>

            <?php if ($position) { ?>
              <div class="consultation-tel__message-bottom paragraph-15-15">
                <?= $position;  ?>

                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.5 10.625L5.625 13.75L13.125 6.25M10 12.5L11.25 13.75L18.75 6.25" stroke="#2B271F" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
            <?php } ?>

            <svg class="consultation-tel__message-angle" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0L20 15V0H0Z" />
            </svg>
          </div>
        </div>

        <div class="consultation-tel__btns">
          <a class="consultation-tel__btn consultation-tel__btn--tel default-btn line-caps-bold-13-15" href="tel:<?= str_replace(['+', ' ', '(', ')', '-'], '', $cd['phone']); ?>" target="_blank">
            <?php
            $svg_url = tolstenko_contact_resolve_icon_url($cd['phone_ico']);
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>

            <span><?= $btn; ?></span>
          </a>

          <a class="consultation-tel__btn default-btn default-btn--whatsapp line-caps-bold-13-15" href="<?= $cd['telegram']; ?>" target="_blank" style="--color-btn: <?= $color; ?>; --color-hover-btn: <?= $color_hover; ?>">
            <?php
            $svg_url = tolstenko_contact_resolve_icon_url($cd['telegram_ico']);
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>

            <span><?= $whatsapp; ?></span>
          </a>
        </div>
      </div>


      <div class="consultation-tel__right">
        <h2 class="consultation-tel__title h2"><?= $title;  ?></h2>

        <svg class="consultation-tel__quote" viewBox="0 0 35 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3571 29.7308C29.866 24.7733 34.0377 19.0027 34.872 12.4193C36.1713 2.17096 27.2564 -2.84505 22.739 1.66146C18.2217 6.16798 20.9291 11.8893 24.1999 13.4537C27.4708 15.018 29.4711 14.4727 29.1221 16.5629C28.7731 18.6532 24.1202 24.4462 20.0316 27.1444C19.887 27.2712 19.7947 27.4499 19.7736 27.6441C19.7524 27.8383 19.8041 28.0336 19.9179 28.1901L20.9291 29.5422C21.3679 30.1286 21.7887 30.106 22.3571 29.7319M2.58657 29.7308C10.0955 24.7733 14.2671 19.0027 15.1015 12.4193C16.4018 2.17096 7.48683 -2.84505 2.96951 1.66146C-1.54782 6.16798 1.15958 11.8893 4.4314 13.4537C7.70322 15.018 9.70261 14.4727 9.35359 16.5629C9.00457 18.6532 4.35063 24.4462 0.2621 27.1444C0.117573 27.2713 0.0254824 27.4501 0.00455495 27.6443C-0.0163763 27.8385 0.0354196 28.0337 0.149414 28.1901L1.15958 29.5422C1.59835 30.1286 2.01917 30.106 2.58657 29.7319" />
        </svg>
      </div>
    </div>
  </div>
</section>
<?php
set_query_var('section', null);
?>
