<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\FileUploadCollectionTransfer;
use Generated\Shared\Transfer\FileUploadTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Orm\Zed\FileUpload\Persistence\PyzFileUpload;
use Propel\Runtime\Util\PropelModelPager;

class FileUploadTableDataMapper implements FileUploadTableDataMapperInterface
{
    public function mapDataToFileUploadCollectionTransfer(array $data): FileUploadCollectionTransfer
    {
        $fileUploadCollectionTransfer = $this->createFileUploadCollectionTransfer();
        foreach ($data as $fileUploadData) {
            $fileUploadTransfer = $this->mapFileUploadDataToTransfer($fileUploadData);
            $fileUploadCollectionTransfer->addFileUpload($fileUploadTransfer);
        }

        return $fileUploadCollectionTransfer;
    }

    public function mapPropelModelPagerToPaginationTransfer(PropelModelPager $propelModelPager): PaginationTransfer
    {
        return $this->createPaginationTransfer()
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

    private function mapFileUploadDataToTransfer(PyzFileUpload $pyzFileUpload): FileUploadTransfer
    {
        $fileUploadTransfer = $this->createFileUploadTransfer()
            ->fromArray($pyzFileUpload->toArray(), true);
        $userTransfer = $this->createHydratedUserTransfer($pyzFileUpload->getVirtualColumn(UserTransfer::USERNAME));
        $fileUploadTransfer->setUser($userTransfer);

        return $fileUploadTransfer;
    }

    private function createHydratedUserTransfer(?string $username): UserTransfer
    {
        return (new UserTransfer())->setUsername($username);
    }

    private function createFileUploadTransfer(): FileUploadTransfer
    {
        return new FileUploadTransfer();
    }

    private function createFileUploadCollectionTransfer(): FileUploadCollectionTransfer
    {
        return new FileUploadCollectionTransfer();
    }

    private function createPaginationTransfer(): PaginationTransfer
    {
        return new PaginationTransfer();
    }
}
