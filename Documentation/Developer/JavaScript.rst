.. include:: ../Includes.txt

.. _javascript:

==========
JavaScript
==========



.. _javascript-api:

JavaScript API
==============

:file:`media2click.js` exposes these methods:

.. _jsapi-setcookielifetime:

media2click.setCookieLifetime(lifetime)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

:aspect:`Parameter data type:`
   integer

:aspect:`Return data type:`
   void

Sets the cookie lifetime to the number of days given.

.. _jsapi-getactivehosts:

media2click.getActiveHosts()
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

:aspect:`Return data type:`
   array

Returns an array of all currently activated hosts.

.. _jsapi-isactivehost:

media2click.isActiveHost(host)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

:aspect:`Parameter data type:`
   string

:aspect:`Return data type:`
   boolean

Returns the current activation status of the given host.

.. _jsapi-addhost:

media2click.addHost(host)
~~~~~~~~~~~~~~~~~~~~~~~~~

:aspect:`Parameter data type:`
   string

:aspect:`Return data type:`
   void

Activate the host and update the cookie.

.. _jsapi-removehost:

media2click.removeHost(host)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

:aspect:`Parameter data type:`
   string

:aspect:`Return data type:`
   void

Deactivate the host and update the cookie.

.. _jsapi-updatecookie:

media2click.updateCookie()
~~~~~~~~~~~~~~~~~~~~~~~~~~

:aspect:`Return data type:`
   void

Update the cookie.

.. _jsapi-activateallforhost:

media2click.activateAllForHost(host)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

:aspect:`Parameter data type:`
   string

:aspect:`Return data type:`
   void

Immediately activate the content of all content elements atached to the given host.

.. _jsapi-bestpractice:

=============
Best Practice
=============

The initialization of the media2click object ist delayed until the document is in a complete ready state. If this leads to undefined variable errors, use something like this:

.. code-block:: js

   document.onreadystatechange = function () {
     if (document.readyState === 'complete') {
       if (typeof media2click === 'undefined') {
         var media2click = new Media2Click(TYPO3.settings.TS.m2cCookieLifetime);
       }

      /* your code here ... */
     }
   };
