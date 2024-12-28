<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductMerchantPortalGui;

use Spryker\Zed\AvailabilityMerchantPortalGui\Communication\Plugin\ProductMerchantPortalGui\TotalProductAvailabilityProductConcreteTableExpanderPlugin;
use Spryker\Zed\PriceProductOfferGui\Communication\Plugin\ProductMerchantPortalGui\PriceProductOfferPriceProductTableFilterPlugin;
use Spryker\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiDependencyProvider as SprykerProductMerchantPortalGuiDependencyProvider;
use Spryker\Zed\TaxMerchantPortalGui\Communication\Plugin\ProductMerchantPortalGui\TaxProductAbstractFormExpanderPlugin;

class ProductMerchantPortalGuiDependencyProvider extends SprykerProductMerchantPortalGuiDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\ProductMerchantPortalGuiExtension\Dependency\Plugin\ProductAbstractFormExpanderPluginInterface>
     */
    protected function getProductAbstractFormExpanderPlugins(): array
    {
        return [
            new TaxProductAbstractFormExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductMerchantPortalGuiExtension\Dependency\Plugin\ProductConcreteTableExpanderPluginInterface>
     */
    protected function getProductConcreteTableExpanderPlugins(): array
    {
        return [
            new TotalProductAvailabilityProductConcreteTableExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductMerchantPortalGuiExtension\Dependency\Plugin\PriceProductTableFilterPluginInterface>
     */
    protected function getPriceProductTableFilterPlugins(): array
    {
        return [
            new PriceProductOfferPriceProductTableFilterPlugin(),
        ];
    }
}
