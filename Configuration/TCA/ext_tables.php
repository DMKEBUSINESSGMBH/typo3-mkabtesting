<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
tx_rnbase::load('tx_mklib_util_TCA');

$_EXTKEY = 'mkabtesting';

$TCA['tx_mkabtesting_rendered_content_elements'] = array (
    'ctrl' => array (
        'title'             => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements',
        'label'             => 'campaign_identifier',
        'label_alt'         => 'content_element,render_count',
        'label_alt_force'   => true,
        'tstamp'            => 'tstamp',
        'crdate'            => 'crdate',
        'cruser_id'         => 'cruser_id',
        'default_sortby'    => 'ORDER BY campaign_identifier DESC',
        'delete'            => 'deleted',
        'enablecolumns'     => array (
            'disabled' => 'hidden',
        ),
        'dynamicConfigFile' => tx_rnbase_util_Extensions::extPath($_EXTKEY).'Configuration/TCA/tx_mkabtesting_rendered_content_elements.php',
        'iconfile'          => 'EXT:mkabtesting/Resources/Public/Img/Icons/tca_table.gif',
        'dividers2tabs'     => true,
        'searchFields'      => 'campaign_identifier,elements'
    )
);
