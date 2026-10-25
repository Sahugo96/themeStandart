// Поиск в шапке.
// Первый клик по лупе открывает поле (оно встаёт на место меню услуг),
// повторный — отправляет форму. Пустой запрос не отправляем, а возвращаем фокус в поле.
// Крестик и Esc закрывают поле и очищают его.
(function () {
  var searchButton = document.querySelector('.js-header-search');
  if (!searchButton) return;

  var wrapper = searchButton.closest('.header-search');
  var form = searchButton.nextElementSibling;
  if (!form || form.tagName !== 'FORM') return;

  var input = form.querySelector('input[name="s"]');
  var closeSearchButton = form.querySelector('.js-header-search-close');

  function isOpen() {
    return form.classList.contains('active');
  }

  function showSearch() {
    form.classList.add('active');
    if (wrapper) wrapper.classList.add('is-open');
    searchButton.setAttribute('aria-expanded', 'true');
    if (input) input.focus();
  }

  function hideSearch() {
    form.classList.remove('active');
    if (wrapper) wrapper.classList.remove('is-open');
    searchButton.setAttribute('aria-expanded', 'false');
    form.reset();
  }

  function submitSearch() {
    if (input && input.value.trim() === '') {
      input.focus();
      return;
    }
    form.submit();
  }

  searchButton.setAttribute('aria-expanded', 'false');

  searchButton.addEventListener('click', function (e) {
    e.preventDefault();
    if (isOpen()) {
      submitSearch();
    } else {
      showSearch();
    }
  });

  // Enter в поле: тот же запрет на пустой запрос.
  form.addEventListener('submit', function (e) {
    if (input && input.value.trim() === '') {
      e.preventDefault();
      input.focus();
    }
  });

  if (closeSearchButton) {
    closeSearchButton.addEventListener('click', function (e) {
      e.preventDefault();
      hideSearch();
      searchButton.focus();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && isOpen()) {
      hideSearch();
      searchButton.focus();
    }
  });
})();
