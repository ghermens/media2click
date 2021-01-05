.. include:: ../Includes.txt


.. _upgrade:

=======
Upgrade
=======

Version 0.3
===========

Version 0.3 introduces the cObject rendering method for the placeholder.
This method is enabled by default and uses a FLUIDTEMPLATE cObject for
rendering and XLIFF language files for localization.

If you changed the default wraps or texts in your installation, this may be
a breaking change. Use the Constant Editor to disable cObject based
rendering.

You should consider adapting your installation to the new rendering, as the
classic rendering method will be deprecated in a future version.
