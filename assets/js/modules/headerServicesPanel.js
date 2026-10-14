const trigger = document.querySelector('.header__bottom-service[aria-controls="header-services-panel"]');
const panel = document.getElementById('header-services-panel');

if (trigger && panel) {
  const tabs = panel.querySelectorAll('.header-services__tab');
  const tabPanels = panel.querySelectorAll('.header-services__panel');

  const closePanel = () => {
    trigger.setAttribute('aria-expanded', 'false');
    trigger.classList.remove('is-active');
    trigger.closest('.header')?.classList.remove('is-services-open');
    panel.hidden = true;
  };

  const openPanel = () => {
    trigger.setAttribute('aria-expanded', 'true');
    trigger.classList.add('is-active');
    trigger.closest('.header')?.classList.add('is-services-open');
    panel.hidden = false;
  };

  trigger.addEventListener('click', (event) => {
    event.preventDefault();

    if (trigger.getAttribute('aria-expanded') === 'true') {
      closePanel();
      return;
    }

    openPanel();
  });

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      const tabIndex = tab.getAttribute('data-tab-index');

      tabs.forEach((item) => {
        const isActive = item === tab;
        item.classList.toggle('is-active', isActive);
        item.setAttribute('aria-selected', isActive ? 'true' : 'false');
      });

      tabPanels.forEach((tabPanel) => {
        const isActive = tabPanel.getAttribute('data-tab-index') === tabIndex;
        tabPanel.classList.toggle('is-active', isActive);
        tabPanel.hidden = !isActive;
      });
    });
  });

  document.addEventListener('click', (event) => {
    if (!event.target.closest('.header__bottom-service') && !event.target.closest('#header-services-panel')) {
      closePanel();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closePanel();
    }
  });
}
