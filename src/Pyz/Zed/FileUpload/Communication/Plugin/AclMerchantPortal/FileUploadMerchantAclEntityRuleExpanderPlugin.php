<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication\Plugin\AclMerchantPortal;

use Generated\Shared\Transfer\AclEntityRuleTransfer;
use Spryker\Shared\AclEntity\AclEntityConstants;
use Spryker\Zed\AclMerchantPortalExtension\Dependency\Plugin\MerchantAclEntityRuleExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\FileUpload\FileUploadConfig getConfig()
 * @method \Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface getFacade()
 * @method \Pyz\Zed\FileUpload\Communication\FileUploadCommunicationFactory getFactory()
 */
class FileUploadMerchantAclEntityRuleExpanderPlugin extends AbstractPlugin implements MerchantAclEntityRuleExpanderPluginInterface
{
    public function expand(array $aclEntityRuleTransfers): array
    {
        $aclEntityRuleTransfers[] = (new AclEntityRuleTransfer())
            ->setEntity('Orm\Zed\FileUpload\Persistence\PyzFileUpload')
            ->setScope(AclEntityConstants::SCOPE_INHERITED)
            ->setPermissionMask(AclEntityConstants::OPERATION_MASK_CRUD);

        return $aclEntityRuleTransfers;
    }
}
