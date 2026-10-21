<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tolstenko_block_defaults_schema() {
	$schema = array(
		'reviews' => array(
			'subtitle'   => '',
			'title'      => 'Отзывы',
			'text'       => '',
			'show_items' => true,
			'ids'        => array(),
			'cards'      => array(),
		),
		'documents' => array(
			'subtitle' => 'Документы',
			'title' => 'Работаем <span>официально</span>',
			'items' => array(
				array( 'image' => 0, 'title' => 'Лицензия DIFC', 'text' => 'Starcompany Consultancies FZE', 'attributes' => 'LICENSE 6502' ),
				array( 'image' => 0, 'title' => 'Регистратор фризон', 'text' => 'Подтверждает статус регистратора', 'attributes' => "ADGM\nDIFC" ),
				array( 'image' => 0, 'title' => 'Сертификаты фризон', 'text' => 'Подтверждает статус регистратора', 'attributes' => '' ),
				array( 'image' => 0, 'title' => 'Партнёрства с банками', 'text' => 'Прямое взаимодействие с банками ОАЭ', 'attributes' => '' ),
				array( 'image' => 0, 'title' => 'Соответствие регулятору', 'text' => 'Работа в рамках требований ОАЭ', 'attributes' => '' ),
			),
		),
		'team' => array(
			'badge' => 'Команда',
			'title' => 'С вами работают <span>реальные эксперты</span>',
			'text' => 'Персональный менеджер ведёт вас от заявки до результата. Вы всегда знаете, с кем говорите.',
		),
		'case_section' => array(
			'subtitle'        => '',
			'title'          => 'Кейсы',
			'text'           => '',
			'posts_per_page' => 4,
			'ids'            => array(),
		),
		'service_section' => array(
			'subtitle'        => '',
			'title'          => 'Услуги',
			'text'           => '',
			'posts_per_page' => 6,
			'ids'            => array(),
		),
		'service_section_filters' => array(
			'subtitle'        => '',
			'title'          => 'Услуги',
			'text'           => '',
			'posts_per_page' => 6,
			'ids'            => array(),
		),
		'blog_section' => array(
			'subtitle'        => '',
			'title'          => 'Похожие статьи',
			'text'           => '',
			'posts_per_page' => 12,
			'ids'            => array(),
		),
		'blog_section_filters' => array(
			'title'          => 'Статьи',
			'text'           => '',
			'posts_per_page' => 4,
			'ids'            => array(),
			'btn_text'       => 'Все статьи',
		),
		'blog_large_img' => array(
			'image' => 0,
		),
		'blog_video' => array(
			'preview' => 0,
			'url'     => '',
			'iframe'  => '',
		),
		'blog_blockquote' => array(
			'text'         => '',
			'link'         => '',
			'show_author'  => false,
			'image'        => 0,
			'author'       => '',
			'author_under' => '',
			'btn_text'     => '',
			'btn_url'      => '',
		),
		'blog_number_list' => array(
			'items' => array(),
		),
		'blog_warning' => array(
			'items' => array(),
		),
		'blog_pros_cons' => array(
			'pros_title' => 'Плюсы',
			'cons_title' => 'Минусы',
			'pros'       => array(),
			'cons'       => array(),
		),
		'blog_definition' => array(
			'mode'   => 'define',
			'kicker' => 'Определение',
			'term'   => 'Продвижение сайта статьями',
			'suffix' => 'способ SEO-продвижения через публикацию полезного контента.',
			'title'  => 'Семантическое ядро',
			'text'   => 'Набор поисковых запросов, по которым пользователи ищут ваш продукт.',
		),
		'blog_seo' => array(
			'title'   => 'Нужна помощь с продвижением?',
			'btn'     => 'Получить консультацию',
			'btn_url' => '',
		),
		'strategy' => array(
			'section_subtitle' => '',
			'title'          => 'Стратегия роста',
			'subtitle'       => 'Что входит в работу',
			'text'           => 'Разрабатываем план продвижения и помогаем внедрить его на практике.',
			'items'          => array(
				'Анализ рынка и конкурентов',
				'Позиционирование и оффер',
				'План каналов и бюджета',
			),
			'btn_text'       => 'Получить стратегию',
			'btn_url'        => '',
			'file_text'      => 'Скачать шаблон',
			'file_url'       => '',
			'contacts_label' => 'Свяжитесь с нами прямо сейчас!',
			'phone'          => '',
			'telegram_url'   => '',
			'telegram_text'  => 'Написать в TG',
			'image'          => 0,
			'image_mob'      => 0,
		),
		'author' => array(
			'name'            => '',
			'photo'           => 0,
			'btn_text'        => '',
			'btn_url'         => '',
			'list'            => array(),
			'items'           => array(),
			'links_label'     => 'Делюсь экспертизой',
			'links'           => array(),
			'show_bottom'     => true,
			'subtitle'        => '',
			'text'            => '',
			'sublist'         => array(),
			'btn_more_text'   => '',
			'btn_more_url'    => '',
			'award'           => '',
			'award_image'     => 0,
			'right_image'     => 0,
			'speeches'        => array(),
			'btn_invite_text' => '',
			'btn_invite_url'  => '',
		),
		'pricing' => array(
			'subtitle' => 'Пакеты продвижения',
			'title'    => 'Сколько стоит <span>продвижение</span>',
			'text'     => 'Единой цены «для всех» нет. Точную стоимость и окупаемость считаем после бесплатного аудита.',
			'items'    => array(
				array(
					'name'     => 'Бизнес-старт',
					'for'      => 'Сайт с историей, 1 регион, старт системной работы',
					'price'    => 'от 150 000 ₽/мес',
					'note'     => 'KPI: рост видимости и первых заявок',
					'badge'    => '',
					'btn_text' => 'Оставить заявку',
					'btn_url'  => '',
					'list'     => array(
						'Аудит, семантика, техническая оптимизация',
						'Базовая оптимизация страниц',
						'Ежемесячная отчётность',
						'Персональный менеджер',
					),
				),
				array(
					'name'     => 'Бизнес-рост',
					'for'      => 'Стабильный поток заявок, несколько направлений',
					'price'    => 'от 200 000 ₽/мес',
					'note'     => 'KPI: заявки + стоимость обращения',
					'badge'    => 'Хит · рекомендуем',
					'btn_text' => 'Обсудить проект',
					'btn_url'  => '',
					'list'     => array(
						'Расширенная семантика и кластеризация',
						'Контент и коммерческие факторы',
						'Персональная стратегия под задачи',
						'Отчётность по заявкам',
					),
				),
				array(
					'name'     => 'Максимум / под ключ',
					'for'      => 'Конкурентные ниши, несколько регионов, амбициозные цели',
					'price'    => 'Индивидуально',
					'note'     => 'KPI: заявки, продажи, доля в поиске',
					'badge'    => '',
					'btn_text' => 'Запросить расчёт',
					'btn_url'  => '',
					'list'     => array(
						'Приоритетная скорость работ',
						'Работа над конверсией сайта',
						'GEO / продвижение в нейросетях',
						'Стратегические сессии',
					),
				),
			),
		),
		'faq' => array(
			'badge'      => 'Частые вопросы',
			'title'      => 'Коротко о главном',
			'items'      => array(
				array(
					'quest'  => 'Сколько занимает изготовление?',
					'unswer' => '<p>Сроки зависят от объёма и сложности задачи. Обычно обсуждаем сроки на консультации.</p>',
				),
				array(
					'quest'  => 'Можно ли заказать только дизайн?',
					'unswer' => '<p>Да, можем выполнить отдельные этапы: дизайн, производство или монтаж.</p>',
				),
			),
			'form_title' => 'Не нашли ответ на свой вопрос?',
			'form_text'  => 'Оставьте заявку — свяжемся и разберём вашу ситуацию.',
			'teammate_id' => 0,
		),
		'result' => array(
			'badge' => 'Результат',
			'title' => 'Что вы получаете',
			'items' => array(
				array(
					'icon' => 0,
					'title' => 'IBAN и счёт',
					'text' => 'Мультивалютный счёт с международными переводами.',
				),
				array(
					'icon' => 0,
					'title' => 'Emirates ID',
					'text' => 'Резидентский статус и спонсорство семьи.',
				),
				array(
					'icon' => 0,
					'title' => 'Карты',
					'text' => 'Дебетовые и кредитные для платежей по миру.',
				),
				array(
					'icon' => 0,
					'title' => 'Компания и лицензия',
					'text' => 'Устав, юр. адрес и корпоративный счёт.',
				),
				array(
					'icon' => 0,
					'title' => 'Доступ к инвестициям',
					'text' => 'Брокерский счёт и верификация на платформах.',
				),
				array(
					'icon' => 0,
					'title' => 'Сопровождение после',
					'text' => 'Помощь с комплаенсом и обслуживанием.',
				),
			),
		),
		'compare' => array(
			'badge' => 'Сравнение',
			'title' => 'Сам, через посредника <span>или напрямую с нами</span>',
			'lead' => "Мы — исполнитель на земле в DIFC.\nПосредник из РФ перепродаёт нашу же работу с наценкой.\nРазница видна по каждому пункту.",
			'th_criterion' => 'Критерий',
			'th_self' => 'Сам',
			'th_mediator' => 'Через посредника',
			'th_us' => 'Напрямую с нами',
			'rows' => array(
				array(
					'criterion' => 'Цена',
					'self' => 'Скрытые расходы',
					'mediator' => '+ наценка посредника',
					'us' => 'Без наценки, от исполнителя',
				),
				array(
					'criterion' => 'Кто оформляет',
					'self' => 'Вы сами',
					'mediator' => 'Перепродаёт исполнителю',
					'us' => 'Мы, напрямую',
				),
				array(
					'criterion' => 'Доступ к банкам',
					'self' => 'Общие условия',
					'mediator' => 'Через третьи руки',
					'us' => 'Свои банкиры, прямые отношения',
				),
				array(
					'criterion' => 'Помощь с комплаенсом',
					'self' => 'Разбираетесь сами',
					'mediator' => 'Обычно не сопровождают',
					'us' => 'Закрываем вопросы комплаенса',
				),
				array(
					'criterion' => 'Сопровождение после',
					'self' => 'Нет',
					'mediator' => 'До открытия счёта',
					'us' => 'Дальнейшая поддержка',
				),
				array(
					'criterion' => 'Ответственность',
					'self' => 'На вас',
					'mediator' => 'Размыта между звеньями',
					'us' => 'Одна команда по договору',
				),
				array(
					'criterion' => 'Скорость и риск отказа',
					'self' => 'Медленно, высокий риск',
					'mediator' => 'Задержки на передаче',
					'us' => 'Быстрее, ниже риск',
				),
			),
			'foot_text' => "Большинство компаний на рынке — посредники.\nВ итоге всё равно приходят к исполнителю.\nТак почему бы не сразу к нам?",
			'btn_text' => 'Начать сотрудничество',
			'btn_url' => '#modal',
		),
		'why_us' => array(
			'badge' => 'Почему именно мы',
			'title' => 'Почему платят нам, <span>а не идут к 10 другим</span>',
			'items' => array(
				array(
					'icon' => 0,
					'title' => 'Экономим ваше время',
					'text' => 'Оформление, документы и переписку с банком берём на себя.',
				),
				array(
					'icon' => 0,
					'title' => 'Паспорт РФ и сложные случаи',
					'text' => 'Открываем там, где другим отказывают — это наша специализация.',
				),
				array(
					'icon' => 0,
					'title' => 'Свои банкиры',
					'text' => 'Прямые отношения с банками ускоряют одобрение и снижают риск отказа.',
				),
				array(
					'icon' => 0,
					'title' => 'Цена ниже рынка',
					'text' => 'Мы исполнитель на земле в DIFC — без наценки посредников.',
				),
				array(
					'icon' => 0,
					'title' => 'Официальный договор',
					'text' => 'Лицензия DIFC 6502 и прозрачные условия — всё по закону.',
				),
				array(
					'icon' => 0,
					'title' => 'Проходим с первого раза',
					'text' => 'Готовим пакет под требования комплаенса — без пересдач и задержек.',
				),
			),
		),
		'infra' => array(
			'badge' => 'Для клиентов с капиталом и бизнесом',
			'title' => 'Нужна не одна услуга, <span>а инфраструктура за пределами РФ</span>',
			'text' => 'Соберём комплексное решение под перевод и владение активами, международные платежи и структуру бизнеса. Конфиденциально, с персональным менеджером.',
			'btn_text' => 'Обсудить конфиденциально',
			'btn_url' => '#contact',
			'items' => array(
				array(
					'text' => 'Регистрация компании за рубежом',
				),
				array(
					'text' => 'Международные платежи',
				),
				array(
					'text' => 'Ведение и сохранность активов',
				),
				array(
					'text' => 'Сопровождение комплаенса',
				),
				array(
					'text' => 'Корпоративный счёт',
				),
				array(
					'text' => 'Офшорные счета и структуры',
				),
				array(
					'text' => 'Налоговое планирование',
				),
				array(
					'text' => 'ВНЖ для бенефициаров',
				),
			),
		),
		'about' => array(
			'badge' => 'Кратко о нас',
			'title' => '<span>Relocate-World —</span> исполнитель в DIFC',
			'text' => '<p>Мы — лицензированный провайдер в финансовом центре Дубая (DIFC). Не посредники: работаем на земле, напрямую с банками и фризонами, поэтому предлагаем цену ниже рынка и беремся за сложные случаи.</p><p>За каждым клиентом — персональный координатор и команда, которая ведёт процесс от заявки до результата и остаётся на связи после.</p>',
			'image' => 0,
			'stats' => array(
				array(
					'num' => '300+',
					'label' => "клиентов\nпо рекомендациям",
				),
				array(
					'num' => '6+',
					'label' => "банков-\nпартнёров",
				),
				array(
					'num' => '6502',
					'label' => "лицензия\nDIFC",
				),
				array(
					'num' => '~20',
					'label' => "специалистов\nв команде",
				),
			),
		),
		'guide' => array(
			'subtitle' => 'Подробнее',
			'title' => 'Банковские счета,<span>ВНЖ и компании в ОАЭ</span>',
			'tags' => array(
				array( 'text' => 'Счета' ),
				array( 'text' => 'ОАЭ' ),
			),
			'time' => '10 мин',
			'views' => '234',
			'date' => '2026-07-19',
			'date_label' => '19 июля 2026',
			'card_title' => 'Почему ОАЭ',
			'text' => '<p>Объединённые Арабские Эмираты — одна из самых устойчивых финансовых юрисдикций мира с нулевым личным подоходным налогом и развитой банковской системой под контролем Центрального банка ОАЭ. Резидентский статус открывает доступ к международным сервисам, а компания во фризоне позволяет вести бизнес со 100% иностранным владением.</p><p>Relocate-World помогает пройти этот путь без ошибок: подбираем банк и программу под ваш профиль, готовим документы под требования комплаенса и сопровождаем до результата.</p>',
			'btn_text' => 'Читать полностью',
			'image' => 0,
			'post_id' => 0,
		),
		'consult' => array(
			'badge' => 'Начните с бесплатной консультации',
			'title' => "Разбор вашей ситуации\nи решение <span>— бесплатно</span>",
			'text' => 'Оставьте номер — перезвоним, зададим пару вопросов и подберём решение под вашу задачу: счёт, ВНЖ или компанию.',
			'contact_label' => 'Или напишите нам:',
			'phone' => '+971 55 435 2459',
			'input_placeholder' => 'Ваш телефон или телеграм',
			'btn_text' => 'Получить консультацию',
			'consents' => array(
				array(
					'text' => 'Согласен с',
					'link_text' => 'политикой конфиденциальности',
					'link_url' => '/privacy-policy/',
				),
				array(
					'text' => 'Согласен с',
					'link_text' => 'обработкой данных',
					'link_url' => '/personal-data/',
				),
			),
			'image' => 0,
		),
		'hero_stats' => array(
			'items' => array(
				array( 'num' => 'От 2 недель', 'label' => 'срок открытия счёта' ),
				array( 'num' => 'От 6 500$', 'label' => 'ВНЖ ОАЭ «под ключ»' ),
				array( 'num' => '300+', 'label' => 'клиентов по рекомендациям' ),
				array( 'num' => '6+', 'label' => 'банков-партнёров' ),
			),
		),
		'situations' => array(
			'badge'        => 'Знакомо?',
			'title'        => 'Ситуации, с которыми <span>к нам приходят</span>',
			'items'        => array(
				array( 'title' => 'Банк в ЕС закрыл счёт из-за паспорта РФ', 'text' => 'Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span>' ),
				array( 'title' => 'Продал недвижимость в Европе', 'text' => 'Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span>' ),
				array( 'title' => 'Не могу принять оплату от клиента', 'text' => 'Международный счёт: <span>личный или на компанию.</span>' ),
				array( 'title' => 'Хочу переехать всей семьёй', 'text' => 'ВНЖ, спонсорство и прочие услуги <span>для супруга и детей.</span>' ),
				array( 'title' => 'Паспорт РФ не пускает на биржи', 'text' => 'Emirates ID верифицирует <span>везде, где принимается.</span>' ),
				array( 'title' => 'Нужна компания на зарубежные рынки', 'text' => 'Фризона за 1–4 недели. <span>Со 100% владением.</span>' ),
				array( 'title' => 'Банк закрыл счёт за границей', 'text' => 'Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span>' ),
				array( 'title' => 'Продал бизнес в Азии', 'text' => 'Откроем счёт в ОАЭ. Всем. <span>В том числе нерезиденту.</span>' ),
			),
		),
		'process' => array(
			'badge'        => 'Как проходит работа',
			'title'        => 'Мы проходим с вами <span>каждый этап</span>',
			'image'        => 0,
			'items'        => array(
				array( 'title' => 'Подготовительный этап', 'text' => '<p>За вами закрепляется персональный координатор.</p><p>Проводим KYC-бриф: анализируем гражданство, профиль и задачи. Подбираем решение: счёт, ВНЖ или структуру.</p><p>Проверяем документы и устраняем несоответствия.</p>' ),
				array( 'title' => 'Подготовка и подача', 'text' => '<p>Готовим пакет документов под требования банка или фризоны и подаём заявку.</p>' ),
				array( 'title' => 'Комплаенс и подготовление', 'text' => '<p>Отвечаем на запросы комплаенса и сопровождаем созвоны с банком.</p>' ),
				array( 'title' => 'Результат и сопровождение', 'text' => '<p>Передаём счёт, карты и документы и остаёмся на связи после открытия.</p>' ),
			),
		),
		'cost' => array(
			'badge'        => 'Стоимость',
			'title'        => '<span>Сколько стоит</span> решить задачу в ОАЭ',
			'lead'         => 'Точная цена зависит от услуги, программы и объёма сопровождения.<br>Ниже ориентиры.',
			'prices'       => array(
				array( 'name' => 'Банковский счёт', 'value' => '<small>от</small> $ –' ),
				array( 'name' => 'ВНЖ ОАЭ', 'value' => '<small>от</small> $ 6 500' ),
				array( 'name' => 'Компания', 'value' => '<small>от</small> $ –' ),
				array( 'name' => 'Виза фрилансера', 'value' => '<small>от</small> $ 9 500' ),
			),
			'card_title'   => 'Рассчитаем стоимость<br>под вашу задачу',
			'card_text'    => 'Пришлём персональную смету со всеми сопутствующими расходами и сборами — ещё до консультации.',
			'btn_text'     => 'Получить расчёт',
			'btn_url'      => '#modal',
			'image'        => 0,
			'links'        => array(
				array( 'icon_id' => THEME_PATH . '/assets/img/WA Icon.svg', 'title' => 'WhatsApp', 'link' => '#' ),
				array( 'icon_id' => THEME_PATH . '/assets/img/TG Icon.svg', 'title' => 'Telegram', 'link' => '#' ),
			),
		),
		'blog_more' => array(
			'text' => 'Перейти в блог',
			'url'  => '/blog/',
		),
		'field_template' => array(
			'enabled'       => false,
			'text_field'     => '',
			'textarea_field' => '',
			'editor_field'   => '<p>Пример текста в визуальном редакторе.</p>',
			'image'          => 0,
			'post_ids'       => array(),
			'single_post_id' => 0,
			'items'          => array(
				array(
					'title'    => 'Пример пункта повторителя',
					'text'     => 'Текстовая область внутри пункта.',
				),
			),
		),
	);

	return $schema;
}

