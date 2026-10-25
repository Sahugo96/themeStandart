// Страница поиска: табы по типу записи переключают группы результатов без перезагрузки.
(function () {
  document.querySelectorAll('.search-results').forEach(function (section) {
    var tabs = section.querySelectorAll('.filter__link[data-filter]');
    var groups = section.querySelectorAll('.search-results__group[data-group]');

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var type = tab.getAttribute('data-filter');

        tabs.forEach(function (other) {
          other.classList.toggle('active', other === tab);
        });

        groups.forEach(function (group) {
          group.hidden = group.getAttribute('data-group') !== type;
        });
      });
    });
  });
})();
