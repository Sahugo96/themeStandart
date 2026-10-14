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
    ?>

    <!-- ===== Секция 1: Что вы получаете ===== -->
    <section class="result section section--white">
        <div class="container">
            <div class="result__top section-top">
                <span class="result__badge section-subtitle">Результат</span>
                <h2 class="result__title section-title">Что вы получаете</h2>
            </div>

            <div class="result__panel br-30">
                <div class="fade-in-container result__splide splide load-on-vissible--js"
                    aria-label="Что вы получаете"
                    data-module="./libs/splide.min.js,./modules/resultSplideInit.js"
                    data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
                    id="result-container">
                    <div class="splide__track">
                        <div class="result__splide-list splide__list">

                            <article class="result__item fade-in-element splide__slide br-15">
                                <div class="result__item-head">
                                    <svg class="result__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M3 9.5 12 4l9 5.5M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 20h18M4 9.5h16" />
                                    </svg>
                                    <h3 class="result__item-title h4">IBAN и счёт</h3>
                                </div>
                                <p class="result__item-text reg-par">Мультивалютный счёт с международными переводами.</p>
                            </article>

                            <article class="result__item fade-in-element splide__slide br-15">
                                <div class="result__item-head">
                                    <svg class="result__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="14" rx="2" />
                                        <rect x="6" y="8.5" width="4.5" height="3.5" rx=".6" />
                                        <path d="M13.5 9h4M13.5 12h4M6 15.5h11.5" />
                                    </svg>
                                    <h3 class="result__item-title h4">Emirates ID</h3>
                                </div>
                                <p class="result__item-text reg-par">Резидентский статус и спонсорство семьи.</p>
                            </article>

                            <article class="result__item fade-in-element splide__slide br-15">
                                <div class="result__item-head">
                                    <svg class="result__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="14" rx="2.5" />
                                        <path d="M3 9.5h18M6.5 15h2.5M12 15h2.5" />
                                    </svg>
                                    <h3 class="result__item-title h4">Карты</h3>
                                </div>
                                <p class="result__item-text reg-par">Дебетовые и кредитные для платежей по миру.</p>
                            </article>

                            <article class="result__item fade-in-element splide__slide br-15">
                                <div class="result__item-head">
                                    <svg class="result__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="8" width="18" height="12" rx="2" />
                                        <path d="M8.5 8V6.5A1.5 1.5 0 0 1 10 5h4a1.5 1.5 0 0 1 1.5 1.5V8M3 13l9 3 9-3" />
                                    </svg>
                                    <h3 class="result__item-title h4">Компания и лицензия</h3>
                                </div>
                                <p class="result__item-text reg-par">Устав, юр. адрес и корпоративный счёт.</p>
                            </article>

                            <article class="result__item fade-in-element splide__slide br-15">
                                <div class="result__item-head">
                                    <svg class="result__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M3 4v16h18" />
                                        <path d="m6.5 14 4-4 3 3 5-6" />
                                        <path d="M15.5 7h3.5v3.5" />
                                    </svg>
                                    <h3 class="result__item-title h4">Доступ к инвестициям</h3>
                                </div>
                                <p class="result__item-text reg-par">Брокерский счёт и верификация на платформах.</p>
                            </article>

                            <article class="result__item fade-in-element splide__slide br-15">
                                <div class="result__item-head">
                                    <svg class="result__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M4 14v-2a8 8 0 0 1 16 0v2" />
                                        <rect x="3" y="13" width="4" height="6" rx="1.5" />
                                        <rect x="17" y="13" width="4" height="6" rx="1.5" />
                                        <path d="M19 19c0 1.5-1.5 2.5-4 2.5h-2" />
                                    </svg>
                                    <h3 class="result__item-title h4">Сопровождение после</h3>
                                </div>
                                <p class="result__item-text reg-par">Помощь с комплаенсом и обслуживанием.</p>
                            </article>

                        </div>
                    </div>

                    <div class="splide__bottom">
                        <div class="splide__pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===== Секция 2: Сравнение ===== -->
    <section class="compare section section--white">
        <div class="container">
            <div class="compare__top section-top">
                <span class="compare__badge section-subtitle">Сравнение</span>
                <h2 class="compare__title section-title">
                    Сам, через посредника
                    <span>или напрямую с нами</span>
                </h2>
                <p class="compare__lead section-text">
                    Мы — исполнитель на земле в DIFC.<br>
                    Посредник из РФ перепродаёт нашу же работу с наценкой.<br>
                    Разница видна по каждому пункту.
                </p>
            </div>

            <div class="compare__table-wrap">
                <table class="compare__table">
                    <thead>
                        <tr>
                            <th class="compare__th" scope="col">Критерий</th>
                            <th class="compare__th" scope="col">Сам</th>
                            <th class="compare__th" scope="col">Через посредника</th>
                            <th class="compare__th compare__th--accent" scope="col">Напрямую с нами</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row">Цена</th>
                            <td class="compare__cell">Скрытые расходы</td>
                            <td class="compare__cell">+ наценка посредника</td>
                            <td class="compare__cell compare__cell--accent">Без наценки, от исполнителя</td>
                        </tr>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row">Кто оформляет</th>
                            <td class="compare__cell">Вы сами</td>
                            <td class="compare__cell">Перепродаёт исполнителю</td>
                            <td class="compare__cell compare__cell--accent">Мы, напрямую</td>
                        </tr>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row">Доступ к банкам</th>
                            <td class="compare__cell">Общие условия</td>
                            <td class="compare__cell">Через третьи руки</td>
                            <td class="compare__cell compare__cell--accent">Свои банкиры, прямые отношения</td>
                        </tr>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row">Помощь с комплаенсом</th>
                            <td class="compare__cell">Разбираетесь сами</td>
                            <td class="compare__cell">Обычно не сопровождают</td>
                            <td class="compare__cell compare__cell--accent">Закрываем вопросы комплаенса</td>
                        </tr>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row">Сопровождение после</th>
                            <td class="compare__cell">Нет</td>
                            <td class="compare__cell">До открытия счёта</td>
                            <td class="compare__cell compare__cell--accent">Дальнейшая поддержка</td>
                        </tr>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row">Ответственность</th>
                            <td class="compare__cell">На вас</td>
                            <td class="compare__cell">Размыта между звеньями</td>
                            <td class="compare__cell compare__cell--accent">Одна команда по договору</td>
                        </tr>
                        <tr class="compare__row">
                            <th class="compare__criterion" scope="row">Скорость и риск отказа</th>
                            <td class="compare__cell">Медленно, высокий риск</td>
                            <td class="compare__cell">Задержки на передаче</td>
                            <td class="compare__cell compare__cell--accent">Быстрее, ниже риск</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="compare__foot">
                <p class="compare__foot-text">
                    Большинство компаний на рынке — посредники.<br>
                    В итоге всё равно приходят к исполнителю.<br>
                    Так почему бы не сразу к нам?
                </p>
                <a class="compare__btn" href="#modal">
                    <span>Начать сотрудничество</span>
                    <svg class="compare__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 12h16M14 6l6 6-6 6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== Секция 1: Почему именно мы ===== -->
    <section class="why-us section">
        <div class="container">
            <div class="why-us__top section-top">
                <span class="why-us__badge section-subtitle">Почему именно мы</span>
                <h2 class="why-us__title section-title">
                    Почему платят нам,
                    <span>а не идут к 10 другим</span>
                </h2>
            </div>

            <ul class="why-us__items br-30">

                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <svg class="why-us__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="13.5" r="7.5" />
                            <path d="M10 3h4M12 3v3M18.2 7.3l1.3-1.3" />
                            <path d="m12.8 10.5-2.3 3h3l-2.3 3" />
                        </svg>
                        <h3 class="why-us__item-title h4">Экономим ваше время</h3>
                    </div>
                    <p class="why-us__item-text reg-par">Оформление, документы и переписку с банком берём на себя.</p>
                </li>

                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <svg class="why-us__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 3 4.5 5.5v6c0 4.4 3 7.6 7.5 9.5 4.5-1.9 7.5-5.1 7.5-9.5v-6L12 3Z" />
                            <circle cx="12" cy="10.5" r="2.5" />
                            <path d="M7.8 17c.8-2 2.4-3 4.2-3s3.4 1 4.2 3" />
                        </svg>
                        <h3 class="why-us__item-title h4">Паспорт РФ и сложные случаи</h3>
                    </div>
                    <p class="why-us__item-text reg-par">Открываем там, где другим отказывают — это наша специализация.</p>
                </li>

                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <svg class="why-us__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="4" width="14" height="11" rx="2" />
                            <circle cx="10" cy="8.5" r="1.8" />
                            <path d="M6.5 13c.6-1.6 1.9-2.3 3.5-2.3s2.9.7 3.5 2.3" />
                            <path d="M7 18.5h12a2 2 0 0 0 2-2V8.5" />
                        </svg>
                        <h3 class="why-us__item-title h4">Свои банкиры</h3>
                    </div>
                    <p class="why-us__item-text reg-par">Прямые отношения с банками ускоряют одобрение и снижают риск отказа.</p>
                </li>

                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <svg class="why-us__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m12 2.5 2.3 1.8 2.9-.1 1.1 2.7 2.5 1.5-.9 2.8.9 2.8-2.5 1.5-1.1 2.7-2.9-.1L12 21.5l-2.3-1.8-2.9.1-1.1-2.7-2.5-1.5.9-2.8-.9-2.8 2.5-1.5 1.1-2.7 2.9.1L12 2.5Z" />
                            <path d="m9 15 6-6" />
                            <circle cx="9.4" cy="9.4" r=".9" />
                            <circle cx="14.6" cy="14.6" r=".9" />
                        </svg>
                        <h3 class="why-us__item-title h4">Цена ниже рынка</h3>
                    </div>
                    <p class="why-us__item-text reg-par">Мы исполнитель на земле в DIFC — без наценки посредников.</p>
                </li>

                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <svg class="why-us__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12.5 21H6.5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v6" />
                            <path d="M8 8h6M8 11.5h6M8 15h3" />
                            <path d="m14.5 18.5 2 2 4-4.5" />
                        </svg>
                        <h3 class="why-us__item-title h4">Официальный договор</h3>
                    </div>
                    <p class="why-us__item-text reg-par">Лицензия DIFC 6502 и прозрачные условия — всё по закону.</p>
                </li>

                <li class="why-us__item br-15">
                    <div class="why-us__item-head">
                        <svg class="why-us__item-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8 4h8v5a4 4 0 0 1-8 0V4Z" />
                            <path d="M8 6H5v1.5A3 3 0 0 0 8 10.5M16 6h3v1.5a3 3 0 0 1-3 3" />
                            <path d="M12 13v4M8.5 20.5h7M9.5 17h5v3.5h-5z" />
                        </svg>
                        <h3 class="why-us__item-title h4">Проходим с первого раза</h3>
                    </div>
                    <p class="why-us__item-text reg-par">Готовим пакет под требования комплаенса — без пересдач и задержек.</p>
                </li>

            </ul>
        </div>
    </section>


    <!-- ===== Секция 2: Инфраструктура за пределами РФ ===== -->
    <section class="infra section">
        <div class="container">
            <div class="infra__inner">

                <div class="infra__left">
                    <span class="infra__badge">Для клиентов с капиталом и бизнесом</span>
                    <h2 class="infra__title">
                        Нужна не одна услуга,
                        <span class="infra__title-accent">а инфраструктура за пределами РФ</span>
                    </h2>
                    <p class="infra__text">
                        Соберём комплексное решение под перевод и владение активами,
                        международные платежи и структуру бизнеса.
                        Конфиденциально, с персональным менеджером.
                    </p>
                    <a class="infra__btn" href="#contact">
                        <span>Обсудить конфиденциально</span>
                        <svg class="infra__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </a>
                </div>

                <div class="infra__right">
                    <ul class="infra__list">
                        <li class="infra__list-item">Регистрация компании за рубежом</li>
                        <li class="infra__list-item">Международные платежи</li>
                        <li class="infra__list-item">Ведение и сохранность активов</li>
                        <li class="infra__list-item">Сопровождение комплаенса</li>
                    </ul>
                    <ul class="infra__list">
                        <li class="infra__list-item">Корпоративный счёт</li>
                        <li class="infra__list-item">Офшорные счета и структуры</li>
                        <li class="infra__list-item">Налоговое планирование</li>
                        <li class="infra__list-item">ВНЖ для бенефициаров</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== Секция 1: Кратко о нас ===== -->
