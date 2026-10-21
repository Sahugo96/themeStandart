<?php

/**
 * Template Name: Main page
 */

get_header();
?>

<main class="main">
    <?php
    if (is_front_page()) {
        theme_output_front_page_blocks();
    } else {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }

    // Hardcoded-секции вынесены в блоки (my-theme/*) с дефолтами.
    // Если на странице есть соответствующий Gutenberg-блок — выводится он,
    // иначе подставляются дефолты секции.

    
    
    theme_render_front_section('hero-stats'); // +
    theme_render_front_section('situations'); // +

    theme_render_front_section('process'); // +
    theme_render_front_section('about'); // +
    theme_render_front_section('result'); // +
    
    theme_render_front_section('compare');

    theme_render_front_section('why-us'); // +
    theme_render_front_section('infra'); // +
    theme_render_front_section('documents'); // +
    theme_render_front_section('cost'); // +


    theme_render_front_section('guide');
    theme_render_front_section('team'); // +
    theme_render_front_section('faq');
    theme_render_front_section('blog-more');
    theme_render_front_section('consult');
    ?>


<!-- ===== Кейсы: «Как это выглядит на практике» ===== -->
<section class="cases">
  <div class="container">
    <div class="cases__top">
      <span class="cases__badge">Кейсы</span>
      <h2 class="cases__title">
        Как это выглядит
        <span class="cases__title-accent">на практике</span>
      </h2>
    </div>

    <!-- Фильтр по рубрикам: только разметка, логику фильтрации подключаете сами -->
    <div class="cases__filter">
      <ul class="cases__tabs">
        <li><button class="cases__tab active" type="button" data-filter="accounts">Счета</button></li>
        <li><button class="cases__tab" type="button" data-filter="residence">ВНЖ</button></li>
        <li><button class="cases__tab" type="button" data-filter="companies">Компании</button></li>
      </ul>
      <a class="cases__all" href="/cases/">
        <span>Все кейсы</span>
        <svg class="cases__all-arrow" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M4 12h16M14 6l6 6-6 6"/>
        </svg>
      </a>
    </div>

    <div class="fade-in-container cases__splide splide load-on-vissible--js"
      aria-label="Кейсы"
      data-module="./libs/splide.min.js,./modules/casesSplideInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="cases-container">
      <div class="splide__track">
        <div class="cases__splide-list splide__list">

          <article class="cases__card fade-in-element splide__slide">
            <span class="cases__card-tag">Счёт нерезиденту</span>
            <h3 class="cases__card-title">Банк в ЕС<br>закрыл счёт</h3>
            <div class="cases__story">
              <div class="cases__step">
                <span class="cases__step-label">Задача:</span>
                <p class="cases__step-text">Банк в ЕС закрыл счёт, клиент был за пределами ОАЭ.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Решение:</span>
                <p class="cases__step-text">Подобрали банк для нерезидента, сопровождали комплаенс.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Результат:</span>
                <p class="cases__step-text">Счёт открыт дистанционно.</p>
              </div>
            </div>
            <ul class="cases__facts">
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6.5V12l3.5 2" /></svg>
                  Срок
                </span>
                <span class="cases__fact-value">12 дней</span>
              </li>
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 8V6a2 2 0 0 1 2-2h11v4"/><rect x="3" y="8" width="18" height="12" rx="2"/><circle cx="16.5" cy="14" r="1.3"/></svg>
                  Экономия
                </span>
                <span class="cases__fact-value">~$4 000</span>
              </li>
            </ul>
          </article>

          <article class="cases__card fade-in-element splide__slide">
            <span class="cases__card-tag">Корпоративный счёт</span>
            <h3 class="cases__card-title">Оплаты от зарубежных клиентов</h3>
            <div class="cases__story">
              <div class="cases__step">
                <span class="cases__step-label">Задача:</span>
                <p class="cases__step-text">Нужен счёт под международные расчёты компании.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Решение:</span>
                <p class="cases__step-text">Открыли корпоративный счёт во фризоне.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Результат:</span>
                <p class="cases__step-text">Приём валютной выручки.</p>
              </div>
            </div>
            <ul class="cases__facts">
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6.5V12l3.5 2" /></svg>
                  Срок
                </span>
                <span class="cases__fact-value">от 2 недель</span>
              </li>
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 8V6a2 2 0 0 1 2-2h11v4"/><rect x="3" y="8" width="18" height="12" rx="2"/><circle cx="16.5" cy="14" r="1.3"/></svg>
                  Экономия
                </span>
                <span class="cases__fact-value">~$4 000</span>
              </li>
            </ul>
          </article>

          <article class="cases__card fade-in-element splide__slide">
            <span class="cases__card-tag">Недвижимость</span>
            <h3 class="cases__card-title">Счёт под покупку<br>в Дубае</h3>
            <div class="cases__story">
              <div class="cases__step">
                <span class="cases__step-label">Задача:</span>
                <p class="cases__step-text">Счёт для оплаты объекта и обслуживания.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Решение:</span>
                <p class="cases__step-text">Открыли личный счёт, оформили платежи по сделке.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Результат:</span>
                <p class="cases__step-text">Сделка проведена через счёт в ОАЭ.</p>
              </div>
            </div>
            <ul class="cases__facts">
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6.5V12l3.5 2" /></svg>
                  Срок
                </span>
                <span class="cases__fact-value">12 дней</span>
              </li>
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 8V6a2 2 0 0 1 2-2h11v4"/><rect x="3" y="8" width="18" height="12" rx="2"/><circle cx="16.5" cy="14" r="1.3"/></svg>
                  Экономия
                </span>
                <span class="cases__fact-value">~$4 000</span>
              </li>
            </ul>
          </article>

          <!-- Карточка 4 на макете обрезана — тексты заглушки, замените на свои -->
          <article class="cases__card fade-in-element splide__slide">
            <span class="cases__card-tag">Криптовалюта</span>
            <h3 class="cases__card-title">Легальный вывод средств</h3>
            <div class="cases__story">
              <div class="cases__step">
                <span class="cases__step-label">Задача:</span>
                <p class="cases__step-text">Нужен счёт для работы с вопросами по источнику средств.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Решение:</span>
                <p class="cases__step-text">Подобрали банк и прошли комплаенс.</p>
              </div>
              <div class="cases__step">
                <span class="cases__step-label">Результат:</span>
                <p class="cases__step-text">Счёт открыт.</p>
              </div>
            </div>
            <ul class="cases__facts">
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6.5V12l3.5 2" /></svg>
                  Срок
                </span>
                <span class="cases__fact-value">14 дней</span>
              </li>
              <li class="cases__fact">
                <span class="cases__fact-label">
                  <svg class="cases__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 8V6a2 2 0 0 1 2-2h11v4"/><rect x="3" y="8" width="18" height="12" rx="2"/><circle cx="16.5" cy="14" r="1.3"/></svg>
                  Экономия
                </span>
                <span class="cases__fact-value">~$4 000</span>
              </li>
            </ul>
          </article>

        </div>
      </div>

      <div class="splide__bottom">
        <div class="splide__pagination"></div>
      </div>
    </div>

    <div class="cases__foot">
      <p class="cases__foot-text">Хотите так же: быстро, без ошибок и лишних затрат?</p>
      <a class="cases__btn" href="#modal">
        <span>Хочу такое же решение</span>
        <svg class="cases__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M4 12h16M14 6l6 6-6 6"/>
        </svg>
      </a>
    </div>
  </div>
