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
          label: 'Заголовок',
          help: 'Если пусто — из страницы настроек',
          value: attributes.title,
          placeholder: faqDefaults.title || '',
          onChange: function (value) {
            setAttributes({ title: value });
          },
        }),
        controls.textareaField({
          label: 'Текст под заголовком',
          help: 'Если пусто — из страницы настроек',
          value: attributes.text,
          placeholder: faqDefaults.text || '',
          onChange: function (value) {
            setAttributes({ text: value });
          },
        }),
        controls.repeaterField({
          label: 'Вопросы',
          help: items.length ? '' : 'Если список пуст — используются данные из настроек темы',
          items: items,
          keyPrefix: 'faq-item',
          itemLabel: 'Вопрос',
          addLabel: 'Добавить вопрос',
          createItem: function () {
            return { title: '', redactor: '' };
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
                value: item.title || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { title: value }));
                },
              }),
              controls.textareaField({
                label: 'Ответ',
                value: item.redactor || '',
                onChange: function (value) {
                  updateItem(Object.assign({}, item, { redactor: value }));
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
        })
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/free-consultation', {
    apiVersion: 3,
    edit: function () {
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--free-consultation',
        style: Object.assign({}, controls.blockShell(colors.accentYellowDark), {
          padding: '15px',
          textAlign: 'center',
        }),
      });

      return el(
        'div',
        blockProps,
        el('p', { style: { margin: 0, color: colors.textMuted } }, 'Бесплатная консультация (контент из настроек темы)')
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

  registerBlockType('my-theme/consultation-tel', {
    apiVersion: 3,
    edit: function () {
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--consultation-tel',
        style: Object.assign({}, controls.blockShell(colors.accent), {
          padding: '15px',
          textAlign: 'center',
        }),
      });

      return el(
        'div',
        blockProps,
        el('p', { style: { margin: 0, color: colors.textMuted } }, 'Подходящий вариант (контент из настроек темы)')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/team', {
    apiVersion: 3,
    edit: function () {
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--team',
        style: Object.assign({}, controls.blockShell(colors.accent), {
          padding: '15px',
          textAlign: 'center',
        }),
      });

      return el(
        'div',
        blockProps,
        el('p', { style: { margin: 0, color: colors.textMuted } }, 'Команда (контент из настроек темы)')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/documents', {
    apiVersion: 3,
    edit: function () {
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--documents',
        style: Object.assign({}, controls.blockShell(colors.accentYellowDark), {
          padding: '15px',
          textAlign: 'center',
        }),
      });

      return el(
        'div',
        blockProps,
        el('p', { style: { margin: 0, color: colors.textMuted } }, 'Документы (контент из настроек темы)')
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('my-theme/partners', {
    apiVersion: 3,
    edit: function () {
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--partners',
        style: Object.assign({}, controls.blockShell(colors.accent), {
          padding: '15px',
          textAlign: 'center',
        }),
      });

      return el(
        'div',
        blockProps,
        el('p', { style: { margin: 0, color: colors.textMuted } }, 'Партнёры (контент из настроек темы)')
      );
    },
    save: function () {
      return null;
    },
  });


  registerBlockType('my-theme/consultation-tg', {
    apiVersion: 3,
    edit: function () {
      var blockProps = useBlockProps({
        className: 'theme-block theme-block--consultation-tg',
        style: Object.assign({}, controls.blockShell('#2AABEE'), {
          padding: '15px',
          textAlign: 'center',
        }),
      });

      return el(
        'div',
        blockProps,
        el('p', { style: { margin: 0, color: colors.textMuted } }, 'Консультация Telegram (контент из настроек темы)')
      );
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
