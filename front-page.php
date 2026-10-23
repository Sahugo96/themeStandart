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

    
    
    theme_render_front_section('main-hero'); // +
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
    theme_render_front_section('flagship'); // +
    theme_render_front_section('europe'); // +
    ?>

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
