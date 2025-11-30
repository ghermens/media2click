<?php

declare(strict_types=1);

namespace Amazing\Media2click\EventListener;

use TYPO3\CMS\Backend\View\Event\IsContentUsedOnPageLayoutEvent;

final class IsContentUsedListener
{
    public function __invoke(IsContentUsedOnPageLayoutEvent $event): void
    {
        $record = $event->getRecord();
        if ($record['tx_media2click_parentid'] > 0 && $record['colPos'] === 1962587) {
            $event->setUsed(true);
        }
    }
}
