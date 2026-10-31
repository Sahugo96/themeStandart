<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Реестр секций «Дефолтов блоков».
 *
 * Каждая секция — папка inc/block-defaults/sections/<ключ>/:
 *   schema.php — дефолтные значения (return array(...));
 *   panel.php  — HTML таба на странице настроек (необязательно);
 *   save.php   — санитизация полей таба при сохранении (необязательно).
 *
 * panel.php и save.php подключаются внутри функций отрисовки и сохранения
 * и видят их переменные: $all (дефолты для формы), $raw (POST) и $out (результат).
 *
 * Чтобы добавить секцию: создать папку и вписать ключ сюда —
 * в нужную группу табов (с подписью) или в 'schema_only'.
 */

/**
 * Группы табов в порядке вывода.
 *
 * @return array<string, array{title: string, tabs: array<string, string>}>
 */
function tolstenko_block_defaults_tab_groups() {
	return array(
		'main' => array(
			'title' => 'Основные блоки',
			'tabs'  => array(
				'field_template' => 'Шаблон всех полей',
			),
		),
		'post_sliders' => array(
			'title' => 'Слайдера записей',
			'tabs'  => array(
				'case_section'            => 'Кейсы',
				'reviews'                 => 'Отзывы',
				'service_section'         => 'Слайдер услуг',
				'service_section_filters' => 'Слайдер услуг (фильтры)',
				'blog_section'            => 'Слайдер статей',
				'blog_section_filters'    => 'Статьи',
			),
		),
		'landing' => array(
			'title' => 'Секции лендинга',
			'tabs'  => array(
				'main_hero'  => 'Главный баннер',
				'result'     => 'Результат',
				'compare'    => 'Сравнение',
				'why_us'     => 'Почему именно мы',
				'infra'      => 'Для клиентов с капиталом и бизнесом',
				'about'      => 'Кратко о нас',
				'guide'      => 'Подробнее',
				'consult'    => 'Начните с бесплатной консультации',
				'documents'  => 'Документы',
				'team'       => 'Команда',
				'faq'        => 'FAQ',
				'hero_stats' => 'Цифры под hero',
				'situations' => 'Ситуации',
				'process'    => 'Как проходит работа',
				'cost'       => 'Стоимость',
				'blog_more'  => 'Кнопка в блог',
				'cases'      => 'Кейсы',
				'programs'   => 'Сравнение программ',
				'banks'      => 'Банки-партнёры',
				'flagship'   => 'Флагманские программы',
				'europe'     => 'ВНЖ в Европе',
				'quiz'       => 'Квиз',
				'seo_section' => 'SEO-наполнение',
			),
		),
	);
}

/**
 * Секции без таба на этой странице (только схема дефолтов).
 * Блоки тела статьи редактируются на отдельной странице (inc/blog/allowed-blocks.php).
 *
 * @return string[]
 */
function tolstenko_block_defaults_schema_only_keys() {
	return array(
		'blog_large_img',
		'blog_video',
		'blog_blockquote',
		'blog_warning',
		'blog_pros_cons',
		'blog_definition',
		'strategy',
		'author',
		'pricing',
	);
}

/**
 * Все ключи секций: сначала табы (в порядке вывода), затем секции только со схемой.
 *
 * @return string[]
 */
function tolstenko_block_defaults_section_keys() {
	$keys = array();
	foreach ( tolstenko_block_defaults_tab_groups() as $group ) {
		$keys = array_merge( $keys, array_keys( $group['tabs'] ) );
	}
	return array_merge( $keys, tolstenko_block_defaults_schema_only_keys() );
}

/**
 * Путь к файлу секции (schema.php, panel.php, save.php) или '' если файла нет.
 *
 * @param string $key  Ключ секции.
 * @param string $file Имя файла.
 * @return string
 */
function tolstenko_block_defaults_section_file( $key, $file ) {
	$path = __DIR__ . '/sections/' . $key . '/' . $file;
	return is_readable( $path ) ? $path : '';
}
