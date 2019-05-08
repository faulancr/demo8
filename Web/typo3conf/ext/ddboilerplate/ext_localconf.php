<?php

defined('TYPO3_MODE') or die();

if (defined('TYPO3_MODE')) {
    // Extkey fallback
    if (!isset($_EXTKEY)) {
        $_EXTKEY = 'ddboilerplate';
    }
    call_user_func(
        function ($extKey) {
            // angeben der Dateien für PageTSconfig
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
                '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $extKey . '/Configuration/PageTS/PageTS.Basic.typoscript">
                <INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $extKey . '/Configuration/PageTS/Mod/Wizards.typoscript">
                <INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $extKey . '/Configuration/PageTS/Mod/WebLayout.typoscript">'
            );
        },
        $_EXTKEY
    );

    /**
     * Register icons
     *
     * @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry
     */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

    /**
     * Registers an icon to be available inside the Icon Factory
     *
     * @param string $identifier
     * @param string $iconProviderClassName
     * @param array $options
     */
    $iconRegistry->registerIcon(
        'BoilerplateIcon',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Images/Backend/BoilerplateIcon.svg']
    );

    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['myConfig'] = 'EXT:ddboilerplate/Configuration/RTE/MyConfig.yaml';
}
