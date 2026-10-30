<?php
/**
 * Хелперы статьи (CPT blog): изображения, кураторские комментарии,
 * автор статьи, оглавление (TOC).
 *
 * Перенесено из tolstenko.marketing (inc/blog/helpers.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Атрибуты изображения из ID, ACF-массива или массива блока ({id,url,alt}).
 *
 * @param mixed  $image Attachment ID / ACF image array / block image array.
 * @param string $size  Image size.
 * @return array{id:int,url:string,srcset:string,sizes:string,alt:string}|null
 */
function tolstenko_get_image_attrs( $image, $size = 'full' ) {
	$id = 0;

	if ( is_numeric( $image ) ) {
		$id = (int) $image;
	} elseif ( is_array( $image ) ) {
		$id = (int) ( $image['ID'] ?? $image['id'] ?? 0 );
	}

	if ( ! $id ) {
		return null;
	}

	$url = wp_get_attachment_image_url( $id, $size );
	if ( ! $url ) {
		return null;
	}

	$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
	if ( $alt === '' && is_array( $image ) && ! empty( $image['alt'] ) ) {
		$alt = (string) $image['alt'];
	}

	return array(
		'id'     => $id,
		'url'    => $url,
		'srcset' => (string) ( wp_get_attachment_image_srcset( $id, $size ) ?: '' ),
		'sizes'  => (string) ( wp_get_attachment_image_sizes( $id, $size ) ?: '' ),
		'alt'    => $alt,
	);
}

/**
 * ID вложения из значения атрибута блока (int или {id,url,alt}).
 *
 * @param mixed $value Attribute value.
 * @return int
 */
function tolstenko_block_image_id( $value ) {
	if ( is_numeric( $value ) ) {
		return (int) $value;
	}
	if ( is_array( $value ) ) {
		return (int) ( $value['id'] ?? $value['ID'] ?? 0 );
	}
	return 0;
}

/**
 * Количество кураторских комментариев (корни + ответы двух уровней).
 *
 * @param int $post_id Post ID.
 * @return int
 */
function tolstenko_get_curated_blog_comments_count( $post_id ) {
	$comments = get_post_meta( $post_id, 'blog_comments', true );
	if ( ! is_array( $comments ) || ! $comments ) {
		return 0;
	}

	$count = 0;
	foreach ( $comments as $comment ) {
		if ( ! is_array( $comment ) ) {
			continue;
		}
		$count++;
		$replies = $comment['replies'] ?? array();
		if ( ! is_array( $replies ) ) {
			continue;
		}
		foreach ( $replies as $reply ) {
			if ( ! is_array( $reply ) ) {
				continue;
			}
			$count++;
			$nested = $reply['replies'] ?? array();
			if ( is_array( $nested ) ) {
				$count += count( $nested );
			}
		}
	}

	return $count;
}

/**
 * Счётчик комментариев для stats.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function tolstenko_get_blog_comments_count( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( ! $post_id ) {
		return 0;
	}

	return tolstenko_get_curated_blog_comments_count( $post_id );
}

/**
 * Email комментатора (на сайте не показывается).
 *
 * @param mixed $email Raw email.
 * @return string
 */
function tolstenko_blog_comment_sanitize_email( $email ) {
	$email = sanitize_email( (string) $email );
	return is_email( $email ) ? $email : '';
}

/**
 * Стабильный id комментария (не индекс массива).
 *
 * @return string
 */
function tolstenko_blog_comment_generate_id() {
	try {
		return 'cmt_' . bin2hex( random_bytes( 8 ) );
	} catch ( Exception $e ) {
		return 'cmt_' . strtolower( wp_generate_password( 16, false, false ) );
	}
}

/**
 * @param mixed $id Raw id.
 * @return string
 */
function tolstenko_blog_comment_normalize_id( $id ) {
	$id = strtolower( trim( (string) $id ) );
	$id = preg_replace( '/[^a-z0-9_]/', '', $id );
	if ( ! is_string( $id ) || $id === '' || strpos( $id, 'cmt_' ) !== 0 || strlen( $id ) < 8 ) {
		return '';
	}
	return $id;
}

/**
 * @param mixed $raw  Raw id.
 * @param array $used Used ids (key = id).
 * @return string
 */
