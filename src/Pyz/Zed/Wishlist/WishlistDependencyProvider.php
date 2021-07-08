<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Wishlist;

use Spryker\Client\MerchantProductOfferWishlist\Plugin\Wishlist\WishlistProductOfferCollectionToRemoveExpanderPlugin;
use Spryker\Client\MerchantProductOfferWishlist\Plugin\Wishlist\WishlistProductOfferPostMoveToCartCollectionExpanderPlugin;
use Spryker\Client\MerchantProductWishlist\Plugin\Wishlist\WishlistMerchantProductCollectionToRemoveExpanderPlugin;
use Spryker\Client\MerchantProductWishlist\Plugin\Wishlist\WishlistMerchantProductPostMoveToCartCollectionExpanderPlugin;
use Spryker\Zed\Availability\Communication\Plugin\Wishlist\AvailabilityWishlistItemExpanderPlugin;
use Spryker\Zed\Availability\Communication\Plugin\Wishlist\SellableWishlistItemExpanderPlugin;
use Spryker\Zed\MerchantProductOfferWishlist\Communication\Plugin\Wishlist\MerchantProductOfferAddItemPreCheckPlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\Wishlist\PriceProductWishlistItemExpanderPlugin;
use Spryker\Zed\PriceProductOffer\Communication\Plugin\Wishlist\PriceProductOfferWishlistItemExpanderPlugin;
use Spryker\Zed\ProductDiscontinued\Communication\Plugin\Wishlist\ProductDiscontinuedAddItemPreCheckPlugin;
use Spryker\Zed\Wishlist\WishlistDependencyProvider as SprykerWishlistDependencyProvider;

class WishlistDependencyProvider extends SprykerWishlistDependencyProvider
{
    /**
     * @return \Spryker\Zed\Wishlist\Dependency\Plugin\ItemExpanderPluginInterface[]
     */
    protected function getItemExpanderPlugins()
    {
        return [];
    }

    /**
     * @return \Spryker\Zed\WishlistExtension\Dependency\Plugin\AddItemPreCheckPluginInterface[]
     */
    protected function getAddItemPreCheckPlugins(): array
    {
        return [
            new ProductDiscontinuedAddItemPreCheckPlugin(), #ProductDiscontinuedFeature
            new MerchantProductOfferAddItemPreCheckPlugin(),
        ];
    }

    /**
     * @return \Spryker\Client\WishlistExtension\Dependency\Plugin\WishlistPostMoveToCartCollectionExpanderPluginInterface[]
     */
    protected function getWishlistPostMoveToCartCollectionExpanderPlugins(): array
    {
        return [
            new WishlistProductOfferPostMoveToCartCollectionExpanderPlugin(),
            new WishlistMerchantProductPostMoveToCartCollectionExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Client\WishlistExtension\Dependency\Plugin\WishlistCollectionToRemoveExpanderPluginInterface[]
     */
    protected function getWishlistCollectionToRemoveExpanderPlugins(): array
    {
        return [
            new WishlistProductOfferCollectionToRemoveExpanderPlugin(),
            new WishlistMerchantProductCollectionToRemoveExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\WishlistExtension\Dependency\Plugin\WishlistItemExpanderPluginInterface[]
     */
    protected function getWishlistItemExpanderPlugins(): array
    {
        return [
            new PriceProductWishlistItemExpanderPlugin(),
            new PriceProductOfferWishlistItemExpanderPlugin(),
            new AvailabilityWishlistItemExpanderPlugin(),
            new SellableWishlistItemExpanderPlugin(),
        ];
    }
}