<section class="about section">
  <div class="container">
    <div class="about__inner br-30">

      <div class="about__image br-30">
        <img src="<?= THEME_PATH; ?>/assets/img/about.jpg" alt="Команда Relocate-World" loading="lazy">
      </div>

      <div class="about__content">
        <span class="about__badge section-subtitle">Кратко о нас</span>
        <h2 class="about__title section-title h1">
          <span>Relocate-World —</span>
          исполнитель в DIFC
        </h2>

        <div class="about__text">
          <p>Мы — лицензированный провайдер в финансовом центре Дубая (DIFC). Не посредники: работаем на земле, напрямую с банками и фризонами, поэтому предлагаем цену ниже рынка и беремся за сложные случаи.</p>
          <p>За каждым клиентом — персональный координатор и команда, которая ведёт процесс от заявки до результата и остаётся на связи после.</p>
        </div>

        <ul class="about__stats br-30">
          <li class="about__stat br-20">
            <span class="about__stat-num">300+</span>
            <span class="about__stat-label">клиентов<br>по рекомендациям</span>
          </li>
          <li class="about__stat br-20">
            <span class="about__stat-num">6+</span>
            <span class="about__stat-label">банков-<br>партнёров</span>
          </li>
          <li class="about__stat br-20">
            <span class="about__stat-num">6502</span>
            <span class="about__stat-label">лицензия<br>DIFC</span>
          </li>
          <li class="about__stat br-20">
            <span class="about__stat-num">~20</span>
            <span class="about__stat-label">специалистов<br>в команде</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>


