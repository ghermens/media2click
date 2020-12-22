<?php
defined('TYPO3_MODE') || die;

(function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'media2click',
        'List',
        'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:plugin.list'
    );
})();
