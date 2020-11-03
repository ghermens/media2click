document.onreadystatechange = function () {
  if (document.readyState === 'complete') {
    let placeholderAnchorList = document.querySelectorAll('.media2click-placeholder a');
    placeholderAnchorList.forEach(function (anchor) {
      anchor.addEventListener('click', function (event) {
        event.stopPropagation();
      }, false);
    });
    let placeholderList = document.querySelectorAll('.media2click-placeholder');
    placeholderList.forEach(function (placeholder) {
      let mediaFrame = placeholder.nextElementSibling;
      if (mediaFrame.nodeName === 'IFRAME') {
        placeholder.addEventListener('click', function (event) {
          mediaFrame.setAttribute('src', mediaFrame.getAttribute('data-src'));
          mediaFrame.setAttribute('style', 'display: block;');
          placeholder.setAttribute('style', 'display: none;');
          event.preventDefault();
        }, false);
      }
    });
  }
};
