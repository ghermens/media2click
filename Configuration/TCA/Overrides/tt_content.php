<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die;

ExtensionManagementUtility::addTCAcolumns(
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
                'eval' => 'trim,Amazing\\Media2click\\Evaluation\\UrlSchemeEvaluation,required',
                'softref' => 'typolink',
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
                    ['21:9', '219'],
                    ['16:9', '169'],
                    ['3:2','32'],
                    ['4:3', '43'],
                    ['LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_ratio.50vh', '50vh'],
                    ['LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_ratio.75vh', '75vh'],
                    ['LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_iframe_ratio.90vh', '90vh'],
                ],
                'default' => '169',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'tx_media2click_content' => [
            'exclude' => false,
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_content',
            'config' => [
                'type' => 'none',
                'default' => '0',
            ]
        ],

                /*
                'tx_media2click_content' => [
                    'exclude' => false,
                    'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_content',
                    'config' => [
                        'type' => 'inline',
                        'allowed' => 'tt_content',
                        'foreign_table' => 'tt_content',
                        'foreign_field' => 'tx_media2click_parentid',
                        'foreign_sortby' => 'sorting',
                        'foreign_match_fields' => [
                            'colPos' => '1962587',
                        ],
                        'appearance' => [
                            'collapseAll' => true,
                            'expandSingle' => true,
                            'newRecordLinkAddTitle' => true,
                            'levelLinksPosition' => 'both',
                            'useSortable' => true,
                            'showPossibleLocalizationRecords' => true,
                            'showAllLocalizationLink' => true,
                            'showSynchronizationLink' => true,
                            'enabledControls' => [
                                'info' => false,
                                'new' => true,
                                'dragdrop' => true,
                                'sort' => true,
                                'hide' => true,
                                'delete' => true,
                                'localize' => true,
                            ],
                        ],
                        'behaviour' => [
                            'allowLanguageSynchronization' => true,
                        ],
                        'overrideChildTca' => [
                            'columns' => [
                                'colPos' => [
                                    'config' => [
                                        'type' => 'none',
                                        'renderType' => '',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                */
        'tx_media2click_host' => [
            'exclude' => false,
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_host',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_media2click_domain_model_host',
                'foreign_table_where' => 'AND {#tx_media2click_domain_model_host}.{#sys_language_uid} IN(-1,0) ORDER BY title',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'default' => 0,
            ],
        ],
    ]
);

// iFrame CE
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:media2click_iframe',
        'media2click_iframe',
        'tx-media2click-ce-iframe',
        'special',
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

// Content CE
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:media2click_content',
        'media2click_content',
        'tx-media2click-ce-content',
        'special',
    ],
    'media2click_iframe',
    'after'
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['media2click_content'] = 'tx-media2click-ce-content';

$GLOBALS['TCA']['tt_content']['types']['media2click_content'] = [
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
        --div--;LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tab.content,
            tx_media2click_content,
            tx_media2click_iframe_ratio,
            image;LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.image,
            tx_media2click_host,
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
        'tx_media2click_content' => [
            'exclude' => false,
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tt_content.tx_media2click_content',
            'config' => [
                'type' => 'inline',
                'allowed' => 'tt_content',
                'foreign_table' => 'tt_content',
                'foreign_field' => 'tx_media2click_parentid',
                'foreign_sortby' => 'sorting',
                'foreign_match_fields' => [
                    'colPos' => '1962587',
                ],
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'newRecordLinkAddTitle' => true,
                    'levelLinksPosition' => 'both',
                    'useSortable' => true,
                    'showPossibleLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                    'enabledControls' => [
                        'info' => false,
                        'new' => true,
                        'dragdrop' => true,
                        'sort' => true,
                        'hide' => true,
                        'delete' => true,
                        'localize' => true,
                    ],
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'overrideChildTca' => [
                    'columns' => [
                        'colPos' => [
                            'config' => [
                                'type' => 'none',
                                'renderType' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ],
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


// List plugin
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['media2click_list'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['media2click_list'] = 'pages,recursive';
ExtensionManagementUtility::addPiFlexFormValue(
    'media2click_list',
    'FILE:EXT:media2click/Configuration/FlexForms/PluginList.xml'
);

ExtensionUtility::registerPlugin(
    'media2click',
    'List',
    'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:plugin.list'
);
