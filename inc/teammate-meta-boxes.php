<?php
defined('ABSPATH') || exit;

/**
 * Мета-поля записи «Член команды» (CPT teammate) без плагина ACF.
 *
 * Поля: Имя, Картинка, Список, Описание, текст кнопки, ссылка кнопки,
 * повторитель ссылок (иконка + ссылка).
 */

/**
 * Регистрируем метабокс на странице редактирования teammate.
 */
add_action('add_meta_boxes', 'tolstenko_add_teammate_meta_boxes');
function tolstenko_add_teammate_meta_boxes(): void
{
    add_meta_box(
        'teammate_meta_box',
        'Член команды',
        'tolstenko_render_teammate_meta_box',
        'teammate',
        'normal',
        'default'
    );
}

/**
 * Подключаем медиа-библиотеку и скрипт только на экране редактирования teammate.
 */
add_action('admin_enqueue_scripts', 'tolstenko_teammate_media_assets');
function tolstenko_teammate_media_assets(string $hook): void
{
    global $post;

    if (!in_array($hook, ['post.php', 'post-new.php'], true) || ! $post instanceof WP_Post || $post->post_type !== 'teammate') {
        return;
    }

    wp_enqueue_media();

    $js_url = get_template_directory_uri() . '/inc/js/teammate-meta.js';
    $js_path = get_template_directory() . '/inc/js/teammate-meta.js';

    if (file_exists($js_path)) {
        wp_enqueue_script('tolstenko-teammate-meta', $js_url, ['jquery', 'media-models', 'media-views', 'media-editor'], null, true);
    }
}

/**
 * Выводит HTML метабокса.
 */
