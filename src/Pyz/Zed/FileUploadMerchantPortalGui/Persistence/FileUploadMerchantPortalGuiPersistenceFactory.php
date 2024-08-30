<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUploadMerchantPortalGui\Persistence;

use Orm\Zed\FileUpload\Persistence\PyzFileUploadQuery;
use Pyz\Zed\FileUploadMerchantPortalGui\Persistence\Propel\Mapper\FileUploadTableDataMapper;
use Pyz\Zed\FileUploadMerchantPortalGui\Persistence\Propel\Mapper\FileUploadTableDataMapperInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\FileUploadMerchantPortalGui\Persistence\FileUploadMerchantPortalGuiRepositoryInterface getRepository()
 */
class FileUploadMerchantPortalGuiPersistenceFactory extends AbstractPersistenceFactory
{
    public function createFileUploadQuery(): PyzFileUploadQuery
    {
        return PyzFileUploadQuery::create();
    }

    public function createFileUploadTableDataMapper(): FileUploadTableDataMapperInterface
    {
        return new FileUploadTableDataMapper();
    }
}
