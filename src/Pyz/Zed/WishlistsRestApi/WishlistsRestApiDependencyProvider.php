<?php
namespace Pyz\Zed\WishlistsRestApi;

use Spryker\Zed\MerchantProductOfferWishlistRestApi\Communication\Plugin\EmptyProductOfferRestWishlistItemsAttributesDeleteStrategyPlugin;
use Spryker\Zed\MerchantProductOfferWishlistRestApi\Communication\Plugin\ProductOfferRestWishlistItemsAttributesDeleteStrategyPlugin;
use Spryker\Zed\WishlistsRestApi\WishlistsRestApiDependencyProvider as SprykerWishlistsRestApiDependencyProvider;

class WishlistsRestApiDependencyProvider extends SprykerWishlistsRestApiDependencyProvider
{
    /**
     * @return \Spryker\Zed\WishlistsRestApiExtension\Dependency\Plugin\RestWishlistItemsAttributesDeleteStrategyPluginInterface[]
     */
    protected function getRestWishlistItemsAttributesDeleteStrategyPlugins(): array
    {
        return [
            new ProductOfferRestWishlistItemsAttributesDeleteStrategyPlugin(),
            new EmptyProductOfferRestWishlistItemsAttributesDeleteStrategyPlugin(),
        ];
    }
}
