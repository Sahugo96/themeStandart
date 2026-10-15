<?php

defined('ABSPATH') || exit;

class Image{

    /**
     * Пустой набор атрибутов изображения.
     *
     * @return array{url:string,srcset:string,sizes:string,alt:string}
     */
    public static function empty_attrs(): array {
        return [
            'url'    => '',
            'srcset' => '',
            'sizes'  => '',
            'alt'    => '',
        ];
    }

    /**
     * Атрибуты изображения (url/srcset/sizes/alt).
     *
     * Безопасно принимает null/пустое/не-массив значение (например, когда
     * ACF-поле не заполнено) и ВСЕГДА возвращает массив с ключами
     * url/srcset/sizes/alt — пустые строки, если изображения нет.
     *
     * @param mixed $image Массив ACF-изображения (url/ID/alt) или что угодно.
     * @return array{url:string,srcset:string,sizes:string,alt:string}
     */
    public static function get_image_attrs($image): array {
        if (!is_array($image) || empty($image)) {
            return self::empty_attrs();
        }

        $image_id  = (int) ($image['ID'] ?? $image['id'] ?? 0);
        $image_url = (string) ($image['url'] ?? '');

        if ($image_url === '' && $image_id > 0) {
            $image_url = (string) wp_get_attachment_image_url($image_id, 'full');
        }

        $image_srcset = $image_id > 0 ? (string) wp_get_attachment_image_srcset($image_id, 'full') : '';
        $image_alt    = !empty($image['alt']) ? esc_attr($image['alt']) : 'Image';
        $image_sizes  = $image_srcset ? esc_attr(SIZES) : '';

        return [
            'url'    => esc_url($image_url),
            'srcset' => $image_srcset ? esc_attr($image_srcset) : '',
            'sizes'  => $image_sizes,
            'alt'    => $image_alt,
        ];
    }
}
