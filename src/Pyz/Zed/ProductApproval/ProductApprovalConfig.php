<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductApproval;

use Spryker\Shared\ProductApproval\ProductApprovalConfig as SharedProductApprovalConfig;
use Spryker\Zed\ProductApproval\ProductApprovalConfig as SprykerProductApprovalConfig;

class ProductApprovalConfig extends SprykerProductApprovalConfig
{
    /**
     * @return array<string, array<string>>
     */
    public function getStatusTree(): array
    {
        return [
            SharedProductApprovalConfig::STATUS_WAITING_FOR_APPROVAL => [
                SharedProductApprovalConfig::STATUS_APPROVED,
                SharedProductApprovalConfig::STATUS_DENIED,
            ],
            SharedProductApprovalConfig::STATUS_APPROVED => [
                SharedProductApprovalConfig::STATUS_DENIED,
            ],
            SharedProductApprovalConfig::STATUS_DENIED => [
                SharedProductApprovalConfig::STATUS_APPROVED,
            ],
            SharedProductApprovalConfig::STATUS_DRAFT => [
                SharedProductApprovalConfig::STATUS_APPROVED,
                SharedProductApprovalConfig::STATUS_DENIED,
            ],
        ];
    }
}
