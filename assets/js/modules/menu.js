document.querySelector('.header__burger').addEventListener('click', function (e) {
  document.querySelector('.header').classList.toggle('active');
  document.querySelector('body').classList.toggle('lock');
});

document.addEventListener('click', function (e) {
  
  if (!e.target.closest('.header__burger')) {
    document.querySelector('.header').classList.remove('active');
    document.querySelector('body').classList.remove('lock');
  }
});