<?php
/**
 * Настройки сайта → Контактные данные.
 * Телефон, почта и два списка соцсетей (моно / цветные).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TOLSTENKO_CONTACT_DATA_OPTION', 'tolstenko_contact_data' );

/**
 * Схема / пустые значения.
 *
 * @return array{
 *   phone: string,
 *   phone_ico: string,
 *   email: string,
 *   email_ico: string,
 *   whatsapp: string,
 *   whatsapp_ico: string,
 *   telegram: string,
 *   telegram_ico: string,
 *   vk_link: string,
 *   vk_ico: string,
 *   max_link: string,
 *   max_ico: string,
 *   logo_header: int,
 *   logo_short: int,
 *   logo_footer: int,
 *   footer_audit_img: int,
 *   footer_name: string,
 *   footer_inn: string,
 *   footer_ogrn: string,
 *   footer_address: string,
 *   footer_bottom_logo: int,
 *   footer_copyright: string,
 *   footer_links: array<int, array{title: string, url: string}>,
 *   modal_title: string,
 *   modal_text: string,
 *   modal_thanks_title: string,
 *   modal_thanks_text: string,
 *   modal_btn: string,
 *   header_services_menu: array<int, array{rubrika: string, groups: array<int, array{title: string, services: array<int, array{title: string, url: string}>}>}>,
 *   header_services_right_title: string,
 *   header_services_right_text: string,
 *   header_services_right_link: array{url: string, title: string, target: string},
 *   socials: array<int, array{icon: string, link: string, text: string, enabled: int}>,
 *   socials_rgb: array<int, array{icon: string, link: string, text: string, enabled: int}>
 * }
 */
function tolstenko_contact_data_defaults() {
	return array(
		'phone'                    => '',
		'phone_ico'                => '',
		'email'                    => '',
		'email_ico'                => '',
		'whatsapp'                 => '',
		'whatsapp_ico'             => '',
		'telegram'                 => '',
		'telegram_ico'             => '',
		'vk_link'                  => '',
		'vk_ico'                   => '',
		'max_link'                 => '',
		'max_ico'                  => '',
		'logo_header'              => 0,
		'logo_short'               => 0,
		'logo_footer'              => 0,
		'footer_audit_img'         => 0,
		'footer_name'              => '',
		'footer_inn'               => '',
		'footer_ogrn'              => '',
		'footer_address'           => '',
		'footer_bottom_logo'       => 0,
		'footer_copyright'         => '',
		'footer_links'             => array(
			array( 'title' => '', 'url' => '' ),
			array( 'title' => '', 'url' => '' ),
			array( 'title' => '', 'url' => '' ),
		),
		'modal_title'              => '',
		'modal_text'               => '',
		'modal_thanks_title'       => '',
		'modal_thanks_text'        => '',
		'modal_btn'                => '',
		'header_services_menu'     => array(),
		'header_services_right_title' => '',
		'header_services_right_text'  => '',
		'header_services_right_link'  => array(
			'url'    => '',
			'title'  => '',
			'target' => '',
		),
		'socials'                  => array(),
		'socials_rgb'              => array(),
		'header_address'           => '',
		'header_hours'             => '',
		'header_phones_title'      => '',
		'header_phones'            => array(),
		'header_services_btn'      => '',
		'header_btn_text'          => '',
		'header_btn_url'           => '',
	);
}

/**
 * Телефоны шапки (выпадающий список у номера): номер, подпись страны, флаг.
 *
 * @param mixed $rows Raw rows.
 * @return array<int, array{phone: string, label: string, flag: int}>
 */
function tolstenko_sanitize_contact_header_phones( $rows ) {
	if ( ! is_array( $rows ) ) {
		return array();
	}
	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$phone = sanitize_text_field( (string) ( $row['phone'] ?? '' ) );
		if ( $phone === '' ) {
			continue;
		}
		$out[] = array(
			'phone' => $phone,
			'label' => sanitize_text_field( (string) ( $row['label'] ?? '' ) ),
			'flag'  => max( 0, (int) ( $row['flag'] ?? 0 ) ),
		);
	}
	return $out;
}

/**
 * Поля «Контактных данных», общие для всех языков (номера, ссылки, иконки, логотипы).
 * В переводе хранятся только текстовые поля (inc/settings-i18n.php).
 *
 * @return string[]
 */
function tolstenko_contact_data_shared_keys() {
	return array(
		'phone', 'email', 'whatsapp', 'telegram', 'vk_link', 'max_link',
		'phone_ico', 'email_ico', 'whatsapp_ico', 'telegram_ico', 'vk_ico', 'max_ico',
		'logo_header', 'logo_short', 'logo_footer', 'footer_audit_img', 'footer_bottom_logo',
		'socials', 'socials_rgb', 'header_btn_url',
		'header_services_menu', 'header_services_right_title', 'header_services_right_text', 'header_services_right_link',
	);
}

/**
 * Номер для ссылки tel: (только цифры и ведущий +).
 *
 * @param string $phone Номер в любом формате.
 * @return string
 */
function tolstenko_contact_phone_href( $phone ) {
	$phone = trim( (string) $phone );
	$plus  = strpos( $phone, '+' ) === 0 ? '+' : '';
	return $plus . preg_replace( '/\D/', '', $phone );
}


/**
 * @param mixed $raw Raw links.
 * @return array<int, array{title: string, url: string}>
 */
function tolstenko_sanitize_contact_footer_links( $raw ) {
	$out = array();
	if ( ! is_array( $raw ) ) {
		$raw = array();
	}
	for ( $i = 0; $i < 3; $i++ ) {
		$row   = isset( $raw[ $i ] ) && is_array( $raw[ $i ] ) ? $raw[ $i ] : array();
		$title = isset( $row['title'] ) ? sanitize_text_field( (string) $row['title'] ) : '';
		$url   = isset( $row['url'] ) ? esc_url_raw( trim( (string) $row['url'] ) ) : '';
		$out[] = array(
			'title' => $title,
			'url'   => $url,
		);
	}
	return $out;
}

/**
 * @param mixed $rows Raw rows.
 * @return array<int, array{icon: string, link: string, text: string, enabled: int}>
 */
function tolstenko_sanitize_contact_social_rows( $rows ) {
	if ( ! is_array( $rows ) ) {
		return array();
	}
	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$icon    = isset( $row['icon'] ) ? trim( (string) $row['icon'] ) : '';
		$link    = isset( $row['link'] ) ? esc_url_raw( trim( (string) $row['link'] ) ) : '';
		$text    = isset( $row['text'] ) ? sanitize_text_field( (string) $row['text'] ) : '';
		$enabled = ! isset( $row['enabled'] ) || ! empty( $row['enabled'] ) ? 1 : 0;
		if ( $icon === '' && $link === '' && $text === '' ) {
			continue;
		}
		$out[] = array(
			'icon'    => $icon,
			'link'    => $link,
			'text'    => $text,
			'enabled' => $enabled,
		);
	}
	return $out;
}

/**
/**
 * Иконка: ID вложения или URL.
 *
 * @param mixed $raw Raw value.
 * @return string
 */
function tolstenko_sanitize_contact_icon( $raw ) {
	$value = trim( (string) $raw );
	if ( $value === '' ) {
		return '';
	}
	if ( ctype_digit( $value ) ) {
		return $value;
	}
	return esc_url_raw( $value );
}

/**
 * Меню панели услуг в шапке: рубрики → группы → услуги.
 *
 * @param mixed $raw Raw rows.
 * @return array<int, array{rubrika: string, groups: array<int, array{title: string, services: array<int, array{title: string, url: string}>}>}>
 */
