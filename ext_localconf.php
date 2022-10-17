<?php
defined('TYPO3') || die();

(function() {
    /** @var \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry $rendererRegistry */
    $rendererRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::class);
    $rendererRegistry->registerRendererClass(\Amazing\Media2click\Resource\Rendering\YouTubeRenderer::class);
    $rendererRegistry->registerRendererClass(\Amazing\Media2click\Resource\Rendering\VimeoRenderer::class);

    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'tx-media2click-ce-iframe',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:media2click/Resources/Public/Icons/CeIframe.svg'
        ]
    );

    $iconRegistry->registerIcon(
        'tx-media2click-ce-content',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:media2click/Resources/Public/Icons/CeContent.svg'
        ]
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:media2click/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig"'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Media2click',
        'List',
        [\Amazing\Media2click\Controller\HostController::class => 'index'],
        []
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals']['Amazing\\Media2click\\Evaluation\\UrlSchemeEvaluation'] = '';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['record_is_used']['tx_media2click']
        = 'Amazing\\Media2click\\Hooks\\UsedRecords->addMedia2ClickContent';
}) ();
