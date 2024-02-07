<?php

/**
 * alle benötigten Klassen einbinden etc.
 */
if (!defined('TYPO3')) {
    die('Access denied.');
}

$_EXTKEY = 'mkabtesting';

// Plugin anmelden
// Einige Felder ausblenden
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_mkabtesting'] =
    'layout,select_key,pages';

// Das tt_content-Feld pi_flexform einblenden
$TCA['tt_content']['types']['list']['subtypes_addlist']['tx_mkabtesting'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'tx_mkabtesting',
    'FILE:EXT:'.$_EXTKEY.'/Configuration/Flexform/actions.xml'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/flexform.xml:plugin.mkabtesting.label',
        'tx_mkabtesting'
    )
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'MK A/B Testing');

// Add plugin wizards
$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_mkabtesting_util_wizicon'] =
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Classes/Util/Wizicon.php';
