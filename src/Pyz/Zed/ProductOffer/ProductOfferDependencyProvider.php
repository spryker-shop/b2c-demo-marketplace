<?php

namespace Pyz\Zed\ProductOffer;

use Spryker\Zed\PriceProductOffer\Communication\Plugin\ProductOffer\PriceProductOfferProductOfferExpanderPlugin;
use Spryker\Zed\PriceProductOffer\Communication\Plugin\ProductOffer\PriceProductOfferProductOfferPostCreatePlugin;
use Spryker\Zed\PriceProductOffer\Communication\Plugin\ProductOffer\PriceProductOfferProductOfferPostUpdatePlugin;
use Spryker\Zed\ProductOffer\ProductOfferDependencyProvider as SprykerProductOfferDependencyProvider;
use Spryker\Zed\ProductOfferValidity\Communication\Plugin\ProductOffer\ProductOfferValidityProductOfferExpanderPlugin;
use Spryker\Zed\ProductOfferValidity\Communication\Plugin\ProductOffer\ProductOfferValidityProductOfferPostCreatePlugin;
use Spryker\Zed\ProductOfferValidity\Communication\Plugin\ProductOffer\ProductOfferValidityProductOfferPostUpdatePlugin;

class ProductOfferDependencyProvider extends SprykerProductOfferDependencyProvider
{
    /**
     * @return \Spryker\Zed\ProductOfferExtension\Dependency\Plugin\ProductOfferPostCreatePluginInterface[]
     */
    protected function getProductOfferPostCreatePlugins(): array
    {
        return [
            new ProductOfferValidityProductOfferPostCreatePlugin(),
            new PriceProductOfferProductOfferPostCreatePlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ProductOfferExtension\Dependency\Plugin\ProductOfferPostUpdatePluginInterface[]
     */
    protected function getProductOfferPostUpdatePlugins(): array
    {
        return [
            new ProductOfferValidityProductOfferPostUpdatePlugin(),
            new PriceProductOfferProductOfferPostUpdatePlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ProductOfferExtension\Dependency\Plugin\ProductOfferExpanderPluginInterface[]
     */
    protected function getProductOfferExpanderPlugins(): array
    {
        return [
            new ProductOfferValidityProductOfferExpanderPlugin(),
            new PriceProductOfferProductOfferExpanderPlugin(),
        ];
    }
}
