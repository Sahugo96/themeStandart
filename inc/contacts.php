<?php
/**
 * Страница контактов: секции «Контакты» (contacts), «Карты» (contacts-maps),
 * «Реквизиты» (contacts-details). Перенесено из tolstenko.marketing (page-contacts.php,
 * template-parts/blocks/contacts-*.php) без ACF: дефолты — табы «Дефолтов блоков»,
 * переопределение на странице — атрибуты блоков.
 *
 * Здесь общие для таба и шаблонов функции: нормализация данных (сохранение таба и вывод
 * используют одни и те же), строки повторителей таба и проверка iframe карты.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ID картинки: число (таб) или {id,url,alt} (блок).
 *
 * @param mixed $value Value.
 */
function theme_contacts_image_id( $value ): int {
	if ( is_array( $value ) ) {
		return (int) ( $value['id'] ?? $value['image'] ?? 0 );
	}
	return (int) $value;
}

/**
 * Ссылки пункта контактов: [{text, link}].
 *
 * @param mixed $raw Raw.
 * @param bool  $clean Санитизировать (сохранение таба).
 * @return array<int,array{text:string,link:string}>
 */
function theme_contacts_normalize_links( $raw, bool $clean = false ): array {
	$out = array();
	foreach ( (array) $raw as $link ) {
		if ( ! is_array( $link ) ) {
			continue;
		}
		$text = trim( (string) ( $link['text'] ?? '' ) );
		$url  = trim( (string) ( $link['link'] ?? '' ) );
		if ( $clean ) {
			$text = sanitize_text_field( $text );
			$url  = esc_url_raw( $url, array( 'http', 'https', 'tel', 'mailto' ) );
		}
		if ( $text === '' && $url === '' ) {
			continue;
		}
		$out[] = array(
			'text' => $text,
			'link' => $url,
		);
	}
	return $out;
}

/**
 * Пункты контактов адреса: [{title, icon, links}].
 *
 * @param mixed $raw Raw.
 * @param bool  $clean Санитизировать.
 * @return array<int,array>
 */
function theme_contacts_normalize_items( $raw, bool $clean = false ): array {
	$out = array();
	foreach ( (array) $raw as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$title = trim( (string) ( $item['title'] ?? '' ) );
		$title = $clean ? sanitize_text_field( $title ) : $title;
		$icon  = theme_contacts_image_id( $item['icon'] ?? 0 );
		$links = theme_contacts_normalize_links( $item['links'] ?? array(), $clean );
		if ( $title === '' && ! $links && $icon <= 0 ) {
			continue;
		}
		$out[] = array(
			'title' => $title,
			'icon'  => $icon,
			'links' => $links,
		);
	}
	return $out;
}

/**
 * Адреса (вкладки) секции «Контакты»: [{address, items, gallery}].
 *
 * @param mixed $raw Raw.
 * @param bool  $clean Санитизировать.
 * @return array<int,array>
 */
function theme_contacts_normalize_addresses( $raw, bool $clean = false ): array {
	$out = array();
	foreach ( (array) $raw as $addr ) {
		if ( ! is_array( $addr ) ) {
			continue;
		}
		$address = trim( (string) ( $addr['address'] ?? '' ) );
		$address = $clean ? sanitize_text_field( $address ) : $address;
		$gallery = array();
		foreach ( (array) ( $addr['gallery'] ?? array() ) as $g ) {
			$id = theme_contacts_image_id( is_array( $g ) && array_key_exists( 'image', $g ) ? $g['image'] : $g );
			if ( $id > 0 ) {
				$gallery[] = $clean ? array( 'image' => $id ) : $id;
			}
		}
		$items = theme_contacts_normalize_items( $addr['items'] ?? array(), $clean );
		if ( $address === '' && ! $gallery && ! $items ) {
			continue;
		}
		$out[] = array(
			'address' => $address,
			'items'   => $items,
			'gallery' => $gallery,
		);
	}
	return $out;
}

/**
 * Пункты реквизитов: HTML-тексты.
 *
 * @param mixed $raw Raw.
 * @param bool  $clean Санитизировать.
 * @return array<int,array{text:string}>
 */
function theme_contacts_normalize_details( $raw, bool $clean = false ): array {
	$out = array();
	foreach ( (array) $raw as $item ) {
		$text = is_array( $item ) ? (string) ( $item['text'] ?? '' ) : (string) $item;
		$text = $clean ? tolstenko_kses_redactor( $text ) : $text;
		if ( trim( wp_strip_all_tags( $text ) ) === '' ) {
			continue;
		}
		$out[] = array( 'text' => $text );
	}
	return $out;
}

