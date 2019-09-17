.. include:: ../Includes.txt

.. highlight:: typoscript

.. _configuration:

Configuration
=============

Reference
---------

Constants
~~~~~~~~~

Properties of plugin.media2click. Use the Constant Editor to change these settings:


.. _constants-enable:

enable
""""""

:aspect:`Property:`
   enable

:aspect:`Data type:`
   boolean

:aspect:`Description:`
   Enable the extension's functionality

:aspect:`Default:`
   0


.. _constants-showtitle:

showTitle
"""""""""

:aspect:`Property:`
   showTitle

:aspect:`Data type:`
   boolean

:aspect:`Description:`
   Enable display of the video's title as the palceholder's title

:aspect:`Default:`
   1

.. _constants-showpreviewimage:

showPreviewImage
""""""""""""""""

:aspect:`Property:`
   showPreviewImage

:aspect:`Data type:`
   boolean

:aspect:`Description:`
   Enable display of the video's preview image

:aspect:`Default:`
   1

   Properties:

   :ts:`maxWidth:` integer
      Maximum width

   :ts:`maxHeight:` integer
      Maximum height


TypoScript Setup
~~~~~~~~~~~~~~~~

All configuration is forwarded to the renderer classes via the settings of the corresponding FLUIDTEMPLATE and the additionalConfig attribute of the Fluid media viewhelper. Therefore all settings are not interpreted as TypoScript, but just used as is. It's not possible to use additional TypoScript to dynamically change these attributes.

For FluidStyledContent content elements, everything has to be set up in lib.contentElement.settings.media.additionalConfig.

For the News extension, use plugin.tx_news.settings.detail.media.video.additionalConfig.

As stated above, there is no interpreting of TypoScript inside a FLUIDTEMPLATE's settings. So you can not use the reference operator '=<' to reuse the settings of lib.contentElement in another FLUIDTEMPLATE, but have to use the copy operator '<'.

These parameters are available:


.. _enable2click:

enable2click
""""""""""""

:aspect:`Property:`
   enable2click

:aspect:`Data type:`
   boolean

:aspect:`Description:`
   Enable the extension's functionality. Set via Constant Editor.

:aspect:`Default:`
   0


.. _placeholdercontent:

placeholderContent
""""""""""""""""""

:aspect:`Property:`
   placeholderContent

:aspect:`Data type:`
   Array

:aspect:`Description:`
   parent attribute to all settings regarding the content of the placeholder

   Properties:

   :ts:`.value:` String
      Default text

   :ts:`.lang:` Array
      Array of language keys, defining optional language specific values

   :ts:`.wrap:` wrap
      This wraps the content.

   :ts:`.showTitle:` boolean
      If enabled, the Fluid media tag's title attribute is shown as the palceholder's title. Set via Constant Editor.

   :ts:`.titleWrap:` wrap
      This wraps the title.

   :ts:`.showPreviewImage:` boolean
      Show preview image if available. Set via Constant editor.

   :ts:`.previewMaxWidth:` integer
      Maximum width of preview image. Set via Constant Editor.

   :ts:`.previewMaxHeight:` integer
      Maximum height of preview image. Set via Constant Editor.
