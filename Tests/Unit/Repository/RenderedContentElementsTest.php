<?php
/**
 * 	@package TYPO3
 *  @subpackage tx_mkabtesting
 *  @author Hannes Bochmann <dev@dmk-ebusiness.de>
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
tx_rnbase::load('Tx_Mkabtesting_Repository_RenderedContentElements');

/**
 * @package TYPO3
 * @subpackage tx_mkabtesting
 * @author Hannes Bochmann <dev@dmk-ebusiness.de>
 */
class Tx_Mkabtesting_Repository_RenderedContentElementsTest
	extends tx_rnbase_tests_BaseTestCase
{

	/**
	 * @group unit
	 */
	public function testGetSearchClass() {
		$this->assertEquals(
			'Tx_Mkabtesting_Search_RenderedContentElements',
			$this->callInaccessibleMethod(
				tx_rnbase::makeInstance('Tx_Mkabtesting_Repository_RenderedContentElements'),
				'getSearchClass'
			),
			'falscher Klassenname'
		);
	}

	/**
	 * @group unit
	 */
	public function testCountByElementUidAndCampaignIdentifier() {
		$repository = $this->getMock(
			'Tx_Mkabtesting_Repository_RenderedContentElements', array('search')
		);

		$expectedFields = array(
			'CONTENTELEMENT.content_element' => array(OP_EQ_INT => 123),
			'CONTENTELEMENT.campaign_identifier' => array(OP_EQ => 456),
		);

		$expectedOptions = array(
			'count' => TRUE
		);

		$repository->expects($this->once())
			->method('search')
			->with($expectedFields, $expectedOptions);

		$repository->countByElementUidAndCampaignIdentifier(123, 456);
	}
}