/**
 * Карта: iframe только с Яндекс/Google/OpenStreetMap; голый URL такой карты → iframe.
 * Всё остальное отбрасывается ('').
 *
 * @param string $value iframe-код или ссылка на карту.
 */
function theme_contacts_map_embed( $value ): string {
	$value = trim( (string) $value );
	if ( $value === '' ) {
		return '';
	}

	$src = '';
	if ( preg_match( '/<iframe\b[^>]*\bsrc\s*=\s*(["\'])([^"\']+)\1/i', $value, $m ) ) {
		$src = html_entity_decode( $m[2], ENT_QUOTES, 'UTF-8' );
	} elseif ( preg_match( '#^https?://\S+$#i', $value ) ) {
		$src = $value;
	}

	$host = strtolower( (string) wp_parse_url( $src, PHP_URL_HOST ) );
	$ok   = $host !== '' && (
		preg_match( '/(^|\.)yandex\.(ru|com|by|kz|uz|com\.tr)$/', $host )
		|| preg_match( '/(^|\.)google\.[a-z.]+$/', $host )
		|| preg_match( '/(^|\.)openstreetmap\.org$/', $host )
	);
	if ( ! $ok ) {
		return '';
	}

	return '<iframe src="' . esc_url( $src ) . '" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="' . esc_attr__( 'Карта', 'tolstenko-theme' ) . '"></iframe>';
}

/**
 * Адреса карт: [{address, map}] (map — исходный код/ссылка; на выводе — theme_contacts_map_embed()).
 *
 * @param mixed $raw Raw.
 * @param bool  $clean Санитизировать.
 * @return array<int,array{address:string,map:string}>
 */
function theme_contacts_normalize_maps( $raw, bool $clean = false ): array {
	$out = array();
	foreach ( (array) $raw as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$address = trim( (string) ( $item['address'] ?? '' ) );
		$map     = trim( (string) ( $item['map'] ?? '' ) );
		if ( $clean ) {
			$address = sanitize_text_field( $address );
			// Храним только проверенный iframe (или пусто).
			$map = theme_contacts_map_embed( $map );
		}
		if ( $address === '' && $map === '' ) {
			continue;
		}
		$out[] = array(
			'address' => $address,
			'map'     => $map,
		);
	}
	return $out;
}

/* -------------------------------------------------------------------------
 * Таб «Контакты»: строки повторителей (они же — <template> для «Добавить»).
 * ---------------------------------------------------------------------- */

/**
 * Кнопки перемещения/удаления пункта.
 */
function theme_contacts_admin_row_buttons(): void {
	?>
	<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
	<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
	<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
	<?php
}

/**
 * Ссылка пункта контактов.
 *
 * @param string $prefix Имя: …[links][i].
 * @param array  $link   Данные.
 */
