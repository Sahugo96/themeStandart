export default function breadcrumbBack() {
  const backLink = document.querySelector('.breadcrumbs__link--back');

  if (!backLink) {
    return;
  }

  const homeUrl = backLink.dataset.home || '/';

  function isSameOrigin(url) {
    try {
      return new URL(url, window.location.origin).origin === window.location.origin;
    } catch {
      return false;
    }
  }
  console.log('bbb');
  

  function canGoBackInternally() {
    if (window.history.length <= 1) {
      return false;
    }

    if (!document.referrer) {
      return true;
    }

    return isSameOrigin(document.referrer);
  }

  backLink.addEventListener('click', (event) => {
    event.preventDefault();

    if (canGoBackInternally()) {
      window.history.back();
      return;
    }

    window.location.href = homeUrl;
  });
}
