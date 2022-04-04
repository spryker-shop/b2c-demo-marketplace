<?php

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
    public function getApplicableApprovalStatuses(string $currentStatus): array
    {
        return $this->getStatusTree()[$currentStatus];
    }

    /**
     * @return array<string, array<string>>
     */
    protected function getStatusTree(): array
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
