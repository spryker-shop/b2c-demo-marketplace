<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductOfferServicePointStorage;

use Spryker\Client\ProductOfferServicePointStorage\ProductOfferServicePointStorageDependencyProvider as SprykerProductOfferServicePointStorageDependencyProvider;
use Spryker\Zed\MerchantProductOfferStorage\Communication\Plugin\ProductOfferServicePointStorage\MerchantProductOfferServiceCollectionStorageFilterPlugin;

class ProductOfferServicePointStorageDependencyProvider extends SprykerProductOfferServicePointStorageDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\ProductOfferServicePointStorageExtension\Dependency\Plugin\ProductOfferServiceCollectionStorageFilterPluginInterface>
     */
    protected function getProductOfferServiceCollectionStorageFilterPlugins(): array
    {
        return [
            new MerchantProductOfferServiceCollectionStorageFilterPlugin(),
        ];
    }
}
