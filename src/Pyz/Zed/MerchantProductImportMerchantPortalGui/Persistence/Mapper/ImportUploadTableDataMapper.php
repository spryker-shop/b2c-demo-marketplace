<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImportMerchantPortalGui\Persistence\Mapper;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Orm\Zed\MerchantProductImport\Persistence\Map\PyzImportUploadTableMap;
use Propel\Runtime\Util\PropelModelPager;
use Pyz\Zed\MerchantProductImportMerchantPortalGui\MerchantProductImportMerchantPortalGuiConfig;

class ImportUploadTableDataMapper implements ImportUploadTableDataMapperInterface
{
    private MerchantProductImportMerchantPortalGuiConfig $config;

    public function __construct(MerchantProductImportMerchantPortalGuiConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function mapImportUploadTableDataToImportUploadCollectionTransfer(
        array $importUploadTableData,
        ImportUploadCollectionTransfer $importUploadCollectionTransfer,
    ): ImportUploadCollectionTransfer {
        foreach ($importUploadTableData as $importUpload) {
            $importUploadTransfer = $this->mapImportUploadArrayToImportUploadTransfer(
                $importUpload,
                new ImportUploadTransfer(),
            );

            $importUploadCollectionTransfer->addImportUpload($importUploadTransfer);
        }

        return $importUploadCollectionTransfer;
    }

    /**
     * @inheritDoc
     */
    public function mapImportUploadArrayToImportUploadTransfer(
        array $importUpload,
        ImportUploadTransfer $importUploadTransfer,
    ): ImportUploadTransfer {
        $importUploadTransfer = $importUploadTransfer->fromArray($importUpload, true);
        $importUploadTransfer->setStatus($this->mapStatusRawToLabel($importUpload[PyzImportUploadTableMap::COL_STATUS]));

        $userTransfer = (new UserTransfer())->fromArray($importUpload, true);

        $importUploadTransfer->setUser($userTransfer);

        return $importUploadTransfer;
    }

    public function mapPropelModelPagerToPaginationTransfer(
        PropelModelPager $propelModelPager,
        PaginationTransfer $paginationTransfer,
    ): PaginationTransfer {
        return $paginationTransfer
            ->setNbResults($propelModelPager->getNbResults())
            ->setPage($propelModelPager->getPage())
            ->setMaxPerPage($propelModelPager->getMaxPerPage())
            ->setFirstIndex($propelModelPager->getFirstIndex())
            ->setFirstIndex($propelModelPager->getFirstIndex())
            ->setLastIndex($propelModelPager->getLastIndex())
            ->setFirstPage($propelModelPager->getFirstPage())
            ->setLastPage($propelModelPager->getLastPage())
            ->setNextPage($propelModelPager->getNextPage())
            ->setPreviousPage($propelModelPager->getPreviousPage());
    }

    private function mapStatusRawToLabel(string $statusRaw): ?string
    {
        $valueSet = PyzImportUploadTableMap::getValueSet(PyzImportUploadTableMap::COL_STATUS);
        $status = $valueSet[array_search($statusRaw, array_keys($valueSet))];
        $statusEnumToLabelMap = $this->config->getStatusEnumValueToLabelMap();

        return $statusEnumToLabelMap[$status] ?? null;
    }
}
