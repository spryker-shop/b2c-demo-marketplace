<?php

namespace Pyz\Zed\MerchantOms\Communication\Plugin\Oms;

class ExecuteReturnMarketplaceOrderItemCommandPlugin extends AbstractTriggerOmsEventCommandPlugin
{
    protected const EVENT_EXECUTE_RETURN = 'execute-return';

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return static::EVENT_EXECUTE_RETURN;
    }
}
