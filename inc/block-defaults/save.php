<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tolstenko_save_block_defaults_from_request() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['tolstenko_defaults_reset_all'] ) ) {
		delete_option( 'tolstenko_block_defaults' );
		return;
	}
	$raw = isset( $_POST['tolstenko_block_defaults'] ) ? wp_unslash( $_POST['tolstenko_block_defaults'] ) : array();
	$out = array();
	if ( ! is_array( $raw ) ) {
		$raw = array();
	}


	$out['reviews'] = array(
		'subtitle'   => tolstenko_kses_html( $raw['reviews']['subtitle'] ?? '' ),
		'title'      => tolstenko_kses_html( $raw['reviews']['title'] ?? '' ),
		'text'       => tolstenko_kses_html( $raw['reviews']['text'] ?? '' ),
		'show_items' => ! empty( $raw['reviews']['show_items'] ),
		'ids'        => tolstenko_sanitize_ids( $raw['reviews']['ids'] ?? array() ),
		'cards'      => array(),
	);
	if ( isset( $raw['reviews']['cards'] ) && is_array( $raw['reviews']['cards'] ) ) {
		foreach ( $raw['reviews']['cards'] as $card ) {
			if ( ! is_array( $card ) ) {
				continue;
			}
			$c_title = sanitize_text_field( $card['title'] ?? '' );
			$c_url   = esc_url_raw( $card['url'] ?? '' );
			$c_rating = isset( $card['rating'] ) ? (int) $card['rating'] : 5;
			if ( $c_rating < 1 ) {
				$c_rating = 5;
			}
			if ( $c_rating > 5 ) {
				$c_rating = 5;
			}
			if ( $c_title === '' ) {
				continue;
			}
			$out['reviews']['cards'][] = array(
				'title'  => $c_title,
				'url'    => $c_url,
				'rating' => $c_rating,
			);
		}
	}

	$out['documents']['subtitle'] = tolstenko_kses_html( $raw['documents']['subtitle'] ?? '' );
	$out['documents']['title'] = tolstenko_kses_html( $raw['documents']['title'] ?? ''  );
	$out['documents']['items'] = array();
	if ( isset( $raw['documents']['items'] ) && is_array( $raw['documents']['items'] ) ) {
		foreach ( $raw['documents']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$title = tolstenko_kses_html( $it['title'] ?? ''  );
			$text = tolstenko_kses_html( $it['text'] ?? ''  );
			$image = isset( $it['image'] ) ? (int) $it['image'] : 0;
			$attributes = sanitize_textarea_field( $it['attributes'] ?? '' );
			if ( $title === '' && $image === 0 && $text === '' && $attributes === '' ) {
				continue;
			}
			$out['documents']['items'][] = array(
				'image' => $image,
				'title' => $title,
				'text' => $text,
				'attributes' => $attributes,
			);
		}
	}



	$out['case_section'] = array(
		'subtitle'        => tolstenko_kses_html( $raw['case_section']['subtitle'] ?? '' ),
		'title'          => tolstenko_kses_html( $raw['case_section']['title'] ?? '' ),
		'text'           => tolstenko_kses_html( $raw['case_section']['text'] ?? '' ),
		'posts_per_page' => isset( $raw['case_section']['posts_per_page'] ) ? (int) $raw['case_section']['posts_per_page'] : 4,
		'ids'            => tolstenko_sanitize_ids( $raw['case_section']['ids'] ?? array() ),
	);

	$out['service_section'] = array(
		'subtitle'        => tolstenko_kses_html( $raw['service_section']['subtitle'] ?? '' ),
		'title'          => tolstenko_kses_html( $raw['service_section']['title'] ?? '' ),
		'text'           => tolstenko_kses_html( $raw['service_section']['text'] ?? '' ),
		'posts_per_page' => isset( $raw['service_section']['posts_per_page'] ) ? (int) $raw['service_section']['posts_per_page'] : 6,
		'ids'            => tolstenko_sanitize_service_section_ids( $raw['service_section']['ids'] ?? array() ),
	);

	$out['service_section_filters'] = array(
		'subtitle'        => tolstenko_kses_html( $raw['service_section_filters']['subtitle'] ?? '' ),
		'title'          => tolstenko_kses_html( $raw['service_section_filters']['title'] ?? '' ),
		'text'           => tolstenko_kses_html( $raw['service_section_filters']['text'] ?? '' ),
		'posts_per_page' => isset( $raw['service_section_filters']['posts_per_page'] ) ? (int) $raw['service_section_filters']['posts_per_page'] : 6,
		'ids'            => tolstenko_sanitize_service_section_ids( $raw['service_section_filters']['ids'] ?? array() ),
	);

	$out['blog_section'] = array(
		'subtitle'        => tolstenko_kses_html( $raw['blog_section']['subtitle'] ?? '' ),
		'title'          => tolstenko_kses_html( $raw['blog_section']['title'] ?? '' ),
		'text'           => tolstenko_kses_html( $raw['blog_section']['text'] ?? '' ),
		'posts_per_page' => isset( $raw['blog_section']['posts_per_page'] ) ? (int) $raw['blog_section']['posts_per_page'] : 12,
		'ids'            => tolstenko_sanitize_service_section_ids( $raw['blog_section']['ids'] ?? array() ),
	);

	$out['blog_section_filters'] = array(
		'title'          => tolstenko_kses_html( $raw['blog_section_filters']['title'] ?? '' ),
		'text'           => tolstenko_kses_html( $raw['blog_section_filters']['text'] ?? '' ),
		'posts_per_page' => isset( $raw['blog_section_filters']['posts_per_page'] ) ? (int) $raw['blog_section_filters']['posts_per_page'] : 4,
		'ids'            => tolstenko_sanitize_service_section_ids( $raw['blog_section_filters']['ids'] ?? array() ),
		'btn_text'       => sanitize_text_field( $raw['blog_section_filters']['btn_text'] ?? '' ),
	);

	$out['faq'] = array(
		'badge'      => tolstenko_kses_html( $raw['faq']['badge'] ?? '' ),
		'title'      => tolstenko_kses_html( $raw['faq']['title'] ?? ''  ),
		'form_title' => tolstenko_kses_html( $raw['faq']['form_title'] ?? ''  ),
		'form_text'  => tolstenko_kses_html( $raw['faq']['form_text'] ?? ''  ),
		'teammate_id' => isset( $raw['faq']['teammate_id'] ) ? (int) $raw['faq']['teammate_id'] : 0,
		'items'      => array(),
	);
	if ( isset( $raw['faq']['items'] ) && is_array( $raw['faq']['items'] ) ) {
		foreach ( $raw['faq']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$q = tolstenko_kses_html( $it['quest'] ?? ''  );
			$a = tolstenko_kses_redactor( $it['unswer'] ?? '' );
			if ( $q === '' && trim( wp_strip_all_tags( $a ) ) === '' ) {
				continue;
			}
			$out['faq']['items'][] = array(
				'quest'  => $q,
				'unswer' => $a,
			);
		}
	}

	$out['field_template'] = array(
		'enabled'       => ! empty( $raw['field_template']['enabled'] ),
		'text_field'     => tolstenko_kses_html( $raw['field_template']['text_field'] ?? '' ),
		'textarea_field' => tolstenko_kses_html( $raw['field_template']['textarea_field'] ?? '' ),
		'editor_field'   => tolstenko_kses_redactor( $raw['field_template']['editor_field'] ?? '' ),
		'image'          => isset( $raw['field_template']['image'] ) ? (int) $raw['field_template']['image'] : 0,
		'post_ids'       => tolstenko_sanitize_service_section_ids( $raw['field_template']['post_ids'] ?? array() ),
		'single_post_id' => isset( $raw['field_template']['single_post_id'] ) ? (int) $raw['field_template']['single_post_id'] : 0,
		'items'          => array(),
	);
	if ( isset( $raw['field_template']['items'] ) && is_array( $raw['field_template']['items'] ) ) {
		foreach ( $raw['field_template']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'title'    => tolstenko_kses_html( $it['title'] ?? '' ),
				'text'     => tolstenko_kses_html( $it['text'] ?? '' ),
			);
			if ( $row['title'] === '' && $row['text'] === '' ) {
				continue;
			}
			$out['field_template']['items'][] = $row;
		}
	}


	$out['main_hero'] = array(
		'title'           => tolstenko_kses_html( $raw['main_hero']['title'] ?? '' ),
		'title_tag'       => tolstenko_kses_html( $raw['main_hero']['title_tag'] ?? 'h1' ),
		'text'            => tolstenko_kses_html( $raw['main_hero']['text'] ?? '' ),
		'items'           => array(),
		'btn_text'        => tolstenko_kses_html( $raw['main_hero']['btn_text'] ?? '' ),
		'show_promo'      => ! empty( $raw['main_hero']['show_promo'] ),
		'promo_text'      => tolstenko_kses_html( $raw['main_hero']['promo_text'] ?? '' ),
		'present_image'   => isset( $raw['main_hero']['present_image'] ) ? (int) $raw['main_hero']['present_image'] : 0,
		'person_name'     => tolstenko_kses_html( $raw['main_hero']['person_name'] ?? '' ),
		'person_position' => tolstenko_kses_html( $raw['main_hero']['person_position'] ?? '' ),
		'image'           => isset( $raw['main_hero']['image'] ) ? (int) $raw['main_hero']['image'] : 0,
	);
	if ( isset( $raw['main_hero']['items'] ) && is_array( $raw['main_hero']['items'] ) ) {
		foreach ( $raw['main_hero']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'title' => tolstenko_kses_html( $it['title'] ?? '' ),
				'text'  => tolstenko_kses_html( $it['text'] ?? '' ),
			);
			$has_value = false;
			foreach ( $row as $row_val ) {
				if ( '' !== $row_val && 0 !== $row_val ) {
					$has_value = true;
					break;
				}
			}
			if ( ! $has_value ) {
				continue;
			}
			$out['main_hero']['items'][] = $row;
		}
	}
	$out['result'] = array(
		'badge' => tolstenko_kses_html( $raw['result']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['result']['title'] ?? '' ),
		'items' => array(),
	);
	if ( isset( $raw['result']['items'] ) && is_array( $raw['result']['items'] ) ) {
		foreach ( $raw['result']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'icon' => isset( $it['icon'] ) ? (int) $it['icon'] : 0,
				'title' => tolstenko_kses_html( $it['title'] ?? '' ),
				'text' => tolstenko_kses_html( $it['text'] ?? '' ),
			);
			$has_value = false;
			foreach ( $row as $row_val ) {
				if ( '' !== $row_val && 0 !== $row_val ) {
					$has_value = true;
					break;
				}
			}
			if ( ! $has_value ) {
				continue;
			}
			$out['result']['items'][] = $row;
		}
	}

	$out['compare'] = array(
		'badge' => tolstenko_kses_html( $raw['compare']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['compare']['title'] ?? '' ),
		'lead' => tolstenko_kses_html( $raw['compare']['lead'] ?? '' ),
		'th_criterion' => tolstenko_kses_html( $raw['compare']['th_criterion'] ?? '' ),
		'th_self' => tolstenko_kses_html( $raw['compare']['th_self'] ?? '' ),
		'th_mediator' => tolstenko_kses_html( $raw['compare']['th_mediator'] ?? '' ),
		'th_us' => tolstenko_kses_html( $raw['compare']['th_us'] ?? '' ),
		'rows' => array(),
		'foot_text' => tolstenko_kses_html( $raw['compare']['foot_text'] ?? '' ),
		'btn_text' => tolstenko_kses_html( $raw['compare']['btn_text'] ?? '' ),
		'btn_url' => esc_url_raw( $raw['compare']['btn_url'] ?? '' ),
	);
	if ( isset( $raw['compare']['rows'] ) && is_array( $raw['compare']['rows'] ) ) {
		foreach ( $raw['compare']['rows'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'criterion' => tolstenko_kses_html( $it['criterion'] ?? '' ),
				'self' => tolstenko_kses_html( $it['self'] ?? '' ),
				'mediator' => tolstenko_kses_html( $it['mediator'] ?? '' ),
				'us' => tolstenko_kses_html( $it['us'] ?? '' ),
			);
			$has_value = false;
			foreach ( $row as $row_val ) {
				if ( '' !== $row_val && 0 !== $row_val ) {
					$has_value = true;
					break;
				}
			}
			if ( ! $has_value ) {
				continue;
			}
			$out['compare']['rows'][] = $row;
		}
	}

	$out['why_us'] = array(
		'badge' => tolstenko_kses_html( $raw['why_us']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['why_us']['title'] ?? '' ),
		'items' => array(),
	);
	if ( isset( $raw['why_us']['items'] ) && is_array( $raw['why_us']['items'] ) ) {
		foreach ( $raw['why_us']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'icon' => isset( $it['icon'] ) ? (int) $it['icon'] : 0,
				'title' => tolstenko_kses_html( $it['title'] ?? '' ),
				'text' => tolstenko_kses_html( $it['text'] ?? '' ),
			);
			$has_value = false;
			foreach ( $row as $row_val ) {
				if ( '' !== $row_val && 0 !== $row_val ) {
					$has_value = true;
					break;
				}
			}
			if ( ! $has_value ) {
				continue;
			}
			$out['why_us']['items'][] = $row;
		}
	}

	$out['infra'] = array(
		'badge' => tolstenko_kses_html( $raw['infra']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['infra']['title'] ?? '' ),
		'text' => tolstenko_kses_html( $raw['infra']['text'] ?? '' ),
		'btn_text' => tolstenko_kses_html( $raw['infra']['btn_text'] ?? '' ),
		'btn_url' => esc_url_raw( $raw['infra']['btn_url'] ?? '' ),
		'items' => array(),
	);
	if ( isset( $raw['infra']['items'] ) && is_array( $raw['infra']['items'] ) ) {
		foreach ( $raw['infra']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'text' => tolstenko_kses_html( $it['text'] ?? '' ),
			);
			$has_value = false;
			foreach ( $row as $row_val ) {
				if ( '' !== $row_val && 0 !== $row_val ) {
					$has_value = true;
					break;
				}
			}
			if ( ! $has_value ) {
				continue;
			}
			$out['infra']['items'][] = $row;
		}
	}

	$out['about'] = array(
		'badge' => tolstenko_kses_html( $raw['about']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['about']['title'] ?? '' ),
		'text' => tolstenko_kses_redactor( $raw['about']['text'] ?? '' ),
		'image' => isset( $raw['about']['image'] ) ? (int) $raw['about']['image'] : 0,
		'stats' => array(),
	);
	if ( isset( $raw['about']['stats'] ) && is_array( $raw['about']['stats'] ) ) {
		foreach ( $raw['about']['stats'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'num' => tolstenko_kses_html( $it['num'] ?? '' ),
				'label' => tolstenko_kses_html( $it['label'] ?? '' ),
			);
			$has_value = false;
			foreach ( $row as $row_val ) {
				if ( '' !== $row_val && 0 !== $row_val ) {
					$has_value = true;
					break;
				}
			}
			if ( ! $has_value ) {
				continue;
			}
			$out['about']['stats'][] = $row;
		}
	}

	$out['guide'] = array(
		'subtitle' => tolstenko_kses_html( $raw['guide']['subtitle'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['guide']['title'] ?? '' ),
		'time' => tolstenko_kses_html( $raw['guide']['time'] ?? '' ),
		'views' => tolstenko_kses_html( $raw['guide']['views'] ?? '' ),
		'date' => sanitize_text_field( $raw['guide']['date'] ?? '' ),
		'date_label' => tolstenko_kses_html( $raw['guide']['date_label'] ?? '' ),
		'card_title' => tolstenko_kses_html( $raw['guide']['card_title'] ?? '' ),
		'text' => tolstenko_kses_html( $raw['guide']['text'] ?? '' ),
		'btn_text' => tolstenko_kses_html( $raw['guide']['btn_text'] ?? '' ),
		'image' => isset( $raw['guide']['image'] ) ? (int) $raw['guide']['image'] : 0,
		'tags' => array(),
		'post_id' => tolstenko_landing_sanitize_post_id( $raw['guide']['post_id'] ?? 0, 'blog' ),
	);
	if ( isset( $raw['guide']['tags'] ) && is_array( $raw['guide']['tags'] ) ) {
		foreach ( $raw['guide']['tags'] as $it ) {
			if ( ! is_array( $it ) ) { continue; }
			$tag = tolstenko_kses_html( $it['text'] ?? '' );
			if ( $tag === '' ) { continue; }
			$out['guide']['tags'][] = array( 'text' => $tag );
		}
	}

	$out['consult'] = array(
		'badge' => tolstenko_kses_html( $raw['consult']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['consult']['title'] ?? '' ),
		'text' => tolstenko_kses_html( $raw['consult']['text'] ?? '' ),
		'contact_label' => tolstenko_kses_html( $raw['consult']['contact_label'] ?? '' ),
		'phone' => tolstenko_kses_html( $raw['consult']['phone'] ?? '' ),
		'input_placeholder' => tolstenko_kses_html( $raw['consult']['input_placeholder'] ?? '' ),
		'btn_text' => tolstenko_kses_html( $raw['consult']['btn_text'] ?? '' ),
		'consents' => array(),
		'image' => isset( $raw['consult']['image'] ) ? (int) $raw['consult']['image'] : 0,
	);
	if ( isset( $raw['consult']['consents'] ) && is_array( $raw['consult']['consents'] ) ) {
		foreach ( $raw['consult']['consents'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$row = array(
				'text' => tolstenko_kses_html( $it['text'] ?? '' ),
				'link_text' => tolstenko_kses_html( $it['link_text'] ?? '' ),
				'link_url' => esc_url_raw( $it['link_url'] ?? '' ),
			);
			$has_value = false;
			foreach ( $row as $row_val ) {
				if ( '' !== $row_val && 0 !== $row_val ) {
					$has_value = true;
					break;
				}
			}
			if ( ! $has_value ) {
				continue;
			}
			$out['consult']['consents'][] = $row;
		}
	}

	$out['hero_stats'] = array( 'items' => array() );
	if ( isset( $raw['hero_stats']['items'] ) && is_array( $raw['hero_stats']['items'] ) ) {
		foreach ( $raw['hero_stats']['items'] as $it ) {
			if ( ! is_array( $it ) ) { continue; }
			$num   = tolstenko_kses_html( $it['num'] ?? '' );
			$label = tolstenko_kses_html( $it['label'] ?? '' );
			if ( $num === '' && $label === '' ) { continue; }
			$out['hero_stats']['items'][] = array( 'num' => $num, 'label' => $label );
		}
	}

	$out['situations'] = array(
		'badge'        => tolstenko_kses_html( $raw['situations']['badge'] ?? '' ),
		'title'        => tolstenko_kses_html( $raw['situations']['title'] ?? '' ),
		'items'        => array(),
	);
	if ( isset( $raw['situations']['items'] ) && is_array( $raw['situations']['items'] ) ) {
		foreach ( $raw['situations']['items'] as $it ) {
			if ( ! is_array( $it ) ) { continue; }
			$t = tolstenko_kses_html( $it['title'] ?? '' );
			$x = tolstenko_kses_html( $it['text'] ?? '' );
			if ( $t === '' && trim( wp_strip_all_tags( $x ) ) === '' ) { continue; }
			$out['situations']['items'][] = array( 'title' => $t, 'text' => $x );
		}
	}

	$out['process'] = array(
		'badge'        => tolstenko_kses_html( $raw['process']['badge'] ?? '' ),
		'title'        => tolstenko_kses_html( $raw['process']['title'] ?? '' ),
		'image'        => isset( $raw['process']['image'] ) ? (int) $raw['process']['image'] : 0,
		'items'        => array(),
	);
	if ( isset( $raw['process']['items'] ) && is_array( $raw['process']['items'] ) ) {
		foreach ( $raw['process']['items'] as $it ) {
			if ( ! is_array( $it ) ) { continue; }
			$t = tolstenko_kses_html( $it['title'] ?? '' );
			$x = tolstenko_kses_redactor( $it['text'] ?? '' );
			if ( $t === '' && trim( wp_strip_all_tags( $x ) ) === '' ) { continue; }
			$out['process']['items'][] = array( 'title' => $t, 'text' => $x );
		}
	}

	$out['cost'] = array(
		'badge'        => tolstenko_kses_html( $raw['cost']['badge'] ?? '' ),
		'title'        => tolstenko_kses_html( $raw['cost']['title'] ?? '' ),
		'lead'         => tolstenko_kses_html( $raw['cost']['lead'] ?? '' ),
		'prices'       => array(),
		'card_title'   => tolstenko_kses_html( $raw['cost']['card_title'] ?? '' ),
		'card_text'    => tolstenko_kses_html( $raw['cost']['card_text'] ?? '' ),
		'btn_text'     => tolstenko_kses_html( $raw['cost']['btn_text'] ?? '' ),
		'btn_url'      => esc_url_raw( $raw['cost']['btn_url'] ?? '' ),
		'image'        => isset( $raw['cost']['image'] ) ? (int) $raw['cost']['image'] : 0,
		'links'        => array(),
	);
	if ( isset( $raw['cost']['links'] ) && is_array( $raw['cost']['links'] ) ) {
		foreach ( $raw['cost']['links'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}
			$icon = $it['icon_id'] ?? '';
			$icon = is_array( $icon ) ? ( $icon['id'] ?? ( $icon['url'] ?? '' ) ) : $icon;
			$icon = ( is_string( $icon ) && $icon !== '' && ctype_digit( $icon ) ) ? (int) $icon : sanitize_text_field( (string) $icon );
			$title = sanitize_text_field( $it['title'] ?? '' );
			$url   = esc_url_raw( $it['link'] ?? '' );
			if ( $url === '' && $title === '' && empty( $icon ) ) {
				continue;
			}
			$out['cost']['links'][] = array(
				'icon_id' => $icon,
				'title'   => $title,
				'link'    => $url,
			);
		}
	}
	if ( isset( $raw['cost']['prices'] ) && is_array( $raw['cost']['prices'] ) ) {
		foreach ( $raw['cost']['prices'] as $it ) {
			if ( ! is_array( $it ) ) { continue; }
			$n = tolstenko_kses_html( $it['name'] ?? '' );
			$v = tolstenko_kses_html( $it['value'] ?? '' );
			if ( $n === '' && $v === '' ) { continue; }
			$out['cost']['prices'][] = array( 'name' => $n, 'value' => $v );
		}
	}

	$out['blog_more'] = array(
		'text' => tolstenko_kses_html( $raw['blog_more']['text'] ?? '' ),
		'url'  => esc_url_raw( $raw['blog_more']['url'] ?? '' ),
	);
	$out['team'] = array(
		'badge' => tolstenko_kses_html( $raw['team']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['team']['title'] ?? '' ),
		'text'  => tolstenko_kses_html( $raw['team']['text'] ?? '' ),
	);

$out['cases'] = array(
		'badge'     => tolstenko_kses_html( $raw['cases']['badge'] ?? '' ),
		'title'     => tolstenko_kses_html( $raw['cases']['title'] ?? '' ),
		'all_text'  => tolstenko_kses_html( $raw['cases']['all_text'] ?? '' ),
		'all_url'   => esc_url_raw( $raw['cases']['all_url'] ?? '' ),
		'foot_text' => tolstenko_kses_html( $raw['cases']['foot_text'] ?? '' ),
		'btn_text'  => tolstenko_kses_html( $raw['cases']['btn_text'] ?? '' ),
		'btn_url'   => esc_url_raw( $raw['cases']['btn_url'] ?? '' ),
		'post_ids'  => tolstenko_sanitize_service_section_ids( $raw['cases']['post_ids'] ?? array() ),
	);

	$out['programs'] = array(
		'badge'    => tolstenko_kses_html( $raw['programs']['badge'] ?? '' ),
		'title'    => tolstenko_kses_html( $raw['programs']['title'] ?? '' ),
		'lead'     => tolstenko_kses_html( $raw['programs']['lead'] ?? '' ),
		'columns'  => array(),
		'rows'     => array(),
		'btn_text' => tolstenko_kses_html( $raw['programs']['btn_text'] ?? '' ),
		'btn_url'  => esc_url_raw( $raw['programs']['btn_url'] ?? '' ),
	);

	if ( isset( $raw['programs']['columns'] ) && is_array( $raw['programs']['columns'] ) ) {
		foreach ( $raw['programs']['columns'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}

			$name   = tolstenko_kses_html( $it['name'] ?? '' );
			$flag   = isset( $it['flag'] ) ? (int) $it['flag'] : 0;
			$accent = ( isset( $it['accent'] ) && (string) $it['accent'] === '1' ) ? '1' : '';

			if ( $name === '' && $flag === 0 ) {
				continue;
			}

			$out['programs']['columns'][] = array( 'name' => $name, 'flag' => $flag, 'accent' => $accent );
		}
	}

	if ( isset( $raw['programs']['rows'] ) && is_array( $raw['programs']['rows'] ) ) {
		foreach ( $raw['programs']['rows'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}

			$criterion = tolstenko_kses_html( $it['criterion'] ?? '' );
			$values    = trim( (string) ( $it['values'] ?? '' ) );

			if ( $criterion === '' && $values === '' ) {
				continue;
			}

			$out['programs']['rows'][] = array( 'criterion' => $criterion, 'values' => $values );
		}
	}

	$out['banks'] = array(
		'badge' => tolstenko_kses_html( $raw['banks']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['banks']['title'] ?? '' ),
		'lead'  => tolstenko_kses_html( $raw['banks']['lead'] ?? '' ),
		'items' => array(),
	);

	if ( isset( $raw['banks']['items'] ) && is_array( $raw['banks']['items'] ) ) {
		foreach ( $raw['banks']['items'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}

			$title = tolstenko_kses_html( $it['title'] ?? '' );
			$logo  = isset( $it['logo'] ) ? (int) $it['logo'] : 0;

			if ( $title === '' && $logo === 0 ) {
				continue;
			}

			$out['banks']['items'][] = array(
				'title'         => $title,
				'logo'          => $logo,
				'type_text'     => sanitize_text_field( $it['type_text'] ?? '' ),
				'fact_1_label'  => sanitize_text_field( $it['fact_1_label'] ?? '' ),
				'fact_1_value'  => sanitize_text_field( $it['fact_1_value'] ?? '' ),
				'fact_2_label'  => sanitize_text_field( $it['fact_2_label'] ?? '' ),
				'fact_2_value'  => sanitize_text_field( $it['fact_2_value'] ?? '' ),
				'link_text'     => sanitize_text_field( $it['link_text'] ?? '' ),
				'link_url'      => esc_url_raw( $it['link_url'] ?? '' ),
			);
		}
	}$out['flagship'] = array(
		'badge' => tolstenko_kses_html( $raw['flagship']['badge'] ?? '' ),
		'title' => tolstenko_kses_html( $raw['flagship']['title'] ?? '' ),
		'cards' => array(),
	);

	if ( isset( $raw['flagship']['cards'] ) && is_array( $raw['flagship']['cards'] ) ) {
		foreach ( $raw['flagship']['cards'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}

			$card_title = tolstenko_kses_html( $it['title'] ?? '' );
			$flag       = isset( $it['flag'] ) ? (int) $it['flag'] : 0;

			if ( $card_title === '' && $flag === 0 ) {
				continue;
			}

			$out['flagship']['cards'][] = array(
				'country'  => sanitize_text_field( $it['country'] ?? '' ),
				'flag'     => $flag,
				'price'    => tolstenko_kses_html( $it['price'] ?? '' ),
				'title'    => $card_title,
				'text'     => tolstenko_kses_html( $it['text'] ?? '' ),
				'facts'    => sanitize_textarea_field( $it['facts'] ?? '' ),
				'btn_text' => tolstenko_kses_html( $it['btn_text'] ?? '' ),
				'btn_url'  => esc_url_raw( $it['btn_url'] ?? '' ),
			);
		}
	}

	$out['europe'] = array(
		'title'     => tolstenko_kses_html( $raw['europe']['title'] ?? '' ),
		'columns'   => array(),
		'rows'      => array(),
		'link_text' => sanitize_text_field( $raw['europe']['link_text'] ?? '' ),
		'link_url'  => esc_url_raw( $raw['europe']['link_url'] ?? '' ),
		'foot_text' => tolstenko_kses_html( $raw['europe']['foot_text'] ?? '' ),
		'btn_text'  => tolstenko_kses_html( $raw['europe']['btn_text'] ?? '' ),
		'btn_url'   => esc_url_raw( $raw['europe']['btn_url'] ?? '' ),
	);

	if ( isset( $raw['europe']['columns'] ) && is_array( $raw['europe']['columns'] ) ) {
		foreach ( $raw['europe']['columns'] as $col ) {
			$out['europe']['columns'][] = tolstenko_kses_html( $col );
		}
	}

	if ( isset( $raw['europe']['rows'] ) && is_array( $raw['europe']['rows'] ) ) {
		foreach ( $raw['europe']['rows'] as $it ) {
			if ( ! is_array( $it ) ) {
				continue;
			}

			$country = sanitize_text_field( $it['country'] ?? '' );
			$flag    = isset( $it['flag'] ) ? (int) $it['flag'] : 0;

			if ( $country === '' && $flag === 0 ) {
				continue;
			}

			$out['europe']['rows'][] = array(
				'country'   => $country,
				'flag'      => $flag,
				'note'      => sanitize_text_field( $it['note'] ?? '' ),
				'price'     => tolstenko_kses_html( $it['price'] ?? '' ),
				'term'      => tolstenko_kses_html( $it['term'] ?? '' ),
				'benefits'  => sanitize_textarea_field( $it['benefits'] ?? '' ),
				'link_text' => sanitize_text_field( $it['link_text'] ?? '' ),
				'link_url'  => esc_url_raw( $it['link_url'] ?? '' ),
			);
		}
	}	// Не затирать дефолты блоков тела статьи (правятся на отдельной странице).
	$prev = get_option( 'tolstenko_block_defaults', array() );
	if ( is_array( $prev ) && function_exists( 'tolstenko_blog_content_defaults_schema' ) ) {
		foreach ( array_keys( tolstenko_blog_content_defaults_schema() ) as $content_key ) {
			if ( isset( $prev[ $content_key ] ) ) {
				$out[ $content_key ] = $prev[ $content_key ];
			}
		}
	}

	// Не затирать видео-пузырь (отдельная страница настроек).
	if ( is_array( $prev ) && isset( $prev['video_bubble'] ) ) {
		$out['video_bubble'] = $prev['video_bubble'];
	}

	update_option( 'tolstenko_block_defaults', $out, false );
}

