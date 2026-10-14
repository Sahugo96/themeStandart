<?php
defined('ABSPATH') || exit;
class Image{

    public static function get_image_attrs(array $image): array {
        if ($image) {
            $image_url = esc_url($image['url']);
            $image_srcset = wp_get_attachment_image_srcset($image['ID'], 'full');
            $image_alt = !empty($image['alt']) ? esc_attr($image['alt']) : 'Image';
            $image_sizes = $image_srcset ? esc_attr(SIZES) : '';

            return [
                'url' => $image_url,
                'srcset' => $image_srcset ? esc_attr($image_srcset) : '',
                'sizes' => $image_sizes,
                'alt' => $image_alt
            ];
        }
        return [];
    }

}