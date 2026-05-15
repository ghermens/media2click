class Media2Click {
  #activeHosts = [];
  #lifetime = -1;

  constructor(lifetime = -1) {
    this.setLifetime(lifetime);

    let cookieHosts = this.#getCookieHosts();
    let storageHosts = this.#getStorageHosts();
    this.#activeHosts = [...new Set([...cookieHosts, ...storageHosts])];

    if (cookieHosts.length > 0) {
      this.#setStorage();
      this.#deleteCookie()
    }

    let thisObject = this;

    let elementList = document.querySelectorAll('.media2click-wrap');
    elementList.forEach(function(element) {
      thisObject.#initElement(element);
    });

    let toggleList = document.querySelectorAll('.media2click-toggle');
    toggleList.forEach(function(toggle) {
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
      let type = 'iframe';
      if (placeholder.classList.contains('media2click-placeholder-content')) {
        type = 'content';
      }
      let contentData = element.querySelector('.media2click-contentdata');
      let frameData = element.querySelector('.media2click-iframedata');
      let activateOnce = element.querySelector('.media2click-once');
      let activatePermanent = element.querySelector('.media2click-permanent');

      /* Activate once and load iframe */
      if (activateOnce !== null) {
        activateOnce.addEventListener('click', function(event) {
          event.preventDefault();
          if (type === 'content') {
            thisObject.#activateContent(contentData, placeholder);
          } else {
            thisObject.#activateFrame(frameData, placeholder);
          }
        }, false);
      }

      /* Activate permanently and load iframe */
      if (activatePermanent !== null) {
        activatePermanent.addEventListener('click', function(event) {
          event.preventDefault();
          thisObject.addHost(host);
          if (type === 'content') {
            thisObject.#activateContent(contentData, placeholder);
          } else {
            thisObject.#activateFrame(frameData, placeholder);
          }
        }, false);
      }
      /* If already activated permanently, load iframe */
      if (thisObject.isActiveHost(host)) {
        if (type === 'content') {
          thisObject.#activateContent(contentData, placeholder);
        } else {
          thisObject.#activateFrame(frameData, placeholder);
        }
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
    if (thisObject.isActiveHost(host)) {
      toggle.classList.add('activated');
      toggle.setAttribute('checked', 'checked');
    }
    toggle.addEventListener('click', function() {
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

  #activateContent(contentNode, placeholderNode) {
    const contentData = JSON.parse(contentNode.text);
    if (typeof trustedTypes === "undefined") {
      trustedTypes = {createPolicy: (n, rules) => rules};
    }
    const myPolicy = trustedTypes.createPolicy('myPolicy', {createHTML: (input) => input});
    if (contentData.security === 'sandbox') {
      const newNode = document.createElement('iframe');
      Object.entries(contentData.attributes).forEach(([key, value]) => newNode.setAttribute(key, value));
      newNode.setAttribute('srcdoc', myPolicy.createHTML(contentData.content));
      newNode.setAttribute('sandbox', 'allow-downloads allow-forms allow-modals allow-popups allow-popups-to-escape-sandbox allow-scripts');
      contentNode.parentElement.insertBefore(newNode, contentNode);
    } else {
      const newNode = document.createElement('div');
      Object.entries(contentData.attributes).forEach(([key, value]) => newNode.setAttribute(key, value));
      newNode.insertAdjacentHTML('afterbegin', myPolicy.createHTML(contentData.content));
      contentNode.parentElement.insertBefore(newNode, contentNode);
      if (contentData.security === 'free') {
        placeholderNode.parentElement.classList.remove('media2click-ratio', 'media2click-ratio-219', 'media2click-ratio-169', 'media2click-ratio-32', 'media2click-ratio-43', 'media2click-ratio-50vh', 'media2click-ratio-75vh', 'media2click-ratio-90vh', 'media2click-ratio-fixed', 'media2click-position-left', 'media2click-position-center', 'media2click-position-right');
        placeholderNode.parentElement.removeAttribute('style');
      }
      /* Reinsert scripts to trigger execution */
      const scripts = Array.from(newNode.querySelectorAll('script'));
      scripts.forEach(oldScriptElement => {
        const newScriptElement = document.createElement('script');
        Array.from(oldScriptElement.attributes).forEach(attr => newScriptElement.setAttribute(attr.name, attr.value));
        newScriptElement.text = oldScriptElement.text;
        oldScriptElement.parentNode.replaceChild(newScriptElement, oldScriptElement);
      });
    }
    contentNode.parentElement.removeChild(contentNode);
    placeholderNode.parentElement.removeChild(placeholderNode);
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
   * Set the media2click accepted hosts in the local storage
   */
  #setStorage() {
    if (this.#lifetime < 1) {
      this.#deleteStorage();
      return;
    }
    let uniqueHosts = [...new Set(this.#activeHosts)];
    localStorage.setItem('m2c_accepted_hosts', JSON.stringify({hosts: uniqueHosts, validUntil: (new Date()).getTime() + (this.#lifetime * 24 * 60 * 60 * 1000)}));
  }

  /**
   * Get the media2click accepted hosts from the local storage
   * @returns {string[]}
   */
  #getStorageHosts() {
    let thisObject = this;
    let storageItem = localStorage.getItem('m2c_accepted_hosts');
    if (storageItem === null) {
      return [];
    }
    let parsedItem = JSON.parse(storageItem);
    if (isNaN(parsedItem.validUntil) || parsedItem.validUntil < (new Date()).getTime()) {
      this.#deleteStorage();
      return [];
    }
    if (parsedItem.hosts !== null) {
      let uniqueHosts = [...new Set(parsedItem.hosts)];
      return uniqueHosts.filter(function(host) {
        return thisObject.#isValidHost(host);
      });
    }
    return [];
  }

  /**
   * Delete the media2click accepted hosts from the local storage
   */
  #deleteStorage() {
    localStorage.removeItem('m2c_accepted_hosts');
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
   * Set the consent lifetime
   * @param lifetime
   */
  setLifetime(lifetime) {
    lifetime = Number.parseInt(lifetime, 10);
    if (Number.isNaN(lifetime) || lifetime < 0) {
      lifetime = 7;
    }
    this.#lifetime = lifetime;
  }

  setCookieLifetime(lifetime) {
    this.setLifetime(lifetime);
  }

  /**
   *
   * @returns {string[]}
   */
  getActiveHosts() {
    return this.#activeHosts;
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
    return (this.#activeHosts.indexOf(host) > -1);
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
      this.#activeHosts.push(host);
      this.updateStorageData();
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
      this.#activeHosts.splice(this.#activeHosts.indexOf(host), 1);
      this.updateStorageData();
    }
    return true;
  }

  /**
   * Update the cookie
   */
  updateStorageData() {
    if (this.#activeHosts.length > 0) {
      this.#setStorage();
    } else {
      this.#deleteStorage();
    }
  }

  updateCookie() {
    this.updateStorageData();
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
        let type = 'iframe';
        if (placeholder.classList.contains('media2click-placeholder-content')) {
          type = 'content';
        }

        let contentData = element.querySelector('.media2click-contentdata');
        let frameData = element.querySelector('.media2click-iframedata');

        if (elementHost === host) {
          if (type === 'content') {
            thisObject.#activateContent(contentData, placeholder);
          } else {
            thisObject.#activateFrame(frameData, placeholder);
          }
        }
      }
    });
    return true;
  }
}

document.addEventListener('readystatechange', (event) => {
  if (event.target.readyState === 'complete') {
    if (typeof media2click === 'undefined') {
      if (typeof m2cLifetime === 'undefined' || isNaN(m2cLifetime)) {
        const media2click = new Media2Click();
      } else {
        const media2click = new Media2Click(m2cLifetime);
      }
    }
  }
});
