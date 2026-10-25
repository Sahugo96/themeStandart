(function (wp) {
  if (!wp || !wp.blocks || !wp.element || !wp.blockEditor || !window.themeBlockControls) {
    return;
  }

  var registerBlockType = wp.blocks.registerBlockType;
  var el = wp.element.createElement;
  var useBlockProps = wp.blockEditor.useBlockProps;
  var InnerBlocks = wp.blockEditor.InnerBlocks;
  var controls = window.themeBlockControls;
  var colors = controls.colors;
  var defaults = window.themeBlockDefaults || {};
  var useState = wp.element.useState;
  var useRef = wp.element.useRef;
  var useEffect = wp.element.useEffect;
  var Modal = wp.components && wp.components.Modal;
  var Button = wp.components && wp.components.Button;
  var TextareaControl = wp.components && wp.components.TextareaControl;

  var HIDDEN_BLOCK_ALLOWED = [
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/list-item',
    'core/quote',
    'core/html',
  ];

  function getDefaults(key) {
    return defaults[key] || {};
  }


  registerBlockType('my-theme/service-section', {
    apiVersion: 3,
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var serviceDefaults = getDefaults('serviceSection');
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--service-section',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Архив услуг', colors.accent),
        controls.textField({
          label: 'Заголовок',
          help: 'Если пусто — из настроек темы',
          value: attributes.title,
          placeholder: serviceDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.textareaField({
          label: 'Текст',
          help: 'Если пусто — из настроек темы',
          value: attributes.text,
          placeholder: serviceDefaults.text || '',
          onChange: function (value) {
            setAttributes({ text: value });
          },
        }),
        controls.blockHint('Выводятся все услуги. Фильтр по категориям — ссылки на архив и рубрики')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/services-slider', {
    apiVersion: 3,
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var sliderDefaults = getDefaults('servicesSlider');
      var postCatalog = (defaults.posts && defaults.posts.service) || [];
      var postIds = Array.isArray(attributes.postIds) ? attributes.postIds : [];
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--services-slider',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Слайдер услуг', colors.accent),
        controls.textField({
          label: 'Заголовок',
          help: 'Если пусто — из настроек темы',
          value: attributes.title,
          placeholder: sliderDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.textareaField({
          label: 'Текст',
          help: 'Если пусто — из настроек темы',
          value: attributes.text,
          placeholder: sliderDefaults.text || '',
          onChange: function (value) {
            setAttributes({ text: value });
          },
        }),
        controls.postsField({
          label: 'Услуги',
          help: postIds.length
            ? 'Порядок на сайте — как добавляли записи'
            : 'Если пусто — услуги из настроек темы',
          postIds: postIds,
          catalog: postCatalog,
          placeholder: 'Начните вводить название услуги…',
          onChange: function (value) {
            setAttributes({ postIds: value });
          },
        }),
        controls.blockHint('Слайдер с AJAX-фильтром по категориям')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/services-slider-simple', {
    apiVersion: 3,
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var sliderDefaults = getDefaults('servicesSlider');
      var postCatalog = (defaults.posts && defaults.posts.service) || [];
      var postIds = Array.isArray(attributes.postIds) ? attributes.postIds : [];
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--services-slider-simple',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Слайдер услуг (без фильтра)', colors.accent),
        controls.textField({
          label: 'Заголовок',
          help: 'Если пусто — из настроек темы',
          value: attributes.title,
          placeholder: sliderDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.textareaField({
          label: 'Текст',
          help: 'Если пусто — из настроек темы',
          value: attributes.text,
          placeholder: sliderDefaults.text || '',
          onChange: function (value) {
            setAttributes({ text: value });
          },
        }),
        controls.postsField({
          label: 'Услуги',
          help: postIds.length
            ? 'Порядок на сайте — как добавляли записи'
            : 'Если пусто — услуги из настроек темы',
          postIds: postIds,
          catalog: postCatalog,
          placeholder: 'Начните вводить название услуги…',
          onChange: function (value) {
            setAttributes({ postIds: value });
          },
        }),
        controls.blockHint('Простой слайдер без фильтра по категориям')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/blog-section', {
    apiVersion: 3,
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var blogDefaults = getDefaults('blogSection');
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--blog-section',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Секция статей', colors.accent),
        controls.textField({
          label: 'Заголовок',
          help: 'Если пусто — из настроек темы',
          value: attributes.title,
          placeholder: blogDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.textareaField({
          label: 'Текст',
          help: 'Если пусто — из настроек темы',
          value: attributes.text,
          placeholder: blogDefaults.text || '',
          onChange: function (value) {
            setAttributes({ text: value });
          },
        }),
        controls.blockHint('Слайдер с AJAX-фильтром по категориям. Кнопка — из настроек темы')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/reviews-section', {
    apiVersion: 3,
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var reviewsDefaults = getDefaults('reviewsSection');
      var postCatalog = (defaults.posts && defaults.posts.review) || [];
      var postIds = Array.isArray(attributes.postIds) ? attributes.postIds : [];
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--reviews-section',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Отзывы (секция)', colors.accent),
        controls.textField({
          label: 'Заголовок',
          help: 'Если пусто — из настроек темы',
          value: attributes.title,
          placeholder: reviewsDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.postsField({
          label: 'Отзывы',
          help: postIds.length
            ? 'Порядок на сайте — как добавляли записи'
            : 'Если пусто — отзывы из настроек темы',
          postIds: postIds,
          catalog: postCatalog,
          placeholder: 'Начните вводить название отзыва…',
          onChange: function (value) {
            setAttributes({ postIds: value });
          },
        }),
        controls.blockHint('Рейтинги площадок — из настроек темы')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/faq', {
    apiVersion: 3,
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var faqDefaults = getDefaults('faq');
      var items = Array.isArray(attributes.items) ? attributes.items : [];
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--faq',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('FAQ', colors.accent),
        controls.textField({
          label: 'Надзаголовок (бейдж)',
          help: 'Если пусто — из ACF-поля faq_badge',
          value: attributes.badge,
          placeholder: faqDefaults.badge || '',
          onChange: function (value) {
            setAttributes({ badge: value });
          },
        }),
        controls.textField({
          label: 'Заголовок',
          help: 'Если пусто — из ACF-поля faq_title',
          value: attributes.title,
          placeholder: faqDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.repeaterField({
          label: 'Вопросы',
          help: items.length ? '' : 'Если список пуст — берётся из ACF-поля faq_items',
          items: items,
          keyPrefix: 'faq-item',
          itemLabel: 'Вопрос',
          addLabel: 'Добавить вопрос',
          createItem: function () {
            return { quest: '', unswer: '' };
          },
          onChange: function (nextItems) {
            setAttributes({ items: nextItems });
          },
          renderItem: function (item, index, updateItem, removeItem) {
            return el(
              'div',
              null,
              controls.textField({
                label: 'Вопрос ' + (index + 1),
                value: item.quest || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { quest: value }));
                },
              }),
              controls.textareaField({
                label: 'Ответ',
                value: item.unswer || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { unswer: value }));
                },
              }),
              el(
                wp.components.Button,
                {
                  isDestructive: true,
                  variant: 'secondary',
                  onClick: removeItem,
                },
                'Удалить вопрос'
              )
            );
          },
        }),
        controls.textField({
          label: 'Заголовок формы',
          help: 'Если пусто — из ACF-поля faq_form_title',
          value: attributes.form_title,
          placeholder: faqDefaults.form_title || '',
          onChange: function (value) {
            setAttributes({ form_title: value });
          },
        }),
        controls.textField({
          label: 'Текст формы',
          help: 'Если пусто — из ACF-поля faq_form_text',
          value: attributes.form_text,
          placeholder: faqDefaults.form_text || '',
          onChange: function (value) {
            setAttributes({ form_text: value });
          },
        })
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/documents', {
    apiVersion: 3,
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var docsDefaults = getDefaults('documents');
      var items = Array.isArray(attributes.items) ? attributes.items : [];
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--documents',
        style: controls.blockShell(colors.accentYellowDark),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Документы', colors.accentYellowDark),
        controls.textField({
          label: 'Надзаголовок (бейдж)',
          help: 'Если пусто — из «Дефолты блоков → Документы»',
          value: attributes.subtitle,
          placeholder: docsDefaults.subtitle || '',
          onChange: function (value) {
            setAttributes({ subtitle: value });
          },
        }),
        controls.textField({
          label: 'Заголовок',
          help: 'Если пусто — из «Дефолты блоков → Документы»',
          value: attributes.title,
          placeholder: docsDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.repeaterField({
          label: 'Документы',
          help: items.length ? '' : 'Если список пуст — из «Дефолты блоков → Документы»',
          items: items,
          keyPrefix: 'documents-item',
          itemLabel: 'Документ',
          addLabel: 'Добавить документ',
          createItem: function () {
            return { title: '', text: '', attributes: '', image: { id: 0, url: '', alt: '' } };
          },
          onChange: function (nextItems) {
            setAttributes({ items: nextItems });
          },
          renderItem: function (item, index, updateItem, removeItem) {
            return el(
              'div',
              null,
              controls.imageField({
                label: 'Изображение',
                value: item.image && item.image.url ? item.image : { id: 0, url: '', alt: '' },
                onChange: function (media) {
                  updateItem(Object.assign({}, item, { image: media }));
                },
              }),
              controls.textField({
                label: 'Заглавие',
                value: item.title || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { title: value }));
                },
              }),
              controls.textareaField({
                label: 'Описание',
                value: item.text || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { text: value }));
                },
              }),
              controls.textareaField({
                label: 'Атрибуты (по одному в строке)',
                value: item.attributes || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { attributes: value }));
                },
              }),
              el(
                wp.components.Button,
                { isDestructive: true, variant: 'secondary', onClick: removeItem },
                'Удалить'
              )
            );
          },
        })
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/hidden-block', {
    apiVersion: 3,
    edit: function () {
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--hidden-block',
        style: controls.blockShell(colors.borderStrong),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Скрытый блок', colors.borderStrong),
        controls.blockHint('SEO-текст. На сайте скрыт классом hide — посетители его не видят. Контент свой на каждой странице.'),
        el(
          'div',
          {
            style: {
              marginTop: '12px',
              padding: '12px',
              border: '1px dashed ' + colors.border,
              background: colors.surface,
              minHeight: '96px',
            },
          },
          el(InnerBlocks, {
            allowedBlocks: HIDDEN_BLOCK_ALLOWED,
            template: [['core/paragraph', {}]],
            templateLock: false,
          })
        )
      );
    },
    save: function () {
      return el(InnerBlocks.Content);
    },
  });

  // —— Rich-text редактор (как «Фото + текст» в editor-blocks.js) ——
  // Превью + модалка с настоящим wp.editor (TinyMCE), как у FAQ.
  var TOLSTENKO_MCE = {
    wpautop: true,
    plugins: 'charmap colorpicker hr lists paste tabfocus textcolor wordpress wpautoresize wpeditimage wpemoji wpgallery wplink wptextpattern',
    toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_adv',
    toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo',
    height: 320
  };

  function themeClassicEditor() {
    if (wp.editor && typeof wp.editor.initialize === 'function') {
      return wp.editor;
    }
    if (wp.oldEditor && typeof wp.oldEditor.initialize === 'function') {
      return wp.oldEditor;
    }
    return null;
  }

  function stripHtmlPreview(html) {
    var tmp = document.createElement('div');
    tmp.innerHTML = String(html || '');
    var text = (tmp.textContent || tmp.innerText || '').replace(/\s+/g, ' ').trim();
    if (!text) {
      return 'Пусто — нажмите «Редактировать»';
    }
    return text.length > 160 ? (text.slice(0, 160) + '…') : text;
  }

  function ThemeRichTextField(props) {
    var id = props.id;
    var label = props.label || '';
    var value = props.value || '';
    var onChange = props.onChange;
    var openState = useState(false);
    var open = openState[0];
    var setOpen = openState[1];
    var draftRef = useRef(value);
    var hostRef = useRef(null);
    var editorLib = themeClassicEditor();

    useEffect(function () {
      if (!open) return undefined;
      draftRef.current = value || '';
      if (!hostRef.current || !id || !editorLib) return undefined;

      var host = hostRef.current;
      host.innerHTML = '';
      var ta = document.createElement('textarea');
      ta.id = id;
      ta.className = 'wp-editor-area';
      ta.rows = 12;
      ta.value = draftRef.current;
      host.appendChild(ta);

      function mceSettings() {
        return {
          tinymce: Object.assign({}, TOLSTENKO_MCE, {
            setup: function (editor) {
              editor.on('init', function () {
                editor.setContent(draftRef.current || '');
              });
              editor.on('change keyup Undo Redo', function () {
                draftRef.current = editor.getContent();
              });
            }
          }),
          quicktags: true,
          mediaButtons: true
        };
      }

      var timer = window.setTimeout(function () {
        try { editorLib.remove(id); } catch (e0) {}
        try {
          editorLib.initialize(id, mceSettings());
        } catch (e1) {
          // Если quicktags недоступны — пробуем без них.
          try {
            var fallback = mceSettings();
            fallback.quicktags = false;
            editorLib.initialize(id, fallback);
          } catch (e2) {}
        }
      }, 50);

      return function () {
        window.clearTimeout(timer);
        if (window.tinymce) {
          var ed = window.tinymce.get(id);
          if (ed) {
            try { draftRef.current = ed.getContent(); } catch (e3) {}
          }
        }
        try { editorLib.remove(id); } catch (e4) {}
        host.innerHTML = '';
      };
    }, [open, id]);

    function readDraft() {
      var ed = window.tinymce ? window.tinymce.get(id) : null;
      if (ed) {
        try { draftRef.current = ed.getContent(); } catch (e5) {}
        return;
      }
      if (hostRef.current) {
        var ta = hostRef.current.querySelector('textarea');
        if (ta) {
          draftRef.current = ta.value;
        }
      }
    }

    function saveAndClose() {
      readDraft();
      if (typeof onChange === 'function') {
        onChange(draftRef.current || '');
      }
      setOpen(false);
    }

    // Если TinyMCE недоступен — обычная текстовая область с HTML.
    if (!editorLib && TextareaControl) {
      return el(TextareaControl, {
        label: (label || 'Редактор') + ' (HTML)',
        help: 'Визуальный редактор недоступен — введите HTML вручную',
        value: value,
        rows: 8,
        onChange: onChange
      });
    }

    return el('div', { className: 'tolstenko-seo-text-editor', style: { margin: '8px 0 12px' } }, [
      label ? el('p', {
        key: 'l',
        style: { margin: '0 0 6px', fontSize: '11px', fontWeight: '600', textTransform: 'uppercase', color: '#1e1e1e' }
      }, label) : null,
      el('div', {
        key: 'preview',
        style: {
          border: '1px solid #c3c4c7',
          borderRadius: '2px',
          background: '#fff',
          padding: '10px 12px',
          minHeight: '72px',
          color: value ? '#1e1e1e' : '#757575',
          fontSize: '13px',
          lineHeight: '1.45',
          marginBottom: '8px'
        }
      }, stripHtmlPreview(value)),
      Button ? el(Button, {
        key: 'edit',
        isSecondary: true,
        isSmall: true,
        onClick: function () { setOpen(true); }
      }, 'Редактировать') : null,
      (open && Modal) ? el(Modal, {
        key: 'modal',
        title: label || 'Редактор',
        onRequestClose: function () { setOpen(false); },
        style: { maxWidth: '820px', width: '92vw' }
      }, [
        el('div', { key: 'host', ref: hostRef, className: 'tolstenko-seo-text-editor-host', style: { minHeight: '360px' } }),
        el('div', {
          key: 'actions',
          style: { display: 'flex', gap: '8px', justifyContent: 'flex-end', marginTop: '16px' }
        }, [
          el(Button, {
            key: 'cancel',
            isSecondary: true,
            onClick: function () { setOpen(false); }
          }, 'Отмена'),
          el(Button, {
            key: 'save',
            isPrimary: true,
            onClick: saveAndClose
          }, 'Готово')
        ])
      ]) : null
    ]);
  }

  // Эталонный блок «Шаблон всех полей»: демонстрирует все типы полей.
  // Атрибуты image_id / post_ids / single_post_id — числовые/массивы id,
  // поэтому imageField адаптируется под число вручную.
  function fieldTemplateImageUrl(id) {
    try {
      if (id && window.wp && wp.data && wp.data.select) {
        var att = wp.data.select('core').getEntityRecord('postType', 'attachment', id);
        if (att && att.source_url) {
          return att.source_url;
        }
      }
    } catch (e) {}
    return '';
  }

  registerBlockType('my-theme/field-template', {
    apiVersion: 3,
    title: 'Шаблон всех полей',
    category: 'tolstenko-general',
    icon: 'editor-table',
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var items = Array.isArray(attributes.items) ? attributes.items : [];
      var postIds = Array.isArray(attributes.post_ids) ? attributes.post_ids : [];
      var imageId = parseInt(attributes.image_id, 10) || 0;
      var singlePostId = parseInt(attributes.single_post_id, 10) || 0;
      var singlePostIds = singlePostId > 0 ? [singlePostId] : [];
      var postCatalog = (defaults.posts && defaults.posts.blog) || [];
      var editorFieldId = 'tolstenko_field_template_editor_' + String(props.clientId || Math.random().toString(36).slice(2)).replace(/[^a-zA-Z0-9_-]/g, '');
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--field-template',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Шаблон всех полей', colors.accent),
        controls.toggleField({
          label: 'Включить / показывать блок (чекбокс)',
          help: 'Если выключено — блок не выводится',
          value: !!attributes.enabled,
          onChange: function (value) {
            setAttributes({ enabled: value });
          },
        }),
        controls.textField({
          label: 'Текстовое поле',
          value: attributes.text_field || '',
          onChange: function (value) {
            setAttributes({ text_field: value });
          },
        }),
        controls.textareaField({
          label: 'Текстовая область',
          value: attributes.textarea_field || '',
          onChange: function (value) {
            setAttributes({ textarea_field: value });
          },
        }),
        el(ThemeRichTextField, {
          key: 'editor-field',
          id: editorFieldId,
          label: 'Редактор (rich text)',
          value: attributes.editor_field || '',
          onChange: function (value) {
            setAttributes({ editor_field: value });
          },
        }),
        controls.imageField({
          label: 'Изображение',
          value: { id: imageId, url: fieldTemplateImageUrl(imageId), alt: '' },
          onChange: function (media) {
            setAttributes({ image_id: media && media.id ? parseInt(media.id, 10) : 0 });
          },
        }),
        controls.repeaterField({
          label: 'Повторитель',
          help: items.length ? '' : 'Пусто — берётся из настроек темы',
          items: items,
          keyPrefix: 'field-template-item',
          itemLabel: 'Пункт',
          addLabel: 'Добавить пункт',
          createItem: function () {
            return { title: '', text: '' };
          },
          onChange: function (nextItems) {
            setAttributes({ items: nextItems });
          },
          renderItem: function (item, index, updateItem, removeItem) {
            return el(
              'div',
              null,
              controls.textField({
                label: 'Заголовок',
                value: item.title || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { title: value }));
                },
              }),
              controls.textareaField({
                label: 'Текст',
                value: item.text || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { text: value }));
                },
              }),
              el(
                wp.components.Button,
                { isDestructive: true, variant: 'secondary', onClick: removeItem },
                'Удалить'
              )
            );
          },
        }),
        controls.postsField({
          label: 'Множественный выбор записей',
          help: postIds.length ? 'Порядок — как добавляли записи' : 'Пусто — все записи',
          postIds: postIds,
          catalog: postCatalog,
          placeholder: 'Начните вводить название статьи…',
          onChange: function (value) {
            setAttributes({ post_ids: value });
          },
        }),
        controls.singlePostField({
          label: 'Одна запись',
          help: singlePostIds.length ? 'Запись выбрана' : 'Пусто — без записи',
          postIds: singlePostIds,
          catalog: postCatalog,
          placeholder: 'Начните вводить название статьи…',
          onChange: function (ids) {
            setAttributes({ single_post_id: Array.isArray(ids) && ids.length ? (parseInt(ids[0], 10) || 0) : 0 });
          },
        }),
        controls.blockHint('Эталонный блок: чекбокс, текст, область, редактор, изображение, повторитель, записи')
      );
    },
    save: function () {
      return null;
    },
  });

  // Блок «Главный баннер» (my-theme/main-hero)
  function mainHeroImageUrl(id) {
    try {
      if (id && window.wp && wp.data && wp.data.select) {
        var att = wp.data.select('core').getEntityRecord('postType', 'attachment', id);
        if (att && att.source_url) {
          return att.source_url;
        }
      }
    } catch (e) {}
    return '';
  }

  registerBlockType('my-theme/main-hero', {
    apiVersion: 3,
    title: 'Главный баннер',
    category: 'tolstenko-general',
    icon: 'cover-image',
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var defaults = getDefaults('main_hero') || {};
      var items = Array.isArray(attributes.block_main_hero_items) ? attributes.block_main_hero_items.slice() : [];
      var imageId = parseInt(attributes.block_main_hero_image, 10) || 0;
      var presentId = parseInt(attributes.block_main_hero_present_image, 10) || 0;
      var showPromo = String(attributes.block_main_hero_show_promo || '') === '1' || (String(attributes.block_main_hero_show_promo || '') === '' && defaults.show_promo === true);

      function setItems(next) { setAttributes({ block_main_hero_items: next }); }

      function moveItem(index, direction) {
        var nextItems = items.slice();
        var target = index + direction;
        if (target < 0 || target >= nextItems.length) { return; }
        var tmp = nextItems[index];
        nextItems[index] = nextItems[target];
        nextItems[target] = tmp;
        setItems(nextItems);
      }

      var blockProps = useBlockProps({
        className: 'theme-block theme-block--main-hero',
        style: controls.blockShell(colors.accent),
      });

      return el(
        'div',
        blockProps,
        controls.blockTitle('Главный баннер', colors.accent),
        el('p', {
          key: 'note',
          style: { marginTop: 0, marginBottom: '12px', opacity: 0.7, fontSize: '12px' }
        }, 'Пустые поля = дефолты. Кнопка открывает модалку заявки.'),
        controls.textField({
          key: 'badge',
          label: 'Бейдж над заголовком',
          value: attributes.block_main_hero_badge || '',
          placeholder: defaults.badge || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_badge: value });
          }
        }),
        controls.textareaField({
          key: 'title',
          label: 'Заголовок (HTML, акцентная часть — в <span>)',
          value: attributes.block_main_hero_title || '',
          placeholder: defaults.title || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_title: value });
          },
          rows: 2
        }),
        controls.textField({
          key: 'title-tag',
          label: 'Тег заголовка',
          value: attributes.block_main_hero_title_tag || 'h1',
          placeholder: 'h1',
          help: 'h1, h2, h3, h4, h5 или h6',
          onChange: function (value) {
            setAttributes({ block_main_hero_title_tag: value });
          }
        }),
        controls.textareaField({
          key: 'text',
          label: 'Текст (HTML)',
          value: attributes.block_main_hero_text || '',
          placeholder: defaults.text || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_text: value });
          },
          rows: 3
        }),
        el('p', {
          key: 'items-label',
          style: { marginBottom: '6px', fontWeight: '600' }
        }, 'Пункты списка (HTML)'),
        controls.repeaterField({
          key: 'items',
          label: null,
          items: items,
          keyPrefix: 'main-hero-item',
          itemLabel: 'Пункт',
          addLabel: 'Добавить пункт',
          createItem: function () {
            return { title: '', text: '' };
          },
          onChange: setItems,
          renderItem: function (item, index, updateItem, removeItem) {
            return el(
              'div',
              null,
              controls.textField({
                label: 'Пункт ' + (index + 1) + ': акцент (золотым)',
                value: item.title || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { title: value }));
                }
              }),
              controls.textareaField({
                label: 'Текст',
                value: item.text || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { text: value }));
                },
                rows: 2
              }),
              el(
                wp.components.Button,
                {
                  variant: 'secondary',
                  onClick: function () { moveItem(index, -1); },
                  disabled: index === 0,
                },
                '↑ Вверх'
              ),
              el(
                wp.components.Button,
                {
                  variant: 'secondary',
                  onClick: function () { moveItem(index, 1); },
                  disabled: index === items.length - 1,
                },
                '↓ Вниз'
              ),
              el(
                wp.components.Button,
                {
                  isDestructive: true,
                  variant: 'secondary',
                  onClick: removeItem,
                },
                'Удалить'
              )
            );
          }
        }),
        controls.textField({
          key: 'btn',
          label: 'Текст кнопки',
          value: attributes.block_main_hero_btn_text || '',
          placeholder: defaults.btn_text || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_btn_text: value });
          }
        }),
        controls.textField({
          key: 'btn-subtext',
          label: 'Подпись под текстом кнопки',
          value: attributes.block_main_hero_btn_subtext || '',
          placeholder: defaults.btn_subtext || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_btn_subtext: value });
          }
        }),
        controls.toggleField({
          key: 'promo',
          label: 'Показать промо у кнопки',
          value: showPromo,
          help: 'Если включено — отображается текст промо под кнопкой',
          onChange: function (value) {
            setAttributes({ block_main_hero_show_promo: value ? '1' : '0' });
          }
        }),
        controls.textareaField({
          key: 'promo-text',
          label: 'Текст промо (HTML)',
          value: attributes.block_main_hero_promo_text || '',
          placeholder: defaults.promo_text || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_promo_text: value });
          },
          rows: 2
        }),
        controls.imageField({
          key: 'present-image',
          label: 'Иконка подарка',
          value: { id: presentId, url: mainHeroImageUrl(presentId), alt: '' },
          onChange: function (media) {
            setAttributes({ block_main_hero_present_image: media && media.id ? parseInt(media.id, 10) : 0 });
          }
        }),
        controls.textField({
          key: 'person-name',
          label: 'Имя персоны',
          value: attributes.block_main_hero_person_name || '',
          placeholder: defaults.person_name || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_person_name: value });
          }
        }),
        controls.textField({
          key: 'person-position',
          label: 'Должность',
          value: attributes.block_main_hero_person_position || '',
          placeholder: defaults.person_position || '',
          onChange: function (value) {
            setAttributes({ block_main_hero_person_position: value });
          }
        }),
        controls.imageField({
          key: 'image',
          label: 'Изображение баннера',
          value: { id: imageId, url: mainHeroImageUrl(imageId), alt: '' },
          onChange: function (media) {
            setAttributes({ block_main_hero_image: media && media.id ? parseInt(media.id, 10) : 0 });
          }
        }),
        controls.blockHint('Эталонный блок главного баннера: заголовок, текст, список, кнопка, промо, фото персоны и изображения.')
      );
    },
    save: function () {
      return null;
    },
  });

  // Общий rich-text контрол для generic-блоков (section-blocks.js).
  if (controls && !controls.richTextField) {
    controls.richTextField = function (options) {
      return el(ThemeRichTextField, {
        id: options.id,
        label: options.label,
        value: options.value,
        onChange: options.onChange,
      });
    };
  }

})(window.wp);
