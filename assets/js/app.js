class DynamicLoader {
    constructor(options = {}) {
      this.options = options;
      this.loadedModules = new Set(); // Для отслеживания загруженных модулей и стилей
      this.init();
    }
  
    init() {
      console.log("DynamicLoader успешно инициализирован с опциями:", this.options);
      if (this.options.onVisible) {
        this.initObserver(this.options.onVisible, this.options.offset || 500);
      }
      if (this.options.onClick) {
        this.initClickListener(this.options.onClick);
      }
    }
  
    // Инициализация Observer для подключения модулей при появлении в области видимости
    initObserver(onVisibleModules, offset) {
      const observerOptions = {
        root: null,
        rootMargin: `0px 0px ${offset}px 0px`, // Отступ для предварительной загрузки
        threshold: 0,
      };
  
      const observer = new IntersectionObserver((entries, observerInstance) => {
        entries.forEach(async (entry) => {
          if (entry.isIntersecting) {
            const modulePaths = entry.target.dataset.module ? entry.target.dataset.module.split(',') : [];
            const cssPaths = entry.target.dataset.css ? entry.target.dataset.css.split(',') : [];
  
            // Загрузка CSS, если указаны пути
            for (const cssPath of cssPaths) {
              if (cssPath && !this.loadedModules.has(cssPath)) {
                console.log(`Загрузка CSS: ${cssPath}`);
                await this.loadCSS(cssPath);
                this.loadedModules.add(cssPath);
              }
            }
  
            // Загрузка JS, если указаны пути
            console.log(`Загрузка JS модулей: ${modulePaths.join(', ')}`);
            await this.loadModulesSequentially(modulePaths);
  
            observerInstance.unobserve(entry.target); // Останавливаем наблюдение
          }
        });
      }, observerOptions);
  
      onVisibleModules.forEach((selector) => {
        const elements = document.querySelectorAll(selector);
        elements.forEach((element) => observer.observe(element));
      });
    }
  
    // Инициализация прослушивателя событий "клик"
    initClickListener(onClickModules) {
      onClickModules.forEach((selector) => {
        document.addEventListener('click', async (e) => {
          const target = e.target.closest(selector);
          if (target) {
            const modulePaths = target.dataset.module ? target.dataset.module.split(',') : [];
            const cssPaths = target.dataset.css ? target.dataset.css.split(',') : [];
  
            // Загрузка CSS, если указаны пути
            for (const cssPath of cssPaths) {
              if (cssPath && !this.loadedModules.has(cssPath)) {
                console.log(`Загрузка CSS: ${cssPath}`);
                await this.loadCSS(cssPath);
                this.loadedModules.add(cssPath);
              }
            }
  
            // Загрузка JS, если указаны пути
            console.log(`Загрузка JS модулей: ${modulePaths.join(', ')}`);
            await this.loadModulesSequentially(modulePaths);
          }
        });
      });
    }
  
    // Динамическая загрузка нескольких JS-модулей по порядку
    async loadModulesSequentially(modulePaths) {
      for (const modulePath of modulePaths) {
        if (modulePath && !this.loadedModules.has(modulePath)) {
          console.log(`Загрузка модуля: ${modulePath}`);
          // Загрузка модуля один за другим
          await this.loadModule(modulePath);
          this.loadedModules.add(modulePath);
        }
      }
    }
  
    // Динамическая загрузка JS-модуля
    async loadModule(modulePath) {
      try {
        const module = await import(modulePath);
        if (module && typeof module.default === 'function') {
          if (module.default.prototype && module.default.prototype.constructor) {
            // Если это класс, создаем новый экземпляр
            new module.default();
          } else {
            // Если это обычная функция, вызываем её
            module.default();
          }
          console.log(`Модуль ${modulePath} успешно загружен и выполнен.`);
        }
      } catch (err) {
        console.error(`Ошибка загрузки модуля ${modulePath}:`, err);
      }
    }
  
    // Динамическая загрузка CSS
    async loadCSS(cssPath) {
      const existingLink = document.querySelector(`link[href="${cssPath}"]`);
      if (existingLink) {
        console.log(`CSS файл ${cssPath} уже загружен.`);
        return;
      }
  
      try {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = cssPath;
  
        // Вставляем <link> перед стилем с id="load-css"
        const existingStyleTag = document.getElementById('load-css');
        if (existingStyleTag) {
          existingStyleTag.parentNode.insertBefore(link, existingStyleTag);
        } else {
          document.head.appendChild(link);
        }
  
        console.log(`CSS файл ${cssPath} успешно загружен.`);
      } catch (err) {
        console.error(`Ошибка при загрузке CSS файла ${cssPath}:`, err);
      }
    }
}
