<?php
defined('ABSPATH') || exit;

class Get {
    /**
     * Получить значение по языку.
     *
     * @param mixed $en Значение для английского языка.
     * @param mixed $ru Значение для русского языка.
     * @param mixed $default Значение по умолчанию (например, для других языков).
     * @return mixed Значение на основе текущего языка.
     */
    public static function lang_attr($en, $ru, $ge, $ua, $default = '') {
        if (defined('LANG')) {
            switch (LANG) {
                case 'en':
                    return $en;
                case 'ru':
                    return $ru;
                case 'ge':
                    return $ge;
                case 'ua':
                    return $ua;
                default:
                    return $default;
            }
        }
        return $default;
    }

    /**
     * Получить ID опции на основе языка.
     *
     * @param int $defaultId ID для других языков.
     * @return int|null ID на основе текущего языка или null.
     */
    public static function option_id($defaultId = 26) {
        if (defined('LANG')) {
            switch (LANG) {
                case 'en':
                    return 33;
                case 'ru':
                    return 26;
                default:
                    return $defaultId;
            }
        }
        return null;
    }

    /**
     * Получить значение по ключу из массива с учетом языка.
     *
     * @param array $data Ассоциативный массив, где ключи — языковые коды.
     * @param mixed $default Значение по умолчанию, если язык не найден.
     * @return mixed Значение на основе текущего языка.
     */
    public static function from_array(array $data, $default = null) {
        if (defined('LANG') && array_key_exists(LANG, $data)) {
            return $data[LANG];
        }
        return $default;
    }
}
