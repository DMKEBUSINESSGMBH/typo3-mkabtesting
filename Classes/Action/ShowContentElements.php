<?php
/**
 * @package TYPO3
 * @subpackage tx_mkabtesting
 * @author Hannes Bochmann <dev@dmk-ebusiness.de>
 *
 *  Copyright notice
 *
 *  (c) 2013 Hannes Bochmann <dev@dmk-ebusiness.de>
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
tx_rnbase::load('tx_rnbase_action_BaseIOC');
tx_rnbase::load('tx_rnbase_util_Strings');
tx_rnbase::load('tx_rnbase_util_Misc');

/**
 * Tx_Mkabtesting_Action_ShowContentElements
 *
 * @package TYPO3
 * @subpackage tx_mkabtesting
 */
class Tx_Mkabtesting_Action_ShowContentElements extends tx_rnbase_action_BaseIOC
{

    /**
     * @var string
     */
    const COOKIE_NAME_PREFIX = 'AB-Testing-';

    /**
     * (non-PHPdoc)
     * @see tx_rnbase_action_BaseIOC::getTemplateName()
     */
    protected function getTemplateName()
    {
        return 'showContentElements';
    }

    /**
     * (non-PHPdoc)
     * @see tx_rnbase_action_BaseIOC::getViewClassName()
     */
    protected function getViewClassName()
    {
        return 'tx_rnbase_view_Base';
    }

    /**
     * (non-PHPdoc)
     * @see tx_rnbase_action_BaseIOC::handleRequest()
     */
    protected function handleRequest(&$parameters, &$configurations, &$viewdata)
    {
        foreach ($this->getElementsToBeRendered() as $contentUid) {
            $typoscriptRenderingConfiguration = array(
                'tables' => 'tt_content',
                'source' => intval($contentUid),
                'dontCheckPid' => 1
            );
            $content .= $this->getConfigurations()->getCObj()->RECORDS(
                $typoscriptRenderingConfiguration
            );
        }

        return $content;
    }

    /**
     * @return array
     */
    protected function getElementsToBeRendered()
    {
        $elementUidsToBeRendered = $this->getElementsToBeRenderedFromCookie();

        if (empty($elementUidsToBeRendered)) {
            $this->assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable();

            foreach ($this->getElementsToBeRenderedFromDatabase() as $element) {
                $elementUidsToBeRendered[] = $element->getContentElement();
                $this->incrementCountForRenderedContentElement($element);
            }

            $this->setElementsToBeRenderedToCookie($elementUidsToBeRendered);
        }

        return $elementUidsToBeRendered;
    }

    /**
     * @return array
     */
    protected function getElementsToBeRenderedFromCookie()
    {
        $elementsFromCookie = array();

        if (!empty($_COOKIE[$this->getCookieName()]) &&
            $this->elementsInCookieStillValid()
        ) {
            $elementsFromCookie = $this->getCookieValuesAsArray();
        }

        return $elementsFromCookie;
    }

    /**
     * @return string
     */
    private function getCookieName()
    {
        return self::COOKIE_NAME_PREFIX . $this->getCurrentCampaignIdentifier();
    }

    /**
     * @return bool
     */
    private function elementsInCookieStillValid()
    {
        $invalidElements = array_diff(
            $this->getCookieValuesAsArray(),
            $this->getAllConfiguredContentElements()
        );

        return empty($invalidElements);
    }

    /**
     * @return Ambigous <multitype:, string, multitype:unknown >
     */
    private function getCookieValuesAsArray()
    {
        return tx_rnbase_util_Strings::trimExplode(
            ',',
            $_COOKIE[$this->getCookieName()]
        );
    }

    /**
     * es werden die elemente gerendert, die bisher am wenigstens gerendert wurden.
     * Dadurch erreichen wir die Gleichverteilung. Wir müssen dadurch aber auch
     * sicherstellen das alle möglichen Elemente in der Datenbank sind
     *
     * @return void
     */
    protected function assureAllElementsOfCurrentCampaignAreInRenderedContentElementsTable()
    {
        $repository = $this->getRenderedContentElementsRepository();
        $currentCampaignIdentifier = $this->getCurrentCampaignIdentifier();

        foreach ($this->getAllConfiguredContentElements() as $elementUid) {
            if (!$repository->countByElementUidAndCampaignIdentifier(
                $elementUid,
                $currentCampaignIdentifier
            )) {
                $repository->create(array(
                    'campaign_identifier' => $currentCampaignIdentifier,
                    'content_element' => $elementUid
                ));
            }
        }
    }

    /**
     * @return array
     */
    protected function getAllConfiguredContentElements()
    {
        return tx_rnbase_util_Strings::trimExplode(
            ',',
            $this->getConfigurations()->get($this->getConfId() . 'elements'),
            true
        );
    }

    /**
     * @return string
     */
    protected function getCurrentCampaignIdentifier()
    {
        return $this->getConfigurations()->get(
            $this->getConfId() . 'campaignIdentifier'
        );
    }

    /**
     * @return Tx_Mkabtesting_Repository_RenderedContentElements
     */
    protected function getRenderedContentElementsRepository()
    {
        static $renderedContentElementsRepository;

        if (!is_object($renderedContentElementsRepository)) {
            $renderedContentElementsRepository = tx_rnbase::makeInstance(
                'Tx_Mkabtesting_Repository_RenderedContentElements'
            );
        }

        return $renderedContentElementsRepository;
    }

    /**
     * wir machen das hier weil wir einer methode im repository sonst
     * zu viele parameter übergeben müssten.
     *
     * @return Ambigous <multitype:tx_rnbase_model_base , array, multitype:>
     */
    private function getElementsToBeRenderedFromDatabase()
    {
        $repository = $this->getRenderedContentElementsRepository();

        $fields = array(
            'CONTENTELEMENT.content_element' => array(
                OP_IN_INT => $this->getConfigurations()->get($this->getConfId() . 'elements')
            ),
            'CONTENTELEMENT.campaign_identifier' => array(
                OP_EQ => $this->getCurrentCampaignIdentifier()
            ),
        );
        $options = array(
            'orderby' => array('CONTENTELEMENT.render_count' => 'ASC'),
            'limit' => $this->getConfigurations()->getInt(
                $this->getConfId() . 'numberOfElementsToDisplay'
            )
        );

        return $repository->search($fields, $options);
    }

    /**
     * @param Tx_Mkabtesting_Model_RenderedContentElement $element
     *
     * @return void
     */
    protected function incrementCountForRenderedContentElement(
        Tx_Mkabtesting_Model_RenderedContentElement $element
    ) {
        $this->getRenderedContentElementsRepository()->handleUpdate(
            $element,
            array('render_count' => 'render_count+1'),
            '',
            0,
            'render_count'
        );
    }

    /**
     *
     * @param array $elementUidsToBeRendered
     * @return void
     */
    protected function setElementsToBeRenderedToCookie(array $elementUidsToBeRendered)
    {
        $expireTime = $GLOBALS['EXEC_TIME'] + $this->getConfigurations()->getInt(
            $this->getConfId() . 'cookieExpireTime'
        );
        $this->setCookie(join(',', $elementUidsToBeRendered), $expireTime);
    }


    /**
     * @param string $value
     * @param int $expire
     * @return void
     */
    protected function setCookie($value, $expire)
    {
        setcookie(
            $this->getCookieName(),
            $value,
            $expire,
            '/',
            tx_rnbase_util_Misc::getIndpEnv('HTTP_HOST'),
            false,
            true
        );
    }
}
