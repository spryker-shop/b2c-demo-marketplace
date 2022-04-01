<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductApprovalGui;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProductApprovalGuiConfig extends AbstractBundleConfig
{
    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::STATUS_WAITING_FOR_APPROVAL
     *
     * @var string
     */
    protected const STATUS_WAITING_FOR_APPROVAL = 'waiting_for_approval';

    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::STATUS_APPROVED
     *
     * @var string
     */
    protected const STATUS_APPROVED = 'approved';

    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::STATUS_DENIED
     *
     * @var string
     */
    protected const STATUS_DENIED = 'denied';

    /**
     * @uses \Spryker\Shared\ProductApproval\ProductApprovalConfig::STATUS_DRAFT
     *
     * @var string
     */
    protected const STATUS_DRAFT = 'draft';

    /**
     * @param string $currentStatus
     *
     * @return array<string>
     */
    public function getApplicableApprovalStatuses(string $currentStatus): array
    {
        return $this->getStatusTree()[$currentStatus] ?? [];
    }

    /**
     * @return array<string, array<string>>
     */
    protected function getStatusTree(): array
    {
        return [
            static::STATUS_WAITING_FOR_APPROVAL => [
                static::STATUS_APPROVED,
                static::STATUS_DENIED,
            ],
            static::STATUS_APPROVED => [
                static::STATUS_DENIED,
            ],
            static::STATUS_DENIED => [
                static::STATUS_APPROVED,
            ],
            static::STATUS_DRAFT => [
                static::STATUS_APPROVED,
                static::STATUS_DENIED,
            ],
        ];
    }
}
