<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductApprovalGui\Dependency\Facade;

use Spryker\Zed\ProductApprovalGui\Dependency\Facade\ProductApprovalGuiToProductApprovalFacadeInterface;

class ProductApprovalGuiToProductApprovalFacadeBridge implements ProductApprovalGuiToProductApprovalFacadeInterface
{
    /**
     * @var \Pyz\Zed\ProductApprovalGui\ProductApprovalGuiConfig
     */
    protected $productApprovalGuiConfig;

    /**
     * @param \Pyz\Zed\ProductApprovalGui\ProductApprovalGuiConfig $productApprovalGuiConfig
     */
    public function __construct($productApprovalGuiConfig)
    {
        $this->productApprovalGuiConfig = $productApprovalGuiConfig;
    }

    /**
     * @param string $currentStatus
     *
     * @return array<string>
     */
    public function getApplicableApprovalStatuses(string $currentStatus): array
    {
        return $this->productApprovalGuiConfig->getApplicableApprovalStatuses($currentStatus);
    }
}
