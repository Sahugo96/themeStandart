// Блоки страницы контактов («Контакты», «Карты», «Реквизиты») доступны только на странице
// с шаблоном «Contacts page». Сервер отдаёт список блоков по сохранённому шаблону
// (theme_allowed_block_types); здесь — живое обновление при смене шаблона в боковой панели.
(function (wp) {
  if (!wp || !wp.data || !wp.blocks) {
    return;
  }

  var config = window.themeContactsBlocks || {};
  var names = Array.isArray(config.names) ? config.names : [];
  var template = config.template || 'page-contacts.php';
  var lastState = null;

  if (!names.length) {
    return;
  }

  wp.data.subscribe(function () {
    var editor = wp.data.select('core/editor');
    var blockEditor = wp.data.select('core/block-editor');

    if (!editor || !blockEditor || !editor.getCurrentPostType || editor.getCurrentPostType() !== 'page') {
      return;
    }

    var isContacts = (editor.getEditedPostAttribute('template') || '') === template;

    if (isContacts === lastState) {
      return;
    }
    lastState = isContacts;

    var allowed = blockEditor.getSettings().allowedBlockTypes;
    if (!Array.isArray(allowed)) {
      allowed = wp.blocks.getBlockTypes().map(function (type) {
        return type.name;
      });
    }

    allowed = allowed.filter(function (name) {
      return names.indexOf(name) === -1;
    });

    if (isContacts) {
      allowed = allowed.concat(names);
    }

    wp.data.dispatch('core/block-editor').updateSettings({ allowedBlockTypes: allowed });
  });
})(window.wp);
