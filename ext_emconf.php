<?php
$EM_CONF['media2click'] = [
    'title' => '2 Clicks for External Media',
    'description' => 'Render external YouTube / Vimeo videos with privacy in mind: User has to click on placeholder to load the actual video iframe.',
    'author' => 'Gregor Hermens',
    'author_email' => 'gregr.hermens@a-mazing.de',
    'author_company' => '@mazing',
    'category' => 'fe',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.8-9.5.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'clearCacheOnLoad' => true,
    'autoload' => [
        'psr-4' => [
            'Amazing\\Media2click\\' => 'Classes',
        ],
    ],
    'state' => 'beta',
    'version' => '0.2.1-dev',
];