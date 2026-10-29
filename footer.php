<?php
/**
 * Футер. Данные — «Настройки сайта → Контактные данные» (блоки «Контакты», «Футер»,
 * «Социальные сети»), меню колонок — области «Футер — колонка 1 / 2» (свои на каждом языке).
 */
$cd = tolstenko_get_contact_data();
$footer_logo = tolstenko_contact_get_image_attrs($cd['logo_footer']);
$footer_links = is_array($cd['footer_links']) ? $cd['footer_links'] : [];
$footer_menus = [
  [
    'title' => trim((string) $cd['footer_menu_1_title']) ?: 'Услуги',
    'html'  => theme_get_nav_menu_html('footer_menu_1', '', 'footer__menu-list'),
  ],
  [
    'title' => trim((string) $cd['footer_menu_2_title']) ?: 'О нас',
    'html'  => theme_get_nav_menu_html('footer_menu_2', '', 'footer__menu-list'),
  ],
];
$footer_phone = trim((string) $cd['phone']);
$footer_email = trim((string) $cd['email']);
$footer_address = trim((string) $cd['footer_address']);
$footer_hours = trim((string) $cd['footer_hours']);
$footer_copyright = trim((string) $cd['footer_copyright']);
$footer_btn = trim((string) $cd['footer_btn_text']) ?: 'Бесплатная консультация';

// Ссылки: 0 — согласие на обработку ПД, 1 — политика конфиденциальности, 2 — «Реквизиты компании».
$footer_link = static function (int $index) use ($footer_links): array {
  $link = is_array($footer_links[$index] ?? null) ? $footer_links[$index] : [];
  return ['title' => trim((string) ($link['title'] ?? '')), 'url' => trim((string) ($link['url'] ?? ''))];
};
$requisites = $footer_link(2);
$legal_links = array_filter([$footer_link(1), $footer_link(0)], static function ($link) {
  return $link['title'] !== '';
});

// Переключатель языка: другие языки сайта (Polylang).
$footer_langs = [];
if (function_exists('pll_the_languages')) {
  foreach ((array) pll_the_languages(['raw' => 1, 'hide_if_empty' => 0]) as $slug => $lang) {
    if (empty($lang['current_lang']) && !empty($lang['url'])) {
      $footer_langs[] = ['slug' => (string) $slug, 'url' => (string) $lang['url']];
    }
  }
}
?>

<footer class="footer" id="footer">
  <div class="container">
    <div class="footer__body">
      <div class="footer__about">
        <a class="footer__logo" href="<?= esc_url(home_url('/')); ?>">
          <?php if ($footer_logo['url'] !== '') : ?>
            <img class="footer__logo-img" src="<?= esc_url($footer_logo['url']); ?>" alt="<?= esc_attr(get_bloginfo('name')); ?>" loading="lazy">
          <?php else : ?>
            Relocate<br>World
          <?php endif; ?>
        </a>

        <?php if ($footer_address !== '') : ?>
          <address class="footer__info reg-par-14-20"><?= nl2br(esc_html($footer_address)); ?></address>
        <?php endif; ?>

        <?php if ($footer_hours !== '') : ?>
          <p class="footer__hours reg-par-14-20"><?= esc_html($footer_hours); ?></p>
        <?php endif; ?>

        <?php if ($requisites['title'] !== '') : ?>
          <a class="footer__requisites reg-par-14-20" href="<?= esc_url($requisites['url'] ?: '#'); ?>" target="_blank" rel="noopener"><?= esc_html($requisites['title']); ?></a>
        <?php endif; ?>
      </div>

      <?php foreach ($footer_menus as $footer_menu) : ?>
        <nav class="footer__menu" aria-label="<?= esc_attr($footer_menu['title']); ?>">
          <div class="footer__menu-title"><?= esc_html($footer_menu['title']); ?></div>
          <?= $footer_menu['html']; ?>
        </nav>
      <?php endforeach; ?>

      <div class="footer__contacts">
        <?php if ($footer_phone !== '') : ?>
          <a class="footer__phone" href="tel:<?= esc_attr(tolstenko_contact_phone_href($footer_phone)); ?>"><?= esc_html($footer_phone); ?></a>
        <?php endif; ?>

        <a class="footer__btn" href="#modal"><?= esc_html($footer_btn); ?></a>

        <div class="footer__socials">
          <?php get_template_part('modules/socials/socials'); ?>
        </div>

        <?php if ($footer_email !== '') : ?>
          <a class="footer__email reg-par-14-20" href="mailto:<?= esc_attr($footer_email); ?>">
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M2.5 4.5h15c.6 0 1 .4 1 1v9c0 .6-.4 1-1 1h-15c-.6 0-1-.4-1-1v-9c0-.6.4-1 1-1Zm.8 1.8L10 10.8l6.7-4.5v-.1H3.3v.1Z"/></svg>
            <span><?= esc_html($footer_email); ?></span>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer__bottom">
      <?php if ($footer_copyright !== '') : ?>
        <span class="footer__pill footer__copyright"><?= esc_html($footer_copyright); ?></span>
      <?php endif; ?>

      <?php if ($legal_links) : ?>
        <div class="footer__legal">
          <?php foreach ($legal_links as $legal_link) : ?>
            <a class="footer__pill" href="<?= esc_url($legal_link['url'] ?: '#'); ?>" target="_blank" rel="noopener"><?= esc_html($legal_link['title']); ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php foreach ($footer_langs as $footer_lang) : ?>
        <a class="footer__pill footer__lang" href="<?= esc_url($footer_lang['url']); ?>" hreflang="<?= esc_attr($footer_lang['slug']); ?>" lang="<?= esc_attr($footer_lang['slug']); ?>"><?= esc_html(strtoupper($footer_lang['slug'])); ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</footer>

<?php get_template_part('modules/modal/modal'); ?>
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
</script>
</body>

</html>