<?php

/**
 * alle benötigten Klassen einbinden etc.
 */
if (!defined ('TYPO3_MODE')) {
  die ('Access denied.');
}

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');

$_EXTKEY = 'mkabtesting';

// TCA
require(t3lib_extMgm::extPath($_EXTKEY).'Configuration/TCA/ext_tables.php');

// Plugin anmelden
// Einige Felder ausblenden
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_mkabtesting'] =
	'layout,select_key,pages';

// Das tt_content-Feld pi_flexform einblenden
$TCA['tt_content']['types']['list']['subtypes_addlist']['tx_mkabtesting'] = 'pi_flexform';

t3lib_extMgm::addPiFlexFormValue(
	'tx_mkabtesting','FILE:EXT:'.$_EXTKEY.'/Configuration/Flexform/actions.xml'
);
t3lib_extMgm::addPlugin(
	array(
		'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/flexform.xml:plugin.mkabtesting.label',
		'tx_mkabtesting'
	)
);
t3lib_extMgm::addStaticFile($_EXTKEY,'Configuration/TypoScript/', 'MK A/B Testing');

if (TYPO3_MODE == 'BE') {
	# Add plugin wizards
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_mkabtesting_util_wizicon'] =
		t3lib_extMgm::extPath($_EXTKEY).'Classes/Util/Wizicon.php';
}