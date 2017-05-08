<?php
/**
 * @package TYPO3
 * @subpackage tx_abtesting
 * @author Hannes Bochmann
 *
 *  Copyright notice
 *
 *  (c) 2012 Hannes Bochmann <dev@dmk-ebusiness.de>
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

tx_rnbase::load('tx_rnbase_util_SearchBase');

/**
 * Tx_Mkabtesting_Search_RenderedContentElements
 *
 * @package TYPO3
 * @subpackage tx_mkabtesting
 */
class Tx_Mkabtesting_Search_RenderedContentElements extends tx_rnbase_util_SearchBase
{

    /**
     * getTableMappings()
     */
    protected function getTableMappings()
    {
        $tableMapping[$this->getBaseTableAlias()] = $this->getBaseTable();

        return $tableMapping;
    }

    /**
     * useAlias()
     */
    protected function useAlias()
    {
        return true;
    }

    /**
     * getBaseTableAlias()
     */
    protected function getBaseTableAlias()
    {
        return 'CONTENTELEMENT';
    }

    /**
     * getBaseTable()
     */
    protected function getBaseTable()
    {
        return 'tx_mkabtesting_rendered_content_elements';
    }

    /**
     * getWrapperClass()
     */
    public function getWrapperClass()
    {
        return 'Tx_Mkabtesting_Model_RenderedContentElement';
    }

    /**
     * Liefert alle JOINS zurück
     *
     * @param array $tableAliases
     * @return string
     */
    protected function getJoins($tableAliases)
    {
        $join = '';

        return $join;
    }
}