function tolstenko_sanitize_contact_services_menu( $raw ) {
	$out = array();
	if ( ! is_array( $raw ) ) {
		return $out;
	}
	foreach ( $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$rubrika    = sanitize_text_field( (string) ( $row['rubrika'] ?? '' ) );
		$groups_out = array();
		$groups     = isset( $row['groups'] ) && is_array( $row['groups'] ) ? $row['groups'] : array();
		foreach ( $groups as $group ) {
			if ( ! is_array( $group ) ) {
				continue;
			}
			$title        = sanitize_text_field( (string) ( $group['title'] ?? '' ) );
			$services     = array();
			$raw_services = isset( $group['services'] ) && is_array( $group['services'] ) ? $group['services'] : array();
			foreach ( $raw_services as $service ) {
				if ( ! is_array( $service ) ) {
					continue;
				}
				$services[] = array(
					'title' => sanitize_text_field( (string) ( $service['title'] ?? '' ) ),
					'url'   => esc_url_raw( trim( (string) ( $service['url'] ?? '' ) ) ),
				);
			}
			if ( $title === '' && empty( $services ) ) {
				continue;
			}
			$groups_out[] = array(
				'title'    => $title,
				'services' => $services,
			);
		}
		if ( $rubrika === '' && empty( $groups_out ) ) {
			continue;
		}
		$out[] = array(
			'rubrika' => $rubrika,
			'groups'  => $groups_out,
		);
	}
	return $out;
}

/**
 * @param mixed $raw Raw option.
 * @return array<string, mixed>
 */
function tolstenko_sanitize_contact_data( $raw ) {
	$base = tolstenko_contact_data_defaults();
	if ( ! is_array( $raw ) ) {
		return $base;
	}
	$base['phone']    = sanitize_text_field( (string) ( $raw['phone'] ?? '' ) );
	$base['email']    = sanitize_email( (string) ( $raw['email'] ?? '' ) );
	if ( $base['email'] === '' && ! empty( $raw['email'] ) ) {
		// sanitize_email может обнулить нестандартный ввод — сохраняем как текст.
		$base['email'] = sanitize_text_field( (string) $raw['email'] );
	}
	$base['whatsapp']         = esc_url_raw( trim( (string) ( $raw['whatsapp'] ?? '' ) ) );
	$base['telegram']         = esc_url_raw( trim( (string) ( $raw['telegram'] ?? '' ) ) );
	$base['footer_name']      = sanitize_text_field( (string) ( $raw['footer_name'] ?? '' ) );
	$base['footer_inn']       = sanitize_text_field( (string) ( $raw['footer_inn'] ?? '' ) );
	$base['footer_ogrn']      = sanitize_text_field( (string) ( $raw['footer_ogrn'] ?? '' ) );
	$base['footer_address']      = sanitize_textarea_field( (string) ( $raw['footer_address'] ?? '' ) );
	$base['footer_bottom_logo']  = isset( $raw['footer_bottom_logo'] ) ? (int) $raw['footer_bottom_logo'] : 0;
	if ( $base['footer_bottom_logo'] < 0 ) {
		$base['footer_bottom_logo'] = 0;
	}
	$base['footer_copyright']    = sanitize_text_field( (string) ( $raw['footer_copyright'] ?? '' ) );
	$base['footer_links']     = tolstenko_sanitize_contact_footer_links( $raw['footer_links'] ?? array() );
	$base['socials']          = tolstenko_sanitize_contact_social_rows( $raw['socials'] ?? array() );
	$base['socials_rgb']      = tolstenko_sanitize_contact_social_rows( $raw['socials_rgb'] ?? array() );

	// Иконки (ID вложения или URL) и ссылки VK / MAX.
	foreach ( array( 'phone_ico', 'email_ico', 'whatsapp_ico', 'telegram_ico', 'vk_ico', 'max_ico' ) as $key ) {
		$base[ $key ] = tolstenko_sanitize_contact_icon( $raw[ $key ] ?? '' );
	}
	$base['vk_link']  = esc_url_raw( trim( (string) ( $raw['vk_link'] ?? '' ) ) );
	$base['max_link'] = esc_url_raw( trim( (string) ( $raw['max_link'] ?? '' ) ) );

	// Логотипы (ID вложений).
	foreach ( array( 'logo_header', 'logo_short', 'logo_footer', 'footer_audit_img' ) as $key ) {
		$base[ $key ] = max( 0, (int) ( $raw[ $key ] ?? 0 ) );
	}

	// Модальное окно (в заголовках допустим <span> для акцента).
	$base['modal_title']        = tolstenko_kses_html( (string) ( $raw['modal_title'] ?? '' ) );
	$base['modal_text']         = sanitize_textarea_field( (string) ( $raw['modal_text'] ?? '' ) );
	$base['modal_thanks_title'] = tolstenko_kses_html( (string) ( $raw['modal_thanks_title'] ?? '' ) );
	$base['modal_thanks_text']  = sanitize_textarea_field( (string) ( $raw['modal_thanks_text'] ?? '' ) );
	$base['modal_btn']          = sanitize_text_field( (string) ( $raw['modal_btn'] ?? '' ) );

	// Шапка.
	$base['header_address']      = sanitize_text_field( (string) ( $raw['header_address'] ?? '' ) );
	$base['header_hours']        = sanitize_text_field( (string) ( $raw['header_hours'] ?? '' ) );
	$base['header_phones_title'] = sanitize_text_field( (string) ( $raw['header_phones_title'] ?? '' ) );
	$base['header_phones']       = tolstenko_sanitize_contact_header_phones( $raw['header_phones'] ?? array() );
	$base['header_services_btn'] = sanitize_text_field( (string) ( $raw['header_services_btn'] ?? '' ) );
	$base['header_btn_text']     = sanitize_text_field( (string) ( $raw['header_btn_text'] ?? '' ) );
	$base['header_btn_url']      = esc_url_raw( trim( (string) ( $raw['header_btn_url'] ?? '' ) ) );

	// Панель услуг в шапке: на этой странице её полей нет — сохраняем как есть.
	$base['header_services_menu']        = tolstenko_sanitize_contact_services_menu( $raw['header_services_menu'] ?? array() );
	$base['header_services_right_title'] = sanitize_text_field( (string) ( $raw['header_services_right_title'] ?? '' ) );
	$base['header_services_right_text']  = sanitize_textarea_field( (string) ( $raw['header_services_right_text'] ?? '' ) );
	$right_link = is_array( $raw['header_services_right_link'] ?? null ) ? $raw['header_services_right_link'] : array();
	$base['header_services_right_link']  = array(
		'url'    => esc_url_raw( trim( (string) ( $right_link['url'] ?? '' ) ) ),
		'title'  => sanitize_text_field( (string) ( $right_link['title'] ?? '' ) ),
		'target' => sanitize_text_field( (string) ( $right_link['target'] ?? '' ) ),
	);

	return $base;
}

/**
 * Контактные данные сайта.
 *
 * @param bool $only_enabled Фильтровать выключенные элементы списков.
 * @return array{
 *   phone: string,
 *   phone_href: string,
 *   email: string,
 *   socials: array<int, array{icon: string, link: string, text: string, enabled?: int}>,
 *   socials_rgb: array<int, array{icon: string, link: string, text: string, enabled?: int}>
 * }
 */
function tolstenko_get_contact_data( $only_enabled = true ) {
	static $cache = array();
	$lang = function_exists( 'theme_settings_lang' ) ? theme_settings_lang() : '';
	if ( isset( $cache[ $lang ] ) && $only_enabled ) {
		return $cache[ $lang ];
	}

	// Основной язык + отличия перевода (inc/settings-i18n.php).
	$saved = function_exists( 'theme_settings_get_saved' )
		? theme_settings_get_saved( TOLSTENKO_CONTACT_DATA_OPTION, $lang )
		: get_option( TOLSTENKO_CONTACT_DATA_OPTION, array() );
	$data  = tolstenko_sanitize_contact_data( $saved );

	$digits = preg_replace( '/\D/', '', $data['phone'] );
	$phone_href = '';
	if ( is_string( $digits ) && strlen( $digits ) >= 10 ) {
		if ( $digits[0] === '8' ) {
			$phone_href = '+7' . substr( $digits, 1 );
		} elseif ( $digits[0] !== '7' ) {
			$phone_href = '+7' . $digits;
		} else {
			$phone_href = '+' . $digits;
		}
	} else {
		$phone_href = is_string( $digits ) ? $digits : '';
	}
	$data['phone_href'] = $phone_href;

	if ( $only_enabled ) {
		foreach ( array( 'socials', 'socials_rgb' ) as $key ) {
			$filtered = array();
			foreach ( $data[ $key ] as $row ) {
				if ( empty( $row['enabled'] ) ) {
					continue;
				}
				$filtered[] = array(
					'icon' => (string) ( $row['icon'] ?? '' ),
					'link' => (string) ( $row['link'] ?? '' ),
					'text' => (string) ( $row['text'] ?? '' ),
				);
			}
			$data[ $key ] = $filtered;
		}
		$cache[ $lang ] = $data;
	}

	return $data;
}

