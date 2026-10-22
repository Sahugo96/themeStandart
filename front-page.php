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
    theme_render_front_section('cases'); // +
    
    theme_render_front_section('compare');
    theme_render_front_section('programs'); // +

    theme_render_front_section('why-us'); // +
    theme_render_front_section('infra'); // +
    theme_render_front_section('documents'); // +
    theme_render_front_section('cost'); // +
    theme_render_front_section('banks'); // +


    theme_render_front_section('guide');
    theme_render_front_section('team'); // +
    theme_render_front_section('faq');
    theme_render_front_section('blog-more');
    theme_render_front_section('consult');
    ?>

    <!-- ===== Флагманские программы резидентства ===== -->
<section class="flagship">
  <div class="container">
    <div class="flagship__top">
      <span class="flagship__badge">Программы по получению ВНЖ ОАЭ</span>
      <h2 class="flagship__title">
        <span class="flagship__title-accent">Флагманские</span> программы
        <br>резидентства
      </h2>
    </div>

    <div class="flagship__list">

      <article class="flagship__card">
        <div class="flagship__card-top">
          <span class="flagship__country">
            <img class="flagship__flag" src="<?= THEME_PATH; ?>/assets/img/flags/ae.svg" alt="" width="14" height="10">
            ОАЭ
          </span>
          <span class="flagship__price"><small>от</small> 6 500 $</span>
        </div>

        <h3 class="flagship__card-title">Компания + ВНЖ</h3>
        <p class="flagship__card-text">Самый популярный путь к резидентству: открываем компанию во Free Zone или Mainland и оформляем визу. Подходит для бизнеса, фриланса и удалённой работы. Документы — от 7 дней, большая часть процесса дистанционно.</p>

        <ul class="flagship__facts">
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M3 19c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M17 8c1.2.8 1.2 3.2 0 4M19.5 6c2.2 1.8 2.2 6.2 0 8"/></svg>
              Знание языка:
            </span>
            <span class="flagship__fact-value">Не требуется</span>
          </li>
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
              Срок действия:
            </span>
            <span class="flagship__fact-value">2 года</span>
          </li>
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="9" r="2.5"/><path d="M2.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5M14 14.5c.7-.3 1.4-.5 2-.5 2.5 0 4.5 1.7 4.5 4.5"/></svg>
              Члены семьи:
            </span>
            <span class="flagship__fact-value">Супруг, супруга, дети до 18</span>
          </li>
        </ul>

        <div class="flagship__actions">
          <a class="flagship__btn" href="#">
            <span>Подробнее</span>
            <svg class="flagship__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
          </a>
          <a class="flagship__round" href="#" aria-label="WhatsApp" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="11"/>
              <path d="M12 6.5a5.5 5.5 0 0 0-4.7 8.3L6.5 17.5l2.8-.8A5.5 5.5 0 1 0 12 6.5Z"/>
              <path d="M10 10c.2 1.6 2.3 3.6 4 3.8l.8-.9-1.4-.7-.6.5c-.6-.3-1.2-.8-1.5-1.5l.5-.6-.7-1.4-1.1.8Z"/>
            </svg>
          </a>
          <a class="flagship__round" href="#" aria-label="Telegram" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="11"/>
              <path d="M17.5 7.5 6.5 11.7l3.3 1.2 1.2 3.8 2.1-2.2 3.3 2.4 1.1-9.4Z"/>
            </svg>
          </a>
        </div>
      </article>

      <article class="flagship__card">
        <div class="flagship__card-top">
          <span class="flagship__country">
            <img class="flagship__flag" src="<?= THEME_PATH; ?>/assets/img/flags/ae.svg" alt="" width="14" height="10">
            ОАЭ
          </span>
          <span class="flagship__price"><small>от</small> 3 900 $</span>
        </div>

        <h3 class="flagship__card-title">Виза инвестора</h3>
        <p class="flagship__card-text">Самый популярный путь к резидентству: открываем компанию во Free Zone или Mainland и оформляем визу. Подходит для бизнеса, фриланса и удалённой работы. Документы — от 7 дней, большая часть процесса дистанционно.</p>

        <ul class="flagship__facts">
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M3 19c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M17 8c1.2.8 1.2 3.2 0 4M19.5 6c2.2 1.8 2.2 6.2 0 8"/></svg>
              Знание языка:
            </span>
            <span class="flagship__fact-value">Не требуется</span>
          </li>
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
              Срок действия:
            </span>
            <span class="flagship__fact-value">от 2-х лет</span>
          </li>
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="9" r="2.5"/><path d="M2.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5M14 14.5c.7-.3 1.4-.5 2-.5 2.5 0 4.5 1.7 4.5 4.5"/></svg>
              Члены семьи:
            </span>
            <span class="flagship__fact-value">Супруг, супруга, дети до 18</span>
          </li>
        </ul>

        <div class="flagship__actions">
          <a class="flagship__btn" href="#">
            <span>Подробнее</span>
            <svg class="flagship__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
          </a>
          <a class="flagship__round" href="#" aria-label="WhatsApp" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="11"/>
              <path d="M12 6.5a5.5 5.5 0 0 0-4.7 8.3L6.5 17.5l2.8-.8A5.5 5.5 0 1 0 12 6.5Z"/>
              <path d="M10 10c.2 1.6 2.3 3.6 4 3.8l.8-.9-1.4-.7-.6.5c-.6-.3-1.2-.8-1.5-1.5l.5-.6-.7-1.4-1.1.8Z"/>
            </svg>
          </a>
          <a class="flagship__round" href="#" aria-label="Telegram" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="11"/>
              <path d="M17.5 7.5 6.5 11.7l3.3 1.2 1.2 3.8 2.1-2.2 3.3 2.4 1.1-9.4Z"/>
            </svg>
          </a>
        </div>
      </article>

      <article class="flagship__card">
        <div class="flagship__card-top">
          <span class="flagship__country">
            <img class="flagship__flag" src="<?= THEME_PATH; ?>/assets/img/flags/ae.svg" alt="" width="14" height="10">
            ОАЭ
          </span>
          <span class="flagship__price"><small>от</small> 9 500 $</span>
        </div>

        <h3 class="flagship__card-title">Виза фрилансера</h3>
        <p class="flagship__card-text">Самый популярный путь к резидентству: открываем компанию во Free Zone или Mainland и оформляем визу. Подходит для бизнеса, фриланса и удалённой работы. Документы — от 7 дней, большая часть процесса дистанционно.</p>

        <ul class="flagship__facts">
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M3 19c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M17 8c1.2.8 1.2 3.2 0 4M19.5 6c2.2 1.8 2.2 6.2 0 8"/></svg>
              Знание языка:
            </span>
            <span class="flagship__fact-value">Не требуется</span>
          </li>
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
              Срок действия:
            </span>
            <span class="flagship__fact-value">1 год (с пролонгацией)</span>
          </li>
          <li class="flagship__fact">
            <span class="flagship__fact-label">
              <svg class="flagship__fact-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="9" r="2.5"/><path d="M2.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5M14 14.5c.7-.3 1.4-.5 2-.5 2.5 0 4.5 1.7 4.5 4.5"/></svg>
              Члены семьи:
            </span>
            <span class="flagship__fact-value">Супруг, супруга, дети до 18</span>
          </li>
        </ul>

        <div class="flagship__actions">
          <a class="flagship__btn" href="#">
            <span>Подробнее</span>
            <svg class="flagship__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
          </a>
          <a class="flagship__round" href="#" aria-label="WhatsApp" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="11"/>
              <path d="M12 6.5a5.5 5.5 0 0 0-4.7 8.3L6.5 17.5l2.8-.8A5.5 5.5 0 1 0 12 6.5Z"/>
              <path d="M10 10c.2 1.6 2.3 3.6 4 3.8l.8-.9-1.4-.7-.6.5c-.6-.3-1.2-.8-1.5-1.5l.5-.6-.7-1.4-1.1.8Z"/>
            </svg>
          </a>
          <a class="flagship__round" href="#" aria-label="Telegram" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="11"/>
              <path d="M17.5 7.5 6.5 11.7l3.3 1.2 1.2 3.8 2.1-2.2 3.3 2.4 1.1-9.4Z"/>
            </svg>
          </a>
        </div>
      </article>

    </div>
  </div>
