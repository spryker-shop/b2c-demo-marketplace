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

interface MerchantProductImportFacadeInterface
{
    public function createImportUpload(FileUploadTransfer $fileUploadTransfer): ImportUploadResponseTransfer;

    /**
     * Specification:
     * - Updates an existing import upload entity.
     * - Runs `PyzImportUpload.preSave()` to set `PyzImportUpload.statusUpdatedAt`
     *
     * @param \Generated\Shared\Transfer\ImportUploadTransfer $importUploadTransfer
     *
     * @return \Generated\Shared\Transfer\ImportUploadResponseTransfer
     */
    public function updateImportUpload(ImportUploadTransfer $importUploadTransfer): ImportUploadResponseTransfer;

    public function getImportUploads(
        ImportUploadCriteriaTransfer $importUploadCriteriaTransfer,
    ): ImportUploadCollectionTransfer;
}
