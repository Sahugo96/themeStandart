<?php
$cd = tolstenko_get_contact_data();
$logo_img = tolstenko_contact_get_image_attrs($cd['logo_footer']);


$audit_img = tolstenko_contact_get_image_attrs($cd['footer_audit_img']);



$footer_menu = wp_nav_menu(
  array(
    'menu' => 'footer-menu',
    'container' => false,
    'menu_class' => 'footer__menu-list menu__list',
    'walker' => '',
    'echo' => false,
  )
);
$footer_services_menu = wp_nav_menu(
  array(
    'menu' => 'footer-services-menu',
    'container' => false,
    'menu_class' => 'footer__menu-list menu__list',
    'walker' => '',
    'echo' => false,
  )
);
?>


<?php
get_template_part('modules/modal/modal');
?>



<!-- <footer class="footer" id="footer">
  <div class="footer__body">
    <div class="footer__left">
      <a class="footer__logo logo" href="<?= home_url(); ?>">
        <img class="logo__img" src="<?= $logo_img['url']; ?>" <?php if ($logo_img['srcset']) echo 'srcset="' . $logo_img['srcset'] . '"' ?> alt="<?= $logo_img['alt']; ?>" <?php if ($logo_img['sizes']) echo 'sizes="' . $logo_img['sizes'] . '"' ?>>
      </a>

      <div class="footer__info">
        <span><?= $cd['footer_name']; ?></span>
        <span><?= $cd['footer_inn']; ?></span>
        <span><?= $cd['footer_ogrn']; ?></span>
      </div>

      <address class="footer__address"><?= $cd['footer_address']; ?></address>
    </div>

    <div class="footer__menu line-13-15">
      <div class="footer__menu-title paragraph-15-15">Услуги</div>

      <?= $footer_services_menu; ?>
    </div>

    <div class="footer__menu line-13-15">
      <div class="footer__menu-title paragraph-15-15">О нас</div>

      <?= $footer_menu; ?>
    </div>


    <div class="footer__right">
      <div class="footer__right-links">
        <a class="footer__right-link footer__right-link--tel default-btn line-caps-bold-13-15" href="tel:<?= str_replace(['+', ' ', '(', ')', '-'], '', $cd['phone']); ?>" target="_blank">
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

        <a class="footer__right-link default-btn line-caps-bold-13-15" href="<?= $cd['max_link']; ?>" target="_blank">
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

        <a class="footer__right-link default-btn line-caps-bold-13-15" href="<?= $cd['telegram']; ?>" target="_blank">
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
      </div>

      
      <a class="footer__audit default-btn footnote-12-10" href="<?= $cd['whatsapp']; ?>" target="_blank">
        <img class="logo__img" src="<?= $audit_img['url']; ?>" <?php if ($audit_img['srcset']) echo 'srcset="' . $audit_img['srcset'] . '"' ?> alt="<?= $audit_img['alt']; ?>" <?php if ($audit_img['sizes']) echo 'sizes="' . $audit_img['sizes'] . '"' ?>>

          Бесплатный аудит
        </a>

      <div class="footer__contacts">
        <div class="footer__contacts-item">
          <span>Эл.почта</span>

          <a class="footer__contacts-link" href="mailto:<?= $cd['email']; ?>" target="_blank">
            <?php
            $svg_url = tolstenko_contact_resolve_icon_url($cd['email_ico']);
            if ($svg_url) {
              $svg_content = file_get_contents($svg_url);

              if ($svg_content) {
                echo $svg_content;
              }
            }
            ?>

            <span>
              <?= $cd['email']; ?>
            </span>
          </a>
        </div>

        <div class="footer__contacts-item">
          <span>Соц.сети</span>

          <?php get_template_part('modules/socials/socials'); ?>
        </div>
      </div>
      
      <a class="footer__right-btn footnote-12-10" href="<?= $cd['whatsapp']; ?>" target="_blank">Написать WhatsApp</a>
    </div>
  </div>

  <div class="footer__bottom">
    <span class="footer__copyrite line-13-15"><?= $cd['footer_copyright']; ?></span>

    <a class="footer__bottom-link line-13-15" href="<?= $cd['footer_links'][0]['url']; ?>" target="_blank"><?= $cd['footer_links'][0]['title']; ?></a>

    <a class="footer__bottom-link line-13-15" href="<?= $cd['footer_links'][1]['url']; ?>" target="_blank"><?= $cd['footer_links'][1]['title']; ?></a>

    <a class="footer__bottom-link line-13-15" href="<?= $cd['footer_links'][2]['url']; ?>" target="_blank"><?= $cd['footer_links'][2]['title']; ?></a>
  </div>
</footer>
</div>


<?php wp_footer(); ?>


<script>
  window.addEventListener("load", () => {
    let script = document.createElement("script");
    script.src = "<?= THEME_PATH; ?>/assets/js/app.js"; // Путь к файлу
    document.body.appendChild(script);

    script.onload = () => {
      console.log("Скрипт app.min.js успешно загружен!");
      new DynamicLoader({
        onVisible: [".load-on-vissible--js"], // Элементы для наблюдения
        onClick: [".load-on-click--js"], // Элементы для загрузки по клику
      });
    };

    script.onerror = () => {
      console.error("Ошибка загрузки скрипта app.min.js!");
    };
  });
</script> -->
</body>

</html>