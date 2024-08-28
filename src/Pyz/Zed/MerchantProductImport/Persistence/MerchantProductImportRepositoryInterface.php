<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Persistence;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadCriteriaTransfer;

interface MerchantProductImportRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ImportUploadCriteriaTransfer $importUploadCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function get(ImportUploadCriteriaTransfer $importUploadCriteriaTransfer): ImportUploadCollectionTransfer;
}
