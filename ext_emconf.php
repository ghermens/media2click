<?php
$EM_CONF[$_EXTKEY] = [
    'title' => '2 Clicks for External Media',
    'description' => 'Render external YouTube / Vimeo videos with privacy in mind: User has to click on placeholder to load the actual video iframe.',
    'author' => 'Gregor Hermens',
    'author_email' => 'gregor.hermens@a-mazing.de',
    'author_company' => '@mazing',
    'category' => 'fe',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '9.5.0-10.99.99',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
    'clearCacheOnLoad' => true,
    'autoload' =>
        [
            'psr-4' =>
                [
                    'Amazing\\Media2click\\' => 'Classes',
                ],
        ],
    'state' => 'beta',
    'version' => '0.3.0',
];
