.. include:: ../Includes.txt


.. _administrator:

==============
Administration
==============

Basic Setup
===========

- :ref:`Include the extension’s static template <t3tsref:static-includes>` into your TypoScript template.
  New in TYPO3 13: You can include the media2click configuration as :ref:`Site Set <t3coreapi:site-sets>`
  'amazing/media2click' in your site configuration or site package extension.
- If your main :ref:`PAGE <t3tsref:page>` object is not named ‘page’, adapt the TypoScript Setup accordingly.
- Activate the extension's functionality via the Constant Editor: :ref:`constants-enable`
- If the "Content with consent" content element is to be used, all required hosts have to be configured explicitly: :ref:`host-configuration`

Advanced Setup
==============

.. _host-configuration:

If individual placeholder content or permanent activation is required
---------------------------------------------------------------------

- Globally allow permanent activation via the Constant Editor: :ref:`constants-enablepermanently`
- Set up a page of type sysfolder to hold the host data.
- Set storagePid to this sysfolder's uid via the Constant Edtior: :ref:`constants-storagepid`
- Using the list module, add a host configuration to your storage page for every target host that needs individual
  placeholder content or permanent activation. For videos, you have to use "YouTube" and "Vimeo" as hostnames:

.. figure:: ../Images/HostConfiguration.png
   :alt: Host Configuration Form: General
   :class: with-shadow

   Example host configuration for YouTube videos

- You can add individual placeholder content and/or a logo in the placeholder tab:

.. figure:: ../Images/HostConfiguration2.png
   :alt: Host Configuration Form: Placeholder
   :class: with-shadow

   Example host configuration for YouTube videos

- Set privacyPid to the uid of your privacy statement page via the Constant Edtior: :ref:`constants-privacypid`
- Insert content elements of type "Toggle permanent activation of external content" on your privacy
  statement page. You can filter the list of shown hosts in the plugin options:

.. figure:: ../Images/PluginHostList.png
   :alt: Plugin form
   :class: with-shadow

   Plugin BE form


.. _hosttemplate:

Individual Host Templates
-------------------------

If individual text and logo is not enough, you can configure individual fluid templates for your hosts' placeholders:
Just add a file named after the host in Fluid Styled Contents' partial root paths. For example for the host www.example.com
this file would be named (...)/Partials/Media2click/Placeholder/www.example.com.html

There is an example template for www.example.com included in this extension.

.. _emptycontent:

Empty Content
-------------

If the content of the "Content with consent" content element is empty (whitespace only), the placeholder is not rendered at all.

E.g. with the :ref:`TYPO3 Content Elements based on Fluid <typo3/cms-fluid-styled-content:start>` extension, you have to adapt the layout to remove all frame and anchor markup from your embedded content elements. See :ref:`Overriding the Fluid templates <typo3/cms-fluid-styled-content:overriding-fluid-templates>` for details.
