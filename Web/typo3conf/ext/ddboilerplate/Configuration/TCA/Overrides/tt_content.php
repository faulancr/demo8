<?php
defined('TYPO3_MODE') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function () {
    $languageFilePrefix = 'LLL:EXT:ddboilerplate/Resources/Private/Language/backend.xlf:';
    $frontendLanguageFilePrefix = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';

    $GLOBALS['TCA']['tt_content']['types']['textmedia']['columnsOverrides']['assets']['config']['overrideChildTca']['columns']['crop']['config'] = [
        'cropVariants' => [
            'desktop' => [
                'title' => 'Hero',
                'allowedAspectRatios' => [
                    '16:9' => [
                        'title' => '1600:900',
                        'value' => 1600 / 900
                    ]
                ],
            ],
            'landscape' => [
                'title' => 'Landscape mit Cover Areas',
                'allowedAspectRatios' => [
                    '1400:800' => [
                        'title' => '1400:800',
                        'value' => 1400 / 800
                    ]
                ],
                'coverAreas' => [
                    [
                        'x' => 0,
                        'y' => 0,
                        'width' => 1,
                        'height' => 0.1,
                    ],
                    [
                        'x' => 0,
                        'y' => 0.9,
                        'width' => 1,
                        'height' => 0.1,
                    ]
                ],
            ],
            'tablet' => [
                'title' => 'Tablet',
                'allowedAspectRatios' => [
                    '600:600' => [
                        'title' => '1 : 1',
                        'value' => 1 / 1
                    ]
                ]
            ],
            'mobile' => [
                'title' => 'mobile',
                'allowedAspectRatios' => [
                    '3:4' => [
                        'title' => '3:42',
                        'value' => 300 / 400
                    ]
                ]
            ],
            'hero_focus' => [
                'title' => 'Hero Focus goldener Schnitt',
                'allowedAspectRatios' => [
                    '16:9' => [
                        'title' => '1600:900',
                        'value' => 1600 / 900
                    ],
                    '1:1' => [
                        'title' => '1:1',
                        'value' => 1 / 1
                    ]
                ],
                'coverAreas' => [
                    [
                        'x' => 1 / 4,
                        'y' => 0,
                        'width' => 1 / 4,
                        'height' => 1,
                    ]
                ],
                'focusArea' => [
                    [
                        'x' => 1 / 2,
                        'y' => 0,
                        'width' => 400,
                        'height' => 200,
                    ],
                    [
                        'x' => 3 / 4,
                        'y' => 0,
                        'width' => 400,
                        'height' => 200,
                    ]
                ]
            ]
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            $languageFilePrefix . 'content.div',
            '--div--'
        ]
    );

//    $GLOBALS['TCA']['tt_content'] = array_replace_recursive($GLOBALS['TCA']['tt_content'], $tca);
});
