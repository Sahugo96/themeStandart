<?php

defined('ABSPATH') || exit;

/**
 * Ответы квиза (pages/sections/quiz.php) в письме CF7.
 *
 * JS кладёт ответы в скрытое поле quiz_answers формы финального экрана.
 * Поле не объявлено в шаблоне формы, поэтому дописываем его в тело основного письма —
 * любая форма CF7 (например, «Телефон») подходит без правки её шаблона.
 */
add_filter('wpcf7_mail_components', function ($components, $contact_form, $mail) {
    if (!is_object($mail) || !method_exists($mail, 'name') || $mail->name() !== 'mail') {
        return $components;
    }

    $answers = isset($_POST['quiz_answers']) ? sanitize_textarea_field(wp_unslash($_POST['quiz_answers'])) : '';

    if ($answers === '') {
        return $components;
    }

    $is_html = method_exists($mail, 'get') && $mail->get('use_html');
    $block = "Ответы квиза:\n" . $answers;

    $components['body'] = ($components['body'] ?? '') . ($is_html
        ? '<br><br>' . nl2br(esc_html($block))
        : "\n\n" . $block);

    return $components;
}, 10, 3);
