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

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class VimeoRenderer extends \TYPO3\CMS\Core\Resource\Rendering\VimeoRenderer
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

        if(!$options['additionalConfig']['enable2click']) {
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

        $placeholderContentObject = $options['additionalConfig']['placeholderContent'];

        $style = '';
        if ((int)$width > 0) {
            $style .= 'width: ' . (int)$width . 'px;';
        }

        if ((int)$height > 0) {
            $style .= 'height: ' . (int)$height . 'px;';
        }

        $hasPreview = false;
        if (!empty($placeholderContentObject['showPreviewImage'])) {
            if ($file instanceof FileReference) {
                $orgFile = $file->getOriginalFile();
            } else {
                $orgFile = $file;
            }

            $previewImage = $this->onlineMediaHelper->getPreviewImage($orgFile);

            if (file_exists($previewImage)) {
                $conf = [
                    'file' => $previewImage,
                    'file.' => [
                        'maxW' => ($placeholderContentObject['previewMaxWidth'] ?? ''),
                        'maxH' => ($placeholderContentObject['previewMaxHeight'] ?? ''),
                    ],
                    'stdWrap.' => [
                        'wrap' => 'background-image: url(/|);'
                    ]
                ];

                if ((int)$width > 0) {
                    $conf['file.']['width'] = (int)$width . 'c';
                }

                if ((int)$height > 0) {
                    $conf['file.']['height'] = (int)$height . 'c';
                }

                $style .= $contentObjectRenderer->cObjGetSingle('IMG_RESOURCE', $conf);
                $hasPreview = true;
            }
        }

        $placeholderContent = null;

        if (is_array($placeholderContentObject)) {
            if (version_compare(TYPO3_version, '9.0.0', '>=')) {

                if (isset($placeholderContentObject['value'])) {
                    $placeholderContent = $placeholderContentObject['value'];
                }

                if (is_array($placeholderContentObject['lang'])) {
                    $typo3Language = $contentObjectRenderer->cObjGetSingle('TEXT', ['data' => 'siteLanguage:typo3Language']);

                    if (array_key_exists($typo3Language, $placeholderContentObject['lang'])) {
                        $placeholderContent = $placeholderContentObject['lang'][$typo3Language];
                    }
                }

                if (!empty($placeholderContentObject['wrap'])) {
                    $wrapArr = explode('|', $placeholderContentObject['wrap']);
                    $placeholderContent = trim($wrapArr[0] ?? '') . $placeholderContent . trim($wrapArr[1] ?? '');
                }

            } else {

                if (is_array($placeholderContentObject['lang'])) {
                    $placeholderContentObject['lang.'] = $placeholderContentObject['lang'];
                    unset($placeholderContentObject['lang']);
                }

                $placeholderContent = $contentObjectRenderer->cObjGetSingle('TEXT', $placeholderContentObject);
            }
        }

        if ($placeholderContent === null) {
            $placeholderContent = 'Click to load external video!';
        }

        if (!empty($options['title']) && !empty($placeholderContentObject['showTitle'])) {
            $title = $options['title'];

            if (!empty($placeholderContentObject['titleWrap'])) {
                $wrapArr = explode('|', $placeholderContentObject['titleWrap']);
                $title = trim($wrapArr[0] ?? '') . $title . trim($wrapArr[1] ?? '');
            }

            $placeholderContent = $title . $placeholderContent;
        }

        if (!empty($placeholderContentObject['allWrap'])) {
            $wrapArr = explode('|', $placeholderContentObject['allWrap']);
            $placeholderContent = trim($wrapArr[0] ?? '') . $placeholderContent . trim($wrapArr[1] ?? '');
        }

        $placeholderContent = '<div class="media2click-placeholder' . ($hasPreview ? ' media2click-haspreview':'') . '" style="' . $style . '">' . $placeholderContent . '</div>';

        return $placeholderContent;
    }
}
