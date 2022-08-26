<?php
$EM_CONF[$_EXTKEY] = [
    'title' => '2 Clicks for External Media',
    'description' => 'Render external content like videos and iframes with privacy in mind: User has to click on placeholder to load the actual content.',
    'author' => 'Gregor Hermens',
    'author_email' => 'gregor.hermens@a-mazing.de',
    'author_company' => '@mazing',
    'category' => 'fe',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '10.4.0-11.5.99',
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
    'state' => 'stable',
    'version' => '3.0.1',
];
