// Аккордеон «Как проходит работа»: одновременно открыт один шаг, открытый можно закрыть повторным кликом.
document.querySelectorAll("[data-accordion]").forEach((root) => {
  const items = root.querySelectorAll("[data-accordion-item]");

  items.forEach((item) => {
    const btn = item.querySelector("[data-accordion-btn]");
    if (!btn) return;

    btn.addEventListener("click", () => {
      const wasOpen = item.classList.contains("active");

      items.forEach((other) => {
        other.classList.remove("active");
        const otherBtn = other.querySelector("[data-accordion-btn]");
        if (otherBtn) otherBtn.setAttribute("aria-expanded", "false");
      });

      // Обновляем состояние кнопки кликнутого элемента
      btn.setAttribute("aria-expanded", wasOpen ? "false" : "true");

      if (!wasOpen) {
        item.classList.add("active");
      }
    });
  });
});