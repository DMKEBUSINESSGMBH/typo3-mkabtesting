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

call_user_func(function () {
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['tx_mkabtesting'] =
        'layout,select_key,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tx_mkabtesting'] = 'pi_flexform';
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        'tx_mkabtesting',
        'FILE:EXT:mkabtesting/Configuration/Flexform/actions.xml'
    );
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
        [
            'LLL:EXT:mkabtesting/Resources/Private/Language/flexform.xlf:plugin.mkabtesting.label',
            'tx_mkabtesting',
        ],
        'list_type',
        'mktegutfe'
    );
});
