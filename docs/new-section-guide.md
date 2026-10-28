# Как создать новую секцию

Пошаговое руководство: секция с табом в «Дефолтах блоков», Gutenberg-блоком,
выводом на главной и переводами. В качестве примера — секция **«Промо»** (`promo`),
в которой есть все типы полей, которые поддерживает тема.

Готовые секции, на которые стоит смотреть как на образец:

| Что нужно | Где посмотреть |
|---|---|
| Все типы полей в одном месте | таб «Шаблон всех полей» (`field_template`), блок `blocks/field-template` |
| Простая секция (тексты + кнопка) | `infra`, `consult` |
| Повторитель | `situations`, `banks` |
| Вложенный повторитель | `flagship` (строки таблицы → преимущества), `quiz` (шаги → варианты) |
| Выбор одной записи | `guide` |
| Слайдер (Splide) | `situations`, `cases`, `reviews` |
| AJAX-фильтр | `cases`, `services-slider` |

---

## 0. Как устроена секция

```
Таб «Дефолты блоков → promo»            Gutenberg-блок my-theme/promo
inc/block-defaults/sections/promo/       blocks/promo/
  schema.php  — значения по умолчанию      block.json   — атрибуты
  panel.php   — поля таба                  template.php — атрибуты → query var
  save.php    — санитизация при сохранении
        │                                         │
        ▼                                         ▼
tolstenko_get_block_defaults('promo')    get_query_var('promo_data')
        └──────────────┬──────────────────────────┘
                       ▼
        pages/sections/promo.php
        theme_section_merge_defaults($defaults, $overrides)
        → разметка секции
```

* **Таб** хранит значения «по умолчанию» для всего сайта (опция `tolstenko_block_defaults`).
* **Блок** позволяет на конкретной странице переопределить любое поле. Пустое поле блока —
  значит «взять из таба».
* **Шаблон секции** один: его подключают и блок, и главная страница
  (`theme_render_front_section('promo')` выводит секцию, если на странице нет блока).
* **Переводы** работают сами (см. раздел 13): таб получает вкладки языков,
  блоки переводятся вместе со страницей в Polylang.

### Имена

| Что | Пример | Правило |
|---|---|---|
| Ключ таба (дефолтов) | `promo` | латиница, слова через `_` (`why_us`, `blog_more`) |
| Slug блока и шаблона | `promo` | слова через `-` (`why-us`, `blog-more`) |
| Имя блока | `my-theme/promo` | `my-theme/<slug>` |
| Query var | `promo_data` | `<slug с _>_data` |
| BEM-блок в разметке и SCSS | `.promo` | как slug |

Если в имени одно слово — ключ и slug совпадают. Дальше в примере везде `promo`.

---

## 1. Типы полей

| Тип | В табе (panel.php) | Санитизация (save.php) | В блоке (editor-config.php) | Атрибут block.json |
|---|---|---|---|---|
| Строка | `<input type="text">` | `sanitize_text_field()` | `text` | `string` |
| Строка с HTML (`<span>` для акцента, `<br>`) | `<input>` / `<textarea>` | `tolstenko_kses_html()` | `text` / `textarea` | `string` |
| Многострочный текст | `<textarea>` | `sanitize_textarea_field()` или `tolstenko_kses_html()` | `textarea` | `string` |
| Визуальный редактор | `tolstenko_field_template_editor()` | `tolstenko_kses_redactor()` | `editor` | `string` |
| Чекбокс | `<input type="checkbox">` | `! empty()` | `toggle` | `boolean` **без default** |
| Изображение | скрытое поле + кнопка `tolstenko-defaults-pick-icon` | `(int)` | `image` | `object` (`{id,url,alt}`) |
| Ссылка (адрес + текст + новая вкладка) | 2 input + чекбокс | `esc_url_raw()` + `sanitize_text_field()` | `link` | `object` (`{url,title,target}`) |
| Выбор из списка | `<select>` | проверка по списку допустимых | — (только в табе) | — |
| Повторитель | `data-repeater-list` + JS | цикл, пустые пункты отбросить | `repeater` + `itemFields` | `array` |
| Вложенный повторитель | `data-repeater-list` с `data-name-prefix` | вложенный цикл | `repeater` внутри `itemFields` | (внутри `array`) |
| Одна запись | `<select>` из `tolstenko_get_posts_for_select()` | `tolstenko_landing_sanitize_post_id()` | `post` + `postType` | `number` |
| Несколько записей | `tolstenko_render_post_select()` | `tolstenko_sanitize_ids()` | `posts` + `postType` | `array` |

Внутри повторителя в блоке доступны поля `text`, `textarea`, `image` и вложенный `repeater`.
Для `post` / `posts` в редакторе есть списки записей `blog`, `service`, `review`, `case`,
`teammate` (`inc/blocks/editor-assets.php`, ключ `posts`; другой тип записей добавляется там же).

---

## 2. Схема дефолтов — `inc/block-defaults/sections/promo/schema.php`

