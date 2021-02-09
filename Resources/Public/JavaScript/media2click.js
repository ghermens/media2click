document.onreadystatechange = function () {
  if (document.readyState === 'complete') {
    let m2cCookieHosts = m2cGetCookieHosts();

    let m2cElementList = document.querySelectorAll('.media2click-wrap');
    m2cElementList.forEach(function(m2cElement) {
      let placeholder = m2cElement.querySelector('.media2click-placeholder');
      let frameData = m2cElement.querySelector('.media2click-iframedata');
      let oldPlaceholder = m2cElement.querySelector('.media2click-old');
      let activateOnce = null;
      let activatePermanent = null;
      if (oldPlaceholder !== null) {
        activateOnce = oldPlaceholder;
      } else {
        activateOnce = m2cElement.querySelector('.media2click-once');
        activatePermanent = m2cElement.querySelector('.media2click-permanent');
      }
      /* Activate once and load iframe */
      if (activateOnce !== null) {
        activateOnce.addEventListener('click', function (event) {
          event.preventDefault();
          m2cActivateFrame(frameData, placeholder);
        }, false);
      }
      /* Activate permanently and load iframe */
      if (activatePermanent !== null) {
        activatePermanent.addEventListener('click', function (event) {
          event.preventDefault();
          let host = this.getAttribute('data-host');
          let lifetime = this.getAttribute('data-cookielifetime');
          if (host !== null && host !== '') {
            m2cCookieHosts.push(host);
            m2cSetCookieHosts(m2cCookieHosts, lifetime);
          }
          m2cActivateFrame(frameData, placeholder);
        }, false);
      }
      /* If already activated permanently, load iframe */
      if(m2cCookieHosts.find(element => element === placeholder.getAttribute('data-host'))) {
        m2cActivateFrame(frameData, placeholder);
      }
    })

    let m2cToggleList = document.querySelectorAll('.media2click-toggle');
    m2cToggleList.forEach( function (toggle) {
      let host = toggle.getAttribute('data-host');
      let lifetime = toggle.getAttribute('data-cookielifetime');
      if(m2cCookieHosts.find(element => element === host)) {
        toggle.classList.add('activated');
        toggle.setAttribute('checked', 'checked');
      }
      toggle.addEventListener('click', function (event) {
        toggle.classList.toggle('activated');
        if (toggle.className === 'media2click-toggle activated') {
          m2cCookieHosts.push(host);
          m2cSetCookieHosts(m2cCookieHosts, lifetime);
        } else {
          let index = m2cCookieHosts.indexOf(host);
          if (index > -1) {
            m2cCookieHosts.splice(index,1);
            if (m2cCookieHosts.length > 0) {
              m2cSetCookieHosts(m2cCookieHosts, lifetime);
            } else {
              m2cDeleteCookie();
            }
          }
        }
      });
    });
  }
};

/**
 * Replace media2click dummy element with actual iframe
 * @param dataNode
 * @param placeholderNode
 */
function m2cActivateFrame(dataNode, placeholderNode) {
  let newNode = document.createElement('iframe');
  let frameData = JSON.parse(dataNode.getAttribute('data-attributes'));
  Object.entries(frameData).forEach(([key, value]) => newNode.setAttribute(key, value));

  dataNode.parentElement.insertBefore(newNode, dataNode);
  dataNode.parentElement.removeChild(dataNode);
  placeholderNode.parentElement.removeChild(placeholderNode);
}

/**
 * Set the media2click accepted hosts cookie
 * @param hosts
 * @param lifetime days
 */
function m2cSetCookieHosts(hosts, lifetime = -1) {
  lifetime = Number.parseInt(lifetime, 10);
  if (Number.isNaN(lifetime) || lifetime < 0) {
    lifetime = 7;
  }
  let expires = '';
  if (lifetime > 0) {
    let d = new Date();
    d.setTime(d.getTime() + (lifetime * 24 * 60 * 60 * 1000));
    expires = "expires=" + d.toUTCString() + ";";
  }
  document.cookie = "m2c_accepted_hosts=" + hosts.join() + ";" + expires + "path=/;SameSite=Strict";
}

/**
 * Get the media2click accepted hosts from cookie
 * @returns {string[]|*[]}
 */
function m2cGetCookieHosts() {
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for (let i = 0; i < ca.length; i++) {
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
