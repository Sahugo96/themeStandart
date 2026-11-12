<?php
/**
 * Переводы страниц настроек («Дефолты блоков», «Контактные данные») через Polylang.
 *
 * Как устроено:
 * 1. Основной язык хранится в прежней опции (tolstenko_block_defaults / tolstenko_contact_data),
 *    остальные — в копиях с суффиксом языка: tolstenko_block_defaults_en и т.п.
 * 2. Перевод сохраняется целиком (theme_settings_save_translation): после сохранения вкладки
 *    языка его значения не меняются от правок основного языка. Из основного языка берётся
 *    только пустое / отсутствующее (theme_settings_overlay) и всё — пока язык ни разу не сохраняли.
 *    Старые переводы «только отличия» (theme_settings_diff/merge) читаются до следующего сохранения.
 * 3. На странице настроек — вкладки языков (параметр settings_lang).
 * 4. Поля-выборы записей (post_id, ids…) общие: хранятся только в основном языке, на чтении
 *    заменяются переводом записи (pll_get_post), если он есть.
 *
 * Без Polylang всё работает как раньше: один язык, без вкладок.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Метка опции перевода «сохранён целиком» (theme_settings_save_translation / theme_settings_get_saved).
const THEME_SETTINGS_FULL_MARK = '__theme_full';

/**
 * Языки сайта (slug), основной язык настроек — первым. Пусто, если Polylang не активен.
 *
 * @return string[]
 */
function theme_settings_languages() {
	if ( ! function_exists( 'pll_languages_list' ) ) {
		return array();
	}
	$list    = array_values( array_filter( (array) pll_languages_list( array( 'fields' => 'slug' ) ) ) );
	$default = theme_settings_default_lang();
	if ( $default !== '' && in_array( $default, $list, true ) ) {
		$list = array_merge( array( $default ), array_values( array_diff( $list, array( $default ) ) ) );
	}
	return $list;
}

/**
 * Основной язык настроек (slug) или '' без Polylang: на нём хранятся общие опции
 * (tolstenko_block_defaults, tolstenko_contact_data), остальные языки — копии с суффиксом.
 *
 * Не зависит от «языка по умолчанию» Polylang: смена его в настройках Polylang не должна
 * менять местами сохранённые переводы. Запоминается в опции theme_settings_main_lang;
 * при первом вызове определяется как язык, у которого нет копий настроек (иначе ru).
 *
 * @return string
 */
function theme_settings_default_lang() {
	static $main = null;

	if ( ! function_exists( 'pll_languages_list' ) ) {
		return '';
	}
	if ( $main !== null ) {
		return $main;
	}

	$languages = array_values( array_filter( (array) pll_languages_list( array( 'fields' => 'slug' ) ) ) );
	if ( ! $languages ) {
		return '';
	}

	$stored = (string) get_option( 'theme_settings_main_lang', '' );
	if ( $stored !== '' && in_array( $stored, $languages, true ) ) {
		return $main = $stored;
	}

	// Язык без копий «…_<язык>» — тот, что хранится в общих опциях.
	$without_copies = array_values(
		array_filter(
			$languages,
			static function ( $lang ) {
				return get_option( 'tolstenko_block_defaults_' . $lang, null ) === null
					&& get_option( 'tolstenko_contact_data_' . $lang, null ) === null;
			}
		)
	);

	if ( count( $without_copies ) === 1 ) {
		$main = $without_copies[0];
	} elseif ( in_array( 'ru', $languages, true ) ) {
		$main = 'ru';
	} else {
		$main = function_exists( 'pll_default_language' ) ? (string) pll_default_language( 'slug' ) : $languages[0];
	}

	update_option( 'theme_settings_main_lang', $main, true );

	return $main;
}

/**
 * Подписи языков для вкладок.
 *
 * @return array<string, string> slug => название.
 */
function theme_settings_language_names() {
	$names = array();
	if ( function_exists( 'pll_languages_list' ) ) {
		$slugs  = (array) pll_languages_list( array( 'fields' => 'slug' ) );
		$titles = (array) pll_languages_list( array( 'fields' => 'name' ) );
		foreach ( $slugs as $i => $slug ) {
			$names[ $slug ] = (string) ( $titles[ $i ] ?? strtoupper( $slug ) );
		}
	}
	return $names;
}

/**
 * Явно заданный язык чтения настроек (редактор блоков, страница настроек).
 *
 * @param string|null $lang Slug или null — сбросить.
 */
function theme_settings_set_lang( $lang ) {
	$GLOBALS['theme_settings_lang_override'] = $lang === null ? null : (string) $lang;
}

/**
 * Язык, на котором сейчас читаются настройки.
 *
 * @return string Slug или '' без Polylang.
 */