Здесь все поля секции и их значения по умолчанию. **Все тексты-заглушки пишите сюда, а не в
шаблон**: тогда их можно перевести и поменять в админке.

```php
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'badge'    => 'Промо',                                   // строка
	'title'    => 'Заголовок <span>с акцентом</span>',       // строка с HTML
	'text'     => 'Короткий текст под заголовком.',          // многострочный текст
	'content'  => '<p>Текст из визуального редактора.</p>',  // визуальный редактор
	'show_btn' => true,                                      // чекбокс
	'image'    => 0,                                         // изображение (ID вложения)
	'link'     => array(                                     // ссылка
		'url'    => '',
		'title'  => 'Подробнее',
		'target' => '',
	),
	'theme'    => 'dark',                                    // выбор из списка: dark | white
	'items'    => array(                                     // повторитель
		array( 'title' => 'Пункт 1', 'text' => 'Описание пункта', 'icon' => 0 ),
	),
	'steps'    => array(                                     // вложенный повторитель
		array(
			'title'   => 'Шаг 1',
			'options' => array(
				array( 'text' => 'Вариант A' ),
				array( 'text' => 'Вариант B' ),
			),
		),
	),
	'post_id'  => 0,                                         // одна запись (статья)
	'post_ids' => array(),                                   // несколько записей (услуги)
);
```

> Ключи `post_id` и `post_ids` выбраны не случайно — см. раздел 13 «Переводы».

---

## 3. Поля таба — `inc/block-defaults/sections/promo/panel.php`

Файл подключается внутри страницы настроек. В нём доступна переменная `$all` — дефолты всех
табов (схема + сохранённое, на выбранном языке). Корневой `div` обязательно с
`data-panel="<ключ>"` и `data-group="<группа>"` (группа — та, куда вы добавите таб в шаге 5).

Имена полей: `tolstenko_block_defaults[promo][<поле>]`.

