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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\Exception\ContentRenderingException;

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
     * @param int|string $width
     * @param int|string $height
     * @return string
     */
    public function render(FileInterface $file, $width, $height, array $options = [])
    {
        $options = $this->collectOptions($options, $file);

        if (empty($options['additionalConfig']['enable2click'])) {
            return parent::render($file, $width, $height, $options);
        }

        $iframe = preg_replace(
            [
                '| class="|',
                '|<iframe |',
                '| allowfullscreen |',
                '| ([a-z-]+)="([^"]*)"|',
                '|&quot;|',
                '|&|',
                '|,></iframe>|',
            ],
            [
                ' class="media2click-iframe ',
                '<div data-attributes=\'{ ',
                ' allowfullscreen="" ',
                '"$1": "$2",',
                '\\u0022',
                '\\u0026',
                '}\' class="media2click-iframedata"></div>',
            ],
            parent::render($file, $width, $height, $options),
        );

        $placeholder = $this->renderPlaceholder($file, $width, $height, $options);

        return '<div class="media2click-wrap">' . $placeholder . $iframe . '</div>';
    }

    /**
     * @param int|string $width
     * @param int|string $height
     * @throws ContentRenderingException
     */
    protected function renderPlaceholder(FileInterface $file, $width, $height, array $options = []): string
    {
        /** @var ContentObjectRenderer $contentObjectRenderer */
        $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $contentObjectRenderer->setRequest($contentObjectRenderer->getRequest());

        $placeholderContentSetup = $options['additionalConfig']['placeholderContent'] ?? [];

        $style = '';
        if ((int)$width > 0) {
            $style .= 'width: ' . (int)$width . 'px;';
        }

        if ((int)$height > 0) {
            $style .= 'height: ' . (int)$height . 'px;';
        }

        $previewImageWebPath = null;

        if (!empty($placeholderContentSetup['showPreviewImage'])) {
            $orgFile = $file instanceof FileReference ? $file->getOriginalFile() : $file;

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
                            'showTitle'     => $conf['showTitle'],
                            'title'         => $options['title'] ?? '',
                            'width'         => (int)$width,
                            'height'        => (int)$height,
                            'previewImage'  => $previewImageWebPath,
                        ],
                    ],
                );
            }

            $placeholderContent = $contentObjectRenderer->cObjGetSingle($conf['cObject'], $conf['cObject.']);
        } else {
            trigger_error(
                'Classic rendering method is deprecated since version 1.3.2 and has been removed in version 2.0.0',
                E_USER_WARNING,
            );

            $placeholderContent = '';
        }
        return $placeholderContent;
    }
}
