<?php

namespace Pyz\Zed\MerchantSearch;

use Spryker\Zed\MerchantCategorySearch\Communication\Plugin\MerchantSearch\MerchantCategoryMerchantSearchDataExpanderPlugin;
use Spryker\Zed\MerchantSearch\MerchantSearchDependencyProvider as SprykerMerchantSearchDependencyProvider;

class MerchantSearchDependencyProvider extends SprykerMerchantSearchDependencyProvider
{
    /**
     * @return \Spryker\Zed\MerchantSearchExtension\Dependency\Plugin\MerchantSearchDataExpanderPluginInterface[]
     */
    protected function getMerchantSearchDataExpanderPlugins(): array
    {
        return [
            new MerchantCategoryMerchantSearchDataExpanderPlugin(),
        ];
    }
}