```php
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pr          = $all['promo'] ?? array();
$pr_img      = (int) ( $pr['image'] ?? 0 );
$pr_img_url  = $pr_img ? wp_get_attachment_image_url( $pr_img, 'medium' ) : '';
$pr_link     = is_array( $pr['link'] ?? null ) ? $pr['link'] : array();
$pr_articles = tolstenko_get_posts_for_select( 'blog' );
?>
<div class="tolstenko-df-panel" data-panel="promo" data-group="landing">

	<?php /* Строка */ ?>
	<div class="row"><input type="text" name="tolstenko_block_defaults[promo][badge]" value="<?php echo esc_attr( $pr['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>

	<?php /* Строка с HTML */ ?>
	<div class="row"><textarea name="tolstenko_block_defaults[promo][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $pr['title'] ?? '' ); ?></textarea></div>

	<?php /* Многострочный текст */ ?>
	<div class="row"><textarea name="tolstenko_block_defaults[promo][text]" rows="3" style="width:100%" placeholder="Текст"><?php echo esc_textarea( $pr['text'] ?? '' ); ?></textarea></div>

	<?php /* Визуальный редактор: id редактора должен быть уникальным на странице */ ?>
	<div class="muted"><?php esc_html_e( 'Содержимое', 'tolstenko-theme' ); ?></div>
	<div class="row"><?php tolstenko_field_template_editor( (string) ( $pr['content'] ?? '' ), 'tolstenko_promo_content', 'tolstenko_block_defaults[promo][content]' ); ?></div>

	<?php /* Чекбокс */ ?>
	<div class="row">
		<label>
			<input type="checkbox" name="tolstenko_block_defaults[promo][show_btn]" value="1" <?php checked( ! empty( $pr['show_btn'] ) ); ?>>
			<?php esc_html_e( 'Показывать кнопку', 'tolstenko-theme' ); ?>
		</label>
	</div>

	<?php /* Изображение: скрытое поле с ID + кнопка выбора + превью (общий JS страницы) */ ?>
	<div class="muted"><?php esc_html_e( 'Изображение', 'tolstenko-theme' ); ?></div>
	<div class="row tolstenko-defaults-image-row">
		<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[promo][image]" value="<?php echo (int) $pr_img; ?>">
		<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
		<div class="icon-preview"><?php if ( $pr_img_url ) : ?><img src="<?php echo esc_url( $pr_img_url ); ?>" alt=""><?php endif; ?></div>
	</div>

	<?php /* Ссылка */ ?>
	<div class="muted"><?php esc_html_e( 'Кнопка', 'tolstenko-theme' ); ?></div>
	<div class="cols">
		<input type="text" name="tolstenko_block_defaults[promo][link][title]" value="<?php echo esc_attr( $pr_link['title'] ?? '' ); ?>" placeholder="Текст кнопки">
		<input type="text" name="tolstenko_block_defaults[promo][link][url]" value="<?php echo esc_attr( $pr_link['url'] ?? '' ); ?>" placeholder="Ссылка (пусто = #modal)" style="flex:1">
		<label><input type="checkbox" name="tolstenko_block_defaults[promo][link][target]" value="_blank" <?php checked( ( $pr_link['target'] ?? '' ) === '_blank' ); ?>> <?php esc_html_e( 'В новой вкладке', 'tolstenko-theme' ); ?></label>
	</div>

	<?php /* Выбор из списка */ ?>
	<div class="row">
		<select name="tolstenko_block_defaults[promo][theme]">
			<option value="dark" <?php selected( $pr['theme'] ?? 'dark', 'dark' ); ?>><?php esc_html_e( 'Тёмная', 'tolstenko-theme' ); ?></option>
			<option value="white" <?php selected( $pr['theme'] ?? 'dark', 'white' ); ?>><?php esc_html_e( 'Светлая (section--white)', 'tolstenko-theme' ); ?></option>
		</select>
	</div>

	<?php /* Повторитель: data-repeater-list="<ключ списка>", пункты — data-repeater-item */ ?>
	<div class="muted"><?php esc_html_e( 'Пункты', 'tolstenko-theme' ); ?></div>
	<div data-repeater-list="promo-items-list">
		<?php foreach ( (array) ( $pr['items'] ?? array() ) as $idx => $it ) : ?>
			<?php
			$it       = is_array( $it ) ? $it : array();
			$icon_id  = (int) ( $it['icon'] ?? 0 );
			$icon_url = $icon_id ? wp_get_attachment_image_url( $icon_id, 'thumbnail' ) : '';
			?>
			<div class="repeater-item" data-repeater-item>
				<div class="cols">
					<input type="text" name="tolstenko_block_defaults[promo][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заголовок" style="flex:1">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[promo][items][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $icon_id; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Иконка', 'tolstenko-theme' ); ?></button>
					<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
					<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
					<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
				</div>
				<div class="icon-preview" style="margin-top:8px;"><?php if ( $icon_url ) : ?><img src="<?php echo esc_url( $icon_url ); ?>" alt=""><?php endif; ?></div>
				<div class="row"><textarea name="tolstenko_block_defaults[promo][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="actions"><button type="button" class="button" data-add-item="promo-items-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>

	<?php /* Вложенный повторитель: у внутреннего списка data-name-prefix = префикс имён его полей */ ?>
	<div class="muted"><?php esc_html_e( 'Шаги', 'tolstenko-theme' ); ?></div>
	<div data-repeater-list="promo-steps-list">
		<?php foreach ( (array) ( $pr['steps'] ?? array() ) as $idx => $step ) : ?>
			<?php
			$step        = is_array( $step ) ? $step : array();
			$step_prefix = 'tolstenko_block_defaults[promo][steps][' . (int) $idx . ']';
			?>
			<div class="repeater-item" data-repeater-item>
				<div class="cols">
					<input type="text" name="<?php echo esc_attr( $step_prefix ); ?>[title]" value="<?php echo esc_attr( $step['title'] ?? '' ); ?>" placeholder="Название шага" style="flex:1">
					<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
					<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
					<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
				</div>
				<div data-repeater-list="promo-options-list" data-name-prefix="<?php echo esc_attr( $step_prefix ); ?>[options]">
					<?php foreach ( (array) ( $step['options'] ?? array() ) as $o_idx => $option ) : ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="<?php echo esc_attr( $step_prefix ); ?>[options][<?php echo (int) $o_idx; ?>][text]" value="<?php echo esc_attr( is_array( $option ) ? ( $option['text'] ?? '' ) : '' ); ?>" placeholder="Вариант" style="flex:1">
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="promo-options-list"><?php esc_html_e( 'Добавить вариант', 'tolstenko-theme' ); ?></button></div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="actions"><button type="button" class="button" data-add-item="promo-steps-list"><?php esc_html_e( 'Добавить шаг', 'tolstenko-theme' ); ?></button></div>

	<?php /* Одна запись */ ?>
	<div class="muted"><?php esc_html_e( 'Статья', 'tolstenko-theme' ); ?></div>
	<div class="row">
		<select name="tolstenko_block_defaults[promo][post_id]" style="min-width:320px;max-width:100%">
			<option value="0"><?php esc_html_e( '— Не выбрано —', 'tolstenko-theme' ); ?></option>
			<?php foreach ( $pr_articles as $article ) : ?>
				<option value="<?php echo (int) $article['id']; ?>" <?php selected( (int) ( $pr['post_id'] ?? 0 ), (int) $article['id'] ); ?>><?php echo esc_html( $article['title'] ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<?php /* Несколько записей (поиск + сортировка, как в Gutenberg) */ ?>
	<div class="row">
		<?php tolstenko_render_post_select( 'tolstenko_block_defaults[promo][post_ids]', (array) ( $pr['post_ids'] ?? array() ), 'service', 'Услуги (пусто = все)' ); ?>
	</div>
</div>

		
```

Полезные классы разметки таба: `.row` — строка на всю ширину, `.cols` — поля в ряд,
`.muted` — подпись группы, `.actions` — ряд кнопок, `.description` — серая подсказка.

---

## 4. Кнопки «Добавить» у повторителей — `assets/js/admin/block-defaults.js`

