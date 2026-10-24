	(function(){
		var root = document.querySelector('.tolstenko-df');
		if (!root) return;

		var panelGroupMap = {
			documents: 'landing',
			team: 'landing',
			cases: 'landing',
			programs: 'landing',
			banks: 'landing',
			flagship: 'landing',
			europe: 'landing',
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
		} else if (key === 'cost-prices-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[cost][prices][' + idx + '][name]" placeholder="Услуга"><input type="text" name="tolstenko_block_defaults[cost][prices][' + idx + '][value]" placeholder="Значение (HTML)"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
				} else if (key === 'guide-tags-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[guide][tags][' + idx + '][text]" placeholder="Тег"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div></div>';
} else if (key === 'programs-columns-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[programs][columns][' + idx + '][name]" placeholder="Название"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[programs][columns][' + idx + '][flag]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Флаг</button><input type="text" name="tolstenko_block_defaults[programs][columns][' + idx + '][accent]" placeholder="Акцент (1)" style="width:110px"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="icon-preview" style="margin-top:8px;"></div></div>';
				} else if (key === 'programs-rows-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[programs][rows][' + idx + '][criterion]" placeholder="Критерий"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="row"><textarea name="tolstenko_block_defaults[programs][rows][' + idx + '][values]" rows="4" placeholder="Значения по колонкам (по одному в строке)"></textarea></div></div>';
				} else if (key === 'banks-items-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][title]" placeholder="Заголовок карточки"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[banks][items][' + idx + '][logo]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Логотип</button><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="icon-preview" style="margin-top:8px;"></div><div class="row"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][type_text]" style="width:100%" placeholder="Тип счёта"></div><div class="cols"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][fact_1_label]" placeholder="Факт 1 — подпись"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][fact_1_value]" placeholder="Факт 1 — значение"></div><div class="cols"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][fact_2_label]" placeholder="Факт 2 — подпись"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][fact_2_value]" placeholder="Факт 2 — значение"></div><div class="cols"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][link_text]" placeholder="Кнопка"><input type="text" name="tolstenko_block_defaults[banks][items][' + idx + '][link_url]" placeholder="Ссылка кнопки"></div></div>';
} else if (key === 'flagship-cards-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[flagship][cards][' + idx + '][country]" placeholder="Страна"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[flagship][cards][' + idx + '][flag]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Флаг</button><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="icon-preview" style="margin-top:8px;"></div><div class="cols"><input type="text" name="tolstenko_block_defaults[flagship][cards][' + idx + '][price]" placeholder="Цена (HTML)"><input type="text" name="tolstenko_block_defaults[flagship][cards][' + idx + '][title]" placeholder="Название программы"></div><div class="row"><textarea name="tolstenko_block_defaults[flagship][cards][' + idx + '][text]" rows="3" placeholder="Описание (HTML)"></textarea></div><div class="row"><textarea name="tolstenko_block_defaults[flagship][cards][' + idx + '][facts]" rows="3" placeholder="Факты (по одному в строке: «Подпись: значение»)"></textarea></div><div class="cols"><input type="text" name="tolstenko_block_defaults[flagship][cards][' + idx + '][btn_text]" placeholder="Кнопка"><input type="text" name="tolstenko_block_defaults[flagship][cards][' + idx + '][btn_url]" placeholder="Ссылка кнопки"></div></div>';
				} else if (key === 'europe-rows-list') {
					html = '<div class="repeater-item" data-repeater-item><div class="cols"><input type="text" name="tolstenko_block_defaults[europe][rows][' + idx + '][country]" placeholder="Страна"><input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[europe][rows][' + idx + '][flag]" value="0"><button type="button" class="button tolstenko-defaults-pick-icon">Флаг</button><input type="text" name="tolstenko_block_defaults[europe][rows][' + idx + '][note]" placeholder="Примечание"><button type="button" class="button move-btn" data-move-up title="Вверх">↑</button><button type="button" class="button move-btn" data-move-down title="Вниз">↓</button><button type="button" class="button" data-remove-item>Удалить</button></div><div class="icon-preview" style="margin-top:8px;"></div><div class="cols"><input type="text" name="tolstenko_block_defaults[europe][rows][' + idx + '][price]" placeholder="Стоимость"><input type="text" name="tolstenko_block_defaults[europe][rows][' + idx + '][term]" placeholder="Срок оформления"></div><div class="row"><textarea name="tolstenko_block_defaults[europe][rows][' + idx + '][benefits]" rows="3" placeholder="Преимущества (по одному в строке)"></textarea></div><div class="cols"><input type="text" name="tolstenko_block_defaults[europe][rows][' + idx + '][link_text]" placeholder="Ссылка — текст"><input type="text" name="tolstenko_block_defaults[europe][rows][' + idx + '][link_url]" placeholder="Ссылка — URL"></div></div>';
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
			if (target === 'faq' || target === 'field_template' || target === 'about' || target === 'infra') refreshFaqEditors();
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

// ---------- Ссылки «Стоимость»: репитер как в записи «Команда» ----------
		(function(){
			var template = document.getElementById('cost-links-template');
			if (!template) return;

			var repeater = template.parentNode.querySelector('.cost-links-repeater');
			if (!repeater) return;

			var index = repeater.querySelectorAll('.cost-link-row').length;
			var frame = null;

			document.addEventListener('click', function(e){
				var target = e.target;
				if (!target || !target.closest) return;

				if (target.closest('.cost-add-link')) {
					e.preventDefault();
					repeater.insertAdjacentHTML('beforeend', template.innerHTML.replace(/__INDEX__/g, index));
					index++;
					return;
				}

				if (target.closest('.cost-remove-link')) {
					e.preventDefault();
					var rowToRemove = target.closest('.cost-link-row');
					if (rowToRemove) rowToRemove.remove();
					return;
				}if (target.closest('.cost-link-choose-icon')) {
					e.preventDefault();
					if (typeof wp === 'undefined' || !wp.media) return;

					var row = target.closest('.cost-link-row');
					if (!row) return;

					if (!frame) {
						frame = wp.media({
							title: 'Выберите SVG иконку',
							button: { text: 'Использовать иконку' },
							multiple: false,
							library: { type: 'image' }
						});

						frame.on('select', function(){
							var selection = frame.state().get('selection').first();
							if (!selection) return;

							var json = selection.toJSON();
							var activeRow = frame.__activeRow;
							if (!activeRow) return;

							activeRow.querySelector('.cost-link-icon-id').value = json.id || '';

							var preview = activeRow.querySelector('.cost-link-icon-preview');
							var img = (json.sizes && json.sizes.thumbnail && json.sizes.thumbnail.url) || json.url || '';

							if (preview) {
								preview.src = img;
								preview.style.display = img ? 'block' : 'none';
							}

							var removeIcon = activeRow.querySelector('.cost-link-remove-icon');
							if (removeIcon && img) removeIcon.classList.remove('hidden');
						});
					}

					frame.__activeRow = row;
					frame.open();
					return;
				}

				if (target.closest('.cost-link-remove-icon')) {
					e.preventDefault();
					var iconRow = target.closest('.cost-link-row');
					if (!iconRow) return;

					iconRow.querySelector('.cost-link-icon-id').value = '';

					var iconPreview = iconRow.querySelector('.cost-link-icon-preview');
					if (iconPreview) {
						iconPreview.src = '';
						iconPreview.style.display = 'none';
					}

					target.closest('.cost-link-remove-icon').classList.add('hidden');
				}
			});
		})();		function bindVideoPicker(scope){
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
