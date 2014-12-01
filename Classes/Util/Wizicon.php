<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009-2012 DMK E-Business GmbH
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
tx_rnbase::load('tx_rnbase_util_TYPO3');

/**
 * @author Hannes Bochmann <hannes.bochmann@dmk-business.de>
 */
class Tx_Mkabtesting_Util_Wizicon {

	/**
	 * Adds the plugin wizard icon
	 *
	 * @param array Input array with wizard items for plugins
	 * @return array Modified input array, having the items for plugin added.
	 */
	public function proc($wizardItems)	{
		global $LANG;

		$LL = $this->includeLocalLang();

		$wizardItems['plugins_tx_mkabtesting'] = array(
			'icon'=>t3lib_extMgm::extRelPath('mkabtesting').'/ext_icon.gif',
			'title'=>$LANG->getLLL('plugin.mkabtesting.label',$LL),
			'description'=>$LANG->getLLL('plugin.mkabtesting.description',$LL),
			'params'=>'&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=tx_mkabtesting'
		);

		return $wizardItems;
	}

	/**
	 *
	 * @return Ambigous <multitype:, string, multitype:unknown string , multitype:multitype: NULL Ambigous <string, NULL> Ambigous <unknown, string, Ambigous <NULL, Ambigous <string, NULL>, multitype:>> >
	 */
	protected function includeLocalLang()	{
		$llFile = t3lib_extMgm::extPath('mkabtesting') . '/Resources/Private/Language/flexform.xml';
		if (tx_rnbase_util_TYPO3::isTYPO46OrHigher()) {
			$llXmlParser = tx_rnbase::makeInstance('t3lib_l10n_parser_Llxml');
			$LOCAL_LANG =  $llXmlParser->getParsedData($llFile, $GLOBALS['LANG']->lang);
		}
		else {
			$LOCAL_LANG = t3lib_div::readLLXMLfile($llFile, $GLOBALS['LANG']->lang);
		}

		return $LOCAL_LANG;
	}
}