Новый пункт повторителя создаётся из HTML-строки в этом файле. Найдите блок
`} else if (key === 'flagship-rows-list') {` и рядом добавьте ветки для своих списков
(ключ — значение `data-add-item` / `data-repeater-list`):

```js
} else if (key === 'promo-items-list') {
	html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[promo][items][' + idx + '][title]" placeholder="Заголовок" style="flex:1"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[promo][items][' + idx + '][icon]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Иконка</button><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="icon-preview" style="margin-top:8px;"></div><div class="row"><textarea name="tolstenko_block_defaults[promo][items][' + idx + '][text]" rows="2" placeholder="Текст"></textarea></div></div>';
} else if (key === 'promo-steps-list') {
	// Внешний пункт: уникальный индекс (Date.now) и пустой вложенный список с data-name-prefix.
	var pp = 'tolstenko_block_defaults[promo][steps][' + (Date.now() + idx) + ']';
	html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="' + pp + '[title]" placeholder="Название шага" style="flex:1"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div data-repeater-list="promo-options-list" data-name-prefix="' + pp + '[options]"></div><div class="actions"><button type="button" class="button" data-add-item="promo-options-list">Добавить вариант</button></div></div>';
} else if (key === 'promo-options-list') {
	// Вложенный пункт: префикс имени берём у своего списка.
	var op = list.getAttribute('data-name-prefix') || '';
	if (!op) return;
	html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="' + op + '[' + (Date.now() + idx) + '][text]" placeholder="Вариант" style="flex:1"><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
```

* Разметка нового пункта должна совпадать с разметкой пункта в `panel.php`.
* Индексы в имени могут идти не по порядку — при сохранении `save.php` перебирает пункты циклом.
* Удаление, перемещение (`data-move-up/down`) и выбор изображения (`tolstenko-defaults-pick-icon`)
  работают сами.

Если в корневом `div` таба указан `data-group`, добавлять ключ в `panelGroupMap` в начале
файла не нужно.

---

## 5. Санитизация — `inc/block-defaults/sections/promo/save.php`

Подключается при сохранении страницы настроек. Доступны `$raw` (данные формы) и `$out`
(результат, который будет сохранён). **Поле, которого нет в `$out`, при сохранении пропадёт.**

```php
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pr_raw  = is_array( $raw['promo'] ?? null ) ? $raw['promo'] : array();
$pr_link = is_array( $pr_raw['link'] ?? null ) ? $pr_raw['link'] : array();
$pr_theme = sanitize_key( $pr_raw['theme'] ?? 'dark' );

$out['promo'] = array(
	'badge'    => sanitize_text_field( $pr_raw['badge'] ?? '' ),
	'title'    => tolstenko_kses_html( $pr_raw['title'] ?? '' ),
	'text'     => tolstenko_kses_html( $pr_raw['text'] ?? '' ),
	'content'  => tolstenko_kses_redactor( $pr_raw['content'] ?? '' ),
	'show_btn' => ! empty( $pr_raw['show_btn'] ),
	'image'    => (int) ( $pr_raw['image'] ?? 0 ),
	'link'     => array(
		'url'    => esc_url_raw( trim( (string) ( $pr_link['url'] ?? '' ) ) ),
		'title'  => sanitize_text_field( $pr_link['title'] ?? '' ),
		'target' => ( $pr_link['target'] ?? '' ) === '_blank' ? '_blank' : '',
	),
	'theme'    => in_array( $pr_theme, array( 'dark', 'white' ), true ) ? $pr_theme : 'dark',
	'items'    => array(),
	'steps'    => array(),
	'post_id'  => tolstenko_landing_sanitize_post_id( $pr_raw['post_id'] ?? 0, 'blog' ),
	'post_ids' => tolstenko_sanitize_ids( $pr_raw['post_ids'] ?? array() ),
);

// Повторитель: пустые пункты отбрасываем.
foreach ( (array) ( $pr_raw['items'] ?? array() ) as $it ) {
	if ( ! is_array( $it ) ) {
		continue;
	}
	$item = array(
		'title' => sanitize_text_field( $it['title'] ?? '' ),
		'text'  => tolstenko_kses_html( $it['text'] ?? '' ),
		'icon'  => (int) ( $it['icon'] ?? 0 ),
	);
	if ( $item['title'] === '' && $item['text'] === '' && ! $item['icon'] ) {
		continue;
	}
	$out['promo']['items'][] = $item;
}

// Вложенный повторитель.
foreach ( (array) ( $pr_raw['steps'] ?? array() ) as $step ) {
	if ( ! is_array( $step ) ) {
		continue;
	}
	$options = array();
	foreach ( (array) ( $step['options'] ?? array() ) as $option ) {
		$option_text = sanitize_text_field( is_array( $option ) ? ( $option['text'] ?? '' ) : '' );
		if ( $option_text !== '' ) {
			$options[] = array( 'text' => $option_text );
		}
	}
	$step_title = sanitize_text_field( $step['title'] ?? '' );
	if ( $step_title === '' && empty( $options ) ) {
		continue;
	}
	$out['promo']['steps'][] = array(
		'title'   => $step_title,
		'options' => $options,
	);
}
```

