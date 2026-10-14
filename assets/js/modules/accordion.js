document.querySelectorAll('.accordion-top').forEach(element => {
  element.addEventListener('click', function (e) {
    e.preventDefault();
    const group = this.closest('.accordion-group');
    if (this.closest('.accordion').classList.contains('active')) {
      this.closest('.accordion').classList.remove('active');
    } else {
      if (group.querySelector('.accordion.active') && group.querySelector('.accordion.active') != this.closest('.accordion')) {
        group.querySelector('.accordion.active').classList.remove('active');
      }
      this.closest('.accordion').classList.add('active');
    }
  });
});