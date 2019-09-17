<?php
defined('TYPO3_MODE') or die();

call_user_func(function() {
    /** @var \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry $rendererRegistry */
    $rendererRegistry = \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::getInstance();
    $rendererRegistry->registerRendererClass(\Amazing\Media2click\Resource\Rendering\YouTubeRenderer::class);
    $rendererRegistry->registerRendererClass(\Amazing\Media2click\Resource\Rendering\VimeoRenderer::class);
});