---

## 6. Регистрация таба — `inc/block-defaults/sections.php`

Добавьте ключ в нужную группу `tolstenko_block_defaults_tab_groups()`
(`main`, `post_sliders` или `landing`) — группа должна совпадать с `data-group` в `panel.php`:

```php
'landing' => array(
	'title' => 'Секции лендинга',
	'tabs'  => array(
		// …
		'promo' => 'Промо',
	),
),
```

После этого на странице «Настройки сайта → Дефолты блоков» появится таб «Промо».
Если таб не нужен (только схема дефолтов), добавьте ключ в
`tolstenko_block_defaults_schema_only_keys()`.

---

## 7. Gutenberg-блок — `blocks/promo/`

Блоки регистрируются автоматически: каждая папка в `blocks/` с `block.json`
(`inc/blocks/registration.php`).

### `blocks/promo/block.json`

Атрибуты — по одному на каждое поле, которое можно переопределить в блоке. Значения
по умолчанию **пустые** (пусто = «взять из таба»).

```json
{
  "apiVersion": 3,
  "title": "Промо",
  "name": "my-theme/promo",
  "category": "tolstenko-general",
  "icon": "megaphone",
  "supports": {
    "html": false,
    "align": ["wide", "full"],
    "multiple": false
  },
  "attributes": {
    "badge": { "type": "string", "default": "" },
    "title": { "type": "string", "default": "" },
    "text": { "type": "string", "default": "" },
    "content": { "type": "string", "default": "" },
    "show_btn": { "type": "boolean" },
    "image": { "type": "object", "default": {} },
    "link": { "type": "object", "default": {} },
    "items": { "type": "array", "default": [] },
    "steps": { "type": "array", "default": [] },
    "post_id": { "type": "number", "default": 0 },
    "post_ids": { "type": "array", "default": [] }
  },
  "render": "file:./template.php"
}
```

* `show_btn` — **без `default`**: иначе `false` из блока всегда перекрывал бы чекбокс таба.
* `multiple: false` — блок можно вставить на страницу один раз (для секций-слайдеров с
  уникальными id это важно). Если секция может повторяться — `true`.

### `blocks/promo/template.php`

Переводит атрибуты блока в данные для шаблона секции. **Пустые значения передавайте
пустыми (`''` / `[]`)** — тогда сработает дефолт из таба.

```php
<?php

defined('ABSPATH') || exit;

/**
 * Блок «Промо» (my-theme/promo). Пустые атрибуты — из таба «Промо»,
 * см. pages/sections/promo.php.
 */

$promo_data = [];

foreach (['badge', 'title', 'text', 'content'] as $key) {
    $promo_data[$key] = isset($attributes[$key]) ? (string) $attributes[$key] : '';
}

foreach (['items', 'steps', 'post_ids'] as $key) {
    $promo_data[$key] = isset($attributes[$key]) && is_array($attributes[$key]) ? $attributes[$key] : [];
}

// Чекбокс: не тронут в блоке — берём из таба.
$promo_data['show_btn'] = isset($attributes['show_btn']) ? (bool) $attributes['show_btn'] : '';

// Изображение и ссылка — объекты; пустые не передаём, иначе они перекроют таб.
$promo_data['image'] = !empty($attributes['image']['url']) ? $attributes['image'] : [];
$promo_data['link']  = !empty($attributes['link']['url']) || !empty($attributes['link']['title']) ? $attributes['link'] : [];

// Одна запись: 0 — из таба.
$promo_data['post_id'] = !empty($attributes['post_id']) ? (int) $attributes['post_id'] : '';

set_query_var('promo_data', $promo_data);

get_template_part('pages/sections/promo');
```

---

## 8. Поля блока в редакторе — `inc/blocks/editor-config.php`

Интерфейс блока в редакторе строится по описанию полей
(`assets/js/section-blocks.js`). Добавьте элемент в массив `theme_get_section_blocks_editor_config()`:

