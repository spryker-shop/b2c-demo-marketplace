<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Business\Reader;

use ArrayObject;
use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadConditionsTransfer;
use Generated\Shared\Transfer\ImportUploadCriteriaTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\SortTransfer;
use Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap;
use Pyz\Zed\MerchantProductImport\MerchantProductImportConfig;
use Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportRepositoryInterface;

class ImportUploadReader implements ImportUploadReaderInterface
{
    private MerchantProductImportConfig $merchantProductImportConfig;

    private MerchantProductImportRepositoryInterface $merchantProductImportRepository;

    public function __construct(
        MerchantProductImportConfig $merchantProductImportConfig,
        MerchantProductImportRepositoryInterface $merchantProductImportRepository,
    ) {
        $this->merchantProductImportConfig = $merchantProductImportConfig;
        $this->merchantProductImportRepository = $merchantProductImportRepository;
    }

    public function get(ImportUploadCriteriaTransfer $importUploadCriteriaTransfer): ImportUploadCollectionTransfer
    {
        return $this->merchantProductImportRepository->get($importUploadCriteriaTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function getLatestPendingImportUploads(): ImportUploadCollectionTransfer
    {
        $sortCollection = new ArrayObject();
        $sortCollection
            ->append(
                (new SortTransfer())
                    ->setField(PyzImportUploadTableMap::COL_CREATED_AT)
                    ->setIsAscending(true),
            );

        $importUploadCriteriaTransfer = (new ImportUploadCriteriaTransfer())
            ->setImportUploadConditions(
                (new ImportUploadConditionsTransfer())
                    ->setStatus(MerchantProductImportConfig::STATUS_PENDING),
            )
            ->setPagination(
                (new PaginationTransfer())
                    ->setLimit($this->merchantProductImportConfig->getImportUploadReadLimit()),
            )
            ->setSortCollection($sortCollection);

        return $this->merchantProductImportRepository->get($importUploadCriteriaTransfer);
    }
}