</section>


<!-- ===== Другие программы — ВНЖ в Европе ===== -->
<section class="europe">
  <div class="container">
    <h3 class="europe__title">Другие программы <span class="europe__title-accent">— ВНЖ в Европе</span></h3>

    <div class="europe__table-wrap">
      <table class="europe__table">
        <thead>
          <tr>
            <th class="europe__th" scope="col">Страна</th>
            <th class="europe__th" scope="col">Стоимость</th>
            <th class="europe__th" scope="col">Срок оформления</th>
            <th class="europe__th" scope="col">Преимущества</th>
            <th class="europe__th" scope="col"><span class="europe__sr">Действие</span></th>
          </tr>
        </thead>
        <tbody>

          <tr class="europe__row">
            <td class="europe__cell europe__cell--country">
              <img class="europe__flag" src="<?= THEME_PATH; ?>/assets/img/flags/pt.svg" alt="" width="16" height="12">
              <span class="europe__country-name">Португалия</span>
              <span class="europe__country-note">ВНЖ, ЕС</span>
            </td>
            <td class="europe__cell europe__cell--strong">от € –</td>
            <td class="europe__cell europe__cell--strong">от 6 мес.</td>
            <td class="europe__cell">
              <ul class="europe__benefits">
                <li>Шенген, путь к гражданству через 5 лет</li>
                <li>Не требует постоянного проживания</li>
              </ul>
            </td>
            <td class="europe__cell europe__cell--action">
              <a class="europe__link" href="#modal"><span>Проконсультироваться</span><svg class="europe__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
            </td>
          </tr>

          <tr class="europe__row">
            <td class="europe__cell europe__cell--country">
              <img class="europe__flag" src="<?= THEME_PATH; ?>/assets/img/flags/es.svg" alt="" width="16" height="12">
              <span class="europe__country-name">Испания</span>
              <span class="europe__country-note">ВНЖ, ЕС</span>
            </td>
            <td class="europe__cell europe__cell--strong">от € 3 000</td>
            <td class="europe__cell europe__cell--strong">от 1,5 мес.</td>
            <td class="europe__cell">
              <ul class="europe__benefits">
                <li>ВНЖ для всей семьи</li>
                <li>ПМЖ через 5 лет</li>
              </ul>
            </td>
            <td class="europe__cell europe__cell--action">
              <a class="europe__link" href="#modal"><span>Проконсультироваться</span><svg class="europe__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
            </td>
          </tr>

          <tr class="europe__row">
            <td class="europe__cell europe__cell--country">
              <img class="europe__flag" src="<?= THEME_PATH; ?>/assets/img/flags/mt.svg" alt="" width="16" height="12">
              <span class="europe__country-name">Мальта</span>
              <span class="europe__country-note">ВНЖ, ЕС</span>
            </td>
            <td class="europe__cell europe__cell--strong">от € –</td>
            <td class="europe__cell europe__cell--strong">от 2 мес.</td>
            <td class="europe__cell">
              <ul class="europe__benefits">
                <li>Английский язык, статус в ЕС</li>
                <li>Стабильная налоговая система</li>
              </ul>
            </td>
            <td class="europe__cell europe__cell--action">
              <a class="europe__link" href="#modal"><span>Проконсультироваться</span><svg class="europe__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
            </td>
          </tr>

          <tr class="europe__row">
            <td class="europe__cell europe__cell--country">
              <img class="europe__flag" src="<?= THEME_PATH; ?>/assets/img/flags/cy.svg" alt="" width="16" height="12">
              <span class="europe__country-name">Кипр</span>
              <span class="europe__country-note">ВНЖ, ЕС</span>
            </td>
            <td class="europe__cell europe__cell--strong">по запросу</td>
            <td class="europe__cell europe__cell--strong">индивидуально</td>
            <td class="europe__cell">
              <ul class="europe__benefits">
                <li>Льготные налоговые режимы</li>
                <li>Мягкий климат, ВНЖ для семьи</li>
              </ul>
            </td>
            <td class="europe__cell europe__cell--action">
              <a class="europe__link" href="#modal"><span>Проконсультироваться</span><svg class="europe__link-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

    <div class="europe__foot">
      <p class="europe__foot-text">
        Не знаете, что выбрать?<br>
        Подскажем подходящую программу под вашу цель и бюджет.
      </p>
      <a class="europe__btn" href="#modal">
        <span>Проконсультироваться по программам</span>
        <svg class="europe__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
      </a>
    </div>
  </div>
