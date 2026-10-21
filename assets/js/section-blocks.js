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

    if (field.type === 'repeater') {
      var items = Array.isArray(value) ? value : [];
      var itemFields = field.itemFields || [];

      return controls.repeaterField({
        label: field.label,
        help: items.length ? '' : 'Если список пуст — из настроек темы',
        addLabel: field.addLabel || 'Добавить',
        itemLabel: field.itemLabel || 'Пункт',
        keyPrefix: field.attr,
        items: items,
        createItem: function () {
          var item = {};
          itemFields.forEach(function (itemField) {
            item[itemField.key] = itemField.type === 'image' ? { id: 0, url: '', alt: '' } : '';
          });
          return item;
        },
        onChange: function (nextItems) {
          var patch = {};
          patch[field.attr] = nextItems;
          setAttributes(patch);
        },
        renderItem: function (item, index, updateItem, removeItem) {
          return el(
            'div',
            null,
            itemFields.map(function (itemField) {
              if (itemField.type === 'image') {
                var imgValue = item[itemField.key];
                return controls.imageField({
                  label: itemField.label,
                  value: imgValue && imgValue.url
                    ? imgValue
                    : { id: imgValue && imgValue.id ? imgValue.id : 0, url: '', alt: '' },
                  onChange: function (next) {
                    var nextItem = Object.assign({}, item);
                    nextItem[itemField.key] = next;
                    updateItem(nextItem);
                  },
                });
              }

              if (itemField.type === 'textarea') {
                return controls.textareaField({
                  label: itemField.label,
                  value: item[itemField.key] || '',
                  onChange: function (next) {
                    var nextItem = Object.assign({}, item);
                    nextItem[itemField.key] = next;
                    updateItem(nextItem);
                  },
                });
              }

              return controls.textField({
                label: itemField.label,
                value: item[itemField.key] || '',
                onChange: function (next) {
                  var nextItem = Object.assign({}, item);
                  nextItem[itemField.key] = next;
                  updateItem(nextItem);
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
      icon: 'layout',
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
