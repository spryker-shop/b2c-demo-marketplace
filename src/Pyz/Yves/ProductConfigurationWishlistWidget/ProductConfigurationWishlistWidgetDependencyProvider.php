<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ProductConfigurationWishlistWidget;

use SprykerShop\Yves\DateTimeConfiguratorPageExample\Plugin\ProductConfigurationWishlistWidget\ExampleDateTimeWishlistItemProductConfigurationRenderStrategyPlugin;
use SprykerShop\Yves\ProductConfigurationWishlistWidget\ProductConfigurationWishlistWidgetDependencyProvider as SprykerProductConfigurationWishlistWidgetDependencyProvider;

class ProductConfigurationWishlistWidgetDependencyProvider extends SprykerProductConfigurationWishlistWidgetDependencyProvider
{
    /**
     * @return array<\SprykerShop\Yves\ProductConfigurationWishlistWidgetExtension\Dependency\Plugin\WishlistItemProductConfigurationRenderStrategyPluginInterface>
     */
    protected function getWishlistItemProductConfigurationRenderStrategyPlugins(): array
    {
        return [
            new ExampleDateTimeWishlistItemProductConfigurationRenderStrategyPlugin(),
        ];
    }
}
