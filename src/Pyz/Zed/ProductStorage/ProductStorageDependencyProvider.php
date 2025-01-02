<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductStorage;

use Spryker\Zed\MerchantProductStorage\Communication\Plugin\ProductStorage\MerchantProductAbstractStorageExpanderPlugin;
use Spryker\Zed\MerchantProductStorage\Communication\Plugin\ProductStorage\MerchantProductConcreteStorageCollectionExpanderPlugin;
use Spryker\Zed\ProductApproval\Communication\Plugin\ProductStorage\ProductApprovalProductAbstractStorageCollectionFilterPlugin;
use Spryker\Zed\ProductApproval\Communication\Plugin\ProductStorage\ProductApprovalProductConcreteStorageCollectionFilterPlugin;
use Spryker\Zed\ProductStorage\ProductStorageDependencyProvider as SprykerProductStorageDependencyProvider;

class ProductStorageDependencyProvider extends SprykerProductStorageDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\ProductStorageExtension\Dependency\Plugin\ProductAbstractStorageExpanderPluginInterface>
     */
    protected function getProductAbstractStorageExpanderPlugins(): array
    {
        return [
            new MerchantProductAbstractStorageExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductStorageExtension\Dependency\Plugin\ProductConcreteStorageCollectionExpanderPluginInterface>
     */
    protected function getProductConcreteStorageCollectionExpanderPlugins(): array
    {
        return [
            new MerchantProductConcreteStorageCollectionExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductStorageExtension\Dependency\Plugin\ProductAbstractStorageCollectionFilterPluginInterface>
     */
    protected function getProductAbstractStorageCollectionFilterPlugins(): array
    {
        return [
            new ProductApprovalProductAbstractStorageCollectionFilterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductStorageExtension\Dependency\Plugin\ProductConcreteStorageCollectionFilterPluginInterface>
     */
    protected function getProductConcreteStorageCollectionFilterPlugins(): array
    {
        return [
            new ProductApprovalProductConcreteStorageCollectionFilterPlugin(),
        ];
    }
}
