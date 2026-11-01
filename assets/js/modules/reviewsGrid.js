// «Сетка отзывов» (pages/sections/reviews.php, вид grid): «Показать ещё» открывает
// оставшиеся карточки своего таба и скрывается.
document.querySelectorAll('.reviews--grid [data-reviews-more]').forEach((btn) => {
  if (btn.dataset.ready) {
    return;
  }

  btn.dataset.ready = '1';

  btn.addEventListener('click', () => {
    const group = btn.closest('.reviews__splide');

    if (group) {
      group.classList.add('is-all');
    }
  });
});