</section>


<!-- ===== Сравнение программ: «ВНЖ ОАЭ и популярная альтернатива» ===== -->
<section class="programs">
  <div class="container">
    <div class="programs__top">
      <span class="programs__badge">Сравнение программ</span>
      <h2 class="programs__title">
        <span class="programs__title-accent">ВНЖ ОАЭ</span> и популярная альтернатива
      </h2>
      <p class="programs__lead">
        Подбираем банк под ваш профиль. Ниже — стоимость и срок открытия.<br>
        Точный список готовим индивидуально.
      </p>
    </div>

    <div class="programs__table-wrap">
      <table class="programs__table">
        <thead>
          <tr>
            <th class="programs__th" scope="col">Категория</th>
            <th class="programs__th programs__th--accent" scope="col">
              <img class="programs__flag" src="<?= THEME_PATH; ?>/assets/img/flags/ae.svg" alt="" width="12" height="9">ОАЭ
            </th>
            <th class="programs__th" scope="col">
              <img class="programs__flag" src="<?= THEME_PATH; ?>/assets/img/flags/es.svg" alt="" width="12" height="9">Испания
            </th>
            <th class="programs__th" scope="col">
              <img class="programs__flag" src="<?= THEME_PATH; ?>/assets/img/flags/pt.svg" alt="" width="12" height="9">Португалия
            </th>
            <th class="programs__th" scope="col">
              <img class="programs__flag" src="<?= THEME_PATH; ?>/assets/img/flags/mt.svg" alt="" width="12" height="9">Мальта
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="programs__row">
            <th class="programs__criterion" scope="row">Срок оформления</th>
            <td class="programs__cell programs__cell--accent">от 2 недель</td>
            <td class="programs__cell">1,5 месяца</td>
            <td class="programs__cell">от 6 мес</td>
            <td class="programs__cell">от 2 мес</td>
          </tr>
          <tr class="programs__row">
            <th class="programs__criterion" scope="row">Стоимость</th>
            <td class="programs__cell programs__cell--accent">от 3 000 $</td>
            <td class="programs__cell">от 3 000 €</td>
            <td class="programs__cell">от 250 000 €</td>
            <td class="programs__cell">от 150 000 €</td>
          </tr>
          <tr class="programs__row">
            <th class="programs__criterion" scope="row">Налог на мировой доход</th>
            <td class="programs__cell programs__cell--accent">0%</td>
            <td class="programs__cell">от 19%</td>
            <td class="programs__cell">от 20%</td>
            <td class="programs__cell">от 15%</td>
          </tr>
          <tr class="programs__row">
            <th class="programs__criterion" scope="row">Налог на наследство</th>
            <td class="programs__cell programs__cell--accent">0%</td>
            <td class="programs__cell">от 7,65%</td>
            <td class="programs__cell">10%</td>
            <td class="programs__cell">0%</td>
          </tr>
          <tr class="programs__row">
            <th class="programs__criterion" scope="row">Требование проживания</th>
            <td class="programs__cell programs__cell--accent">Не требуется</td>
            <td class="programs__cell">Есть</td>
            <td class="programs__cell">Минимальное</td>
            <td class="programs__cell">Минимальное</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="programs__foot">
      <a class="programs__btn" href="#modal">
        <span>Открыть ВНЖ в ОАЭ</span>
        <svg class="programs__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M4 12h16M14 6l6 6-6 6"/>
        </svg>
      </a>
    </div>
  </div>
