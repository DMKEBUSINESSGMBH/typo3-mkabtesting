<?php

/*
 * Copyright notice
 *
 * (c) 2011-2024 DMK E-BUSINESS GmbH <dev@dmk-ebusiness.de>
 * All rights reserved
 *
 * This file is part of the "mklog" Extension for TYPO3 CMS.
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GNU Lesser General Public License can be found at
 * www.gnu.org/licenses/lgpl.html
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

namespace DMK\Mkabtesting\Action;

use DMK\Mkabtesting\Domain\Model\RenderedContentElement;
use DMK\Mkabtesting\Domain\Repository\RenderedContentElements;
use Sys25\RnBase\Configuration\ConfigurationInterface;
use Sys25\RnBase\Frontend\Request\Parameters;
use Sys25\RnBase\Frontend\Request\Request;
use Sys25\RnBase\Frontend\Request\RequestInterface;
use Sys25\RnBase\Frontend\View\Marker\BaseView;
use Sys25\RnBase\Testing\BaseTestCase;
use Sys25\RnBase\Testing\TestUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/***************************************************************
 *  Copyright notice
 *
 * (c) DMK E-BUSINESS GmbH <dev@dmk-ebusiness.de>
 * All rights reserved
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

/**
 * Class ShowContentElementsTest.
 *
 * @author  Hannes Bochmann
 * @license http://www.gnu.org/licenses/lgpl.html
 *          GNU Lesser General Public License, version 3 or later
 */
class ShowContentElementsTest extends BaseTestCase
{
    protected function tearDown(): void
    {
        if (isset($_COOKIE['AB-Testing-testCampaign'])) {
            unset($_COOKIE['AB-Testing-testCampaign']);
        }
    }

    /**
     * @group unit
     */
    public function testGetTemplateName()
    {
        $this->assertEquals(
            'showContentElements',
            $this->callInaccessibleMethod(
                GeneralUtility::makeInstance(ShowContentElements::class),
                'getTemplateName'
            ),
            'falscher Templatename'
        );
    }

    /**
     * @group unit
     */
    public function testGetViewClassName()
    {
        $this->assertEquals(
            BaseView::class,
            $this->callInaccessibleMethod(
                GeneralUtility::makeInstance(ShowContentElements::class),
                'getViewClassName'
            ),
            'falscher Klassenname'
        );
    }

    /**
     * @group unit
     */
    public function testGetRenderedContentElementsRepository()
    {
        $this->assertInstanceOf(
            RenderedContentElements::class,
            $this->callInaccessibleMethod(
                GeneralUtility::makeInstance(ShowContentElements::class),
                'getRenderedContentElementsRepository'
            ),
            'falsche Klasse'
        );
    }