function tolstenko_blog_comment_unique_id( $raw, array &$used ) {
	$id = tolstenko_blog_comment_normalize_id( $raw );
	if ( $id === '' || isset( $used[ $id ] ) ) {
		$id = tolstenko_blog_comment_generate_id();
		while ( isset( $used[ $id ] ) ) {
			$id = tolstenko_blog_comment_generate_id();
		}
	}
	$used[ $id ] = true;
	return $id;
}

/**
 * Проставляет недостающие id всем комментариям дерева.
 *
 * @param array $comments Comments list.
 * @return array{comments:array,changed:bool}
 */
function tolstenko_blog_ensure_comment_ids( array $comments ) {
	$used    = array();
	$changed = false;
	$out     = array();

	foreach ( $comments as $comment ) {
		if ( ! is_array( $comment ) ) {
			continue;
		}
		$old_id        = (string) ( $comment['id'] ?? '' );
		$comment['id'] = tolstenko_blog_comment_unique_id( $old_id, $used );
		if ( $comment['id'] !== $old_id ) {
			$changed = true;
		}

		$replies_out = array();
		$replies     = isset( $comment['replies'] ) && is_array( $comment['replies'] ) ? $comment['replies'] : array();
		foreach ( $replies as $reply ) {
			if ( ! is_array( $reply ) ) {
				continue;
			}
			$old_rid     = (string) ( $reply['id'] ?? '' );
			$reply['id'] = tolstenko_blog_comment_unique_id( $old_rid, $used );
			if ( $reply['id'] !== $old_rid ) {
				$changed = true;
			}

			$nested_out = array();
			$nested     = isset( $reply['replies'] ) && is_array( $reply['replies'] ) ? $reply['replies'] : array();
			foreach ( $nested as $nested_item ) {
				if ( ! is_array( $nested_item ) ) {
					continue;
				}
				$old_nid           = (string) ( $nested_item['id'] ?? '' );
				$nested_item['id'] = tolstenko_blog_comment_unique_id( $old_nid, $used );
				if ( $nested_item['id'] !== $old_nid ) {
					$changed = true;
				}
				unset( $nested_item['replies'] );
				$nested_out[] = $nested_item;
			}
			$reply['replies'] = $nested_out;
			$replies_out[]    = $reply;
		}

		$comment['replies'] = $replies_out;
		$out[]              = $comment;
	}

	return array(
		'comments' => $out,
		'changed'  => $changed,
	);
}

/**
 * Комментарии статьи с гарантированными id (сохраняет, если что-то проставили).
 *
 * @param int $post_id Post ID.
 * @return array
 */
function tolstenko_blog_ensure_post_comment_ids( $post_id ) {
	$post_id  = (int) $post_id;
	$comments = $post_id ? get_post_meta( $post_id, 'blog_comments', true ) : array();
	if ( ! is_array( $comments ) ) {
		$comments = array();
	}

	$ensured = tolstenko_blog_ensure_comment_ids( $comments );
	if ( $post_id && $ensured['changed'] ) {
		update_post_meta( $post_id, 'blog_comments', $ensured['comments'] );
	}

	return $ensured['comments'];
}

/**
 * Найти комментарий в дереве (корень, ответ или ответ второго уровня).
 *
 * @param array  $comments Comments.
 * @param string $id       Comment id.
 * @return array{kind:string,depth:int,root_index:int,reply_index:?int,nested_index:?int,comment:array}|null
 */
function tolstenko_blog_find_comment( array $comments, $id ) {
	$id = tolstenko_blog_comment_normalize_id( $id );
	if ( $id === '' ) {
		return null;
	}
	foreach ( $comments as $index => $comment ) {
		if ( ! is_array( $comment ) ) {
			continue;
		}
		if ( tolstenko_blog_comment_normalize_id( $comment['id'] ?? '' ) === $id ) {
			return array(
				'kind'         => 'root',
				'depth'        => 0,
				'root_index'   => (int) $index,
				'reply_index'  => null,
				'nested_index' => null,
				'comment'      => $comment,
			);
		}
		$replies = isset( $comment['replies'] ) && is_array( $comment['replies'] ) ? $comment['replies'] : array();
		foreach ( $replies as $ri => $reply ) {
			if ( ! is_array( $reply ) ) {
				continue;
			}
			if ( tolstenko_blog_comment_normalize_id( $reply['id'] ?? '' ) === $id ) {
				return array(
					'kind'         => 'reply',
					'depth'        => 1,
					'root_index'   => (int) $index,
					'reply_index'  => (int) $ri,
					'nested_index' => null,
					'comment'      => $reply,
				);
			}
			$nested = isset( $reply['replies'] ) && is_array( $reply['replies'] ) ? $reply['replies'] : array();
			foreach ( $nested as $ni => $nested_item ) {
				if ( ! is_array( $nested_item ) ) {
					continue;
				}
				if ( tolstenko_blog_comment_normalize_id( $nested_item['id'] ?? '' ) === $id ) {
					return array(
						'kind'         => 'nested',
						'depth'        => 2,
						'root_index'   => (int) $index,
						'reply_index'  => (int) $ri,
						'nested_index' => (int) $ni,
						'comment'      => $nested_item,
					);
				}
			}
		}
	}
	return null;
}

