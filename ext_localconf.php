<?php

use Amazing\Media2click\Controller\HostController;
use Amazing\Media2click\Resource\Rendering\VimeoRenderer;
use Amazing\Media2click\Resource\Rendering\YouTubeRenderer;
use TYPO3\CMS\Core\Resource\Rendering\RendererRegistry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die;

/** @var RendererRegistry $rendererRegistry */
$rendererRegistry = GeneralUtility::makeInstance(RendererRegistry::class);
$rendererRegistry->registerRendererClass(YouTubeRenderer::class);
$rendererRegistry->registerRendererClass(VimeoRenderer::class);

ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:media2click/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig"'
);

ExtensionUtility::configurePlugin(
    'Media2click',
    'List',
    [HostController::class => 'index'],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals']['Amazing\\Media2click\\Evaluation\\UrlSchemeEvaluation'] = '';
