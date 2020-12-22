document.onreadystatechange = function () {
  if (document.readyState === 'complete') {
    let m2cCookieHosts = m2cGetCookieHosts();
    const clickEvent = new MouseEvent('click', {
      view: window,
      bubbles: true,
      cancelable: true
    });

    let placeholderAnchorList = document.querySelectorAll('.media2click-placeholder a');
    placeholderAnchorList.forEach(function (anchor) {
      anchor.addEventListener('click', function (event) {
        let host = this.getAttribute('data-host');
        console.log(host);
        if (host !== null && host !== '') {
          m2cCookieHosts.push(host);
          m2cSetCookieHosts(m2cCookieHosts);
        } else {
          event.stopPropagation();
        }
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
        /* Host already permanently enabled? */
        if(m2cCookieHosts.find(element => element === placeholder.getAttribute('data-host'))) {
          placeholder.dispatchEvent(clickEvent);
        }
      }
    });

    let toggleList = document.querySelectorAll('.media2click-toggle');
    toggleList.forEach( function (toggle) {
      let host = toggle.getAttribute('data-host');
      if(m2cCookieHosts.find(element => element === host)) {
        toggle.classList.add('activated');
      }
      toggle.addEventListener('click', function (event) {
        toggle.classList.toggle('activated');
        if (toggle.className === 'media2click-toggle activated') {
          m2cCookieHosts.push(host);
          m2cSetCookieHosts(m2cCookieHosts);
        } else {
          let index = m2cCookieHosts.indexOf(host);
          if (index > -1) {
            m2cCookieHosts.splice(index,1);
            m2cSetCookieHosts(m2cCookieHosts);
          }
        }
      });
    });
  }
};

/**
 * Set the media2click accepted hosts cookie
 * @param hosts
 */
function m2cSetCookieHosts(hosts) {
  let d = new Date();
  d.setTime(d.getTime() + (7 * 24 * 60 * 60 * 1000));
  let expires = "expires=" + d.toUTCString();
  document.cookie = "m2c_accepted_hosts=" + hosts.join() + ";" + expires + ";path=/";
}

/**
 *
 * @returns {string[]|*[]}
 */
function m2cGetCookieHosts() {
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf("m2c_accepted_hosts=") === 0) {
      return c.substring(19, c.length).split(',');
    }
  }
  return [];
}

/**
 * Delete the media2click accepted hosts cookie
 */
function m2cDeleteCookie() {
  document.cookie = "m2c_accepted_hosts=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