/**
 * Комментарий по id.
 *
 * @param int    $post_id Post ID.
 * @param string $id      Comment id.
 * @return array|null
 */
function tolstenko_blog_get_comment( $post_id, $id ) {
	$post_id  = (int) $post_id;
	$comments = $post_id ? get_post_meta( $post_id, 'blog_comments', true ) : array();
	if ( ! is_array( $comments ) ) {
		$comments = array();
	}
	$found = tolstenko_blog_find_comment( $comments, $id );
	return $found ? $found['comment'] : null;
}

/**
 * Очистка дерева комментариев (корни → ответы → ответы второго уровня).
 *
 * @param array $rows Raw comments.
 * @return array
 */
function tolstenko_blog_sanitize_comments( array $rows ) {
	$used = array();

	$sanitize_row = static function ( array $row ) use ( &$used ) {
		return array(
			'id'    => tolstenko_blog_comment_unique_id( $row['id'] ?? '', $used ),
			'photo' => (int) ( $row['photo'] ?? 0 ),
			'name'  => sanitize_text_field( (string) ( $row['name'] ?? '' ) ),
			'email' => tolstenko_blog_comment_sanitize_email( $row['email'] ?? '' ),
			'date'  => sanitize_text_field( (string) ( $row['date'] ?? '' ) ),
			'time'  => sanitize_text_field( (string) ( $row['time'] ?? '' ) ),
			'text'  => sanitize_textarea_field( (string) ( $row['text'] ?? '' ) ),
		);
	};

	$is_empty = static function ( array $item ) {
		return $item['name'] === '' && $item['text'] === '' && ! $item['photo'] && empty( $item['replies'] );
	};

	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$item        = $sanitize_row( $row );
		$replies_out = array();
		foreach ( (array) ( $row['replies'] ?? array() ) as $reply ) {
			if ( ! is_array( $reply ) ) {
				continue;
			}
			$r          = $sanitize_row( $reply );
			$nested_out = array();
			foreach ( (array) ( $reply['replies'] ?? array() ) as $nested_item ) {
				if ( ! is_array( $nested_item ) ) {
					continue;
				}
				$n = $sanitize_row( $nested_item );
				if ( ! $is_empty( $n ) ) {
					$nested_out[] = $n;
				}
			}
			$r['replies'] = $nested_out;
			if ( ! $is_empty( $r ) ) {
				$replies_out[] = $r;
			}
		}
		$item['replies'] = $replies_out;
		if ( ! $is_empty( $item ) ) {
			$out[] = $item;
		}
	}
	return $out;
}

/**
 * Добавить кураторский комментарий в meta blog_comments (append, без затирания).
 *
 * @param int    $post_id   Target blog post ID.
 * @param array  $item      Keys: photo, name, email, date, time, text.
 * @param string $parent_id Id корня или ответа (пусто = новый корень).
 * @return string|false Id нового комментария или false.
 */
function tolstenko_append_blog_comment( $post_id, array $item, $parent_id = '' ) {
	$post_id = (int) $post_id;
	if ( ! $post_id || ! get_post( $post_id ) ) {
		return false;
	}

	$comments = tolstenko_blog_ensure_post_comment_ids( $post_id );

	$used = array();
	array_walk_recursive(
		$comments,
		static function ( $value, $key ) use ( &$used ) {
			if ( $key === 'id' ) {
				$id = tolstenko_blog_comment_normalize_id( $value );
				if ( $id !== '' ) {
					$used[ $id ] = true;
				}
			}
		}
	);

	$sanitized = tolstenko_blog_sanitize_comments( array( $item ) );
	if ( ! $sanitized ) {
		return false;
	}
	$row       = $sanitized[0];
	$row['id'] = tolstenko_blog_comment_unique_id( '', $used );

	$parent_id = tolstenko_blog_comment_normalize_id( $parent_id );
	if ( $parent_id !== '' ) {
		$found = tolstenko_blog_find_comment( $comments, $parent_id );
		if ( ! $found || $found['depth'] >= 2 ) {
			return false;
		}
		if ( $found['kind'] === 'reply' ) {
			unset( $row['replies'] );
			$comments[ $found['root_index'] ]['replies'][ $found['reply_index'] ]['replies'][] = $row;
		} else {
			$comments[ $found['root_index'] ]['replies'][] = $row;
		}
	} else {
		$comments[] = $row;
	}

	update_post_meta( $post_id, 'blog_comments', $comments );

	return (string) $row['id'];
}

