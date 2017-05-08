<?php
/**
 * @package TYPO3
 * @subpackage tx_mkabtesting
 * @author Hannes Bochmann <dev@dmk-ebusiness.de>
 *
 *  Copyright notice
 *
 *  (c) 2010 Hannes Bochmann <dev@dmk-ebusiness.de>
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

tx_rnbase::load('tx_rnbase_tests_BaseTestCase');
tx_rnbase::load('Tx_Mkabtesting_Search_RenderedContentElements');

/**
 * @package TYPO3
 * @subpackage tx_mkabtesting
 * @author Hannes Bochmann <dev@dmk-ebusiness.de>
 */
class Tx_Mkabtesting_Search_RenderedContentElementsTest
    extends tx_rnbase_tests_BaseTestCase
{

    /**
     * @group unit
     */
    public function testGetTableMappings()
    {
        $this->assertEquals(
            array('CONTENTELEMENT' => 'tx_mkabtesting_rendered_content_elements'),
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('Tx_Mkabtesting_Search_RenderedContentElements'),
                'getTableMappings'
            )
        );
    }

    /**
     * @group unit
     */
    public function testUseAlias()
    {
        $this->assertTrue(
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('Tx_Mkabtesting_Search_RenderedContentElements'),
                'useAlias'
            )
        );
    }

    /**
     * @group unit
     */
    public function testGetBaseTableAlias()
    {
        $this->assertEquals(
            'CONTENTELEMENT',
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('Tx_Mkabtesting_Search_RenderedContentElements'),
                'getBaseTableAlias'
            )
        );
    }

    /**
     * @group unit
     */
    public function testGetBaseTable()
    {
        $this->assertEquals(
            'tx_mkabtesting_rendered_content_elements',
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('Tx_Mkabtesting_Search_RenderedContentElements'),
                'getBaseTable'
            )
        );
    }

    /**
     * @group unit
     */
    public function testGetWrapperClass()
    {
        $this->assertEquals(
            'Tx_Mkabtesting_Model_RenderedContentElement',
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('Tx_Mkabtesting_Search_RenderedContentElements'),
                'getWrapperClass'
            )
        );
    }

    /**
     * @group unit
     */
    public function testGetJoins()
    {
        $this->assertEquals(
            '',
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('Tx_Mkabtesting_Search_RenderedContentElements'),
                'getJoins',
                array()
            )
        );
    }
}