<!-- ===== Секция 2: Подробнее (статья) ===== -->
<section class="guide section">
  <div class="container">
    <div class="guide__top">
      <span class="guide__badge">Подробнее</span>
      <h2 class="guide__title">
        Банковские счета,
        <span class="guide__title-accent">ВНЖ и компании в ОАЭ</span>
      </h2>
    </div>

    <article class="guide__card" data-read-more>
      <div class="guide__content">

        <div class="guide__meta">
          <ul class="guide__tags">
            <li class="guide__tag">Счета</li>
            <li class="guide__tag">ОАЭ</li>
          </ul>
          <ul class="guide__info">
            <li class="guide__info-item">
              <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 7v5l3 2"/>
              </svg>
              10 мин
            </li>
            <li class="guide__info-item">
              <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
              234
            </li>
            <li class="guide__info-item">
              <time datetime="2026-07-19">19 июля 2026</time>
              <svg class="guide__info-icon" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="5" width="18" height="16" rx="2"/>
                <path d="M3 10h18M8 3v4M16 3v4"/>
              </svg>
            </li>
          </ul>
        </div>

        <h3 class="guide__card-title">Почему ОАЭ</h3>

        <div class="guide__text">
          <p>Объединённые Арабские Эмираты — одна из самых устойчивых финансовых юрисдикций мира с нулевым личным подоходным налогом и развитой банковской системой под контролем Центрального банка ОАЭ. Резидентский статус открывает доступ к международным сервисам, а компания во фризоне позволяет вести бизнес со 100% иностранным владением.</p>
          <p>Relocate-World помогает пройти этот путь без ошибок: подбираем банк и программу под ваш профиль, готовим документы под требования комплаенса и сопровождаем до результата.</p>

          <div class="guide__more">
            <!-- Продолжение статьи: показывается по кнопке «Читать полностью» -->
          </div>
        </div>

        <button class="guide__btn" type="button" aria-expanded="false" data-read-more-btn>
          <span data-read-more-label>Читать полностью</span>
          <svg class="guide__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>

      </div>

      <div class="guide__image">
        <img src="<?= THEME_PATH; ?>/assets/img/guide.jpg" alt="Почему ОАЭ" loading="lazy">
      </div>
    </article>
  </div>
