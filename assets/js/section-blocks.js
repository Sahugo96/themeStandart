(function (wp) {
  if (!wp || !wp.blocks || !wp.element || !wp.blockEditor || !window.themeBlockControls) {
    return;
  }

  var registerBlockType = wp.blocks.registerBlockType;
  var el = wp.element.createElement;
  var useBlockProps = wp.blockEditor.useBlockProps;
  var controls = window.themeBlockControls;
  var blocks = window.themeSimpleSectionBlocks || [];
  var sectionDefaults = window.themeSectionBlockDefaults || {};

  function getBlockDefaults(block) {
    if (!block.defaultsKey || !sectionDefaults[block.defaultsKey]) {
      return {};
    }

    return sectionDefaults[block.defaultsKey];
  }

  function emptyItem(itemFields) {
    var item = {};
    itemFields.forEach(function (itemField) {
      if (itemField.type === 'image') {
        item[itemField.key] = { id: 0, url: '', alt: '' };
      } else if (itemField.type === 'repeater') {
        item[itemField.key] = [];
      } else if (itemField.type === 'select') {
        item[itemField.key] = itemField.options && itemField.options.length ? itemField.options[0].value : '';
      } else {
        item[itemField.key] = '';
      }
    });
    return item;
  }

  /**
   * showIf: { key, values } — поле видно, только если значение поля key входит в values
   * (например, поля строки «SEO-наполнения» по выбранному виду). Пустое значение
   * select считается его первым вариантом — так же, как на сайте.
   */
  function isItemFieldVisible(itemField, item, itemFields) {
    var cond = itemField.showIf;
    if (!cond || !cond.key || !Array.isArray(cond.values)) {
      return true;
    }

    var current = item[cond.key];
    if (!current) {
      var source = itemFields.filter(function (f) { return f.key === cond.key; })[0];
      current = source && source.options && source.options.length ? source.options[0].value : '';
    }

    return cond.values.indexOf(current) !== -1;
  }

  /**
   * Повторитель; поле пункта с type: 'repeater' рисуется вложенным повторителем
   * (например, преимущества внутри строки таблицы).
   */
  function renderRepeater(field, value, keyPrefix, onChange, emptyHelp) {
    var items = Array.isArray(value) ? value : [];
    var itemFields = field.itemFields || [];

    return controls.repeaterField({
      label: field.label,
      help: items.length ? '' : (emptyHelp || ''),
      addLabel: field.addLabel || 'Добавить',
      itemLabel: field.itemLabel || 'Пункт',
      keyPrefix: keyPrefix,
      items: items,
      createItem: function () {
        return emptyItem(itemFields);
      },
      onChange: onChange,
      renderItem: function (item, index, updateItem, removeItem) {
        function setValue(key, next) {
          var nextItem = Object.assign({}, item);
          nextItem[key] = next;
          updateItem(nextItem);
        }

        return el(
          'div',
          null,
          itemFields.map(function (itemField) {
            if (!isItemFieldVisible(itemField, item, itemFields)) {
              return null;
            }

            if (itemField.type === 'repeater') {
              return el(
                'div',
                { key: itemField.key, style: { marginLeft: '12px' } },
                renderRepeater(itemField, item[itemField.key], keyPrefix + '-' + index + '-' + itemField.key, function (next) {
                  setValue(itemField.key, next);
                })
              );
            }

            if (itemField.type === 'image') {
              var imgValue = item[itemField.key];
              return controls.imageField({
                label: itemField.label,
                value: imgValue && imgValue.url
                  ? imgValue
                  : { id: imgValue && imgValue.id ? imgValue.id : 0, url: '', alt: '' },
                onChange: function (next) {
                  setValue(itemField.key, next);
                },
              });
            }

            if (itemField.type === 'select') {
              return controls.selectField({
                label: itemField.label,
                value: item[itemField.key] || '',
                options: itemField.options || [],
                onChange: function (next) {
                  setValue(itemField.key, next);
                },
              });
            }

            if (itemField.type === 'textarea') {
              return controls.textareaField({
                label: itemField.label,
                value: item[itemField.key] || '',
                onChange: function (next) {
                  setValue(itemField.key, next);
                },
              });
            }

            return controls.textField({
              label: itemField.label,
              value: item[itemField.key] || '',
              onChange: function (next) {
                setValue(itemField.key, next);
              },
            });
          }),
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
      },
    });
  }

  function renderField(field, attributes, setAttributes, defaults) {
    var value = attributes[field.attr];
    var placeholder = defaults[field.attr];

    if (field.type === 'text') {
      return controls.textField({
        label: field.label,
        help: field.help || 'Если пусто — из настроек темы',
        value: value || '',
        placeholder: typeof placeholder === 'string' ? placeholder : '',
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'editor' && typeof controls.richTextField === 'function') {
      return controls.richTextField({
        id: 'tolstenko_section_editor_' + String(field.attr || 'field').replace(/[^a-zA-Z0-9_-]/g, '') + '_' + Math.random().toString(36).slice(2, 8),
        label: field.label,
        value: value || '',
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'textarea') {
      return controls.textareaField({
        label: field.label,
        help: field.help || 'Если пусто — из настроек темы',
        value: value || '',
        placeholder: typeof placeholder === 'string' ? placeholder : '',
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'toggle') {
      return controls.toggleField({
        label: field.label,
        help: field.help || '',
        value: value !== undefined ? value : !!placeholder,
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'select') {
      return controls.selectField({
        label: field.label,
        help: field.help || '',
        value: value || '',
        options: field.options || [],
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'number') {
      return controls.numberField({
        label: field.label,
        help: field.help || '',
        value: value,
        min: field.min,
        max: field.max,
        placeholder: field.placeholder !== undefined ? String(field.placeholder) : '',
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'link') {
      return controls.linkField({
        label: field.label,
        help: field.help || 'Если пусто — из настроек темы',
        value: value && value.url ? value : (placeholder || { url: '', title: '', target: '' }),
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'image') {
      return controls.imageField({
        label: field.label,
        help: field.help || 'Если пусто — из настроек темы',
        value: value && value.url ? value : (placeholder || { id: 0, url: '', alt: '' }),
        onChange: function (next) {
          var patch = {};
          patch[field.attr] = next;
          setAttributes(patch);
        },
      });
    }

    // Выбор одной записи (как в «Шаблоне всех полей»): атрибут — id записи, 0 = из настроек темы.
    if (field.type === 'post') {
      var postId = parseInt(value, 10) || 0;
      var catalogs = (window.themeBlockDefaults && window.themeBlockDefaults.posts) || {};

      return controls.singlePostField({
        label: field.label,
        help: field.help || 'Если пусто — из настроек темы',
        postIds: postId > 0 ? [postId] : [],
        catalog: catalogs[field.postType || 'blog'] || [],
        placeholder: 'Начните вводить название…',
        onChange: function (ids) {
          var patch = {};
          patch[field.attr] = Array.isArray(ids) && ids.length ? (parseInt(ids[0], 10) || 0) : 0;
          setAttributes(patch);
        },
      });
    }

    // Множественный выбор записей: атрибут — массив id (порядок как добавляли), пусто = из настроек темы.
    if (field.type === 'posts') {
      var postIdsValue = Array.isArray(value) ? value.map(function (id) { return parseInt(id, 10) || 0; }).filter(Boolean) : [];
      var postsCatalogs = (window.themeBlockDefaults && window.themeBlockDefaults.posts) || {};

      return controls.postsField({
        label: field.label,
        help: field.help || (postIdsValue.length ? 'Порядок — как добавляли записи' : 'Если пусто — из настроек темы'),
        postIds: postIdsValue,
        catalog: postsCatalogs[field.postType || 'blog'] || [],
        placeholder: 'Начните вводить название…',
        onChange: function (ids) {
          var patch = {};
          patch[field.attr] = Array.isArray(ids) ? ids.map(function (id) { return parseInt(id, 10) || 0; }).filter(Boolean) : [];
          setAttributes(patch);
        },
      });
    }

    if (field.type === 'repeater') {
      return renderRepeater(field, value, field.attr, function (nextItems) {
        var patch = {};
        patch[field.attr] = nextItems;
        setAttributes(patch);
      }, 'Если список пуст — из настроек темы');
    }

    return null;
  }

  blocks.forEach(function (block) {
    var existing = wp.blocks.getBlockType(block.name);
    if (existing && existing.edit && !block.fields) {
      return;
    }

    registerBlockType(block.name, {
      apiVersion: 3,
      title: block.title,
      icon: block.icon || 'layout',
      category: block.category || 'tolstenko-general',
      edit: function (props) {
        var attributes = props.attributes;
        var setAttributes = props.setAttributes;
        var defaults = getBlockDefaults(block);
        var blockProps = useBlockProps({
          className: 'theme-block theme-block--section',
          style: controls.blockShell(block.color || controls.colors.accent),
        });
        var fields = [controls.blockTitle(block.title, block.color || controls.colors.accent)];

        if (block.fields && block.fields.length) {
          block.fields.forEach(function (field) {
            fields.push(renderField(field, attributes, setAttributes, defaults));
          });
        } else if (block.hasTextFields) {
          fields.push(
            controls.textField({
              label: 'Заголовок',
              help: 'Если пусто — из ACF страницы или настроек',
              value: attributes.title || '',
              onChange: function (value) { setAttributes({ title: value }); },
            }),
            controls.textareaField({
              label: 'Текст',
              help: 'Если пусто — из ACF страницы',
              value: attributes.text || '',
              onChange: function (value) { setAttributes({ text: value }); },
            })
          );
        }

        fields.push(controls.blockHint(block.hint || 'На сайте — данные из настроек темы'));
        return el.apply(null, ['div', blockProps].concat(fields));
      },
      save: function () { return null; },
    });
  });
})(window.wp);
