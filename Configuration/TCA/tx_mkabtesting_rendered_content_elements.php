<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}
tx_rnbase::load('Tx_Rnbase_Utility_TcaTool');

return array(
    'ctrl' => array(
        'title'             => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements',
        'label'             => 'campaign_identifier',
        'label_alt'         => 'content_element,render_count',
        'label_alt_force'   => true,
        'tstamp'            => 'tstamp',
        'crdate'            => 'crdate',
        'cruser_id'         => 'cruser_id',
        'default_sortby'    => 'ORDER BY campaign_identifier DESC',
        'delete'            => 'deleted',
        'enablecolumns'     => array(
            'disabled' => 'hidden',
        ),
        'iconfile'          => 'EXT:mkabtesting/Resources/Public/Img/Icons/tca_table.gif',
        'dividers2tabs'     => true,
        'searchFields'      => 'campaign_identifier,elements'
    ),
    'interface' => array(
        'showRecordFieldList'   => 'hidden,campaign_identifier,content_element,render_count'
    ),
    'columns'   => array(
        'hidden'        => array(
            'exclude'   => 1,
            'label'     => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config'    => array(
                'type'      => 'check',
                'default'   => '0'
            )
        ),
        'campaign_identifier' => array(
            'exclude'   => 1,
            'label'     => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements.campaign_identifier',
            'config'    => array(
                'type'      => 'input',
                'eval'      => 'required,trim',
                'maxsize'   => 255
            )
        ),
        'render_count' => array(
            'exclude'   => 1,
            'label'     => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements.render_count',
            'config'    => array(
                'type'  => 'input',
                'eval'  => 'int',
                'default' => 0,
            )
        ),
        'content_element' => array(
            'label'     => 'LLL:EXT:mkabtesting/Resources/Private/Language/tca.xml:tx_mkabtesting_rendered_content_elements.content_element',
            'exclude' => 1,
            'config' => array(
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
    'types' => array(
        '0' => array('showitem' => 'hidden;;1;;1-1-1,campaign_identifier,content_element,render_count')
    ),
    'palettes' => array(
        '1' => array('showitem' => '')
    )
);
