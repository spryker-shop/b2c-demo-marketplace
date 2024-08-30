<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantProductImport\Persistence;

use Generated\Shared\Transfer\ImportUploadCollectionTransfer;
use Generated\Shared\Transfer\ImportUploadCriteriaTransfer;
use Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\MerchantProductImport\Persistence\MerchantProductImportPersistenceFactory getFactory()
 */
class MerchantProductImportRepository extends AbstractRepository implements MerchantProductImportRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ImportUploadCriteriaTransfer $importUploadCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\ImportUploadCollectionTransfer
     */
    public function get(ImportUploadCriteriaTransfer $importUploadCriteriaTransfer): ImportUploadCollectionTransfer
    {
        $importUploadQuery = $this->getFactory()->createImportUploadPropelQuery();

        $importUploadQuery = $this->applyCriteria($importUploadCriteriaTransfer, $importUploadQuery);
        $importUploadQuery = $this->applySortings($importUploadCriteriaTransfer, $importUploadQuery);
        $importUploadQuery = $this->applyPagination($importUploadCriteriaTransfer, $importUploadQuery);

        /** @var \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\MerchantProductImport\Persistence\Base\PyzImportUpload> $pyzImportUploadEntityCollection */
        $pyzImportUploadEntityCollection = $importUploadQuery->find();

        return $this->getFactory()->createImportUploadMapper()
            ->mapImportUploadEntityCollectionToImportUploadCollectionTransfer($pyzImportUploadEntityCollection);
    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadCriteriaTransfer $importUploadCriteriaTransfer
     * @param \Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery $importUploadQuery
     *
     * @return \Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery
     */
    private function applyCriteria(
        ImportUploadCriteriaTransfer $importUploadCriteriaTransfer,
        PyzImportUploadQuery $importUploadQuery,
    ): PyzImportUploadQuery {
        $importUploadConditionsTransfer = $importUploadCriteriaTransfer->getImportUploadConditions();

        if ($importUploadConditionsTransfer === null) {
            return $importUploadQuery;
        }

        if ($importUploadConditionsTransfer->getIdImportUpload() !== null) {
            $importUploadQuery->filterByIdImportUpload($importUploadConditionsTransfer->getIdImportUpload());
        }

        if ($importUploadConditionsTransfer->getIdMerchant() !== null) {
            $importUploadQuery->filterByFkMerchant($importUploadConditionsTransfer->getIdMerchant());
        }

        if ($importUploadConditionsTransfer->getIdUser() !== null) {
            $importUploadQuery->filterByFkUser($importUploadConditionsTransfer->getIdUser());
        }

        if ($importUploadConditionsTransfer->getStatus() !== null) {
            $importUploadQuery->filterByStatus($importUploadConditionsTransfer->getStatus());
        }

        return $importUploadQuery;
    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadCriteriaTransfer $importUploadCriteriaTransfer
     * @param \Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery $pyzImportUploadQuery
     *
     * @return \Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery
     */
    private function applySortings(
        ImportUploadCriteriaTransfer $importUploadCriteriaTransfer,
        PyzImportUploadQuery $pyzImportUploadQuery,
    ): PyzImportUploadQuery {
        foreach ($importUploadCriteriaTransfer->getSortCollection() as $sortTransfer) {
            $pyzImportUploadQuery->orderBy(
                $sortTransfer->getField(),
                $sortTransfer->getIsAscending() ? Criteria::ASC : Criteria::DESC,
            );
        }

        return $pyzImportUploadQuery;
    }

    /**
     * @param \Generated\Shared\Transfer\ImportUploadCriteriaTransfer $importUploadCriteriaTransfer
     * @param \Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery $pyzImportUploadQuery
     *
     * @return \Orm\Zed\MerchantProductImport\Persistence\PyzImportUploadQuery
     */
    private function applyPagination(
        ImportUploadCriteriaTransfer $importUploadCriteriaTransfer,
        PyzImportUploadQuery $pyzImportUploadQuery,
    ): PyzImportUploadQuery {
        $paginationTransfer = $importUploadCriteriaTransfer->getPagination();

        if ($paginationTransfer === null) {
            return $pyzImportUploadQuery;
        }

        $paginationTransfer->setNbResults($pyzImportUploadQuery->count());

        if ($paginationTransfer->getLimit() !== null) {
            $pyzImportUploadQuery
                ->setLimit($paginationTransfer->getLimit());
        }

        if ($paginationTransfer->getOffset() !== null) {
            $pyzImportUploadQuery
                ->setOffset($paginationTransfer->getOffset());
        }

        return $pyzImportUploadQuery;
    }
}
