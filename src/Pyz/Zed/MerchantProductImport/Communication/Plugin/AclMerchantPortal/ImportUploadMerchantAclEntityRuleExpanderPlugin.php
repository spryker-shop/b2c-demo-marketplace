<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Communication\Plugin\AclMerchantPortal;

use Generated\Shared\Transfer\AclEntityRuleTransfer;
use Spryker\Zed\AclMerchantPortalExtension\Dependency\Plugin\MerchantAclEntityRuleExpanderPluginInterface;

class ImportUploadMerchantAclEntityRuleExpanderPlugin implements MerchantAclEntityRuleExpanderPluginInterface
{
    /**
     * @uses {@link \Spryker\Shared\AclEntity\AclEntityConstants::SCOPE_INHERITED}
     *
     * @var string
     */
    private const SCOPE_INHERITED = 'inherited';

    /**
     * @uses {@link \Spryker\Shared\AclEntity\AclEntityConstants::OPERATION_MASK_READ}
     *
     * @var int
     */
    private const OPERATION_MASK_READ = 0b1;

    /**
     * @uses {@link \Spryker\Shared\AclEntity\AclEntityConstants::OPERATION_MASK_CREATE}
     *
     * @var int
     */
    private const OPERATION_MASK_CREATE = 0b10;

    /**
     * @inheritDoc
     */
    public function expand(array $aclEntityRuleTransfers): array
    {
        $aclEntityRuleTransfers[] = (new AclEntityRuleTransfer())
            ->setEntity('Orm\Zed\MerchantProductImport\Persistence\PyzImportUpload')
            ->setScope(self::SCOPE_INHERITED)
            ->setPermissionMask(self::OPERATION_MASK_READ | self::OPERATION_MASK_CREATE);

        return $aclEntityRuleTransfers;
    }
}
