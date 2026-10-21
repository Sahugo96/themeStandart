<?php

defined('ABSPATH') || exit;

/**
 * Секция «Команда».
 *
 * Заголовок секции — из админки: tolstenko_get_block_defaults('team')
 * (таб «Дефолты блоков → Команда»). Карточки — из CPT «teammate».
 */

$admin = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('team') : [];

$defaults = [
    'subtitle' => $admin['badge'] ?? '',
    'title'    => $admin['title'] ?? '',
    'text'     => $admin['text'] ?? '',
];

$overrides = get_query_var('team_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$teammates = get_posts([
    'post_type'      => 'teammate',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'ASC'],
]);

if (empty($teammates) && trim((string) $data['title']) === '') {
    return;
}

$split_lines = static function ($value): array {
    $lines = preg_split('/\r\n|\r|\n/', (string) $value);

    return array_values(array_filter(array_map('trim', (array) $lines), static function ($line) {
        return $line !== '';
    }));
};
?>
<section class="team section">
  <div class="container">
    <div class="team__top section-top">
      <?php if (trim((string) $data['subtitle']) !== '') : ?>
        <span class="team__badge section-subtitle"><?= $data['subtitle']; ?></span>
      <?php endif; ?>

      <?php if (trim((string) $data['title']) !== '') : ?>
        <h2 class="team__title section-title"><?= $data['title']; ?></h2>
      <?php endif; ?>

      <?php if (trim((string) $data['text']) !== '') : ?>
        <div class="team__text section-text"><?= theme_section_text_html($data['text']); ?></div>
      <?php endif; ?>
    </div>

    <?php if (!empty($teammates)) : ?>
      <div class="team__splide splide load-on-vissible--js"
        aria-label="<?= esc_attr(wp_strip_all_tags($data['title'])); ?>"
        data-module="./libs/splide.min.js,./modules/teamSplideInit.js"
        data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css"
        id="team-container">

        <div class="splide__track">
          <div class="team__list splide__list">

            <?php foreach ($teammates as $teammate) :
              $teammate_id = (int) $teammate->ID;
              $name = trim((string) get_post_meta($teammate_id, 'teammate_name', true));

              if ($name === '') {
                  $name = get_the_title($teammate);
              }

              $image_id = (int) get_post_meta($teammate_id, 'teammate_image_id', true);
              $image = tolstenko_contact_get_image_attrs($image_id);
              $tags = $split_lines((string) get_post_meta($teammate_id, 'teammate_list', true));
              $description = (string) get_post_meta($teammate_id, 'teammate_description', true);
              $btn_text = trim((string) get_post_meta($teammate_id, 'teammate_btn_text', true));
              $btn_url = trim((string) get_post_meta($teammate_id, 'teammate_btn_url', true));
              $links = get_post_meta($teammate_id, 'teammate_links', true);
              $links = is_array($links) ? $links : [];
            ?>
              <article class="team__item br-30 fade-in-element splide__slide">
                <div class="team__item-head">
                  <?php if ($image['url'] !== '') : ?>
                    <div class="team__item-img">
                      <img src="<?= $image['url']; ?>" <?php if ($image['srcset']) echo 'srcset="' . $image['srcset'] . '"'; ?> alt="<?= esc_attr($name); ?>" loading="lazy">
                    </div>
                  <?php endif; ?>

                  <div class="team__item-info">
                    <h3 class="team__item-name"><?= esc_html($name); ?></h3>

                    <?php if (!empty($tags)) : ?>
                      <ul class="team__item-tags">
                        <?php foreach ($tags as $tag) : ?>
                          <li class="team__item-tag"><?= esc_html($tag); ?></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  </div>
                </div>

                <?php if (trim($description) !== '') : ?>
                  <p class="team__item-text reg-par-14-20"><?= nl2br(esc_html($description)); ?></p>
                <?php endif; ?>

                <?php if ($btn_text !== '' || !empty($links)) : ?>
                  <div class="team__item-bottom">
                    <?php if ($btn_text !== '') : ?>
                      <a class="team__item-btn default-btn" href="<?= esc_url($btn_url !== '' ? $btn_url : '#modal'); ?>">
                        <?= esc_html($btn_text); ?>
                      </a>
                    <?php endif; ?>

                    <?php if (!empty($links)) : ?>
                      <div class="team__item-links">
                        <?php foreach ($links as $link) :
                          $link = is_array($link) ? $link : [];
                          $icon_id = (int) ($link['icon_id'] ?? 0);
                          $link_title = trim((string) ($link['title'] ?? ''));
                          $link_url = trim((string) ($link['link'] ?? ''));

                          if ($link_url === '') {
                              continue;
                          }

                          $svg = function_exists('tolstenko_contact_get_inline_svg') ? tolstenko_contact_get_inline_svg($icon_id) : '';
                          $icon_url = tolstenko_contact_resolve_icon_url($icon_id);
                        ?>
                          <a class="team__item-link" href="<?= esc_url($link_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc_attr($name); ?> — ссылка">
                            <?php if ($svg !== '') : ?>
                              <?= $svg; ?>
                            <?php elseif ($icon_url !== '') : ?>
                              <img src="<?= esc_url($icon_url); ?>" alt="" loading="lazy">
                            <?php endif; ?>
                            <?php if ($link_title !== '') : ?>
                              <span class="team__item-link-title"><?= esc_html($link_title); ?></span>
                            <?php endif; ?>
                          </a>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </article>
            <?php endforeach; ?>

          </div>
        </div>

        <div class="splide__bottom">
          <div class="splide__pagination"></div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
