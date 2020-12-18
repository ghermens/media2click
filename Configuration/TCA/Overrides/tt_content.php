<?php
defined('TYPO3_MODE') || die;

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'tx_media2click_iframe_src' => [
            'exclude' => false,
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_src',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'eval' => 'trim,required',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkFields' => 'class,params,target,title',
                            'blindLinkOptions' => 'file,folder,mail,page,spec',
                        ],
                    ],
                ],
            ],
        ],
        'tx_media2click_iframe_ratio' => [
            'exclude' => false,
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_ratio',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['16:9', '169'],
                    ['3:2','32'],
                    ['4:3', '43'],
                    ['LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_ratio.50vh', '50vh'],
                    ['LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_ratio.75vh', '75vh'],
                    ['LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_ratio.90vh', '90vh'],
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
            ]
        ]
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:media2click_iframe',
        'media2click_iframe',
        'tx-media2click-ce-iframe'
    ],
    'div',
    'after'
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['media2click_iframe'] = 'tx-media2click-ce-iframe';

$GLOBALS['TCA']['tt_content']['types']['media2click_iframe'] = [
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
        --div--;iFrame,
            tx_media2click_iframe_src,
            tx_media2click_iframe_ratio,
            image;LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.image,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
    'columnsOverrides' => [
        'image' => [
            'config' => [
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'maxitems' => 1,
                'overrideChildTca' => [
                    'types' => [
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '--palette--;;imageMinimalOverlayPalette,--palette--;;filePalette',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