</section>


<!-- ===== Статьи и новости ===== -->
<section class="news">
  <div class="container">
    <div class="news__top">
      <span class="news__badge">Статьи и новости</span>
      <h2 class="news__title">
        Следим за изменениями
        <span class="news__title-accent">в отрасли</span>
      </h2>
    </div>

    <div class="news__panel">
      <div class="news__grid">

        <!-- Главная статья -->
        <article class="news__main">
          <a class="news__main-image" href="#">
            <img src="<?= THEME_PATH; ?>/assets/img/news-main.jpg" alt="" loading="lazy">
          </a>
          <div class="news__main-body">
            <ul class="news__tags">
              <li class="news__tag">ВНЖ</li>
              <li class="news__tag">ОАЭ</li>
            </ul>
            <h3 class="news__main-title"><a href="#">ВНЖ в ОАЭ через компанию: как оформить в 2026 году</a></h3>
            <p class="news__main-text">Пошаговый разбор: какие фризоны выбрать, сколько стоит, какие документы нужны и сколько времени занимает оформление резидентства.</p>
            <div class="news__meta">
              <ul class="news__meta-list">
                <li class="news__meta-item">
                  <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                  10 мин
                </li>
                <li class="news__meta-item">
                  <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                  234
                </li>
              </ul>
              <span class="news__meta-item">
                <time datetime="2026-08-19">19 августа 2026</time>
                <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
              </span>
            </div>
          </div>
        </article>

        <!-- Три статьи справа -->
        <div class="news__side">

          <article class="news__item">
            <a class="news__item-image" href="#">
              <img src="<?= THEME_PATH; ?>/assets/img/news-1.jpg" alt="" loading="lazy">
            </a>
            <div class="news__item-body">
              <ul class="news__tags">
                <li class="news__tag">Счета</li>
                <li class="news__tag">ОАЭ</li>
              </ul>
              <h3 class="news__item-title"><a href="#">Как открыть счёт нерезиденту в ОАЭ и пройти комплаенс</a></h3>
              <p class="news__item-text">Что спрашивает банк о происхождении средств и как подготовиться заранее.</p>
              <div class="news__meta">
                <ul class="news__meta-list">
                  <li class="news__meta-item">
                    <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    10 мин
                  </li>
                  <li class="news__meta-item">
                    <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    234
                  </li>
                </ul>
                <span class="news__meta-item">
                  <time datetime="2026-09-23">23 сентября 2026</time>
                  <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                </span>
              </div>
            </div>
          </article>

          <article class="news__item">
            <a class="news__item-image" href="#">
              <img src="<?= THEME_PATH; ?>/assets/img/news-2.jpg" alt="" loading="lazy">
            </a>
            <div class="news__item-body">
              <ul class="news__tags">
                <li class="news__tag">Компании</li>
                <li class="news__tag">ОАЭ</li>
              </ul>
              <h3 class="news__item-title"><a href="#">Free Zone или Mainland: где регистрировать компанию</a></h3>
              <p class="news__item-text">Сравниваем налоги, владение и стоимость двух форматов.</p>
              <div class="news__meta">
                <ul class="news__meta-list">
                  <li class="news__meta-item">
                    <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    1 мин
                  </li>
                  <li class="news__meta-item">
                    <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    234
                  </li>
                </ul>
                <span class="news__meta-item">
                  <time datetime="2026-08-19">19 августа 2026</time>
                  <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                </span>
              </div>
            </div>
          </article>

          <article class="news__item">
            <a class="news__item-image" href="#">
              <img src="<?= THEME_PATH; ?>/assets/img/news-3.jpg" alt="" loading="lazy">
            </a>
            <div class="news__item-body">
              <ul class="news__tags">
                <li class="news__tag">Счета</li>
                <li class="news__tag">ОАЭ</li>
              </ul>
              <h3 class="news__item-title"><a href="#">Золотая виза ОАЭ: кому подходит и как получить</a></h3>
              <p class="news__item-text">Условия по инвестициям, недвижимости и таланту — простыми словами.</p>
              <div class="news__meta">
                <ul class="news__meta-list">
                  <li class="news__meta-item">
                    <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    10 мин
                  </li>
                  <li class="news__meta-item">
                    <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    234
                  </li>
                </ul>
                <span class="news__meta-item">
                  <time datetime="2026-07-19">19 июля 2026</time>
                  <svg class="news__meta-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                </span>
              </div>
            </div>
          </article>

        </div>
      </div>

      <div class="news__foot">
        <a class="news__btn" href="/blog/">
          <span>Перейти в блог</span>
          <svg class="news__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

</main>

<?php get_footer(); ?>
