document.onreadystatechange = function() {
    if (document.readyState === 'complete') {
        let placeholderList = document.querySelectorAll('.media2click-placeholder');
        placeholderList.forEach(function(placeholder) {
            let mediaFrame = placeholder.nextElementSibling;
            if (mediaFrame.nodeName === 'IFRAME') {
                placeholder.addEventListener('click', function(event) {
                    mediaFrame.setAttribute('src', mediaFrame.getAttribute('data-src'));
                    mediaFrame.setAttribute('style', 'display: block;');
                    placeholder.setAttribute('style', 'display: none;');
                    event.preventDefault();
                }, false);
            }
        });
    }
};