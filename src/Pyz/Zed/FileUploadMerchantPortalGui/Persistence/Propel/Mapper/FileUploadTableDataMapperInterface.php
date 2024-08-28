<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\FileUploadCollectionTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Propel\Runtime\Util\PropelModelPager;

interface FileUploadTableDataMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\FileUploadCollectionTransfer
     */
    public function mapDataToFileUploadCollectionTransfer(array $data): FileUploadCollectionTransfer;

    public function mapPropelModelPagerToPaginationTransfer(PropelModelPager $propelModelPager): PaginationTransfer;
}
