<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Business\Writer;

use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadResponseTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;

interface ImportUploadWriterInterface
{
    public function createImportUpload(FileUploadTransfer $fileUploadTransfer): ImportUploadResponseTransfer;

    public function updateImportUpload(ImportUploadTransfer $importUploadTransfer): ImportUploadResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\ImportUploadCollectionTransfer $importUploadCollectionTransfer
     * @param string $status
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function updateImportUploadsCollectionStatus(
        ImportUploadCollectionTransfer $importUploadCollectionTransfer,
        string $status,
    ): ImportUploadCollectionTransfer;
}