/**
 * URL иконки из ID вложения или готового URL.
 *
 * @param string $icon_raw ID или URL.
 * @param string $size     Image size.
 * @return string
 */
function tolstenko_contact_resolve_icon_url( $icon_raw, $size = 'full' ) {
	$icon_raw = trim( (string) $icon_raw );
	if ( $icon_raw === '' ) {
		return '';
	}
	if ( ctype_digit( $icon_raw ) ) {
		$url = wp_get_attachment_image_url( (int) $icon_raw, $size );
		return $url ? (string) $url : '';
	}
	return $icon_raw;
}

/**
 * Локальный путь к SVG для inline-вывода.
 *
 * @param string $icon_raw ID, URL темы или uploads.
 * @return string
 */
function tolstenko_contact_resolve_svg_path( $icon_raw ) {
	$icon_raw = trim( (string) $icon_raw );
	if ( $icon_raw === '' ) {
		return '';
	}

	$path = '';

	if ( ctype_digit( $icon_raw ) ) {
		$attached = get_attached_file( (int) $icon_raw );
		$path     = is_string( $attached ) ? $attached : '';
	} else {
		$theme_uri = get_template_directory_uri();
		$theme_dir = get_template_directory();
		if ( strpos( $icon_raw, $theme_uri ) === 0 ) {
			$path = $theme_dir . substr( $icon_raw, strlen( $theme_uri ) );
		} else {
			$attachment_id = function_exists( 'attachment_url_to_postid' )
				? (int) attachment_url_to_postid( $icon_raw )
				: 0;
			if ( $attachment_id > 0 ) {
				$attached = get_attached_file( $attachment_id );
				$path     = is_string( $attached ) ? $attached : '';
			} else {
				$uploads = wp_get_upload_dir();
				if ( ! empty( $uploads['baseurl'] ) && ! empty( $uploads['basedir'] ) && strpos( $icon_raw, (string) $uploads['baseurl'] ) === 0 ) {
					$path = (string) $uploads['basedir'] . substr( $icon_raw, strlen( (string) $uploads['baseurl'] ) );
				}
			}
		}
	}

	$path = wp_normalize_path( $path );
	if ( $path === '' || ! is_readable( $path ) ) {
		return '';
	}
	if ( ! preg_match( '/\.svg$/i', $path ) ) {
		return '';
	}

	return $path;
}

/**
 * Inline SVG markup for contact/header icons (empty if not SVG).
 *
 * @param string $icon_raw ID или URL.
 * @return string
 */
function tolstenko_contact_get_inline_svg( $icon_raw ) {
	$path = tolstenko_contact_resolve_svg_path( $icon_raw );
	if ( $path === '' ) {
		return '';
	}
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local SVG only.
	$svg = file_get_contents( $path );
	return is_string( $svg ) ? $svg : '';
}

function tolstenko_contact_get_image_attrs( $image ) {
	$empty = array(
		'url'    => '',
		'srcset' => '',
		'sizes'  => '',
		'alt'    => '',
	);
	$id  = 0;
	$url = '';
	$alt = '';
	if ( is_array( $image ) ) {
		$id  = (int) ( $image['ID'] ?? $image['id'] ?? 0 );
		$url = (string) ( $image['url'] ?? '' );
		$alt = (string) ( $image['alt'] ?? '' );
	} else {
		$value = trim( (string) $image );
		if ( $value !== '' && ctype_digit( $value ) ) {
			$id = (int) $value;
		} else {
			$url = $value;
		}
	}
	$srcset = '';
	if ( $id > 0 ) {
		$attachment_url = wp_get_attachment_image_url( $id, 'full' );
		$url            = $attachment_url ? (string) $attachment_url : $url;
		$srcset         = wp_get_attachment_image_srcset( $id, 'full' );
		if ( $alt === '' ) {
			$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
		}
	}
	if ( $url === '' ) {
		return $empty;
	}
	return array(
		'url'    => esc_url( $url ),
		'srcset' => $srcset ? esc_attr( $srcset ) : '',
		'sizes'  => ( $srcset && defined( 'SIZES' ) ) ? esc_attr( SIZES ) : '',
		'alt'    => esc_attr( $alt !== '' ? $alt : 'Image' ),
	);
}

add_action( 'admin_menu', 'tolstenko_register_contact_data_admin_page', 11 );
add_action( 'admin_enqueue_scripts', 'tolstenko_contact_data_admin_assets' );
add_action( 'admin_post_tolstenko_save_contact_data', 'tolstenko_handle_save_contact_data' );

function tolstenko_register_contact_data_admin_page() {
	add_submenu_page(
		'tolstenko-site-settings',
		__( 'Контактные данные', 'tolstenko-theme' ),
		__( 'Контактные данные', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-contact-data',
		'tolstenko_render_contact_data_admin_page'
	);
}

/**
 * @param string $hook Hook.
 */
function tolstenko_contact_data_admin_assets( $hook ) {
	unset( $hook );
	$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $page !== 'tolstenko-contact-data' ) {
		return;
	}
	wp_enqueue_media();
}

function tolstenko_handle_save_contact_data() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Недостаточно прав.', 'tolstenko-theme' ) );
	}
	check_admin_referer( 'tolstenko_contact_data_save', 'tolstenko_contact_data_nonce' );

	$raw = isset( $_POST['tolstenko_contact_data'] ) && is_array( $_POST['tolstenko_contact_data'] )
		? wp_unslash( $_POST['tolstenko_contact_data'] )
		: array();

	$lang = function_exists( 'theme_settings_admin_lang' ) ? theme_settings_admin_lang() : '';
	$is_translation = function_exists( 'theme_settings_is_translation' ) && theme_settings_is_translation( $lang );

	// Поля панели услуг на этой форме не редактируются — берём сохранённые значения.
	$saved = $is_translation ? theme_settings_get_saved( TOLSTENKO_CONTACT_DATA_OPTION, $lang ) : get_option( TOLSTENKO_CONTACT_DATA_OPTION, array() );
	if ( is_array( $saved ) ) {
		foreach ( array( 'header_services_menu', 'header_services_right_title', 'header_services_right_text', 'header_services_right_link' ) as $key ) {
			if ( ! isset( $raw[ $key ] ) && isset( $saved[ $key ] ) ) {
				$raw[ $key ] = $saved[ $key ];
			}
		}
	}

	if ( $is_translation ) {
		// Перевод: только отличия от основного языка, без общих полей.
		theme_settings_save_translation( TOLSTENKO_CONTACT_DATA_OPTION, $lang, tolstenko_sanitize_contact_data( $raw ), tolstenko_contact_data_shared_keys() );
	} else {
		update_option( TOLSTENKO_CONTACT_DATA_OPTION, tolstenko_sanitize_contact_data( $raw ), false );
	}

	$redirect_args = array(
		'page'    => 'tolstenko-contact-data',
		'updated' => '1',
	);
	if ( $lang !== '' ) {
		$redirect_args['settings_lang'] = $lang;
	}

	wp_safe_redirect( add_query_arg( $redirect_args, admin_url( 'admin.php' ) ) );
	exit;
}

/**
 * @param string $group  socials|socials_rgb.
 * @param string $index  Row index.
 * @param string $icon   Icon.
 * @param string $link   Link.
 * @param string $text   Text.
 * @param bool   $enabled Enabled.
 */