/**
 * Автор статьи для шапки и сайдбара.
 * Приоритет: выбранный в записи → главный автор (Настройки сайта → Авторы статей)
 * → ACF-опции director_* (как было в теме раньше).
 *
 * @param int $post_id Post ID.
 * @return array{photo:int,name:string,title:string,description:string,show_quest:bool}
 */
function tolstenko_get_single_blog_director( $post_id = 0 ) {
	$post_id    = $post_id ? (int) $post_id : (int) get_the_ID();
	$quest_raw  = get_post_meta( $post_id, 'single-blog_quest', true );
	$show_quest = ( $quest_raw === '' || (string) $quest_raw === '1' );

	$author = null;
	$index  = get_post_meta( $post_id, 'blog_author', true );
	if ( $index !== '' && $index !== false ) {
		$author = tolstenko_get_blog_author_by_index( $index );
	}

	$person = is_array( $author )
		? tolstenko_blog_author_to_person( $author )
		: tolstenko_get_blog_default_author();

	$person['show_quest'] = $show_quest;

	return $person;
}

/**
 * Строка автора из настроек → данные для вывода.
 *
 * @param array $author Author row.
 * @return array{photo:int,name:string,title:string,description:string}
 */
function tolstenko_blog_author_to_person( array $author ) {
	$title = trim( (string) ( $author['job_title'] ?? '' ) );
	if ( $title === '' ) {
		$title = trim( (string) ( $author['position'] ?? '' ) );
	}

	return array(
		'photo'       => (int) ( $author['photo'] ?? 0 ),
		'name'        => trim( (string) ( $author['name'] ?? '' ) ),
		'title'       => $title,
		'description' => trim( (string) ( $author['description'] ?? '' ) ),
	);
}

/**
 * Автор по умолчанию (сетка статей, статьи без выбранного автора):
 * главный автор → «директор» из ACF-опций темы (как было раньше).
 *
 * @return array{photo:int,name:string,title:string,description:string}
 */
function tolstenko_get_blog_default_author() {
	$main = tolstenko_get_blog_main_author();
	if ( is_array( $main ) ) {
		return tolstenko_blog_author_to_person( $main );
	}

	return array(
		'photo'       => tolstenko_block_image_id( theme_get_field( 'director_photo', OPTION_ID ) ),
		'name'        => trim( wp_strip_all_tags( (string) theme_get_field( 'director_name', OPTION_ID ) ) ),
		'title'       => '',
		'description' => trim( (string) theme_get_field( 'director_text', OPTION_ID ) ),
	);
}

/**
 * Транслит кириллицы в латиницу для якорей TOC.
 *
 * @param string $text Heading text.
 * @return string
 */
function tolstenko_transliterate_slug( $text ) {
	$map = array(
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',
		'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
		'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shh',
		'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
		'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
		'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shh',
		'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
		'І' => 'I', 'Ї' => 'Yi', 'Є' => 'Ye', 'Ґ' => 'G',
		'і' => 'i', 'ї' => 'yi', 'є' => 'ye', 'ґ' => 'g',
	);

	$slug = sanitize_title( strtr( (string) $text, $map ) );

	return $slug !== '' ? $slug : 'section';
}

/**
 * Иерархический TOC (h2 → пункты, h3 → вложенные) + id у заголовков.
 *
 * @param string $html Content HTML.
 * @return array{html:string,items:array<int,array{id:string,text:string,level:int,children:array}>}
 */
