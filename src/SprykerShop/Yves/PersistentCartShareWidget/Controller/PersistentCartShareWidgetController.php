<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\PersistentCartShareWidget\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\PersistentCartShareWidget\PersistentCartShareWidgetFactory getFactory()
 */
class PersistentCartShareWidgetController extends AbstractController
{

    /**
     * @param int $idQuote
     * @param string $permissionOption
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(int $idQuote, string $permissionOption, Request $request): View
    {
        $response = $this->executeIndexAction($idQuote, $permissionOption, $request);

        return $this->view($response, [], '@PersistentCartShareWidget/views/share-cart-response/share-cart-response.twig');
    }

    /**
     * @param int $idQuote
     * @param string $permissionOptionGroup
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeIndexAction(int $idQuote, string $permissionOptionGroup, Request $request): array
    {
        $cartShareOptions = $this->getFactory()
            ->getPersistentCartShareClient()
            ->getCartShareOptions();

        $cartShareLinks = $this->getFactory()
            ->createPersistentCartShareLinkGenerator()
            ->generateCartShareLinks($cartShareOptions, $idQuote, $permissionOptionGroup);

        $cartShareLinkLabels = $this->getFactory()
            ->createPersistentCartShareLinkGenerator()
            ->generateCartShareLinkLabels($cartShareOptions, $idQuote, $permissionOptionGroup);

        return [
            'idQuote' => $idQuote,
            'permissionOption' => $permissionOptionGroup,
            'cartShareLinks' => $cartShareLinks,
            'cartShareLinkLabels' => $cartShareLinkLabels,
        ];
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function getCustomer(): ?CustomerTransfer
    {
        return $this->getFactory()
            ->getCustomerClient()
            ->getCustomer();
    }
}
