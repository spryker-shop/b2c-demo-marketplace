<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductMerchantPortalGui;

use Spryker\Shared\ProductApproval\ProductApprovalConfig as SharedProductApprovalConfig;
use Spryker\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig as SprykerProductMerchantPortalGuiConfig;

class ProductMerchantPortalGuiConfig extends SprykerProductMerchantPortalGuiConfig
{
    /**
     * @param string $currentStatus
     *
     * @return array<string>
     */
    public function getPyzApplicableApprovalStatuses(string $currentStatus): array
    {
        return $this->getPyzStatusTree()[$currentStatus];
    }

    /**
     * @return array<string, array<string>>
     */
    protected function getPyzStatusTree(): array
    {
        return [
            SharedProductApprovalConfig::STATUS_WAITING_FOR_APPROVAL => [
                SharedProductApprovalConfig::STATUS_APPROVED,
                SharedProductApprovalConfig::STATUS_DENIED,
                SharedProductApprovalConfig::STATUS_DRAFT,
            ],
            SharedProductApprovalConfig::STATUS_APPROVED => [
                SharedProductApprovalConfig::STATUS_DENIED,
                SharedProductApprovalConfig::STATUS_DRAFT,
            ],
            SharedProductApprovalConfig::STATUS_DENIED => [
                SharedProductApprovalConfig::STATUS_APPROVED,
                SharedProductApprovalConfig::STATUS_DRAFT,
            ],
            SharedProductApprovalConfig::STATUS_DRAFT => [
                SharedProductApprovalConfig::STATUS_APPROVED,
                SharedProductApprovalConfig::STATUS_WAITING_FOR_APPROVAL,
                SharedProductApprovalConfig::STATUS_DENIED,
            ],
        ];
    }
}
