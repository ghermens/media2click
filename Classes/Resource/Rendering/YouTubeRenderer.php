<?php
namespace Amazing\Media2click\Resource\Rendering;

/***
 *
 * This file is part of the "2 Clicks for External Media" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Gregor Hermens <gregor.hermens@a-mazing.de>, @mazing
 *
 ***/

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class YouTubeRenderer extends \TYPO3\CMS\Core\Resource\Rendering\YouTubeRenderer
{
    /**
     * @return int
     */
    public function getPriority()
    {
        return 25;
    }

    /**
     * @param FileInterface $file
     * @param int|string $width
     * @param int|string $height
     * @param array $options
     * @param bool $usedPathsRelativeToCurrentScript
     * @return string
     */
    public function render(FileInterface $file, $width, $height, array $options = [], $usedPathsRelativeToCurrentScript = false)
    {
        $options = $this->collectOptions($options, $file);

        if (empty($options['additionalConfig']['enable2click'])) {
            return parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript);
        }

        $iframe = preg_replace(
            [
                '| class="|',
                '|<iframe |',
                '| allowfullscreen |',
                '| ([a-z-]+)="([^"]*)"|',
                '|&quot;|',
                '|&|',
                '|,></iframe>|'
            ],
            [
                ' class="media2click-iframe ',
                '<div data-attributes=\'{ ',
                ' allowfullscreen="" ',
                '"$1": "$2",',
                '\\u0022',
                '\\u0026',
                '}\' class="media2click-iframedata"></div>'
            ],
            parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript)
        );

        $placeholder = $this->renderPlaceholder($file, $width, $height, $options);

        return '<div class="media2click-wrap">' . $placeholder . $iframe . '</div>';
    }


    /**
     * @param FileInterface $file
     * @param int|string $width
     * @param int|string $height
     * @param array $options
     * @return string
     */
    protected function renderPlaceholder(FileInterface $file, $width, $height, array $options = [])
    {

        /** @var ContentObjectRenderer $contentObjectRenderer */
        $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class, $GLOBALS['TSFE']);

        $placeholderContentSetup = $options['additionalConfig']['placeholderContent'] ?? [];

        $style = '';
        if ((int)$width > 0) {
            $style .= 'width: ' . (int)$width . 'px;';
        }

        if ((int)$height > 0) {
            $style .= 'height: ' . (int)$height . 'px;';
        }

        $hasPreview = false;
        $previewImageWebPath = null;

        if (!empty($placeholderContentSetup['showPreviewImage'])) {
            if ($file instanceof FileReference) {
                $orgFile = $file->getOriginalFile();
            } else {
                $orgFile = $file;
            }

            $previewImage = $this->onlineMediaHelper->getPreviewImage($orgFile);

            /* Make sure the preview image is always publicly available */
            $publicPreviewImage = Environment::getPublicPath() . '/typo3temp/assets/images/' . basename($previewImage);
            if (
                file_exists($previewImage) && (
                    !file_exists($publicPreviewImage) ||
                    filemtime($previewImage) > filemtime($publicPreviewImage)
                )
            ) {
                GeneralUtility::writeFileToTypo3tempDir($publicPreviewImage, @file_get_contents($previewImage));
            }

            if (file_exists($publicPreviewImage)) {
                $conf = [
                    'file' => $publicPreviewImage,
                    'file.' => [
                        'maxW' => ($placeholderContentSetup['previewMaxWidth'] ?? ''),
                        'maxH' => ($placeholderContentSetup['previewMaxHeight'] ?? ''),
                    ],
                ];

                if ((int)$width > 0) {
                    $conf['file.']['width'] = (int)$width . 'c';
                }

                if ((int)$height > 0) {
                    $conf['file.']['height'] = (int)$height . 'c';
                }

                $previewImageWebPath = '/' . ltrim($contentObjectRenderer->cObjGetSingle('IMG_RESOURCE', $conf), '/');
            }
        }

        if (!empty($placeholderContentSetup['cObject']['_typoScriptNodeValue'])) {

            /** @var TypoScriptService $typoScriptService */
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);

            $conf = $typoScriptService->convertPlainArrayToTypoScriptArray($placeholderContentSetup);

            if ($conf['cObject'] === 'FLUIDTEMPLATE') {
                $conf['cObject.'] = array_merge_recursive(
                    $conf['cObject.'],
                    [
                        'settings.' => [
                            'videoProvider' => 'YouTube',
                            'showTitle' => $conf['showTitle'],
                            'title' => $options['title'],
                            'width' => (int)$width,
                            'height' => (int)$height,
                            'previewImage' => $previewImageWebPath,
                        ]
                    ]
                );
            }

            $placeholderContent = $contentObjectRenderer->cObjGetSingle($conf['cObject'], $conf['cObject.']);

        } else {

            trigger_error(
                'Classic rendering method is deprecated since version 1.3.2 and has been removed in version 2.0.0',
                E_USER_WARNING
            );

            $placeholderContent = '';

        }
        return $placeholderContent;
    }
}
