<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mkabtesting".
 *
 * Auto generated 06-01-2015 15:06
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

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
	'version' => '1.0.2',
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
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:30:{s:12:"ext_icon.gif";s:4:"8e4d";s:14:"ext_tables.php";s:4:"f632";s:14:"ext_tables.sql";s:4:"4f2b";s:38:"Classes/Action/ShowContentElements.php";s:4:"6279";s:40:"Classes/Model/RenderedContentElement.php";s:4:"b732";s:46:"Classes/Repository/RenderedContentElements.php";s:4:"2da7";s:42:"Classes/Search/RenderedContentElements.php";s:4:"ec6d";s:24:"Classes/Util/Wizicon.php";s:4:"425d";s:34:"Configuration/Flexform/actions.xml";s:4:"5383";s:32:"Configuration/TCA/ext_tables.php";s:4:"dd38";s:62:"Configuration/TCA/tx_mkabtesting_rendered_content_elements.php";s:4:"b5a6";s:34:"Configuration/TypoScript/setup.txt";s:4:"fd99";s:26:"Documentation/Includes.txt";s:4:"ef74";s:23:"Documentation/Index.rst";s:4:"af93";s:26:"Documentation/Settings.yml";s:4:"336d";s:33:"Documentation/ChangeLog/Index.rst";s:4:"8b13";s:31:"Documentation/Images/Plugin.png";s:4:"cee3";s:36:"Documentation/Introduction/Index.rst";s:4:"cd0f";s:35:"Documentation/UsersManual/Index.rst";s:4:"90d2";s:33:"Resources/Private/Build/phpcs.xml";s:4:"4a12";s:33:"Resources/Private/Build/phpmd.xml";s:4:"38b3";s:38:"Resources/Private/Language/actions.xml";s:4:"e52d";s:39:"Resources/Private/Language/flexform.xml";s:4:"c817";s:34:"Resources/Private/Language/tca.xml";s:4:"fcd5";s:57:"Resources/Private/Templates/Html/showContentElements.html";s:4:"cc78";s:40:"Resources/Public/Img/Icons/tca_table.gif";s:4:"475a";s:17:"Tests/phpunit.xml";s:4:"4e02";s:46:"Tests/Unit/Actions/ShowContentElementsTest.php";s:4:"7d60";s:53:"Tests/Unit/Repository/RenderedContentElementsTest.php";s:4:"a748";s:49:"Tests/Unit/Search/RenderedContentElementsTest.php";s:4:"d769";}',
);

?>