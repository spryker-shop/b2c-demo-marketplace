<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SalesPaymentMerchant;

use Spryker\Zed\SalesPaymentMerchant\SalesPaymentMerchantDependencyProvider as SprykerSalesPaymentMerchantDependencyProvider;
use Spryker\Zed\SalesPaymentMerchantExtension\Communication\Dependency\Plugin\MerchantPayoutCalculatorPluginInterface;
use Spryker\Zed\SalesPaymentMerchantSalesMerchantCommission\Communication\Plugin\SalesPaymentMerchant\PayoutAmountMerchantPayoutCalculatorPlugin;
use Spryker\Zed\SalesPaymentMerchantSalesMerchantCommission\Communication\Plugin\SalesPaymentMerchant\PayoutReverseAmountMerchantPayoutCalculatorPlugin;

class SalesPaymentMerchantDependencyProvider extends SprykerSalesPaymentMerchantDependencyProvider
{
    protected function getMerchantPayoutAmountCalculatorPlugin(): ?MerchantPayoutCalculatorPluginInterface
    {
        return new PayoutAmountMerchantPayoutCalculatorPlugin();
    }

    protected function getMerchantPayoutReverseAmountCalculatorPlugin(): ?MerchantPayoutCalculatorPluginInterface
    {
        return new PayoutReverseAmountMerchantPayoutCalculatorPlugin();
    }
}
