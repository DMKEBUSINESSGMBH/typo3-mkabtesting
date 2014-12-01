<?php
/**
 * Extension Manager/Repository config file for ext "mkabtesting".
 */

$EM_CONF[$_EXTKEY] = array(
	'title' => 'MK A/B Testing',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Hannes Bochmann',
	'author_company' => 'DMK E-BUSINESS GmbH',
	'author_email' => 'dev@dmk-ebusiness.de',
	'shy' => '',
	'dependencies' => 'rn_base,mklib',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'rn_base' => '',
			'mklib' => '',
			'typo3' => '4.5.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>