/**
 * ID одиночной записи нужного типа (иначе 0).
 */
function tolstenko_landing_sanitize_post_id( $raw, $post_type ) {
	$id = (int) $raw;
	return ( $id > 0 && get_post_type( $id ) === $post_type ) ? $id : 0;
}

/**
 * Нормализация ID записей для слайдеров.
 */
function tolstenko_sanitize_ids( $raw ) {
	$ids = array();
	if ( is_string( $raw ) ) {
		$raw = preg_split( '/[\s,]+/', $raw, -1, PREG_SPLIT_NO_EMPTY );
	}
	if ( ! is_array( $raw ) ) {
		return array();
	}
	foreach ( $raw as $id ) {
		$id = (int) $id;
		if ( $id > 0 ) {
			$ids[] = $id;
		}
	}
	return array_values( array_unique( $ids ) );
}

/**
 * Получение списка записей для select2-подобного поля.
 */
function tolstenko_get_posts_for_select( $post_type ) {
	$posts = get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);
	$result = array();
	foreach ( $posts as $post ) {
		$result[] = array(
			'id'    => $post->ID,
			'title' => get_the_title( $post ),
		);
	}
	return $result;
}

/**
 * Рендер поля мультивыбора записей (как в Gutenberg).
 *
 * @param string               $name         Имя input (без []).
 * @param int[]|mixed          $selected_ids Выбранные ID.
 * @param string               $post_type    CPT.
 * @param string               $label        Подпись над полем.
 * @param array<string,mixed>  $args         exclude_ids, placeholder.
 */
