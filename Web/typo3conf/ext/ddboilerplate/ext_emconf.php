<?php

//#######################################################################
// Extension Manager/Repository config file for ext "in2template".
//#######################################################################

$EM_CONF[$_EXTKEY] = [
    'title' => 'ddboilerplate',
    'description' => 'This extension contains the default configuration for the layout',
    'category' => 'misc',
    'author' => 'Dirk Doering',
    'author_email' => 'hello@dirkdoering.de',
    'state' => 'stable',
    'author_company' => 'Dirk Doering',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.0.0-8.99.99',
            'php' => '5.6.0-7.99.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