function theme_settings_lang() {
	$languages = theme_settings_languages();
	if ( empty( $languages ) ) {
		return '';
	}
	$override = $GLOBALS['theme_settings_lang_override'] ?? null;
	if ( is_string( $override ) && in_array( $override, $languages, true ) ) {
		return $override;
	}
	$current = function_exists( 'pll_current_language' ) ? (string) pll_current_language( 'slug' ) : '';
	return in_array( $current, $languages, true ) ? $current : theme_settings_default_lang();
}

/**
 * Язык, выбранный вкладкой на странице настроек (settings_lang в запросе).
 *
 * @return string
 */
function theme_settings_admin_lang() {
	$languages = theme_settings_languages();
	if ( empty( $languages ) ) {
		return '';
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- только выбор вкладки.
	$requested = isset( $_REQUEST['settings_lang'] ) ? sanitize_key( wp_unslash( $_REQUEST['settings_lang'] ) ) : '';
	return in_array( $requested, $languages, true ) ? $requested : theme_settings_default_lang();
}

/**
 * Не основной ли это язык (тогда настройки читаются как «основной + отличия»).
 *
 * @param string $lang Slug.
 * @return bool
 */
function theme_settings_is_translation( $lang ) {
	return $lang !== '' && $lang !== theme_settings_default_lang();
}

/**
 * Имя опции для языка: основной язык — без суффикса.
 *
 * @param string $base Базовое имя опции.
 * @param string $lang Slug.
 * @return string
 */
function theme_settings_option_name( $base, $lang ) {
	return theme_settings_is_translation( $lang ) ? $base . '_' . $lang : $base;
}

/**
 * Список (repeater) или ассоциативный массив. Пустой массив считается списком.
 *
 * @param mixed $value Значение.
 * @return bool
 */
function theme_settings_is_list( $value ) {
	return is_array( $value ) && ( $value === array() || array_keys( $value ) === range( 0, count( $value ) - 1 ) );
}

/**
 * Отличия перевода от основного языка: совпадающие значения → null (не хранятся).
 *
 * @param mixed $base  Значение основного языка.
 * @param mixed $value Значение перевода.
 * @return mixed|null null — «как в основном языке».
 */
function theme_settings_diff( $base, $value ) {
	if ( $value === $base ) {
		return null;
	}
	if ( is_array( $value ) && theme_settings_is_list( $value ) ) {
		if ( is_array( $base ) && $value == $base ) { // phpcs:ignore Universal.Operators.StrictComparisons -- сравнение структур.
			return null;
		}
		$base = is_array( $base ) && theme_settings_is_list( $base ) ? $base : array();
		$out  = array();
		foreach ( $value as $i => $item ) {
			$base_item = $base[ $i ] ?? null;
			if ( is_array( $item ) && ! theme_settings_is_list( $item ) && is_array( $base_item ) ) {
				$item_diff = theme_settings_diff( $base_item, $item );
				$out[]     = $item_diff === null ? array() : $item_diff;
			} else {
				$out[] = $item === $base_item ? null : $item;
			}
		}
		return $out;
	}
	if ( is_array( $value ) ) {
		$base = is_array( $base ) ? $base : array();
		$out  = array();
		foreach ( $value as $key => $item ) {
			$item_diff = theme_settings_diff( $base[ $key ] ?? null, $item );
			if ( $item_diff !== null ) {
				$out[ $key ] = $item_diff;
			}
		}
		return $out === array() ? null : $out;
	}
	return $value;
}

/**
 * Перевод поверх основного языка: null и пустые строки берутся из основного.
 *
 * @param mixed $base Значение основного языка.
 * @param mixed $diff Отличия (theme_settings_diff).
 * @return mixed
 */
function theme_settings_merge( $base, $diff ) {
	if ( $diff === null ) {
		return $base;
	}
	if ( $diff === '' && is_string( $base ) ) {
		return $base;
	}
	if ( is_array( $diff ) && theme_settings_is_list( $diff ) && ( $diff !== array() || theme_settings_is_list( $base ) ) ) {
		// Число пунктов повторителя следует основному языку: новые пункты основного языка
		// появляются и в переводе, пока их не переведут.
		$base  = is_array( $base ) && theme_settings_is_list( $base ) ? $base : array();
		$out   = array();
		$count = max( count( $base ), count( $diff ) );
		for ( $i = 0; $i < $count; $i++ ) {
			$out[] = theme_settings_merge( $base[ $i ] ?? null, $diff[ $i ] ?? null );
		}
		return $out;
	}
	if ( is_array( $diff ) ) {
		$out = is_array( $base ) ? $base : array();
		foreach ( $diff as $key => $item ) {
			$out[ $key ] = theme_settings_merge( $out[ $key ] ?? null, $item );
		}
		return $out;
	}
	return $diff;
}

/**
 * Убрать из массива общие для всех языков ключи (на любой глубине).
 *
 * @param mixed    $data Данные.
 * @param string[] $keys Ключи.
 * @return mixed
 */
function theme_settings_strip_keys( $data, $keys ) {
	if ( ! is_array( $data ) ) {
		return $data;
	}
	foreach ( $data as $key => $value ) {
		if ( is_string( $key ) && in_array( $key, $keys, true ) ) {
			unset( $data[ $key ] );
			continue;
		}
		$data[ $key ] = theme_settings_strip_keys( $value, $keys );
	}
	return $data;
}

/**
 * Ключи-выборы записей в «Дефолтах блоков»: общие для языков, переводятся через pll_get_post.
 *
 * @return string[]
 */
function theme_settings_post_id_keys() {
	return array( 'post_id', 'teammate_id', 'single_post_id', 'ids', 'post_ids' );
}

/**
 * Заменить ID записей на их переводы для языка (если перевод есть).
 *
 * @param mixed  $data Данные.
 * @param string $lang Slug.
 * @return mixed
 */
function theme_settings_translate_post_ids( $data, $lang ) {
	if ( ! is_array( $data ) || ! function_exists( 'pll_get_post' ) || ! theme_settings_is_translation( $lang ) ) {
		return $data;
	}
	$map = static function ( $id ) use ( $lang ) {
		$id = (int) $id;
		if ( $id <= 0 ) {
			return $id;
		}
		$translated = (int) pll_get_post( $id, $lang );
		return $translated > 0 ? $translated : $id;
	};
	foreach ( $data as $key => $value ) {
		if ( is_string( $key ) && in_array( $key, theme_settings_post_id_keys(), true ) ) {
			$data[ $key ] = is_array( $value ) ? array_map( $map, $value ) : ( is_numeric( $value ) ? $map( $value ) : $value );
			continue;
		}
		$data[ $key ] = theme_settings_translate_post_ids( $value, $lang );
	}
	return $data;
}

/**
 * Сохранённые настройки для языка: основной язык + отличия перевода.
 *
 * @param string $base_option Имя опции основного языка.
 * @param string $lang        Slug ('' — основной).
 * @return array
 */
function theme_settings_get_saved( $base_option, $lang ) {
	$saved = get_option( $base_option, array() );
	$saved = is_array( $saved ) ? $saved : array();
	if ( ! theme_settings_is_translation( $lang ) ) {
		return $saved;
	}
	$stored = get_option( theme_settings_option_name( $base_option, $lang ), array() );
	if ( ! is_array( $stored ) || ! $stored ) {
		// Язык ещё не сохраняли — показываем основной.
		return $saved;
	}
	// Новый формат: перевод сохранён целиком, основной язык — только для пустого / отсутствующего.
	if ( ! empty( $stored[ THEME_SETTINGS_FULL_MARK ] ) ) {
		unset( $stored[ THEME_SETTINGS_FULL_MARK ] );
		return (array) theme_settings_overlay( $saved, $stored );
	}
	// Старый формат (только отличия) — читается как раньше до следующего сохранения вкладки.
	return (array) theme_settings_merge( $saved, $stored );
}

/**
 * Перевод, сохранённый целиком, поверх основного языка.
 * Из основного языка берётся только то, чего в переводе нет или что пусто
 * (пустая строка, пустой список); повторители перевода — свой состав пунктов.
 *
 * @param mixed $base Значение основного языка.
 * @param mixed $full Значение перевода.
 * @return mixed
 */
function theme_settings_overlay( $base, $full ) {
	if ( $full === null ) {
		return $base;
	}
	if ( $full === '' && is_string( $base ) ) {
		return $base;
	}
	if ( is_array( $full ) && theme_settings_is_list( $full ) ) {
		if ( $full === array() ) {
			return $base !== null ? $base : $full;
		}
		$base = is_array( $base ) && theme_settings_is_list( $base ) ? $base : array();
		$out  = array();
		foreach ( $full as $i => $item ) {
			// Пункт перевода дополняется общими полями (выборы записей) пункта основного языка.
			$out[] = is_array( $item ) && ! theme_settings_is_list( $item ) ? theme_settings_overlay( $base[ $i ] ?? null, $item ) : $item;
		}
		return $out;
	}
	if ( is_array( $full ) ) {
		$out = is_array( $base ) && ! theme_settings_is_list( $base ) ? $base : array();
		foreach ( $full as $key => $item ) {
			$out[ $key ] = theme_settings_overlay( $out[ $key ] ?? null, $item );
		}
		return $out;
	}
	return $full;
}

/**
 * Сохранить перевод: только отличия от основного языка, без общих ключей.
 *
 * @param string   $base_option Имя опции основного языка.
 * @param string   $lang        Slug перевода.
 * @param array    $data        Полные (санитизированные) данные из формы.
 * @param string[] $shared_keys Общие для языков ключи.
 */
function theme_settings_save_translation( $base_option, $lang, $data, $shared_keys ) {
	// Перевод хранится целиком (кроме общих для языков ключей): после сохранения вкладки языка
	// его значения больше не зависят от правок основного языка.
	$full = theme_settings_strip_keys( is_array( $data ) ? $data : array(), $shared_keys );
	$full[ THEME_SETTINGS_FULL_MARK ] = 1;
	update_option( theme_settings_option_name( $base_option, $lang ), $full, false );
}

/**
 * Вкладки языков над формой настроек + пояснение для перевода.
 *
 * @param string   $page_url      URL страницы настроек.
 * @param string[] $shared_labels Подписи общих полей для пояснения.
 */
function theme_settings_render_lang_tabs( $page_url, $shared_labels = array() ) {
	$languages = theme_settings_languages();
	if ( count( $languages ) < 2 ) {
		return;
	}
	$current = theme_settings_admin_lang();
	$names   = theme_settings_language_names();
	?>
	<style>
		.theme-settings-langs{display:flex;gap:6px;margin:16px 0 8px}
		.theme-settings-langs a{padding:6px 14px;border:1px solid #c3c4c7;border-radius:4px;background:#fff;text-decoration:none;color:#2c3338}
		.theme-settings-langs a.is-active{background:#2271b1;border-color:#2271b1;color:#fff}
		.theme-settings-shared{opacity:.55}
		.theme-settings-shared input,.theme-settings-shared select,.theme-settings-shared textarea,.theme-settings-shared button{pointer-events:none}
	</style>
	<nav class="theme-settings-langs" aria-label="<?php esc_attr_e( 'Язык настроек', 'tolstenko-theme' ); ?>">
		<?php foreach ( $languages as $slug ) : ?>
			<a class="<?php echo $slug === $current ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'settings_lang', $slug, $page_url ) ); ?>"><?php echo esc_html( $names[ $slug ] ?? strtoupper( $slug ) ); ?></a>
		<?php endforeach; ?>
	</nav>
	<?php if ( theme_settings_is_translation( $current ) ) : ?>
		<div class="notice notice-info inline"><p>
			<?php
			echo esc_html(
				sprintf(
					/* translators: %s: основной язык. */
					__( 'Перевод. После сохранения значения этого языка не зависят от языка «%s»; пустые поля берутся из него. Пока язык ни разу не сохраняли, показываются значения «%1$s».', 'tolstenko-theme' ),
					$names[ theme_settings_default_lang() ] ?? theme_settings_default_lang()
				)
			);
			if ( $shared_labels ) {
				echo ' ' . esc_html( sprintf( __( 'Общие для всех языков (меняются на основном языке): %s.', 'tolstenko-theme' ), implode( ', ', $shared_labels ) ) );
			}
			?>
		</p></div>
	<?php endif; ?>
	<?php
}

/**
 * Скрипт для перевода: блокирует общие поля формы (их значения не сохраняются в переводе).
 *
 * @param string   $form_selector Селектор формы.
 * @param string[] $keys          Общие ключи (последний сегмент name="…[key]" или "…[key][]").
 * @param string[] $exact_names   Поля, заблокированные только по полному name.
 */
function theme_settings_render_shared_fields_script( $form_selector, $keys, $exact_names = array() ) {
	if ( ! theme_settings_is_translation( theme_settings_admin_lang() ) || ( ! $keys && ! $exact_names ) ) {
		return;
	}
	?>
	<script>
	(function(){
		var form = document.querySelector(<?php echo wp_json_encode( $form_selector ); ?>);
		if (!form) return;
		var keys = <?php echo wp_json_encode( array_values( $keys ) ); ?>;
		var exact = <?php echo wp_json_encode( array_values( $exact_names ) ); ?>;
		var re = keys.length ? new RegExp('\\[(' + keys.join('|') + ')\\](\\[\\d*\\])?$') : null;
		form.querySelectorAll('[name]').forEach(function(field){
			var name = field.getAttribute('name');
			if (exact.indexOf(name) === -1 && !(re && re.test(name))) return;
			field.disabled = true;
			var box = field.closest('.row, .cols, .tolstenko-cd-row, tr') || field.parentElement;
			if (box) {
				box.classList.add('theme-settings-shared');
				box.title = <?php echo wp_json_encode( __( 'Общее для всех языков — меняется на основном языке', 'tolstenko-theme' ) ); ?>;
			}
		});
	})();
	</script>
	<?php
}
