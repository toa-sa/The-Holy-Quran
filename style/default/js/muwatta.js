/* «مختصر الموطأ»: open the reading guide before the index the first time. */
(function () {
  var key = 'muwatta.guideShown';
  try {
    if (document.querySelector('[data-mw-guide]')) {
      localStorage.setItem(key, '1');
      return;
    }
    var index = document.querySelector('[data-mw-index]');
    if (index && !localStorage.getItem(key)) {
      location.replace(index.getAttribute('data-guide-url'));
    }
  } catch (e) { /* storage blocked: the guide stays one tap away */ }
})();
