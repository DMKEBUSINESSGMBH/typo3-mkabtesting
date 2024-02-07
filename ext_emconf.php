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

$EM_CONF['mkabtesting'] = [
    'title' => 'MK A/B Testing',
    'description' => 'A/B Testing of content elements',
    'category' => 'plugin',
    'author' => 'Hannes Bochmann',
    'author_company' => 'DMK E-BUSINESS GmbH',
    'author_email' => 'dev@dmk-ebusiness.de',
    'shy' => '',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 0,
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '11.0.0',
    'constraints' => [
        'depends' => [
            'rn_base' => '1.16.0-',
            'typo3' => '11.5.0-11.5.99',
            'mklib' => '11.0.0-',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'suggests' => [],
];