```php
[
    'name'        => 'my-theme/promo',
    'title'       => 'Промо',
    'hint'        => 'Если пусто — из админки: Дефолты блоков → Промо',
    'color'       => '#2271b1',
    'defaultsKey' => 'promo', // ключ таба: его значения показываются подсказками в пустых полях
    'fields'      => [
        ['attr' => 'badge', 'label' => 'Надзаголовок', 'type' => 'text'],
        ['attr' => 'title', 'label' => 'Заголовок (HTML, акцент — <span>)', 'type' => 'text'],
        ['attr' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
        ['attr' => 'content', 'label' => 'Содержимое', 'type' => 'editor'],
        ['attr' => 'show_btn', 'label' => 'Показывать кнопку', 'type' => 'toggle'],
        ['attr' => 'image', 'label' => 'Изображение', 'type' => 'image'],
        ['attr' => 'link', 'label' => 'Кнопка', 'type' => 'link'],
        [
            'attr'       => 'items',
            'label'      => 'Пункты',
            'type'       => 'repeater',
            'addLabel'   => 'Добавить пункт',
            'itemLabel'  => 'Пункт',
            'itemFields' => [
                ['key' => 'title', 'label' => 'Заголовок', 'type' => 'text'],
                ['key' => 'text', 'label' => 'Текст', 'type' => 'textarea'],
                ['key' => 'icon', 'label' => 'Иконка', 'type' => 'image'],
            ],
        ],
        [
            'attr'       => 'steps',
            'label'      => 'Шаги',
            'type'       => 'repeater',
            'addLabel'   => 'Добавить шаг',
            'itemLabel'  => 'Шаг',
            'itemFields' => [
                ['key' => 'title', 'label' => 'Название', 'type' => 'text'],
                [
                    'key'        => 'options',
                    'label'      => 'Варианты',
                    'type'       => 'repeater',
                    'addLabel'   => 'Добавить вариант',
                    'itemLabel'  => 'Вариант',
                    'itemFields' => [
                        ['key' => 'text', 'label' => 'Текст', 'type' => 'text'],
                    ],
                ],
            ],
        ],
        ['attr' => 'post_id', 'label' => 'Статья', 'type' => 'post', 'postType' => 'blog'],
        ['attr' => 'post_ids', 'label' => 'Услуги', 'type' => 'posts', 'postType' => 'service'],
    ],
],
```

`attr` должен совпадать с атрибутом в `block.json`, `key` в `itemFields` — с ключом пункта
в схеме.

### Категория и шаблон главной

* `inc/blocks/registration.php`, функция `theme_get_block_category_map()` — добавьте
  `'promo' => 'tolstenko-general',` (раздел в списке блоков редактора).
* `inc/blocks/page-templates.php`, `theme_get_front_page_block_template()` — по желанию
  `['my-theme/promo'],`, чтобы блок был в шаблоне новой главной страницы.

---

## 9. Шаблон секции — `pages/sections/promo.php`

Собирает данные «таб + блок» и выводит разметку. Его подключают и блок, и главная страница.

```php
<?php

defined('ABSPATH') || exit;

/**
 * Секция «Промо» (promo).
 *
 * Дефолты — из админки: tolstenko_get_block_defaults('promo')
 * (таб «Дефолты блоков → Промо»). Атрибуты блока имеют приоритет.
 */

$defaults = function_exists('tolstenko_get_block_defaults') ? tolstenko_get_block_defaults('promo') : [];

$overrides = get_query_var('promo_data');
$overrides = is_array($overrides) ? $overrides : [];

$data = theme_section_merge_defaults($defaults, $overrides);

$items = array_values(array_filter((array) ($data['items'] ?? []), 'is_array'));
$steps = array_values(array_filter((array) ($data['steps'] ?? []), 'is_array'));

// Секция без содержимого не выводится.
if (trim((string) ($data['title'] ?? '')) === '' && empty($items)) {
    return;
}

$image = tolstenko_contact_get_image_attrs($data['image'] ?? 0); // ID из таба или объект из блока
$link = is_array($data['link'] ?? null) ? $data['link'] : [];
$link_url = trim((string) ($link['url'] ?? '')) ?: '#modal';
$link_title = trim((string) ($link['title'] ?? ''));

$article = !empty($data['post_id']) ? get_post((int) $data['post_id']) : null;
$services = !empty($data['post_ids']) ? get_posts([
    'post_type'      => 'service',
    'post__in'       => array_map('intval', (array) $data['post_ids']),
    'orderby'        => 'post__in',
    'posts_per_page' => -1,
]) : [];

$section_class = 'promo section' . (($data['theme'] ?? '') === 'white' ? ' section--white' : '');
?>
<section class="<?= esc_attr($section_class); ?>">
  <div class="container">
    <div class="promo__top section-top">
      <?php if (trim((string) ($data['badge'] ?? '')) !== '') : ?>
        <span class="promo__badge section-subtitle"><?= esc_html($data['badge']); ?></span>
      <?php endif; ?>

      <?php if (trim((string) ($data['title'] ?? '')) !== '') : ?>
        <h2 class="promo__title section-title"><?= $data['title']; ?></h2>
      <?php endif; ?>

      <?php if (trim((string) ($data['text'] ?? '')) !== '') : ?>
        <div class="promo__text section-text"><?= theme_section_text_html($data['text']); ?></div>
      <?php endif; ?>
    </div>

    <?php if (trim((string) ($data['content'] ?? '')) !== '') : ?>
      <div class="promo__content redactor"><?= wp_kses_post($data['content']); ?></div>
    <?php endif; ?>

    <?php if ($image['url'] !== '') : ?>
      <div class="promo__image br-30">
        <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>" loading="lazy">
      </div>
    <?php endif; ?>

    <?php if ($items) : ?>
      <div class="promo__items">
        <?php foreach ($items as $item) : ?>
          <?php $icon = tolstenko_contact_get_image_attrs($item['icon'] ?? 0); ?>
          <article class="promo__item br-20">
            <?php if ($icon['url'] !== '') : ?>
              <img class="promo__item-icon" src="<?= esc_url($icon['url']); ?>" alt="" loading="lazy">
            <?php endif; ?>
            <h3 class="promo__item-title h4-16-20"><?= esc_html($item['title'] ?? ''); ?></h3>
            <p class="promo__item-text reg-par-14-20"><?= $item['text'] ?? ''; ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php foreach ($steps as $step) : ?>
      <div class="promo__step">
        <h3 class="promo__step-title"><?= esc_html($step['title'] ?? ''); ?></h3>
        <ul class="promo__options">
          <?php foreach ((array) ($step['options'] ?? []) as $option) : ?>
            <li class="promo__option"><?= esc_html($option['text'] ?? ''); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>

    <?php if ($article instanceof WP_Post) : ?>
      <a class="promo__article" href="<?= esc_url(get_permalink($article)); ?>"><?= esc_html(get_the_title($article)); ?></a>
    <?php endif; ?>

    <?php foreach ($services as $service) : ?>
      <a class="promo__service" href="<?= esc_url(get_permalink($service)); ?>"><?= esc_html(get_the_title($service)); ?></a>
    <?php endforeach; ?>

    <?php if (!empty($data['show_btn']) && $link_title !== '') : ?>
      <a class="promo__btn default-btn default-btn--brown" href="<?= esc_url($link_url); ?>"<?= ($link['target'] ?? '') === '_blank' ? ' target="_blank" rel="noopener"' : ''; ?>>
        <span><?= esc_html($link_title); ?></span>
        <svg class="promo__btn-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6" /></svg>
      </a>
    <?php endif; ?>
  </div>
</section>
```

