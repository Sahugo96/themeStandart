class LazyLoader {
    constructor(options = {}) {
      this.lazyImages = document.querySelectorAll("img.lazyload--js");
      this.offset = options.offset || 170; // Отступ по умолчанию
      this.init();
    }
  
    init() {
      if ("IntersectionObserver" in window) {
        const observerOptions = {
          root: null,
          rootMargin: `0px 0px ${this.offset}px 0px`,
          threshold: 0,
        };
  
        this.imageObserver = new IntersectionObserver(this.onIntersection.bind(this), observerOptions);
        this.lazyImages.forEach((img) => this.imageObserver.observe(img));
      } else {
        // Если IntersectionObserver не поддерживается
        this.loadAllImages();
      }
    }
  
    onIntersection(entries, observer) {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          this.loadImage(img);
          observer.unobserve(img);
        }
      });
    }
  
    loadImage(img) {
      if (!img.dataset.src) {
        return;
      }

      img.src = img.dataset.src;
      if (img.dataset.srcset) {
        img.srcset = img.dataset.srcset;
      }
      if (img.dataset.sizes) {
        img.sizes = img.dataset.sizes;
      }
      img.classList.remove("lazyload--js");
    }
  
    loadAllImages() {
      this.lazyImages.forEach((img) => this.loadImage(img));
    }
  }

  function loadLazyImagesNow(root) {
    const scope = root || document;

    scope.querySelectorAll('img.lazyload--js').forEach((img) => {
      if (!img.dataset.src) {
        return;
      }

      img.src = img.dataset.src;

      if (img.dataset.srcset) {
        img.srcset = img.dataset.srcset;
      }

      if (img.dataset.sizes) {
        img.sizes = img.dataset.sizes;
      }

      img.classList.remove('lazyload--js');
    });
  }

  window.themeLoadLazyImagesNow = loadLazyImagesNow;

  export default LazyLoader;