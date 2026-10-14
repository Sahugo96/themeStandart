import { gsap } from "https://cdn.jsdelivr.net/npm/gsap@3.14.1/index.js";
import { ScrollTrigger } from "https://cdn.jsdelivr.net/npm/gsap@3.14.1/ScrollTrigger.js";

gsap.registerPlugin(ScrollTrigger);

const animBlock = document.querySelector(".anim-block");

gsap.fromTo(
  animBlock,
  {
    x: "100vw",
  },
  {
    x: "-100vw",
    duration: 1,
    ease: "none", // Линейная анимация для плавности скролла
    scrollTrigger: {
      trigger: animBlock, // Триггер - сам анимируемый блок
      start: "top bottom", // Начало: когда верх блока касается низа окна (элемент начинает появляться)
      end: "bottom top", // Конец: когда низ блока касается верха окна (элемент полностью уходит)
      scrub: 1, // Привязка к скроллу с плавностью
      invalidateOnRefresh: true, // Обновляем при ресайзе
    },
  },
);

// Добавляем информацию при клике на блок
animBlock.addEventListener("click", () => {
  const trigger = animation.scrollTrigger;
});

// Обработка ресайза окна
window.addEventListener("resize", () => {
  ScrollTrigger.refresh();
});