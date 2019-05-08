<?php
if (defined('TYPO3_MODE')) {
    // Extkey fallback
    if (!isset($_EXTKEY)) {
        $_EXTKEY = 'ddboilerplate';
    }
    call_user_func(
        function ($extKey) {
            $extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey);

            // Add static TS-Files
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $extKey,
                'Configuration/TypoScript',
                'Dirk Döring Boilerplate'
            );

            // Add static page TS config
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
                '<INCLUDE_TYPOSCRIPT: source="FILE: EXT:ddboilerplate/Configuration/PageTS/PageTS.Basic.typoscript">'
            );

            // Include BackendLayouts
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
                '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ddboilerplate/Configuration/PageTS/Mod/Mod.typoscript">'
            );

            // Configure Backend Logos and styles
            if (!isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]['Logo'])
                || empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]['Logo'])
            ) {
                $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]['Logo'] = $extRelPath . 'Resources/Public/Images/Backend/logo_dd.svg';
            }
            $GLOBALS['TBE_STYLES']['logo'] = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]['Logo'];

            if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
                $extConfBackend = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);

                $extConfBackend['loginLogo'] = $extRelPath . 'Resources/Public/Images/Backend/logo_dd.svg';
                $extConfBackend['loginHighlightColor'] = '#e3000b';
                $extConfBackend['backendLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/logo_dd.svg';
                $extConfBackend['loginBackgroundImage'] = $extRelPath . 'Resources/Public/Images/Backend/backend_login_background.jpg';

                $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize($extConfBackend);
            }
        },
        $_EXTKEY
    );
}
