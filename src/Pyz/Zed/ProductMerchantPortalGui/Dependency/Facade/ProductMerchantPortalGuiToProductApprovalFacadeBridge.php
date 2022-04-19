<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductApprovalFacadeInterface;

class ProductMerchantPortalGuiToProductApprovalFacadeBridge implements ProductMerchantPortalGuiToProductApprovalFacadeInterface
{
    /**
     * @var \Pyz\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig
     */
    protected $productMerchantPortalGuiConfig;

    /**
     * @param \Pyz\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig $productMerchantPortalGuiConfig
     */
    public function __construct($productMerchantPortalGuiConfig)
    {
        $this->productMerchantPortalGuiConfig = $productMerchantPortalGuiConfig;
    }

    /**
     * @param string $currentStatus
     *
     * @return array<string>
     */
    public function getApplicableApprovalStatuses(string $currentStatus): array
    {
        return $this->productMerchantPortalGuiConfig->getApplicableApprovalStatuses($currentStatus);
    }
}
