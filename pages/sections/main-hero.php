<?php

$data = get_query_var('main_hero_data') ?? [];

$title          = $data['title']          ?? '';
$title_tag      = $data['title_tag']      ?? 'h1';
$text           = $data['text']           ?? '';
$items          = $data['items']          ?? [];
$btn_text       = $data['btn_text']       ?? 'Оставить заявку';
$show_promo     = $data['show_promo']     ?? false;
$promo_text     = $data['promo_text']     ?? '';
$present_image_id = $data['present_image_id'] ?? 0;
$person_name    = $data['person_name']    ?? '';
$person_position= $data['person_position'] ?? '';
$image_id       = $data['image_id']       ?? 0;
?>
<section class="main-hero section">
    <div class="container">
        <?php if ($title !== ''): ?>
            <<?= esc_attr($title_tag); ?> class="main-hero__title"><?= wp_kses_post($title); ?></<?= esc_attr($title_tag); ?>>
        <?php endif; ?>
    
        <?php if ($text !== ''): ?>
            <div class="main-hero__text"><?= wp_kses_post($text); ?></div>
        <?php endif; ?>
    
        <?php if (!empty($items)): ?>
            <ul class="main-hero__items">
                <?php foreach ($items as $item): ?>
                    <?php
                    $title = is_array($item) ? ($item['title'] ?? '') : (is_object($item) ? ($item->title ?? '') : (string) $item);
                    $text  = is_array($item) ? ($item['text'] ?? '') : (is_object($item) ? ($item->text ?? '') : '');
                    ?>
                    <li class="main-hero__item">
                        <?php if ($title !== ''): ?>
                            <div class="main-hero__item-title"><?= wp_kses_post($title); ?></div>
                        <?php endif; ?>
                        <?php if ($text !== ''): ?>
                            <div class="main-hero__item-text"><?= wp_kses_post($text); ?></div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    
        <?php if ($btn_text !== ''): ?>
            <button class="main-hero__btn"><?= esc_html($btn_text); ?></button>
        <?php endif; ?>
    
        <?php if ($show_promo && $promo_text !== ''): ?>
            <div class="main-hero__promo"><?= wp_kses_post($promo_text); ?></div>
        <?php endif; ?>
    
        <?php if ($present_image_id): ?>
            <div class="main-hero__present"><?= wp_get_attachment_image($present_image_id, 'medium', false, array('class' => 'main-hero__present-img')); ?></div>
        <?php endif; ?>
    
        <?php if ($person_name !== '' || $person_position !== ''): ?>
            <div class="main-hero__person">
                <?php if ($person_name !== ''): ?>
                    <div class="main-hero__person-name"><?= esc_html($person_name); ?></div>
                <?php endif; ?>
                <?php if ($person_position !== ''): ?>
                    <div class="main-hero__person-position"><?= esc_html($person_position); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    
        <?php if ($image_id): ?>
            <div class="main-hero__image"><?= wp_get_attachment_image($image_id, 'large', false, array('class' => 'main-hero__image-img')); ?></div>
        <?php endif; ?>
    </div>
</section>
