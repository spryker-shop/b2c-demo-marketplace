<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence;

use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\ProductImportGuiTableCriteriaTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Orm\Zed\FileUpload\Persistence\Map\PyzFileUploadTableMap;
use Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap;
use Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery;
use Orm\Zed\User\Persistence\Map\SpyUserTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\MerchantProductImportMerchantPortalGuiPersistenceFactory getFactory()
 */
class MerchantProductImportMerchantPortalGuiRepository extends AbstractRepository implements MerchantProductImportMerchantPortalGuiRepositoryInterface
{
    public function getImportUploadTableData(
        ProductImportGuiTableCriteriaTransfer $productImportGuiTableCriteriaTransfer,
    ): ImportUploadCollectionTransfer {
        $pyzImportUploadQuery = $this->buildBaseImportUploadQuery($productImportGuiTableCriteriaTransfer);
        $pyzImportUploadQuery = $this->addImportUploadFilters($pyzImportUploadQuery, $productImportGuiTableCriteriaTransfer);

        $propelModelPager = $pyzImportUploadQuery->paginate(
            $productImportGuiTableCriteriaTransfer->getPageOrFail(),
            $productImportGuiTableCriteriaTransfer->getPageSizeOrFail(),
        );

        $productImportTableDataMapper = $this->getFactory()->createImportUploadTableDataMapper();

        $importUploadCollectionTransfer = $productImportTableDataMapper
            ->mapImportUploadTableDataToImportUploadCollectionTransfer(
                $propelModelPager->getResults()->getData(),
                new ImportUploadCollectionTransfer(),
            );

        $paginationTransfer = $productImportTableDataMapper->mapPropelModelPagerToPaginationTransfer(
            $propelModelPager,
            new PaginationTransfer(),
        );

        $importUploadCollectionTransfer->setPagination($paginationTransfer);

        return $importUploadCollectionTransfer;
    }

    private function buildBaseImportUploadQuery(
        ProductImportGuiTableCriteriaTransfer $productImportGuiTableCriteriaTransfer,
    ): PyzImportUploadQuery {
        $pyzImportUploadQuery = $this->getFactory()->getImportUploadQuery();

        $pyzImportUploadQuery
            ->filterByFkMerchant($productImportGuiTableCriteriaTransfer->getFkMerchant())
            ->joinUser(null, Criteria::LEFT_JOIN)
            ->joinWithPyzFileUpload()
            ->select([
                PyzImportUploadTableMap::COL_ID_IMPORT_UPLOAD,
                PyzImportUploadTableMap::COL_STATUS,
                PyzImportUploadTableMap::COL_STATUS_UPDATED_AT,
                PyzImportUploadTableMap::COL_NUMBER_OF_PRODUCTS_UPLOADED,
                PyzImportUploadTableMap::COL_NUMBER_OF_PRODUCTS_FAILED,
                PyzImportUploadTableMap::COL_ERRORS,
                PyzImportUploadTableMap::COL_CREATED_AT,
                PyzImportUploadTableMap::COL_STARTED_AT,
                PyzImportUploadTableMap::COL_FINISHED_AT,
                SpyUserTableMap::COL_FIRST_NAME,
                SpyUserTableMap::COL_LAST_NAME,
            ])
            ->orderByIdImportUpload(Criteria::DESC);

        $pyzImportUploadQuery = $this->addColumnToTransferMappings($pyzImportUploadQuery);

        return $pyzImportUploadQuery;
    }

    private function addColumnToTransferMappings(
        PyzImportUploadQuery $pyzImportUploadQuery,
    ): PyzImportUploadQuery {
        $totalNumberOfProductsClause = sprintf(
            '(%s + %s)',
            PyzImportUploadTableMap::COL_NUMBER_OF_PRODUCTS_UPLOADED,
            PyzImportUploadTableMap::COL_NUMBER_OF_PRODUCTS_FAILED,
        );

        return $pyzImportUploadQuery
            ->addAsColumn(ImportUploadTransfer::ID_IMPORT_UPLOAD, PyzImportUploadTableMap::COL_ID_IMPORT_UPLOAD)
            ->addAsColumn(ImportUploadTransfer::STATUS, PyzImportUploadTableMap::COL_STATUS)
            ->addAsColumn(ImportUploadTransfer::STATUS_UPDATED_AT, PyzImportUploadTableMap::COL_STATUS_UPDATED_AT)
            ->addAsColumn(ImportUploadTransfer::NUMBER_OF_PRODUCTS_UPLOADED, PyzImportUploadTableMap::COL_NUMBER_OF_PRODUCTS_UPLOADED)
            ->addAsColumn(ImportUploadTransfer::NUMBER_OF_PRODUCTS_FAILED, PyzImportUploadTableMap::COL_NUMBER_OF_PRODUCTS_FAILED)
            ->addAsColumn(ImportUploadTransfer::TOTAL_NUMBER_OF_PRODUCTS, $totalNumberOfProductsClause)
            ->addAsColumn(ImportUploadTransfer::ORIGINAL_FILE_NAME, PyzFileUploadTableMap::COL_ORIGINAL_FILE_NAME)
            ->addAsColumn(ImportUploadTransfer::ERRORS, PyzImportUploadTableMap::COL_ERRORS)
            ->addAsColumn(ImportUploadTransfer::CREATED_AT, PyzImportUploadTableMap::COL_CREATED_AT)
            ->addAsColumn(ImportUploadTransfer::STARTED_AT, PyzImportUploadTableMap::COL_STARTED_AT)
            ->addAsColumn(ImportUploadTransfer::FINISHED_AT, PyzImportUploadTableMap::COL_FINISHED_AT)
            ->addAsColumn(UserTransfer::FIRST_NAME, SpyUserTableMap::COL_FIRST_NAME)
            ->addAsColumn(UserTransfer::LAST_NAME, SpyUserTableMap::COL_LAST_NAME);
    }

    private function addImportUploadFilters(
        PyzImportUploadQuery $pyzImportUploadQuery,
        ProductImportGuiTableCriteriaTransfer $productImportGuiTableCriteriaTransfer,
    ): PyzImportUploadQuery {
        if ($productImportGuiTableCriteriaTransfer->getFilterStatus() !== null) {
            $pyzImportUploadQuery->filterByStatus($productImportGuiTableCriteriaTransfer->getFilterStatus());
        }

        return $pyzImportUploadQuery;
    }
}
