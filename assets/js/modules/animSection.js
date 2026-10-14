class animSection {
  constructor() {
    this.sections = document.querySelectorAll(".section");
    if (this.sections.length > 0) {
      this.initObserver();
    }
  }

  initObserver() {
    const observer = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && entry.intersectionRatio >= 0.1) {
            entry.target.classList.add("anim");
            observer.unobserve(entry.target); // отключаем после первого срабатывания
          }
        });
      },
      {
        threshold: 0.1, // 10% видимости
        rootMargin: "0px"
      }
    );

    this.sections.forEach(section => {
      observer.observe(section);
    });
  }
}

export default animSection;