    /**
     * @group unit
     */
    public function testGetAllConfiguredContentElements()
    {
        $action = $this->getAccessibleMock(ShowContentElements::class, ['getTemplateName']);
        $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => ['elements' => '1,2,3']],
                'mkabtesting'
            )
        );

        $this->assertEquals(
            [1, 2, 3],
            $this->callInaccessibleMethod(
                $action,
                'getAllConfiguredContentElements'
            ),
            'falscher IDs'
        );
    }

    protected function setRequestToAction(ShowContentElements $action, ConfigurationInterface $configurations): RequestInterface
    {
        $parameters = new Parameters();
        $request = new Request($parameters, $configurations, 'showContentElements.');
        $action->_set('request', $request);

        return $request;
    }

    /**
     * @group unit
     */
    public function testAssureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable()
    {
        $repository = $this->getMock(
            RenderedContentElements::class,
            ['countByElementUidAndCampaignIdentifier', 'create']
        );
        $repository->expects($this->exactly(2))
            ->method('countByElementUidAndCampaignIdentifier')
            ->withConsecutive([1, 'testCampaign'], [2, 'testCampaign'])
            ->willReturnOnConsecutiveCalls(1, null);
        $expectedCreationData = [
            'campaign_identifier' => 'testCampaign',
            'content_element' => 2,
        ];
        $repository->expects($this->once())
            ->method('create')
            ->with($expectedCreationData);

        $action = $this->getAccessibleMock(
            ShowContentElements::class,
            ['getRenderedContentElementsRepository']
        );
        $action->expects($this->once())
            ->method('getRenderedContentElementsRepository')
            ->will($this->returnValue($repository));

        $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => [
                    'elements' => '1,2', 'campaignIdentifier' => 'testCampaign',
                ]],
                'mkabtesting'
            )
        );

        $this->callInaccessibleMethod(
            $action,
            'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable'
        );
    }

    /**
     * @group unit
     */
    public function testIncrementCountForRenderedContentElement()
    {
        $repository = $this->getMock(
            RenderedContentElements::class,
            ['handleUpdate']
        );
        $elementModel = GeneralUtility::makeInstance(
            RenderedContentElement::class,
            ['uid' => 1]
        );
        $repository->expects($this->once())
            ->method('handleUpdate')
            ->with(
                $elementModel,
                ['render_count' => 'render_count+1'],
                '',
                0,
                'render_count'
            );

        $action = $this->getAccessibleMock(
            ShowContentElements::class,
            ['getRenderedContentElementsRepository']
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
    public function testGetCookieName()
    {
        $action = $this->getAccessibleMock(
            ShowContentElements::class,
            ['setCookie']
        );

        $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => [
                    'campaignIdentifier' => 'testCampaign',
                ]],
                'mkabtesting'
            )
        );

        $this->assertEquals(
            'AB-Testing-testCampaign',
            $this->callInaccessibleMethod($action, 'getCookieName')
        );
    }

    /**
     * @group unit
     */
    public function testSetElementsToBeRenderedToCookie()
    {
        $action = $this->getAccessibleMock(
            ShowContentElements::class,
            ['setCookie']
        );
        $action->expects($this->once())
            ->method('setCookie')
            ->with('123,456', $GLOBALS['EXEC_TIME'] + 123456);

        $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => [
                    'cookieExpireTime' => 123456, 'campaignIdentifier' => 'testCampaign',
                ]],
                'mkabtesting'
            )
        );

        $this->callInaccessibleMethod(
            $action,
            'setElementsToBeRenderedToCookie',
            [123, 456]
        );
    }

    /**
     * @group unit
     */
    public function testGetElementsToBeRenderedIfNoCookie()
    {
        $repository = $this->getMock(
            RenderedContentElements::class,
            ['search']
        );

        $expectedFields = [
            'CONTENTELEMENT.content_element' => [
                OP_IN_INT => '1,2,3,4',
            ],
            'CONTENTELEMENT.campaign_identifier' => [
                OP_EQ => 'testCampaign',
            ],
        ];
        $expectedOptions = [
            'orderby' => ['CONTENTELEMENT.render_count' => 'ASC'],
            'limit' => 2,
        ];
        $elementModels = [
            0 => GeneralUtility::makeInstance(
                RenderedContentElement::class,
                ['uid' => 1, 'content_element' => 3]
            ),
            1 => GeneralUtility::makeInstance(
                RenderedContentElement::class,
                ['uid' => 2, 'content_element' => 4]
            ),
        ];
        $repository->expects($this->once())
            ->method('search')
            ->with($expectedFields, $expectedOptions)
            ->will($this->returnValue($elementModels));

        $action = $this->getAccessibleMock(
            ShowContentElements::class,
            [
                'getRenderedContentElementsRepository',
                'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable',
                'incrementCountForRenderedContentElement',
                'setElementsToBeRenderedToCookie',
            ]
        );
        $action->expects($this->once())
            ->method('getRenderedContentElementsRepository')
            ->will($this->returnValue($repository));

        $action->expects($this->once())
            ->method('assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable');

        $action->expects($this->exactly(2))
            ->method('incrementCountForRenderedContentElement')
            ->withConsecutive([$elementModels[0]], [$elementModels[1]]);

        $action->expects($this->once())
            ->method('setElementsToBeRenderedToCookie')
            ->with([3, 4]);

        $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => [
                    'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
                    'numberOfElementsToDisplay' => 2,
                ]],
                'mkabtesting'
            )
        );

        $this->assertEquals(
            [3, 4],
            $this->callInaccessibleMethod($action, 'getElementsToBeRendered'),
            'falsche element uids in array'
        );
    }

    /**
     * @group unit
     */
    public function testGetElementsToBeRenderedIfInvalidElementsInCookie()
    {
        $_COOKIE['AB-Testing-testCampaign'] = '1,5';
        $repository = $this->getMock(
            RenderedContentElements::class,
            ['search']
        );

        $expectedFields = [
            'CONTENTELEMENT.content_element' => [
                OP_IN_INT => '1,2,3,4',
            ],
            'CONTENTELEMENT.campaign_identifier' => [
                OP_EQ => 'testCampaign',
            ],
        ];
        $expectedOptions = [
            'orderby' => ['CONTENTELEMENT.render_count' => 'ASC'],
            'limit' => 2,
        ];
        $elementModels = [
            0 => GeneralUtility::makeInstance(
                RenderedContentElement::class,
                ['uid' => 1, 'content_element' => 3]
            ),
            1 => GeneralUtility::makeInstance(
                RenderedContentElement::class,
                ['uid' => 2, 'content_element' => 4]
            ),
        ];
        $repository->expects($this->once())
            ->method('search')
            ->with($expectedFields, $expectedOptions)
            ->will($this->returnValue($elementModels));

        $action = $this->getAccessibleMock(
            ShowContentElements::class,
            [
                'getRenderedContentElementsRepository',
                'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable',
                'incrementCountForRenderedContentElement',
                'setElementsToBeRenderedToCookie',
            ]
        );
        $action->expects($this->once())
            ->method('getRenderedContentElementsRepository')
            ->will($this->returnValue($repository));

        $action->expects($this->once())
            ->method('assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable');

        $action->expects($this->exactly(2))
            ->method('incrementCountForRenderedContentElement')
            ->withConsecutive([$elementModels[0]], [$elementModels[1]]);

        $action->expects($this->once())
            ->method('setElementsToBeRenderedToCookie')
            ->with([3, 4]);

        $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => [
                    'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
                    'numberOfElementsToDisplay' => 2,
                ]],
                'mkabtesting'
            )
        );

        $this->assertEquals(
            [3, 4],
            $this->callInaccessibleMethod($action, 'getElementsToBeRendered'),
            'falsche element uids in array'
        );
    }

    /**
     * @group unit
     */
    public function testGetElementsToBeRenderedIfValidElementsInCookie()
    {
        $_COOKIE['AB-Testing-testCampaign'] = '1,2';
        $repository = $this->getMock(
            RenderedContentElements::class,
            ['search']
        );

        $action = $this->getAccessibleMock(
            ShowContentElements::class,
            [
                'getRenderedContentElementsRepository',
                'assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable',
                'incrementCountForRenderedContentElement',
                'setElementsToBeRenderedToCookie',
            ]
        );
        $action->expects($this->never())
            ->method('getRenderedContentElementsRepository')
            ->will($this->returnValue($repository));

        $action->expects($this->never())
            ->method('assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable');

        $action->expects($this->never())
            ->method('incrementCountForRenderedContentElement');

        $action->expects($this->never())
        ->method('setElementsToBeRenderedToCookie');

        $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => [
                    'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
                    'numberOfElementsToDisplay' => 2,
                ]],
                'mkabtesting'
            )
        );

        $this->assertEquals(
            [1, 2],
            $this->callInaccessibleMethod($action, 'getElementsToBeRendered'),
            'falsche element uids in array'
        );
    }

    /**
     * @group unit
     */
    public function testHandleRequestRendersElementsCorrect()
    {
        $contentObject = $this->getMock(
            ContentObjectRenderer::class,
            ['cObjGetSingle']
        );

        $contentObject->expects($this->exactly(2))
            ->method('cObjGetSingle')
            ->withConsecutive(
                [
                    'RECORDS',
                    [
                        'tables' => 'tt_content',
                        'source' => 123,
                        'dontCheckPid' => 1,
                    ],
                ],
                [
                    'RECORDS',
                    [
                        'tables' => 'tt_content',
                        'source' => 456,
                        'dontCheckPid' => 1,
                    ],
                ]
            )
            ->willReturnOnConsecutiveCalls('erstes element ', 'zweites element');

        $action = $this->getAccessibleMock(ShowContentElements::class, ['getElementsToBeRendered']);
        $action->expects($this->once())
            ->method('getElementsToBeRendered')
            ->will($this->returnValue([123, 456]));

        $request = $this->setRequestToAction(
            $action,
            TestUtility::createConfigurations(
                ['showContentElements.' => [
                    'elements' => '1,2,3,4', 'campaignIdentifier' => 'testCampaign',
                    'numberOfElementsToDisplay' => 2,
                ]],
                'mkabtesting',
                '',
                $contentObject
            )
        );

        $parameters = $viewData = null;
        $this->assertEquals(
            'erstes element zweites element',
            $this->callInaccessibleMethod(
                [$action, 'handleRequest'],
                [$request]
            ),
            'falsche element uids in array'
        );
    }
}
