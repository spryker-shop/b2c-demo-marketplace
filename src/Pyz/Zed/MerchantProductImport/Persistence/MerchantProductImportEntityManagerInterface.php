<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Persistence;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;

interface MerchantProductImportEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ImportUploadCollectionTransfer $importUploadCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function saveImportUploadCollection(ImportUploadCollectionTransfer $importUploadCollectionTransfer): ImportUploadCollectionTransfer;

    public function updateImportUpload(ImportUploadTransfer $importUploadTransfer): void;
}
