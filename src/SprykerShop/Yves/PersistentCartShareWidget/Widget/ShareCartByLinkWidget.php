<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\PersistentCartShareWidget\Widget;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\PersistentCartShareWidget\PersistentCartShareWidgetFactory getFactory()
 */
class ShareCartByLinkWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAM_CART = 'cart';

    /**
     * @var string
     */
    protected const PARAM_IS_QUOTE_OWNER = 'isQuoteOwner';

    /**
     * @var string
     */
    protected const PARAM_SHARE_OPTIONS_GROUPS = 'shareOptionGroups';

    public function __construct(QuoteTransfer $quoteTransfer)
    {
        $this->addCartParameter($quoteTransfer);
        $this->addIsQuoteOwnerParameter($quoteTransfer);
        $this->addCartShareOptionsParameter();
    }

    protected function addCartParameter(QuoteTransfer $quoteTransfer): void
    {
        $this->addParameter(static::PARAM_CART, $quoteTransfer);
    }

    protected function addIsQuoteOwnerParameter(QuoteTransfer $quoteTransfer): void
    {
        $this->addParameter(static::PARAM_IS_QUOTE_OWNER, $this->isQuoteOwner($quoteTransfer));
    }

    protected function addCartShareOptionsParameter(): void
    {
        $this->addParameter(static::PARAM_SHARE_OPTIONS_GROUPS, $this->getShareOptionsGroups());
    }

    protected function isQuoteOwner(QuoteTransfer $quoteTransfer): bool
    {
        $customerTransfer = $this->getFactory()
            ->getCustomerClient()
            ->getCustomer();

        if (!$customerTransfer) {
            return false;
        }

        return $customerTransfer->getCustomerReference() === $quoteTransfer->getCustomerReference();
    }

    public static function getName(): string
    {
        return 'ShareCartByLinkWidget';
    }

    public static function getTemplate(): string
    {
        return '@PersistentCartShareWidget/views/share-cart-by-link-widget/share-cart-by-link-widget.twig';
    }

    /**
     * @return array<string>
     */
    protected function getShareOptionsGroups(): array
    {
        return $this->getFactory()
            ->createPersistentCartShareLinkGenerator()
            ->generateShareOptionGroups();
    }
}
