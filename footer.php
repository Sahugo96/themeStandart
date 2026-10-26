<?php
// Футер — статичная вёрстка по макету, к админке (Контактные данные, меню) пока не подключён.
$footer_services = [
  'Банковские счета',
  'ВНЖ / Emirates ID',
  'Компании в ОАЭ',
  'Компания в Гонконге',
  'Инвестиции',
  'Бизнес-услуги',
];

$footer_company = [
  'О компании',
  'Кейсы',
  'Отзывы',
  'Команда',
  'Документы',
  'Вопросы',
];
?>

<footer class="footer" id="footer">
  <div class="container">
    <div class="footer__body">
      <div class="footer__about">
        <a class="footer__logo" href="<?= esc_url(home_url('/')); ?>">Relocate<br>World</a>

        <address class="footer__info reg-par-14-20">
          © ООО / Starcompany Consultancies FZE<br>
          License 6502 · Free Zone Establishment<br>
          502, Al Hawai Tower, DIFC, Dubai, UAE
        </address>

        <p class="footer__hours reg-par-14-20">Пн–Сб · 08:00–19:00</p>

        <a class="footer__requisites reg-par-14-20" href="#">Реквизиты компании</a>
      </div>

      <nav class="footer__menu" aria-label="Услуги">
        <div class="footer__menu-title">Услуги</div>
        <ul class="footer__menu-list">
          <?php foreach ($footer_services as $footer_link) : ?>
            <li><a class="footer__menu-link reg-par-14-20" href="#"><?= esc_html($footer_link); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <nav class="footer__menu" aria-label="О нас">
        <div class="footer__menu-title">О нас</div>
        <ul class="footer__menu-list">
          <?php foreach ($footer_company as $footer_link) : ?>
            <li><a class="footer__menu-link reg-par-14-20" href="#"><?= esc_html($footer_link); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div class="footer__contacts">
        <a class="footer__phone" href="tel:+971554352459">+971 55 435 2459</a>

        <a class="footer__btn" href="#modal">Бесплатная консультация</a>

        <div class="footer__socials">
          <a class="footer__social" href="#" target="_blank" rel="noopener" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm5.4 13.9c-.2.6-1.3 1.2-1.8 1.3-.5 0-1 .2-3.3-.7-2.8-1.1-4.5-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.1.1.3 0 .5l-.3.5-.4.4c-.1.1-.3.3-.1.6.2.3.7 1.2 1.6 2 1.1.9 2 1.2 2.3 1.4.3.1.4.1.6-.1l.8-1c.2-.3.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.2.1.6-.2 1.1Z"/></svg>
          </a>
          <a class="footer__social" href="#" target="_blank" rel="noopener" aria-label="Telegram">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm4.6 6.8-1.6 7.7c-.1.6-.5.7-1 .4l-2.6-1.9-1.3 1.2c-.1.1-.3.3-.6.3l.2-2.7 4.9-4.4c.2-.2 0-.3-.3-.1l-6 3.8-2.6-.8c-.6-.2-.6-.6.1-.8l10.1-3.9c.5-.2.9.1.7.8Z"/></svg>
          </a>
          <a class="footer__social" href="#" target="_blank" rel="noopener" aria-label="VK">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm5.1 13.6h-1.5c-.6 0-.8-.5-1.8-1.5-.9-.8-1.3-.9-1.5-.9-.3 0-.4.1-.4.5v1.3c0 .4-.1.6-1.1.6-1.6 0-3.4-1-4.7-2.8-1.9-2.6-2.4-4.6-2.4-5 0-.2.1-.4.5-.4h1.5c.4 0 .5.2.7.6.7 2.1 2 3.9 2.5 3.9.2 0 .3-.1.3-.6V9.1c-.1-1-.6-1.1-.6-1.4 0-.2.1-.3.4-.3h2.4c.3 0 .4.2.4.5v2.9c0 .3.1.4.2.4.2 0 .4-.1.8-.5 1.2-1.4 2.1-3.5 2.1-3.5.1-.3.3-.5.7-.5h1.5c.5 0 .6.2.5.5-.2.9-2.1 3.6-2.1 3.6-.2.3-.2.4 0 .7.2.2.7.7 1.1 1.1.7.8 1.2 1.4 1.3 1.8.1.5-.1.7-.6.7Z"/></svg>
          </a>
        </div>

        <a class="footer__email reg-par-14-20" href="mailto:info@relocate-world.com">
          <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M2.5 4.5h15c.6 0 1 .4 1 1v9c0 .6-.4 1-1 1h-15c-.6 0-1-.4-1-1v-9c0-.6.4-1 1-1Zm.8 1.8L10 10.8l6.7-4.5v-.1H3.3v.1Z"/></svg>
          <span>info@relocate-world.com</span>
        </a>
      </div>
    </div>

    <div class="footer__bottom">
      <span class="footer__pill footer__copyright">© 2024–2026 Relocate-World. Все права защищены.</span>

      <div class="footer__legal">
        <a class="footer__pill" href="#" target="_blank">Политика конфиденциальности</a>
        <a class="footer__pill" href="#" target="_blank">Согласие на обработку ПД</a>
      </div>

      <a class="footer__pill footer__lang" href="#" hreflang="en" lang="en">EN</a>
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