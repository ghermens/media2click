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

.. _constants-disablecobj:

disableCObj
"""""""""""

:aspect:`Property:`
   disableCObj

:aspect:`Datatype:`
   comment

:aspect:`Description:`
   Disable the cObject / FLUIDTEMPLATE rendering, switch back to classic rendering instead

:aspect:`Default:`
   #

.. _constants-enablepermanently:

enablePermanently
"""""""""""""""""

:aspect:`Property:`
   enablePermanently

:aspect:`Datatype:`
   boolean

:aspect:`Description:`
   Generally allow or disallow the permanent activation of accordingly configured target hosts.

:aspect:`Default:`
   0

.. _constants-allwrap:

allWrap
"""""""

:aspect:`Property`
   allWrap

:aspect:`Data type:`
   wrap

:aspect:`Description`
   Additional wrap to all placeholder content (only used with classic rendering)

:aspect:`Default:`
   <div class="media2click-placeholder-inner">|</div>

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

.. _constants-templaterootpath:

templateRootPath
""""""""""""""""

:aspect:`Property:`
   templateRootPath

:aspect:`Data type:`
   String

:aspect:`Description:`
   Path to your Fluid templates when using the FLUIDTEMPLATE cObject rendering for videos

.. _constants-partialrootpath:

partialRootPath
""""""""""""""""

:aspect:`Property:`
   partialRootPath

:aspect:`Data type:`
   String

:aspect:`Description:`
   Path to your Fluid partial when using the FLUIDTEMPLATE cObject rendering for videos

.. _constants-layoutrootpath:

layoutRootPath
""""""""""""""""

:aspect:`Property:`
   layoutRootPath

:aspect:`Data type:`
   String

:aspect:`Description:`
   Path to your Fluid layouts when using the FLUIDTEMPLATE cObject rendering for videos

.. _constants-privacypid:

privacyPid
""""""""""

:aspect:`Property:`
   privacyPid

:aspect:`Data type:`
   integer

:aspect:`Description:`
   Page id of your privacy statement page

:aspect:`Default:`
   0

.. _constants-storagepid:

storagePid
""""""""""

:aspect:`Property:`
   storagePid

:aspect:`Data type:`
   integer

:aspect:`Description:`
   Page id of your storage page with the individual target host configuration

:aspect:`Default:`
   0


.. _typoscriptsetup:

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

   :ts:`.allWrap:`
      This wraps the whole placeholder content.  (only used with classic rendering)

   :ts:`.value:` String
      Default text  (only used with classic rendering)

   :ts:`.lang:` Array
      Array of language keys, defining optional language specific values  (only used with classic rendering)

   :ts:`.wrap:` wrap
      This wraps the content.  (only used with classic rendering)

   :ts:`.showTitle:` boolean
      If enabled, the Fluid media tag's title attribute is shown as the palceholder's title. Set via Constant Editor.

   :ts:`.titleWrap:` wrap
      This wraps the title.  (only used with classic rendering)

   :ts:`.showPreviewImage:` boolean
      Show preview image if available. Set via Constant editor.

   :ts:`.previewMaxWidth:` integer
      Maximum width of preview image. Set via Constant Editor.

   :ts:`.previewMaxHeight:` integer
      Maximum height of preview image. Set via Constant Editor.

   :ts:`.cObject:` cObject
      If present, this cObject is used for rendering the placeholder. If this cObject is a FLUIDTEMPLATE, some useful values are passed to the fluid template as settings:

      :ts:`.settings:`
         Settings for the FLUIDTEMPLATE cObject

         Default properties:

         :ts:`.videoProvider:` String
            Provider of the video, i.e. "YouTube" or "Vimeo". Usefull to adapt the placeholder content, i.e. link to the proper privacy statement.

         :ts:`.showTitle:` boolean
            see above

         :ts:`.title:` String
            The title of the video

         :ts:`.width:` integer
            The calculated width of the video iframe

         :ts:`.height:` integer
            The calculated height of the video iframe

         :ts:`.previewImage:` String
            Path to the preview image relative to the web root

         :ts:`.enablePermanently:` boolean
            Show the button for permanent activation if configured for this host.

         :ts:`.privacyPid:` integer
            Target page for the "More Info" link. Set via Constant Editor.

