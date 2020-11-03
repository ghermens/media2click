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

        if (!$options['additionalConfig']['enable2click']) {
            return parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript);
        }

        $iframe = str_replace(' src="', ' src="" data-src="', parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript));


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

        $placeholderContentSetup = $options['additionalConfig']['placeholderContent'];

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

            /* In composer installations $previewImage is outside of publicPath */
            if (Environment::getVarPath() !== Environment::getPublicPath() . '/typo3temp/var') {
                $tempFile = str_replace(Environment::getVarPath() . '/transient', Environment::getPublicPath() . '/typo3temp/assets/images', $previewImage);
                GeneralUtility::writeFileToTypo3tempDir($tempFile, @file_get_contents($previewImage));
                $previewImage = $tempFile;
            }

            if (file_exists($previewImage)) {
                $conf = [
                    'file' => $previewImage,
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

                $previewImageWebPath = $contentObjectRenderer->cObjGetSingle('IMG_RESOURCE', $conf);
                $style .= 'background-image:url(/' . $previewImageWebPath . ');';
                $hasPreview = true;
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

            $placeholderContent = null;

            if (is_array($placeholderContentSetup)) {
                if (isset($placeholderContentSetup['value'])) {
                    $placeholderContent = $placeholderContentSetup['value'];
                }

                if (is_array($placeholderContentSetup['lang'])) {
                    $typo3Language = $contentObjectRenderer->cObjGetSingle('TEXT', ['data' => 'siteLanguage:typo3Language']);

                    if (array_key_exists($typo3Language, $placeholderContentSetup['lang'])) {
                        $placeholderContent = $placeholderContentSetup['lang'][$typo3Language];
                    }
                }

                if (!empty($placeholderContentSetup['wrap'])) {
                    $wrapArr = explode('|', $placeholderContentSetup['wrap']);
                    $placeholderContent = trim($wrapArr[0] ?? '') . $placeholderContent . trim($wrapArr[1] ?? '');
                }
            }

            if ($placeholderContent === null) {
                $placeholderContent = 'Click to load external video!';
            }

            if (!empty($options['title']) && !empty($placeholderContentSetup['showTitle'])) {
                $title = $options['title'];

                if (!empty($placeholderContentSetup['titleWrap'])) {
                    $wrapArr = explode('|', $placeholderContentSetup['titleWrap']);
                    $title = trim($wrapArr[0] ?? '') . $title . trim($wrapArr[1] ?? '');
                }

                $placeholderContent = $title . $placeholderContent;
            }

            if (!empty($placeholderContentSetup['allWrap'])) {
                $wrapArr = explode('|', $placeholderContentSetup['allWrap']);
                $placeholderContent = trim($wrapArr[0] ?? '') . $placeholderContent . trim($wrapArr[1] ?? '');
            }

            $placeholderContent = '<div class="media2click-placeholder' . ($hasPreview ? ' media2click-haspreview' : '') . '" style="' . $style . '">' . $placeholderContent . '</div>';
        }
        return $placeholderContent;
    }
}
