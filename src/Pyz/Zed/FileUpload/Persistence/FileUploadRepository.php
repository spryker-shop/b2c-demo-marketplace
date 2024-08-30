<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Persistence;

use Generated\Shared\Transfer\FileUploadCollectionTransfer;
use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Generated\Shared\Transfer\FileUploadTransfer;
use Orm\Zed\FileUpload\Persistence\PyzFileUploadQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadPersistenceFactory getFactory()
 */
class FileUploadRepository extends AbstractRepository implements FileUploadRepositoryInterface
{
    public function findFileUpload(FileUploadCriteriaTransfer $fileUploadCriteriaTransfer): ?FileUploadTransfer
    {
        $pyzFileUploadQuery = $this->getFactory()->createFileUploadQuery();
        $pyzFileUploadQuery = $this->applyFileUploadQueryCriteria($pyzFileUploadQuery, $fileUploadCriteriaTransfer);

        $pyzFileUploadEntity = $pyzFileUploadQuery->findOne();

        if (!$pyzFileUploadEntity) {
            return null;
        }

        return $this->getFactory()
            ->createFileUploadMapper()
            ->mapEntityToTransfer($pyzFileUploadEntity, new FileUploadTransfer());
    }

    /**
     * @param \Generated\Shared\Transfer\FileUploadCriteriaTransfer $fileUploadCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\FileUploadCollectionTransfer
     */
    public function getFileUploadCollectionByCriteria(FileUploadCriteriaTransfer $fileUploadCriteriaTransfer): FileUploadCollectionTransfer
    {
        $pyzFileUploadQuery = $this->getFactory()->createFileUploadQuery();
        $pyzFileUploadQuery = $this->applyFileUploadQueryCriteria($pyzFileUploadQuery, $fileUploadCriteriaTransfer);

        return new FileUploadCollectionTransfer();
    }

    private function applyFileUploadQueryCriteria(
        PyzFileUploadQuery $pyzFileUploadQuery,
        FileUploadCriteriaTransfer $fileUploadCriteriaTransfer,
    ): PyzFileUploadQuery {
        if ($fileUploadCriteriaTransfer->getIdFileUpload()) {
            $pyzFileUploadQuery->filterByIdFileUpload($fileUploadCriteriaTransfer->getIdFileUpload());
        }

        if ($fileUploadCriteriaTransfer->getWithMerchant()) {
            $pyzFileUploadQuery->leftJoinSpyMerchant();
        }

        if ($fileUploadCriteriaTransfer->getWithUser()) {
            $pyzFileUploadQuery->leftJoinSpyUser();
        }

        if ($fileUploadCriteriaTransfer->getIdMerchant()) {
            $pyzFileUploadQuery->filterByFkMerchant($fileUploadCriteriaTransfer->getIdMerchant());
        }

        if ($fileUploadCriteriaTransfer->getIdUser()) {
            $pyzFileUploadQuery->filterByFkUser($fileUploadCriteriaTransfer->getIdUser());
        }

        return $pyzFileUploadQuery;
    }
}
