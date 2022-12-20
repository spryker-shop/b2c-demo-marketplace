<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantOms\Communication\Plugin\Oms;

class RefundMarketplaceOrderItemCommandPlugin extends AbstractTriggerOmsEventCommandPlugin
{
    /**
     * @var string
     */
    protected const PYZ_EVENT_REFUND = 'refund';

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return static::PYZ_EVENT_REFUND;
    }
}
