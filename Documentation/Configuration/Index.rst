.. include:: ../Includes.txt

.. highlight:: typoscript

.. _configuration:

=============
Configuration
=============

.. _typoscriptconstants:

TypoScript Constants
====================

Properties of plugin.media2click. Use the Constant Editor to change these settings:


.. _constants-enable:

enable
~~~~~~

:aspect:`Property:`
   enable

:aspect:`Data type:`
   :ref:`boolean <t3tsref:data-type-boolean>`

:aspect:`Description:`
   Enable the extension's functionality

:aspect:`Default:`
   0

.. _constants-enablepermanently:

enablePermanently
~~~~~~~~~~~~~~~~~

:aspect:`Property:`
   enablePermanently

:aspect:`Datatype:`
   :ref:`boolean <t3tsref:data-type-boolean>`

:aspect:`Description:`
   Generally allow or disallow the permanent activation of accordingly configured target hosts.

:aspect:`Default:`
   0

.. _constants-allwrap:

showTitle
~~~~~~~~~

:aspect:`Property:`
   showTitle

:aspect:`Data type:`
   :ref:`boolean <t3tsref:data-type-boolean>`

:aspect:`Description:`
   Enable display of the video's title as the palceholder's title

:aspect:`Default:`
   1

.. _constants-showpreviewimage:

showPreviewImage
~~~~~~~~~~~~~~~~

:aspect:`Property:`
   showPreviewImage

:aspect:`Data type:`
   :ref:`boolean <t3tsref:data-type-boolean>`

:aspect:`Description:`
   Enable display of the video's preview image

:aspect:`Default:`
   1

   Properties:

   :ts:`maxWidth:` :ref:`integer <t3tsref:data-type-integer>`
      Maximum width

   :ts:`maxHeight:` :ref:`integer <t3tsref:data-type-integer>`
      Maximum height

.. _constants-cookielifetime:

cookieLifetime
~~~~~~~~~~~~~~

:aspect:`Property:`
   cookieLifetime

:aspect:`Data type:`
   :ref:`int+ <t3tsref:data-type-intplus>`

:aspect:`Description:`
   Cookie lifetime in days. Set to 0 to limit the cookie to the session.

:aspect:`Default:`
   7

.. _constants-templaterootpath:

templateRootPath
~~~~~~~~~~~~~~~~

:aspect:`Property:`
   templateRootPath

:aspect:`Data type:`
   :ref:`string <t3tsref:data-type-string>`

:aspect:`Description:`
   Path to your Fluid templates

.. _constants-partialrootpath:

partialRootPath
~~~~~~~~~~~~~~~~

:aspect:`Property:`
   partialRootPath

:aspect:`Data type:`
   :ref:`string <t3tsref:data-type-string>`

:aspect:`Description:`
   Path to your Fluid partials

.. _constants-layoutrootpath:

layoutRootPath
~~~~~~~~~~~~~~~~

:aspect:`Property:`
   layoutRootPath

:aspect:`Data type:`
   :ref:`string <t3tsref:data-type-string>`

:aspect:`Description:`
   Path to your Fluid layouts

.. _constants-privacypid:

privacyPid
~~~~~~~~~~

:aspect:`Property:`
   privacyPid

:aspect:`Data type:`
   :ref:`integer <t3tsref:data-type-integer>`

:aspect:`Description:`
   Page id of your privacy statement page

:aspect:`Default:`
   0

.. _constants-storagepid:

storagePid
~~~~~~~~~~

:aspect:`Property:`
   storagePid

:aspect:`Data type:`
   :ref:`integer <t3tsref:data-type-integer>`

:aspect:`Description:`
   Page id of your storage page with the individual target host configuration

:aspect:`Default:`
   0


.. _typoscriptsetup:

TypoScript Setup
================

All configuration is forwarded to the renderer classes via the settings of the corresponding FLUIDTEMPLATE and the
additionalConfig attribute of the Fluid media viewhelper. Therefore all settings are not interpreted as TypoScript, but
just used as is. It's not possible to use additional TypoScript to dynamically change these attributes.

For FluidStyledContent content elements, everything has to be set up in lib.contentElement.settings.media.additionalConfig.

For the News extension, use plugin.tx_news.settings.detail.media.video.additionalConfig.

As stated above, there is no interpreting of TypoScript inside a FLUIDTEMPLATE's settings. So you can not use the
reference operator '=<' to reuse the settings of lib.contentElement in another FLUIDTEMPLATE, but have to use the copy operator '<'.

These parameters are available:


.. _enable2click:

enable2click
~~~~~~~~~~~~

:aspect:`Property:`
   enable2click

:aspect:`Data type:`
   :ref:`boolean <t3tsref:data-type-boolean>`

:aspect:`Description:`
   Enable the extension's functionality. Set via Constant Editor.

:aspect:`Default:`
   0


.. _placeholdercontent:

placeholderContent
~~~~~~~~~~~~~~~~~~

:aspect:`Property:`
   placeholderContent

:aspect:`Data type:`
   array of keys

:aspect:`Description:`
   Parent property to all settings regarding the content of the placeholder

:aspect:`Properties:`
   :ts:`.showTitle:` :ref:`boolean <t3tsref:data-type-boolean>`
      If enabled, the Fluid media tag's title attribute is shown as the palceholder's title. Set via Constant Editor.

   :ts:`.showPreviewImage:` :ref:`boolean <t3tsref:data-type-boolean>`
      Show preview image if available. Set via Constant editor.

   :ts:`.previewMaxWidth:` :ref:`integer <t3tsref:data-type-integer>`
      Maximum width of preview image. Set via Constant Editor.

   :ts:`.previewMaxHeight:` :ref:`integer <t3tsref:data-type-integer>`
      Maximum height of preview image. Set via Constant Editor.

   :ts:`.cObject:` :ref:`cObject <t3tsref:data-type-cobject>`
      This cObject is used for rendering the placeholder. If this cObject is a :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>`,
      some useful values are passed to the fluid template as settings:

      :ts:`.settings:` array of keys
         :ref:`Settings for the FLUIDTEMPLATE cObject <t3tsref:cobj-fluidtemplate-properties-settings>`.
         You can add your own properties according to the needs of your custom templates.

         :aspect:`Default Properties:`
            :ts:`.videoProvider:` :ref:`string <t3tsref:data-type-string>`
               Provider of the video, i.e. "YouTube" or "Vimeo". Usefull to adapt the placeholder content, i.e. link to the
               proper privacy statement.

            :ts:`.showTitle:` :ref:`boolean <t3tsref:data-type-boolean>`
               see above

            :ts:`.title:` :ref:`string <t3tsref:data-type-string>`
               The title of the video

            :ts:`.width:` :ref:`integer <t3tsref:data-type-integer>`
               The calculated width of the video iframe

            :ts:`.height:` :ref:`integer <t3tsref:data-type-integer>`
               The calculated height of the video iframe

            :ts:`.previewImage:` :ref:`string <t3tsref:data-type-string>`
               Path to the preview image relative to the web root

            :ts:`.enablePermanently:` :ref:`boolean <t3tsref:data-type-boolean>`
               Show the button for permanent activation if configured for this host.

            :ts:`.privacyPid:` :ref:`integer <t3tsref:data-type-integer>`
               Target page for the "More Info" link. Set via Constant Editor.
