<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Persistence;

use Generated\Shared\Transfer\FileUploadCollectionTransfer;
use Generated\Shared\Transfer\FileUploadCriteriaTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Orm\Zed\FileUpload\Persistence\PyzFileUploadQuery;
use Orm\Zed\User\Persistence\Map\SpyUserTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Persistence\FileUploadMerchantPortalGuiPersistenceFactory getFactory()
 */
class FileUploadMerchantPortalGuiRepository extends AbstractRepository implements FileUploadMerchantPortalGuiRepositoryInterface
{
    public function getFileUploadTableData(
        FileUploadCriteriaTransfer $fileUploadCriteriaTransfer,
    ): FileUploadCollectionTransfer {
        $query = $this->buildBaseFileUploadQuery($fileUploadCriteriaTransfer);
        $propelModelPager = $query->paginate(
            $fileUploadCriteriaTransfer->getPageOrFail(),
            $fileUploadCriteriaTransfer->getPageSizeOrFail(),
        );

        $mapper = $this->getFactory()->createFileUploadTableDataMapper();
        $fileUploadCollectionTransfer = $mapper->mapDataToFileUploadCollectionTransfer($propelModelPager->getResults()->getData());
        $paginationTransfer = $mapper->mapPropelModelPagerToPaginationTransfer($propelModelPager);
        $fileUploadCollectionTransfer->setPagination($paginationTransfer);

        return $fileUploadCollectionTransfer;
    }

    private function buildBaseFileUploadQuery(FileUploadCriteriaTransfer $fileUploadCriteriaTransfer): PyzFileUploadQuery
    {
        $query = $this->getFactory()->createFileUploadQuery();
        $query = $this->applyFilters($query, $fileUploadCriteriaTransfer);

        $query
            ->leftJoinSpyUser()
            ->addAsColumn(UserTransfer::USERNAME, SpyUserTableMap::COL_USERNAME);

        $query->orderByIdFileUpload(Criteria::DESC);

        return $query;
    }

    private function applyFilters(
        PyzFileUploadQuery $query,
        FileUploadCriteriaTransfer $fileUploadCriteriaTransfer,
    ): PyzFileUploadQuery {
        $query->filterByFkMerchant($fileUploadCriteriaTransfer->getIdMerchantOrFail());

        if ($fileUploadCriteriaTransfer->getSearchTerm()) {
            $query->filterByCdnUrl_Like(sprintf('%%%s%%', $fileUploadCriteriaTransfer->getSearchTerm()));
        }

        return $query;
    }
}
