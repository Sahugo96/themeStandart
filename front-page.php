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
    theme_render_front_section('result');
    theme_render_front_section('compare');
    theme_render_front_section('why-us');
    theme_render_front_section('infra');
    theme_render_front_section('about');
    theme_render_front_section('guide');
    theme_render_front_section('consult');
    ?>
    <!-- ===== Полоса цифр под hero ===== -->
<section class="hero-stats">
  <div class="container">
    <ul class="hero-stats__list">
      <li class="hero-stats__item">
        <span class="hero-stats__num">От 2 недель</span>
        <span class="hero-stats__label">срок открытия счёта</span>
      </li>
      <li class="hero-stats__item">
        <span class="hero-stats__num">От 6 500$</span>
        <span class="hero-stats__label">ВНЖ ОАЭ «под ключ»</span>
      </li>
      <li class="hero-stats__item">
        <span class="hero-stats__num">300+</span>
        <span class="hero-stats__label">клиентов по рекомендациям</span>
      </li>
      <li class="hero-stats__item">
        <span class="hero-stats__num">6+</span>
        <span class="hero-stats__label">банков-партнёров</span>
      </li>
    </ul>
  </div>
</section>


<!-- ===== Ситуации, с которыми к нам приходят (слайдер) ===== -->
<section class="situations">
  <div class="container">
    <div class="situations__top">
      <span class="situations__badge">Знакомо?</span>
      <h2 class="situations__title">
        Ситуации, с которыми
        <span class="situations__title-accent">к нам приходят</span>
      </h2>
    </div>

    <div class="fade-in-container situations__splide splide load-on-vissible--js"
      aria-label="Ситуации, с которыми к нам приходят"
      data-module="./libs/splide.min.js,./modules/situationsSplideinit.js"
      data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
      id="situations-container">
      <div class="splide__track">
        <div class="situations__splide-list splide__list">

          <!-- Слайд = две карточки друг под другом -->
          <div class="situations__slide fade-in-element splide__slide">
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Банк в ЕС закрыл счёт из-за паспорта РФ</h3>
              </div>
              <p class="situations__card-text">Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span></p>
            </article>
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Продал недвижимость в Европе</h3>
              </div>
              <p class="situations__card-text">Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span></p>
            </article>
          </div>

          <div class="situations__slide fade-in-element splide__slide">
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Не могу принять оплату от клиента</h3>
              </div>
              <p class="situations__card-text">Международный счёт: <span>личный или на компанию.</span></p>
            </article>
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Хочу переехать всей семьёй</h3>
              </div>
              <p class="situations__card-text">ВНЖ, спонсорство и прочие услуги <span>для супруга и детей.</span></p>
            </article>
          </div>

          <div class="situations__slide fade-in-element splide__slide">
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Паспорт РФ не пускает на биржи</h3>
              </div>
              <p class="situations__card-text">Emirates ID верифицирует <span>везде, где принимается.</span></p>
            </article>
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Нужна компания на зарубежные рынки</h3>
              </div>
              <p class="situations__card-text">Фризона за 1–4 недели. <span>Со 100% владением.</span></p>
            </article>
          </div>

          <!-- Слайд 4: на макете обрезан, тексты — заглушки, замените на свои -->
          <div class="situations__slide fade-in-element splide__slide">
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Банк закрыл счёт за границей</h3>
              </div>
              <p class="situations__card-text">Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span></p>
            </article>
            <article class="situations__card">
              <div class="situations__card-head">
                <svg class="situations__card-icon" viewBox="0 0 30 30" aria-hidden="true">
                  <circle cx="15" cy="15" r="15"/>
                  <path d="M8.5 15h13M16.5 10l5 5-5 5"/>
                </svg>
                <h3 class="situations__card-title">Продал бизнес в Азии</h3>
              </div>
              <p class="situations__card-text">Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span></p>
            </article>
          </div>

        </div>
      </div>

      <div class="splide__bottom">
        <div class="splide__pagination"></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Как проходит работа ===== -->
