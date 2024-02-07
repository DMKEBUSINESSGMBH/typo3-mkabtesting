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

namespace DMK\Mkabtesting\Search;

use DMK\Mkabtesting\Domain\Model\RenderedContentElement;
use Sys25\RnBase\Testing\BaseTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * Class RenderedContentElementsTest.
 *
 * @author  Hannes Bochmann
 * @license http://www.gnu.org/licenses/lgpl.html
 *          GNU Lesser General Public License, version 3 or later
 */
class RenderedContentElementsTest extends BaseTestCase
{
    /**
     * @group unit
     */
    public function testGetTableMappings()
    {
        $this->assertEquals(
            ['CONTENTELEMENT' => 'tx_mkabtesting_rendered_content_elements'],
            $this->callInaccessibleMethod(
                GeneralUtility::makeInstance(RenderedContentElements::class),
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
                GeneralUtility::makeInstance(RenderedContentElements::class),
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
                GeneralUtility::makeInstance(RenderedContentElements::class),
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
                GeneralUtility::makeInstance(RenderedContentElements::class),
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
            RenderedContentElement::class,
            $this->callInaccessibleMethod(
                GeneralUtility::makeInstance(RenderedContentElements::class),
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
                GeneralUtility::makeInstance(RenderedContentElements::class),
                'getJoins',
                []
            )
        );
    }
}