Как работает `theme_section_merge_defaults($defaults, $overrides)`
(`inc/blocks/front-sections.php`): значение из блока заменяет дефолт, **если оно не пустое** —
строка не `''`, массив не `[]`. Поэтому в `template.php` пустые поля передаются пустыми.

Экранирование: поля с HTML (заголовок с `<span>`, текст) выводятся как есть — они уже
очищены в `save.php` / блоке; обычные строки — через `esc_html()`, ссылки — `esc_url()`,
атрибуты — `esc_attr()`, текст из редактора — `wp_kses_post()`.

---

## 10. Стили — `assets/scss/pages/front/sections/_promo.scss`

Подключите файл в `assets/scss/style.scss` рядом с другими секциями:

```scss
@import './pages/front/sections/promo';
```

Правила темы:

* Размеры — через `vw(px, $mobile | $desktop | $desktop_large)` и брейкпоинты
  `$desk` (992) / `$desk_large` (1441): каждое значение пишется три раза.
* Цвета — только переменные палитры из `assets/scss/common/_vars.scss`
  (`--accent-color`, `--light-bg-color`, `--main-text-color`, `--dark-bg-plank-color`…).
* Сначала общие классы, потом свои:
  * секция и фон — `section`, `section--white`;
  * шапка секции — `section-top`, `section-subtitle`, `section-title`, `section-text`;
  * скругления — `br-20`, `br-30`;
  * типографика — `h2-18-20`, `h4-16-20`, `reg-par-14-20`, `reg-small-12-15`, `lead-16-25`…;
  * кнопки — `default-btn` + `default-btn--brown` / `default-btn--transparent`;
  * табы-фильтры — `filter filter--tabs`, формы CF7 на тёмном фоне — `form form--dark`.
* Свои классы — по BEM внутри блока секции (`.promo__item`), без чужих классов.

```scss
// Секция «Промо» (pages/sections/promo.php).
.promo {
  &__items {
    display: grid;
    grid-template-columns: minmax(0, 1fr);
    grid-gap: vw(10px, $mobile);
    @media (min-width: $desk) {
      grid-template-columns: repeat(3, minmax(0, 1fr));
      grid-gap: vw(20px, $desktop);
    }
    @media (min-width: $desk_large) {
      grid-gap: vw(20px, $desktop_large);
    }
  }

  &__item {
    padding: vw(20px, $mobile);
    background-color: var(--dark-bg-plank-color);
    @media (min-width: $desk) {
      padding: vw(30px, $desktop);
    }
    @media (min-width: $desk_large) {
      padding: vw(30px, $desktop_large);
    }
  }

  // Кнопка — общий default-btn (как в «infra»): здесь только отступ и стрелка.
  &__btn {
    margin-top: vw(30px, $mobile);
    @media (min-width: $desk) {
      width: auto;
      margin-top: vw(40px, $desktop);
    }
    @media (min-width: $desk_large) {
      margin-top: vw(40px, $desktop_large);
    }

    svg.promo__btn-arrow {
      fill: none;
    }
  }

  &__btn-arrow {
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
  }
}
```

Соберите стили тем же способом, что и обычно: `assets/scss/style.scss` →
`assets/css/style.css` и `assets/css/style.min.css`.

---

## 11. JavaScript (если нужен)

Скрипты секций подгружаются, когда секция появляется на экране: элементу с классом
`load-on-vissible--js` указываются модули в `data-module` (пути — относительно `assets/js/`)
и стили в `data-css`.

