<?php
return [
    'ctrl' => [
        'label' => 'title',
        'label_alt' => 'host',
        'label_alt_force' => true,
        'title' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tx_media2click_domain_model_host',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime'
        ],
        'iconfile' => 'EXT:media2click/Resources/Public/Icons/Extension.svg',
        'languageField' => 'sys_language_uid',
        'searchFields' => 'title,host,placeholder',
        'sortby' => 'sorting',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'transOrigPointerField' => 'l10n_parent',
        'tstamp' => 'tstamp',
    ],
    'interface' => [
        'showRecordFieldList' => 'title,host,placeholder,privacy_statement_link,hidden,starttime,endtime',
    ],
    'types' => [
        0 => [
            'showitem' => '
                title,host,privacy_statement_link,placeholder,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;;access
            ',
        ],
    ],
    'palettes' => [
        'access' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
            'showitem' => 'starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel, endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
        ],
        'hidden' => [
            'showitem' => ' hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden',
        ],
    ],
    'columns' => [
        'endtime' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'exclude' => true,
            'l10n_display' => 'defaultAsReadonly',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
            ],
        ],
        'starttime' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'exclude' => true,
            'l10n_display' => 'defaultAsReadonly',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
            ]
        ],
        'hidden' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    0 => [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ]
                ]
            ]
        ],

        'title' => [
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tx_media2click_domain_model_host.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'host' => [
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tx_media2click_domain_model_host.host',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,nospace,required'
            ],
        ],
        'placeholder' => [
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tx_media2click_domain_model_host.placeholder',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'eval' => 'trim',
            ],
        ],
        'privacy_statement_link' => [
            'label' => 'LLL:EXT:media2click/Resources/Private/Language/locallang_db.xlf:tx_media2click_domain_model_host.privacy_statement_link',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'eval' => 'required',
                'fieldControl' => [
                    'linkPopup' => [
                        'blindLinkFields' => 'class,params,target,title',
                        'blindLinkOptions' => 'file,folder,mail,page,spec,telephone',
                    ],
                ],
            ],
        ],
    ],
];
