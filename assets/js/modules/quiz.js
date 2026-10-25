// Квиз-диагностика (pages/sections/quiz.php): шаги по очереди, затем общий финальный экран с формой CF7.
// Ответы попадают в скрытое поле quiz_answers формы — в письмо их добавляет inc/cf7/quiz-answers.php.
export default function quiz() {
  document.querySelectorAll('[data-quiz]').forEach(function (root) {
    if (root.dataset.quizReady) {
      return;
    }
    root.dataset.quizReady = '1';

    var steps = Array.prototype.slice.call(root.querySelectorAll('[data-quiz-step]'));
    var bars = root.querySelectorAll('[data-quiz-bar]');
    var finalScreen = root.querySelector('[data-quiz-final]');
    var formWrap = root.querySelector('[data-quiz-btn-text]') || (finalScreen && finalScreen.querySelector('.quiz__form'));
    var answers = [];
    var current = 0;

    function show(index) {
      current = index;

      steps.forEach(function (step, i) {
        step.hidden = i !== index;
      });

      if (finalScreen) {
        finalScreen.hidden = index < steps.length;
      }

      bars.forEach(function (bar, i) {
        bar.classList.toggle('active', i <= index);
      });

      if (index >= steps.length) {
        syncAnswers();
      }
    }

    // Текст ответов: «1. Вопрос — Ответ» построчно.
    function answersText() {
      return steps.map(function (step, i) {
        var question = step.querySelector('[data-quiz-question]');
        return (question ? question.textContent.trim() : String(i + 1)) + ' — ' + (answers[i] || '—');
      }).join('\n');
    }

    function syncAnswers() {
      var form = finalScreen && finalScreen.querySelector('form');
      if (!form) {
        return;
      }

      var input = form.querySelector('input[name="quiz_answers"]');
      if (!input) {
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'quiz_answers';
        form.appendChild(input);
      }
      input.value = answersText();
    }

    function reset() {
      answers = [];
      root.querySelectorAll('[data-quiz-option]').forEach(function (option) {
        option.classList.remove('active');
        option.setAttribute('aria-pressed', 'false');
      });
      show(0);
    }

    steps.forEach(function (step, index) {
      step.querySelectorAll('[data-quiz-option]').forEach(function (option) {
        option.addEventListener('click', function () {
          step.querySelectorAll('[data-quiz-option]').forEach(function (other) {
            var selected = other === option;
            other.classList.toggle('active', selected);
            other.setAttribute('aria-pressed', selected ? 'true' : 'false');
          });

          answers[index] = option.textContent.trim();

          // Небольшая пауза, чтобы был виден выбранный вариант.
          setTimeout(function () {
            show(index + 1);
          }, 250);
        });
      });
    });

    root.querySelectorAll('[data-quiz-back]').forEach(function (back) {
      back.addEventListener('click', function () {
        show(Math.max(current - 1, 0));
      });
    });

    // Подпись кнопки формы — из настроек секции (форма CF7 общая с другими блоками).
    if (formWrap && formWrap.dataset.quizBtnText) {
      var submit = formWrap.querySelector('[type="submit"]');
      if (submit) {
        if (submit.tagName === 'INPUT') {
          submit.value = formWrap.dataset.quizBtnText;
        } else {
          submit.textContent = formWrap.dataset.quizBtnText;
        }
      }
    }

    // После успешной отправки квиз начинается заново.
    if (finalScreen) {
      finalScreen.addEventListener('wpcf7mailsent', reset);
    }
  });
}
