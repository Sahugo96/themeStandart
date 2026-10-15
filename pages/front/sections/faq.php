<?php

/**
 * FAQ на странице блога.
 *
 * Данные берутся из ACF-полей текущей страницы (faq_badge, faq_title,
 * faq_items, faq_form_title, faq_form_text) — см. inc/acf-faq-fields.php.
 * Рендер общий с блоком my-theme/faq (pages/sections/faq.php).
 */

set_query_var('section', true);
get_template_part('pages/sections/faq');