<section class="process">
  <div class="container">
    <div class="process__top">
      <span class="process__badge">Как проходит работа</span>
      <h2 class="process__title">
        Мы проходим с вами
        <span class="process__title-accent">каждый этап</span>
      </h2>
    </div>

    <div class="process__card">
      <div class="process__image">
        <img src="<?= THEME_PATH; ?>/assets/img/process.jpg" alt="Координатор Relocate-World" loading="lazy">
      </div>

      <div class="process__steps" data-accordion>

        <div class="process__item active" data-accordion-item>
          <button class="process__item-top" type="button" aria-expanded="true" data-accordion-btn>
            <span class="process__item-num">1</span>
            <span class="process__item-title">Подготовительный этап</span>
            <svg class="process__item-plus" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M10 3v14M3 10h14"/>
            </svg>
          </button>
          <div class="process__item-body">
            <div class="process__item-inner">
              <p>За вами закрепляется персональный координатор.</p>
              <p>Проводим KYC-бриф: анализируем гражданство, профиль и задачи. Подбираем решение: счёт, ВНЖ или структуру.</p>
              <p>Проверяем документы и устраняем несоответствия.</p>
            </div>
          </div>
        </div>

        <!-- Тексты шагов 2–4 на макете не раскрыты — заглушки, замените на свои -->
        <div class="process__item" data-accordion-item>
          <button class="process__item-top" type="button" aria-expanded="false" data-accordion-btn>
            <span class="process__item-num">2</span>
            <span class="process__item-title">Подготовка и подача</span>
            <svg class="process__item-plus" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M10 3v14M3 10h14"/>
            </svg>
          </button>
          <div class="process__item-body">
            <div class="process__item-inner">
              <p>Готовим пакет документов под требования банка или фризоны и подаём заявку.</p>
            </div>
          </div>
        </div>

        <div class="process__item" data-accordion-item>
          <button class="process__item-top" type="button" aria-expanded="false" data-accordion-btn>
            <span class="process__item-num">3</span>
            <span class="process__item-title">Комплаенс и подготовление</span>
            <svg class="process__item-plus" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M10 3v14M3 10h14"/>
            </svg>
          </button>
          <div class="process__item-body">
            <div class="process__item-inner">
              <p>Отвечаем на запросы комплаенса и сопровождаем созвоны с банком.</p>
            </div>
          </div>
        </div>

        <div class="process__item" data-accordion-item>
          <button class="process__item-top" type="button" aria-expanded="false" data-accordion-btn>
            <span class="process__item-num">4</span>
            <span class="process__item-title">Результат и сопровождение</span>
            <svg class="process__item-plus" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M10 3v14M3 10h14"/>
            </svg>
          </button>
          <div class="process__item-body">
            <div class="process__item-inner">
              <p>Передаём счёт, карты и документы и остаёмся на связи после открытия.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<!-- ===== Стоимость ===== -->
<section class="cost">
  <div class="container">
    <div class="cost__top">
      <span class="cost__badge">Стоимость</span>
      <h2 class="cost__title">
        <span class="cost__title-accent">Сколько стоит</span>
        решить задачу в ОАЭ
      </h2>
      <p class="cost__lead">
        Точная цена зависит от услуги, программы и объёма сопровождения.<br>
        Ниже ориентиры.
      </p>
    </div>

    <ul class="cost__prices">
      <li class="cost__price">
        <span class="cost__price-name">Банковский счёт</span>
        <span class="cost__price-value"><small>от</small> $ –</span>
      </li>
      <li class="cost__price">
        <span class="cost__price-name">ВНЖ ОАЭ</span>
        <span class="cost__price-value"><small>от</small> $ 6 500</span>
      </li>
      <li class="cost__price">
        <span class="cost__price-name">Компания</span>
        <span class="cost__price-value"><small>от</small> $ –</span>
      </li>
      <li class="cost__price">
        <span class="cost__price-name">Виза фрилансера</span>
        <span class="cost__price-value"><small>от</small> $ 9 500</span>
      </li>
    </ul>

    <div class="cost__card">
      <div class="cost__content">
        <h3 class="cost__card-title">Рассчитаем стоимость<br>под вашу задачу</h3>
        <p class="cost__card-text">Пришлём персональную смету со всеми сопутствующими расходами и сборами — ещё до консультации.</p>

        <div class="cost__actions">
          <a class="cost__btn" href="#modal">
            <span>Получить расчёт</span>
            <svg class="cost__btn-arrow" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 12h16M14 6l6 6-6 6"/>
            </svg>
          </a>
          <a class="cost__round" href="#" aria-label="WhatsApp" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Z"/>
              <path d="M8.8 8.6c.3 2.7 3.9 6 6.6 6.2l1.2-1.4-2.2-1.2-1 .8c-1-.4-2-1.4-2.4-2.4l.8-1-1.2-2.2-1.8 1.2Z"/>
            </svg>
          </a>
          <a class="cost__round" href="#" aria-label="Telegram" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M21 4 3 11l5.5 2L10 19l3-3 4.5 3.5L21 4Z"/>
              <path d="m8.5 13 12-8.5"/>
            </svg>
          </a>
          <a class="cost__round" href="tel:+971554352459" aria-label="Позвонить">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M5 4h4l1.5 4-2.3 1.5a11 11 0 0 0 5.3 5.3L15 12.5l4 1.5v4a2 2 0 0 1-2 2A14 14 0 0 1 3 6a2 2 0 0 1 2-2Z"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="cost__image">
        <img src="<?= THEME_PATH; ?>/assets/img/cost.jpg" alt="Расчёт стоимости" loading="lazy">
      </div>
    </div>
  </div>
</section>


<!-- ===== Кнопка «Перейти в блог» (под FAQ) ===== -->
<div class="blog-more">
  <div class="container">
    <a class="blog-more__btn" href="/blog/">
      <span>Перейти в блог</span>
      <svg class="blog-more__arrow" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M4 12h16M14 6l6 6-6 6"/>
      </svg>
    </a>
  </div>
</div>
</main>

<?php get_footer(); ?>
