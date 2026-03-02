<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\PersistentCartShareWidget;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\Kernel\Application;
use Spryker\Yves\Router\Router\ChainRouter;
use SprykerShop\Yves\PersistentCartShareWidget\Dependency\Client\PersistentCartShareWidgetToCustomerClientInterface;
use SprykerShop\Yves\PersistentCartShareWidget\Dependency\Client\PersistentCartShareWidgetToPersistentCartShareClientInterface;
use SprykerShop\Yves\PersistentCartShareWidget\PersistentCartShare\PersistentCartShareLinkGenerator;
use SprykerShop\Yves\PersistentCartShareWidget\PersistentCartShare\PersistentCartShareLinkGeneratorInterface;
use SprykerShop\Yves\PersistentCartShareWidget\ResourceShare\ResourceShareRequestBuilder;

class PersistentCartShareWidgetFactory extends AbstractFactory
{
    public function getCustomerClient(): PersistentCartShareWidgetToCustomerClientInterface
    {
        return $this->getProvidedDependency(PersistentCartShareWidgetDependencyProvider::CLIENT_CUSTOMER);
    }

    public function getPersistentCartShareClient(): PersistentCartShareWidgetToPersistentCartShareClientInterface
    {
        return $this->getProvidedDependency(PersistentCartShareWidgetDependencyProvider::CLIENT_PERSISTENT_CART_SHARE);
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return \Spryker\Yves\Kernel\Application
     */
    public function getApplication(): Application
    {
        return $this->getProvidedDependency(PersistentCartShareWidgetDependencyProvider::PLUGIN_APPLICATION);
    }

    public function createResourceShareRequestBuilder(): ResourceShareRequestBuilder
    {
        return new ResourceShareRequestBuilder(
            $this->getCustomerClient(),
        );
    }

    public function createPersistentCartShareLinkGenerator(): PersistentCartShareLinkGeneratorInterface
    {
        return new PersistentCartShareLinkGenerator(
            $this->getPersistentCartShareClient(),
            $this->getRouter(),
            $this->createResourceShareRequestBuilder(),
            $this->getCustomerClient(),
        );
    }

    public function getRouter(): ChainRouter
    {
        return $this->getProvidedDependency(PersistentCartShareWidgetDependencyProvider::SERVICE_ROUTER);
    }
}