</section>


<!-- ===== Секция 3: Бесплатная консультация ===== -->
<section class="consult section">
  <div class="container">
    <div class="consult__inner">

      <div class="consult__content">
        <span class="consult__badge section-subtitle">Начните с бесплатной консультации</span>
        <h2 class="consult__title section-title">
          Разбор вашей ситуации<br>
          и решение <span>— бесплатно</span>
        </h2>
        <div class="consult__text">
          <p>Оставьте номер — перезвоним, зададим пару вопросов и подберём решение под вашу задачу: счёт, ВНЖ или компанию.</p>
          <p>Или напишите нам: <a href="tel:+971554352459">+971 55 435 2459</a></p>
        </div>

        <form class="consult__form" action="" method="post">
          <div class="consult__field">
            <input class="consult__input" type="text" name="contact" placeholder="Ваш телефон или телеграм" autocomplete="tel" required>
            <button class="consult__submit" type="submit">Получить консультацию</button>
          </div>

          <label class="consult__check">
            <input class="consult__check-input" type="checkbox" name="agree_policy" checked required>
            <span class="consult__check-box"></span>
            <span class="consult__check-text">Согласен с <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a></span>
          </label>

          <label class="consult__check">
            <input class="consult__check-input" type="checkbox" name="agree_data" required>
            <span class="consult__check-box"></span>
            <span class="consult__check-text">Согласен с <a href="/personal-data/" target="_blank">обработкой данных</a></span>
          </label>
        </form>
      </div>

      <div class="consult__image">
        <img src="<?= THEME_PATH; ?>/assets/img/consult.jpg" alt="Консультант Relocate-World" loading="lazy">
      </div>

    </div>
  </div>
</section>
</main>

<?php get_footer(); ?>