<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
tx_rnbase::load('Tx_Rnbase_Utility_TcaTool');

$_EXTKEY = 'mkabtesting';

$TCA['tx_mkabtesting_rendered_content_elements'] = array (
    'ctrl'  => $TCA['tx_mkabtesting_rendered_content_elements']['ctrl'],
    'interface' => array (
        'showRecordFieldList'   => 'hidden,campaign_identifier,content_element,render_count'
    ),
    'feInterface'   => $TCA['tx_mkabtesting_rendered_content_elements']['feInterface'],
    'columns'   => array (
        'hidden'        => array (
            'exclude'   => 1,
            'label'     => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config'    => array (
                'type'      => 'check',
                'default'   => '0'
            )
        ),
        'campaign_identifier' => array (
            'exclude'   => 1,
            'label'     => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements.campaign_identifier',
            'config'    => array (
                'type'      => 'input',
                'eval'      => 'required,trim',
                'maxsize'   => 255
            )
        ),
        'render_count' => array (
            'exclude'   => 1,
            'label'     => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements.render_count',
            'config'    => array (
                'type'  => 'input',
                'eval'  => 'int',
                'default' => 0,
            )
        ),
        'content_element' => array(
            'label'     => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements.content_element',
            'exclude' => 1,
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tt_content',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 1,
                'maxitems' => 0,
                'wizards' => Tx_Rnbase_Utility_TcaTool::getWizards('', array('suggest')),
            ),
        ),
    ),
    'types' => array (
        '0' => array('showitem' => 'hidden;;1;;1-1-1,campaign_identifier,content_element,render_count')
    ),
    'palettes' => array (
        '1' => array('showitem' => '')
    )
);