function theme_contacts_admin_link_row( string $prefix, array $link ): void {
	?>
	<div class="repeater-item" data-repeater-item>
		<div class="cols">
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[text]" value="<?php echo esc_attr( $link['text'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Текст (+971 50 000 00 00)', 'tolstenko-theme' ); ?>" style="flex:1">
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[link]" value="<?php echo esc_attr( $link['link'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Ссылка (tel:…, mailto:…, https://…) — пусто: просто текст', 'tolstenko-theme' ); ?>" style="flex:1">
			<?php theme_contacts_admin_row_buttons(); ?>
		</div>
	</div>
	<?php
}

/**
 * Пункт контактов (заголовок, иконка, ссылки).
 *
 * @param string $prefix Имя: …[items][i].
 * @param array  $item   Данные.
 */
function theme_contacts_admin_item_row( string $prefix, array $item ): void {
	$icon     = theme_contacts_image_id( $item['icon'] ?? 0 );
	$icon_url = $icon ? wp_get_attachment_image_url( $icon, 'thumbnail' ) : '';
	?>
	<div class="repeater-item" data-repeater-item>
		<div class="cols">
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Заголовок (Телефон, Почта, Адрес…)', 'tolstenko-theme' ); ?>" style="flex:1">
			<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $prefix ); ?>[icon]" value="<?php echo (int) $icon; ?>">
			<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Иконка', 'tolstenko-theme' ); ?></button>
			<?php theme_contacts_admin_row_buttons(); ?>
		</div>
		<div class="icon-preview" style="margin-top:8px;"><?php if ( $icon_url ) : ?><img src="<?php echo esc_url( $icon_url ); ?>" alt=""><?php endif; ?></div>
		<div class="muted"><?php esc_html_e( 'Ссылки / строки', 'tolstenko-theme' ); ?></div>
		<div data-repeater-list="contacts-links-list" data-name-prefix="<?php echo esc_attr( $prefix ); ?>[links]">
			<?php foreach ( (array) ( $item['links'] ?? array() ) as $l_idx => $link ) : ?>
				<?php theme_contacts_admin_link_row( $prefix . '[links][' . (int) $l_idx . ']', is_array( $link ) ? $link : array() ); ?>
			<?php endforeach; ?>
		</div>
		<div class="actions"><button type="button" class="button" data-add-item="contacts-links-list"><?php esc_html_e( 'Добавить строку', 'tolstenko-theme' ); ?></button></div>
	</div>
	<?php
}

/**
 * Фото галереи адреса.
 *
 * @param string $prefix Имя: …[gallery][i].
 * @param int    $image  ID.
 */
function theme_contacts_admin_gallery_row( string $prefix, int $image ): void {
	$url = $image ? wp_get_attachment_image_url( $image, 'thumbnail' ) : '';
	?>
	<div class="repeater-item" data-repeater-item>
		<div class="cols">
			<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $prefix ); ?>[image]" value="<?php echo (int) $image; ?>">
			<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Фото', 'tolstenko-theme' ); ?></button>
			<?php theme_contacts_admin_row_buttons(); ?>
		</div>
		<div class="icon-preview" style="margin-top:8px;"><?php if ( $url ) : ?><img src="<?php echo esc_url( $url ); ?>" alt=""><?php endif; ?></div>
	</div>
	<?php
}

/**
 * Адрес (вкладка): название, пункты контактов, галерея.
 *
 * @param string $prefix Имя: tolstenko_block_defaults[contacts][addresses][i].
 * @param array  $addr   Данные.
 */
function theme_contacts_admin_address_row( string $prefix, array $addr ): void {
	?>
	<div class="repeater-item" data-repeater-item>
		<div class="cols">
			<input type="text" name="<?php echo esc_attr( $prefix ); ?>[address]" value="<?php echo esc_attr( $addr['address'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Название адреса — подпись вкладки (Дубай, Москва…)', 'tolstenko-theme' ); ?>" style="flex:1">
			<?php theme_contacts_admin_row_buttons(); ?>
		</div>

		<div class="muted"><?php esc_html_e( 'Контакты адреса', 'tolstenko-theme' ); ?></div>
		<div data-repeater-list="contacts-items-list" data-name-prefix="<?php echo esc_attr( $prefix ); ?>[items]">
			<?php foreach ( (array) ( $addr['items'] ?? array() ) as $i_idx => $item ) : ?>
				<?php theme_contacts_admin_item_row( $prefix . '[items][' . (int) $i_idx . ']', is_array( $item ) ? $item : array() ); ?>
			<?php endforeach; ?>
		</div>
		<div class="actions"><button type="button" class="button" data-add-item="contacts-items-list"><?php esc_html_e( 'Добавить контакт', 'tolstenko-theme' ); ?></button></div>

		<div class="muted"><?php esc_html_e( 'Фото офиса (галерея справа)', 'tolstenko-theme' ); ?></div>
		<div data-repeater-list="contacts-gallery-list" data-name-prefix="<?php echo esc_attr( $prefix ); ?>[gallery]">
			<?php foreach ( (array) ( $addr['gallery'] ?? array() ) as $g_idx => $g ) : ?>
				<?php theme_contacts_admin_gallery_row( $prefix . '[gallery][' . (int) $g_idx . ']', theme_contacts_image_id( is_array( $g ) ? ( $g['image'] ?? 0 ) : $g ) ); ?>
			<?php endforeach; ?>
		</div>
		<div class="actions"><button type="button" class="button" data-add-item="contacts-gallery-list"><?php esc_html_e( 'Добавить фото', 'tolstenko-theme' ); ?></button></div>
	</div>
	<?php
}

/**
 * <template> пунктов для кнопок «Добавить» (assets/js/admin/block-defaults.js:
 * data-repeater-template, __prefix__ / __i__).
 */
function theme_contacts_admin_templates(): void {
	?>
	<template data-repeater-template="contacts-addresses-list"><?php theme_contacts_admin_address_row( '__prefix__[__i__]', array() ); ?></template>
	<template data-repeater-template="contacts-items-list"><?php theme_contacts_admin_item_row( '__prefix__[__i__]', array() ); ?></template>
	<template data-repeater-template="contacts-links-list"><?php theme_contacts_admin_link_row( '__prefix__[__i__]', array() ); ?></template>
	<template data-repeater-template="contacts-gallery-list"><?php theme_contacts_admin_gallery_row( '__prefix__[__i__]', 0 ); ?></template>
	<?php
}
