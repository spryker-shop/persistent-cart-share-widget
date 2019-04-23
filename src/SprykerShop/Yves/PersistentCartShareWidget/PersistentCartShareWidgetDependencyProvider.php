<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\PersistentCartShareWidget;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\PersistentCartShareWidget\Dependency\Client\PersistentCartShareWidgetToCustomerClientBridge;

class PersistentCartShareWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';
    public const CLIENT_PERSISTENT_CART_SHARE = 'CLIENT_PERSISTENT_CART_SHARE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addCustomerClient($container);
        $container = $this->addPersistentCartShareClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container[static::CLIENT_CUSTOMER] = function (Container $container) {
            return new PersistentCartShareWidgetToCustomerClientBridge($container->getLocator()->customer()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPersistentCartShareClient(Container $container): Container
    {
        $container[static::CLIENT_PERSISTENT_CART_SHARE] = function (Container $container) {
            return new PersistentCartShareWidgetToPersistentCartShareClientBridge($container->getLocator()->persistentCartShare()->client());
        };

        return $container;
    }
}