function tolstenko_prepare_blog_toc( $html ) {
	$html         = (string) $html;
	$toc_items    = array();
	$used_toc_ids = array();

	$has_h2 = (bool) preg_match( '/<h2\b/i', $html );
	$has_h3 = (bool) preg_match( '/<h3\b/i', $html );

	if ( ! $has_h2 && ! $has_h3 ) {
		return array(
			'html'  => $html,
			'items' => $toc_items,
		);
	}

	// Оба уровня, если есть h2; иначе только h3 как верхний уровень.
	$heading_pattern = $has_h2
		? '/<h([23])([^>]*)>(.*?)<\/h\1>/isu'
		: '/<h(3)([^>]*)>(.*?)<\/h\1>/isu';

	$html = preg_replace_callback(
		$heading_pattern,
		function ( $matches ) use ( &$toc_items, &$used_toc_ids, $has_h2 ) {
			$level = (int) $matches[1];
			$attrs = (string) $matches[2];
			$body  = (string) $matches[3];
			$text  = trim( wp_strip_all_tags( $body ) );

			// Заголовки внутри плашек статьи (CTA и т.п.) в оглавление не попадают.
			if ( $text === '' || preg_match( '/class=(["\'])[^"\']*article-cta__title/i', $attrs ) ) {
				return $matches[0];
			}

			$base_id   = tolstenko_transliterate_slug( $text );
			$unique_id = $base_id;
			$suffix    = 2;
			while ( isset( $used_toc_ids[ $unique_id ] ) ) {
				$unique_id = $base_id . '-' . $suffix;
				$suffix++;
			}
			$used_toc_ids[ $unique_id ] = true;

			$entry = array(
				'id'       => $unique_id,
				'text'     => $text,
				'level'    => $level,
				'children' => array(),
			);

			$last = count( $toc_items ) - 1;
			if ( $has_h2 && 3 === $level && $last >= 0 && 2 === (int) $toc_items[ $last ]['level'] ) {
				$toc_items[ $last ]['children'][] = $entry;
			} else {
				$toc_items[] = $entry;
			}

			$attrs = preg_replace( '/\s+id=(["\']).*?\1/i', '', $attrs );

			return '<h' . $level . $attrs . ' id="' . esc_attr( $unique_id ) . '">' . $body . '</h' . $level . '>';
		},
		$html
	);

	return array(
		'html'  => is_string( $html ) ? $html : '',
		'items' => $toc_items,
	);
}

/**
 * Дата публикации в формате «5 марта, 2026».
 *
 * @param int $post_id Post ID.
 * @return string
 */
function tolstenko_get_blog_date_label( $post_id = 0 ) {
	$months = array(
		1  => 'января',
		2  => 'февраля',
		3  => 'марта',
		4  => 'апреля',
		5  => 'мая',
		6  => 'июня',
		7  => 'июля',
		8  => 'августа',
		9  => 'сентября',
		10 => 'октября',
		11 => 'ноября',
		12 => 'декабря',
	);

	$parts = explode( ' ', (string) get_the_date( 'j n Y', $post_id ?: null ) );
	if ( count( $parts ) !== 3 || empty( $months[ (int) $parts[1] ] ) ) {
		return (string) get_the_date( '', $post_id ?: null );
	}

	return $parts[0] . ' ' . $months[ (int) $parts[1] ] . ', ' . $parts[2];
}

/**
 * Короткий текст карточки статьи: поле карточки → лид → начало текста.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function tolstenko_get_blog_card_text( $post_id ) {
	foreach ( array( 'blog_card_text', 'single-blog_text' ) as $key ) {
		$text = trim( wp_strip_all_tags( (string) get_post_meta( $post_id, $key, true ) ) );
		if ( $text !== '' ) {
			return $text;
		}
	}

	// Текст статьи лежит внутри my-theme/blog-content: убираем разметку блоков (комментарии с JSON).
	$content = (string) get_post_field( 'post_content', $post_id );
	$content = preg_replace( '/<!--.*?-->/s', ' ', strip_shortcodes( $content ) );

	return wp_trim_words( wp_strip_all_tags( (string) $content ), 20, '…' );
}

/**
 * HTML тела статьи из редактора (текст + блоки «Статья: …»).
 * Обычные блоки здесь не оборачиваются в .container (это делает
 * theme_wrap_non_theme_blocks_in_container для страниц из секций).
 *
 * @param int $post_id Post ID.
 * @return string
 */
function tolstenko_get_blog_body_html( $post_id ) {
	$content = (string) get_post_field( 'post_content', (int) $post_id );
	if ( trim( $content ) === '' ) {
		return '';
	}

	theme_nested_blocks_depth( 1 );
	$html = (string) apply_filters( 'the_content', $content );
	theme_nested_blocks_depth( -1 );

	return $html;
}