function tolstenko_render_contact_social_row( $group, $index, $icon, $link, $text, $enabled = true ) {
	$name    = 'tolstenko_contact_data[' . $group . '][' . $index . ']';
	$preview = tolstenko_contact_resolve_icon_url( $icon, 'thumbnail' );
	$row_class = 'tolstenko-cd-row' . ( $enabled ? '' : ' is-disabled' );
	$icon_value_label = $icon !== ''
		? ( ctype_digit( $icon ) ? 'ID: ' . $icon : __( 'URL задан', 'tolstenko-theme' ) )
		: __( 'Не выбрана', 'tolstenko-theme' );
	?>
	<div class="<?php echo esc_attr( $row_class ); ?>">
		<div class="field tolstenko-cd-field-enabled">
			<label class="tolstenko-cd-enabled">
				<input type="hidden" name="<?php echo esc_attr( $name . '[enabled]' ); ?>" value="0">
				<input type="checkbox" data-cd-enabled name="<?php echo esc_attr( $name . '[enabled]' ); ?>" value="1" <?php checked( $enabled, true ); ?>>
				<?php esc_html_e( 'Показать', 'tolstenko-theme' ); ?>
			</label>
		</div>
		<div class="field tolstenko-cd-field-link">
			<label><?php esc_html_e( 'Ссылка', 'tolstenko-theme' ); ?></label>
			<input type="url" name="<?php echo esc_attr( $name . '[link]' ); ?>" value="<?php echo esc_attr( $link ); ?>" placeholder="https://...">
		</div>
		<div class="field tolstenko-cd-field-text">
			<label><?php esc_html_e( 'Текст', 'tolstenko-theme' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $name . '[text]' ); ?>" value="<?php echo esc_attr( $text ); ?>" placeholder="<?php echo esc_attr__( 'Например Telegram', 'tolstenko-theme' ); ?>">
		</div>
		<div class="field tolstenko-cd-field-actions field-actions">
			<label>&nbsp;</label>
			<div class="tolstenko-cd-row-btns">
				<button type="button" class="button button-small" data-cd-up>↑</button>
				<button type="button" class="button button-small" data-cd-down>↓</button>
				<button type="button" class="button button-small" data-cd-remove><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
			</div>
		</div>
		<div class="field tolstenko-cd-field-icon">
			<label><?php esc_html_e( 'Иконка', 'tolstenko-theme' ); ?></label>
			<div class="tolstenko-cd-icon-controls">
				<img class="tolstenko-cd-icon-preview" data-cd-icon-preview src="<?php echo esc_url( $preview ); ?>" alt="">
				<input type="hidden" data-cd-icon-input name="<?php echo esc_attr( $name . '[icon]' ); ?>" value="<?php echo esc_attr( $icon ); ?>">
				<span class="tolstenko-cd-icon-value" data-cd-icon-value><?php echo esc_html( $icon_value_label ); ?></span>
				<button type="button" class="button button-small" data-cd-pick-icon><?php esc_html_e( 'Выбрать', 'tolstenko-theme' ); ?></button>
				<button type="button" class="button button-small" data-cd-set-url><?php esc_html_e( 'Вставить URL', 'tolstenko-theme' ); ?></button>
				<button type="button" class="button button-small" data-cd-clear-icon><?php esc_html_e( 'Очистить', 'tolstenko-theme' ); ?></button>
			</div>
		</div>
	</div>
	<?php
}

/**
 * @param string                                                                 $group socials|socials_rgb.
 * @param string                                                                 $title Title.
 * @param string                                                                 $hint  Hint.
 * @param array<int, array{icon?: string, link?: string, text?: string, enabled?: int}> $rows Rows.
 */
function tolstenko_render_contact_social_group( $group, $title, $hint, $rows ) {
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}
	?>
	<div class="tolstenko-cd-group" data-cd-group>
		<h2 class="tolstenko-cd-group-title"><?php echo esc_html( $title ); ?></h2>
		<?php if ( $hint !== '' ) : ?>
			<p class="description"><?php echo esc_html( $hint ); ?></p>
		<?php endif; ?>
		<div class="tolstenko-cd-list" data-cd-list>
			<?php
			foreach ( $rows as $i => $row ) {
				$icon    = isset( $row['icon'] ) ? (string) $row['icon'] : '';
				$link    = isset( $row['link'] ) ? (string) $row['link'] : '';
				$text    = isset( $row['text'] ) ? (string) $row['text'] : '';
				$enabled = ! isset( $row['enabled'] ) || ! empty( $row['enabled'] );
				tolstenko_render_contact_social_row( $group, (string) $i, $icon, $link, $text, $enabled );
			}
			?>
		</div>
		<p class="tolstenko-cd-empty"><?php esc_html_e( 'Пока нет элементов.', 'tolstenko-theme' ); ?></p>
		<p class="tolstenko-cd-actions">
			<button type="button" class="button" data-cd-add><?php esc_html_e( 'Добавить элемент', 'tolstenko-theme' ); ?></button>
		</p>
		<template>
			<?php tolstenko_render_contact_social_row( $group, '__INDEX__', '', '', '', true ); ?>
		</template>
	</div>
	<?php
}

/**
 * Поле иконки: ID вложения или URL (кнопки «Выбрать / Вставить URL / Очистить» — общий JS страницы).
 *
 * @param string $key   Ключ в tolstenko_contact_data.
 * @param string $label Подпись.
 * @param string $value Текущее значение.
 */
function tolstenko_render_contact_icon_field( $key, $label, $value ) {
	$value   = (string) $value;
	$preview = tolstenko_contact_resolve_icon_url( $value, 'thumbnail' );
	$state   = $value !== ''
		? ( ctype_digit( $value ) ? 'ID: ' . $value : __( 'URL задан', 'tolstenko-theme' ) )
		: __( 'Не выбрана', 'tolstenko-theme' );
	?>
	<div class="row tolstenko-cd-row tolstenko-cd-row--single">
		<label><?php echo esc_html( $label ); ?></label>
		<div class="tolstenko-cd-icon-controls">
			<img class="tolstenko-cd-icon-preview" data-cd-icon-preview src="<?php echo esc_url( $preview ); ?>" alt="">
			<input type="hidden" data-cd-icon-input name="<?php echo esc_attr( 'tolstenko_contact_data[' . $key . ']' ); ?>" value="<?php echo esc_attr( $value ); ?>">
			<span class="tolstenko-cd-icon-value" data-cd-icon-value><?php echo esc_html( $state ); ?></span>
			<button type="button" class="button button-small" data-cd-pick-icon><?php esc_html_e( 'Выбрать', 'tolstenko-theme' ); ?></button>
			<button type="button" class="button button-small" data-cd-set-url><?php esc_html_e( 'Вставить URL', 'tolstenko-theme' ); ?></button>
			<button type="button" class="button button-small" data-cd-clear-icon><?php esc_html_e( 'Очистить', 'tolstenko-theme' ); ?></button>
		</div>
	</div>
	<?php
}

/**
 * Поле изображения (ID вложения).
 *
 * @param string $key   Ключ в tolstenko_contact_data.
 * @param string $label Подпись.
 * @param int    $id    ID вложения.
 */
