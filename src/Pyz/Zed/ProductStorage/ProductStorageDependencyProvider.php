<?php


namespace Pyz\Zed\ProductStorage;

use Spryker\Zed\ProductStorage\ProductStorageDependencyProvider as SprykerProductStorageDependencyProvider;

use Spryker\Zed\MerchantProductStorage\Communication\Plugin\ProductStorage\MerchantProductAbstractStorageExpanderPlugin;

class ProductStorageDependencyProvider extends SprykerProductStorageDependencyProvider
{
    /**
     * @return \Spryker\Zed\ProductStorageExtension\Dependency\Plugin\ProductAbstractStorageExpanderPluginInterface[]
     */
    protected function getProductAbstractStorageExpanderPlugins(): array
    {
        return [
            new MerchantProductAbstractStorageExpanderPlugin(),
        ];
    }
}
