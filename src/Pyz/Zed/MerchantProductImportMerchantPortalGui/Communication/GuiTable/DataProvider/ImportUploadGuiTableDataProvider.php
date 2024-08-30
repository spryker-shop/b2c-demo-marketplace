<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\GuiTable\DataProvider;

use Generated\Shared\Transfer\GuiTableDataRequestTransfer;
use Generated\Shared\Transfer\GuiTableDataResponseTransfer;
use Generated\Shared\Transfer\GuiTableRowDataResponseTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\ProductImportGuiTableCriteriaTransfer;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\ImportUploadGuiTableConfigurationProvider;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\MerchantProductImportMerchantPortalGuiRepositoryInterface;
use Spryker\Shared\GuiTable\DataProvider\AbstractGuiTableDataProvider;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

class ImportUploadGuiTableDataProvider extends AbstractGuiTableDataProvider
{
    private MerchantProductImportMerchantPortalGuiRepositoryInterface $productImportMerchantPortalGuiRepository;

    private MerchantUserFacadeInterface $merchantUserFacade;

    public function __construct(
        MerchantProductImportMerchantPortalGuiRepositoryInterface $productImportMerchantPortalGuiRepository,
        MerchantUserFacadeInterface $merchantUserFacade,
    ) {
        $this->productImportMerchantPortalGuiRepository = $productImportMerchantPortalGuiRepository;
        $this->merchantUserFacade = $merchantUserFacade;
    }

    /**
     * @inheritDoc
     */
    protected function createCriteria(GuiTableDataRequestTransfer $guiTableDataRequestTransfer): AbstractTransfer
    {
        return (new ProductImportGuiTableCriteriaTransfer())
            ->setFkMerchant($this->merchantUserFacade->getCurrentMerchantUser()->getIdMerchant());
    }

    /**
     * @inheritDoc
     *
     * @param \Generated\Shared\Transfer\ProductImportGuiTableCriteriaTransfer $criteriaTransfer
     */
    protected function fetchData(AbstractTransfer $criteriaTransfer): GuiTableDataResponseTransfer
    {
        $importUploadCollectionTransfer = $this->productImportMerchantPortalGuiRepository
            ->getImportUploadTableData($criteriaTransfer);

        $guiTableDataResponseTransfer = new GuiTableDataResponseTransfer();
        foreach ($importUploadCollectionTransfer->getImportUploads() as $importUploadTransfer) {
            $guiTableDataResponseTransfer->addRow($this->createGuiTableRowDataResponseTransfer($importUploadTransfer));
        }

        $guiTableDataResponseTransfer = $this->setPaginationData(
            $guiTableDataResponseTransfer,
            $importUploadCollectionTransfer->getPagination(),
        );

        return $guiTableDataResponseTransfer;
    }

    private function createGuiTableRowDataResponseTransfer(
        ImportUploadTransfer $importUploadTransfer,
    ): GuiTableRowDataResponseTransfer {
        return (new GuiTableRowDataResponseTransfer())->setResponseData([
            ImportUploadGuiTableConfigurationProvider::COL_ID_OWNER => $this->getOwnerColumnData($importUploadTransfer),
            ImportUploadGuiTableConfigurationProvider::COL_ID_ORIGINAL_FILE_NAME => $importUploadTransfer->getOriginalFileName(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_UPLOAD_TIME => $importUploadTransfer->getCreatedAt(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_PROCESSING_START_TIME => $importUploadTransfer->getStartedAt(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_PROCESSING_FINISH_TIME => $importUploadTransfer->getFinishedAt(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_TOTAL_NUMBER_OF_PRODUCTS => $importUploadTransfer->getTotalNumberOfProducts(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_NUMBER_OF_PRODUCTS_UPLOADED => $importUploadTransfer->getNumberOfProductsUploaded(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_NUMBER_OF_PRODUCTS_FAILED => $importUploadTransfer->getNumberOfProductsFailed(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_STATUS => $importUploadTransfer->getStatus(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_STATUS_UPDATED_TIME => $importUploadTransfer->getStatusUpdatedAt(),
            ImportUploadGuiTableConfigurationProvider::COL_ID_ERRORS => $this->getErrorsColumnData($importUploadTransfer),
        ]);
    }

    private function setPaginationData(
        GuiTableDataResponseTransfer $guiTableDataResponseTransfer,
        PaginationTransfer $paginationTransfer,
    ): GuiTableDataResponseTransfer {
        return $guiTableDataResponseTransfer
            ->setPage($paginationTransfer->getPageOrFail())
            ->setPageSize($paginationTransfer->getMaxPerPageOrFail())
            ->setTotal($paginationTransfer->getNbResultsOrFail());
    }

    private function getOwnerColumnData(ImportUploadTransfer $importUploadTransfer): string
    {
        return sprintf(
            '%s %s',
            $importUploadTransfer->getUser()->getFirstName(),
            $importUploadTransfer->getUser()->getLastName(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadTransfer $importUploadTransfer
     *
     * @return array<string>
     */
    private function getErrorsColumnData(ImportUploadTransfer $importUploadTransfer): array
    {
        return explode("\n", $importUploadTransfer->getErrors());
    }
}
