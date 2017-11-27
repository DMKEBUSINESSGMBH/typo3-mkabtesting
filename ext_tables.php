<?php

/**
 * alle benötigten Klassen einbinden etc.
 */
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$_EXTKEY = 'mkabtesting';

// Plugin anmelden
// Einige Felder ausblenden
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_mkabtesting'] =
    'layout,select_key,pages';

// Das tt_content-Feld pi_flexform einblenden
$TCA['tt_content']['types']['list']['subtypes_addlist']['tx_mkabtesting'] = 'pi_flexform';

tx_rnbase_util_Extensions::addPiFlexFormValue(
    'tx_mkabtesting',
    'FILE:EXT:'.$_EXTKEY.'/Configuration/Flexform/actions.xml'
);
tx_rnbase_util_Extensions::addPlugin(
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/flexform.xml:plugin.mkabtesting.label',
        'tx_mkabtesting'
    )
);
tx_rnbase_util_Extensions::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'MK A/B Testing');

if (TYPO3_MODE == 'BE') {
    // Add plugin wizards
    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_mkabtesting_util_wizicon'] =
        tx_rnbase_util_Extensions::extPath($_EXTKEY).'Classes/Util/Wizicon.php';
}
