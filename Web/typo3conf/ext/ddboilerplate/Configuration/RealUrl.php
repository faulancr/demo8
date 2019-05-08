<?php
call_user_func(
    function () {
        $rootlinefields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];

        if ($rootlinefields != '') {
            $rootlinefields .= ' , ';
        }

        $rootlinefields .= 'tx_realurl_pathsegment,tx_realurl_exclude,tx_realurl_pathoverride,alias,nav_title,title';

        $defaultRealurlConfiguration = [
            'init' => [
                'adminJumpToBackend' => true,
                'appendMissingSlash' => 'ifNotFile,redirect[301]',
                'emptyUrlReturnValue' => '/',
                'enableAllUnicodeLetters' => false,
                // 'enableAllUnicodeLetters' => true,
                'enableCHashCache' => true,
                'enableUrlDecodeCache' => true,
                'enableUrlEncodeCache' => true,
                'reapplyAbsRefPrefix' => true,
                'respectSimulateStaticURLs' => false,
                'postVarSet_failureMode' => 'ignore',
            ],
            'fileName' => [
                'defaultToHTMLsuffixOnPrev' => false,
                'acceptHTMLsuffix' => true,
                'index' => [
                    'text' => [
                        'keyValues' => [
                            'type' => 99,
                        ],
                    ],
                    'print' => [
                        'keyValues' => [
                            'type' => 98,
                        ],
                    ],
                    'rss' => [
                        'keyValues' => [
                            'type' => 100,
                        ],
                    ],
                    'rss.xml' => [
                        'keyValues' => [
                            'type' => 100,
                        ],
                    ],
                    'rss091.xml' => [
                        'keyValues' => [
                            'type' => 101,
                        ],
                    ],
                    'rdf.xml' => [
                        'keyValues' => [
                            'type' => 102,
                        ],
                    ],
                    'atom.xml' => [
                        'keyValues' => [
                            'type' => 103,
                        ],
                    ],
                    'sitemap.xml' => [
                        'keyValues' => [
                            'type' => 841132,
                        ],
                    ],
                    'sitemap.txt' => [
                        'keyValues' => [
                            'type' => 841131,
                        ],
                    ],
                    'robots.txt' => [
                        'keyValues' => [
                            'type' => 841133,
                        ],
                    ],
                ],
            ],
            'pagePath' => [
                'type' => 'user',
                'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
                'spaceCharacter' => '-',
                'languageGetVar' => 'L',
                'expireDays' => 365,
                'rootpage_id' => 1,
            ],
            'preVars' => [
                [
                    'GETvar' => 'no_cache',
                    'valueMap' => [
                        'nc' => 1,
                    ],
                    'noMatch' => 'bypass',
                ],
                [
                    'GETvar' => 'L',
                    'valueMap' => [
                        'de' => '0',
                        'en' => '1',
                        // 'zh' => '15',
                        // 'pl' => '16',
                        // 'kr' => '17',
                    ],
                    'noMatch' => 'bypass',
                ],
            ],
            // Konfiguration vieler Extensions entfernt
            // in älterer Version von in2template sind folgende noch mit drin:
            // newloginbox, srfeuserregister, simplecal, advanced calender, cforum, nrdfimport, t3consultancies, gsislideshow
            // ednewscomments, atolflashpdfviewer

            'postVarSets' => [
                '_DEFAULT' => [
                    // news archive parameters
                    'news' => [
                        [
                            'GETvar' => 'tx_news_pi1[controller]',
                        ],
                        [
                            'GETvar' => 'tx_news_pi1[action]',
                        ],
                        [
                            'GETvar' => 'tx_news_pi1[news]',
                            'lookUpTable' => [
                                'table' => 'tx_news_domain_model_news',
                                'id_field' => 'uid',
                                'alias_field' => 'title',
                                'addWhereClause' => ' AND NOT deleted',
                                'useUniqueCache' => 1,
                                'autoUpdate' => 1,
                                'useUniqueCache_conf' => [
                                    'strtolower' => 1,
                                    'spaceCharacter' => '-'
                                ]
                            ]
                        ]
                    ],
                    'forgot' => [
                        [
                            'GETvar' => 'tx_felogin_pi1[forgot]'
                        ]
                    ],
                    'query' => [
                        [
                            'GETvar' => 'tx_indexedsearch[sword]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[ext]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[submit_button]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[_sections]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[pointer]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[extResume]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[type]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[group]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[_freeIndexUid]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[media]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[defOp]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[ang]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[desc]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[results]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[sections]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[lang]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[order]'
                        ],
                        [
                            'GETvar' => 'tx_indexedsearch[freeIndexUid]'
                        ]
                    ],
                    'view' => [
                        [
                            'GETvar' => 'view'
                        ]
                    ]
                ]
            ],
            'redirects_regex' => [],
        ];

        /**
         * Set rootpage ids depending on domains, subdomains, ports or something else
         *      key: part of domain (subdomain, domain, top level domain, port
         *      value: rootpage id
         *
         *      e.g. subdomain overrules domain settings:
         *          subdomain => 123
         *          domain => 234
         *
         *      Use individual key for individual domains
         */
        $domainConfiguration = [
            //    'domains' => [
            //        'domain.com' => 1,
            //        'domain.de' => 2,
            //    ],
            //    'subDomains' => [
            //        'at.' => 11,
            //        'cn.' => 21,
            //    ],
            //    'subSubDomains' => [
            //        'stage.' => 200,
            //        'develop.' => 100,
            //        'www.',
            //        'local.',
            //    ],
            //    'ports' => [
            //        '',
            //        ':8051'
            //    ],
            'individual' => [
                'www.domain.org' => 123,
            ]
        ];

        \In2code\In2template\Utility\RealUrlUtility::recursiveSetDomainRootPid(
            $domainConfiguration,
            $defaultRealurlConfiguration
        );

        // following not needed for simpler sites

        // Domain-Konfiguration - die Erste
        // Was macht _DOMAINS?

        // Domains setzt die URL und die realURL-Konfiguration in Abhängigkeit des Sprachparameters "L", bzw. der Domain, die ankommt.
        // Bsp. als Doku drin gelassen ...

        // _DOMAINS configuration conflicts with rlmp_languagedetect

        /* if ( false ) {
        $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DOMAINS'] = array(
            'encode' => array(
                array(
                    'GETvar' => 'L',
                    'value' => '0', // de
                    'useConfiguration' => $_SERVER['HTTP_HOST'],
                    'urlPrepend' => 'http://' . $_SERVER['HTTP_HOST'],
                ),
                array(
                    'GETvar' => 'L',
                    'value' => '1', // en
                    'useConfiguration' => 'www.example.com',
                    'urlPrepend' => 'http://www.example.com'
                ),
            ),
            'decode' => array(
                $_SERVER['HTTP_HOST'] => array(
                    'GETvars' => array(
                        'L' => '0',
                    ),
                    'useConfiguration' => $_SERVER['HTTP_HOST']
                ),
                'www.example.de' => array(
                    'GETvars' => array(
                        'L' => '1',
                    ),
                    'useConfiguration' => 'www.example.com'
                ),
            )
        );
        }
        */
    }
);
