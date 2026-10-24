<section class="services section anim-hot-section load-on-vissible--js" data-module="./modules/accordion.js,./modules/animHotLogo.js">
  <div class="container">

    <div class="section-top">
      <h1 class="services__title h1"><?= theme_get_field('services_title') ?></h1>
    </div>

    <div class="services__items">
      <?php
      $items = theme_get_field('services_items');
      $items = is_array($items) ? $items : [];
      foreach ($items as $item) {
        $ico = $item['ico'];
        $ico = Image::get_image_attrs($ico);
      ?>
        <div class="services__item border-card">
          <div class="services__item-top">
            <div class="services__item-ico">
              <img src="<?= $ico['url']; ?>" alt="<?= $item['title']; ?>">
            </div>

            <h3 class="services__item-subtitle h3"><?= $item['title']; ?></h3>
          </div>

          <?php
          $list = $item['list'];
          foreach ($list as $elem) {
          ?>
            <p class="services__item-text"><?= $elem['text']; ?></p>
          <?php
          }
          ?>
        </div>
      <?php
      }
      ?>
    </div>

    <?php get_template_part('./modules/anim-block/anim-block'); ?>

    <div class="services__note border-card">
      <svg class="services__note-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_201_7801)">
          <path d="M24 0H0V24H24V0Z" fill="white" fill-opacity="0.01" />
          <path d="M12 22C14.7614 22 17.2614 20.8807 19.0711 19.0711C20.8807 17.2614 22 14.7614 22 12C22 9.2386 20.8807 6.7386 19.0711 4.92893C17.2614 3.11929 14.7614 2 12 2C9.2386 2 6.7386 3.11929 4.92893 4.92893C3.11929 6.7386 2 9.2386 2 12C2 14.7614 3.11929 17.2614 4.92893 19.0711C6.7386 20.8807 9.2386 22 12 22Z" stroke="#3C899A" stroke-width="1.5" stroke-linejoin="round" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.5C12.6904 5.5 13.25 6.05965 13.25 6.75C13.25 7.44035 12.6904 8 12 8C11.3097 8 10.75 7.44035 10.75 6.75C10.75 6.05965 11.3097 5.5 12 5.5Z" fill="#3C899A" />
          <path d="M12.25 17V10H11.75H11.25" stroke="#3C899A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M10.5 17H14" stroke="#3C899A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </g>
      </svg>

      <p><?= theme_get_field('services_note') ?></p>
    </div>

    <div class="services__list accordion-group">
      <?php
      $active = " active";
      $items = theme_get_field('services_list');
      $items = is_array($items) ? $items : [];
      $current_anchor = isset($_GET['anchor']) ? '#' . $_GET['anchor'] : '';

      foreach ($items as $index => $item) {
          $active = '';
          
          if ($current_anchor && $current_anchor === '#' . $item['title_id']) {
              $active = ' active';
          } elseif (!$current_anchor && $index === 0) {
              $active = ' active';
          }
      ?>
        <div class="services__elem border-card accordion <?= $active; ?> ?>" id="<?= $item['title_id']; ?>">
          <div class="services__elem-top accordion-top">
            <h3 class="services__elem-subtitle h3"><?= $item['title']; ?></h3>


            <svg class="services__elem-plus h3" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.0251 4.16699L10.0098 15.8337" stroke="#3C899A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M4.16602 10H15.8327" stroke="#3C899A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>

          <div class="services__elem-redactor redactor"><?= $item['redactor']; ?></div>
        </div>
      <?php
        $active = "";
      }
      ?>
    </div>

    <div class="services__wrapper">
      <div class="services__wrapper-title h2"><?= theme_get_field('price_text', 136); ?></div>

      <a class="services__wrapper-link default-btn default-btn--svg" href="<?= theme_get_field('price_file', 136)['url']; ?>" target="_blank">
        Скачать PDF

        <div class="default-btn__svg">
          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2.5 10.0035V17.5H17.5V10" stroke="#3C899A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M13.75 9.58301L10 13.333L6.25 9.58301" stroke="#3C899A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M9.99609 2.5V13.3333" stroke="#3C899A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </div>
      </a>
    </div>
  </div>
</section>