<?php

namespace Amazing\Media2click\Hooks;

use TYPO3\CMS\Backend\View\PageLayoutView;

class UsedRecords
{
    /**
     * @param array                                  $params
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $pageLayoutView
     * @return bool
     */
    public function addMedia2clickContent(array $params, PageLayoutView $pageLayoutView): bool
    {
        $record = $params['record'];

        if ($record['tx_media2click_parentid'] > 0) {
            if ($record['colPos'] === 1962587) {
                return true;
            }
        }
        return $params['used'];
    }
}