function tolstenko_render_post_select( $name, $selected_ids, $post_type, $label = '', $args = array() ) {
	$args         = is_array( $args ) ? $args : array();
	$exclude_ids  = array_map( 'intval', (array) ( $args['exclude_ids'] ?? array() ) );
	$exclude_ids  = array_values( array_filter( $exclude_ids ) );
	$all_posts    = tolstenko_get_posts_for_select( $post_type );
	if ( $exclude_ids ) {
		$all_posts = array_values(
			array_filter(
				$all_posts,
				static function ( $p ) use ( $exclude_ids ) {
					return ! in_array( (int) ( $p['id'] ?? 0 ), $exclude_ids, true );
				}
			)
		);
	}
	$selected_ids = array_map( 'intval', (array) $selected_ids );
	$selected_ids = array_values( array_filter( $selected_ids, static function ( $id ) use ( $exclude_ids ) {
		return $id > 0 && ! in_array( $id, $exclude_ids, true );
	} ) );

	$placeholders = array(
		'service' => 'Поиск услуг...',
		'blog'    => 'Поиск статей...',
		'case'    => 'Поиск кейсов...',
		'review'  => 'Поиск отзывов...',
		'actions' => 'Поиск акций...',
	);
	$placeholder = (string) ( $args['placeholder'] ?? '' );
	if ( $placeholder === '' ) {
		$placeholder = $placeholders[ $post_type ] ?? ( 'Поиск ' . $post_type . '...' );
	}

	$posts_json = wp_json_encode( $all_posts, JSON_UNESCAPED_UNICODE );
	if ( ! is_string( $posts_json ) ) {
		$posts_json = '[]';
	}
	?>
	<div class="tolstenko-post-select-wrap">
		<?php if ( $label ) : ?>
			<div class="muted" style="margin-bottom:6px;"><?php echo esc_html( $label ); ?></div>
		<?php endif; ?>
		<div
			class="tolstenko-post-select-token-field"
			data-name="<?php echo esc_attr( $name ); ?>"
			data-post-type="<?php echo esc_attr( $post_type ); ?>"
			data-posts="<?php echo esc_attr( $posts_json ); ?>"
		>
			<div class="tolstenko-post-select-tokens">
				<?php foreach ( $selected_ids as $id ) : ?>
					<?php
					$title = '';
					foreach ( $all_posts as $p ) {
						if ( (int) $p['id'] === $id ) {
							$title = (string) $p['title'];
							break;
						}
					}
					if ( ! $title ) {
						$title = get_the_title( $id );
						$title = $title !== '' ? $title : ( '#' . $id );
					}
					?>
					<span class="tolstenko-post-select-token" data-id="<?php echo (int) $id; ?>">
						<span class="tolstenko-post-select-token-label"><?php echo esc_html( $title ); ?></span>
						<button type="button" class="tolstenko-post-select-token-remove" title="Удалить">×</button>
						<input type="hidden" name="<?php echo esc_attr( $name ); ?>[]" value="<?php echo (int) $id; ?>">
					</span>
				<?php endforeach; ?>
			</div>
			<div class="tolstenko-post-select-input-wrap">
				<input type="text" class="tolstenko-post-select-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off">
				<div class="tolstenko-post-select-suggestions" style="display:none;"></div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * CSS + JS для tolstenko_render_post_select (один раз за запрос).
 */
function tolstenko_post_select_print_assets() {
	static $printed = false;
	if ( $printed ) {
		return;
	}
	$printed = true;
	?>
	<style>
		.tolstenko-post-select-wrap{border:1px solid #dcdcde;border-radius:4px;padding:8px;background:#fff;width:100%;box-sizing:border-box}
		.tolstenko-post-select-tokens{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:8px}
		.tolstenko-post-select-tokens:empty{display:none;margin:0}
		.tolstenko-post-select-token{display:inline-flex;align-items:center;background:#e5e5e5;border-radius:3px;padding:4px 8px;gap:6px;font-size:13px;max-width:100%}
		.tolstenko-post-select-token-label{overflow:hidden;text-overflow:ellipsis}
		.tolstenko-post-select-token-remove{background:none;border:none;color:#b32d2e;cursor:pointer;font-size:18px;line-height:1;padding:0 2px;flex-shrink:0}
		.tolstenko-post-select-token-remove:hover{color:#7b1a1b}
		.tolstenko-post-select-input-wrap{position:relative}
		.tolstenko-post-select-input{width:100%;max-width:none !important;padding:6px 8px;border:1px solid #ddd;border-radius:3px;box-sizing:border-box}
		.tolstenko-post-select-suggestions{position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #ddd;border-radius:3px;max-height:240px;overflow:auto;z-index:100000;box-shadow:0 2px 6px rgba(0,0,0,0.15)}
		.tolstenko-post-select-suggestions .suggestion{padding:6px 10px;cursor:pointer}
		.tolstenko-post-select-suggestions .suggestion:hover{background:#f0f0f0}
	</style>
	<script>
	(function(){
		function stripHtml(s){
			var d = document.createElement('div');
			d.innerHTML = String(s || '');
			return (d.textContent || d.innerText || '').trim();
		}
		function initPostSelect() {
			document.querySelectorAll('.tolstenko-post-select-token-field').forEach(function(wrap) {
				if (wrap.dataset.initialized) return;
				wrap.dataset.initialized = '1';
				var input = wrap.querySelector('.tolstenko-post-select-input');
				var suggestions = wrap.querySelector('.tolstenko-post-select-suggestions');
				var tokensContainer = wrap.querySelector('.tolstenko-post-select-tokens');
				var name = wrap.dataset.name;
				var postType = wrap.dataset.postType || '';
				if (!input || !suggestions || !tokensContainer || !name) return;

				var allPosts = [];
				var isLoading = false;
				var isLoaded = false;

				try {
					if (wrap.hasAttribute('data-posts')) {
						var embedded = JSON.parse(wrap.getAttribute('data-posts') || '[]');
						if (Array.isArray(embedded)) {
							allPosts = embedded.map(function(p){
								return { id: parseInt(p.id, 10), title: stripHtml(p.title) || ('#' + p.id) };
							}).filter(function(p){ return p.id > 0; });
							suggestions.dataset.posts = JSON.stringify(allPosts);
							isLoaded = true;
						}
					}
				} catch (e) {}

				function loadAllPosts(cb) {
					if (isLoaded) { if (cb) cb(); return; }
					if (isLoading) return;
					isLoading = true;

					var existingIds = {};
					tokensContainer.querySelectorAll('.tolstenko-post-select-token').forEach(function(token) {
						var id = parseInt(token.dataset.id, 10);
						existingIds[id] = true;
						allPosts.push({
							id: id,
							title: stripHtml(token.querySelector('.tolstenko-post-select-token-label').textContent)
						});
					});

					if (!postType) {
						isLoaded = true;
						isLoading = false;
						suggestions.dataset.posts = JSON.stringify(allPosts);
						if (cb) cb();
						return;
					}

					var restRoot = (window.wpApiSettings && wpApiSettings.root) ? wpApiSettings.root : '/wp-json/';
					fetch(restRoot + 'wp/v2/' + postType + '?per_page=100&status=publish&_fields=id,title')
						.then(function(res) { return res.json(); })
						.then(function(data) {
							if (!Array.isArray(data)) data = [];
							data.forEach(function(post) {
								if (!existingIds[post.id]) {
									allPosts.push({ id: post.id, title: stripHtml(post.title && post.title.rendered) || ('#' + post.id) });
								}
							});
							allPosts.sort(function(a, b) { return a.title.localeCompare(b.title, 'ru'); });
							suggestions.dataset.posts = JSON.stringify(allPosts);
							isLoaded = true;
							isLoading = false;
							if (cb) cb();
						})
						.catch(function() {
							isLoaded = true;
							isLoading = false;
							suggestions.dataset.posts = JSON.stringify(allPosts);
							if (cb) cb();
						});
				}

				function getSelectedIds() {
					var ids = [];
					tokensContainer.querySelectorAll('.tolstenko-post-select-token').forEach(function(token) {
						ids.push(parseInt(token.dataset.id, 10));
					});
					return ids;
				}

				function showSuggestions(filter) {
					var posts = [];
					try { posts = JSON.parse(suggestions.dataset.posts || '[]'); } catch (e) { posts = []; }
					var selectedIds = getSelectedIds();
					var query = (filter || '').toLowerCase().trim();
					var filtered = posts.filter(function(p) {
						if (selectedIds.indexOf(p.id) !== -1) return false;
						if (query) return String(p.title || '').toLowerCase().indexOf(query) !== -1;
						return true;
					});

					if (filtered.length === 0) {
						suggestions.style.display = 'none';
						return;
					}

					suggestions.innerHTML = '';
					filtered.forEach(function(post) {
						var div = document.createElement('div');
						div.className = 'suggestion';
						div.textContent = post.title;
						div.dataset.id = post.id;
						div.addEventListener('mousedown', function(e) {
							e.preventDefault();
							addToken(post.id, post.title);
							input.value = '';
							showSuggestions('');
						});
						suggestions.appendChild(div);
					});
					suggestions.style.display = 'block';
				}

				function addToken(id, title) {
					var existing = tokensContainer.querySelector('.tolstenko-post-select-token[data-id="' + id + '"]');
					if (existing) return;
					var token = document.createElement('span');
					token.className = 'tolstenko-post-select-token';
					token.dataset.id = String(id);
					token.innerHTML = '<span class="tolstenko-post-select-token-label"></span>' +
						'<button type="button" class="tolstenko-post-select-token-remove" title="Удалить">×</button>' +
						'<input type="hidden" name="' + name + '[]" value="' + id + '">';
					token.querySelector('.tolstenko-post-select-token-label').textContent = title;
					tokensContainer.appendChild(token);
					token.querySelector('.tolstenko-post-select-token-remove').addEventListener('click', function() {
						token.remove();
						if (document.activeElement === input) showSuggestions(input.value);
					});
				}

				input.addEventListener('focus', function() {
					loadAllPosts(function(){ showSuggestions(input.value); });
				});
				input.addEventListener('input', function() {
					loadAllPosts(function(){ showSuggestions(input.value); });
				});
				input.addEventListener('blur', function() {
					setTimeout(function(){ suggestions.style.display = 'none'; }, 180);
				});
				document.addEventListener('click', function(e) {
					if (!wrap.contains(e.target)) suggestions.style.display = 'none';
				});
				tokensContainer.querySelectorAll('.tolstenko-post-select-token-remove').forEach(function(btn) {
					btn.addEventListener('click', function() {
						btn.closest('.tolstenko-post-select-token').remove();
						if (document.activeElement === input) showSuggestions(input.value);
					});
				});
			});
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initPostSelect);
		} else {
			initPostSelect();
		}
		if (window.MutationObserver) {
			new MutationObserver(function(){ initPostSelect(); }).observe(document.body, { childList: true, subtree: true });
		}
		window.tolstenkoInitPostSelect = initPostSelect;
	})();
	</script>
	<?php
}

/**
 * Нормализация ID услуг в дефолтах слайдера.
 *
 * @param mixed $raw Сырые ID (массив или строка).
 * @return int[]
 */
function tolstenko_sanitize_service_section_ids( $raw ) {
	return tolstenko_sanitize_ids( $raw );
}

/**
 * Поля дефолтов для слайдера услуг (обычный / с фильтрами).
 */
function tolstenko_render_service_section_defaults_fields( $key, $data ) {
	$key  = sanitize_key( $key );
	$data = is_array( $data ) ? $data : array();
	$ids  = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
	?>
	<div class="row"><input type="text" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][subtitle]" value="<?php echo esc_attr( $data['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $data['title'] ?? '' ); ?></textarea></div>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $data['text'] ?? '' ); ?></textarea></div>
	<div class="row"><input type="number" min="-1" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][posts_per_page]" value="<?php echo esc_attr( (string) ( $data['posts_per_page'] ?? 6 ) ); ?>" style="width:100%" placeholder="Количество услуг, если ничего не выбрано (6, -1 = все)"></div>
	<div class="row">
		<?php tolstenko_render_post_select( 
			'tolstenko_block_defaults[' . $key . '][ids]',
			$ids,
			'service',
			'Услуги (пусто = самые новые по количеству выше)'
		); ?>
	</div>
	<?php
}

/**
 * Поля дефолтов для слайдера статей.
 */
function tolstenko_render_blog_section_defaults_fields( $key, $data ) {
	$key  = sanitize_key( $key );
	$data = is_array( $data ) ? $data : array();
	$ids  = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
	?>
	<?php if ( $key === 'blog_section' ) : ?>
	<div class="row"><input type="text" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][subtitle]" value="<?php echo esc_attr( $data['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
	<?php endif; ?>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $data['title'] ?? '' ); ?></textarea></div>
	<div class="row"><textarea name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $data['text'] ?? '' ); ?></textarea></div>
	<div class="row"><input type="number" min="-1" name="tolstenko_block_defaults[<?php echo esc_attr( $key ); ?>][posts_per_page]" value="<?php echo esc_attr( (string) ( $data['posts_per_page'] ?? 6 ) ); ?>" style="width:100%" placeholder="Количество статей, если ничего не выбрано (6, -1 = все)"></div>
	<div class="row">
		<?php tolstenko_render_post_select( 
			'tolstenko_block_defaults[' . $key . '][ids]',
			$ids,
			'blog',
			'Статьи (пусто = самые новые по количеству выше)'
		); ?>
	</div>
	<?php
}

/**
 * Список ли это (0..n), а не ассоциативный массив полей.
 */
function tolstenko_is_list_array( $value ) {
	if ( ! is_array( $value ) ) {
		return false;
	}
	if ( array() === $value ) {
		return true;
	}
	return array_keys( $value ) === range( 0, count( $value ) - 1 );
}

/**
 * Склейка схемы и сохранённых дефолтов.
 */
function tolstenko_merge_block_defaults_data( $base, $saved ) {
	if ( ! is_array( $base ) ) {
		$base = array();
	}
	if ( ! is_array( $saved ) ) {
		return $base;
	}

	// Пустое значение в сохранённых данных = «поле не заполнено»:
	// не затираем непустой дефолт из схемы (иначе секции с пустыми
	// сохранёнными полями/списками перестают выводиться).
	foreach ( $saved as $saved_key => $saved_value ) {
		if ( ! array_key_exists( $saved_key, $base ) ) {
			continue;
		}

		$base_value = $base[ $saved_key ];

		// Пустая строка vs непустая строка в схеме.
		if ( is_string( $saved_value ) ) {
			if ( trim( $saved_value ) === '' && is_string( $base_value ) && trim( $base_value ) !== '' ) {
				unset( $saved[ $saved_key ] );
			}

			continue;
		}

		// Пустой список vs непустой список в схеме.
		if ( is_array( $saved_value ) && empty( $saved_value ) && is_array( $base_value ) && ! empty( $base_value ) ) {
			unset( $saved[ $saved_key ] );
		}
	}

	$data = array_replace_recursive( $base, $saved );
	foreach ( $saved as $key => $value ) {
		if ( ! is_array( $value ) ) {
			continue;
		}
		$base_val = $base[ $key ] ?? null;
		if ( tolstenko_is_list_array( $value ) && ( null === $base_val || tolstenko_is_list_array( $base_val ) ) ) {
			$data[ $key ] = $value;
			continue;
		}
		if ( is_array( $base_val ) && ! tolstenko_is_list_array( $base_val ) && ! tolstenko_is_list_array( $value ) ) {
			$data[ $key ] = tolstenko_merge_block_defaults_data( $base_val, $value );
		}
	}
	return $data;
}

/**
 * Смержить сохранённые дефолты поверх схемы для набора ключей.
 *
 * @param string[] $keys Ключи блоков.
 * @return array<string, array>
 */
function tolstenko_get_merged_defaults_for_keys( $keys ) {
	$schema = function_exists( 'tolstenko_block_defaults_schema' ) ? tolstenko_block_defaults_schema() : array();
	$saved  = get_option( 'tolstenko_block_defaults', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$all = array();
	foreach ( $keys as $key ) {
		$base = isset( $schema[ $key ] ) && is_array( $schema[ $key ] ) ? $schema[ $key ] : array();
		$cur  = isset( $saved[ $key ] ) && is_array( $saved[ $key ] ) ? $saved[ $key ] : array();
		$all[ $key ] = function_exists( 'tolstenko_merge_block_defaults_data' )
			? tolstenko_merge_block_defaults_data( $base, $cur )
			: array_replace_recursive( $base, $cur );
	}
	return $all;
}


function tolstenko_get_block_defaults( $block ) {
	$schema = tolstenko_block_defaults_schema();
	$base = isset( $schema[ $block ] ) ? $schema[ $block ] : array();
	$saved = get_option( 'tolstenko_block_defaults', array() );
	if ( ! is_array( $saved ) || ! isset( $saved[ $block ] ) || ! is_array( $saved[ $block ] ) ) {
		if ( $block === 'service_section_filters' && is_array( $saved ) && isset( $saved['service_section'] ) && is_array( $saved['service_section'] ) ) {
			$data = tolstenko_merge_block_defaults_data( $base, $saved['service_section'] );
			$data['ids'] = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
			return $data;
		}
		return $base;
	}
	$data = tolstenko_merge_block_defaults_data( $base, $saved[ $block ] );
	if ( $block === 'service_section' || $block === 'service_section_filters' || $block === 'blog_section' || $block === 'blog_section_filters' || $block === 'case_section' || $block === 'reviews' ) {
		$data['ids'] = tolstenko_sanitize_service_section_ids( $data['ids'] ?? array() );
	}
	return $data;
}

add_action( 'admin_menu', 'tolstenko_register_block_defaults_admin_page' );
add_action( 'admin_enqueue_scripts', 'tolstenko_block_defaults_admin_assets' );

function tolstenko_register_block_defaults_admin_page() {
	add_menu_page(
		__( 'Настройки сайта', 'tolstenko-theme' ),
		__( 'Настройки сайта', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-site-settings',
		'tolstenko_render_block_defaults_admin_page',
		'dashicons-admin-generic',
		58
	);
	add_submenu_page(
		'tolstenko-site-settings',
		__( 'Дефолты блоков', 'tolstenko-theme' ),
		__( 'Дефолты блоков', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-site-settings',
		'tolstenko_render_block_defaults_admin_page'
	);
}

function tolstenko_block_defaults_admin_assets( $hook ) {
	if ( $hook !== 'toplevel_page_tolstenko-site-settings' ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_editor();
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'wp-components' );
}

/**
 * Визуальный редактор ответа FAQ в дефолтах блоков.
 */
function tolstenko_faq_answer_editor( $content, $idx ) {
	$idx       = (int) $idx;
	$editor_id = 'tolstenko_faq_redactor_' . $idx;
	wp_editor(
		(string) $content,
		$editor_id,
		array(
			'textarea_name' => 'tolstenko_block_defaults[faq][items][' . $idx . '][unswer]',
			'textarea_rows' => 8,
			'media_buttons' => true,
			'teeny'         => false,
			'quicktags'     => true,
			'editor_height' => 180,
		)
	);
}

/**
 * Универсальный визуальный редактор (rich text) для шаблона полей в дефолтах блоков.
 *
 * @param string $content       HTML-содержимое редактора.
 * @param string $editor_id     Уникальный id редактора (tinymce/quicktags).
 * @param string $textarea_name Значение атрибута name у textarea.
 */
function tolstenko_field_template_editor( $content, $editor_id, $textarea_name ) {
	wp_editor(
		(string) $content,
		(string) $editor_id,
		array(
			'textarea_name' => $textarea_name,
			'textarea_rows' => 8,
			'media_buttons' => true,
			'teeny'         => false,
			'quicktags'     => true,
			'editor_height' => 180,
		)
	);
}

function tolstenko_render_block_defaults_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['tolstenko_block_defaults_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_block_defaults_nonce'] ) ), 'tolstenko_block_defaults_save' ) ) {
		tolstenko_save_block_defaults_from_request();
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Дефолты блоков сохранены.', 'tolstenko-theme' ) . '</p></div>';
	}

	$all = tolstenko_block_defaults_schema();
	$saved = get_option( 'tolstenko_block_defaults', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	foreach ( $saved as $block_key => $block_saved ) {
		if ( ! is_array( $block_saved ) ) {
			continue;
		}
		$base_block = isset( $all[ $block_key ] ) && is_array( $all[ $block_key ] ) ? $all[ $block_key ] : array();
		$all[ $block_key ] = tolstenko_merge_block_defaults_data( $base_block, $block_saved );
	}
	if ( empty( $all['documents']['items'] ) || ! is_array( $all['documents']['items'] ) ) {
		$all['documents']['items'] = array();
	}
	?>
	<div class="wrap">
	<h1><?php esc_html_e( 'Настройки сайта: дефолты блоков', 'tolstenko-theme' ); ?></h1>
	<form method="post" action="">
	<?php wp_nonce_field( 'tolstenko_block_defaults_save', 'tolstenko_block_defaults_nonce' ); ?>
	<p class="description"><?php esc_html_e( 'Редактируйте дефолтные значения блоков. Они используются, когда у конкретной страницы/блока нет своих значений.', 'tolstenko-theme' ); ?></p>
	<style>
	.tolstenko-df-tabs{display:flex;flex-wrap:wrap;gap:0;border-bottom:1px solid #dcdcde;margin-top:8px}
	.tolstenko-df-tabs-group{margin-top:20px;padding:14px;background:#fff;border:1px solid #dcdcde;border-radius:4px}
	.tolstenko-df-tabs-group.is-active{border-color:#2271b1;box-shadow:0 0 0 1px #2271b1}
	.tolstenko-df-tabs-group-title{margin:0;font-size:14px;font-weight:600;color:#1d2327}
	.tolstenko-df-tab{border:1px solid #dcdcde;border-bottom:0;background:#f0f0f1;padding:8px 12px;cursor:pointer;margin:0 4px 0 0;border-radius:4px 4px 0 0}
	.tolstenko-df-tab.active{background:#fff;font-weight:600;color:#1d2327;position:relative;z-index:1}
	.tolstenko-df-group-panels{border:1px solid #dcdcde;border-top:0;background:#fff;min-height:0}
	.tolstenko-df-group-panels:empty{display:none}
	.tolstenko-df-panel{display:none;padding:14px}
	.tolstenko-df-panel.active{display:block}
	.tolstenko-df .row{margin:10px 0}
	.tolstenko-df textarea{width:100%}
	.tolstenko-df .repeater-item{padding:10px;border:1px solid #ddd;background:#fafafa;margin-bottom:8px}
	.tolstenko-df .repeater-item .cols{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
	.tolstenko-df .repeater-item .cols input[type="text"]{flex:1 1 220px}
	.tolstenko-df .repeater-item .cols .move-btn{min-width:34px;padding:0 8px}
	.tolstenko-df .muted{font-size:12px;color:#666}
	.tolstenko-df .actions{margin-top:12px;display:flex;gap:8px}
	.tolstenko-df .icon-preview img{max-width:44px;max-height:44px;display:block}
	.tolstenko-df .cert-preview img{max-width:80px;max-height:110px;display:block;object-fit:cover;border-radius:4px}
	.tolstenko-df .field-template-preview img{max-width:240px;max-height:330px;display:block;object-fit:cover;border-radius:4px}
	.tolstenko-df .tolstenko-defaults-image-row{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
	.tolstenko-df .tolstenko-faq-editor-wrap .wp-editor-wrap{width:100%}
	.tolstenko-df .tolstenko-faq-editor-wrap .wp-editor-area{width:100%}
	.tolstenko-df .repeater-item .repeater-item{margin-top:8px;background:#f5f5f5}
	</style>
	<?php tolstenko_post_select_print_assets(); ?>
	<div class="tolstenko-df">
		<div class="tolstenko-df-tabs-group is-active" data-group="main">
			<div class="tolstenko-df-tabs-group-title"><?php esc_html_e( 'Основные блоки', 'tolstenko-theme' ); ?></div>
			<div class="tolstenko-df-tabs">
				<button type="button" class="tolstenko-df-tab active" data-panel="field_template" data-group="main"><?php esc_html_e( 'Шаблон всех полей', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="tolstenko-df-group-panels" data-group-panels="main"></div>
		</div>
		<div class="tolstenko-df-tabs-group" data-group="post_sliders">
			<div class="tolstenko-df-tabs-group-title"><?php esc_html_e( 'Слайдера записей', 'tolstenko-theme' ); ?></div>
			<div class="tolstenko-df-tabs">
				<button type="button" class="tolstenko-df-tab" data-panel="case_section" data-group="post_sliders"><?php esc_html_e( 'Кейсы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="reviews" data-group="post_sliders"><?php esc_html_e( 'Отзывы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="service_section" data-group="post_sliders"><?php esc_html_e( 'Слайдер услуг', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="service_section_filters" data-group="post_sliders"><?php esc_html_e( 'Слайдер услуг (фильтры)', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="blog_section" data-group="post_sliders"><?php esc_html_e( 'Слайдер статей', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="blog_section_filters" data-group="post_sliders"><?php esc_html_e( 'Статьи', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="tolstenko-df-group-panels" data-group-panels="post_sliders"></div>
		</div>

		<div class="tolstenko-df-tabs-group" data-group="landing">
			<div class="tolstenko-df-tabs-group-title"><?php esc_html_e( 'Секции лендинга', 'tolstenko-theme' ); ?></div>
			<div class="tolstenko-df-tabs">
				<button type="button" class="tolstenko-df-tab" data-panel="result" data-group="landing"><?php esc_html_e( 'Результат', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="compare" data-group="landing"><?php esc_html_e( 'Сравнение', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="why_us" data-group="landing"><?php esc_html_e( 'Почему именно мы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="infra" data-group="landing"><?php esc_html_e( 'Для клиентов с капиталом и бизнесом', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="about" data-group="landing"><?php esc_html_e( 'Кратко о нас', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="guide" data-group="landing"><?php esc_html_e( 'Подробнее', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="consult" data-group="landing"><?php esc_html_e( 'Начните с бесплатной консультации', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="documents" data-group="landing"><?php esc_html_e( 'Документы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="team" data-group="landing"><?php esc_html_e( 'Команда', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="faq" data-group="landing"><?php esc_html_e( 'FAQ', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="hero_stats" data-group="landing"><?php esc_html_e( 'Цифры под hero', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="situations" data-group="landing"><?php esc_html_e( 'Ситуации', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="process" data-group="landing"><?php esc_html_e( 'Как проходит работа', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="cost" data-group="landing"><?php esc_html_e( 'Стоимость', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="blog_more" data-group="landing"><?php esc_html_e( 'Кнопка в блог', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="tolstenko-df-group-panels" data-group-panels="landing"></div>
		</div>

		<div class="tolstenko-df-panels-source">

		<div class="tolstenko-df-panel" data-panel="reviews" data-group="post_sliders">
			<?php
			$rv      = $all['reviews'] ?? array();
			$rv_ids  = isset( $rv['ids'] ) && is_array( $rv['ids'] ) ? array_map( 'intval', $rv['ids'] ) : array();
			$rv_cards = isset( $rv['cards'] ) && is_array( $rv['cards'] ) ? $rv['cards'] : array();
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[reviews][subtitle]" value="<?php echo esc_attr( $rv['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[reviews][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $rv['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[reviews][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $rv['text'] ?? '' ); ?></textarea></div>
			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[reviews][show_items]" value="1" <?php checked( ! empty( $rv['show_items'] ) ); ?>>
					<?php esc_html_e( 'Показывать блок рейтингов (reviews__items)', 'tolstenko-theme' ); ?>
				</label>
			</div>
			<div class="row">
				<?php tolstenko_render_post_select( 
					'tolstenko_block_defaults[reviews][ids]',
					$rv_ids,
					'review',
					'Отзывы (пусто = все)'
				); ?>
			</div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Карточки рейтингов (reviews__items)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="reviews-cards-list">
					<?php foreach ( $rv_cards as $idx => $card ) : ?>
						<?php
						$card    = is_array( $card ) ? $card : array();
						$c_title = (string) ( $card['title'] ?? '' );
						$c_url   = (string) ( $card['url'] ?? '' );
						$c_rating = isset( $card['rating'] ) ? (int) $card['rating'] : 5;
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $c_title ); ?>" placeholder="Название (Яндекс, 2ГИС…)" style="flex:1">
								<input type="url" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][url]" value="<?php echo esc_attr( $c_url ); ?>" placeholder="Ссылка" style="flex:1">
								<input type="number" min="1" max="5" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][rating]" value="<?php echo (int) $c_rating; ?>" style="width:80px" title="Рейтинг">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<button type="button" class="button" data-add-item="reviews-cards-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="documents" data-group="landing">
			<div class="row"><input type="text" name="tolstenko_block_defaults[documents][subtitle]" value="<?php echo esc_attr( $all['documents']['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[documents][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $all['documents']['title'] ?? '' ); ?></textarea></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Документы (картинка + заглавие + описание + атрибуты)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="documents-list">
					<?php foreach ( (array) ( $all['documents']['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$img_id = isset( $it['image'] ) ? (int) $it['image'] : 0;
						$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заглавие">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][image]" value="<?php echo (int) $img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Описание"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="row"><textarea name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][attributes]" rows="2" placeholder="Атрибуты (по одному в строке)"><?php echo esc_textarea( $it['attributes'] ?? '' ); ?></textarea></div>
							<div class="icon-preview cert-preview" style="margin-top:8px;"><?php if ( $img_url ) : ?><img src="<?php echo esc_url( $img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="documents-list"><?php esc_html_e( 'Добавить документ', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="team" data-group="landing">
			<?php $team_defaults = $all['team'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[team][badge]" value="<?php echo esc_attr( $team_defaults['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[team][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $team_defaults['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[team][text]" rows="3" placeholder="Текст под заголовком"><?php echo esc_textarea( $team_defaults['text'] ?? '' ); ?></textarea></div>
			<p class="description"><?php esc_html_e( 'Карточки команды берутся из записей «Команда» (CPT teammate).', 'tolstenko-theme' ); ?></p>
		</div>

		<div class="tolstenko-df-panel" data-panel="case_section" data-group="post_sliders">
			<?php
			$cs = $all['case_section'] ?? array();
			$cs_ids = isset( $cs['ids'] ) && is_array( $cs['ids'] ) ? array_map( 'intval', $cs['ids'] ) : array();
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[case_section][subtitle]" value="<?php echo esc_attr( $cs['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[case_section][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $cs['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[case_section][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $cs['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="number" min="-1" name="tolstenko_block_defaults[case_section][posts_per_page]" value="<?php echo esc_attr( (string) ( $cs['posts_per_page'] ?? 4 ) ); ?>" style="width:100%" placeholder="Количество кейсов (4, -1 = все)"></div>
			<div class="row">
				<?php tolstenko_render_post_select( 
					'tolstenko_block_defaults[case_section][ids]',
					$cs_ids,
					'case',
					'Кейсы (пусто = все)'
				); ?>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="service_section" data-group="post_sliders">
			<?php tolstenko_render_service_section_defaults_fields( 'service_section', $all['service_section'] ?? array() ); ?>
		</div>

		<div class="tolstenko-df-panel" data-panel="service_section_filters" data-group="post_sliders">
			<?php
			$filters_data = $all['service_section_filters'] ?? array();
			if ( ! array_key_exists( 'service_section_filters', $saved ) && ! empty( $all['service_section'] ) && is_array( $all['service_section'] ) ) {
				$filters_data = array_replace_recursive( $filters_data, $all['service_section'] );
			}
			tolstenko_render_service_section_defaults_fields( 'service_section_filters', $filters_data );
			?>
		</div>

		<div class="tolstenko-df-panel" data-panel="blog_section" data-group="post_sliders">
			<?php tolstenko_render_blog_section_defaults_fields( 'blog_section', $all['blog_section'] ?? array() ); ?>
		</div>

		<div class="tolstenko-df-panel" data-panel="blog_section_filters" data-group="post_sliders">
			<?php
			$bsf = $all['blog_section_filters'] ?? array();
			tolstenko_render_blog_section_defaults_fields( 'blog_section_filters', $bsf );
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_section_filters][btn_text]" value="<?php echo esc_attr( $bsf['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки под списком (Все статьи)"></div>
			<p class="description"><?php esc_html_e( 'Слайдер с фильтром по рубрикам blog_cat. Кнопка всегда ведёт на страницу блога.', 'tolstenko-theme' ); ?></p>
		</div>


		<?php
		$faq = $all['faq'] ?? array();
		$ftpl = $all['field_template'] ?? array();
		$ftpl_img_id = isset( $ftpl['image'] ) ? (int) $ftpl['image'] : 0;
		$ftpl_img_url = $ftpl_img_id ? wp_get_attachment_image_url( $ftpl_img_id, 'medium' ) : '';
		$ftpl_post_ids = isset( $ftpl['post_ids'] ) && is_array( $ftpl['post_ids'] ) ? array_map( 'intval', $ftpl['post_ids'] ) : array();
		$ftpl_single_post_id = isset( $ftpl['single_post_id'] ) ? (int) $ftpl['single_post_id'] : 0;
		$ftpl_action_posts = get_posts(
			array(
				'post_type'      => 'actions',
				'posts_per_page' => 100,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		?>


		<div class="tolstenko-df-panel" data-panel="faq" data-group="landing">
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][badge]" value="<?php echo esc_attr( $faq['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][title]" value="<?php echo esc_attr( $faq['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок"></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Вопросы и ответы', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="faq-list">
					<?php foreach ( (array) ( $faq['items'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array( 'quest' => '', 'unswer' => '' ); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[faq][items][<?php echo (int) $idx; ?>][quest]" value="<?php echo esc_attr( $it['quest'] ?? '' ); ?>" placeholder="Вопрос" style="width:100%">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row tolstenko-faq-editor-wrap">
								<p class="description" style="margin:0 0 6px;"><?php esc_html_e( 'Ответ', 'tolstenko-theme' ); ?></p>
								<?php tolstenko_faq_answer_editor( (string) ( $it['unswer'] ?? '' ), (int) $idx ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="faq-list"><?php esc_html_e( 'Добавить вопрос', 'tolstenko-theme' ); ?></button></div>
			</div>
			<hr>
			<div class="muted"><?php esc_html_e( 'Форма справа', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][form_title]" value="<?php echo esc_attr( $faq['form_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок формы"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][form_text]" value="<?php echo esc_attr( $faq['form_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст формы"></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Контактная карточка — член команды', 'tolstenko-theme' ); ?></div>
				<?php
				$faq_teammates = get_posts( array(
					'post_type'      => 'teammate',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'orderby'        => 'title',
					'order'          => 'ASC',
				) );
				$faq_teammate_id = isset( $faq['teammate_id'] ) ? (int) $faq['teammate_id'] : 0;
				?>
				<select name="tolstenko_block_defaults[faq][teammate_id]" style="min-width:320px;max-width:100%">
					<option value="0"><?php esc_html_e( '— Не выбрано —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $faq_teammates as $faq_teammate ) : ?>
						<option value="<?php echo (int) $faq_teammate->ID; ?>" <?php selected( $faq_teammate_id, (int) $faq_teammate->ID ); ?>><?php echo esc_html( get_the_title( $faq_teammate ) ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php if ( empty( $faq_teammates ) ) : ?>
					<p class="description"><?php esc_html_e( 'Сначала добавьте записи в разделе «Команда».', 'tolstenko-theme' ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="field_template">
			<p class="description"><?php esc_html_e( 'Эталонная панель со всеми типами полей: чекбокс, текстовое поле, текстовая область, визуальный редактор, изображение, повторитель, множественный выбор записей и выбор одной записи. Ключ панели (field_template) совпадает с ключом блока my-theme/field-template.', 'tolstenko-theme' ); ?></p>
			<div class="muted"><?php esc_html_e( '0. Чекбокс', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[field_template][enabled]" value="1" <?php checked( ! empty( $ftpl['enabled'] ) ); ?>>
					<?php esc_html_e( 'Включить / показывать блок', 'tolstenko-theme' ); ?>
				</label>
			</div>
			<div class="muted"><?php esc_html_e( '1. Текстовое поле', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[field_template][text_field]" value="<?php echo esc_attr( $ftpl['text_field'] ?? '' ); ?>" style="width:100%" placeholder="Однострочное текстовое поле"></div>
			<div class="muted"><?php esc_html_e( '2. Текстовая область', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[field_template][textarea_field]" rows="3" style="width:100%" placeholder="Многострочная текстовая область"><?php echo esc_textarea( $ftpl['textarea_field'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( '3. Редактор (rich text)', 'tolstenko-theme' ); ?></div>
			<div class="row tolstenko-faq-editor-wrap"><?php tolstenko_field_template_editor( (string) ( $ftpl['editor_field'] ?? '' ), 'tolstenko_field_template_editor_0', 'tolstenko_block_defaults[field_template][editor_field]' ); ?></div>
			<div class="muted"><?php esc_html_e( '4. Изображение', 'tolstenko-theme' ); ?></div>
			<div class="row tolstenko-defaults-image-row">
				<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[field_template][image]" value="<?php echo (int) $ftpl_img_id; ?>">
				<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
				<div class="icon-preview field-template-preview"><?php if ( $ftpl_img_url ) : ?><img src="<?php echo esc_url( $ftpl_img_url ); ?>" alt=""><?php endif; ?></div>
			</div>
			<div class="muted"><?php esc_html_e( '5. Повторитель', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<div data-repeater-list="field-template-list">
					<?php foreach ( (array) ( $ftpl['items'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array( 'title' => '', 'text' => '' ); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[field_template][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Текстовое поле (заголовок)" style="flex:1">
								<button type="button" class="button move-btn" data-move-up title="<?php esc_attr_e( 'Вверх', 'tolstenko-theme' ); ?>">&uarr;</button>
								<button type="button" class="button move-btn" data-move-down title="<?php esc_attr_e( 'Вниз', 'tolstenko-theme' ); ?>">&darr;</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[field_template][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="<?php esc_attr_e( 'Текстовая область', 'tolstenko-theme' ); ?>"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="field-template-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
			<div class="muted"><?php esc_html_e( '6. Множественный выбор записей', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<?php tolstenko_render_post_select(
					'tolstenko_block_defaults[field_template][post_ids]',
					$ftpl_post_ids,
					'case',
					'Записи (пусто = все)'
				); ?>
			</div>
			<div class="muted"><?php esc_html_e( '7. Выбор одной записи', 'tolstenko-theme' ); ?></div>
			<div class="cols">
				<select name="tolstenko_block_defaults[field_template][single_post_id]" style="min-width:220px">
					<option value="0"><?php esc_html_e( '— Без ссылки —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $ftpl_action_posts as $ap ) : ?>
						<option value="<?php echo (int) $ap->ID; ?>" <?php selected( $ftpl_single_post_id, (int) $ap->ID ); ?>><?php echo esc_html( get_the_title( $ap ) ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			</div>
		</div>

		<?php $lp_blog_posts = tolstenko_get_posts_for_select( 'blog' ); ?>
		<div class="tolstenko-df-panel" data-panel="result" data-group="landing">
			<?php $lp = $all['result'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[result][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[result][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок"></div>
			<div class="row">
				<div class="muted">Карточки (иконка + название + текст)</div>
				<div data-repeater-list="result-items-list">
					<?php foreach ( (array) ( $lp['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$it_img_id  = isset( $it['icon'] ) ? (int) $it['icon'] : 0;
						$it_img_url = $it_img_id ? wp_get_attachment_image_url( $it_img_id, 'thumbnail' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $it_img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать иконку', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="icon-preview" style="margin-top:8px;"><?php if ( $it_img_url ) : ?><img src="<?php echo esc_url( $it_img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="result-items-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="compare" data-group="landing">
			<?php $lp = $all['compare'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[compare][lead]" rows="3" style="width:100%" placeholder="Текст под заголовком (перенос строки = новая строка)"><?php echo esc_textarea( $lp['lead'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_criterion]" value="<?php echo esc_attr( $lp['th_criterion'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: критерий"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_self]" value="<?php echo esc_attr( $lp['th_self'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 1"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_mediator]" value="<?php echo esc_attr( $lp['th_mediator'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 2"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_us]" value="<?php echo esc_attr( $lp['th_us'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 3 (золотая)"></div>
			<div class="row">
				<div class="muted">Строки таблицы</div>
				<div data-repeater-list="compare-rows-list">
					<?php foreach ( (array) ( $lp['rows'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][criterion]" value="<?php echo esc_attr( $it['criterion'] ?? '' ); ?>" placeholder="Критерий">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][self]" value="<?php echo esc_attr( $it['self'] ?? '' ); ?>" placeholder="Сам">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][mediator]" value="<?php echo esc_attr( $it['mediator'] ?? '' ); ?>" placeholder="Через посредника">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][us]" value="<?php echo esc_attr( $it['us'] ?? '' ); ?>" placeholder="Напрямую с нами">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="compare-rows-list"><?php esc_html_e( 'Добавить строку', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row"><textarea name="tolstenko_block_defaults[compare][foot_text]" rows="3" style="width:100%" placeholder="Текст под таблицей (перенос строки = новая строка)"><?php echo esc_textarea( $lp['foot_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][btn_url]" value="<?php echo esc_attr( $lp['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		</div>

		<div class="tolstenko-df-panel" data-panel="why_us" data-group="landing">
			<?php $lp = $all['why_us'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[why_us][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[why_us][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row">
				<div class="muted">Карточки (иконка + название + текст)</div>
				<div data-repeater-list="why_us-items-list">
					<?php foreach ( (array) ( $lp['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$it_img_id  = isset( $it['icon'] ) ? (int) $it['icon'] : 0;
						$it_img_url = $it_img_id ? wp_get_attachment_image_url( $it_img_id, 'thumbnail' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[why_us][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[why_us][items][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $it_img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать иконку', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[why_us][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="icon-preview" style="margin-top:8px;"><?php if ( $it_img_url ) : ?><img src="<?php echo esc_url( $it_img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="why_us-items-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="infra" data-group="landing">
			<?php $lp = $all['infra'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[infra][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $lp['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][btn_url]" value="<?php echo esc_attr( $lp['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
			<div class="row">
				<div class="muted">Список услуг (выводится в две колонки)</div>
				<div data-repeater-list="infra-items-list">
					<?php foreach ( (array) ( $lp['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[infra][items][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Пункт">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="infra-items-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="about" data-group="landing">
			<?php $lp = $all['about'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[about][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[about][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="muted">Текст (визуальный редактор)</div>
			<div class="row tolstenko-faq-editor-wrap"><?php tolstenko_field_template_editor( (string) ( $lp['text'] ?? '' ), 'tolstenko_field_template_about_text', 'tolstenko_block_defaults[about][text]' ); ?></div>
			<div class="row">
				<div class="muted">Фото слева</div>
				<?php $lp_img_id = (int) ( $lp['image'] ?? 0 ); $lp_img_url = $lp_img_id ? wp_get_attachment_image_url( $lp_img_id, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[about][image]" value="<?php echo (int) $lp_img_id; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $lp_img_url ) : ?><img src="<?php echo esc_url( $lp_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
			<div class="row">
				<div class="muted">Цифры (число + подпись)</div>
				<div data-repeater-list="about-stats-list">
					<?php foreach ( (array) ( $lp['stats'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[about][stats][<?php echo (int) $idx; ?>][num]" value="<?php echo esc_attr( $it['num'] ?? '' ); ?>" placeholder="Число">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[about][stats][<?php echo (int) $idx; ?>][label]" rows="2" placeholder="Подпись (перенос строки = новая строка)"><?php echo esc_textarea( $it['label'] ?? '' ); ?></textarea></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="about-stats-list"><?php esc_html_e( 'Добавить цифру', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="guide" data-group="landing">
			<?php $lp = $all['guide'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][subtitle]" value="<?php echo esc_attr( $lp['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[guide][title]" rows="3" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $lp['title'] ?? '' ); ?></textarea></div>
			<div class="muted">Статья (запись блога)</div>
			<div class="row">
				<select name="tolstenko_block_defaults[guide][post_id]" style="min-width:320px;max-width:100%">
					<option value="0"><?php esc_html_e( '— Не выбрано —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $lp_blog_posts as $lp_post ) : ?>
						<option value="<?php echo (int) $lp_post['id']; ?>" <?php selected( (int) ( $lp['post_id'] ?? 0 ), (int) $lp_post['id'] ); ?>><?php echo esc_html( $lp_post['title'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="muted">Карточка статьи</div>
			<div class="row">
				<div data-repeater-list="guide-tags-list">
					<?php foreach ( (array) ( $lp['tags'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array(); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[guide][tags][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Тег">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="guide-tags-list"><?php esc_html_e( 'Добавить тег', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][time]" value="<?php echo esc_attr( $lp['time'] ?? '' ); ?>" style="width:100%" placeholder="Время чтения"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][views]" value="<?php echo esc_attr( $lp['views'] ?? '' ); ?>" style="width:100%" placeholder="Просмотры"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][date_label]" value="<?php echo esc_attr( $lp['date_label'] ?? '' ); ?>" style="width:100%" placeholder="Дата (подпись)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][date]" value="<?php echo esc_attr( $lp['date'] ?? '' ); ?>" style="width:100%" placeholder="Дата ISO (2026-07-19)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][card_title]" value="<?php echo esc_attr( $lp['card_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок карточки"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[guide][text]" rows="5" placeholder="Текст карточки (HTML)"><?php echo esc_textarea( $lp['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row">
				<div class="muted">Изображение</div>
				<?php $g_img = (int) ( $lp['image'] ?? 0 ); $g_url = $g_img ? wp_get_attachment_image_url( $g_img, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[guide][image]" value="<?php echo (int) $g_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $g_url ) : ?><img src="<?php echo esc_url( $g_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="consult" data-group="landing">
			<?php $lp = $all['consult'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[consult][title]" rows="3" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $lp['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[consult][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $lp['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][contact_label]" value="<?php echo esc_attr( $lp['contact_label'] ?? '' ); ?>" style="width:100%" placeholder="Подпись перед телефоном"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][phone]" value="<?php echo esc_attr( $lp['phone'] ?? '' ); ?>" style="width:100%" placeholder="Телефон"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][input_placeholder]" value="<?php echo esc_attr( $lp['input_placeholder'] ?? '' ); ?>" style="width:100%" placeholder="Плейсхолдер поля"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row">
				<div class="muted">Согласия (текст + ссылка)</div>
				<div data-repeater-list="consult-consents-list">
					<?php foreach ( (array) ( $lp['consents'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Текст перед ссылкой">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][link_text]" value="<?php echo esc_attr( $it['link_text'] ?? '' ); ?>" placeholder="Текст ссылки">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][link_url]" value="<?php echo esc_attr( $it['link_url'] ?? '' ); ?>" placeholder="URL ссылки">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="consult-consents-list"><?php esc_html_e( 'Добавить согласие', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row">
				<div class="muted">Фото справа</div>
				<?php $lp_img_id = (int) ( $lp['image'] ?? 0 ); $lp_img_url = $lp_img_id ? wp_get_attachment_image_url( $lp_img_id, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[consult][image]" value="<?php echo (int) $lp_img_id; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $lp_img_url ) : ?><img src="<?php echo esc_url( $lp_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="hero_stats" data-group="landing">
			<?php $hs = $all['hero_stats'] ?? array(); ?>
			<div class="muted"><?php esc_html_e( 'Пункты (значение + подпись)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="hero-stats-list">
				<?php foreach ( (array) ( $hs['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[hero_stats][items][<?php echo (int) $idx; ?>][num]" value="<?php echo esc_attr( $it['num'] ?? '' ); ?>" placeholder="Значение">
							<input type="text" name="tolstenko_block_defaults[hero_stats][items][<?php echo (int) $idx; ?>][label]" value="<?php echo esc_attr( $it['label'] ?? '' ); ?>" placeholder="Подпись">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="hero-stats-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
		</div>
		<div class="tolstenko-df-panel" data-panel="situations" data-group="landing">
			<?php $st = $all['situations'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[situations][badge]" value="<?php echo esc_attr( $st['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[situations][title]" value="<?php echo esc_attr( $st['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="muted"><?php esc_html_e( 'Карточки (по две в слайде)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="situations-list">
				<?php foreach ( (array) ( $st['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[situations][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заголовок">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[situations][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст (можно <span>)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="situations-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
		</div>
		<div class="tolstenko-df-panel" data-panel="process" data-group="landing">
			<?php $pr2 = $all['process'] ?? array(); $pr2_img = (int) ( $pr2['image'] ?? 0 ); $pr2_img_url = $pr2_img ? wp_get_attachment_image_url( $pr2_img, 'medium' ) : ''; ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[process][badge]" value="<?php echo esc_attr( $pr2['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[process][title]" value="<?php echo esc_attr( $pr2['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Изображение', 'tolstenko-theme' ); ?></div>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[process][image]" value="<?php echo (int) $pr2_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $pr2_img_url ) : ?><img src="<?php echo esc_url( $pr2_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
			<div class="muted"><?php esc_html_e( 'Шаги (нумерация автоматически)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="process-list">
				<?php foreach ( (array) ( $pr2['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[process][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название шага">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[process][items][<?php echo (int) $idx; ?>][text]" rows="3" placeholder="Описание (HTML)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="process-list"><?php esc_html_e( 'Добавить шаг', 'tolstenko-theme' ); ?></button></div>
		</div>

		<div class="tolstenko-df-panel" data-panel="cost" data-group="landing">
			<?php $cst = $all['cost'] ?? array(); $cst_img = (int) ( $cst['image'] ?? 0 ); $cst_img_url = $cst_img ? wp_get_attachment_image_url( $cst_img, 'medium' ) : ''; ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][badge]" value="<?php echo esc_attr( $cst['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][title]" value="<?php echo esc_attr( $cst['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][lead]" rows="3" placeholder="Текст под заголовком (HTML)"><?php echo esc_textarea( $cst['lead'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Цены', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="cost-prices-list">
				<?php foreach ( (array) ( $cst['prices'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[cost][prices][<?php echo (int) $idx; ?>][name]" value="<?php echo esc_attr( $it['name'] ?? '' ); ?>" placeholder="Услуга">
							<input type="text" name="tolstenko_block_defaults[cost][prices][<?php echo (int) $idx; ?>][value]" value="<?php echo esc_attr( $it['value'] ?? '' ); ?>" placeholder="Значение (HTML)">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="cost-prices-list"><?php esc_html_e( 'Добавить цену', 'tolstenko-theme' ); ?></button></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][card_title]" rows="2" placeholder="Заголовок карточки (HTML)"><?php echo esc_textarea( $cst['card_title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][card_text]" rows="2" placeholder="Текст карточки"><?php echo esc_textarea( $cst['card_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][btn_text]" value="<?php echo esc_attr( $cst['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[cost][btn_url]" value="<?php echo esc_attr( $cst['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		<div class="muted"><?php esc_html_e( 'Ссылки с иконками (под кнопкой)', 'tolstenko-theme' ); ?></div>
		<div data-repeater-list="cost-links-list">
			<?php foreach ( (array) ( $cst['links'] ?? array() ) as $idx => $lk ) : ?>
				<?php $lk = is_array( $lk ) ? $lk : array(); $lk_icon_id = (int) ( $lk['icon_id'] ?? 0 ); $lk_icon_url = $lk_icon_id ? wp_get_attachment_image_url( $lk_icon_id, 'thumbnail' ) : ''; ?>
				<div class="repeater-item" data-repeater-item>
					<div class="cols" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
						<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][icon_id]" value="<?php echo esc_attr( $lk_icon_id ); ?>">
						<div class="icon-preview" style="max-width:32px;max-height:32px;<?php echo empty($lk_icon_url) ? 'display:none;' : ''; ?>"><?php if ($lk_icon_url) : ?><img src="<?php echo esc_url( $lk_icon_url ); ?>" alt=""><?php endif; ?></div>
						<button type="button" class="button tolstenko-defaults-pick-icon" style="min-width:110px;">Загрузить SVG</button>
						<button type="button" class="button tolstenko-defaults-remove-icon hidden" style="margin-left:4px; min-width:90px;">Удалить иконку</button>
						<input type="text" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $lk['title'] ?? '' ); ?>" placeholder="Название" style="min-width:130px;">
						<input type="text" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][link]" value="<?php echo esc_attr( $lk['link'] ?? '' ); ?>" placeholder="Ссылка" style="flex:1; min-width:200px;">
						<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="actions"><button type="button" class="button" data-add-item="cost-links-list"><?php esc_html_e( 'Добавить ссылку', 'tolstenko-theme' ); ?></button></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Изображение', 'tolstenko-theme' ); ?></div>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[cost][image]" value="<?php echo (int) $cst_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $cst_img_url ) : ?><img src="<?php echo esc_url( $cst_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>
		<div class="tolstenko-df-panel" data-panel="blog_more" data-group="landing">
			<?php $bm = $all['blog_more'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_more][text]" value="<?php echo esc_attr( $bm['text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_more][url]" value="<?php echo esc_attr( $bm['url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка"></div>
		</div>

		</div><!-- .tolstenko-df-panels-source -->
	</div>
	<div class="actions">
		<!-- <button type="submit" name="tolstenko_defaults_reset_all" value="1" class="button"><?php esc_html_e( 'Сбросить всё к заводским', 'tolstenko-theme' ); ?></button> -->
	</div>
	<?php submit_button( __( 'Сохранить дефолты', 'tolstenko-theme' ) ); ?>
	<script>
	(function(){
		var root = document.querySelector('.tolstenko-df');
		if (!root) return;

		var panelGroupMap = {
			documents: 'landing',
			team: 'landing',
			hero_stats: 'landing',
			situations: 'landing',
			process: 'landing',
			cost: 'landing',
			blog_more: 'landing',
			faq: 'landing',
			field_template: 'main',
			case_section: 'post_sliders',
			reviews: 'post_sliders',
			service_section: 'post_sliders',
			service_section_filters: 'post_sliders',
			blog_section: 'post_sliders',
			blog_section_filters: 'post_sliders',
		};

		// Разложить панели по группам
		root.querySelectorAll('.tolstenko-df-panel').forEach(function(panel){
			var key = panel.getAttribute('data-panel');
			var group = panel.getAttribute('data-group') || panelGroupMap[key];
			if (!group) return;
			var slot = root.querySelector('.tolstenko-df-group-panels[data-group-panels="' + group + '"]');
			if (slot) slot.appendChild(panel);
		});
		var source = root.querySelector('.tolstenko-df-panels-source');
		if (source) source.remove();

		// Функция переиндексации элементов репитера
		function reindexRepeater(listEl, namePrefix) {
			var items = listEl.querySelectorAll('[data-repeater-item]');
			items.forEach(function(item, idx){
				var inputs = item.querySelectorAll('[name]');
				inputs.forEach(function(input){
					var name = input.getAttribute('name');
					var regex = new RegExp('\\' + namePrefix + '\\[\\d+\\]');
					if (regex.test(name)) {
						input.setAttribute('name', name.replace(regex, namePrefix + '[' + idx + ']'));
					}
				});
				// Обновляем data-атрибуты для кнопок перемещения
				var upBtn = item.querySelector('[data-move-up]');
				var downBtn = item.querySelector('[data-move-down]');
				if (upBtn) upBtn.dataset.index = idx;
				if (downBtn) downBtn.dataset.index = idx;
			});
		}

		// Функция перемещения элемента
		function moveItem(item, direction) {
			var list = item.parentElement;
			var items = list.querySelectorAll('[data-repeater-item]');
			var index = Array.from(items).indexOf(item);
			var newIndex = index + direction;
			if (newIndex < 0 || newIndex >= items.length) return;
			
			var namePrefix = '';
			var nameInputs = item.querySelectorAll('[name]');
			if (nameInputs.length > 0) {
				var name = nameInputs[0].getAttribute('name');
				var match = name.match(/^([^\[]+\[[^\]]+\])\[/);
				if (match) namePrefix = match[1];
			}
			if (!namePrefix) {
				// Пробуем найти через data-repeater-list
				var listKey = list.getAttribute('data-repeater-list');
				if (listKey) {
					var panel = list.closest('.tolstenko-df-panel');
					if (panel) {
						var panelKey = panel.getAttribute('data-panel');
						if (panelKey) {
							namePrefix = panelKey + '[' + listKey.replace(/-list$/, '') + ']';
						}
					}
				}
			}
			
			if (newIndex > index) {
				item.parentElement.insertBefore(item, items[newIndex + 1] || null);
			} else {
				item.parentElement.insertBefore(item, items[newIndex]);
			}
			
			if (namePrefix) {
				reindexRepeater(list, namePrefix);
			}
		}

		// Обработка кликов по кнопкам перемещения и удаления
		document.addEventListener('click', function(e){
			var target = e.target;
			if (target.closest && target.closest('[data-move-up]')) {
				e.preventDefault();
				var btn = target.closest('[data-move-up]');
				var item = btn.closest('[data-repeater-item]');
				if (item) moveItem(item, -1);
				return;
			}
			if (target.closest && target.closest('[data-move-down]')) {
				e.preventDefault();
				var btn = target.closest('[data-move-down]');
				var item = btn.closest('[data-repeater-item]');
				if (item) moveItem(item, 1);
				return;
			}
			var removeBtn = target.closest && target.closest('[data-remove-item]');
			if (removeBtn) {
				e.preventDefault();
				var item = removeBtn.closest('[data-repeater-item]');
				if (!item) return;
				var area = item.querySelector('textarea.wp-editor-area');
				if (area && area.id && window.wp && wp.editor && typeof wp.editor.remove === 'function') {
					try { wp.editor.remove(area.id); } catch (err) {}
				}
				item.remove();
				return;
			}
			var addBtn = target.closest && target.closest('[data-add-item]');
			if (addBtn) {
				e.preventDefault();
				var key = addBtn.getAttribute('data-add-item');
				var panel = addBtn.closest('.tolstenko-df-panel') || document;
				var list = panel.querySelector('[data-repeater-list="' + key + '"]') || document.querySelector('[data-repeater-list="' + key + '"]');
				if (!list) return;
				var directItems = list.querySelectorAll('[data-repeater-item]');
				var idx = directItems.length;
				var html = '';
				if (key === 'reviews-cards-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[reviews][cards][' + idx + '][title]" placeholder="Название (Яндекс, 2ГИС…)" style="flex:1"><input type="url" name="tolstenko_block_defaults[reviews][cards][' + idx + '][url]" placeholder="Ссылка" style="flex:1"><input type="number" min="1" max="5" name="tolstenko_block_defaults[reviews][cards][' + idx + '][rating]" value="5" style="width:80px" title="Рейтинг"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'documents-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[documents][items][' + idx + '][title]" placeholder="Заглавие"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[documents][items][' + idx + '][image]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Выбрать изображение</button><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[documents][items][' + idx + '][text]" rows="2" placeholder="Описание"></textarea></div><div class="row"><textarea name="tolstenko_block_defaults[documents][items][' + idx + '][attributes]" rows="2" placeholder="Атрибуты (по одному в строке)"></textarea></div><div class="icon-preview cert-preview" style="margin-top:8px;"></div></div>';
				} else if (key === 'hero-stats-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[hero_stats][items][' + idx + '][num]" placeholder="Значение"><input type="text" name="tolstenko_block_defaults[hero_stats][items][' + idx + '][label]" placeholder="Подпись"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'situations-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[situations][items][' + idx + '][title]" placeholder="Заголовок"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[situations][items][' + idx + '][text]" rows="2" placeholder="Текст"></textarea></div></div>';
				} else if (key === 'process-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[process][items][' + idx + '][title]" placeholder="Название шага"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[process][items][' + idx + '][text]" rows="3" placeholder="Описание (HTML)"></textarea></div></div>';
				} else if (key === 'cost-links-list') {
			html = '<div class="repeater-item" data-repeater-item><div class="cols" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[cost][links][' + idx + '][icon_id]" value="0"><div class="icon-preview" style="max-width:32px;max-height:32px;display:none;"></div><button type="button" class="button tolstenko-defaults-pick-icon" style="min-width:110px;">Загрузить SVG</button><button type="button" class="button tolstenko-defaults-remove-icon hidden" style="margin-left:4px; min-width:90px;">Удалить иконку</button><input type="text" name="tolstenko_block_defaults[cost][links][' + idx + '][title]" placeholder="Название" style="min-width:130px;"><input type="text" name="tolstenko_block_defaults[cost][links][' + idx + '][link]" placeholder="Ссылка" style="flex:1; min-width:200px;"><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
		} else if (key === 'cost-prices-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[cost][prices][' + idx + '][name]" placeholder="Услуга"><input type="text" name="tolstenko_block_defaults[cost][prices][' + idx + '][value]" placeholder="Значение (HTML)"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'guide-tags-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[guide][tags][' + idx + '][text]" placeholder="Тег"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'faq-list') {
					var editorId = 'tolstenko_faq_redactor_' + idx + '_' + Date.now();
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[faq][items][' + idx + '][quest]" placeholder="Вопрос" style="width:100%"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row tolstenko-faq-editor-wrap"><p class="description" style="margin:0 0 6px;">Ответ</p><textarea id="' + editorId + '" name="tolstenko_block_defaults[faq][items][' + idx + '][unswer]" rows="8" class="wp-editor-area"></textarea></div></div>';
					list.insertAdjacentHTML('beforeend', html);
					if (window.wp && wp.editor && typeof wp.editor.initialize === 'function') {
						wp.editor.initialize(editorId, {
							tinymce: {
								wpautop: true,
								plugins: 'charmap colorpicker hr lists paste tabfocus textcolor wordpress wpautoresize wpeditimage wpemoji wpgallery wplink wptextpattern',
								toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_adv',
								toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo'
							},
							quicktags: true,
							mediaButtons: true
						});
					}
					html = '';
				} else if (key === 'result-items-list') {
					var k = Date.now() + idx;
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[result][items][' + k + '][title]" placeholder="Название"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[result][items][' + k + '][icon]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Выбрать иконку</button><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[result][items][' + k + '][text]" rows="2" placeholder="Текст"></textarea></div><div class="icon-preview" style="margin-top:8px;"></div></div>';
				} else if (key === 'compare-rows-list') {
					var k = Date.now() + idx;
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[compare][rows][' + k + '][criterion]" placeholder="Критерий"><input type="text" name="tolstenko_block_defaults[compare][rows][' + k + '][self]" placeholder="Сам"><input type="text" name="tolstenko_block_defaults[compare][rows][' + k + '][mediator]" placeholder="Через посредника"><input type="text" name="tolstenko_block_defaults[compare][rows][' + k + '][us]" placeholder="Напрямую с нами"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'why_us-items-list') {
					var k = Date.now() + idx;
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[why_us][items][' + k + '][title]" placeholder="Название"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[why_us][items][' + k + '][icon]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Выбрать иконку</button><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[why_us][items][' + k + '][text]" rows="2" placeholder="Текст"></textarea></div><div class="icon-preview" style="margin-top:8px;"></div></div>';
				} else if (key === 'infra-items-list') {
					var k = Date.now() + idx;
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[infra][items][' + k + '][text]" placeholder="Пункт"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'about-stats-list') {
					var k = Date.now() + idx;
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[about][stats][' + k + '][num]" placeholder="Число"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[about][stats][' + k + '][label]" rows="2" placeholder="Подпись (перенос строки = новая строка)"></textarea></div></div>';
				} else if (key === 'consult-consents-list') {
					var k = Date.now() + idx;
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[consult][consents][' + k + '][text]" placeholder="Текст перед ссылкой"><input type="text" name="tolstenko_block_defaults[consult][consents][' + k + '][link_text]" placeholder="Текст ссылки"><input type="text" name="tolstenko_block_defaults[consult][consents][' + k + '][link_url]" placeholder="URL ссылки"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'field-template-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[field_template][items][' + idx + '][title]" placeholder="Текстовое поле (заголовок)" style="flex:1"><button type="button" class="button move-btn" data-move-up title="Вверх">&uarr;</button><button type="button" class="button move-btn" data-move-down title="Вниз">&darr;</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[field_template][items][' + idx + '][text]" rows="2" placeholder="Текстовая область"></textarea></div></div>';
				}
				if (html) list.insertAdjacentHTML('beforeend', html);
			}
		});

		function refreshFaqEditors(){
			if (typeof tinymce === 'undefined') return;
			window.setTimeout(function(){
				var editors = tinymce.editors || [];
				for (var i = 0; i < editors.length; i++) {
					var ed = editors[i];
					if (!ed || !ed.id || (ed.id.indexOf('tolstenko_faq_redactor_') !== 0 && ed.id.indexOf('tolstenko_field_template_') !== 0)) continue;
					try {
						ed.fire('show');
						if (ed.theme && typeof ed.theme.resizeTo === 'function') {
							ed.theme.resizeTo('100%', 180);
						}
					} catch (err) {}
				}
			}, 60);
		}

		function activateTab(tab){
			if (!tab) return;
			var target = tab.getAttribute('data-panel');
			var group = tab.getAttribute('data-group') || panelGroupMap[target] || '';
			root.querySelectorAll('.tolstenko-df-tab').forEach(function(t){ t.classList.remove('active'); });
			root.querySelectorAll('.tolstenko-df-panel').forEach(function(p){ p.classList.remove('active'); });
			root.querySelectorAll('.tolstenko-df-tabs-group').forEach(function(g){ g.classList.remove('is-active'); });
			tab.classList.add('active');
			var panel = root.querySelector('.tolstenko-df-panel[data-panel="' + target + '"]');
			if (panel) panel.classList.add('active');
			var groupEl = root.querySelector('.tolstenko-df-tabs-group[data-group="' + group + '"]');
			if (groupEl) {
				groupEl.classList.add('is-active');
				groupEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			}
			if (target === 'faq' || target === 'field_template' || target === 'about') refreshFaqEditors();
		}

		root.querySelectorAll('.tolstenko-df-tab').forEach(function(tab){
			tab.addEventListener('click', function(){
				activateTab(tab);
			});
		});

		var initial = root.querySelector('.tolstenko-df-tab.active') || root.querySelector('.tolstenko-df-tab');
		activateTab(initial);

		var defaultsForm = root.closest('form');
		if (defaultsForm) {
			defaultsForm.addEventListener('submit', function(){
				if (typeof tinymce !== 'undefined' && typeof tinymce.triggerSave === 'function') {
					tinymce.triggerSave();
				}
			});
		}

		function bindIconPicker(scope){
			scope.querySelectorAll('.tolstenko-defaults-pick-icon').forEach(function(btn){
				if (btn.dataset.bound) return;
				btn.dataset.bound = '1';
				btn.addEventListener('click', function(ev){
					ev.preventDefault();
					if (typeof wp === 'undefined' || !wp.media) return;
					var row = btn.closest('[data-repeater-item], .tolstenko-defaults-image-row');
					if (!row) return;
					var input = row.querySelector('.tolstenko-defaults-icon-id');
					var preview = row.querySelector('.icon-preview');
					var frame = wp.media({ title: 'Выберите иконку', button: { text: 'Использовать' }, multiple: false, library: { type: 'image' } });
					frame.on('select', function(){
						var sel = frame.state().get('selection').first();
						if (!sel) return;
						var json = sel.toJSON();
						input.value = json.id || 0;
						var img = (json.sizes && json.sizes.thumbnail && json.sizes.thumbnail.url) || json.url || '';
						preview.innerHTML = img ? '<img src="' + img + '" alt="">' : '';
					});
					frame.open();
				});
			});
		}
		bindIconPicker(document);
		document.addEventListener('click', function(e){
			var btn = e.target;
			if (btn.matches && btn.matches('[data-add-item]')) {
				setTimeout(function(){ bindIconPicker(document); }, 0);
			}
			if (btn.matches && btn.matches('.tolstenko-defaults-remove-icon')) {
				e.preventDefault();
				var row = btn.closest('[data-repeater-item], .tolstenko-defaults-image-row');
				if (!row) return;
				var input = row.querySelector('.tolstenko-defaults-icon-id');
				var preview = row.querySelector('.icon-preview');
				if (input) input.value = '0';
				if (preview) { preview.innerHTML = ''; preview.style.display = 'none'; }
				btn.classList.add('hidden');
			}
		});

		function bindVideoPicker(scope){
			scope.querySelectorAll('.tolstenko-defaults-pick-video').forEach(function(btn){
				if (btn.dataset.bound) return;
				btn.dataset.bound = '1';
				btn.addEventListener('click', function(ev){
					ev.preventDefault();
					if (typeof wp === 'undefined' || !wp.media) return;
					var row = btn.closest('.tolstenko-defaults-image-row');
					if (!row) return;
					var input = row.querySelector('.tolstenko-defaults-icon-id');
					var preview = row.querySelector('.icon-preview');
					var frame = wp.media({
						title: 'Выберите видео',
						button: { text: 'Использовать' },
						multiple: false,
						library: { type: 'video' }
					});
					frame.on('select', function(){
						var sel = frame.state().get('selection').first();
						if (!sel) return;
						var json = sel.toJSON();
						input.value = json.id || 0;
						var name = (json.filename || json.title || json.url || '');
						if (name && name.indexOf('/') !== -1) {
							name = name.split('/').pop();
						}
						preview.textContent = name || '';
					});
					frame.open();
				});
			});
		}
		bindVideoPicker(document);
	})();
	</script>
	</form>
	</div>
	<?php
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

	if ( isset( $raw['cost']['links'] ) && is_array( $raw['cost']['links'] ) ) {
		foreach ( $raw['cost']['links'] as $lk ) {
			if ( ! is_array( $lk ) ) { continue; }
			$icon_id = isset( $lk['icon_id'] ) ? (int) $lk['icon_id'] : 0;
			$title   = sanitize_text_field( $lk['title'] ?? '' );
			$url     = esc_url_raw( $lk['link'] ?? '' );
			if ( $icon_id === 0 && $title === '' && $url === '' ) { continue; }
			$out['cost']['links'][] = array( 'icon_id' => $icon_id, 'title' => $title, 'link' => $url );
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

	// Не затирать дефолты блоков тела статьи (правятся на отдельной странице).
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

/* ==========================================================================
   Хелперы для секций лендинга (why_us, result, compare, infra, about, guide, consult)
   ========================================================================== */

/**
 * Текст с переносами строк -> HTML (разрешённые теги + <br>).
 */
function tolstenko_landing_text( $value ) {
	return wp_kses_post( nl2br( (string) $value ) );
}

/**
 * Стандартные иконки карточек (используются, если в поле «Иконка» ничего не выбрано).
 */
function tolstenko_landing_default_icons() {
	return array(
		'why_us' => array(
			'<circle cx="12" cy="13.5" r="7.5"/><path d="M10 3h4M12 3v3M18.2 7.3l1.3-1.3"/><path d="m12.8 10.5-2.3 3h3l-2.3 3"/>',
			'<path d="M12 3 4.5 5.5v6c0 4.4 3 7.6 7.5 9.5 4.5-1.9 7.5-5.1 7.5-9.5v-6L12 3Z"/><circle cx="12" cy="10.5" r="2.5"/><path d="M7.8 17c.8-2 2.4-3 4.2-3s3.4 1 4.2 3"/>',
			'<rect x="3" y="4" width="14" height="11" rx="2"/><circle cx="10" cy="8.5" r="1.8"/><path d="M6.5 13c.6-1.6 1.9-2.3 3.5-2.3s2.9.7 3.5 2.3"/><path d="M7 18.5h12a2 2 0 0 0 2-2V8.5"/>',
			'<path d="m12 2.5 2.3 1.8 2.9-.1 1.1 2.7 2.5 1.5-.9 2.8.9 2.8-2.5 1.5-1.1 2.7-2.9-.1L12 21.5l-2.3-1.8-2.9.1-1.1-2.7-2.5-1.5.9-2.8-.9-2.8 2.5-1.5 1.1-2.7 2.9.1L12 2.5Z"/><path d="m9 15 6-6"/><circle cx="9.4" cy="9.4" r=".9"/><circle cx="14.6" cy="14.6" r=".9"/>',
			'<path d="M12.5 21H6.5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v6"/><path d="M8 8h6M8 11.5h6M8 15h3"/><path d="m14.5 18.5 2 2 4-4.5"/>',
			'<path d="M8 4h8v5a4 4 0 0 1-8 0V4Z"/><path d="M8 6H5v1.5A3 3 0 0 0 8 10.5M16 6h3v1.5a3 3 0 0 1-3 3"/><path d="M12 13v4M8.5 20.5h7M9.5 17h5v3.5h-5z"/>',
		),
		'result' => array(
			'<path d="M3 9.5 12 4l9 5.5M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 20h18M4 9.5h16"/>',
			'<rect x="3" y="5" width="18" height="14" rx="2"/><rect x="6" y="8.5" width="4.5" height="3.5" rx=".6"/><path d="M13.5 9h4M13.5 12h4M6 15.5h11.5"/>',
			'<rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3 9.5h18M6.5 15h2.5M12 15h2.5"/>',
			'<rect x="3" y="8" width="18" height="12" rx="2"/><path d="M8.5 8V6.5A1.5 1.5 0 0 1 10 5h4a1.5 1.5 0 0 1 1.5 1.5V8M3 13l9 3 9-3"/>',
			'<path d="M3 4v16h18"/><path d="m6.5 14 4-4 3 3 5-6"/><path d="M15.5 7h3.5v3.5"/>',
			'<path d="M4 14v-2a8 8 0 0 1 16 0v2"/><rect x="3" y="13" width="4" height="6" rx="1.5"/><rect x="17" y="13" width="4" height="6" rx="1.5"/><path d="M19 19c0 1.5-1.5 2.5-4 2.5h-2"/>',
		),
	);
}

/**
 * Иконка карточки: выбранное изображение или стандартная SVG по порядковому номеру.
 */
function tolstenko_landing_icon( $section, $index, $attachment_id, $class ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id > 0 ) {
		$img = wp_get_attachment_image(
			$attachment_id,
			'thumbnail',
			false,
			array(
				'class'   => $class,
				'alt'     => '',
				'loading' => 'lazy',
			)
		);
		if ( $img ) {
			return $img;
		}
	}
	$icons = tolstenko_landing_default_icons();
	if ( ! isset( $icons[ $section ][ $index ] ) ) {
		return '';
	}
	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 24 24" aria-hidden="true">' . $icons[ $section ][ $index ] . '</svg>';
}