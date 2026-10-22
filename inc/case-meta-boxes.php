<?php

defined('ABSPATH') || exit;

/**
 * Мета-поля записи «Кейс» (CPT case) без плагина ACF.
 *
 * Поля: Метка, Заголовок, История (шаги: подпись + текст),
 * Факты (подпись + значение).
 */

add_action('add_meta_boxes', 'tolstenko_add_case_meta_boxes');
function tolstenko_add_case_meta_boxes(): void
{
    add_meta_box('case_meta_box', 'Данные кейса', 'tolstenko_render_case_meta_box', 'case', 'normal', 'default');
}

add_action('admin_enqueue_scripts', 'tolstenko_case_meta_assets');
function tolstenko_case_meta_assets(string $hook): void
{
    global $post;

    if (!in_array($hook, ['post.php', 'post-new.php'], true) || ! $post instanceof WP_Post || $post->post_type !== 'case') {
        return;
    }

    $js_path = get_template_directory() . '/inc/js/case-meta.js';

    if (file_exists($js_path)) {
        wp_enqueue_script(
            'tolstenko-case-meta',
            get_template_directory_uri() . '/inc/js/case-meta.js',
            ['jquery'],
            filemtime($js_path),
            true
        );
    }
}
/**
 * HTML метабокса.
 */
function tolstenko_render_case_meta_box(WP_Post $post): void
{
    wp_nonce_field('casemeta_save', 'casemeta_nonce');

    $tag   = (string) get_post_meta($post->ID, 'case_tag', true);
    $title = (string) get_post_meta($post->ID, 'case_title', true);
    $steps = get_post_meta($post->ID, 'case_steps', true);
    $facts = get_post_meta($post->ID, 'case_facts', true);

    $steps = is_array($steps) ? $steps : [];
    $facts = is_array($facts) ? $facts : [];
    ?>
    <div class="case-meta-box">
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="case_tag">Метка</label></th>
                <td><input type="text" id="case_tag" name="case_tag" value="<?php echo esc_attr($tag); ?>" class="widefat" placeholder="Счёт нерезиденту" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="case_title">Заголовок карточки</label></th>
                <td>
                    <textarea id="case_title" name="case_title" rows="2" class="widefat" placeholder="Банк в ЕС&lt;br&gt;закрыл счёт"><?php echo esc_textarea($title); ?></textarea>
                    <p class="description">HTML разрешён; &lt;br&gt; — перенос строки.</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label>История (шаги)</label></th>
                <td>
                    <div id="case-steps-template" style="display:none;">
                        <div class="case-step-row" style="margin-top:8px; display:flex; gap:8px; align-items:flex-start; flex-wrap:wrap;">
                            <input type="text" name="case_steps[__INDEX__][label]" placeholder="Подпись (Задача)" style="min-width:140px;" />
                            <textarea name="case_steps[__INDEX__][text]" rows="2" placeholder="Текст шага" style="flex:1; min-width:280px;"></textarea>
                            <button type="button" class="button case-remove-step">Удалить</button>
                        </div>
                    </div>

                    <div class="case-steps-repeater">
                        <?php foreach ($steps as $index => $step) : ?>
                            <?php
                            $step      = is_array($step) ? $step : [];
                            $step_label = (string) ($step['label'] ?? '');
                            $step_text  = (string) ($step['text'] ?? '');
                            ?>
                            <div class="case-step-row" style="margin-top:8px; display:flex; gap:8px; align-items:flex-start; flex-wrap:wrap;">
                                <input type="text" name="case_steps[<?php echo esc_attr($index); ?>][label]" value="<?php echo esc_attr($step_label); ?>" placeholder="Подпись (Задача)" style="min-width:140px;" />
                                <textarea name="case_steps[<?php echo esc_attr($index); ?>][text]" rows="2" placeholder="Текст шага" style="flex:1; min-width:280px;"><?php echo esc_textarea($step_text); ?></textarea>
                                <button type="button" class="button case-remove-step">Удалить</button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="button case-add-step" style="margin-top:8px;">Добавить шаг</button>
                    <p class="description">Обычно три шага: Задача / Решение / Результат.</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label>Факты</label></th>
                <td>
                    <div id="case-facts-template" style="display:none;">
                        <div class="case-fact-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                            <input type="text" name="case_facts[__INDEX__][label]" placeholder="Подпись (Срок)" style="min-width:140px;" />
                            <input type="text" name="case_facts[__INDEX__][value]" placeholder="Значение (12 дней)" style="flex:1; min-width:200px;" />
                            <button type="button" class="button case-remove-fact">Удалить</button>
                        </div>
                    </div>

                    <div class="case-facts-repeater">
                        <?php foreach ($facts as $index => $fact) : ?>
                            <?php
                            $fact       = is_array($fact) ? $fact : [];
                            $fact_label = (string) ($fact['label'] ?? '');
                            $fact_value = (string) ($fact['value'] ?? '');
                            ?>
                            <div class="case-fact-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                <input type="text" name="case_facts[<?php echo esc_attr($index); ?>][label]" value="<?php echo esc_attr($fact_label); ?>" placeholder="Подпись (Срок)" style="min-width:140px;" />
                                <input type="text" name="case_facts[<?php echo esc_attr($index); ?>][value]" value="<?php echo esc_attr($fact_value); ?>" placeholder="Значение (12 дней)" style="flex:1; min-width:200px;" />
                                <button type="button" class="button case-remove-fact">Удалить</button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="button case-add-fact" style="margin-top:8px;">Добавить факт</button>
                    <p class="description">Первая иконка — «часы», вторая — «кошелёк» (как в макете).</p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Сохраняет мета-поля кейса.
 */
add_action('save_post_case', 'tolstenko_save_case_meta', 10, 2);
function tolstenko_save_case_meta(int $post_id, WP_Post $post): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (wp_is_post_revision($post_id)) {
        return;
    }

    if (! isset($_POST['casemeta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['casemeta_nonce'])), 'casemeta_save')) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, 'case_tag', sanitize_text_field(wp_unslash($_POST['case_tag'] ?? '')));
    update_post_meta($post_id, 'case_title', wp_kses_post(wp_unslash($_POST['case_title'] ?? '')));

    $clean_steps = [];

    if (isset($_POST['case_steps']) && is_array($_POST['case_steps'])) {
        foreach (wp_unslash($_POST['case_steps']) as $step) {
            if (! is_array($step)) {
                continue;
            }

            $label = sanitize_text_field($step['label'] ?? '');
            $text  = sanitize_textarea_field($step['text'] ?? '');

            if ($label === '' && $text === '') {
                continue;
            }

            $clean_steps[] = ['label' => $label, 'text' => $text];
        }
    }

    update_post_meta($post_id, 'case_steps', $clean_steps);

    $clean_facts = [];

    if (isset($_POST['case_facts']) && is_array($_POST['case_facts'])) {
        foreach (wp_unslash($_POST['case_facts']) as $fact) {
            if (! is_array($fact)) {
                continue;
            }

            $label = sanitize_text_field($fact['label'] ?? '');
            $value = sanitize_text_field($fact['value'] ?? '');

            if ($label === '' && $value === '') {
                continue;
            }

            $clean_facts[] = ['label' => $label, 'value' => $value];
        }
    }

    update_post_meta($post_id, 'case_facts', $clean_facts);
}
