class Media2Click {
  #cookieHosts = [];
  #lifetime = -1;

  constructor(lifetime = -1) {
    this.setCookieLifetime(lifetime);
    this.#cookieHosts = this.#getCookieHosts();
    let thisObject = this;

    let elementList = document.querySelectorAll('.media2click-wrap');
    elementList.forEach(function(element) {
      thisObject.#initElement(element);
    });

    let toggleList = document.querySelectorAll('.media2click-toggle');
    toggleList.forEach( function (toggle) {
      thisObject.#initToggle(toggle);
    });
  }

  /**
   * Initialise a placeholder element
   * @param element
   */
  #initElement(element) {
    let thisObject = this;
    let placeholder = element.querySelector('.media2click-placeholder');
    let host = '';
    if (placeholder !== null) {
      host = placeholder.getAttribute('data-host');
      let frameData = element.querySelector('.media2click-iframedata');
      let activateOnce = element.querySelector('.media2click-once');
      let activatePermanent = element.querySelector('.media2click-permanent');

      /* Activate once and load iframe */
      if (activateOnce !== null) {
        activateOnce.addEventListener('click', function(event) {
          event.preventDefault();
          thisObject.#activateFrame(frameData, placeholder);
        }, false);
      }

      /* Activate permanently and load iframe */
      if (activatePermanent !== null) {
        activatePermanent.addEventListener('click', function(event) {
          event.preventDefault();
          thisObject.addHost(host);
          thisObject.#activateFrame(frameData, placeholder);
        }, false);
      }
      /* If already activated permanently, load iframe */
      if (thisObject.isActiveHost(host)) {
        thisObject.#activateFrame(frameData, placeholder);
      }
    }
  }

  /**
   * Initialize a toggle element
   * @param toggle
   */
  #initToggle(toggle) {
    let thisObject = this;
    let host = toggle.getAttribute('data-host');
    if(thisObject.isActiveHost(host)) {
      toggle.classList.add('activated');
      toggle.setAttribute('checked', 'checked');
    }
    toggle.addEventListener('click', function (event) {
      toggle.classList.toggle('activated');
      if (toggle.className === 'media2click-toggle activated') {
        thisObject.addHost(host);
      } else {
        thisObject.removeHost(host);
      }
    });
  }

  /**
   * Replace media2click dummy element with actual iframe
   * @param dataNode
   * @param placeholderNode
   */
  #activateFrame(dataNode, placeholderNode) {
    let newNode = document.createElement('iframe');
    let frameData = JSON.parse(dataNode.getAttribute('data-attributes'));
    Object.entries(frameData).forEach(([key, value]) => newNode.setAttribute(key, value));

    dataNode.parentElement.insertBefore(newNode, dataNode);
    dataNode.parentElement.removeChild(dataNode);
    placeholderNode.parentElement.removeChild(placeholderNode);
  }

  /**
   * Set the media2click accepted hosts cookie
   */
  #setCookie() {
    let uniqueHosts = [...new Set(this.#cookieHosts)];
    let expires = '';
    if (this.#lifetime > 0) {
      let d = new Date();
      d.setTime(d.getTime() + (this.#lifetime * 24 * 60 * 60 * 1000));
      expires = "expires=" + d.toUTCString() + ";";
    }
    document.cookie = "m2c_accepted_hosts=" + uniqueHosts.join() + ";" + expires + "path=/;SameSite=Strict";
  }

  /**
   * Get the media2click accepted hosts from cookie
   * @returns {string[]}
   */
  #getCookieHosts() {
    let thisObject = this;
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) === ' ') {
        c = c.substring(1);
      }
      if (c.indexOf("m2c_accepted_hosts=") === 0) {
        let hosts = c.substring(19, c.length).split(',');
        let uniqueHosts = [...new Set(hosts)];
        return uniqueHosts.filter(function(host) {
          return thisObject.#isValidHost(host);
        });
      }
    }
    return [];
  }

  /**
   * Delete the media2click accepted hosts cookie
   */
  #deleteCookie() {
    document.cookie = "m2c_accepted_hosts=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }

  /**
   * Check host for validity
   * @param host
   * @returns {boolean}
   */
  #isValidHost(host) {
    if (typeof host !== 'string' || host === '') {
      return false;
    }
    return !/[^a-z0-9._-]/i.test(host);
  }

  /**
   * Set the cookie lifetime
   * @param lifetime
   */
  setCookieLifetime(lifetime) {
    lifetime = Number.parseInt(lifetime, 10);
    if (Number.isNaN(lifetime) || lifetime < 0) {
      lifetime = 7;
    }
    this.#lifetime = lifetime;
  }

  /**
   *
   * @returns {string[]}
   */
  getActiveHosts() {
    return this.#cookieHosts;
  }

  /**
   * Check if a host is active
   * @param host
   * @returns {boolean}
   */
  isActiveHost(host) {
    if (!this.#isValidHost(host)) {
      return false;
    }
    return (this.#cookieHosts.indexOf(host) > -1);
  }

  /**
   * Add a host to the allowed hosts list and update the cookie
   * @param host
   * @returns {boolean}
   */
  addHost(host) {
    if (!this.#isValidHost(host)) {
      return false;
    }
    if (!this.isActiveHost(host)) {
      this.#cookieHosts.push(host);
      this.updateCookie();
    }
    return true;
  }

  /**
   * Remove a host from the allowed hosts list and update the cookie
   * @param host
   * @returns {boolean}
   */
  removeHost(host) {
    if (!this.#isValidHost(host)) {
      return false;
    }
    if (this.isActiveHost(host)) {
      this.#cookieHosts.splice(this.#cookieHosts.indexOf(host), 1);
      this.updateCookie();
    }
    return true;
  }

  /**
   * Update the cookie
   */
  updateCookie() {
    if (this.#cookieHosts.length > 0) {
      this.#setCookie();
    } else {
      this.#deleteCookie();
    }
  }

  /**
   * Activate all elements for a selected host
   * @param host
   * @returns {boolean}
   */
  activateAllForHost(host) {
    if (!this.#isValidHost(host)) {
      return false;
    }

    let thisObject = this;

    let elementList = document.querySelectorAll('.media2click-wrap');
    elementList.forEach(function(element) {
      let placeholder = element.querySelector('.media2click-placeholder');
      let elementHost = '';
      if (placeholder !== null) {
        elementHost = placeholder.getAttribute('data-host');

        let frameData = element.querySelector('.media2click-iframedata');

        if (elementHost === host) {
          thisObject.#activateFrame(frameData, placeholder);
        }
      }
    });
    return true;
  }
}

document.onreadystatechange = function () {
  if (document.readyState === 'complete') {
    if (typeof media2click === 'undefined') {
      var media2click = new Media2Click(TYPO3.settings.TS.m2cCookieLifetime);
    }
  }
};
