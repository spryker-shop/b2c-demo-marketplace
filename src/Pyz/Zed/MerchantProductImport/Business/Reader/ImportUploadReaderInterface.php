<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Business\Reader;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadCriteriaTransfer;

interface ImportUploadReaderInterface
{
    public function get(ImportUploadCriteriaTransfer $importUploadCriteriaTransfer): ImportUploadCollectionTransfer;

    /**
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function getLatestPendingImportUploads(): ImportUploadCollectionTransfer;
}