function tolstenko_render_teammate_meta_box(WP_Post $post): void
{
    wp_nonce_field('teammeta_save', 'teammeta_nonce');

    $name        = get_post_meta($post->ID, 'teammate_name', true);
    $image_id    = (int) get_post_meta($post->ID, 'teammate_image_id', true);
    $image_url   = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    $list        = get_post_meta($post->ID, 'teammate_list', true);
    $description = get_post_meta($post->ID, 'teammate_description', true);
    $btn_text    = get_post_meta($post->ID, 'teammate_btn_text', true);
    $btn_url     = get_post_meta($post->ID, 'teammate_btn_url', true);
    $links       = get_post_meta($post->ID, 'teammate_links', true);
    $links       = is_array($links) ? $links : [];
    ?>
    <div class="teammate-meta-box">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="teammate_name">Имя</label></th>
                <td>
                    <input type="text" id="teammate_name" name="teammate_name" value="<?php echo esc_attr($name); ?>" class="widefat" />
                    <p class="description">Отображаемое имя члена команды.</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label>Картинка</label></th>
                <td>
                    <input type="hidden" name="teammate_image_id" class="teammate-image-id" value="<?php echo esc_attr($image_id); ?>" />
                    <?php if ($image_url): ?>
                        <img src="<?php echo esc_url($image_url); ?>" style="max-width:200px;height:auto;margin-top:8px;display:block;" />
                    <?php endif; ?>
                    <button type="button" class="button teammate-choose-image">Выбрать изображение</button>
                    <button type="button" class="button teammate-remove-image<?php echo !$image_id ? ' hidden' : ''; ?>">Удалить</button>
                    <p class="description">Фото члена команды из медиабиблиотеки.</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="teammate_list">Список (по одному в строке)</label></th>
                <td>
                    <textarea id="teammate_list" name="teammate_list" rows="3" class="widefat"><?php echo esc_textarea($list); ?></textarea>
                    <p class="description">Каждый элемент с новой строки.</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="teammate_description">Описание</label></th>
                <td>
                    <textarea id="teammate_description" name="teammate_description" rows="4" class="widefat"><?php echo esc_textarea($description); ?></textarea>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="teammate_btn_text">Текст кнопки</label></th>
                <td>
                    <input type="text" id="teammate_btn_text" name="teammate_btn_text" value="<?php echo esc_attr($btn_text); ?>" class="widefat" />
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="teammate_btn_url">Ссылка кнопки</label></th>
                <td>
                    <input type="text" id="teammate_btn_url" name="teammate_btn_url" value="<?php echo esc_attr($btn_url); ?>" class="widefat" />
                </td>
            </tr>

            <tr>
                <th scope="row"><label>Ссылки (иконка + адрес)</label></th>
                <td>
                    <div id="teammate-links-template" style="display:none;">
                        <div class="teammate-link-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                            <input type="hidden" name="teammate_links[__INDEX__][icon_id]" class="teammate-link-icon-id" value="" />
                            <img src="" class="teammate-link-icon-preview" style="max-width:32px;max-height:32px;display:none;" />
                            <button type="button" class="button teammate-link-choose-icon">Загрузить SVG</button>
                            <button type="button" class="button teammate-link-remove-icon hidden" style="margin-left:4px;">Удалить иконку</button>
                            <input type="text" name="teammate_links[__INDEX__][title]" placeholder="Название" style="min-width:120px;" />
                            <input type="text" name="teammate_links[__INDEX__][link]" placeholder="Ссылка" style="flex:1; min-width:220px;" />
                            <button type="button" class="button teammate-remove-link">Удалить строку</button>
                        </div>
                    </div>

                    <div class="teammate-links-repeater">
                        <?php foreach ($links as $index => $link): ?>
                            <?php
                            $icon_id   = (int) ( $link['icon_id'] ?? 0 );
                            $icon_url  = $icon_id ? wp_get_attachment_image_url( $icon_id, 'thumbnail' ) : '';
                            $link_title = $link['title'] ?? '';
                            $link_val  = $link['link'] ?? '';
                            ?>
                            <div class="teammate-link-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                <input type="hidden" name="teammate_links[<?php echo esc_attr($index); ?>][icon_id]" class="teammate-link-icon-id" value="<?php echo esc_attr($icon_id); ?>" />
                                <img src="<?php echo esc_url($icon_url); ?>" class="teammate-link-icon-preview" style="max-width:32px;max-height:32px;<?php echo empty($icon_url) ? 'display:none;' : ''; ?>" />
                                <button type="button" class="button teammate-link-choose-icon">Загрузить SVG</button>
                                <button type="button" class="button teammate-link-remove-icon<?php echo empty($icon_url) ? ' hidden' : ''; ?>" style="margin-left:4px;">Удалить иконку</button>
                                <input type="text" name="teammate_links[<?php echo esc_attr($index); ?>][title]" placeholder="Название" value="<?php echo esc_attr($link_title); ?>" style="min-width:120px;" />
                                <input type="text" name="teammate_links[<?php echo esc_attr($index); ?>][link]" placeholder="Ссылка" value="<?php echo esc_attr($link_val); ?>" style="flex:1; min-width:220px;" />
                                <button type="button" class="button teammate-remove-link">Удалить строку</button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="button teammate-add-link" style="margin-top:8px;">Добавить ссылку</button>
                    <p class="description">Список ссылок с иконками (SVG).</p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Сохраняет мета-поля при обновлении записи teammate.
 */
add_action('save_post_teammate', 'tolstenko_save_teammate_meta', 10, 2);
function tolstenko_save_teammate_meta(int $post_id, WP_Post $post): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['teammeta_nonce']) || !wp_verify_nonce($_POST['teammeta_nonce'], 'teammeta_save')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Простые текстовые поля
    $text_fields = [
        'teammate_name'        => 'sanitize_text_field',
        'teammate_list'        => 'sanitize_textarea_field',
        'teammate_description' => 'sanitize_textarea_field',
        'teammate_btn_text'    => 'sanitize_text_field',
        'teammate_btn_url'     => 'sanitize_text_field',
    ];

    foreach ($text_fields as $field => $callback) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, $callback($_POST[$field]));
        }
    }

    // ID картинки
    if (isset($_POST['teammate_image_id'])) {
        update_post_meta($post_id, 'teammate_image_id', (int) $_POST['teammate_image_id']);
    }

    // Повторитель ссылок
    if (isset($_POST['teammate_links']) && is_array($_POST['teammate_links'])) {
        $clean_links = [];
        foreach ($_POST['teammate_links'] as $link) {
            $icon_id = isset($link['icon_id']) ? (int) $link['icon_id'] : 0;
            $title   = isset($link['title']) ? sanitize_text_field($link['title']) : '';
            $url     = isset($link['link']) ? sanitize_text_field($link['link']) : '';
            if ($icon_id !== 0 || $title !== '' || $url !== '') {
                $clean_links[] = ['icon_id' => $icon_id, 'title' => $title, 'link' => $url];
            }
        }
        update_post_meta($post_id, 'teammate_links', $clean_links);
    }
}