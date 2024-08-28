<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\Mapper;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Propel\Runtime\Util\PropelModelPager;

interface ImportUploadTableDataMapperInterface
{
    /**
     * @param array<array<string, mixed>> $importUploadTableData
     * @param \Generated\Shared\Transfer\ImportUploadCollectionTransfer $importUploadCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function mapImportUploadTableDataToImportUploadCollectionTransfer(
        array $importUploadTableData,
        ImportUploadCollectionTransfer $importUploadCollectionTransfer,
    ): ImportUploadCollectionTransfer;

    /**
     * @param array<string, mixed> $importUpload
     * @param \Generated\Shared\Transfer\ImportUploadTransfer $importUploadTransfer
     *
     * @return \Generated\Shared\Transfer\ImportUploadTransfer
     */
    public function mapImportUploadArrayToImportUploadTransfer(
        array $importUpload,
        ImportUploadTransfer $importUploadTransfer,
    ): ImportUploadTransfer;

    public function mapPropelModelPagerToPaginationTransfer(
        PropelModelPager $propelModelPager,
        PaginationTransfer $paginationTransfer,
    ): PaginationTransfer;
}
