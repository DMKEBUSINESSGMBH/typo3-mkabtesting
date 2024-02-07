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
use Sys25\RnBase\Frontend\Controller\AbstractAction;
use Sys25\RnBase\Frontend\Request\RequestInterface;
use Sys25\RnBase\Frontend\View\Marker\BaseView;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ShowContentElements.
 *
 * @author  Hannes Bochmann
 * @license http://www.gnu.org/licenses/lgpl.html
 *          GNU Lesser General Public License, version 3 or later
 */
class ShowContentElements extends AbstractAction
{
    protected RequestInterface $request;

    /**
     * @var string
     */
    public const COOKIE_NAME_PREFIX = 'AB-Testing-';

    protected function getTemplateName()
    {
        return 'showContentElements';
    }

    protected function getViewClassName()
    {
        return BaseView::class;
    }

    protected function handleRequest(RequestInterface $request)
    {
        $this->request = $request;
        $content = '';
        foreach ($this->getElementsToBeRendered() as $contentUid) {
            $renderingConfiguration = [
                'tables' => 'tt_content',
                'source' => intval($contentUid),
                'dontCheckPid' => 1,
            ];
            $content .= $this->request->getConfigurations()->getCObj()->cObjGetSingle(
                'RECORDS',
                $renderingConfiguration
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
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getElementsToBeRenderedFromCookie(): array
    {
        $elementsFromCookie = [];

        if (!empty($_COOKIE[$this->getCookieName()])
            && $this->elementsInCookieStillValid()
        ) {
            $elementsFromCookie = $this->getCookieValuesAsArray();
        }

        return $elementsFromCookie;
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function getCookieName(): string
    {
        return self::COOKIE_NAME_PREFIX.$this->getCurrentCampaignIdentifier();
    }

    private function elementsInCookieStillValid(): bool
    {
        $invalidElements = array_diff(
            $this->getCookieValuesAsArray(),
            $this->getAllConfiguredContentElements()
        );

        return empty($invalidElements);
    }

    /**
     * @return Ambigous <multitype:, string, multitype:unknown >
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function getCookieValuesAsArray()
    {
        return GeneralUtility::trimExplode(
            ',',
            $_COOKIE[$this->getCookieName()]
        );
    }

    /**
     * es werden die elemente gerendert, die bisher am wenigstens gerendert wurden.
     * Dadurch erreichen wir die Gleichverteilung. Wir müssen dadurch aber auch
     * sicherstellen das alle möglichen Elemente in der Datenbank sind.
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
                $repository->create([
                    'campaign_identifier' => $currentCampaignIdentifier,
                    'content_element' => $elementUid,
                    'pid' => \Sys25\RnBase\Utility\TYPO3::getTSFE()->id,
                ]);
            }
        }
    }

    /**
     * @return array
     */
    protected function getAllConfiguredContentElements()
    {
        return GeneralUtility::trimExplode(
            ',',
            $this->request->getConfigurations()->get($this->request->getConfId().'elements'),
            true
        );
    }

    /**
     * @return string
     */
    protected function getCurrentCampaignIdentifier()
    {
        return $this->request->getConfigurations()->get(
            $this->request->getConfId().'campaignIdentifier'
        );
    }

    protected function getRenderedContentElementsRepository(): RenderedContentElements
    {
        return GeneralUtility::makeInstance(RenderedContentElements::class);
    }

    /**
     * wir machen das hier weil wir einer methode im repository sonst
     * zu viele parameter übergeben müssten.
     */
    private function getElementsToBeRenderedFromDatabase()
    {
        $repository = $this->getRenderedContentElementsRepository();

        $fields = [
            'CONTENTELEMENT.content_element' => [
                OP_IN_INT => $this->request->getConfigurations()->get($this->request->getConfId().'elements'),
            ],
            'CONTENTELEMENT.campaign_identifier' => [
                OP_EQ => $this->getCurrentCampaignIdentifier(),
            ],
        ];
        $options = [
            'orderby' => ['CONTENTELEMENT.render_count' => 'ASC'],
            'limit' => $this->request->getConfigurations()->getInt(
                $this->request->getConfId().'numberOfElementsToDisplay'
            ),
        ];

        return $repository->search($fields, $options);
    }

    protected function incrementCountForRenderedContentElement(RenderedContentElement $element): void
    {
        $this->getRenderedContentElementsRepository()->handleUpdate(
            $element,
            ['render_count' => 'render_count+1'],
            '',
            0,
            'render_count'
        );
    }

    /**
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function setElementsToBeRenderedToCookie(array $elementUidsToBeRendered)
    {
        $expireTime = $GLOBALS['EXEC_TIME'] + $this->request->getConfigurations()->getInt(
            $this->request->getConfId().'cookieExpireTime'
        );
        $this->setCookie(join(',', $elementUidsToBeRendered), $expireTime);
    }

    /**
     * @param string $value
     * @param int    $expire
     *
     * @return void
     */
    protected function setCookie($value, $expire)
    {
        setcookie(
            $this->getCookieName(),
            $value,
            $expire,
            '/',
            GeneralUtility::getIndpEnv('HTTP_HOST'),
            false,
            true
        );
    }
}
