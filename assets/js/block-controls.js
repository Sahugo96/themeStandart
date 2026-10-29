(function (wp) {
  if (!wp || !wp.element || !wp.components) {
    return;
  }

  var el = wp.element.createElement;
  var useState = wp.element.useState;
  var MediaUpload = wp.blockEditor && wp.blockEditor.MediaUpload;
  var MediaUploadCheck = wp.blockEditor && wp.blockEditor.MediaUploadCheck;
  var Button = wp.components.Button;
  var ToggleControl = wp.components.ToggleControl;

  var colors = {
    accent: '#AE1730',
    accentBright: '#FF2146',
    accentYellow: '#FACA64',
    accentYellowDark: '#F7A800',
    surface: '#FFFFFF',
    border: '#E6E6E6',
    borderStrong: '#343434',
    text: '#1A1A1A',
    textMuted: '#7F7F7F',
  };

  function blockShell(accentColor) {
    return {
      padding: '20px',
      borderRadius: '4px',
      background: colors.surface,
      border: '1px solid ' + colors.border,
      borderLeft: '4px solid ' + (accentColor || colors.accent),
      color: colors.text,
    };
  }

  function blockTitle(text, accentColor) {
    return el('p', {
      style: {
        margin: '0 0 16px',
        fontWeight: '600',
        color: accentColor || colors.accent,
      },
    }, text);
  }

  function blockHint(text) {
    return el('p', {
      style: {
        margin: '12px 0 0',
        color: colors.textMuted,
        fontSize: '12px',
      },
    }, text);
  }

  var styles = {
    field: { marginBottom: '16px' },
    label: { display: 'block', marginBottom: '6px', fontWeight: '600', fontSize: '13px', color: colors.text },
    help: { display: 'block', marginTop: '4px', color: colors.textMuted, fontSize: '12px' },
    input: {
      width: '100%',
      padding: '8px',
      border: '1px solid ' + colors.border,
      borderRadius: '4px',
      boxSizing: 'border-box',
      fontSize: '14px',
      color: colors.text,
      background: colors.surface,
    },
    textarea: {
      width: '100%',
      minHeight: '80px',
      padding: '8px',
      border: '1px solid ' + colors.border,
      borderRadius: '4px',
      boxSizing: 'border-box',
      fontSize: '14px',
      resize: 'vertical',
      color: colors.text,
      background: colors.surface,
    },
    repeaterItem: {
      marginBottom: '12px',
      padding: '12px',
      border: '1px solid ' + colors.border,
      borderRadius: '4px',
      background: colors.surface,
    },
    repeaterItemHeader: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: '8px',
      marginBottom: '12px',
    },
    repeaterItemTitle: {
      fontWeight: '600',
      fontSize: '13px',
      color: colors.textMuted,
    },
    imagePreview: {
      maxWidth: '100%',
      height: 'auto',
      display: 'block',
      marginBottom: '8px',
      borderRadius: '4px',
    },
    row: { display: 'flex', gap: '8px', flexWrap: 'wrap' },
  };

  function stopBubble(event) {
    event.stopPropagation();
  }

  function fieldWrap(label, help, content) {
    return el(
      'div',
      { style: styles.field, onClick: stopBubble, onFocus: stopBubble },
      label ? el('span', { style: styles.label }, label) : null,
      content,
      help ? el('span', { style: styles.help }, help) : null
    );
  }

  function textField(options) {
    return fieldWrap(
      options.label,
      options.help,
      el('input', {
        type: 'text',
        value: options.value || '',
        placeholder: options.placeholder || '',
        onChange: function (event) {
          options.onChange(event.target.value);
        },
        onClick: stopBubble,
        onFocus: stopBubble,
        onKeyDown: stopBubble,
        style: styles.input,
      })
    );
  }

  function textareaField(options) {
    return fieldWrap(
      options.label,
      options.help,
      el('textarea', {
        value: options.value || '',
        placeholder: options.placeholder || '',
        onChange: function (event) {
          options.onChange(event.target.value);
        },
        onClick: stopBubble,
        onFocus: stopBubble,
        onKeyDown: stopBubble,
        style: styles.textarea,
      })
    );
  }

  function selectField(options) {
    return fieldWrap(
      options.label,
      options.help,
      el(
        'select',
        {
          value: options.value || '',
          onChange: function (event) {
            options.onChange(event.target.value);
          },
          onClick: stopBubble,
          onFocus: stopBubble,
          onKeyDown: stopBubble,
          style: styles.input,
        },
        (options.options || []).map(function (option) {
          return el('option', { key: option.value, value: option.value }, option.label);
        })
      )
    );
  }

  function numberField(options) {
    return fieldWrap(
      options.label,
      options.help,
      el('input', {
        type: 'number',
        min: options.min !== undefined ? options.min : 1,
        max: options.max !== undefined ? options.max : 100,
        value: options.value !== undefined && options.value !== null ? options.value : '',
        placeholder: options.placeholder || '',
        onChange: function (event) {
          var next = parseInt(event.target.value, 10);
          options.onChange(isNaN(next) ? undefined : next);
        },
        onClick: stopBubble,
        onFocus: stopBubble,
        onKeyDown: stopBubble,
        style: styles.input,
      })
    );
  }

  function linkField(options) {
    var value = options.value || { url: '', title: '', target: '' };

    function update(field, fieldValue) {
      var next = Object.assign({}, value, { [field]: fieldValue });
      options.onChange(next);
    }

    return el(
      'div',
      null,
      textField({
        label: options.label ? options.label + ' — URL' : 'URL',
        value: value.url || '',
        placeholder: 'https://',
        help: options.help,
        onChange: function (nextValue) {
          update('url', nextValue);
        },
      }),
      textField({
        label: 'Текст ссылки',
        value: value.title || '',
        onChange: function (nextValue) {
          update('title', nextValue);
        },
      }),
      textField({
        label: 'Target',
        value: value.target || '',
        placeholder: '_blank',
        onChange: function (nextValue) {
          update('target', nextValue);
        },
      })
    );
  }

  function imageField(options) {
    var value = options.value || { id: 0, url: '', alt: '' };

    if (!MediaUpload || !MediaUploadCheck) {
      return fieldWrap(options.label, options.help, el('p', null, 'Медиатека недоступна'));
    }

    return fieldWrap(
      options.label,
      options.help,
      el(
        MediaUploadCheck,
        null,
        el(MediaUpload, {
          onSelect: function (media) {
            options.onChange({
              id: media.id,
              url: media.url || '',
              alt: media.alt || media.title || '',
            });
          },
          allowedTypes: ['image'],
          value: value.id || 0,
          render: function (renderProps) {
            return el(
              'div',
              null,
              value.url
                ? el('img', { src: value.url, alt: value.alt || '', style: styles.imagePreview })
                : null,
              el(
                'div',
                { style: styles.row },
                el(Button, { variant: 'secondary', onClick: renderProps.open }, value.url ? 'Заменить' : 'Выбрать'),
                value.url
                  ? el(Button, {
                      variant: 'link',
                      isDestructive: true,
                      onClick: function () {
                        options.onChange({ id: 0, url: '', alt: '' });
                      },
                    }, 'Удалить')
                  : null
              )
            );
          },
        })
      )
    );
  }

  function repeaterField(options) {
    var items = Array.isArray(options.items) ? options.items : [];
    var itemLabel = options.itemLabel || 'Пункт';

    function moveItem(fromIndex, toIndex) {
      if (fromIndex === toIndex || toIndex < 0 || toIndex >= items.length) {
        return;
      }

      var nextItems = items.slice();
      var movedItem = nextItems.splice(fromIndex, 1)[0];
      nextItems.splice(toIndex, 0, movedItem);
      options.onChange(nextItems);
    }

    return el(
      'div',
      { style: styles.field, onClick: stopBubble },
      options.label ? el('span', { style: styles.label }, options.label) : null,
      options.help ? el('span', { style: Object.assign({}, styles.help, { marginBottom: '8px' }) }, options.help) : null,
      items.map(function (item, index) {
        return el(
          'div',
          { key: options.keyPrefix + '-' + index, style: styles.repeaterItem },
          el(
            'div',
            { style: styles.repeaterItemHeader },
            el('span', { style: styles.repeaterItemTitle }, itemLabel + ' ' + (index + 1)),
            el(
              'div',
              { style: styles.row },
              el(Button, {
                variant: 'secondary',
                disabled: index === 0,
                onClick: function () {
                  moveItem(index, index - 1);
                },
                title: 'Переместить выше',
              }, '↑'),
              el(Button, {
                variant: 'secondary',
                disabled: index === items.length - 1,
                onClick: function () {
                  moveItem(index, index + 1);
                },
                title: 'Переместить ниже',
              }, '↓')
            )
          ),
          options.renderItem(item, index, function (nextItem) {
            var nextItems = items.slice();
            nextItems[index] = nextItem;
            options.onChange(nextItems);
          }, function () {
            var nextItems = items.filter(function (_, itemIndex) {
              return itemIndex !== index;
            });
            options.onChange(nextItems);
          })
        );
      }),
      el(Button, {
        variant: 'secondary',
        onClick: function () {
          options.onChange(items.concat([options.createItem()]));
        },
        style: { marginTop: '8px' },
      }, options.addLabel || 'Добавить')
    );
  }

  function PostsSearchField(props) {
    var catalog = Array.isArray(props.catalog) ? props.catalog : [];
    var postIds = Array.isArray(props.postIds)
      ? props.postIds.map(function (id) {
          return parseInt(id, 10);
        }).filter(function (id) {
          return !isNaN(id) && id > 0;
        })
      : [];
    var onChange = props.onChange;
    var placeholder = props.placeholder || 'Начните вводить название…';
    // 0 — без ограничения; 1 — выбор ровно одной записи.
    var max = parseInt(props.max, 10) > 0 ? parseInt(props.max, 10) : 0;

    var queryState = useState('');
    var query = queryState[0];
    var setQuery = queryState[1];

    var focusedState = useState(false);
    var isFocused = focusedState[0];
    var setFocused = focusedState[1];

    var labelById = {};
    catalog.forEach(function (item) {
      labelById[String(item.id)] = item.label || ('ID: ' + item.id);
    });

    function addPost(id) {
      if (max === 1) {
        // Одна запись: выбранная заменяется новой.
        if (postIds[0] !== id) {
          onChange([id]);
        }
        setQuery('');
        return;
      }

      if (postIds.indexOf(id) === -1) {
        onChange(postIds.concat([id]));
      }
      setQuery('');
    }

    function removePost(id) {
      onChange(postIds.filter(function (existingId) {
        return existingId !== id;
      }));
    }

    var normalizedQuery = query.trim().toLowerCase();
    var suggestions = catalog.filter(function (item) {
      var id = parseInt(item.id, 10);
      if (postIds.indexOf(id) !== -1) {
        return false;
      }

      if (!normalizedQuery) {
        return true;
      }

      return (item.label || '').toLowerCase().indexOf(normalizedQuery) !== -1;
    });

    var showList = isFocused;

    return el(
      'div',
      null,
      postIds.length
        ? el(
            'div',
            { style: Object.assign({}, styles.row, { marginBottom: '8px' }) },
            postIds.map(function (id) {
              return el(
                'span',
                {
                  key: 'selected-post-' + id,
                  style: {
                    display: 'inline-flex',
                    alignItems: 'center',
                    gap: '6px',
                    padding: '4px 8px',
                    borderRadius: '4px',
                    background: colors.border,
                    fontSize: '13px',
                    color: colors.text,
                  },
                },
                labelById[String(id)] || ('ID: ' + id),
                el(
                  'button',
                  {
                    type: 'button',
                    onClick: function () {
                      removePost(id);
                    },
                    style: {
                      border: 'none',
                      background: 'transparent',
                      cursor: 'pointer',
                      padding: 0,
                      lineHeight: 1,
                      color: colors.textMuted,
                    },
                    'aria-label': 'Удалить',
                  },
                  '×'
                )
              );
            })
          )
        : null,
      el('input', {
        type: 'text',
        value: query,
        placeholder: placeholder,
        onChange: function (event) {
          setQuery(event.target.value);
        },
        onFocus: function () {
          setFocused(true);
        },
        onBlur: function () {
          window.setTimeout(function () {
            setFocused(false);
          }, 150);
        },
        onClick: stopBubble,
        onKeyDown: function (event) {
          stopBubble(event);

          if (event.key === 'Enter' && suggestions.length) {
            event.preventDefault();
            addPost(parseInt(suggestions[0].id, 10));
          }
        },
        style: styles.input,
      }),
      showList
        ? el(
            'ul',
            {
              style: {
                listStyle: 'none',
                margin: '8px 0 0',
                padding: 0,
                maxHeight: '220px',
                overflowY: 'auto',
                border: '1px solid ' + colors.border,
                borderRadius: '4px',
                background: colors.surface,
              },
            },
            suggestions.length
              ? suggestions.map(function (item) {
                  var id = parseInt(item.id, 10);

                  return el(
                    'li',
                    {
                      key: 'suggestion-' + id,
                      onMouseDown: function (event) {
                        event.preventDefault();
                        addPost(id);
                      },
                      style: {
                        padding: '8px 10px',
                        cursor: 'pointer',
                        fontSize: '14px',
                        color: colors.text,
                        borderBottom: '1px solid ' + colors.border,
                      },
                    },
                    item.label || ('ID: ' + id)
                  );
                })
              : el(
                  'li',
                  {
                    style: {
                      padding: '8px 10px',
                      fontSize: '13px',
                      color: colors.textMuted,
                    },
                  },
                  normalizedQuery
                    ? 'Ничего не найдено'
                    : (max === 1 && postIds.length
                        ? 'Запись выбрана — начните вводить, чтобы заменить'
                        : (catalog.length ? 'Все записи уже выбраны' : 'Нет опубликованных записей'))
                )
          )
        : null
    );
  }

  function toggleField(options) {
    return el(
      'div',
      { style: styles.field, onClick: stopBubble },
      el(ToggleControl, {
        label: options.label || '',
        help: options.help || '',
        checked: !!options.value,
        onChange: options.onChange,
      })
    );
  }

  function postsField(options) {
    return el(
      'div',
      { style: styles.field, onClick: stopBubble },
      options.label ? el('span', { style: styles.label }, options.label) : null,
      options.help ? el('span', { style: Object.assign({}, styles.help, { marginBottom: '8px' }) }, options.help) : null,
      el(PostsSearchField, {
        catalog: options.catalog,
        postIds: options.postIds,
        onChange: options.onChange,
        placeholder: options.placeholder || 'Начните вводить название…',
      })
    );
  }

  /**
   * Выбор одной записи — та же логика, что postsField, но с лимитом 1.
   * options.postIds — массив (0 или 1 id), options.onChange получает массив.
   */
  function singlePostField(options) {
    return el(
      'div',
      { style: styles.field, onClick: stopBubble },
      options.label ? el('span', { style: styles.label }, options.label) : null,
      options.help ? el('span', { style: Object.assign({}, styles.help, { marginBottom: '8px' }) }, options.help) : null,
      el(PostsSearchField, {
        catalog: options.catalog,
        postIds: options.postIds,
        max: 1,
        onChange: options.onChange,
        placeholder: options.placeholder || 'Начните вводить название…',
      })
    );
  }

  function resolveValue(override, defaults, key) {
    if (override !== undefined && override !== null && override !== '') {
      if (Array.isArray(override) && override.length) {
        return override;
      }
      if (!Array.isArray(override)) {
        return override;
      }
    }

    if (defaults && defaults[key] !== undefined) {
      return defaults[key];
    }

    if (Array.isArray(override)) {
      return override;
    }

    return '';
  }

  window.themeBlockControls = {
    colors: colors,
    blockShell: blockShell,
    blockTitle: blockTitle,
    blockHint: blockHint,
    styles: styles,
    fieldWrap: fieldWrap,
    textField: textField,
    textareaField: textareaField,
    selectField: selectField,
    numberField: numberField,
    linkField: linkField,
    imageField: imageField,
    repeaterField: repeaterField,
    toggleField: toggleField,
    postsField: postsField,
    singlePostField: singlePostField,
    resolveValue: resolveValue,
    stopBubble: stopBubble,
  };
})(window.wp);
