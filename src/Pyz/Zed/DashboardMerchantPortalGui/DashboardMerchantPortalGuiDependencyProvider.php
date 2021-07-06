<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DashboardMerchantPortalGui;

use Spryker\Zed\DashboardMerchantPortalGui\DashboardMerchantPortalGuiDependencyProvider as SprykerDashboardMerchantPortalGuiDependencyProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Plugin\DashboardMerchantPortalGui\OffersMerchantDashboardCardPlugin;

class DashboardMerchantPortalGuiDependencyProvider extends SprykerDashboardMerchantPortalGuiDependencyProvider
{
    /**
     * @return \Spryker\Zed\DashboardMerchantPortalGuiExtension\Dependency\Plugin\MerchantDashboardCardPluginInterface[]
     */
    protected function getDashboardCardPlugins(): array
    {
        return [
            new OffersMerchantDashboardCardPlugin(),
        ];
    }
}