</section>


<!-- ===== Банки-партнёры: «Где открываем счёт» ===== -->
<section class="banks">
  <div class="container">
    <div class="banks__top">
      <span class="banks__badge">Банки-партнёры</span>
      <h2 class="banks__title">
        Где открываем <span class="banks__title-accent">счёт</span>
      </h2>
      <p class="banks__lead">
        Подбираем банк под ваш профиль. Ниже — стоимость и срок открытия.<br>
        Точный список готовим индивидуально.
      </p>
    </div>

    <div class="fade-in-container banks__splide splide load-on-vissible--js"
      aria-label="Банки-партнёры"
      data-module="./libs/splide.min.js,./modules/banksSplideInit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="banks-container">

      <div class="banks__stage">
        <div class="splide__track">
          <div class="banks__splide-list splide__list">

            <article class="banks__card fade-in-element splide__slide">
              <h3 class="banks__card-title">Личный счёт для нерезидентов</h3>
              <div class="banks__logo">
                <img src="<?= THEME_PATH; ?>/assets/img/banks/rakbank.svg" alt="RAKBANK" loading="lazy">
              </div>
              <div class="banks__type">
                <svg class="banks__check" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10"/><path d="m5.8 10.3 2.7 2.7 5.2-5.6"/></svg>
                <span class="banks__type-text">Открытие личного счёта</span>
              </div>
              <ul class="banks__facts">
                <li class="banks__fact"><span class="banks__fact-label">Стоимость</span><span class="banks__fact-value">0 AED</span></li>
                <li class="banks__fact"><span class="banks__fact-label">Срок</span><span class="banks__fact-value">6 дней</span></li>
              </ul>
              <a class="banks__link" href="#modal">
                <span>Открыть счёт</span>
                <svg class="banks__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
              </a>
            </article>

            <article class="banks__card fade-in-element splide__slide">
              <h3 class="banks__card-title">Корпоративный счёт</h3>
              <div class="banks__logo">
                <img src="<?= THEME_PATH; ?>/assets/img/banks/wio.svg" alt="Wio" loading="lazy">
              </div>
              <div class="banks__type">
                <svg class="banks__check" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10"/><path d="m5.8 10.3 2.7 2.7 5.2-5.6"/></svg>
                <span class="banks__type-text">Открытие корпоративного счёта</span>
              </div>
              <ul class="banks__facts">
                <li class="banks__fact"><span class="banks__fact-label">Стоимость</span><span class="banks__fact-value">0 AED</span></li>
                <li class="banks__fact"><span class="banks__fact-label">Срок</span><span class="banks__fact-value">10 дней</span></li>
              </ul>
              <a class="banks__link" href="#modal">
                <span>Открыть счёт</span>
                <svg class="banks__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
              </a>
            </article>

            <article class="banks__card fade-in-element splide__slide">
              <h3 class="banks__card-title">Личный счёт для нерезидентов</h3>
              <div class="banks__logo">
                <img src="<?= THEME_PATH; ?>/assets/img/banks/mashreq.svg" alt="Mashreq" loading="lazy">
              </div>
              <div class="banks__type">
                <svg class="banks__check" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10"/><path d="m5.8 10.3 2.7 2.7 5.2-5.6"/></svg>
                <span class="banks__type-text">Открытие личного счёта</span>
              </div>
              <ul class="banks__facts">
                <li class="banks__fact"><span class="banks__fact-label">Стоимость</span><span class="banks__fact-value">0 AED</span></li>
                <li class="banks__fact"><span class="banks__fact-label">Срок</span><span class="banks__fact-value">2 дня</span></li>
              </ul>
              <a class="banks__link" href="#modal">
                <span>Открыть счёт</span>
                <svg class="banks__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
              </a>
            </article>

            <article class="banks__card fade-in-element splide__slide">
              <h3 class="banks__card-title">Корпоративный счёт</h3>
              <div class="banks__logo">
                <img src="<?= THEME_PATH; ?>/assets/img/banks/emirates-nbd.svg" alt="Emirates NBD" loading="lazy">
              </div>
              <div class="banks__type">
                <svg class="banks__check" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10"/><path d="m5.8 10.3 2.7 2.7 5.2-5.6"/></svg>
                <span class="banks__type-text">Открытие личного счёта</span>
              </div>
              <ul class="banks__facts">
                <li class="banks__fact"><span class="banks__fact-label">Стоимость</span><span class="banks__fact-value">0 AED</span></li>
                <li class="banks__fact"><span class="banks__fact-label">Срок</span><span class="banks__fact-value">35 дней</span></li>
              </ul>
              <a class="banks__link" href="#modal">
                <span>Открыть счёт</span>
                <svg class="banks__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
              </a>
            </article>

            <!-- Карточка 5 на макете видна только краем — заглушка, замените на свой банк -->
            <article class="banks__card fade-in-element splide__slide">
              <h3 class="banks__card-title">Личный счёт для нерезидентов</h3>
              <div class="banks__logo">
                <img src="<?= THEME_PATH; ?>/assets/img/banks/bank-5.svg" alt="Банк" loading="lazy">
              </div>
              <div class="banks__type">
                <svg class="banks__check" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10"/><path d="m5.8 10.3 2.7 2.7 5.2-5.6"/></svg>
                <span class="banks__type-text">Открытие личного счёта</span>
              </div>
              <ul class="banks__facts">
                <li class="banks__fact"><span class="banks__fact-label">Стоимость</span><span class="banks__fact-value">0 AED</span></li>
                <li class="banks__fact"><span class="banks__fact-label">Срок</span><span class="banks__fact-value">7 дней</span></li>
              </ul>
              <a class="banks__link" href="#modal">
                <span>Открыть счёт</span>
                <svg class="banks__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
              </a>
            </article>

          </div>
        </div>

        <div class="splide__arrows splide__arrows--ltr">
          <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Предыдущий слайд">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
            </svg>
          </button>
          <button class="splide__arrow splide__arrow--next" type="button" aria-label="Следующий слайд">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.8332 10H4.99987M9.16654 5L4.7558 9.41074C4.43036 9.73618 4.43036 10.2638 4.7558 10.5893L9.16654 15" stroke-width="2" stroke-linecap="round" />
            </svg>
          </button>
        </div>
      </div>

      <div class="splide__bottom">
        <div class="splide__pagination"></div>
      </div>
    </div>

    <div class="banks__foot">
      <a class="banks__btn" href="#modal">
        <span>Открыть счёт в ОАЭ</span>
        <svg class="banks__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M4 12h16M14 6l6 6-6 6"/>
        </svg>
      </a>
    </div>
  </div>
</section>
</main>

<?php get_footer(); ?>
