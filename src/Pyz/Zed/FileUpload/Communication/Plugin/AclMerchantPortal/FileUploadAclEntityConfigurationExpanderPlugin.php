<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Communication\Plugin\AclMerchantPortal;

use Generated\Shared\Transfer\AclEntityMetadataConfigTransfer;
use Generated\Shared\Transfer\AclEntityMetadataTransfer;
use Generated\Shared\Transfer\AclEntityParentMetadataTransfer;
use Spryker\Zed\AclMerchantPortalExtension\Dependency\Plugin\AclEntityConfigurationExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\FileUpload\FileUploadConfig getConfig()
 * @method \Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface getFacade()
 * @method \Pyz\Zed\FileUpload\Communication\FileUploadCommunicationFactory getFactory()
 */
class FileUploadAclEntityConfigurationExpanderPlugin extends AbstractPlugin implements AclEntityConfigurationExpanderPluginInterface
{
    public function expand(AclEntityMetadataConfigTransfer $aclEntityMetadataConfigTransfer): AclEntityMetadataConfigTransfer
    {
        $aclEntityMetadataConfigTransfer
            ->getAclEntityMetadataCollectionOrFail()
            ->addAclEntityMetadata(
                'Orm\Zed\FileUpload\Persistence\PyzFileUpload',
                (new AclEntityMetadataTransfer())
                    ->setEntityName('Orm\Zed\FileUpload\Persistence\PyzFileUpload')
                    ->setParent((new AclEntityParentMetadataTransfer())
                        ->setEntityName('Orm\Zed\Merchant\Persistence\SpyMerchant')),
            );

        return $aclEntityMetadataConfigTransfer;
    }
}
