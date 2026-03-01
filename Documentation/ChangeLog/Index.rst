.. include:: ../Includes.txt


.. _changelog:

==========
Change Log
==========

Breaking Changes
================

Version 13.0.0 / Version 14.0.0
-------------------------------

The version number now aligns with the highest compatible TYPO3 core version.

The list of permanently allowed hosts is now stored in local storage instead of a cookie.
If a cookie is found, its content is merged into local storage and the cookie is deleted.

Version 3.0.0
-------------

The JavaScript has been rewritten to provide a clean API.
If you relied on the variables and functions previously in the global scope, you have to adapt your code to the new API.

Version 2.0.0
-------------

Some FLUID template variables have been renamed to be less generic. If you
use your own templates, you have to adapt them accordingly.

The classic rendering method has been removed.

Version 1.3.2
-------------

As of version 1.3.2, the classic rendering method is deprecated. It will be
removed in version 2.0.0.


Version 0.3
-----------

Version 0.3 introduces the cObject rendering method for the placeholder.
This method is enabled by default and uses a FLUIDTEMPLATE cObject for
rendering and XLIFF language files for localization.

If you changed the default wraps or texts in your installation, this may be
a breaking change. Use the Constant Editor to disable cObject based
rendering.

You should consider adapting your installation to the new rendering, as the
classic rendering method will be deprecated in a future version.
