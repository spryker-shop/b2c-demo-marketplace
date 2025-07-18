<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\OrderAmendmentExample;

use Spryker\Zed\OrderAmendmentExample\OrderAmendmentExampleConfig as SprykerOrderAmendmentExampleConfig;

class OrderAmendmentExampleConfig extends SprykerOrderAmendmentExampleConfig
{
    /**
     * @var list<string>
     */
    protected const ASYNC_ORDER_AMENDMENT_PAYMENT_METHOD_NAMES = [
        'dummyMarketplacePaymentInvoice',
        'dummyPaymentInvoice',
    ];
}
