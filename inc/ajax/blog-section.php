<?php

add_action('wp_enqueue_scripts', 'blog_section_ajax_data');

function blog_section_ajax_data()
{
    wp_add_inline_script('jquery', '
        window.blog_ajax = {
            ajax_url: "' . admin_url('admin-ajax.php') . '"
        };
    ', 'before');
}

add_action('wp_ajax_filter_blog_section', 'handle_blog_section_filter');
add_action('wp_ajax_nopriv_filter_blog_section', 'handle_blog_section_filter');

function handle_blog_section_filter()
{
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $taxonomy = isset($_POST['taxonomy']) ? sanitize_text_field($_POST['taxonomy']) : 'blog_cat';
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'blog';
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 4;

    if ($posts_per_page < 1) {
        $posts_per_page = 4;
    }

    $posts_per_page = min(4, $posts_per_page);

    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'paged'          => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    if (!empty($category)) {
        $args['tax_query'] = [
            [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $category,
            ],
        ];
    }

    $query = new WP_Query($args);

    $months = [
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря'
    ];

    ob_start();

    $index = 1;

    if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : $query->the_post(); ?>

            <article class="blog-section__item blog-card fade-in-element splide__slide">
                <a class="blog-card__link" href="<?= get_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="blog-card__image">
                            <?= get_the_post_thumbnail(get_the_ID()); ?>

                            <svg viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.17309 3.41726C3.48384 3.41726 3.73572 3.66411 3.73572 3.96866V10.1167C4.52232 9.06924 5.30923 8.02205 6.08642 6.96803C6.33162 6.63553 6.63297 6.47522 7.05752 6.47879C8.35911 6.49009 9.66102 6.47731 10.9629 6.48207C11.4561 6.48385 11.6606 6.53115 11.7425 6.77294C11.8315 6.88298 11.887 7.02037 11.887 7.17175V9.90673C11.8946 9.94866 11.9025 9.99239 11.9103 10.0403C12.6372 9.05882 13.2936 8.18057 13.9418 7.29666C14.7873 6.1442 15.6121 4.97658 16.4822 3.84226C16.6391 3.63764 16.9641 3.46573 17.2244 3.4461C17.9379 3.39256 18.6584 3.43033 19.3761 3.42795C19.7721 3.42676 19.9448 3.61147 19.9445 4.00226L19.9448 4.00165C19.9417 7.4528 19.9445 10.9043 19.9508 14.3557C19.9514 14.7632 19.7715 14.9592 19.3533 14.9633C18.6857 14.9699 18.0183 14.9933 17.3507 14.9996C16.6369 15.0061 16.5705 14.9407 16.5705 14.2534C16.5705 12.6994 16.5775 11.1457 16.5729 9.59178C16.5723 9.32768 16.528 9.06358 16.5037 8.79949C16.4403 8.78848 16.3765 8.77747 16.3131 8.76646C15.6737 9.61706 15.0282 10.4632 14.3964 11.3188C13.6162 12.3752 12.8423 13.4358 12.0773 14.5026C11.8585 14.8075 11.6117 14.9684 11.2072 14.9508C10.9514 14.9398 10.6953 14.9362 10.4388 14.9353H10.081C9.75572 14.9383 9.43009 14.9452 9.10507 14.9526C9.02465 14.9544 8.95453 14.9475 8.8908 14.9353H8.85924C8.49569 14.9353 8.20103 14.6466 8.20103 14.2903V8.89466C8.14579 8.92411 8.0948 8.95682 8.0599 9.00143C6.71947 10.7282 5.3857 12.8014 4.0568 14.5368C3.94877 14.6781 3.76939 14.9633 3.31418 14.9633C2.85898 14.9633 0.6121 14.9633 0.6121 14.9633C0.301346 14.9633 0.0494623 14.7165 0.0494623 14.4119V3.96866C0.0494623 3.66411 0.301346 3.41726 0.6121 3.41726H3.17309Z" />
                                <path d="M19.3418 0C19.705 0 20 0.289096 20 0.645096V1.64586C20 2.00187 19.705 2.29096 19.3418 2.29096H0.658243C0.294988 2.29096 0 2.00187 0 1.64586V0.645096C0 0.289096 0.294988 0 0.658243 0H19.3418Z" />
                            </svg>
                        </div>
                    <?php endif; ?>

                    <div class="blog-card__wrapper">
                        <?php
                        $post_id = get_the_ID();
                        $tags = get_the_terms($post_id, 'blog_cat');

                        if ($tags && !is_wp_error($tags)) :

                            $selected_category = isset($_POST['category']) ? $_POST['category'] : '';

                            if (!empty($selected_category)) {
                                $selected_term = null;
                                $other_terms = [];

                                foreach ($tags as $tag) {
                                    if ($tag->slug === $selected_category) {
                                        $selected_term = $tag;
                                    } else {
                                        $other_terms[] = $tag;
                                    }
                                }

                                if ($selected_term) {
                                    $tags = array_merge([$selected_term], $other_terms);
                                }
                            }

                            if ($tags && !is_wp_error($tags)) :
                                $tags = array_slice($tags, 0, 2);
                        ?>
                                <div class="blog-card__tags">
                                    <?php foreach ($tags as $tag) : ?>
                                        <span class="blog-card__tag">
                                            <?= esc_html($tag->name); ?>
                                        </span>
                                    <?php endforeach; ?>

                                    <?php if ($index) {
                                        $months = [
                                            1 => 'января',
                                            2 => 'февраля',
                                            3 => 'марта',
                                            4 => 'апреля',
                                            5 => 'мая',
                                            6 => 'июня',
                                            7 => 'июля',
                                            8 => 'августа',
                                            9 => 'сентября',
                                            10 => 'октября',
                                            11 => 'ноября',
                                            12 => 'декабря'
                                        ];

                                        $post_date = get_the_date('j n Y');
                                        $date_parts = explode(' ', $post_date);
                                        $day = $date_parts[0];
                                        $month_num = (int)$date_parts[1];
                                        $year = $date_parts[2];

                                        $datee = $day . ' ' . $months[$month_num] . ', ' . $year;
                                    ?>
                                        <span class="blog-card__tag blog-card__tag--date">
                                            <?= $datee; ?>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <h4 class="blog-card__title"><?= get_the_title(); ?></h4>

<div class="blog-card__text line-13-15"><?= esc_html(theme_get_blog_card_text($post_id)); ?></div>

                        <div class="blog-card__stats">
                          <?php    get_template_part('modules/stats/stats'); ?>
                        </div>
                    </div>
                </a>
            </article>


            <?php if ($index) { ?>
                <div class="splide__track">
                    <div class="blog-section__splide-list splide__list">
                <?php
                $index = 0;
            }
        endwhile;
                ?>
                    </div>

                    <div class="splide__pagination"></div>

                    <a class="blog-section__btn default-btn" href="<?= theme_get_field('blog_section_btn', OPTION_ID)['url']; ?>">
                    <?= theme_get_field('blog_section_btn', OPTION_ID)['title']; ?>

                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.87524 14.1246L13.5356 6.46426M7.05376 5.875H13.2915C13.7517 5.875 14.1248 6.2481 14.1248 6.70833V12.9461" stroke="black" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </a>
                </div>

                <?php if (wp_doing_ajax()) : ?>
                    <script>
                        (function() {
                            if (window.innerWidth < 992) {
                                var splideElement = document.querySelector('.blog-section__splide');
                                if (splideElement) {
                                    setTimeout(function() {
                                        var splide = new Splide('.blog-section__splide', {
                                            perPage: 1,
                                            perMove: 1,
                                            gap: "20px",
                                            pagination: true,
                                            arrows: false,
                                            updateOnMove: true,
                                        });
                                        splide.mount();
                                        splideElement.classList.add('splide--initialized');
                                    }, 100);
                                }
                            }
                        })();
                    </script>
                <?php endif;
            endif;

            wp_reset_postdata();
            $html = ob_get_clean();

            wp_send_json_success(['html' => $html, 'scripts' => true]);
        }