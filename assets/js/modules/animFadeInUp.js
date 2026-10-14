import { gsap } from "https://cdn.jsdelivr.net/npm/gsap@3.14.1/index.js";
import { ScrollTrigger } from "https://cdn.jsdelivr.net/npm/gsap@3.14.1/ScrollTrigger.js";

gsap.registerPlugin(ScrollTrigger);

function initFadeInUp() {
  const containers = document.querySelectorAll('.fade-in-container');

  containers.forEach(container => {
    const elements = gsap.utils.toArray('.fade-in-element', container);
    
    if (!elements.length) return;
  
    // Устанавливаем начальное состояние
    gsap.set(elements, { opacity: 0, y: 30 });
  
    // Создаем поочередную анимацию
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: container,
        start: 'top 80%',
        toggleActions: 'play none none reverse'
      }
    });
  
    // Добавляем каждый элемент с задержкой
    elements.forEach((el, index) => {
      tl.to(el, {
        opacity: 1,
        y: 0,
        duration: 0.6,
        ease: "power2.out"
      }, 0.3 + index * 0.2); // Задержка 0.2 секунды между элементами
    });
  });
}

initFadeInUp();