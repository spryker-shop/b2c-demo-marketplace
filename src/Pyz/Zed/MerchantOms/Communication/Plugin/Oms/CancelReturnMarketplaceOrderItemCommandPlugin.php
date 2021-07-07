<?php

namespace Pyz\Zed\MerchantOms\Communication\Plugin\Oms;

class CancelReturnMarketplaceOrderItemCommandPlugin extends AbstractTriggerOmsEventCommandPlugin
{
    protected const EVENT_CANCEL_RETURN = 'cancel-return';

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return static::EVENT_CANCEL_RETURN;
    }
}
