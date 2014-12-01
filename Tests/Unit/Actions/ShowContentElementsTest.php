<?php
/**
 * 	@package TYPO3
 *  @subpackage tx_mkadvent
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
tx_rnbase::load('Tx_Mkabtesting_Action_ShowContentElements');
tx_rnbase::load('Tx_Mkabtesting_Repository_RenderedContentElements');

/**
 * @package TYPO3
 * @subpackage tx_mkadvent
 * @author Hannes Bochmann <dev@dmk-ebusiness.de>
 */
class Tx_Mkabtesting_Action_ShowContentElementsTest
	extends tx_rnbase_tests_BaseTestCase
{

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		if (isset($_COOKIE['AB-Testing-testCampaign'])) {
			unset($_COOKIE['AB-Testing-testCampaign']);
		}
	}

	/**
	 * @group unit
	 */
	public function testGetTemplateName() {
		$this->assertEquals(
			'showContentElements',
			$this->callInaccessibleMethod(
				tx_rnbase::makeInstance('Tx_Mkabtesting_Action_ShowContentElements'),
				'getTemplateName'
			),
			'falscher Templatename'
		);
	}

	/**
	 * @group unit
	 */
	public function testGetViewClassName() {
		$this->assertEquals(
			'tx_rnbase_view_Base',
			$this->callInaccessibleMethod(
				tx_rnbase::makeInstance('Tx_Mkabtesting_Action_ShowContentElements'),
				'getViewClassName'
			),
			'falscher Klassenname'
		);
	}

	/**
	 * @group unit
	 */
	public function testGetRenderedContentElementsRepository() {
		$this->assertInstanceOf(
			'Tx_Mkabtesting_Repository_RenderedContentElements',
			$this->callInaccessibleMethod(
				tx_rnbase::makeInstance('Tx_Mkabtesting_Action_ShowContentElements'),
				'getRenderedContentElementsRepository'
			),
			'falsche Klasse'
		);
	}

	/**
	 * @group unit
	 */
	public function testGetAllConfiguredContentElements() {
		$action = tx_rnbase::makeInstance('Tx_Mkabtesting_Action_ShowContentElements');
		$configurations = $this->createConfigurations(
			array('showContentElements.' => array('elements' => '1,2,3')), 'mkabtesting'
		);
		$action->setConfigurations($configurations);
		$this->assertEquals(
			array(1,2,3),
			$this->callInaccessibleMethod(
				$action,
				'getAllConfiguredContentElements'
			),
			'falscher IDs'
		);
	}

	/**
	 * @group unit
	 */
	public function testAssureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable() {
		$repository = $this->getMock(
			'Tx_Mkabtesting_Repository_RenderedContentElements',
			array('countByElementUidAndCampaignIdentifier', 'create')
		);
		$repository->expects($this->at(0))
			->method('countByElementUidAndCampaignIdentifier')
			->with(1, 'testCampaign')
			->will(($this->returnValue(1)));
		$repository->expects($this->at(1))
			->method('countByElementUidAndCampaignIdentifier')
			->with(2, 'testCampaign')
			->will(($this->returnValue(NULL)));
		$expectedCreationData = array(
			'campaign_identifier' => 'testCampaign',
			'content_element' => 2
		);
		$repository->expects($this->at(2))
			->method('create')
			->with($expectedCreationData);

		$action = $this->getMock(
			'Tx_Mkabtesting_Action_ShowContentElements',
			array('getRenderedContentElementsRepository')
		);
		$action->expects($this->once())
			->method('getRenderedContentElementsRepository')
			->will(($this->returnValue($repository)));

		$configurations = $this->createConfigurations(
			array('showContentElements.' => array(
				'elements' => '1,2', 'campaignIdentifier' => 'testCampaign'
			)), 'mkabtesting'
		);
		$action->setConfigurations($configurations);

		$this->callInaccessibleMethod(
			$action,
			'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable'
		);
	}

	/**
	 * @group unit
	 */
	public function testIncrementCountForRenderedContentElement() {
		$repository = $this->getMock(
			'Tx_Mkabtesting_Repository_RenderedContentElements',
			array('handleUpdate')
		);
		$elementModel = tx_rnbase::makeInstance(
			'Tx_Mkabtesting_Model_RenderedContentElement', array('uid' => 1)
		);
		$repository->expects($this->once())
			->method('handleUpdate')
			->with(
				$elementModel,
				array('render_count' => 'render_count+1'),
				'', 0, 'render_count'
			);

		$action = $this->getMock(
			'Tx_Mkabtesting_Action_ShowContentElements',
			array('getRenderedContentElementsRepository')
		);
		$action->expects($this->once())
			->method('getRenderedContentElementsRepository')
			->will($this->returnValue($repository));

		$this->callInaccessibleMethod(
			$action,
			'incrementCountForRenderedContentElement',
			$elementModel
		);
	}

	/**
	 * @group unit
	 */
	public function testGetCookieName() {
		$action = tx_rnbase::makeInstance('Tx_Mkabtesting_Action_ShowContentElements');

		$configurations = $this->createConfigurations(
			array('showContentElements.' => array(
				'campaignIdentifier' => 'testCampaign',
			)), 'mkabtesting'
		);
		$action->setConfigurations($configurations);

		$this->assertEquals(
			'AB-Testing-testCampaign',
			$this->callInaccessibleMethod($action, 'getCookieName')
		);
	}

	/**
	 * @group unit
	 */
	public function testSetElementsToBeRenderedToCookie() {
		$action = $this->getMock(
			'Tx_Mkabtesting_Action_ShowContentElements',
			array('setCookie')
		);
		$action->expects($this->once())
			->method('setCookie')
			->with('123,456', $GLOBALS['EXEC_TIME'] + 123456);

		$configurations = $this->createConfigurations(
			array('showContentElements.' => array(
				'cookieExpireTime' => 123456, 'campaignIdentifier' => 'testCampaign',
			)), 'mkabtesting'
		);
		$action->setConfigurations($configurations);

		$this->callInaccessibleMethod(
			$action,
			'setElementsToBeRenderedToCookie',
			array(123, 456)
		);
	}

	/**
	 * @group unit
	 */
	public function testGetElementsToBeRenderedIfNoCookie() {
		$repository = $this->getMock(
			'Tx_Mkabtesting_Repository_RenderedContentElements',
			array('search')
		);

		$expectedFields = array(
			'CONTENTELEMENT.content_element' => array(
				OP_IN_INT => '1,2,3,4'
			),
			'CONTENTELEMENT.campaign_identifier' => array(
				OP_EQ => 'testCampaign'
			),
		);
		$expectedOptions = array(
			'orderby' => array('CONTENTELEMENT.render_count' => 'ASC'),
			'limit' => 2
		);
		$elementModels = array(
			0 => tx_rnbase::makeInstance(
				'Tx_Mkabtesting_Model_RenderedContentElement',
				array('uid' => 1, 'content_element' => 3)
			),
			1 => tx_rnbase::makeInstance(
				'Tx_Mkabtesting_Model_RenderedContentElement',
				array('uid' => 2, 'content_element' => 4)
			),
		);
		$repository->expects($this->once())
			->method('search')
			->with($expectedFields, $expectedOptions)
			->will(($this->returnValue($elementModels)));

		$action = $this->getMock(
			'Tx_Mkabtesting_Action_ShowContentElements',
			array(
				'getRenderedContentElementsRepository',
				'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable',
				'incrementCountForRenderedContentElement',
				'setElementsToBeRenderedToCookie'
			)
		);
		$action->expects($this->once())
			->method('getRenderedContentElementsRepository')
			->will(($this->returnValue($repository)));

		$action->expects($this->once())
			->method('assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable');

		$action->expects($this->at(2))
			->method('incrementCountForRenderedContentElement')
			->with($elementModels[0]);

		$action->expects($this->at(3))
			->method('incrementCountForRenderedContentElement')
			->with($elementModels[1]);

		$action->expects($this->once())
			->method('setElementsToBeRenderedToCookie')
			->with(array(3, 4));

		$configurations = $this->createConfigurations(
			array('showContentElements.' => array(
				'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
				'numberOfElementsToDisplay' => 2
			)), 'mkabtesting'
		);
		$action->setConfigurations($configurations);

		$this->assertEquals(
			array(3, 4),
			$this->callInaccessibleMethod($action, 'getElementsToBeRendered'),
			'falsche element uids in array'
		);
	}

	/**
	 * @group unit
	 */
	public function testGetElementsToBeRenderedIfInvalidElementsInCookie() {
		$_COOKIE['AB-Testing-testCampaign'] = '1,5';
		$repository = $this->getMock(
			'Tx_Mkabtesting_Repository_RenderedContentElements',
			array('search')
		);

		$expectedFields = array(
			'CONTENTELEMENT.content_element' => array(
				OP_IN_INT => '1,2,3,4'
			),
			'CONTENTELEMENT.campaign_identifier' => array(
				OP_EQ => 'testCampaign'
			),
		);
		$expectedOptions = array(
			'orderby' => array('CONTENTELEMENT.render_count' => 'ASC'),
			'limit' => 2
		);
		$elementModels = array(
			0 => tx_rnbase::makeInstance(
				'Tx_Mkabtesting_Model_RenderedContentElement',
				array('uid' => 1, 'content_element' => 3)
			),
			1 => tx_rnbase::makeInstance(
				'Tx_Mkabtesting_Model_RenderedContentElement',
				array('uid' => 2, 'content_element' => 4)
			),
		);
		$repository->expects($this->once())
			->method('search')
			->with($expectedFields, $expectedOptions)
			->will(($this->returnValue($elementModels)));

		$action = $this->getMock(
			'Tx_Mkabtesting_Action_ShowContentElements',
			array(
				'getRenderedContentElementsRepository',
				'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable',
				'incrementCountForRenderedContentElement',
				'setElementsToBeRenderedToCookie'
			)
		);
		$action->expects($this->once())
			->method('getRenderedContentElementsRepository')
			->will(($this->returnValue($repository)));

		$action->expects($this->once())
			->method('assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable');

		$action->expects($this->at(2))
			->method('incrementCountForRenderedContentElement')
			->with($elementModels[0]);

		$action->expects($this->at(3))
			->method('incrementCountForRenderedContentElement')
			->with($elementModels[1]);

		$action->expects($this->once())
			->method('setElementsToBeRenderedToCookie')
			->with(array(3, 4));

		$configurations = $this->createConfigurations(
			array('showContentElements.' => array(
				'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
				'numberOfElementsToDisplay' => 2
			)), 'mkabtesting'
		);
		$action->setConfigurations($configurations);

		$this->assertEquals(
			array(3, 4),
			$this->callInaccessibleMethod($action, 'getElementsToBeRendered'),
			'falsche element uids in array'
		);
	}

	/**
	 * @group unit
	 */
	public function testGetElementsToBeRenderedIfValidElementsInCookie() {
		$_COOKIE['AB-Testing-testCampaign'] = '1,2';
		$repository = $this->getMock(
			'Tx_Mkabtesting_Repository_RenderedContentElements',
			array('search')
		);

		$action = $this->getMock(
			'Tx_Mkabtesting_Action_ShowContentElements',
			array(
				'getRenderedContentElementsRepository',
				'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable',
				'incrementCountForRenderedContentElement',
				'setElementsToBeRenderedToCookie'
			)
		);
		$action->expects($this->never())
			->method('getRenderedContentElementsRepository')
			->will(($this->returnValue($repository)));

		$action->expects($this->never())
			->method('assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable');

		$action->expects($this->never())
			->method('incrementCountForRenderedContentElement');

		$action->expects($this->never())
		->method('setElementsToBeRenderedToCookie');

		$configurations = $this->createConfigurations(
			array('showContentElements.' => array(
				'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
				'numberOfElementsToDisplay' => 2
			)), 'mkabtesting'
		);
		$action->setConfigurations($configurations);

		$this->assertEquals(
			array(1, 2),
			$this->callInaccessibleMethod($action, 'getElementsToBeRendered'),
			'falsche element uids in array'
		);
	}

	/**
	 * @group unit
	 */
	public function testHandleRequestRendersElementsCorrect() {
		$contentObject = $this->getMock(
			'tslib_cObj',
			array('RECORDS')
		);

		$contentObject->expects($this->at(0))
			->method('RECORDS')
			->with(array(
				'tables' => 'tt_content',
				'source' => 123,
				'dontCheckPid' => 1
			))
			->will(($this->returnValue('erstes element ')));
		$contentObject->expects($this->at(1))
			->method('RECORDS')
			->with(array(
				'tables' => 'tt_content',
				'source' => 456,
				'dontCheckPid' => 1
			))
			->will(($this->returnValue('zweites element')));

		$action = $this->getMock(
			'Tx_Mkabtesting_Action_ShowContentElements',
			array('getElementsToBeRendered')
		);
		$action->expects($this->once())
			->method('getElementsToBeRendered')
			->will(($this->returnValue(array(123, 456))));

		$configurations = $this->createConfigurations(
			array('showContentElements.' => array(
				'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
				'numberOfElementsToDisplay' => 2
			)), 'mkabtesting', '', $contentObject
		);
		$action->setConfigurations($configurations);

		$parameters = $viewData = arNULL;
		$this->assertEquals(
			'erstes element zweites element',
			$this->callInaccessibleMethod(
				$action, 'handleRequest', $parameters, $configurations, $viewData
			),
			'falsche element uids in array'
		);
	}
}