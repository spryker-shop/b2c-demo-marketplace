<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\MerchantSalesOrder;

use Spryker\Zed\DiscountMerchantSalesOrder\Communication\Plugin\MerchantSalesOrder\DiscountMerchantOrderFilterPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MerchantOms\Communication\Plugin\MerchantSalesOrder\EventTriggerMerchantOrderPostCreatePlugin;
use Spryker\Zed\MerchantOms\Communication\Plugin\MerchantSalesOrder\MerchantOmsMerchantOrderExpanderPlugin;
use Spryker\Zed\MerchantSalesOrder\MerchantSalesOrderDependencyProvider as SprykerMerchantSalesOrderDependencyProvider;
use Spryker\Zed\MerchantSalesOrderSalesMerchantCommission\Communication\Plugin\MerchantSalesOrder\UpdateMerchantCommissionTotalsMerchantOrderPostCreatePlugin;
use Spryker\Zed\SalesDiscountConnector\Communication\Plugin\MerchantSalesOrder\CopyOrderContextMerchantOrderTotalsPreRecalculatePlugin;

class MerchantSalesOrderDependencyProvider extends SprykerMerchantSalesOrderDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addSalesFacade($container);

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\MerchantSalesOrderExtension\Dependency\Plugin\MerchantOrderPostCreatePluginInterface>
     */
    protected function getMerchantOrderPostCreatePlugins(): array
    {
        return [
            new EventTriggerMerchantOrderPostCreatePlugin(),
            new UpdateMerchantCommissionTotalsMerchantOrderPostCreatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\MerchantSalesOrderExtension\Dependency\Plugin\MerchantOrderExpanderPluginInterface>
     */
    protected function getMerchantOrderExpanderPlugins(): array
    {
        return [
            new MerchantOmsMerchantOrderExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\MerchantSalesOrderExtension\Dependency\Plugin\MerchantOrderFilterPluginInterface>
     */
    protected function getMerchantOrderFilterPlugins(): array
    {
        return [
            new DiscountMerchantOrderFilterPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\MerchantSalesOrderExtension\Dependency\Plugin\MerchantOrderTotalsPreRecalculatePluginInterface>
     */
    protected function getMerchantOrderTotalsPreRecalculatePlugins(): array
    {
        return [
            new CopyOrderContextMerchantOrderTotalsPreRecalculatePlugin(),
        ];
    }
}
