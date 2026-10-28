<?php

defined('ABSPATH') || exit;

function theme_parse_html_images(string $html): array
{
  $images = [];

  if ($html === '' || !preg_match_all('/<img[^>]+src=(["\'])([^"\']+)\1/i', $html, $matches)) {
    return $images;
  }

  foreach ($matches[2] as $src) {
    $src = html_entity_decode($src, ENT_QUOTES, 'UTF-8');

    if ($src !== '') {
      $images[] = $src;
    }
  }

  return array_values(array_unique($images));
}

function theme_get_rutube_video_id(string $url): string
{
  if (preg_match('#rutube\.ru/(?:play/embed|video)/([a-zA-Z0-9_-]+)#', $url, $matches)) {
    return $matches[1];
  }

  return '';
}

function theme_get_video_embed_poster(string $embed_url): string
{
  if ($embed_url === '') {
    return '';
  }

  $request_args = [
    'timeout' => 8,
    'headers' => [
      'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
      'Accept' => 'application/json',
    ],
  ];

  $rutube_id = theme_get_rutube_video_id($embed_url);

  if ($rutube_id !== '') {
    $cache_key = 'theme_rutube_poster_' . $rutube_id;
    $cached = get_transient($cache_key);

    if (is_string($cached) && $cached !== '') {
      return $cached;
    }

    $response = wp_remote_get('https://rutube.ru/api/video/' . $rutube_id . '/', $request_args);

    if (!is_wp_error($response)) {
      $data = json_decode(wp_remote_retrieve_body($response), true);
      $poster = is_array($data) ? (string) ($data['thumbnail_url'] ?? '') : '';

      if ($poster !== '') {
        set_transient($cache_key, $poster, WEEK_IN_SECONDS);
        return $poster;
      }
    }

    $oembed_url = add_query_arg(
      'url',
      'https://rutube.ru/video/' . $rutube_id . '/',
      'https://rutube.ru/api/oembed/'
    );

    $oembed_response = wp_remote_get($oembed_url, $request_args);

    if (!is_wp_error($oembed_response)) {
      $oembed_data = json_decode(wp_remote_retrieve_body($oembed_response), true);
      $poster = is_array($oembed_data) ? (string) ($oembed_data['thumbnail_url'] ?? '') : '';

      if ($poster !== '') {
        set_transient($cache_key, $poster, WEEK_IN_SECONDS);
        return $poster;
      }
    }
  }

  if (preg_match('#(?:youtube\.com/embed/|youtu\.be/)([a-zA-Z0-9_-]+)#', $embed_url, $matches)) {
    return 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg';
  }

  return '';
}

function theme_ajax_video_poster(): void
{
  $src = isset($_GET['src']) ? esc_url_raw(wp_unslash($_GET['src'])) : '';

  wp_send_json_success([
    'poster' => theme_get_video_embed_poster($src),
  ]);
}

add_action('wp_ajax_theme_video_poster', 'theme_ajax_video_poster');
add_action('wp_ajax_nopriv_theme_video_poster', 'theme_ajax_video_poster');

// show_admin_bar(true);
// show_admin_bar(false);

add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('custom-logo');
add_theme_support( 'menus' );

// Области меню шапки. Меню назначаются в Внешний вид → Меню → «Управление областями»;
// с Polylang у каждой области своё меню на каждом языке.
add_action('after_setup_theme', function () {
    register_nav_menus([
        'header_top' => __('Шапка — верхняя строка', 'tolstenko-theme'),
        'header_bar' => __('Шапка — плашка (рядом с поиском)', 'tolstenko-theme'),
    ]);
});

/**
 * Меню области: назначенное в области (на текущем языке — через Polylang),
 * иначе — меню с прежним именем (header-menu / header-service-menu), иначе пусто.
 *
 * @param string $location    Область меню.
 * @param string $legacy_name Имя меню до появления областей.
 * @param string $menu_class  Класс списка.
 * @return string HTML меню или ''.
 */
function theme_get_nav_menu_html(string $location, string $legacy_name, string $menu_class): string
{
    $args = [
        'container'   => false,
        'menu_class'  => $menu_class,
        'fallback_cb' => false,
        'echo'        => false,
    ];

    if (has_nav_menu($location)) {
        return (string) wp_nav_menu($args + ['theme_location' => $location]);
    }

    // Без проверки wp_nav_menu() подставил бы первое попавшееся меню сайта.
    $legacy_menu = $legacy_name !== '' ? wp_get_nav_menu_object($legacy_name) : false;

    return $legacy_menu ? (string) wp_nav_menu($args + ['menu' => $legacy_menu]) : '';
}


function true_register_wp_sidebars() {
	register_sidebar(
		array(
			'id' => 'true_side',
			'name' => 'Боковая колонка', 
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
			'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
			'after_title' => '</h3>'
		)
	);
}
add_action( 'widgets_init', 'true_register_wp_sidebars' );


//Убрать p в СF7
add_filter('wpcf7_autop_or_not', '__return_false');


// Скрываем уведомления о новой версии WordPress
if ( 1 ) {

	// Общий счётчик обновлений в админ-баре
	add_action( 'admin_bar_menu', function ( $wp_adminbar ) {
		$wp_adminbar->remove_node( 'updates' );
	}, 999 );

	add_action( 'admin_menu', function () {

		// "Доступен WordPress X.X" в Консоле - Для Single установки
		remove_action( 'admin_notices', 'update_nag', 3 );

		// "Доступен WordPress X.X" в Консоле - Для Multisite установки
		remove_action( 'network_admin_notices', 'update_nag', 3 );

		// "Скачать версию X.X" в футере
		remove_action( 'update_footer', 'core_update_footer' );

		// Общий счётчик обновлений в админ-меню
		remove_submenu_page( 'index.php', 'update-core.php' );

		// Счётчик плагинов для обновления в админ-меню
		$GLOBALS['menu'][65][0] = __( 'Plugins' );

	}, 999 );

	// "Обновление до X.X" в виджете "На виду" в Консоле
	add_action( 'admin_head-index.php', function () {
		?>
		<style>
			#wp-version-message .button {
				display: none;
			}
		</style>
		<?php
	} );

}


function remove_plugin_updates($value) {
    return null;
  }
  
  add_filter('site_transient_update_plugins', 'remove_plugin_updates');