<?php

$EM_CONF['twoh_base'] = [
    'title' => 'TWOH Page Setup',
    'description' => 'This extension allows you to move the TYPO3 context into separate files instead of working with the AdditionalConfiguration.php.',
    'category' => 'plugin',
    'author' => 'Andreas Reichel, Igor Smertin',
    'author_email' => 'a.reichel91@outlook.com, igor.smertin@web.de',
    'author_company' => 'TWOH digital',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'php' => '8.2.0-8.3.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
