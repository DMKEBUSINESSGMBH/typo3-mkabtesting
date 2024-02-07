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

if (!defined('TYPO3')) {
    exit('Access denied.');
}

return [
    'ctrl' => [
        'title' => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xlf:tx_mkabtesting_rendered_content_elements',
        'label' => 'campaign_identifier',
        'label_alt' => 'content_element,render_count',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY campaign_identifier DESC',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:mkabtesting/Resources/Public/Img/Icons/tca_table.gif',
        'dividers2tabs' => true,
        'searchFields' => 'campaign_identifier,elements',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,campaign_identifier,content_element,render_count',
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => '0',
            ],
        ],
        'campaign_identifier' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xlf:tx_mkabtesting_rendered_content_elements.campaign_identifier',
            'config' => [
                'type' => 'input',
                'eval' => 'required,trim',
                'maxsize' => 255,
            ],
        ],
        'render_count' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xlf:tx_mkabtesting_rendered_content_elements.render_count',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
                'default' => 0,
            ],
        ],
        'content_element' => [
            'label' => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xlf:tx_mkabtesting_rendered_content_elements.content_element',
            'exclude' => 1,
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tt_content',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 1,
                'maxitems' => 0,
                'suggestOptions' => [
                    'default' => [
                        'maxItemsInResultList' => 999,
                        'minimumCharacters' => 3,
                        'searchWholePhrase' => 1,
                    ],
                ],
            ],
        ],
        // so the column is not discarded when writing data through the repository
        'pid' => [],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden;;1;;1-1-1,campaign_identifier,content_element,render_count'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];
