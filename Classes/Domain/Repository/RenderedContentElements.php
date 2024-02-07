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

namespace DMK\Mkabtesting\Domain\Repository;

/**
 * Class RenderedContentElements.
 *
 * @author  Hannes Bochmann
 * @license http://www.gnu.org/licenses/lgpl.html
 *          GNU Lesser General Public License, version 3 or later
 */
class RenderedContentElements extends \tx_mklib_repository_Abstract
{
    /**
     * (non-PHPdoc).
     *
     * @see tx_mklib_repository_Abstract::getSearchClass()
     */
    protected function getSearchClass()
    {
        return \DMK\Mkabtesting\Search\RenderedContentElements::class;
    }

    /**
     * @param int    $elementUid
     * @param string $campaignIdentifier
     *
     * @return array
     */
    public function countByElementUidAndCampaignIdentifier($elementUid, $campaignIdentifier)
    {
        $fields = [
            'CONTENTELEMENT.content_element' => [OP_EQ_INT => $elementUid],
            'CONTENTELEMENT.campaign_identifier' => [OP_EQ => $campaignIdentifier],
        ];

        $options = [
            'count' => true,
        ];

        return $this->search($fields, $options);
    }
}
