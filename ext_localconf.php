<?php
defined('TYPO3_MODE') || die();

(function() {
    /** @var \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry $rendererRegistry */
    $rendererRegistry = \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::getInstance();
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

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:media2click/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig"'
    );
}) ();
