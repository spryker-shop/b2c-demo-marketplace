<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ProductImportGuiTableCriteriaTransfer;

interface MerchantProductImportMerchantPortalGuiRepositoryInterface
{
    public function getImportUploadTableData(
        ProductImportGuiTableCriteriaTransfer $productImportGuiTableCriteriaTransfer,
    ): ImportUploadCollectionTransfer;
}
