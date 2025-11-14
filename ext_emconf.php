<?php

$EM_CONF['twoh_base'] = array(
    'title' => 'TWOH Page Setup',
    'description' => 'This extension allows you to move the TYPO3 context into separate files instead of working with the AdditionalConfiguration.php.',
    'category' => 'plugin',
    'author' => 'Andreas Reichel, Igor Smertin',
    'author_email' => 'a.reichel91@outlook.com, igor.smertin@web.de',
    'author_company' => 'TWOH digital',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '1.0.1',
    'constraints' => array(
        'depends' => array(
            'typo3' => '12.4.99',
            'php' => '8.0-8.3',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
