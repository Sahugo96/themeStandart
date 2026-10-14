export default function headerScroll() {
  const header = document.querySelector(".header");
  let lastScrollY = 0;

  if (!header) {
    return;
  }
  
  function handleScroll() {
    const currentScrollY = window.scrollY;
    
    if (currentScrollY > 0) {
      header.classList.add('scroll');
    } 
    
    // Убираем класс, если пользователь скролит вверх или находится в самом верху
    if (currentScrollY < lastScrollY || currentScrollY === 0) {
      header.classList.remove('scroll');
    }
    
    lastScrollY = currentScrollY;
  }

  handleScroll(); // Вызываем при инициализации

  window.addEventListener('scroll', handleScroll);
}