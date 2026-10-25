<?php

/**
 * Шаблон результатов поиска.
 *
 * Форма в шапке (modules/header-menu.php): method="get", action="home_url()", поле name="s".
 * Какие типы записей ищутся и в каком порядке идут табы — inc/search.php.
 * Результаты разбиты на табы по типу записи (универсальный фильтр .filter--tabs)
 * и выводятся карточками темы: услуги, статьи, кейсы.
 */

defined('ABSPATH') || exit;

get_header();

$search_query = get_search_query();
$post_types   = theme_search_post_types();
$groups       = [];

if (have_posts()) {
    while (have_posts()) {
        the_post();
        $post_type = get_post_type();

        if (isset($post_types[$post_type])) {
            $groups[$post_type][] = get_post();
        }
    }

    rewind_posts();
}

// Табы — в порядке theme_search_post_types(), только непустые.
$groups = array_filter(array_replace(array_fill_keys(array_keys($post_types), []), $groups));
$active_type = (string) array_key_first($groups);
$found_total = array_sum(array_map('count', $groups));

$card_templates = [
    'service' => 'pages/sections/partials/service-card',
    'blog'    => 'pages/sections/partials/blog-card',
    'case'    => 'pages/sections/partials/case-card',
];
?>

<main class="main">
  <section class="search-results section load-on-vissible--js" data-module="./modules/searchResultsTabs.js">
    <div class="container">
      <div class="search-results__top section-top">
        <span class="search-results__badge section-subtitle">Поиск</span>

        <h1 class="search-results__title section-title">
          <?php if ($search_query !== '') : ?>
            Результаты по запросу <span>«<?= esc_html($search_query); ?>»</span>
          <?php else : ?>
            Поиск по сайту
          <?php endif; ?>
        </h1>

        <?php if ($found_total) : ?>
          <p class="search-results__count">Найдено: <?= (int) $found_total; ?></p>
        <?php endif; ?>
      </div>

      <form class="search-results__form" role="search" method="get" action="<?= esc_url(home_url('/')); ?>">
        <input class="search-results__input" type="search" name="s" value="<?= esc_attr($search_query); ?>" placeholder="Найти" required>
        <button class="search-results__submit" type="submit">Найти</button>
      </form>

      <?php if ($groups) : ?>
        <div class="search-results__filter filter filter--tabs filter--dark">
          <div class="filter__form">
            <?php foreach ($groups as $post_type => $items) : ?>
              <button class="filter__link<?= $post_type === $active_type ? ' active' : ''; ?>" type="button" data-filter="<?= esc_attr($post_type); ?>">
                <span class="filter__label"><?= esc_html($post_types[$post_type]); ?> · <?= count($items); ?></span>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <?php foreach ($groups as $post_type => $items) : ?>
          <div class="search-results__group search-results__group--<?= esc_attr($post_type); ?>" data-group="<?= esc_attr($post_type); ?>"<?= $post_type === $active_type ? '' : ' hidden'; ?>>
            <div class="search-results__grid fade-in-container">
              <?php
              foreach ($items as $item) {
                  $GLOBALS['post'] = $item;
                  setup_postdata($item);
                  get_template_part($card_templates[$post_type]);
              }
              wp_reset_postdata();
              ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <p class="search-results__empty">
          <?= $search_query !== '' ? 'По вашему запросу ничего не найдено. Попробуйте изменить формулировку.' : 'Введите запрос, чтобы найти услуги, статьи и кейсы.'; ?>
        </p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
