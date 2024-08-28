<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Communication\GuiTable\DataProvider;

use DateTime;
use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\GuiTableDataRequestTransfer;
use Generated\Shared\Transfer\GuiTableDataResponseTransfer;
use Generated\Shared\Transfer\GuiTableRowDataResponseTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Pyz\Zed\FileUpload\Business\FileUploadFacadeInterface;
use Pyz\Zed\FileUploadMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\FileUploadGuiTableConfigurationProvider;
use Pyz\Zed\FileUploadMerchantPortalGui\Persistence\FileUploadMerchantPortalGuiRepositoryInterface;
use Spryker\Shared\GuiTable\DataProvider\AbstractGuiTableDataProvider;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\MerchantUser\Business\MerchantUserFacadeInterface;

class FileUploadGuiTableDataProvider extends AbstractGuiTableDataProvider
{
    private const KIB_BYTES = 1024;

    private const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    private MerchantUserFacadeInterface $merchantUserFacade;

    private FileUploadFacadeInterface $fileUploadFacade;

    private FileUploadMerchantPortalGuiRepositoryInterface $repository;

    public function __construct(
        MerchantUserFacadeInterface $merchantUserFacade,
        FileUploadFacadeInterface $fileUploadFacade,
        FileUploadMerchantPortalGuiRepositoryInterface $repository,
    ) {
        $this->merchantUserFacade = $merchantUserFacade;
        $this->fileUploadFacade = $fileUploadFacade;
        $this->repository = $repository;
    }

    protected function createCriteria(GuiTableDataRequestTransfer $guiTableDataRequestTransfer): AbstractTransfer
    {
        $fileUploadCriteriaTransfer = (new FileUploadCriteriaTransfer())
            ->fromArray($guiTableDataRequestTransfer->toArray(), true);

        $currentMerchantId = $this->merchantUserFacade->getCurrentMerchantUser()->getIdMerchant();
        $fileUploadCriteriaTransfer
            ->setIdMerchant($currentMerchantId)
            ->setWithUser(true);

        return $fileUploadCriteriaTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\FileUploadCriteriaTransfer $criteriaTransfer
     *
     * @return \Generated\Shared\Transfer\GuiTableDataResponseTransfer
     */
    protected function fetchData(AbstractTransfer $criteriaTransfer): GuiTableDataResponseTransfer
    {
        $fileUploadCollectionTransfer = $this->repository->getFileUploadTableData($criteriaTransfer);

        $guiTableDataResponseTransfer = new GuiTableDataResponseTransfer();
        foreach ($fileUploadCollectionTransfer->getFileUploads() as $fileUploadTransfer) {
            $rowDataResponseTransfer = $this->createGuiTableRowDataResponseTransfer($fileUploadTransfer);
            $guiTableDataResponseTransfer->addRow($rowDataResponseTransfer);
        }

        $guiTableDataResponseTransfer = $this->setPaginationData(
            $guiTableDataResponseTransfer,
            $fileUploadCollectionTransfer->getPagination(),
        );

        return $guiTableDataResponseTransfer;
    }

    private function createGuiTableRowDataResponseTransfer(
        FileUploadTransfer $fileUploadTransfer,
    ): GuiTableRowDataResponseTransfer {
        return (new GuiTableRowDataResponseTransfer())->setResponseData([
            FileUploadTransfer::ID_FILE_UPLOAD => $fileUploadTransfer->getIdFileUpload(),
            FileUploadGuiTableConfigurationProvider::COL_USER_EMAIL => $fileUploadTransfer->getUser()?->getUsername(),
            FileUploadGuiTableConfigurationProvider::COL_CDN_URL => $fileUploadTransfer->getCdnUrl(),
            FileUploadGuiTableConfigurationProvider::COL_CONTENT_TYPE => $this->fileUploadFacade
                ->resolveFileTypeByContentType($fileUploadTransfer->getContentType()),
            FileUploadGuiTableConfigurationProvider::COL_SIZE => $this->formatFileSize($fileUploadTransfer->getSize()),
            FileUploadGuiTableConfigurationProvider::COL_CREATED_AT => $this->formatDateTime($fileUploadTransfer->getCreatedAt()),
        ]);
    }

    private function formatDateTime(string $dateTime): string
    {
        return (new DateTime($dateTime))->format(self::DATE_TIME_FORMAT);
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

    private function formatFileSize(int $size): int
    {
        return (int)($size / self::KIB_BYTES);
    }
}
