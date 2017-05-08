<?php
/**
 * @package TYPO3
 * @subpackage tx_mkabtesting
 * @author Hannes Bochmann <dev@dmk-ebusiness.de>
 *
 *  Copyright notice
 *
 *  (c) 2013 Hannes Bochmann <dev@dmk-ebusiness.de>
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
 */

tx_rnbase::load('tx_mklib_repository_Abstract');

/**
 * Tx_Mkabtesting_Repository_RenderedContentElements
 *
 * @package TYPO3
 * @subpackage tx_mkabtesting
 */
class Tx_Mkabtesting_Repository_RenderedContentElements
    extends tx_mklib_repository_Abstract
{

    /**
     * (non-PHPdoc)
     * @see tx_mklib_repository_Abstract::getSearchClass()
     */
    protected function getSearchClass()
    {
        return 'Tx_Mkabtesting_Search_RenderedContentElements';
    }

    /**
     * @param int $elementUid
     * @param string $campaignIdentifier
     *
     * @return array
     */
    public function countByElementUidAndCampaignIdentifier($elementUid, $campaignIdentifier)
    {
        $fields = array(
            'CONTENTELEMENT.content_element' => array(OP_EQ_INT => $elementUid),
            'CONTENTELEMENT.campaign_identifier' => array(OP_EQ => $campaignIdentifier),
        );

        $options = array(
            'count' => true
        );

        return $this->search($fields, $options);
    }
}
