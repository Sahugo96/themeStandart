// Комментарии статьи: «Ответить» подставляет id родителя в скрытое поле CF7
// (tolstenko_parent_comment) — после одобрения ответ встанет в нужную ветку.
// Перенесено из tolstenko.marketing (assets/js/script.js).

const section = document.getElementById('comments');
// Карточка с формой: подсказка «Ответ для…» и форма CF7.
const formWrap = section ? section.querySelector('.comments__right') : null;

if (section && formWrap) {
  const hint = formWrap.querySelector('[data-comments-reply-hint]');
  const hintText = formWrap.querySelector('[data-comments-reply-hint-text]');
  const cancel = formWrap.querySelector('[data-comments-reply-cancel]');

  const getParentInput = () => {
    let input = formWrap.querySelector('input[name="tolstenko_parent_comment"]');

    if (input) {
      return input;
    }

    const form = formWrap.querySelector('form');

    if (!form) {
      return null;
    }

    input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'tolstenko_parent_comment';
    form.appendChild(input);

    return input;
  };

  const setReply = (id, author) => {
    const input = getParentInput();

    if (input) {
      input.value = id || '';
    }

    formWrap.classList.toggle('is-reply', !!id);

    section.querySelectorAll('.comments__item.is-reply-target').forEach((item) => {
      item.classList.remove('is-reply-target');
    });

    if (id) {
      const target = section.querySelector('.comments__item[data-comment-id="' + id + '"]');

      if (target) {
        target.classList.add('is-reply-target');
      }
    }

    if (hint) {
      hint.hidden = !id;

      if (hintText) {
        hintText.textContent = id ? (author ? 'Ответ для ' + author : 'Ответ на комментарий') : '';
      }
    }
  };

  section.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-comment-reply]');

    if (!btn) {
      return;
    }

    e.preventDefault();

    const id = btn.getAttribute('data-comment-id') || '';
    const input = getParentInput();

    if (input && input.value === id) {
      setReply('', '');
      return;
    }

    setReply(id, btn.getAttribute('data-comment-author') || '');
    formWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });

    const field = formWrap.querySelector('input[type="text"], textarea');

    if (field) {
      field.focus({ preventScroll: true });
    }
  });

  if (cancel) {
    cancel.addEventListener('click', (e) => {
      e.preventDefault();
      setReply('', '');
    });
  }

  document.addEventListener('wpcf7mailsent', (e) => {
    if (e.target && formWrap.contains(e.target)) {
      setReply('', '');
    }
  });
}
