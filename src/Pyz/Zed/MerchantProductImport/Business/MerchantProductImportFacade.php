<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Business;

use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadCriteriaTransfer;
use Generated\Shared\Transfer\ImportUploadResponseTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\MerchantProductImport\MerchantProductImportConfig getConfig()
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportRepositoryInterface getRepository()
 * @method \Pyz\Zed\MerchantProductImport\Business\MerchantProductImportBusinessFactory getFactory()
 */
class MerchantProductImportFacade extends AbstractFacade implements MerchantProductImportFacadeInterface
{
    public function createImportUpload(FileUploadTransfer $fileUploadTransfer): ImportUploadResponseTransfer
    {
        return $this->getFactory()
            ->createImportUploadWriter()
            ->createImportUpload($fileUploadTransfer);
    }

    public function updateImportUpload(ImportUploadTransfer $importUploadTransfer): ImportUploadResponseTransfer
    {
        return $this->getFactory()
            ->createImportUploadWriter()
            ->updateImportUpload($importUploadTransfer);
    }

    public function getImportUploads(
        ImportUploadCriteriaTransfer $importUploadCriteriaTransfer,
    ): ImportUploadCollectionTransfer {
        return $this->getFactory()
            ->createImportUploadReader()
            ->get($importUploadCriteriaTransfer);
    }
}