function tolstenko_render_contact_image_field( $key, $label, $id ) {
	$id  = (int) $id;
	$url = $id ? (string) wp_get_attachment_image_url( $id, 'medium' ) : '';
	?>
	<div class="row">
		<label><?php echo esc_html( $label ); ?></label>
		<div class="tolstenko-cd-image" data-cd-image>
			<input type="hidden" name="<?php echo esc_attr( 'tolstenko_contact_data[' . $key . ']' ); ?>" value="<?php echo (int) $id; ?>" data-cd-image-id>
			<div class="tolstenko-cd-image__preview" data-cd-image-preview>
				<?php if ( $url !== '' ) : ?>
					<img src="<?php echo esc_url( $url ); ?>" alt="" style="max-width:220px;height:auto;display:block;margin:6px 0;">
				<?php endif; ?>
			</div>
			<p>
				<button type="button" class="button" data-cd-image-pick><?php esc_html_e( 'Выбрать', 'tolstenko-theme' ); ?></button>
				<button type="button" class="button-link-delete" data-cd-image-clear <?php echo $id ? '' : 'style="display:none"'; ?>><?php esc_html_e( 'Убрать', 'tolstenko-theme' ); ?></button>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Строка повторителя «Телефоны в шапке».
 *
 * @param string $index Индекс строки.
 * @param array  $row   phone / label / flag.
 */
function tolstenko_render_contact_header_phone_row( $index, $row ) {
	$name    = 'tolstenko_contact_data[header_phones][' . $index . ']';
	$flag    = (int) ( $row['flag'] ?? 0 );
	$preview = $flag ? (string) wp_get_attachment_image_url( $flag, 'thumbnail' ) : '';
	?>
	<div class="tolstenko-cd-row tolstenko-cd-row--phone">
		<div class="field tolstenko-cd-field-link">
			<label><?php esc_html_e( 'Номер', 'tolstenko-theme' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $name . '[phone]' ); ?>" value="<?php echo esc_attr( (string) ( $row['phone'] ?? '' ) ); ?>" placeholder="+971 (55) 43 52 459">
		</div>
		<div class="field tolstenko-cd-field-text">
			<label><?php esc_html_e( 'Подпись (страна)', 'tolstenko-theme' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $name . '[label]' ); ?>" value="<?php echo esc_attr( (string) ( $row['label'] ?? '' ) ); ?>" placeholder="ОАЭ">
		</div>
		<div class="field tolstenko-cd-field-actions field-actions">
			<label>&nbsp;</label>
			<div class="tolstenko-cd-row-btns">
				<button type="button" class="button button-small" data-cd-up>↑</button>
				<button type="button" class="button button-small" data-cd-down>↓</button>
				<button type="button" class="button button-small" data-cd-remove><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
			</div>
		</div>
		<div class="field tolstenko-cd-field-icon">
			<label><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></label>
			<div class="tolstenko-cd-icon-controls">
				<img class="tolstenko-cd-icon-preview" data-cd-icon-preview src="<?php echo esc_url( $preview ); ?>" alt="">
				<input type="hidden" data-cd-icon-input name="<?php echo esc_attr( $name . '[flag]' ); ?>" value="<?php echo $flag ? (int) $flag : ''; ?>">
				<span class="tolstenko-cd-icon-value" data-cd-icon-value><?php echo $flag ? esc_html( 'ID: ' . $flag ) : esc_html__( 'Не выбран', 'tolstenko-theme' ); ?></span>
				<button type="button" class="button button-small" data-cd-pick-icon><?php esc_html_e( 'Выбрать', 'tolstenko-theme' ); ?></button>
				<button type="button" class="button button-small" data-cd-clear-icon><?php esc_html_e( 'Очистить', 'tolstenko-theme' ); ?></button>
			</div>
		</div>
	</div>
	<?php
}

function tolstenko_render_contact_data_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings_lang = function_exists( 'theme_settings_admin_lang' ) ? theme_settings_admin_lang() : '';
	$saved = get_option( TOLSTENKO_CONTACT_DATA_OPTION, null );
	if ( is_array( $saved ) && function_exists( 'theme_settings_is_translation' ) && theme_settings_is_translation( $settings_lang ) ) {
		// Перевод: основной язык + уже переведённое.
		$saved = theme_settings_get_saved( TOLSTENKO_CONTACT_DATA_OPTION, $settings_lang );
	}
	$data  = is_array( $saved )
		? tolstenko_sanitize_contact_data( $saved )
		: tolstenko_contact_data_defaults();

	// Первичный заход: подставить телефон/почту из шапки для удобства.
	if ( ! is_array( $saved ) && function_exists( 'tolstenko_get_site_header_footer_data' ) ) {
		$hf = tolstenko_get_site_header_footer_data();
		if ( $data['phone'] === '' && ! empty( $hf['phone'] ) ) {
			$data['phone'] = (string) $hf['phone'];
		}
		if ( $data['email'] === '' && ! empty( $hf['email'] ) ) {
			$data['email'] = (string) $hf['email'];
		}
		if ( empty( $data['socials'] ) && ! empty( $hf['socials_header_1'] ) && is_array( $hf['socials_header_1'] ) ) {
			$data['socials'] = tolstenko_sanitize_contact_social_rows( $hf['socials_header_1'] );
		}
		if ( empty( $data['socials_rgb'] ) && ! empty( $hf['socials_footer_2'] ) && is_array( $hf['socials_footer_2'] ) ) {
			$data['socials_rgb'] = tolstenko_sanitize_contact_social_rows( $hf['socials_footer_2'] );
		}
	}

	$updated = isset( $_GET['updated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<div class="wrap tolstenko-cd">
		<h1><?php esc_html_e( 'Контактные данные', 'tolstenko-theme' ); ?></h1>
		<?php
		if ( function_exists( 'theme_settings_render_lang_tabs' ) ) {
			theme_settings_render_lang_tabs( admin_url( 'admin.php?page=tolstenko-contact-data' ), array( __( 'телефоны, почта, ссылки, иконки, логотипы, соцсети', 'tolstenko-theme' ) ) );
		}
		?>
		<?php if ( $updated ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Сохранено.', 'tolstenko-theme' ); ?></p></div>
		<?php endif; ?>
		<p class="description">
			<?php esc_html_e( 'Телефоны, почта, ссылки, тексты шапки, футера и модального окна. Меню шапки — Внешний вид → Меню → «Управление областями».', 'tolstenko-theme' ); ?>
		</p>

		<style>
			.tolstenko-cd .tolstenko-cd-card{max-width:920px;background:#fff;border:1px solid #dcdcde;padding:16px 18px;margin:16px 0;border-radius:4px}
			.tolstenko-cd .row{margin:12px 0}
			.tolstenko-cd .row label{display:block;font-weight:600;margin:0 0 6px}
			.tolstenko-cd .row input[type="text"],
			.tolstenko-cd .row input[type="email"],
			.tolstenko-cd .row input[type="url"],
			.tolstenko-cd .row input[type="tel"],
			.tolstenko-cd .row textarea{width:100%;max-width:640px}
			.tolstenko-cd .row textarea{min-height:72px}
			.tolstenko-cd .tolstenko-cd-links{display:flex;flex-direction:column;gap:10px;max-width:640px}
			.tolstenko-cd .tolstenko-cd-link-row{display:grid;grid-template-columns:1fr 1.4fr;gap:10px}
			.tolstenko-cd-group{border:1px solid #dcdcde;background:#fff;padding:14px;margin:18px 0;border-radius:4px;max-width:920px}
			.tolstenko-cd-group-title{margin:0 0 8px;font-size:15px}
			.tolstenko-cd-list{display:flex;flex-direction:column;gap:8px}
			.tolstenko-cd-row{border:1px solid #e2e4e7;background:#f9f9f9;padding:10px 12px;display:grid;grid-template-columns:92px minmax(0,1fr) minmax(0,1fr) auto;grid-template-areas:"enabled link text actions" "icon icon icon icon";gap:10px 12px;align-items:end}
			.tolstenko-cd-row.is-disabled{opacity:.55}
			.tolstenko-cd-field-enabled{grid-area:enabled;align-self:center}
			.tolstenko-cd-field-icon{grid-area:icon}
			.tolstenko-cd-field-link{grid-area:link}
			.tolstenko-cd-field-text{grid-area:text}
			.tolstenko-cd-field-actions{grid-area:actions}
			.tolstenko-cd-enabled{display:flex;align-items:center;gap:6px;margin:0;white-space:nowrap;font-size:12px;color:#50575e;font-weight:400;cursor:pointer}
			.tolstenko-cd-enabled input{margin:0}
			.tolstenko-cd-icon-controls{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
			.tolstenko-cd-icon-preview{width:28px;height:28px;flex:0 0 28px;border:1px solid #dcdcde;background:#fff;object-fit:contain}
			.tolstenko-cd-icon-value{flex:0 1 auto;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:12px;color:#666}
			.tolstenko-cd-row .field{margin:0;min-width:0}
			.tolstenko-cd-row .field>label{display:block;font-size:12px;color:#50575e;margin:0 0 4px;font-weight:600}
			.tolstenko-cd-row .field input[type="url"],
			.tolstenko-cd-row .field input[type="text"]{width:100%;max-width:100%;box-sizing:border-box}
			.tolstenko-cd-row-btns{display:flex;flex-wrap:wrap;gap:6px}
			.tolstenko-cd-actions{display:flex;gap:8px;align-items:center}
			.tolstenko-cd-empty{color:#777;font-style:italic}
			.tolstenko-cd .submit{margin-top:8px}
			.tolstenko-cd-row--single{display:block;border:0;background:none;padding:0}
			.tolstenko-cd-row--phone{grid-template-columns:minmax(0,1fr) minmax(0,1fr) auto;grid-template-areas:"link text actions" "icon icon icon"}
			@media (max-width:960px){
				.tolstenko-cd-row{grid-template-columns:1fr auto;grid-template-areas:"enabled actions" "link link" "text text" "icon icon"}
			}
		</style>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="tolstenko-cd-form">
			<input type="hidden" name="action" value="tolstenko_save_contact_data">
			<?php if ( $settings_lang !== '' ) : ?>
				<input type="hidden" name="settings_lang" value="<?php echo esc_attr( $settings_lang ); ?>">
			<?php endif; ?>
			<?php wp_nonce_field( 'tolstenko_contact_data_save', 'tolstenko_contact_data_nonce' ); ?>

			<div class="tolstenko-cd-card">
				<h2 style="margin-top:0;"><?php esc_html_e( 'Контакты', 'tolstenko-theme' ); ?></h2>
				<div class="row">
					<label for="tolstenko-cd-phone"><?php esc_html_e( 'Телефон', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-phone" name="tolstenko_contact_data[phone]" value="<?php echo esc_attr( $data['phone'] ); ?>" placeholder="8 (800) 500-71-48">
				</div>
				<div class="row">
					<label for="tolstenko-cd-email"><?php esc_html_e( 'Почта', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-email" name="tolstenko_contact_data[email]" value="<?php echo esc_attr( $data['email'] ); ?>" placeholder="sale@example.ru">
				</div>
				<div class="row">
					<label for="tolstenko-cd-telegram"><?php esc_html_e( 'Telegram (кнопка «Написать ТГ» в футере)', 'tolstenko-theme' ); ?></label>
					<input type="url" id="tolstenko-cd-telegram" name="tolstenko_contact_data[telegram]" value="<?php echo esc_attr( $data['telegram'] ); ?>" placeholder="https://t.me/...">
				</div>
				<div class="row">
					<label for="tolstenko-cd-whatsapp"><?php esc_html_e( 'WhatsApp (для блоков на сайте)', 'tolstenko-theme' ); ?></label>
					<input type="url" id="tolstenko-cd-whatsapp" name="tolstenko_contact_data[whatsapp]" value="<?php echo esc_attr( $data['whatsapp'] ); ?>" placeholder="https://wa.me/79...">
				</div>
			</div>

			<div class="tolstenko-cd-card">
				<h2 style="margin-top:0;"><?php esc_html_e( 'Футер — левая колонка', 'tolstenko-theme' ); ?></h2>
				<div class="row">
					<label for="tolstenko-cd-footer-name"><?php esc_html_e( 'Название компании', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-footer-name" name="tolstenko_contact_data[footer_name]" value="<?php echo esc_attr( $data['footer_name'] ); ?>" placeholder='ООО "Компания"'>
				</div>
				<div class="row">
					<label for="tolstenko-cd-footer-inn"><?php esc_html_e( 'ИНН', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-footer-inn" name="tolstenko_contact_data[footer_inn]" value="<?php echo esc_attr( $data['footer_inn'] ); ?>" placeholder="ИНН 0000000000">
				</div>
				<div class="row">
					<label for="tolstenko-cd-footer-ogrn"><?php esc_html_e( 'ОГРН', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-footer-ogrn" name="tolstenko_contact_data[footer_ogrn]" value="<?php echo esc_attr( $data['footer_ogrn'] ); ?>" placeholder="ОГРН 0000000000000">
				</div>
				<div class="row">
					<label for="tolstenko-cd-footer-address"><?php esc_html_e( 'Адрес', 'tolstenko-theme' ); ?></label>
					<textarea id="tolstenko-cd-footer-address" name="tolstenko_contact_data[footer_address]" rows="3"><?php echo esc_textarea( $data['footer_address'] ); ?></textarea>
				</div>
				<?php
				$bottom_logo_id  = (int) ( $data['footer_bottom_logo'] ?? 0 );
				$bottom_logo_url = $bottom_logo_id ? (string) wp_get_attachment_image_url( $bottom_logo_id, 'medium' ) : '';
				?>
				<div class="row">
					<label><?php esc_html_e( 'Нижний логотип (под адресом)', 'tolstenko-theme' ); ?></label>
					<div class="tolstenko-cd-image" data-cd-image>
						<input type="hidden" name="tolstenko_contact_data[footer_bottom_logo]" value="<?php echo (int) $bottom_logo_id; ?>" data-cd-image-id>
						<div class="tolstenko-cd-image__preview" data-cd-image-preview>
							<?php if ( $bottom_logo_url !== '' ) : ?>
								<img src="<?php echo esc_url( $bottom_logo_url ); ?>" alt="" style="max-width:220px;height:auto;display:block;margin:6px 0;">
							<?php endif; ?>
						</div>
						<p>
							<button type="button" class="button" data-cd-image-pick><?php esc_html_e( 'Выбрать', 'tolstenko-theme' ); ?></button>
							<button type="button" class="button-link-delete" data-cd-image-clear <?php echo $bottom_logo_id ? '' : 'style="display:none"'; ?>><?php esc_html_e( 'Убрать', 'tolstenko-theme' ); ?></button>
						</p>
					</div>
				</div>
			</div>

			<div class="tolstenko-cd-card">
				<h2 style="margin-top:0;"><?php esc_html_e( 'Футер — нижняя полоса', 'tolstenko-theme' ); ?></h2>
				<div class="row">
					<label for="tolstenko-cd-footer-copyright"><?php esc_html_e( 'Копирайт', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-footer-copyright" name="tolstenko_contact_data[footer_copyright]" value="<?php echo esc_attr( $data['footer_copyright'] ); ?>" placeholder="© 2026 Компания">
				</div>
				<div class="row">
					<label><?php esc_html_e( 'Ссылки (до 3)', 'tolstenko-theme' ); ?></label>
					<div class="tolstenko-cd-links">
						<?php
						$links = is_array( $data['footer_links'] ) ? $data['footer_links'] : array();
						for ( $i = 0; $i < 3; $i++ ) :
							$link = isset( $links[ $i ] ) && is_array( $links[ $i ] ) ? $links[ $i ] : array( 'title' => '', 'url' => '' );
							?>
							<div class="tolstenko-cd-link-row">
								<input type="text" name="tolstenko_contact_data[footer_links][<?php echo (int) $i; ?>][title]" value="<?php echo esc_attr( (string) ( $link['title'] ?? '' ) ); ?>" placeholder="<?php echo esc_attr( sprintf( __( 'Название ссылки %d', 'tolstenko-theme' ), $i + 1 ) ); ?>">
								<input type="url" name="tolstenko_contact_data[footer_links][<?php echo (int) $i; ?>][url]" value="<?php echo esc_attr( (string) ( $link['url'] ?? '' ) ); ?>" placeholder="https://">
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>

			<div class="tolstenko-cd-card">
				<h2 style="margin-top:0;"><?php esc_html_e( 'Шапка', 'tolstenko-theme' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Меню верхней строки и меню в плашке — Внешний вид → Меню → «Управление областями» (свои для каждого языка). Иконки соцсетей — из блока «Социальные сети» ниже, Telegram-кнопка — из поля Telegram выше.', 'tolstenko-theme' ); ?></p>
				<div class="row">
					<label for="tolstenko-cd-header-address"><?php esc_html_e( 'Адрес', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-header-address" name="tolstenko_contact_data[header_address]" value="<?php echo esc_attr( $data['header_address'] ); ?>" placeholder="502, Al Hawai Tower, DIFC, Dubai">
				</div>
				<div class="row">
					<label for="tolstenko-cd-header-hours"><?php esc_html_e( 'Часы работы', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-header-hours" name="tolstenko_contact_data[header_hours]" value="<?php echo esc_attr( $data['header_hours'] ); ?>" placeholder="Пн–Сб, 08:00–19:00">
				</div>
				<div class="row">
					<label for="tolstenko-cd-header-services-btn"><?php esc_html_e( 'Кнопка панели услуг', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-header-services-btn" name="tolstenko_contact_data[header_services_btn]" value="<?php echo esc_attr( $data['header_services_btn'] ); ?>" placeholder="Все услуги">
				</div>
				<div class="row">
					<label for="tolstenko-cd-header-btn-text"><?php esc_html_e( 'Кнопка справа: текст и ссылка (пусто = #modal)', 'tolstenko-theme' ); ?></label>
					<div class="tolstenko-cd-link-row">
						<input type="text" id="tolstenko-cd-header-btn-text" name="tolstenko_contact_data[header_btn_text]" value="<?php echo esc_attr( $data['header_btn_text'] ); ?>" placeholder="Оставить заявку">
						<input type="text" name="tolstenko_contact_data[header_btn_url]" value="<?php echo esc_attr( $data['header_btn_url'] ); ?>" placeholder="#modal">
					</div>
				</div>
			</div>

			<div class="tolstenko-cd-group" data-cd-group>
				<h2 class="tolstenko-cd-group-title"><?php esc_html_e( 'Телефоны в шапке', 'tolstenko-theme' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Первый номер показывается в шапке, по клику открывается весь список. Пусто — выводится основной телефон из «Контактов».', 'tolstenko-theme' ); ?></p>
				<div class="row">
					<label for="tolstenko-cd-header-phones-title"><?php esc_html_e( 'Заголовок списка', 'tolstenko-theme' ); ?></label>
					<input type="text" id="tolstenko-cd-header-phones-title" name="tolstenko_contact_data[header_phones_title]" value="<?php echo esc_attr( $data['header_phones_title'] ); ?>" placeholder="Нажмите для вызова">
				</div>
				<div class="tolstenko-cd-list" data-cd-list>
					<?php foreach ( (array) $data['header_phones'] as $i => $phone_row ) : ?>
						<?php tolstenko_render_contact_header_phone_row( (string) $i, is_array( $phone_row ) ? $phone_row : array() ); ?>
					<?php endforeach; ?>
				</div>
				<p class="tolstenko-cd-empty"><?php esc_html_e( 'Пока нет элементов.', 'tolstenko-theme' ); ?></p>
				<p class="tolstenko-cd-actions">
					<button type="button" class="button" data-cd-add><?php esc_html_e( 'Добавить телефон', 'tolstenko-theme' ); ?></button>
				</p>
				<template>
					<?php tolstenko_render_contact_header_phone_row( '__INDEX__', array() ); ?>
				</template>
			</div>

			<?php
			tolstenko_render_contact_social_group(
				'socials',
				__( 'Социальные сети', 'tolstenko-theme' ),
				__( 'Монохромные / SVG. Шапка (иконки), футер («Соц.сети»), кнопка рядом с телефоном в футере берёт первые 2.', 'tolstenko-theme' ),
				$data['socials']
			);
			tolstenko_render_contact_social_group(
				'socials_rgb',
				__( 'Социальные сети (цветные)', 'tolstenko-theme' ),
				__( 'Цветные иконки для сайдбаров. Модуль: modules/socials/socials-rgb.php', 'tolstenko-theme' ),
				$data['socials_rgb']
			);
			?>

	<div class="tolstenko-cd-card">
		<h2 style="margin-top:0;"><?php esc_html_e( 'Ссылки и иконки (шапка, футер, кнопки)', 'tolstenko-theme' ); ?></h2>
		<p class="description"><?php esc_html_e( 'Иконки — SVG из медиатеки или URL. Ссылки используются в шапке, футере и блоках консультаций.', 'tolstenko-theme' ); ?></p>
		<?php
		tolstenko_render_contact_icon_field( 'phone_ico', __( 'Иконка телефона (SVG)', 'tolstenko-theme' ), $data['phone_ico'] );
		tolstenko_render_contact_icon_field( 'email_ico', __( 'Иконка почты (SVG)', 'tolstenko-theme' ), $data['email_ico'] );
		tolstenko_render_contact_icon_field( 'telegram_ico', __( 'Иконка Telegram (SVG)', 'tolstenko-theme' ), $data['telegram_ico'] );
		tolstenko_render_contact_icon_field( 'whatsapp_ico', __( 'Иконка WhatsApp (SVG)', 'tolstenko-theme' ), $data['whatsapp_ico'] );
		tolstenko_render_contact_icon_field( 'max_ico', __( 'Иконка MAX (SVG)', 'tolstenko-theme' ), $data['max_ico'] );
		tolstenko_render_contact_icon_field( 'vk_ico', __( 'Иконка VK (SVG)', 'tolstenko-theme' ), $data['vk_ico'] );
		?>
		<div class="row">
			<label for="tolstenko-cd-vk-link"><?php esc_html_e( 'VK (ссылка)', 'tolstenko-theme' ); ?></label>
			<input type="url" id="tolstenko-cd-vk-link" name="tolstenko_contact_data[vk_link]" value="<?php echo esc_attr( $data['vk_link'] ); ?>" placeholder="https://vk.com/...">
		</div>
		<div class="row">
			<label for="tolstenko-cd-max-link"><?php esc_html_e( 'MAX (ссылка)', 'tolstenko-theme' ); ?></label>
			<input type="url" id="tolstenko-cd-max-link" name="tolstenko_contact_data[max_link]" value="<?php echo esc_attr( $data['max_link'] ); ?>" placeholder="https://...">
		</div>
	</div>

	<div class="tolstenko-cd-card">
		<h2 style="margin-top:0;"><?php esc_html_e( 'Логотипы', 'tolstenko-theme' ); ?></h2>
		<?php
		tolstenko_render_contact_image_field( 'logo_header', __( 'Логотип в шапке (полный)', 'tolstenko-theme' ), $data['logo_header'] );
		tolstenko_render_contact_image_field( 'logo_short', __( 'Логотип в шапке (короткий, мобильный)', 'tolstenko-theme' ), $data['logo_short'] );
		tolstenko_render_contact_image_field( 'logo_footer', __( 'Логотип в футере', 'tolstenko-theme' ), $data['logo_footer'] );
		tolstenko_render_contact_image_field( 'footer_audit_img', __( 'Картинка «Бесплатный аудит» в футере', 'tolstenko-theme' ), $data['footer_audit_img'] );
		?>
	</div>

	<div class="tolstenko-cd-card">
		<h2 style="margin-top:0;"><?php esc_html_e( 'Модальное окно', 'tolstenko-theme' ); ?></h2>
		<div class="row">
			<label for="tolstenko-cd-modal-title"><?php esc_html_e( 'Заголовок', 'tolstenko-theme' ); ?></label>
			<input type="text" id="tolstenko-cd-modal-title" name="tolstenko_contact_data[modal_title]" value="<?php echo esc_attr( $data['modal_title'] ); ?>">
		</div>
		<div class="row">
			<label for="tolstenko-cd-modal-text"><?php esc_html_e( 'Текст под заголовком', 'tolstenko-theme' ); ?></label>
			<textarea id="tolstenko-cd-modal-text" name="tolstenko_contact_data[modal_text]" rows="2"><?php echo esc_textarea( $data['modal_text'] ); ?></textarea>
		</div>
		<div class="row">
			<label for="tolstenko-cd-modal-thanks-title"><?php esc_html_e( 'Заголовок «спасибо»', 'tolstenko-theme' ); ?></label>
			<input type="text" id="tolstenko-cd-modal-thanks-title" name="tolstenko_contact_data[modal_thanks_title]" value="<?php echo esc_attr( $data['modal_thanks_title'] ); ?>">
		</div>
		<div class="row">
			<label for="tolstenko-cd-modal-thanks-text"><?php esc_html_e( 'Текст «спасибо»', 'tolstenko-theme' ); ?></label>
			<textarea id="tolstenko-cd-modal-thanks-text" name="tolstenko_contact_data[modal_thanks_text]" rows="2"><?php echo esc_textarea( $data['modal_thanks_text'] ); ?></textarea>
		</div>
		<div class="row">
			<label for="tolstenko-cd-modal-btn"><?php esc_html_e( 'Кнопка «На главную»', 'tolstenko-theme' ); ?></label>
			<input type="text" id="tolstenko-cd-modal-btn" name="tolstenko_contact_data[modal_btn]" value="<?php echo esc_attr( $data['modal_btn'] ); ?>" placeholder="На главную">
		</div>
	</div>


			<p class="submit">
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Сохранить', 'tolstenko-theme' ); ?></button>
			</p>
		</form>
	</div>
	<script>
	(function(){
		function updateEmpty(list){
			var empty = list.parentElement.querySelector('.tolstenko-cd-empty');
			if (!empty) return;
			empty.style.display = list.children.length ? 'none' : '';
		}
		function init(){
			var wrap = document.querySelector('.tolstenko-cd');
			if (!wrap || wrap.dataset.init === '1') return;
			wrap.dataset.init = '1';
			wrap.querySelectorAll('[data-cd-list]').forEach(updateEmpty);
			wrap.addEventListener('click', function(e){
				var addBtn = e.target.closest('[data-cd-add]');
				if (addBtn) {
					var group = addBtn.closest('[data-cd-group]');
					if (!group) return;
					var list = group.querySelector('[data-cd-list]');
					var tpl = group.querySelector('template');
					if (!list || !tpl) return;
					var idx = Date.now().toString() + Math.floor(Math.random() * 1000).toString();
					list.insertAdjacentHTML('beforeend', tpl.innerHTML.replace(/__INDEX__/g, idx));
					updateEmpty(list);
					return;
				}
				var enabledToggle = e.target.closest('[data-cd-enabled]');
				if (enabledToggle) {
					var erow = enabledToggle.closest('.tolstenko-cd-row');
					if (erow) erow.classList.toggle('is-disabled', !enabledToggle.checked);
					return;
				}
				var removeBtn = e.target.closest('[data-cd-remove]');
				if (removeBtn) {
					var row = removeBtn.closest('.tolstenko-cd-row');
					var list = removeBtn.closest('[data-cd-group]') && removeBtn.closest('[data-cd-group]').querySelector('[data-cd-list]');
					if (row) row.remove();
					if (list) updateEmpty(list);
					return;
				}
				var up = e.target.closest('[data-cd-up]');
				if (up) {
					var urow = up.closest('.tolstenko-cd-row');
					if (urow && urow.previousElementSibling) {
						urow.parentNode.insertBefore(urow, urow.previousElementSibling);
					}
					return;
				}
				var down = e.target.closest('[data-cd-down]');
				if (down) {
					var drow = down.closest('.tolstenko-cd-row');
					if (drow && drow.nextElementSibling) {
						drow.parentNode.insertBefore(drow.nextElementSibling, drow);
					}
					return;
				}
				var pickImg = e.target.closest('[data-cd-image-pick]');
				if (pickImg) {
					var iwrap = pickImg.closest('[data-cd-image]');
					if (!iwrap || !window.wp || !wp.media) return;
					var iid = iwrap.querySelector('[data-cd-image-id]');
					var iprev = iwrap.querySelector('[data-cd-image-preview]');
					var iclear = iwrap.querySelector('[data-cd-image-clear]');
					var iframe = wp.media({ title: 'Нижний логотип футера', multiple: false, library: { type: 'image' } });
					iframe.on('select', function(){
						var att = iframe.state().get('selection').first().toJSON();
						if (!att) return;
						if (iid) iid.value = String(att.id || 0);
						if (iprev) {
							var src = (att.sizes && att.sizes.medium && att.sizes.medium.url) ? att.sizes.medium.url : att.url;
							iprev.innerHTML = src ? '<img src="'+src+'" alt="" style="max-width:220px;height:auto;display:block;margin:6px 0;">' : '';
						}
						if (iclear) iclear.style.display = '';
					});
					iframe.open();
					return;
				}
				var clearImg = e.target.closest('[data-cd-image-clear]');
				if (clearImg) {
					var cwrap = clearImg.closest('[data-cd-image]');
					if (!cwrap) return;
					var cid = cwrap.querySelector('[data-cd-image-id]');
					var cprev = cwrap.querySelector('[data-cd-image-preview]');
					if (cid) cid.value = '0';
					if (cprev) cprev.innerHTML = '';
					clearImg.style.display = 'none';
					return;
				}
				var pick = e.target.closest('[data-cd-pick-icon]');
				if (pick) {
					var prow = pick.closest('.tolstenko-cd-row');
					if (!prow || !window.wp || !wp.media) return;
					var input = prow.querySelector('[data-cd-icon-input]');
					var preview = prow.querySelector('[data-cd-icon-preview]');
					var valueText = prow.querySelector('[data-cd-icon-value]');
					var frame = wp.media({ title: 'Выбор иконки', multiple: false, library: { type: 'image' } });
					frame.on('select', function(){
						var att = frame.state().get('selection').first().toJSON();
						if (!att) return;
						if (input) input.value = String(att.id || '');
						if (preview && att.url) preview.src = att.url;
						if (valueText) valueText.textContent = input && input.value ? ('ID: ' + input.value) : 'Не выбрана';
					});
					frame.open();
					return;
				}
				var fromUrl = e.target.closest('[data-cd-set-url]');
				if (fromUrl) {
					var frow = fromUrl.closest('.tolstenko-cd-row');
					if (!frow) return;
					var finput = frow.querySelector('[data-cd-icon-input]');
					var fpreview = frow.querySelector('[data-cd-icon-preview]');
					var fvalue = frow.querySelector('[data-cd-icon-value]');
					var currentVal = finput && finput.value ? finput.value : '';
					var url = window.prompt('Вставьте URL изображения', currentVal);
					if (url === null) return;
					var clean = String(url).trim();
					if (finput) finput.value = clean;
					if (fpreview) fpreview.src = clean;
					if (fvalue) fvalue.textContent = clean ? 'URL задан' : 'Не выбрана';
					return;
				}
				var clear = e.target.closest('[data-cd-clear-icon]');
				if (clear) {
					var crow = clear.closest('.tolstenko-cd-row');
					if (!crow) return;
					var cinput = crow.querySelector('[data-cd-icon-input]');
					var cpreview = crow.querySelector('[data-cd-icon-preview]');
					var cvalue = crow.querySelector('[data-cd-icon-value]');
					if (cinput) cinput.value = '';
					if (cpreview) cpreview.src = '';
					if (cvalue) cvalue.textContent = 'Не выбрана';
				}
			});
		}
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', init);
		} else {
			init();
		}
	})();
	</script>
	<?php
	if ( function_exists( 'theme_settings_render_shared_fields_script' ) ) {
		// Номер в строках «Телефонов в шапке» не блокируем: без него строка не сохранится
		// (подпись переводится), а сам номер всё равно берётся из основного языка.
		$shared_keys = array_diff( tolstenko_contact_data_shared_keys(), array( 'phone' ) );
		theme_settings_render_shared_fields_script( '.tolstenko-cd-form', array_merge( $shared_keys, array( 'link', 'icon', 'enabled' ) ), array( 'tolstenko_contact_data[phone]' ) );
	}
}
