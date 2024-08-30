<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\FileUpload\Persistence;

use Orm\Zed\FileUpload\Persistence\PyzFileUploadQuery;
use Pyz\Zed\FileUpload\Persistence\Propel\Mapper\FileUploadMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\FileUpload\FileUploadConfig getConfig()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\FileUpload\Persistence\FileUploadRepositoryInterface getRepository()
 */
class FileUploadPersistenceFactory extends AbstractPersistenceFactory
{
    public function createFileUploadMapper(): FileUploadMapper
    {
        return new FileUploadMapper();
    }

    public function createFileUploadQuery(): PyzFileUploadQuery
    {
        return PyzFileUploadQuery::create();
    }
}