```php
<div class="promo__splide splide load-on-vissible--js"
  data-module="./libs/splide.min.js,./modules/promoSplideInit.js"
  data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css">
```

Модуль — `assets/js/modules/promoSplideInit.js`. Можно экспортировать функцию по умолчанию
(её вызовет загрузчик) или просто выполнить код:

```js
document.querySelectorAll(".promo__splide").forEach((el) => {
  if (el.splide) {
    return;
  }

  el.splide = new Splide(el, {
    perPage: 3,
    perMove: 1,
    gap: "20px",
    pagination: true,
    arrows: false,
    breakpoints: { 991.9: { perPage: 1 } },
  }).mount();
});
```

Стили точек пагинации и «вылет» слайдов за контейнер — скопируйте из `_cases.scss`
(блок «Пагинация»).

---

## 12. Вывод на главной — `front-page.php`

```php
theme_render_front_section('promo');
```

Функция выводит `pages/sections/promo.php`, **если на странице нет блока** `my-theme/promo`
(если блок есть — он уже выведен содержимым страницы). На других страницах секция
появляется, только если вставить блок.

---

## 13. Переводы

Специально ничего делать не нужно — достаточно соблюдать правила ниже.

**Таб.** На странице «Дефолты блоков» есть вкладки языков (Polylang). Основной язык хранится
в `tolstenko_block_defaults`, перевод — в `tolstenko_block_defaults_<язык>` и содержит только
отличия. Пустое поле или поле, совпадающее с основным языком, берётся из основного языка;
число пунктов в повторителях следует основному языку
(`inc/settings-i18n.php`).

**Блок.** Атрибуты блока хранятся в содержимом страницы, поэтому переводятся вместе со
страницей: создайте перевод страницы в Polylang и поменяйте тексты в блоке. Подсказки
в пустых полях блока показываются на языке редактируемой страницы.

**Правила:**

1. **Тексты по умолчанию — в `schema.php`, не в шаблоне.** Строка, зашитая в
   `pages/sections/promo.php`, на всех языках будет одинаковой.
2. **Выбор записей называйте ключами `post_id`, `ids`, `post_ids`, `single_post_id` или
   `teammate_id`.** Такие поля общие для языков: на вкладке перевода они заблокированы,
   а на сайте вместо выбранной записи подставляется её перевод (`pll_get_post`).
   Для другого имени добавьте его в `theme_settings_post_id_keys()` в `inc/settings-i18n.php`.
3. Чтобы подстановка перевода работала, тип записей должен быть переводимым в настройках
   Polylang.
4. Изображения переводимые: на вкладке языка можно выбрать другую картинку (например, с
   текстом на английском); не тронутая — берётся из основного языка.

---

## 14. Проверка

1. **Таб:** «Настройки сайта → Дефолты блоков → Промо» открывается, все поля видны, кнопки
   «Добавить» у повторителей добавляют пункты (в том числе вложенные), изображения выбираются.
2. **Сохранение:** измените каждое поле, сохраните, обновите страницу — значения на месте.
   Пропавшее поле — почти всегда забытый ключ в `save.php`.
3. **Главная:** секция выводится в нужном месте `front-page.php` с данными таба.
4. **Блок:** вставьте «Промо» на страницу. Пустые поля показывают подсказки из таба;
   на сайте — данные таба. Заполните поле в блоке — на сайте значение из блока.
5. **Переводы:** на вкладке «English» таба переведите заголовок, откройте английскую главную —
   заголовок английский, остальное как на русском; выбранная статья — её английская версия.
6. **Вёрстка:** 390px (мобильная), 1280px и 1920px; на 991px нет горизонтального скролла.
7. **PHP:** `php -l` для новых файлов; включите `WP_DEBUG` — в логе нет предупреждений.

---

## 15. Частые ошибки

| Симптом | Причина |
|---|---|
| Таб не появился | ключ не добавлен в `sections.php` или нет файла `panel.php` |
| Таб пустой / оказался в другой группе | `data-group` в `panel.php` не совпадает с группой в `sections.php` |
| Поле не сохраняется | ключа нет в `$out['promo']` в `save.php` |
| «Добавить пункт» ничего не делает | нет ветки `key === '…-list'` в `block-defaults.js` или ключ не совпадает с `data-add-item` |
| Блока нет в редакторе | ошибка в `block.json` (проверьте JSON) или нет записи в `editor-config.php` |
| Блок всегда перекрывает таб пустым значением | в `template.php` передаётся пустой объект изображения/ссылки или `false` у чекбокса; `default` у boolean-атрибута |
| Секция не выводится на главной | нет `theme_render_front_section('promo')`, шаблон вернулся на `return` (пусто), или slug не совпадает с именем файла `pages/sections/promo.php` |
| На английском русский текст | текст зашит в шаблоне, а не в `schema.php`; или поле перевода пустое (берётся из основного языка) |
| Стили не применились | файл не подключён в `style.scss` или стили не пересобраны |
