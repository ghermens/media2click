<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'tx-media2click-ce-iframe'  => [
        'provider' => SvgIconProvider::class,
        'source'   => 'EXT:media2click/Resources/Public/Icons/CeIframe.svg',
    ],
    'tx-media2click-ce-content' => [
        'provider' => SvgIconProvider::class,
        'source'   => 'EXT:media2click/Resources/Public/Icons/CeContent.svg',
    ],
    'tx-media2click-icon'       => [
        'provider' => SvgIconProvider::class,
        'source'   => 'EXT:media2click/Resources/Public/Icons/Extension.svg',
    ],
];
